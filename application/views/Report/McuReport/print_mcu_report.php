<!DOCTYPE html>
<html lang="id">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <meta charset="UTF-8">
  <title>Medical Check Up (MCU)</title>
  <style>
  body {
    font-family: "Times New Roman", serif;
    font-size: 12px;
    margin: 0;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  td,
  th {
    vertical-align: top;
    padding: 4px;
  }

  .border td,
  .border th {
    border: 1px solid #000;
  }

  .center {
    text-align: center;
  }

  .right {
    text-align: right;
  }

  .mt {
    margin-top: 15px;
  }

  /* Checkbox aman mPDF */
  .box {
    display: inline-block;
    width: 16px;
    height: 16px;
    line-height: 16px;
    /* KUNCI */
    border: 1.2px solid #000;
    text-align: center;
    vertical-align: middle;
    margin-right: 6px;
    /* JANGAN LEBIH BESAR */
  }


  .signature {
    margin-top: 40px;
    width: 40%;
    text-align: center;
  }
  </style>

  <style>
  .header-section {
    background: #009999;
    color: #fff;
    padding: 60px 20px;
    margin-bottom: 15px;
  }
  </style>
</head>

<body>

  <section class="header-section">

  </section>

  <div class="card" style="  margin-top: -80px; ">

    <!-- HEADER -->
    <table width="100%" cellpadding="5" cellspacing="0" style="font-family:'Times New Roman';">
      <tr>
        <!-- KIRI : LOGO -->
        <td width="6%" align="left" valign="middle">
          <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" style="height:50px;">
          <!-- <img src="base_urlassets/img/Logo_Andhika_2017.jpg" style="height:50px;"> -->
        </td>

        <!-- TENGAH : JUDUL -->
        <td width="50%" align="left" valign="middle" style="padding-top:27px;">
          <div style="font-size:17px; font-weight:bold;">
            <?php echo $header_mcu; ?>
          </div>
        </td>

        <!-- KANAN : LISENSI + LOGO -->
        <td width="25%" align="right" valign="middle">
          <div style="font-size:11px; font-weight:bold;">
            SRPS LICENSE NO:
          </div>
          <div style="font-size:10px;">
            SIUPPAK 12.12 Tahun 2014
          </div>
          <div>
            <img src="<?php echo base_url('assets/img/Bureau_Veritas_Logo.jpg'); ?>" style="height:30px;">
            <img src="<?php echo base_url('assets/img/Iso.jpg'); ?>" style="height:30px;">
          </div>
        </td>
      </tr>
    </table>

    <!-- TUJUAN -->
    <table class="mt">
      <tr>
        <td style="width:400px;">
          Kepada Yth:<br>
          <?php echo $clinic_name; ?><br>
          <?php echo $address_clinic; ?><br>
          Telp: <?php echo $telp; ?><br>
          Fax: <?php echo $fax; ?>
        </td>
        <td class="right">
          Jakarta, <?php echo date('d M Y', strtotime($date_mcu)); ?>
        </td>
      </tr>
    </table>

    <p class="center"><strong>TOP URGENT<br>_______________________________</strong></p>

    <p>Dengan hormat,<br>Bersama ini kami mohon agar dapat dilakukan pemeriksaan:</p>

    <!-- MCU LIST -->
    <table style="width:700px;">
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;word-wrap: break-word;"><?php echo ($mcu->mcu1==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          1. Medical Check Up Standart Perla
        </td>
      </tr>
      <tr>
        <td>
          <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
            <tr>
              <td style="padding: 0 6px 0 0; vertical-align: top; border: none; width: 25px;">
                <span class="box" style="font-family: 'DejaVu Sans'; font-size: 16px; margin-right: 0;"><?php echo ($mcu->mcu2==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
              </td>
              <td style="padding: 0; vertical-align: top; border: none;">
                2. Medical Check Up
                <table class="table table-borderless table-sm mt-1" style="font-size:11px;">
                  <tr>
                    <td style="width:25%;">
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_1']) && $subData['sub_answer_2_1']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Kerajaan Malaysia
                    </td>
                    <td style="width:25%;">
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_2']) && $subData['sub_answer_2_2']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Marshall Islands
                    </td>
                    <td style="width:25%;">
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_3']) && $subData['sub_answer_2_3']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Liberia
                    </td>
                    <td style="width:25%;">
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_4']) && $subData['sub_answer_2_4']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Singapore
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_5']) && $subData['sub_answer_2_5']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Cyprus
                    </td>
                    <td>
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_6']) && $subData['sub_answer_2_6']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Shipowner
                    </td>
                    <td>
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_7']) && $subData['sub_answer_2_7']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> OGUK
                    </td>
                    <td>
                      <span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_2_8']) && $subData['sub_answer_2_8']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Netherlands
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu3==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          <strong>3. Medical Check Up Panama + ECG + Renal Function + Lever Function + Glukosa at Random</strong>
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu4==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          4. Pemeriksaan Gigi & Gusi (Dental+Gum)
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu5==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          <strong>5. Drug & Alcoholic Test 6 (six) items</strong>
          <table class="table table-borderless table-sm mt-2">
            <tr>
              <td class="fw-bold ps-4" style="width:55%;padding-left:38px;">
                Pemeriksaan no. 5,6,7,8 dilakukan JIKA<br>
                SUDAH FIT dan biayanya dibebankan<br>
                kepada PT. Andhini Eka Karya Sejahtera
              </td>
              <td style="width:45%;">
                <table style="width:100%;font-size:11px;">
                  <tr>
                    <td style="width:50%;"><span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_5_1']) && $subData['sub_answer_5_1']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Cocain metabolic</td>
                    <td style="width:50%;"><span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_5_4']) && $subData['sub_answer_5_4']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Pencyclidine</td>
                  </tr>
                  <tr>
                    <td><span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_5_2']) && $subData['sub_answer_5_2']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Marijuana metabolic</td>
                    <td><span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_5_5']) && $subData['sub_answer_5_5']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Amphetamine</td>
                  </tr>
                  <tr>
                    <td><span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_5_3']) && $subData['sub_answer_5_3']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Morphine / Opiates</td>
                    <td><span class="box" style="width:12px;height:12px;line-height:12px;font-size:12px;"><?php echo (isset($subData['sub_answer_5_6']) && $subData['sub_answer_5_6']==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span> Alcohol metabolic</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu6==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          6. HIV Test
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu7==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          7. Chemical Contamination Test
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu8==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          8. Sleep Apnea Syndrome
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu11==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          9. Treadmill
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu12==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          10. PEME Gard
        </td>
      </tr>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu13==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          11. Stool culture
        </td>
      </tr>
    </table>

    <p class="mt">Pemeriksaan dilaksanakan untuk crew kami:</p>

    <!-- CREW -->
    <table class="border">
      <tr class="center">
        <th>No</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Kapal</th>
      </tr>

      <?php $no = 1; foreach ($persons as $p): ?>
      <tr>
        <td class="center"><?php echo $no++; ?></td>
        <td><?php echo $p->name_person; ?></td>
        <td><?php echo $p->rank; ?></td>
        <td><?php echo $p->vessel_name; ?></td>
      </tr>
      <?php endforeach; ?>
    </table>


    <p class="mt">Harap biaya dibebankan pada:</p>

    <table>
      <tr>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu9==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          <?php echo $header_mcu; ?>

        </td>
        <td>
          <span class="box"
            style="font-family: 'DejaVu Sans'; font-size: 16px;"><?php echo ($mcu->mcu10==1)?'✓':'&nbsp;&nbsp;&nbsp;'; ?></span>
          Crew yang bersangkutan
        </td>
      </tr>
    </table>

    <div class="signature">
      <p>Hormat Kami,</p>
      <?php if ($status_mcu == 1 || $status_mcu == 2): ?>
      <img src="<?php echo base_url('assets/imgQRCodeCrewCV/'.$signature_qr); ?>" style="height:50px;"><br>
      <?php endif; ?>
      <strong>Eva Marliana</strong><br>
      Crew Manager
    </div>


    <!-- APPROVE BUTTON -->
    <?php if ($status_mcu == 0): ?>
    <div style="margin-top:30px; text-align:right;">
      <div style="display:inline-flex; gap:10px;">

        <!-- APPROVE -->
        <form id="formApprove" method="post" action="<?php echo base_url('ListReport/Mcu/approve_mcu') ?>" onsubmit="event.preventDefault(); showLoading('formApprove');">
          <input type="hidden" name="id_report" value="<?php echo $id_report ?>">
          <input type="hidden" name="hash_id" value="<?php echo $hash_id ?>">
          <button type="submit" style="
          background:#28a745;
          color:#fff;
          border:none;
          padding:10px 18px;
          font-size:14px;
          border-radius:5px;
          cursor:pointer;">
            ✔ APPROVE MCU
          </button>
        </form>

        <!-- REJECT (OPEN MODAL) -->
        <button type="button" id="btnRejectMCU" style="
        background:#dc3545;
        color:#fff;
        border:none;
        padding:10px 18px;
        font-size:14px;
        border-radius:5px;
        cursor:pointer;">
          ✖ REJECT MCU
        </button>

      </div>
    </div>
    <?php endif; ?>

    <?php if ($status_mcu == 1 || $status_mcu == 2): ?>
    <div style="margin-top:30px; text-align:right;">
      <div style="display:inline-flex; gap:10px;">

        <form method="post" action="<?php echo base_url('ListReport/Mcu/generatePDF_MCU'); ?>" target="_blank">
          <?php
            $mcuArr = array();
            for ($i = 1; $i <= 13; $i++) {
                $prop = 'mcu' . $i;
                $mcuArr[] = isset($mcu->$prop) ? $mcu->$prop : 0;
            }
            $mcuStr = implode(',', $mcuArr);
          ?>
          <input type="hidden" name="persons" value='<?php echo htmlspecialchars(json_encode($persons), ENT_QUOTES, "UTF-8"); ?>'>
          <input type="hidden" name="mcu" value="<?php echo htmlspecialchars($mcuStr, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="sub_data" value='<?php echo htmlspecialchars(json_encode($subData), ENT_QUOTES, "UTF-8"); ?>'>
          <input type="hidden" name="date_mcu" value="<?php echo htmlspecialchars($date_mcu, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="clinic_name" value="<?php echo htmlspecialchars($clinic_name, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="address_clinic" value="<?php echo htmlspecialchars($address_clinic, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="telp" value="<?php echo htmlspecialchars($telp, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="fax" value="<?php echo htmlspecialchars($fax, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="status_mcu" value="<?php echo htmlspecialchars($status_mcu, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="signature_qr" value="<?php echo htmlspecialchars($signature_qr, ENT_QUOTES, "UTF-8"); ?>">
          <input type="hidden" name="header_mcu" value="<?php echo htmlspecialchars($header_mcu, ENT_QUOTES, "UTF-8"); ?>">

          <button type="submit" style="
                background:#0080ff;
                color:#fff;
                border:none;
                padding:10px 18px;
                font-size:14px;
                border-radius:5px;
                cursor:pointer;
                display:flex;
                align-items:center;
                gap:8px;">
            <span>Print MCU PDF</span>
          </button>
        </form>

      </div>
    </div>
    <?php endif; ?>


    <div class="modal fade" id="modalRejectMCU" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">

          <form id="formReject" method="post" action="<?php echo base_url('ListReport/Mcu/reject_mcu') ?>" onsubmit="event.preventDefault(); showLoading('formReject');">
            <div class="modal-body">
              <input type="hidden" name="id_report" value="<?php echo $id_report ?>">
              <input type="hidden" name="hash_id" value="<?php echo $hash_id ?>">

              <div class="form-group">
                <label style="padding-bottom:10px;"><strong>Reason for Rejection</strong></label>
                <br>
                <textarea name="remarks_reject" class="form-control" rows="4" required></textarea>
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-success">
                Submit Reject
              </button>
              <button type="button" class="btn btn-danger" id="btnCloseModal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>

</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showLoading(formId) {
  Swal.fire({
    title: 'Processing...',
    text: 'Mohon tunggu sebentar...',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
  document.getElementById(formId).submit();
}

$(document).ready(function() {
  <?php if ($this->session->flashdata('swal_success')): ?>
  let timerInterval;
  Swal.fire({
    title: "Berhasil!",
    html: "<?php echo $this->session->flashdata('swal_success'); ?> <br> Auto close alert in <b></b> milliseconds.",
    timer: 1000,
    icon: 'success',
    timerProgressBar: true,
    didOpen: () => {
      const timer = Swal.getPopup().querySelector("b");
      timerInterval = setInterval(() => {
        if(timer) timer.textContent = `${Swal.getTimerLeft()}`;
      }, 100);
    },
    willClose: () => {
      clearInterval(timerInterval);
    }
  }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log("I was closed by the timer");
    }
  });
  <?php endif; ?>
  $('#modalRejectMCU').modal({
    show: false
  });

  $('#btnRejectMCU').click(function() {
    $('#modalRejectMCU').modal('show');
  });

  $('#btnCloseModal').click(function() {
    $('#modalRejectMCU').modal('hide');
  });


});
</script>


<style>
/* CARD WRAPPER */
.card {
  max-width: 900px;
  margin: 30px auto;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
  padding: 20px;
}

/* SECTION */
.section {
  margin-top: 20px;
}

.section-title {
  font-weight: bold;
  font-size: 13px;
  border-bottom: 2px solid #000;
  padding-bottom: 4px;
  margin-bottom: 10px;
}

/* APPROVE FOOTER */
.approve-footer {
  margin-top: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Hide approve when print / pdf */
@media print {
  .approve-footer {
    display: none;
  }
}
</style>