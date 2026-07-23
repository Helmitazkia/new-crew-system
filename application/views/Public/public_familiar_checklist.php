<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Familiarization Checklist<?php echo isset($link) ? ' - ' . htmlspecialchars($link->department) : ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .header-banner .dept-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 5px 15px;
            border-radius: 20px;
            margin-top: 8px;
            font-size: 14px;
        }
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
        .fam-radio-public {
            cursor: pointer;
            width: 18px;
            height: 18px;
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
        .error-container {
            max-width: 600px;
            margin: 80px auto;
            text-align: center;
        }
        .crew-list-item {
            display: inline-block;
            background: #e8eaf6;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            margin: 3px 4px;
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
                <p class="text-muted small">Silakan hubungi admin untuk mendapatkan link yang valid.</p>
            </div>
        </div>
    </div>
<?php else: ?>

    <!-- IDENTITY POPUP (muncul di awal) -->
    <div class="identity-overlay" id="identityOverlay">
        <div class="identity-card">
            <div style="text-align:center; margin-bottom: 20px;">
                <i class="fa fa-user-circle" style="font-size:50px; color:#000099;"></i>
                <h5 class="fw-bold mt-2" style="color:#000099;">Identifikasi Pengisi</h5>
                <p class="text-muted small mb-0">Silakan masukkan nama Anda sebelum mengisi checklist</p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="inputFillerName" placeholder="Masukkan nama lengkap Anda..." autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Department</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($link->department); ?>" readonly style="background-color: #e8eaf6; font-weight: 600;">
            </div>
            <button type="button" class="btn btn-submit-public w-100 mt-2" id="btnStartFill">
                <i class="fa fa-arrow-right me-2"></i>Mulai Mengisi
            </button>
        </div>
    </div>

    <!-- MAIN FORM -->
    <div class="form-container" id="mainForm" style="display: none;">
        <!-- Header Banner -->
        <div class="header-banner">
            <h4><i class="fa fa-clipboard-check me-2"></i>FAMILIARIZATION CHECKLIST</h4>
            <div class="dept-badge">
                <i class="fa fa-building me-1"></i>Department: <?php echo htmlspecialchars($link->department); ?>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="label">Date Request</div>
                    <div class="value"><?php echo !empty($master->date_created) ? date('d M Y', strtotime($master->date_created)) : '-'; ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="label">Total Crew</div>
                    <div class="value"><?php echo count($crewList); ?> Orang</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="label">Note</div>
                    <div class="value"><?php echo !empty($master->note) ? htmlspecialchars($master->note) : '-'; ?></div>
                </div>
            </div>
        </div>

        <!-- Crew List -->
        <div class="mb-4">
            <strong class="text-muted" style="font-size:13px;"><i class="fa fa-users me-1"></i>Daftar Crew:</strong><br>
            <?php foreach ($crewList as $c): ?>
                <span class="crew-list-item">
                    <?php echo htmlspecialchars($c['nama_crew']); ?>
                    <small class="text-muted">(<?php echo htmlspecialchars($c['rank']); ?>)</small>
                </span>
            <?php endforeach; ?>
        </div>

        <!-- Checklist Table -->
        <form id="formPublicChecklist">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="filled_by_name" id="hiddenFillerName" value="">

            <table class="table table-bordered table-checklist">
                <thead>
                    <tr>
                        <th class="text-center" style="width:45px;">No</th>
                        <th>Topics</th>
                        <th class="text-center" style="width:150px;">Department</th>
                        <th class="text-center" style="width:120px;">Yes / No</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevNo = '';
                    foreach ($checklistItems as $itemKey => $item):
                        $isAllowed = in_array($itemKey, $allowedItems);
                        $isFilledBefore = isset($auditMap[$itemKey]);
                        $existingValue = $isFilledBefore ? $auditMap[$itemKey]->item_value : null;
                        $existingFiller = $isFilledBefore ? $auditMap[$itemKey]->filled_by_name : '';
                        $existingDate = $isFilledBefore ? date('d M Y H:i', strtotime($auditMap[$itemKey]->filled_at)) : '';

                        // Get current value from master
                        $currentValue = isset($master->{$itemKey}) ? $master->{$itemKey} : null;

                        $rowClass = '';
                        if (!$isAllowed) $rowClass = 'item-disabled';
                        elseif ($isFilledBefore) $rowClass = 'item-filled';

                        // Insert section header before item 2
                        if ($item['no'] === '2' && $prevNo !== '2'):
                    ?>
                        <tr style="background-color:#f8f9fa;"><td colspan="4" class="fw-bold">Company Policy :</td></tr>
                    <?php endif; ?>

                    <tr class="<?php echo $rowClass; ?>">
                        <td class="text-center"><?php echo $item['no']; ?></td>
                        <td>
                            <?php echo htmlspecialchars($item['topic']); ?>
                            <?php if ($isFilledBefore && $isAllowed): ?>
                                <div class="audit-info">
                                    <i class="fa fa-check-circle text-success"></i>
                                    Diisi oleh: <?php echo htmlspecialchars($existingFiller); ?> pada <?php echo $existingDate; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?php echo htmlspecialchars($item['dept']); ?></td>
                        <td class="text-center">
                            <?php if ($isAllowed): ?>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input fam-radio-public" type="radio" name="<?php echo $itemKey; ?>" value="1"
                                        <?php echo ($currentValue === '1' || $currentValue === 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label text-success fw-bold">✓</label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input fam-radio-public" type="radio" name="<?php echo $itemKey; ?>" value="0"
                                        <?php echo ($currentValue === '0' || $currentValue === 0) ? 'checked' : ''; ?>>
                                    <label class="form-check-label text-danger fw-bold">✗</label>
                                </div>
                            <?php else: ?>
                                <?php if ($currentValue !== null && $currentValue !== ''): ?>
                                    <span style="font-size:16px;">
                                        <?php echo ($currentValue == 1) ? '<span class="text-success">✓</span>' : '<span class="text-danger">✗</span>'; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                        $prevNo = $item['no'];
                    endforeach;
                    ?>
                </tbody>
            </table>

            <div class="row mt-4 mb-3">
                <div class="col-md-6 offset-md-3">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-center" style="color: #000099;">
                                <i class="fa fa-clock me-2"></i>Waktu Pelaksanaan Familiarization
                            </h6>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label fw-bold" style="font-size: 13px;">Time Start <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="time_start" value="<?php echo !empty($link->time_start) ? date('H:i', strtotime($link->time_start)) : ''; ?>" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold" style="font-size: 13px;">Time End <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="time_end" value="<?php echo !empty($link->time_end) ? date('H:i', strtotime($link->time_end)) : ''; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 mb-3">
                <button type="submit" class="btn btn-submit-public" id="btnSubmitPublic">
                    <i class="fa fa-paper-plane me-2"></i>Submit Checklist
                </button>
            </div>
        </form>

        <div class="text-center mt-2">
            <small class="text-muted">
                <i class="fa fa-lock me-1"></i>
                Anda hanya dapat mengisi item milik departemen <strong><?php echo htmlspecialchars($link->department); ?></strong>.
                Item departemen lain bersifat read-only.
            </small>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Identity popup
        $('#btnStartFill').on('click', function() {
            var name = $.trim($('#inputFillerName').val());
            if (!name) {
                Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Silakan masukkan nama Anda terlebih dahulu!', confirmButtonColor: '#000099' });
                return;
            }
            $('#hiddenFillerName').val(name);
            $('#identityOverlay').fadeOut(300, function() {
                $('#mainForm').fadeIn(300);
            });
        });

        // Allow Enter key on name input
        $('#inputFillerName').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btnStartFill').click();
            }
        });

        // Submit form
        $('#formPublicChecklist').on('submit', function(e) {
            e.preventDefault();

            var btn = $('#btnSubmitPublic');
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i>Menyimpan...');

            $.ajax({
                url: '<?php echo base_url("PublicFamiliar/submit_checklist"); ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-2"></i>Submit Checklist');
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
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message, confirmButtonColor: '#000099' });
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-2"></i>Submit Checklist');
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem.', confirmButtonColor: '#000099' });
                }
            });
        });
    });
    </script>

<?php endif; ?>

</body>
</html>
