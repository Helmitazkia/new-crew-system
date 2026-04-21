<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Statement of Employment</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 14px; margin: 0; padding: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }
        .logo-bureau { width: 70px; margin-right: 5px; }
        p { margin: 5px 0; text-align: justify; line-height: 1.3; }
        table { border-collapse: collapse; }
    </style>
</head>
<body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
        <tr>
            <td width="20%" valign="top">
                <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" style="width:100px;">
            </td>
            <td width="50%" class="text-center" valign="middle">
                <div style="font-size:22px; font-weight:bold; letter-spacing:2px;">
                    STATEMENT/<span class="italic">PERNYATAAN</span>
                </div>
            </td>
            <td width="30%" class="text-right" valign="top" style="font-size:11px;">
                <div class="font-bold">SRPS LICENSE NO:</div>
                <div>SIUKAK 236.121 - R Tahun 2025</div>
                <div style="margin-top:6px;">
                    <img src="<?php echo base_url('assets/img/Bureau_Veritas_Logo.jpg'); ?>" class="logo-bureau">
                    <img src="<?php echo base_url('assets/img/Iso.jpg'); ?>" style="width:70px;">
                </div>
            </td>
        </tr>
    </table>

    <div style="margin-left: 15px; margin-right: 15px; margin-top: 60px;">
        <p>
            I <span class="font-bold"><?php echo isset($crew->name_person) ? strtoupper($crew->name_person) : ''; ?></span> 
            hereby declare that I have never give Money or / and other forms of gifts to any of our Andhika Eka 
            Karya Sejahtera office staff in return for favors.
        </p>
        <p class="italic" style="margin-top: 15px;">
            Saya <span class="font-bold"><?php echo isset($crew->name_person) ? strtoupper($crew->name_person) : ''; ?></span> 
            dengan ini menyatakan dengan sesungguhnya bahwa saya tidak pernah memberi uang dan / atau Semacamnya kepada 
            siapapun staf Personalia Laut Andhika Eka Karya Sejahtera untuk diterima dan ditempatkan di atas 
            kapal.
        </p>

        <!-- Blok Info di Tengah -->
        <div style="margin-top: 50px; font-size: 13px;">
            <table border="0" cellpadding="4" cellspacing="0" width="55%" align="center">
                <tr>
                    <td width="30%">Date<br><span class="italic">tanggal</span></td>
                    <td width="3%">:</td>
                    <td><span class="font-bold"><?php echo isset($crew->date_request) ? $crew->date_request : ''; ?></span></td>
                </tr>
                <tr>
                    <td style="padding-top:10px;">Vessel<br><span class="italic">Kapal</span></td>
                    <td style="padding-top:10px;">:</td>
                    <td style="padding-top:10px;"><span class="font-bold"><?php echo isset($crew->vessel_name) ? $crew->vessel_name : ''; ?></span></td>
                </tr>
                <tr>
                    <td style="padding-top:10px;">Rank<br><span class="italic">Jabatan</span></td>
                    <td style="padding-top:10px;">:</td>
                    <td style="padding-top:10px;"><span class="font-bold"><?php echo isset($crew->rank) ? $crew->rank : ''; ?></span></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tanda Tangan diposisikan mutlak di bagian bawah kertas -->
    <div style="position: absolute; bottom: 90px; left: 35px; right: 35px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="50%" align="left" valign="top">
                    Thank you.<br>
                    <span class="italic">Terima kasih</span>
                </td>
                <td width="50%" align="right" valign="top">
                    Acknowledge:<br>
                    <span class="italic">Mengetahui</span>
                </td>
            </tr>
            <tr>
                <td align="left" valign="bottom" style="padding-top: 80px;">
                    <div class="font-bold" style="margin-bottom: 5px;"><?php echo isset($crew->name_person) ? strtoupper($crew->name_person) : ''; ?></div>
                    <div style="border-top: 1px solid #000; width: 160px; padding-top: 5px;">
                        Seafarer
                    </div>
                </td>
                <td align="right" valign="bottom" style="padding-top: 80px;">
                    <div style="font-size: 13px; font-weight: bold; text-decoration: underline; margin-bottom: 3px;">
                        EVA MARLIANA
                    </div>
                    <div style="font-size: 12px;">Crew Manager</div>
                </td>
            </tr>
        </table>
    </div>
    <div style="position: fixed; bottom: 20px; margin-left: 80px; color: gray; font-size: 12px; font-style: italic;">
        <span>CD-31 a./20/03/16</span>
    </div>

</body>
</html>