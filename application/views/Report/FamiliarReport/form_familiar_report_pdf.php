<!DOCTYPE html>
<html>
<head>
    <title>Familiarization Report</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .w-100 { width: 100%; }
        .header-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .table-border {
            width: 100%;
            border-collapse: collapse;
        }
        .table-border th,
        .table-border td {
            border: 1px solid #000;
            padding: 5px;
        }
        .table-noborder {
            width: 100%;
            border-collapse: collapse;
        }
        .table-noborder td {
            padding: 3px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

<?php
// Helper function: render ✓ or ✗ wrapped in DejaVu Sans font (required by mPDF for Unicode symbols)
function famMarkReport($val) {
    $style = "font-family:'DejaVu Sans',sans-serif; font-size:13px;";
    if ($val === 1 || $val === '1') return '<span style="' . $style . '">&#10003;</span>'; // ✓
    if ($val === 0 || $val === '0') return '<span style="' . $style . '">&#10007;</span>'; // ✗
    return '';
}

$totalCrew = count($crewList);
$crewIndex = 0;

foreach ($crewList as $crew):
    $crewIndex++;
?>

    <!-- PAGE 1: Checklist Familiarization -->
    <?php if ($crewIndex > 1): ?>
        <pagebreak />
    <?php endif; ?>

    <div style="text-align:left;">
        <img src="./assets/img/andhika.jpg" alt="Logo" style="max-width:40px; height: auto;">
        <img src="./assets/img/Adnyana.bmp" alt="Logo" style="max-width: 200px; height: auto;">
    </div>

    <div class="header-title" style="margin-top:10px;">
        FAMILIARIZATION CREW BEFORE JOIN ON BOARD
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Instructions :</strong><br>
        1. All new crew familiarization must do the following before being assigned aboard.<br>
        2. Familiarization conducted by the DPA or DPA may be assigned a staff to do familiarization. DPA should be
        assured that the orientation is done before the new crew assigned aboard.<br>
        3. Tick <?php echo famMarkReport("1"); ?> for things that are done and the sign <?php echo famMarkReport("0"); ?> for
        things that have not worked.<br>
        4. Archive form completed and signed on Personnel File archives are concerned.<br>
    </div>

    <table class="table-noborder" style="margin-bottom: 20px;">
        <tr>
            <td style="width: 10%;">Name</td>
            <td style="width: 40%;">: <?php echo $crew->fullname ?></td>
            <td style="width: 10%;">Rank</td>
            <td style="width: 40%;">: <?php echo $crew->rankname ?></td>
        </tr>
        <tr>
            <td>Vessel Name</td>
            <td>: <?php echo $crew->vesselnm ?></td>
            <td>Date</td>
            <td>: <?php echo $crew->signon_date ?></td>
        </tr>
    </table>

    <table class="table-border" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="width: 60%; text-align:center;">Material</th>
                <th style="width: 30%; text-align:center;">PIC</th>
                <th style="width: 10%; text-align:center;"><?php echo famMarkReport("1"); ?> / <?php echo famMarkReport("0"); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Procedures Related Crewing (Payroll, Working Hours, etc)</td>
                <td style="text-align:center;">Crewing</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_1); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">Company Policy :</td>
            </tr>
            <tr>
                <td>- Quality, Health, Safety and Environmental (QHSE) Policy</td>
                <td style="text-align:center;">QHSE</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_2); ?>
                </td>
            </tr>
            <tr>
                <td>Safety Management System Manual and Document</td>
                <td style="text-align:center;">DPA / Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_3); ?>
                </td>
            </tr>
            <tr>
                <td>Duties and Responsibility</td>
                <td style="text-align:center;">DPA</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_4); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Ship Operation</td>
                <td style="text-align:center;">Operation</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_5); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Emergency</td>
                <td style="text-align:center;">DPA / Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_6); ?>
                </td>
            </tr>
            <tr>
                <td rowspan="3">Procedures Related Maintenance of Ship (Plan Maintenance System)</td>
                <td style="text-align:center;">Technical</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_7); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">Purchasing</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_8); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">Finance</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_9); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Cargo Handling</td>
                <td style="text-align:center;">Operation</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_10); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Safety Drill</td>
                <td style="text-align:center;">DPA / Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_11); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Health</td>
                <td style="text-align:center;">DPA / Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_12); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Environmental Protection</td>
                <td style="text-align:center;">DPA / Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_13); ?>
                </td>
            </tr>
            <tr>
                <td>Procedures Related Audit (External / Internal)</td>
                <td style="text-align:center;">DPA / Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_14); ?>
                </td>
            </tr>
            <tr>
                <td>Hazard Identification / Risk Assessment / Job Safety Analysis (JSA)</td>
                <td style="text-align:center;">Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_15); ?>
                </td>
            </tr>
            <tr>
                <td>Wearing PPE and PPE Maintenance</td>
                <td style="text-align:center;">Marine Safety</td>
                <td style="text-align:center; font-size:14px; font-family:'DejaVu Sans',sans-serif;">
                    <?php echo famMarkReport($master->item_16); ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div style="margin-bottom: 30px;">
        <strong>Note :</strong><br>
        <div style="min-height: 50px;">
            <?php echo htmlspecialchars($master->note) ?>
        </div>
    </div>

    <table class="table-noborder text-center" style="margin-top: 40px;">
        <tr>
            <td style="width: 33%;">Acknowledged By,</td>
            <td style="width: 33%;">Checked By,</td>
            <td style="width: 33%;">Crew Sign on</td>
        </tr>
        <tr>
            <td style="height: 80px;">
                <?php if (!empty($crew->qr_dpa)): ?>
                    <img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dpa ?>" style="height: 70px;">
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($crew->qr_checkedby)): ?>
                    <img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_checkedby ?>" style="height: 70px;">
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($crew->qr_crew)): ?>
                    <img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_crew ?>" style="height: 70px;">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php if (!empty($crew->signature_DPA)): ?>
                    <?php echo $crew->signature_DPA ?>
                <?php else: ?>
                    ( .................................... )
                <?php endif; ?>
            </td>
            <td>
                <?php if (!empty($crew->signature_checkedBy)): ?>
                    <?php echo $crew->signature_checkedBy ?>
                <?php else: ?>
                    ( .................................... )
                <?php endif; ?>
            </td>
            <td>( <?php echo $crew->fullname ?> )</td>
        </tr>
        <tr>
            <td>DPA</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div style="position: fixed; bottom: 20px; margin-left: 80px; color: gray; font-size: 12px; font-style: italic;">
        <span>Form MSB 6.1/ Rev.00 / 09-06-2016</span>
    </div>

    <?php
    // ============================================================
    // PAGE 2: Senior Officer Familiarization (ONLY for Top 4)
    // ============================================================
    if ($crew->is_top4):
    ?>
        <pagebreak />

        <div style="text-align:left;">
            <img src="./assets/img/andhika.jpg" alt="Logo" style="max-width:40px; height: auto;">
            <img src="./assets/img/Adnyana.bmp" alt="Logo" style="max-width: 200px; height: auto;">
        </div>

        <div class="header-title" style="margin-top:20px;">
            FAMILIARIZATION OF SIGNING ON SENIOR OFFICER AT <br>
            PT. ADNYANA PREMISES
        </div>

        <p style="text-align: justify; margin-bottom: 15px;">
            The following Senior Officer will be present at the PT. Adnyana office at the date and the time mentioned below.
            It is expected that all departments will be able to send their representatives to familiarization the senior
            officer.
        </p>
        <p style="text-align: justify; margin-bottom: 15px;">
            The Departmental representatives will be allocated a time window to carry out their familiarization. It is
            anticipated that the time allowed will be sufficient. If it is not the representative may take the necessary
            extra time and the briefing schedule will be adjusted accordingly. If the representative finishes his/her
            briefing a head schedule, he will advise the next person in line and that person may take over if it is
            convenient. If not, the schedule will be maintained with the officer concerned being allowed a short break.
        </p>
        <p style="text-align: justify; margin-bottom: 15px;">
            Please note that the person presently familiarization the Senior Officer is personally responsible ensuring that
            the next department representative attends to the Senior Officer.
        </p>
        <p style="text-align: justify; margin-bottom: 30px;">
            The last Senior Officer to brief the officer shall inform so that the Senior Officer may be allowed leave.
        </p>

        <table class="table-border" style="margin-bottom: 30px;">
            <tr>
                <td style="width: 5%; text-align:center;">1</td>
                <td style="width: 45%;">Name of Senior Officer</td>
                <td style="width: 50%;"><?php echo $crew->fullname ?></td>
            </tr>
            <tr>
                <td style="text-align:center;">2</td>
                <td>Rank</td>
                <td><?php echo $crew->rankname ?></td>
            </tr>
            <tr>
                <td style="text-align:center;">3</td>
                <td>Date of Birth</td>
                <td><?php echo $crew->date_of_birth ?></td>
            </tr>
            <tr>
                <td style="text-align:center;">4</td>
                <td>License of Senior Officer</td>
                <td><?php echo isset($crew->license) ? $crew->license : '' ?></td>
            </tr>
            <tr>
                <td style="text-align:center;">5</td>
                <td>Vessel Schedule Joining</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align:center;">6</td>
                <td>Date Schedule Joining/Place</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align:center;">7</td>
                <td>Last Vessel / Sign Off date</td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align:center;">8</td>
                <td>Reason Sign Off</td>
                <td>EOC</td>
            </tr>
            <tr>
                <td style="text-align:center;">9</td>
                <td>Years in Rank</td>
                <td><?php echo isset($crew->years_in_rank) ? $crew->years_in_rank : '' ?></td>
            </tr>
        </table>

        <table class="table-border text-center">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Description</th>
                    <th style="width: 25%;">Representative</th>
                    <th style="width: 15%;">Time Start</th>
                    <th style="width: 15%;">Time End</th>
                    <th style="width: 15%;">Initials</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td><td style="text-align:left;">DPA</td>
                    <td><?php echo isset($reps['DPA']) ? $reps['DPA'] : (isset($reps['DPA / Marine Safety']) ? $reps['DPA / Marine Safety'] : '') ?></td>
                    <td><?php echo isset($times['DPA']['start']) ? $times['DPA']['start'] : (isset($times['DPA / Marine Safety']['start']) ? $times['DPA / Marine Safety']['start'] : '') ?></td>
                    <td><?php echo isset($times['DPA']['end']) ? $times['DPA']['end'] : (isset($times['DPA / Marine Safety']['end']) ? $times['DPA / Marine Safety']['end'] : '') ?></td>
                    <td><?php if(!empty($crew->qr_dpa)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dpa ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>2</td><td style="text-align:left;">Technical</td>
                    <td><?php echo isset($reps['Technical']) ? $reps['Technical'] : '' ?></td>
                    <td><?php echo isset($times['Technical']['start']) ? $times['Technical']['start'] : '' ?></td>
                    <td><?php echo isset($times['Technical']['end']) ? $times['Technical']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_technical)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_technical ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>3</td><td style="text-align:left;">Marine Safety</td>
                    <td><?php echo isset($reps['Marine Safety']) ? $reps['Marine Safety'] : '' ?></td>
                    <td><?php echo isset($times['Marine Safety']['start']) ? $times['Marine Safety']['start'] : '' ?></td>
                    <td><?php echo isset($times['Marine Safety']['end']) ? $times['Marine Safety']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_marinesafety)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_marinesafety ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>4</td><td style="text-align:left;">Finance</td>
                    <td><?php echo isset($reps['Finance']) ? $reps['Finance'] : '' ?></td>
                    <td><?php echo isset($times['Finance']['start']) ? $times['Finance']['start'] : '' ?></td>
                    <td><?php echo isset($times['Finance']['end']) ? $times['Finance']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_finance)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_finance ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>5</td><td style="text-align:left;">Purchasing</td>
                    <td><?php echo isset($reps['Purchasing']) ? $reps['Purchasing'] : '' ?></td>
                    <td><?php echo isset($times['Purchasing']['start']) ? $times['Purchasing']['start'] : '' ?></td>
                    <td><?php echo isset($times['Purchasing']['end']) ? $times['Purchasing']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_purchasing)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_purchasing ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>6</td><td style="text-align:left;">QHSE</td>
                    <td><?php echo isset($reps['QHSE']) ? $reps['QHSE'] : '' ?></td>
                    <td><?php echo isset($times['QHSE']['start']) ? $times['QHSE']['start'] : '' ?></td>
                    <td><?php echo isset($times['QHSE']['end']) ? $times['QHSE']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_qhse)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_qhse ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>7</td><td style="text-align:left;">Operation</td>
                    <td><?php echo isset($reps['Operation']) ? $reps['Operation'] : '' ?></td>
                    <td><?php echo isset($times['Operation']['start']) ? $times['Operation']['start'] : '' ?></td>
                    <td><?php echo isset($times['Operation']['end']) ? $times['Operation']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_operation)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_operation ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
                <tr>
                    <td>8</td><td style="text-align:left;">Crewing</td>
                    <td><?php echo isset($reps['Crewing']) ? $reps['Crewing'] : '' ?></td>
                    <td><?php echo isset($times['Crewing']['start']) ? $times['Crewing']['start'] : '' ?></td>
                    <td><?php echo isset($times['Crewing']['end']) ? $times['Crewing']['end'] : '' ?></td>
                    <td><?php if(!empty($crew->qr_dept_crewing)): ?><img src="./assets/imgQRCodeCrewCV/<?php echo $crew->qr_dept_crewing ?>" style="height: 40px;"><?php endif; ?></td>
                </tr>
            </tbody>
        </table>

        <div style="position: fixed; bottom: 20px; margin-left: 80px; color: gray; font-size: 12px; font-style: italic;">
            <span>Form MSB 6.1/ Rev.00 / 09-06-2016</span>
        </div>

    <?php endif; // End Top 4 check ?>

<?php endforeach; // End crew loop ?>

</body>
</html>
