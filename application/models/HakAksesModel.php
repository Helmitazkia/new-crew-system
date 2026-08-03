<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class HakAksesModel extends CI_Model {

    // =========================================================
    // ROLE
    // =========================================================

    public function getAllRoles() {
        return $this->db->query("
            SELECT roleId, roleCode, roleName, roleDesc, isActive,
                   createdAt
            FROM m_user_role
            ORDER BY roleName ASC
        ")->result();
    }

    public function getRoleById($roleId) {
        return $this->db->query("
            SELECT * FROM m_user_role WHERE roleId = ?
        ", array($roleId))->row();
    }

    public function saveRole($data) {
        if (!empty($data['roleId'])) {
            $this->db->query("
                UPDATE m_user_role
                SET roleCode = ?, roleName = ?, roleDesc = ?, updatedAt = NOW()
                WHERE roleId = ?
            ", array(
                $data['roleCode'],
                $data['roleName'],
                $data['roleDesc'],
                $data['roleId']
            ));
            return $this->db->affected_rows();
        } else {
            $this->db->query("
                INSERT INTO m_user_role (roleCode, roleName, roleDesc, isActive, createdAt)
                VALUES (?, ?, ?, 1, NOW())
            ", array(
                $data['roleCode'],
                $data['roleName'],
                $data['roleDesc']
            ));
            return $this->db->insert_id();
        }
    }

    public function toggleRoleStatus($roleId, $isActive) {
        $this->db->query("
            UPDATE m_user_role SET isActive = ?, updatedAt = NOW() WHERE roleId = ?
        ", array($isActive, $roleId));
        return $this->db->affected_rows();
    }

    public function deleteRole($roleId) {
        $this->db->query("DELETE FROM m_user_role WHERE roleId = ?", array($roleId));
        return $this->db->affected_rows();
    }

    public function roleCodeExists($roleCode, $excludeId = null) {
        $sql    = "SELECT COUNT(*) as cnt FROM m_user_role WHERE roleCode = ?";
        $params = array($roleCode);
        if ($excludeId) {
            $sql     .= " AND roleId != ?";
            $params[] = $excludeId;
        }
        $row = $this->db->query($sql, $params)->row();
        return $row->cnt > 0;
    }

    // =========================================================
    // MENU & PERMISSION
    // =========================================================

    /** Semua menu utama dari m_menu */
    public function getAllMenus() {
        return $this->db->query("
            SELECT * FROM m_menu ORDER BY menuOrder ASC, menuName ASC
        ")->result();
    }

    /** Semua sub-menu dari m_sub_menu */
    public function getAllSubMenus() {
        return $this->db->query("
            SELECT sm.*, m.menuName as parentMenuName
            FROM m_sub_menu sm
            JOIN m_menu m ON m.menuId = sm.menuId
            ORDER BY m.menuOrder ASC, sm.subMenuOrder ASC
        ")->result();
    }

    /**
     * Ambil permission matrix untuk satu role:
     * return array gabungan menu + sub-menu lengkap dengan status canAccess
     */
    public function getPermissionsByRole($roleId) {
        // Menu utama
        $menus = $this->db->query("
            SELECT
                m.menuId,
                m.menuCode,
                m.menuName,
                m.menuIcon,
                m.menuUrl,
                m.hasSubMenu,
                COALESCE(rma.canAccess, 0) AS canAccess,
                rma.accessId
            FROM m_menu m
            LEFT JOIN m_role_menu_access rma
                ON rma.menuId = m.menuId
                AND rma.subMenuId IS NULL
                AND rma.roleId = ?
            WHERE m.isActive = 1
            ORDER BY m.menuOrder ASC
        ", array($roleId))->result();

        // Sub-menu
        $subMenus = $this->db->query("
            SELECT
                sm.subMenuId,
                sm.menuId,
                sm.subMenuCode,
                sm.subMenuName,
                sm.subMenuUrl,
                COALESCE(rma.canAccess, 0) AS canAccess,
                rma.accessId
            FROM m_sub_menu sm
            LEFT JOIN m_role_menu_access rma
                ON rma.subMenuId = sm.subMenuId
                AND rma.menuId IS NULL
                AND rma.roleId = ?
            WHERE sm.isActive = 1
            ORDER BY sm.subMenuOrder ASC
        ", array($roleId))->result();

        return array(
            'menus'    => $menus,
            'subMenus' => $subMenus
        );
    }

    /**
     * Toggle satu permission (upsert)
     * Jika record belum ada -> INSERT, jika sudah ada -> UPDATE
     */
    public function upsertPermission($roleId, $menuId, $subMenuId, $canAccess) {
        // Cek apakah sudah ada record
        if ($menuId) {
            $existing = $this->db->query("
                SELECT accessId FROM m_role_menu_access
                WHERE roleId = ? AND menuId = ? AND subMenuId IS NULL
            ", array($roleId, $menuId))->row();
        } else {
            $existing = $this->db->query("
                SELECT accessId FROM m_role_menu_access
                WHERE roleId = ? AND subMenuId = ? AND menuId IS NULL
            ", array($roleId, $subMenuId))->row();
        }

        if ($existing) {
            $this->db->query("
                UPDATE m_role_menu_access
                SET canAccess = ?, updatedAt = NOW()
                WHERE accessId = ?
            ", array($canAccess, $existing->accessId));
        } else {
            if ($menuId) {
                $this->db->query("
                    INSERT INTO m_role_menu_access (roleId, menuId, subMenuId, canAccess, createdAt)
                    VALUES (?, ?, NULL, ?, NOW())
                ", array($roleId, $menuId, $canAccess));
            } else {
                $this->db->query("
                    INSERT INTO m_role_menu_access (roleId, menuId, subMenuId, canAccess, createdAt)
                    VALUES (?, NULL, ?, ?, NOW())
                ", array($roleId, $subMenuId, $canAccess));
            }
        }

        return $this->db->affected_rows() > 0 || $this->db->insert_id() > 0;
    }

    /**
     * Untuk header.php: ambil menu yang boleh diakses role tertentu
     */
    public function getAccessibleMenus($roleCode) {
        return $this->db->query("
            SELECT m.menuId, m.menuCode, m.menuName, m.menuUrl, m.hasSubMenu, m.menuIcon
            FROM m_menu m
            JOIN m_role_menu_access rma ON rma.menuId = m.menuId AND rma.subMenuId IS NULL
            JOIN m_user_role r ON r.roleId = rma.roleId
            WHERE r.roleCode = ?
              AND rma.canAccess = 1
              AND m.isActive = 1
            ORDER BY m.menuOrder ASC
        ", array($roleCode))->result();
    }

    /**
     * Untuk header.php: ambil sub-menu yang boleh diakses role + menu induk tertentu
     */
    public function getAccessibleSubMenus($roleCode, $menuId) {
        return $this->db->query("
            SELECT sm.subMenuId, sm.subMenuCode, sm.subMenuName, sm.subMenuUrl
            FROM m_sub_menu sm
            JOIN m_role_menu_access rma ON rma.subMenuId = sm.subMenuId AND rma.menuId IS NULL
            JOIN m_user_role r ON r.roleId = rma.roleId
            WHERE r.roleCode = ?
              AND sm.menuId = ?
              AND rma.canAccess = 1
              AND sm.isActive = 1
            ORDER BY sm.subMenuOrder ASC
        ", array($roleCode, $menuId))->result();
    }

    /**
     * Helper: cek apakah role dapat akses menu utama berdasarkan menuCode.
     * Fallback ke TRUE jika tabel belum ada (sebelum migrasi dijalankan).
     */
    public function canAccessMenuByCode($roleCode, $menuCode) {
        if (empty($roleCode)) return true;

        try {
            $row = $this->db->query("
                SELECT rma.canAccess
                FROM m_role_menu_access rma
                JOIN m_user_role r  ON r.roleId  = rma.roleId
                JOIN m_menu m       ON m.menuId  = rma.menuId
                WHERE r.roleCode   = ?
                  AND m.menuCode   = ?
                  AND rma.subMenuId IS NULL
                LIMIT 1
            ", array($roleCode, $menuCode))->row();

            // Jika tidak ada record → tampilkan (belum di-setup = default boleh)
            if (!$row) return true;
            return (int)$row->canAccess === 1;
        } catch (Exception $e) {
            // Tabel belum ada → tampilkan semua (fallback)
            return true;
        }
    }

    /**
     * Helper: cek apakah role dapat akses sub-menu berdasarkan subMenuCode.
     * Fallback ke TRUE jika tabel belum ada.
     */
    public function canAccessSubMenuByCode($roleCode, $subMenuCode) {
        if (empty($roleCode)) return true;

        try {
            $row = $this->db->query("
                SELECT rma.canAccess
                FROM m_role_menu_access rma
                JOIN m_user_role r    ON r.roleId    = rma.roleId
                JOIN m_sub_menu sm    ON sm.subMenuId = rma.subMenuId
                WHERE r.roleCode    = ?
                  AND sm.subMenuCode = ?
                  AND rma.menuId IS NULL
                LIMIT 1
            ", array($roleCode, $subMenuCode))->row();

            // Jika tidak ada record → tampilkan (belum di-setup = default boleh)
            if (!$row) return true;
            return (int)$row->canAccess === 1;
        } catch (Exception $e) {
            // Tabel belum ada → tampilkan semua (fallback)
            return true;
        }
    }
}
