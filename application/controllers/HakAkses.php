<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class HakAkses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('HakAksesModel');

        // Cek login
        if (!$this->session->userdata('isLogin')) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('HTTP/1.1 401 Unauthorized');
                exit;
            }
            redirect(base_url('auth/login'));
        }
    }

    // =========================================================
    // INDEX — Halaman utama Role Access (masuk via Master Data)
    // =========================================================
    public function index() {
        $data['title']       = 'Role Access Management';
        $data['active_menu'] = 'role_access';
        $this->load->view('layout/header', $data);
        $this->load->view('MasterData/RoleAccess/RoleAccessView');
        $this->load->view('layout/footer');
    }

    // =========================================================
    // AJAX: GET master list role code (untuk dropdown selectpicker)
    // =========================================================
    public function getRoleCodes() {
        header('Content-Type: application/json');

        // Master daftar role code yang tersedia di sistem
        $masterCodes = array(
            array('code' => 'superadmin',    'label' => 'superadmin — Super Admin'),
            array('code' => 'admincv',       'label' => 'admincv — Admin CV'),
            array('code' => 'adminlogistic', 'label' => 'adminlogistic — Admin Logistic'),
            array('code' => 'userlogistic',  'label' => 'userlogistic — User Logistic'),
            array('code' => 'hrd',           'label' => 'hrd — HRD'),
            array('code' => 'crewing',       'label' => 'crewing — Crewing'),
            array('code' => 'finance',       'label' => 'finance — Finance'),
            array('code' => 'operation',     'label' => 'operation — Operation'),
            array('code' => 'viewer',        'label' => 'viewer — Viewer (Read Only)'),
        );

        // Ambil role code yang sudah dipakai agar bisa di-disable
        $existing = $this->HakAksesModel->getAllRoles();
        $usedCodes = array();
        foreach ($existing as $r) {
            $usedCodes[] = $r->roleCode;
        }

        $result = array();
        foreach ($masterCodes as $item) {
            $result[] = array(
                'code'   => $item['code'],
                'label'  => $item['label'],
                'used'   => in_array($item['code'], $usedCodes),
            );
        }

        echo json_encode(array('status' => true, 'data' => $result));
    }

    // =========================================================
    // AJAX: GET semua role (untuk DataTable)
    // =========================================================
    public function getRoles() {
        header('Content-Type: application/json');
        $roles = $this->HakAksesModel->getAllRoles();

        $result = array();
        $no = 1;
        foreach ($roles as $r) {
            $result[] = array(
                'no'        => $no++,
                'roleId'    => $r->roleId,
                'roleCode'  => $r->roleCode,
                'roleName'  => $r->roleName,
                'roleDesc'  => !empty($r->roleDesc) ? $r->roleDesc : '-',
                'isActive'  => (int) $r->isActive,
                'createdAt' => !empty($r->createdAt) ? date('d M Y', strtotime($r->createdAt)) : '-',
            );
        }

        echo json_encode(array('status' => true, 'data' => $result));
    }

    // =========================================================
    // AJAX: SAVE Role (insert / update)
    // =========================================================
    public function saveRole() {
        header('Content-Type: application/json');

        $roleId   = $this->input->post('roleId');
        $roleCode = strtolower(trim($this->input->post('roleCode')));
        $roleName = trim($this->input->post('roleName'));
        $roleDesc = trim($this->input->post('roleDesc'));

        if (empty($roleCode) || empty($roleName)) {
            echo json_encode(array('status' => false, 'msg' => 'Role Code dan Role Name wajib diisi.'));
            return;
        }

        // Cek duplikat
        if ($this->HakAksesModel->roleCodeExists($roleCode, $roleId ? $roleId : null)) {
            echo json_encode(array('status' => false, 'msg' => "Role Code '$roleCode' sudah digunakan."));
            return;
        }

        $data = array(
            'roleId'   => $roleId,
            'roleCode' => $roleCode,
            'roleName' => $roleName,
            'roleDesc' => $roleDesc,
        );

        $res = $this->HakAksesModel->saveRole($data);
        if ($res) {
            echo json_encode(array('status' => true, 'msg' => 'Data role berhasil disimpan.'));
        } else {
            echo json_encode(array('status' => false, 'msg' => 'Gagal menyimpan data.'));
        }
    }

    // =========================================================
    // AJAX: GET satu role (untuk isi form edit)
    // =========================================================
    public function getRole() {
        header('Content-Type: application/json');
        $roleId = $this->input->get('roleId');
        $role   = $this->HakAksesModel->getRoleById($roleId);
        if ($role) {
            echo json_encode(array('status' => true, 'data' => $role));
        } else {
            echo json_encode(array('status' => false, 'msg' => 'Data tidak ditemukan.'));
        }
    }

    // =========================================================
    // AJAX: TOGGLE status isActive role
    // =========================================================
    public function toggleRole() {
        header('Content-Type: application/json');
        $roleId   = $this->input->post('roleId');
        $isActive = $this->input->post('isActive');

        $res = $this->HakAksesModel->toggleRoleStatus($roleId, $isActive);
        echo json_encode(array(
            'status' => $res > 0,
            'msg'    => $res > 0 ? 'Status berhasil diubah.' : 'Gagal mengubah status.'
        ));
    }

    // =========================================================
    // AJAX: DELETE role
    // =========================================================
    public function deleteRole() {
        header('Content-Type: application/json');
        $roleId = $this->input->post('roleId');
        $res    = $this->HakAksesModel->deleteRole($roleId);
        echo json_encode(array(
            'status' => $res > 0,
            'msg'    => $res > 0 ? 'Role berhasil dihapus.' : 'Gagal menghapus.'
        ));
    }

    // =========================================================
    // AJAX: GET permission matrix untuk satu role (modal)
    // =========================================================
    public function getPermissions() {
        header('Content-Type: application/json');
        $roleId = $this->input->get('roleId');

        if (!$roleId) {
            echo json_encode(array('status' => false, 'msg' => 'roleId diperlukan.'));
            return;
        }

        $role = $this->HakAksesModel->getRoleById($roleId);
        $data = $this->HakAksesModel->getPermissionsByRole($roleId);

        echo json_encode(array(
            'status'   => true,
            'role'     => $role,
            'menus'    => $data['menus'],
            'subMenus' => $data['subMenus'],
        ));
    }

    // =========================================================
    // AJAX: UPSERT satu permission (auto-save per toggle)
    // =========================================================
    public function updatePermission() {
        header('Content-Type: application/json');

        $roleId    = $this->input->post('roleId');
        $menuId    = $this->input->post('menuId')    ? $this->input->post('menuId')    : null;
        $subMenuId = $this->input->post('subMenuId') ? $this->input->post('subMenuId') : null;
        $canAccess = (int) $this->input->post('canAccess');

        if (!$roleId || (!$menuId && !$subMenuId)) {
            echo json_encode(array('status' => false, 'msg' => 'Parameter tidak lengkap.'));
            return;
        }

        $res = $this->HakAksesModel->upsertPermission($roleId, $menuId, $subMenuId, $canAccess);
        echo json_encode(array(
            'status' => $res,
            'msg'    => $res ? 'Permission berhasil disimpan.' : 'Gagal menyimpan permission.',
        ));
    }
}
