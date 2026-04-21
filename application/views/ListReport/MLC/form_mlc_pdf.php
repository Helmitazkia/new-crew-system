<!DOCTYPE html>
<html>
<head>
    <title>FORM PERNYATAAN MLC</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 11px; }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .statement-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 15px; }
        .statement-table th, .statement-table td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        .statement-table th { text-align: center; font-weight: bold; }
        .col-no { width: 30px; text-align: center; }
        .col-yes, .col-no-check { width: 60px; text-align: center; font-family: 'DejaVu Sans', sans-serif; font-size: 14px; }
        .subtext { font-style: italic; font-size: 10px; margin-top: 3px; color: #333; }
        .long-line { width: 100%; border-bottom: 1px solid #000; margin: 3px 0; }
        .remarks-title { font-size: 11px; font-weight: bold; margin-top: 10px; }
        .remarks-italic { font-style: italic; font-size: 10px; margin-bottom: 10px; }
        .sign-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; font-size: 11px; margin-top: 20px; }
        .sign-box { border: 1px solid #000; width: 32%; height: 80px; vertical-align: bottom; text-align: center; padding-bottom: 8px; }
        .sign-box-2 { border: 1px solid #000; width: 45%; height: 80px; vertical-align: bottom; text-align: center; padding-bottom: 8px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width:100px; vertical-align:top;">
                <img src="./assets/img/Logo_Andhika_2017.jpg" style="width:80px;">
            </td>
            <td style="text-align:center; vertical-align:middle;">
                <div style="font-size:14px; font-weight:bold;">MLC DECLARATION FORM</div>
                <div style="font-size:16px; font-weight:bold; margin-top:2px;">FORM PERNYATAAN MLC</div>
            </td>
            <td style="width:140px; text-align:right; vertical-align:top;">
                <div style="font-size:10px; font-weight:bold;">SRPS LICENSE NO:</div>
                <div style="font-size:9px; margin-bottom: 5px;">SIUKAK 236.121 - R Tahun 2025</div>
                <div>
                    <img src="./assets/img/Bureau_Veritas_Logo.jpg" style="width:50px; margin-right:3px;">
                    <img src="./assets/img/Iso.jpg" style="width:50px;">
                </div>
            </td>
        </tr>
    </table>

    <table class="statement-table">
        <tr>
            <th class="col-no">No</th>
            <th>Statement</th>
            <th>Yes<br>Ya</th>
            <th>No<br>Tidak</th>
        </tr>
        <tr>
            <td class="col-no">1</td>
            <td>
                All items contained in my employment contract have been explained to me and I am aware of them.
                <div class="subtext">Semua hal yang terdapat dalam kontrak kerja saya telah dijelaskan kepada saya dan saya memahaminya.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_1'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_1'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">2</td>
            <td>
                A full sample agreement incorporating all terms and conditions to apply (including the CBA) has been provided to me prior to entering the agreement.
                <div class="subtext">Contoh perjanjian yang lengkap yang menggabungkan semua ketentuan dan persyaratan melamar (termasuk Kontrak Kerja Bersama) telah diberikan kepada saya sebelum memulai perjanjian ini.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_2'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_2'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">3</td>
            <td>
                I was given adequate time to review the contract and seek advice on the terms and conditions in the agreement.
                <div class="subtext">Saya diberikan waktu yang mencukupi untuk memeriksa kontrak dan meminta nasihat mengenai ketentuan dan persyaratan dalam perjanjian tersebut.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_3'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_3'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">4</td>
            <td>
                I freely entered into the agreement with a sufficient understanding of my rights and responsibilities.
                <div class="subtext">Saya bebas mengadakan perjanjian dengan pemahaman yang memadai mengenai hak dan tanggungjawab saya.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_4'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_4'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">5</td>
            <td>
                I was given an original set of my Seafarers Employment Agreement, which I must carry with me on board.
                <div class="subtext">Saya diberikan satu berkas Perjanjian Kerja Pelaut yang asli, yang saya harus bawa di atas kapal.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_5'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_5'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">6</td>
            <td>
                No fees or other charges for my recruitment or placement or for providing employment to me have incurred directly or indirectly, in whole or part.
                <div class="subtext">Tidak diadakan biaya maupun beban lainnya untuk perekrutan dan penempatan saya atau untuk memberikan pekerjaan kepada saya secara langsung atau tidak langsung, secara keseluruhan atau sebagian.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_6'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_6'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">7</td>
            <td>
                No joining advances or any other exploitation incurred with regard to the employment.
                <div class="subtext">Tidak ada biaya untuk bergabung ataupun eksploitasi lainnya sehubungan dengan pekerjaan tersebut.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_7'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_7'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">8</td>
            <td>
                The Company's Complaint procedure has been explained to me and I am fully aware of the process to be followed and the record to be used.
                <div class="subtext">Prosedur keluhan perusahaan telah dijelaskan kepada saya dan saya sepenuhnya mengetahui proses yang harus diikuti dan catatan yang akan digunakan.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_8'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_8'] == 0) ? '✓' : ''; ?></td>
        </tr>
        <tr>
            <td class="col-no">9</td>
            <td>
                The terms and conditions of employment and my particular conditions applicable to the job for which I am engaged have been explained to me.
                <div class="subtext">Ketentuan dan persyaratan pekerjaan serta persyaratan tertentu yang berlaku terhadap pekerjaan di mana saya terlibat telah dijelaskan kepada saya.</div>
            </td>
            <td class="col-yes"><?php echo ($all_data['statement_9'] == 1) ? '✓' : ''; ?></td>
            <td class="col-no-check"><?php echo ($all_data['statement_9'] == 0) ? '✓' : ''; ?></td>
        </tr>
    </table>

    <ul style="padding-left: 20px; font-size: 11px; margin-bottom: 20px;">
        <li>
            By ticking the YES box you indicate that the documented statement is correct.<br>
            <div class="long-line"></div>
            Dengan mencentang kotak YA yang anda tandai bahwa pernyataan yang dituliskan adalah benar.
        </li>
        <li style="margin-top: 8px;">
            By ticking the NO box you indicate that the documented statement is NOT correct.<br>
            <div class="long-line"></div>
            Dengan mencentang kotak TIDAK yang anda tandai bahwa pernyataan yang dituliskan adalah TIDAK benar.
        </li>
        <li style="margin-top: 8px;">
            If any statement is answered NO you may enter your remarks below.<br>
            <div class="long-line"></div>
            Jika pernyataan dijawab TIDAK anda dapat mencantumkan keterangan anda di bawah ini.
        </li>
    </ul>

    <div class="remarks-title">Remarks:</div>
    <div class="remarks-italic">Keterangan:</div>

    <table class="sign-table">
        <tr>
            <td class="sign-box">
                <div style="font-weight:bold;">Seafarer's Name</div>
                <div style="margin-top:5px; font-size:12px;"><?php echo !empty($crew->fullname) ? $crew->fullname : '-'; ?></div>
            </td>
            <td class="sign-box">
                <div style="font-weight:bold;">Rank</div>
                <div style="margin-top:5px; font-size:12px;"><?php echo !empty($crew->nmrank) ? $crew->nmrank : '-'; ?></div>
            </td>
            <td class="sign-box">
                <div style="font-weight:bold;">Date</div>
                <div style="margin-top:5px; font-size:12px;"><?php echo !empty($crew->signondt) ? $crew->signondt : '-'; ?></div>
            </td>
        </tr>
    </table>

    <table class="sign-table" style="width: 70%; margin-left: 0;">
        <tr>
            <td class="sign-box-2">
                <div style="font-weight:bold; font-size:10px;">Eva Marliana</div>
                <div style="font-size:10px;">Crew Manager</div>
            </td>
            <td class="sign-box-2">
                <div style="font-weight:bold; font-size:10px;">Vessel to Join</div>
                <div style="margin-top:5px; font-size:10px;"><?php echo !empty($crew->nmvsl) ? $crew->nmvsl : '-'; ?></div>
            </td>
        </tr>
    </table>

  <div style="position: fixed; bottom: 20px; margin-left: 80px; color: gray; font-size: 12px; font-style: italic;">
    <span>CD.31 MLC Declaration Form / Rev.00-15 /May/.2015</span>
  </div>
</body>
</html>