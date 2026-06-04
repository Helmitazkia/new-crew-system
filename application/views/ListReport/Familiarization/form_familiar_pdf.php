<!DOCTYPE html>
<html>

<head>
    <title>Familiarization Form</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .w-100 {
            width: 100%;
        }

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

    <!-- PAGE 1 -->
    <div style="text-align:left;">
        <img src="<?= base_url('assets/img/andhika.jpg') ?>" alt="Logo Andhika"
            style="max-width:40px; height: auto;">
        <img src="<?= base_url('assets/img/Adnyana.bmp') ?>" alt="Logo Andhika"
            style="max-width: 200px; height: auto;">
    </div>


    <div class="header-title" style="margin-top:10px;">
        FAMILIARIZATION CREW BEFORE JOIN ON BOARD
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Instructions :</strong><br>
        1. All new crew familiarization must do the following before being assigned aboard.<br>
        2. Familiarization conducted by the DPA or DPA may be assigned a staff to do familiarization. DPA should be
        assured that the orientation is done before the new crew assigned aboard.<br>
        3. Tick (√) for things that are done and the sign (x) for things that have not worked.<br>
        4. Archive form completed and signed on Personnel File archives are concerned.<br>
    </div>

    <table class="table-noborder" style="margin-bottom: 20px;">
        <tr>
            <td style="width: 10%;">Name</td>
            <td style="width: 40%;">: <?= $crew->fullname ?></td>
            <td style="width: 10%;">Rank</td>
            <td style="width: 40%;">: <?= $crew->rankname ?></td>
        </tr>
        <tr>
            <td>Vessel Name</td>
            <td>: <?= $crew->vesselnm ?></td>
            <td>Date</td>
            <td>: <?= $crew->signon_date ?></td>
        </tr>
    </table>

    <table class="table-border" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="width: 60%;">Material</th>
                <th style="width: 30%;">PIC</th>
                <th style="width: 10%;">√ / x</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Procedures Related Crewing (Payroll, Working Hours, etc)</td>
                <td>Crewing</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">Company Policy :</td>
            </tr>
            <tr>
                <td>- Quality, Health, Safety and Environmental (QHSE) Policy</td>
                <td>QHSE</td>
                <td></td>
            </tr>
            <tr>
                <td>Safety Management System Manual and Document</td>
                <td>DPA / Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td>Duties and Responsibility</td>
                <td>DPA</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Ship Operation</td>
                <td>Operation</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Emergency</td>
                <td>DPA / Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="3">Procedures Related Maintenance of Ship (Plan Maintenance System)</td>
                <td>Technical</td>
                <td></td>
            </tr>
            <tr>
                <td>Purchasing</td>
                <td></td>
            </tr>
            <tr>
                <td>Finance</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Cargo Handling</td>
                <td>Operation</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Safety Drill</td>
                <td>DPA / Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Health</td>
                <td>DPA / Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Environmental Protection</td>
                <td>DPA / Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td>Procedures Related Audit (External / Internal)</td>
                <td>DPA / Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td>Hazard Identification / Risk Assessment / Job Safety Analysis (JSA)</td>
                <td>Marine Safety</td>
                <td></td>
            </tr>
            <tr>
                <td>Wearing PPE and PPE Maintenance</td>
                <td>Marine Safety</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-bottom: 30px;">
        <strong>Note :</strong><br>
        <div style="min-height: 50px;">
            <?php echo (htmlspecialchars($history->note)) ?>
        </div>
    </div>

    <table class="table-noborder text-center" style="margin-top: 40px;">
        <tr>
            <td style="width: 33%;">Acknowledged By,</td>
            <td style="width: 33%;">Checked By,</td>
            <td style="width: 33%;">Crew Sign on</td>
        </tr>
        <tr>
            <td style="height: 80px;"></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>( .................................... )</td>
            <td>( .................................... )</td>
            <td>( <?= $crew->fullname ?> )</td>
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

    <!-- PAGE 2 -->
    <pagebreak />

   <div style="text-align:left;">
        <img src="<?= base_url('assets/img/andhika.jpg') ?>" alt="Logo Andhika"
            style="max-width:40px; height: auto;">
        <img src="<?= base_url('assets/img/Adnyana.bmp') ?>" alt="Logo Andhika"
            style="max-width: 200px; height: auto;">
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
            <td style="width: 50%;"><?= $crew->fullname ?></td>
        </tr>
        <tr>
            <td style="text-align:center;">2</td>
            <td>Rank</td>
            <td><?= $crew->rankname ?></td>
        </tr>
        <tr>
            <td style="text-align:center;">3</td>
            <td>Date of Birth</td>
            <td><?= $crew->date_of_birth ?></td>
        </tr>
        <tr>
            <td style="text-align:center;">4</td>
            <td>License of Senior Officer</td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align:center;">5</td>
            <td>Vessel Schedule Joining</td>
            <td><?= $crew->vesselnm ?></td>
        </tr>
        <tr>
            <td style="text-align:center;">6</td>
            <td>Date Schedule Joining/Place</td>
            <td><?= $crew->signon_date ?></td>
        </tr>
        <tr>
            <td style="text-align:center;">7</td>
            <td>Last Vessel / Sign Off date</td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align:center;">8</td>
            <td>Reason Sign Off</td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align:center;">9</td>
            <td>Years in Rank</td>
            <td></td>
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
                <td>1</td>
                <td style="text-align:left;">DPA</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td style="text-align:left;">Technical</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td style="text-align:left;">Marine Safety</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td style="text-align:left;">Finance</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td style="text-align:left;">Purchasing</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td style="text-align:left;">QHSE</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td style="text-align:left;">Operation</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>8</td>
                <td style="text-align:left;">Crewing</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div style="position: fixed; bottom: 20px; margin-left: 80px; color: gray; font-size: 12px; font-style: italic;">
        <span>Form MSB 6.1/ Rev.00 / 09-06-2016</span>
    </div>

</body>

</html>