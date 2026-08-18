<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instruction Letter</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4; color: #000; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        .table-bordered td, .table-bordered th { border: 1px solid #000; padding: 6px; text-align: center; }
        .header-bg { background-color: #f2f2f2; }
    </style>
</head>
<body>

<table style="width:100%; border-collapse:collapse;">
    <tr>
        <td style="width:90px; vertical-align:top;">
            <img src="<?php echo FCPATH.'assets/img/Logo_Andhika_2017.jpg'; ?>" style="width:80px;">
        </td>
        <td style="text-align:center; vertical-align:middle;">
            <div style="font-size:18px; letter-spacing:10px; font-weight:bold;">INSTRUKSI</div>
            <div style="font-size:15px; font-weight:bold; margin-top:3px;">INSTRUCTION LETTER</div>
        </td>
        <td style="width:170px; text-align:right; vertical-align:top;">
            <div style="font-size:11px; font-weight:bold;">SRPS LICENSE NO:</div>
            <div style="font-size:10px;">SIUKAK 236.121 - R Tahun 2025</div>
            <div style="margin-top:5px;">
                <img src="<?php echo FCPATH.'assets/img/Bureau_Veritas_Logo.jpg'; ?>" style="width:60px; margin-right:3px;">
                <img src="<?php echo FCPATH.'assets/img/Iso.jpg'; ?>" style="width:60px;">
            </div>
        </td>
    </tr>
</table>

<table style="width:100%; margin-top:25px; font-size:13px;">
    <tr>
        <td style="width:120px;">Berdasarkan</td>
        <td>: Kepentingan Dinas Perusahaan</td>
    </tr>
    <tr>
        <td>Base on</td>
        <td>: Shipping Company Official Regulation</td>
    </tr>
    <tr>
        <td></td>
        <td>: <?php echo htmlspecialchars($meta->company); ?></td>
    </tr>
</table>

<div style="margin-top:30px; text-align:center; font-weight:bold;">
    DIINSTRUKSIKAN<br>
    <span style="font-weight:normal;">INSTRUCTED</span>
</div>

<table style="width:100%; margin-top:20px; font-size:13px;">
    <tr>
        <td style="width:110px;">Kepada (To)</td>
        <td>: Master <?php echo htmlspecialchars($meta->vessel); ?></td>
    </tr>
    <tr>
        <td>Untuk (For)</td>
        <td>: _______________________________</td>
    </tr>
</table>

<!-- TABLE 1 RELEASE -->
<div style="margin-top:18px; font-size:13px;">
    1. Membebaskan dari tugas dan tanggung jawab serta jabatan:
    <br><i>Release from the duty/responsibility...</i>
</div>

<table class="table-bordered" style="margin-top:10px;">
    <tr class="header-bg">
        <td style="width:5%;">No</td>
        <td style="width:25%;">Nama / Name</td>
        <td style="width:25%;">Jabatan / Rank</td>
        <td style="width:25%;">Alasan / Reason</td>
        <td style="width:20%;">Tax Status</td>
    </tr>
    <?php 
    $noRelease = 1;
    foreach ($reports as $r): 
        if (!empty($r->release_name)):
    ?>
    <tr>
        <td><?php echo $noRelease++; ?></td>
        <td><?php echo htmlspecialchars($r->release_name); ?></td>
        <td><?php echo htmlspecialchars($r->release_rank); ?></td>
        <td><?php echo htmlspecialchars($r->release_reason); ?></td>
        <td><?php echo htmlspecialchars($r->release_others); ?></td>
    </tr>
    <?php 
        endif;
    endforeach; 
    
    if ($noRelease == 1):
    ?>
    <tr>
        <td colspan="5">No Crew Released</td>
    </tr>
    <?php endif; ?>
</table>

<div style="margin-top:20px; font-size:13px;">
    2. Sebagai penggantinya ditetapkan sebagai berikut:
    <br><i>As the successor:</i>
</div>

<table class="table-bordered" style="margin-top:10px;">
    <tr class="header-bg">
        <td rowspan="2" style="width:5%; vertical-align:middle;">No</td>
        <td rowspan="2" style="width:25%; vertical-align:middle;">Nama</td>
        <td rowspan="2" style="width:20%; vertical-align:middle;">Jabatan</td>
        <td colspan="3" style="width:50%;">Wages</td>
    </tr>
    <tr class="header-bg">
        <td style="width:16.6%;">B/S</td>
        <td style="width:16.6%;">OT</td>
        <td style="width:16.8%;">Leave Pay</td>
    </tr>
    <?php 
    $noSuccessor = 1;
    $grandTotal = 0;
    foreach ($reports as $r): 
        if (!empty($r->successor_name)):
            $bs = (float)$r->successor_bs;
            $ot = (float)$r->successor_ot;
            $lp = (float)$r->successor_leavepay;
            $grandTotal += ($bs + $ot + $lp);
    ?>
    <tr>
        <td><?php echo $noSuccessor++; ?></td>
        <td><?php echo htmlspecialchars($r->successor_name); ?></td>
        <td><?php echo htmlspecialchars($r->successor_rank); ?></td>
        <td class="text-right"><?php echo number_format($bs, 0, ',', '.'); ?></td>
        <td class="text-right"><?php echo number_format($ot, 0, ',', '.'); ?></td>
        <td class="text-right"><?php echo number_format($lp, 0, ',', '.'); ?></td>
    </tr>
    <?php 
        endif;
    endforeach; 

    if ($noSuccessor == 1):
    ?>
    <tr>
        <td colspan="6">No Successor</td>
    </tr>
    <?php endif; ?>
</table>

<div style="margin-top:5px; text-align:right; font-size:13px; font-weight:bold;">
    Grand Total: Rp. <?php echo number_format($grandTotal, 0, ',', '.'); ?>
</div>

<div style="margin-top:14px; font-size:13px; line-height:1.5;">
    3. Selesai pelaksanaan sign off, agar off signer menghadapi Direksi <?php echo htmlspecialchars($meta->company); ?> Cq. Manager Personalia Laut untuk menerima instruksi selanjutnya.<br>

    <i>After completing the contract, off signer must report to <?php echo htmlspecialchars($meta->company); ?> Director Cq. Marine Personal Division Manager to receive next instruction.
    </i><br><br>

    4. Pelaksanaan Sign On/Off di pelabuhan: <?php echo htmlspecialchars($meta->port); ?><br>
    <i>The Signing On/Off at: <?php echo htmlspecialchars($meta->port); ?></i><br><br>

    5. Apabila terdapat kekeliruan dikemudian hari, akan diadakan pembetulan seperlunya.<br>
    <i>If found any mistake in the future, it will be corrected.</i><br><br>

    6. Agar dilaksanakan dengan penuh tanggung jawab.<br>
    <i>Please follow with full responsibility.</i>
</div>

<div style="margin-top:12px; width:100%; font-size:13px;">
    <table style="border:none;">
        <tr>
            <td style="border:none; text-align:left; vertical-align:top;">
                Instruksi: Selesai<br>
                <i>Instruction: Done</i>
            </td>
            <td style="border:none; text-align:right; vertical-align:top;">
                Jakarta, <?php echo date('d M Y', strtotime($meta->date_created)); ?><br>
                <?php echo htmlspecialchars($meta->company); ?>
            </td>
        </tr>
    </table>
</div>

<div style="margin-top:65px; text-align:right; font-size:14px; font-weight:bold;">
    Eva Marliana<br>
    <span style="font-weight:normal;">Crewing Manager</span>
</div>

</body>
</html>
