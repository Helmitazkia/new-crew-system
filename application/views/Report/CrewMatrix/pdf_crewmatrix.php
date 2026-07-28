<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Crew_Matrix_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

function fmtDate($val) {
    if (empty($val) || $val === '0000-00-00') return '';
    $d = strtotime($val);
    if (!$d) return $val;
    return date('d M Y', $d);
}
?>
<table border="1" style="border-collapse: collapse; font-size: 11px; font-family: Arial, sans-serif;">
    <thead>
        <!-- Row 1: Fixed headers (rowspan=2) + Cert group headers (colspan=2) -->
        <tr style="background-color: #000099; color: #ffffff; font-weight: bold; text-align: center;">
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 30px;">No</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 180px;">Full Name Crew</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 80px;">Status</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 120px;">Rank</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 100px;">Nationality</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 90px;">DOB</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 140px;">Vessel</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 90px;">Sign On</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 90px;">Sign Off</th>
            <th rowspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 90px;">Est Sign Off</th>
            <?php foreach ($dynamic_certs as $cert): ?>
                <th colspan="2" style="border: 1px solid #000; vertical-align: middle; min-width: 180px;"><?php echo htmlspecialchars($cert['certname']); ?></th>
            <?php endforeach; ?>
        </tr>
        <!-- Row 2: Sub-headers for cert Iss/Exp -->
        <tr style="background-color: #1a3a8c; color: #ffffff; font-weight: bold; text-align: center;">
            <?php foreach ($dynamic_certs as $cert): ?>
                <th style="border: 1px solid #000; vertical-align: middle; min-width: 90px;">Iss Date</th>
                <th style="border: 1px solid #000; vertical-align: middle; min-width: 90px;">Exp Date</th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($rows as $row): ?>
        <tr>
            <td style="border: 1px solid #ccc; text-align: center;"><?php echo $no++; ?></td>
            <td style="border: 1px solid #ccc;"><?php echo htmlspecialchars($row->fullName); ?></td>
            <td style="border: 1px solid #ccc; text-align: center;"><?php echo htmlspecialchars($row->crew_status); ?></td>
            <td style="border: 1px solid #ccc; text-align: center;"><?php echo htmlspecialchars($row->nmrank); ?></td>
            <td style="border: 1px solid #ccc; text-align: center;"><?php echo htmlspecialchars($row->NmNegara); ?></td>
            <td style="border: 1px solid #ccc; text-align: center; mso-number-format:'\@';"><?php echo fmtDate($row->dob); ?></td>
            <td style="border: 1px solid #ccc; text-align: center;"><?php echo htmlspecialchars($row->signonvsl); ?></td>
            <td style="border: 1px solid #ccc; text-align: center; mso-number-format:'\@';"><?php echo fmtDate($row->signondt); ?></td>
            <td style="border: 1px solid #ccc; text-align: center; mso-number-format:'\@';"><?php echo $row->signoffdt === '0000-00-00' ? '' : fmtDate($row->signoffdt); ?></td>
            <td style="border: 1px solid #ccc; text-align: center; mso-number-format:'\@';"><?php echo fmtDate($row->estsignoffdt); ?></td>
            <?php foreach ($dynamic_certs as $cert):
                $alias_iss = "iss_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert['certname']);
                $alias_exp = "exp_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert['certname']);
            ?>
                <td style="border: 1px solid #ccc; text-align: center; mso-number-format:'\@';"><?php echo fmtDate(isset($row->$alias_iss) ? $row->$alias_iss : ''); ?></td>
                <td style="border: 1px solid #ccc; text-align: center; mso-number-format:'\@';"><?php echo fmtDate(isset($row->$alias_exp) ? $row->$alias_exp : ''); ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
