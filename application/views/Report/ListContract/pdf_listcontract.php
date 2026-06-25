<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=List_Contract_".date('Ymd_His').".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
    <thead>
        <tr style="background:#D2D2D2; font-weight:bold;">
            <th>No</th>
            <th>Company</th>
            <th>Crew Name</th>
            <th>Apply For</th>
            <th>Religion</th>
            <th>Gender</th>
            <th>Date Join</th>
            <th>Total Contract</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($rows as $row): ?>
        <?php
            $signOn  = $row->signondt ? date('d-M-Y', strtotime($row->signondt)) : '';
            $signOff = $row->signoffdt ? date('d-M-Y', strtotime($row->signoffdt)) : 'On Board';
        ?>
        <tr>
            <td style="text-align: center;"><?= $no++; ?></td>
            <td><?= $row->nmcmp; ?></td>
            <td><?= $row->fullname; ?></td>
            <td style="text-align: center;"><?= $row->applyfor; ?></td>
            <td style="text-align: center;"><?= $row->religion; ?></td>
            <td style="text-align: center;"><?= $row->gender; ?></td>
            <td style="mso-number-format:'\@'; text-align: center;">
                <?= $signOn; ?> - <?= $signOff; ?>
            </td>
            <td style="text-align: center;"><?= $row->total_contract; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
