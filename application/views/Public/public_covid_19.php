<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health and Pandemic Guidelines</title>
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #e8eaf6 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .form-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 153, 0.08);
        }
        .header-banner {
            background: linear-gradient(135deg, #000099 0%, #1a237e 100%);
            color: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }
        .header-banner h4 { margin: 0; font-weight: 700; font-size: 24px; letter-spacing: 0.5px; }
        .header-banner p { margin-top: 5px; opacity: 0.8; font-size: 14px; }
        .info-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 18px 22px;
            margin-bottom: 20px;
            border-left: 4px solid #000099;
        }
        .info-card .label { color: #666; font-size: 12px; margin-bottom: 2px; }
        .info-card .value { font-weight: 600; font-size: 15px; color: #333; }
        .table-guidelines td { padding: 18px 10px; vertical-align: middle; border-bottom: 1px solid #f0f0f0; }
        .table-guidelines tr:last-child td { border-bottom: none; }
        .table-guidelines img { border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 2px solid #fff; }
        .btn-submit-public {
            background: linear-gradient(135deg, #000099 0%, #1a237e 100%);
            border: none;
            color: #fff;
            padding: 14px 45px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(0,0,153,0.3);
            transition: all 0.3s;
        }
        .btn-submit-public:hover {
            background: linear-gradient(135deg, #1a237e 0%, #000066 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,153,0.4);
        }
        .success-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        
        <div class="header-banner">
            <h4><i class="fa fa-shield-virus me-2"></i>Health and Pandemic Guidelines</h4>
            <p class="mb-0">COVID-19 Prevention & Stay Healthy Protocol</p>
        </div>
        
        <?php if (!empty($report->sign_on)): ?>
            <div class="success-box">
                <i class="fa fa-check-circle fa-4x mb-3 text-success"></i>
                <h4 class="fw-bold text-success mb-2">Tanda Tangan Diterima</h4>
                <p class="text-muted">Anda sudah men-submit persetujuan Health and Pandemic Guidelines ini secara digital.</p>
                <div class="mt-4 p-3 bg-white rounded shadow-sm d-inline-block">
                    <img src="<?php echo base_url('assets/imgQRCodeCrewCV/' . $report->sign_on); ?>" style="height:120px;" />
                    <p class="mt-2 mb-0 fw-bold small text-muted">Verified Digital Signature</p>
                </div>
            </div>
        <?php else: ?>

            <!-- Info Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="label"><i class="fa fa-user me-1"></i> Full Name</div>
                        <div class="value"><?php echo $report->fullname; ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="label"><i class="fa fa-id-badge me-1"></i> Rank</div>
                        <div class="value"><?php echo $report->rankname; ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="label"><i class="fa fa-ship me-1"></i> Vessel</div>
                        <div class="value"><?php echo $report->vessel_name; ?></div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-guidelines">
                    <tbody>
                        <?php 
                         $items = array(
                            array("Avoid these modes of travel if you have a fever or a cough.",
                            "Hindari perjalanan moda transportasi ini apabila anda sedang sakit demam atau batuk.",
                            "gambar1.jpg"),

                            array("Eat only well-cooked food.",
                            "Makanlah makanan yang dimasak matang.",
                            "gambar2.jpg"),

                            array("Avoid spitting in public.",
                            "Hindari meludah di keramaian.",
                            "gambar3.jpg"),

                            array("Avoid close contact and travel with sick animals, particularly in wet markets.",
                            "Hindari kontak dekat dan bepergian dengan binatang yang sakit, terutama di pasar tradisional.",
                            "gambar4.jpg"),

                            array("When coughing and sneezing, cover your mouth and nose with a tissue or flexed elbow.",
                            "Ketika batuk dan bersin, tutuplah mulut dan hidung dengan tisu atau siku.",
                            "gambar5.jpg"),

                            array("Frequently clean hands with alcohol-based hand rub or wash with soap at least 20 seconds.",
                            "Sering membersihkan tangan dengan hand sanitizer atau sabun selama 20 detik.",
                            "gambar6.jpg"),

                            array("Avoid touching eyes, nose, mouth.",
                            "Hindari menyentuh mata, hidung, dan mulut.",
                            "gambar7.jpg"),

                            array("Avoid close contact with people suffering fever or cough.",
                            "Hindari kontak dekat dengan orang yang menderita demam atau batuk.",
                            "gambar8.jpg"),

                            array("If wearing a mask, ensure it covers mouth and nose.",
                            "Jika memakai masker, pastikan menutupi mulut dan hidung.",
                            "gambar9.jpg"),

                            array("If you become sick while traveling, tell the crew or ground staff.",
                            "Jika sakit saat bepergian, beritahu petugas.",
                            "gambar10.jpg"),

                            array("Seek medical care early if you become sick and share history with the provider.",
                            "Cari perawatan medis lebih awal jika sakit.",
                            "gambar11.jpg"),
                        );

                        foreach ($items as $item): ?>
                        <tr>
                            <td style="width:75%;">
                                <p class="mb-1 fw-bold text-dark" style="font-size: 15px;"><?php echo $item[0]; ?></p>
                                <p class="mb-0 text-muted fst-italic" style="font-size: 14px;"><?php echo $item[1]; ?></p>
                            </td>
                            <td class="text-center" style="width:25%;">
                                <img src="<?php echo base_url('assets/img/' . $item[2]); ?>" style="width:110px;">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 border rounded text-center" style="background-color: #f8f9fc; border-color: #e3e6f0 !important;">
                <h6 class="fw-bold mb-1" style="color: #4e73df;">As International Chamber of Shipping Maritime Publications 2020</h6>
                <p class="mb-0 fst-italic text-dark">"Have read, understand and will be implemented."</p>
            </div>

            <div class="text-center mt-5 mb-2">
                <button type="button" class="btn-submit-public" id="btnSubmitSignature">
                    <i class="fa fa-qrcode me-2"></i> Submit Persetujuan
                </button>
            </div>

        <?php endif; ?>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#btnSubmitSignature').on('click', function() {
        var btn = $(this);
        
        Swal.fire({
            title: 'Konfirmasi Persetujuan',
            html: "Dengan menekan tombol ini, Anda menyatakan telah membaca, mengerti, dan bersedia menjalankan pedoman pencegahan <b>COVID-19</b> ini.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#000099',
            cancelButtonColor: '#e74a3b',
            confirmButtonText: 'Ya, Saya Setuju',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Memproses...');
                
                $.ajax({
                    url: '<?php echo base_url("PublicCovid19/submit_form"); ?>',
                    type: 'POST',
                    data: { token: '<?php echo $token; ?>' },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            btn.prop('disabled', false).html('<i class="fa fa-qrcode me-2"></i> Submit Persetujuan (Sign)');
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-qrcode me-2"></i> Submit Persetujuan (Sign)');
                        Swal.fire('Error', 'Terjadi kesalahan pada sistem.', 'error');
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
