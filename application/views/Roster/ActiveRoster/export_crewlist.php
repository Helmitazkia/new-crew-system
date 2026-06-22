<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Crew List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 5px;
            text-decoration: underline;
        }
        .header-table {
            width: 100%;
            margin-bottom: 5px;
            font-weight: bold;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        table.data-table th {
            background-color: #008080; /* Teal/Blue color */
            color: #ffffff;
            font-weight: bold;
            font-size: 8px;
        }
        table.data-table td {
            font-size: 9px;
        }
        .text-left {
            text-align: left !important;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <?php 
    $chunks = !empty($rows) ? array_chunk($rows, 30) : array(array());
    $no = 1;
    foreach ($chunks as $index => $chunk):
    ?>
    <?php if ($index > 0): ?>
        <div class="page-break"></div>
    <?php endif; ?>

    <h2>CREW LIST</h2>
    
    <table class="header-table">
        <tr>
            <td style="text-align: left; width: 50%;">STATUS : <?php echo isset($statusFilter) ? $statusFilter : 'ON BOARD'; ?></td>
            <td style="text-align: right; width: 50%;"><?php echo isset($printDate) ? $printDate : date('d M Y H:i:s'); ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="3">NO</th>
                <th rowspan="3">RANK</th>
                <th rowspan="3">ID PERSON</th>
                <th rowspan="3">NAME</th>
                <th rowspan="3">DOB</th>
                <th rowspan="3">AGE</th>
                <th colspan="2">VESSEL</th>
                <th colspan="3">DATE</th>
                <th rowspan="3">REMARK</th>
            </tr>
            <tr>
                <th rowspan="2">SIGN ON</th>
                <th rowspan="2">LAST</th>
                <th rowspan="2">SIGN ON</th>
                <th colspan="2">SIGN OFF</th>
            </tr>
            <tr>
                <th>ACTUAL</th>
                <th>SCHEDULE</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($chunk)): ?>
                <?php foreach ($chunk as $row): 
                    // Calculate Age
                    $dob = $row['dob'];
                    $age = '-';
                    $dob_str = '-';
                    if (!empty($dob) && $dob != '0000-00-00') {
                        $bday = new DateTime($dob);
                        $today = new DateTime('today');
                        $age = $bday->diff($today)->y;
                        $dob_str = date('d M Y', strtotime($dob));
                    }

                    // Format Dates
                    $signondt_str = (!empty($row['signondt']) && $row['signondt'] != '0000-00-00') ? date('d M Y', strtotime($row['signondt'])) : '-';
                    $signoffdt_str = (!empty($row['signoffdt']) && $row['signoffdt'] != '0000-00-00') ? date('d M Y', strtotime($row['signoffdt'])) : '-';
                    $estsignoffdt_str = (!empty($row['estsignoffdt']) && $row['estsignoffdt'] != '0000-00-00') ? date('d M Y', strtotime($row['estsignoffdt'])) : '-';
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo !empty($row['nmrank']) ? htmlspecialchars($row['nmrank']) : '-'; ?></td>
                    <td><?php echo !empty($row['idperson']) ? htmlspecialchars($row['idperson']) : '-'; ?></td>
                    <td class="text-left"><?php echo !empty($row['fullName']) ? htmlspecialchars($row['fullName']) : '-'; ?></td>
                    <td><?php echo $dob_str; ?></td>
                    <td><?php echo $age; ?></td>
                    
                    <td><?php echo !empty($row['nmvsl']) ? htmlspecialchars($row['nmvsl']) : '-'; ?></td>
                    <td><?php echo !empty($row['lastvsl']) ? htmlspecialchars($row['lastvsl']) : '-'; ?></td>
                    
                    <td><?php echo $signondt_str; ?></td>
                    <td><?php echo $signoffdt_str; ?></td>
                    <td><?php echo $estsignoffdt_str; ?></td>
                    
                    <td class="text-left"><?php echo !empty($row['estremark']) ? htmlspecialchars($row['estremark']) : '-'; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No data available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endforeach; ?>

</body>
</html>
