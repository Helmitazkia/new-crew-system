<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familiarization Crew Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #e8eaf6 100%);
            font-family: 'Segoe UI', 'Times New Roman', serif;
            min-height: 100vh;
        }
        .form-container {
            max-width: 900px;
            margin: 30px auto;
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
        }
        .header-banner h4 { margin: 0; font-weight: 700; }
        .info-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 18px 22px;
            margin-bottom: 20px;
            border-left: 4px solid #000099;
        }
        .info-card .label { color: #666; font-size: 12px; margin-bottom: 2px; }
        .info-card .value { font-weight: 600; font-size: 14px; }
        .table-checklist th { background-color: #e8eaf6; font-size: 13px; }
        .table-checklist td { font-size: 13px; vertical-align: middle; }
        .item-disabled {
            background-color: #f5f5f5 !important;
            color: #bbb;
        }
        .item-filled {
            background-color: #e8f5e9 !important;
        }
        .audit-info {
            font-size: 11px;
            color: #666;
            font-style: italic;
            margin-top: 4px;
        }
        .btn-submit-public {
            background: linear-gradient(135deg, #000099 0%, #1a237e 100%);
            border: none;
            color: #fff;
            padding: 12px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
        }
        .btn-submit-public:hover {
            background: linear-gradient(135deg, #1a237e 0%, #000066 100%);
            color: #fff;
        }
        .btn-submit-public:disabled {
            background: linear-gradient(135deg, #303f9f 0%, #1a237e 100%);
            color: #ffffff !important;
            opacity: 0.9;
            cursor: not-allowed;
        }
        .error-container {
            max-width: 600px;
            margin: 80px auto;
            text-align: center;
        }
        
        /* Identity popup */
        .identity-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .identity-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Fix bootstrap-select inside overlay */
        .bootstrap-select .dropdown-menu {
            z-index: 10000;
        }
        .filter-option-inner-inner {
            color: #333;
            font-weight: 500;
        }
    </style>
</head>
<body>

<?php if (isset($error_message)): ?>
    <!-- ERROR STATE -->
    <div class="error-container">
        <div class="card shadow border-0">
            <div class="card-body p-5">
                <i class="fa fa-exclamation-triangle text-warning" style="font-size: 50px;"></i>
                <h4 class="mt-3 fw-bold">Oops!</h4>
                <p class="text-muted"><?php echo $error_message; ?></p>
            </div>
        </div>
    </div>
<?php else: ?>

    <!-- IDENTITY POPUP (muncul di awal) -->
    <div class="identity-overlay" id="identityOverlay">
        <div class="identity-card">
            <div style="text-align:center; margin-bottom: 20px;">
                <i class="fa fa-user-circle" style="font-size:50px; color:#000099;"></i>
                <h5 class="fw-bold mt-2" style="color:#000099;">Identifikasi Kru</h5>
                <p class="text-muted small mb-0">Silakan pilih nama Anda sebelum melanjutkan</p>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Pilih Nama Anda <span class="text-danger">*</span></label>
                <select class="form-control selectpicker border" data-live-search="true" data-size="5" title="-- Cari dan Pilih Nama --" id="inputFillerName" data-width="100%">
                    <?php foreach ($crewList as $c): ?>
                        <option value="<?php echo htmlspecialchars($c['idperson']); ?>" <?php echo $c['is_signed'] ? 'disabled' : ''; ?> class="dark-text">
                            <?php echo htmlspecialchars($c['nama_crew']) . ' (' . htmlspecialchars($c['rank']) . ')'; ?>
                            <?php echo $c['is_signed'] ? ' - Sudah Konfirmasi' : ''; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" class="btn btn-submit-public w-100 mt-2" id="btnStartFill">
                <i class="fa fa-arrow-right me-2"></i>Lanjutkan Membaca Materi
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <div class="form-container" id="mainForm" style="display: none;">
        <!-- Header Banner -->
        <div class="header-banner">
            <h4><i class="fa fa-book-open me-2"></i>FAMILIARIZATION MATERIAL</h4>
            <p class="mb-0 mt-2 text-white-50">Silakan baca dan konfirmasi materi di bawah ini.</p>
        </div>

        <!-- Info Cards -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="info-card">
                    <div class="label">Date Request</div>
                    <div class="value"><?php echo !empty($master->date_created) ? date('d M Y', strtotime($master->date_created)) : '-'; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-card">
                    <div class="label">Vessel</div>
                    <div class="value"><?php echo !empty($master->vessel) ? htmlspecialchars($master->vessel) : '-'; ?></div>
                </div>
            </div>
        </div>

        <!-- Checklist Table Read-Only -->
        <form id="formCrewChecklist">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="batch_id" value="<?php echo htmlspecialchars($batch_id); ?>">
            <input type="hidden" name="idperson" id="hiddenIdPerson" value="">

            <table class="table table-bordered table-checklist">
                <thead>
                    <tr>
                        <th class="text-center" style="width:45px;">No</th>
                        <th>Topics</th>
                        <th class="text-center" style="width:150px;">Department</th>
                        <th class="text-center" style="width:120px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevNo = '';
                    foreach ($checklistItems as $itemKey => $item):
                        $isFilledBefore = isset($auditMap[$itemKey]);
                        $existingFiller = $isFilledBefore ? $auditMap[$itemKey]->filled_by_name : '';
                        $existingDate = $isFilledBefore ? date('d M Y H:i', strtotime($auditMap[$itemKey]->filled_at)) : '';
                        
                        $currentValue = isset($master->{$itemKey}) ? $master->{$itemKey} : null;
                        
                        $rowClass = $isFilledBefore ? 'item-filled' : '';

                        if ($item['no'] === '2' && $prevNo !== '2'):
                    ?>
                        <tr style="background-color:#f8f9fa;"><td colspan="4" class="fw-bold">Company Policy :</td></tr>
                    <?php endif; ?>

                    <tr class="<?php echo $rowClass; ?>">
                        <td class="text-center"><?php echo $item['no']; ?></td>
                        <td>
                            <?php echo htmlspecialchars($item['topic']); ?>
                            <?php if ($isFilledBefore): ?>
                                <div class="audit-info">
                                    <i class="fa fa-check-circle text-success"></i>
                                    Diisi oleh dept terkait pada <?php echo $existingDate; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?php echo htmlspecialchars($item['dept']); ?></td>
                        <td class="text-center">
                            <?php if ($currentValue !== null && $currentValue !== ''): ?>
                                <span style="font-size:16px;">
                                    <?php echo ($currentValue == 1) ? '<span class="text-success fw-bold">✓ Ya</span>' : '<span class="text-danger fw-bold">✗ Tidak</span>'; ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                        $prevNo = $item['no'];
                    endforeach;
                    ?>
                </tbody>
            </table>

            <div class="text-center mt-5 mb-3">
                <div class="alert alert-info text-start d-inline-block shadow-sm">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkConfirm" style="width:20px; height:20px; margin-top:2px; cursor:pointer;">
                        <label class="form-check-label ms-2" for="checkConfirm" style="font-size:15px; cursor:pointer;">
                            <strong>Saya mengonfirmasi bahwa saya telah menerima dan memahami seluruh materi Familiarization di atas.</strong><br>
                            <span class="text-muted small">Dengan menekan tombol submit, tanda tangan elektronik Anda akan diterbitkan.</span>
                        </label>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-submit-public mt-3" id="btnSubmitConfirm" disabled>
                    <i class="fa fa-signature me-2"></i>Submit & Tanda Tangan
                </button>
            </div>
        </form>

    </div>

    <script>
    $(document).ready(function() {
        // Init selectpicker
        $('.selectpicker').selectpicker();

        // Identity popup
        $('#btnStartFill').on('click', function() {
            var idperson = $('#inputFillerName').val();
            if (!idperson) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan pilih nama Anda terlebih dahulu!', confirmButtonColor: '#000099' });
                return;
            }
            $('#hiddenIdPerson').val(idperson);
            $('#identityOverlay').fadeOut(300, function() {
                $('#mainForm').fadeIn(300);
            });
        });

        $('#checkConfirm').on('change', function() {
            $('#btnSubmitConfirm').prop('disabled', !$(this).is(':checked'));
        });

        // Submit form
        $('#formCrewChecklist').on('submit', function(e) {
            e.preventDefault();

            var btn = $('#btnSubmitConfirm');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i>Memproses...');

            $.ajax({
                url: '<?php echo base_url("PublicFamiliar/submit_crew_confirm"); ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            confirmButtonColor: '#000099'
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        btn.prop('disabled', false).html('<i class="fa fa-signature me-2"></i>Submit & Tanda Tangan');
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message, confirmButtonColor: '#000099' });
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-signature me-2"></i>Submit & Tanda Tangan');
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem.', confirmButtonColor: '#000099' });
                }
            });
        });
    });
    </script>

<?php endif; ?>

</body>
</html>
