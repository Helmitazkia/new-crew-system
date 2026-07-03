<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Briefing Checklist - <?php echo htmlspecialchars($history->nama_crew); ?></title>
    <!-- Include Bootstrap CSS (using CDN for public page) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Times New Roman', serif;
        }
        .form-container {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000999;
            border-bottom: 2px solid #000999;
            padding-bottom: 10px;
        }
        .table-briefing th, .table-briefing td {
            vertical-align: middle;
            font-size: 14px;
        }
        .section-header {
            background-color: #000099 !important;
            color: white !important;
            font-weight: bold;
            text-align: left;
            padding: 8px !important;
        }
        .info-label {
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 14px;
        }
        .info-value {
            border-bottom: 1px dotted #000;
            margin-bottom: 15px;
            min-height: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h3 class="header-title">BRIEFING CHECK LIST PRIOR JOINING VESSEL</h3>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="info-label">Name</div>
            <div class="info-value"><?php echo htmlspecialchars($history->nama_crew); ?></div>
            
            <div class="info-label">Rank</div>
            <div class="info-value"><?php echo htmlspecialchars($history->rank); ?></div>
        </div>
        <div class="col-md-6">
            <div class="info-label">Vessel Name</div>
            <div class="info-value"><?php echo htmlspecialchars($history->vessel); ?></div>
            
            <div class="info-label">Date of Briefing</div>
            <div class="info-value"><?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : ''; ?></div>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="fa fa-info-circle me-2"></i> Please tick (Yes/No) the column during briefing / test
    </div>

    <form id="formBriefingCrew">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        
        <?php
        // Define all items logically based on template
        $sections = array(
            'ABOUT AES' => array(
                1 => 'Crew Manning Agent',
                2 => 'Company Policy',
                3 => 'Organization',
            ),
            'DISCIPLINE & COMPLAIN' => array(
                4 => 'Personal Protective Equipment',
                5 => 'Complaints/Problems onboard - (received Complaint Proc. & Form)',
                6 => 'Disciplinary Procedure',
                7 => 'Drug and Alcohol Policy',
                8 => 'Anti Smuggling',
                9 => 'Jump Ship',
                10 => 'Pornography prohibition',
                11 => 'Borrow money on board',
                12 => 'Online gambling',
                13 => 'Online Loan',
            ),
            'ABOUT PRINCIPALS' => array(
                14 => 'Organisation',
                15 => 'Q M System',
            ),
            'EMPLOYMENT CONTRACT' => array(
                16 => 'Service Period',
                17 => 'Vessel\'s route',
                18 => 'Type of vessel',
                19 => 'Insurance',
                20 => 'Collective Bargaining Agreement',
                21 => 'MLC and Indonesia Goverment Regulation no. 7 - 2000',
            ),
            'MEDICAL' => array(
                22 => 'Pre-employment medical check up',
                23 => 'Drug and Alcohol test/Screening',
                24 => 'Crew Medical coverage',
                25 => 'Sick onboard / medical report',
            ),
            'SALARY' => array(
                26 => 'As per contract',
                27 => 'Bank Account',
                28 => 'Onboard / Home Salary',
                29 => 'NPWP',
                30 => 'Deduction (if any)',
                31 => 'Exchange rates - company',
            ),
            'LATEST INCIDENCES' => array(
                32 => 'Crew Incident',
                33 => 'Fire / Piracy',
                34 => 'Engine problem',
                35 => 'Other Emergency situations',
            ),
            'TRAVEL TO JOIN VESSEL' => array(
                36 => 'Agents Address',
                37 => 'Emergency contact',
                38 => 'Schedule of join (Date & Time)',
                39 => 'Airport rules',
            ),
            'HEALTH SAFETY N ENVIRONMENT' => array(
                40 => 'Health',
                41 => 'Safety',
                42 => 'Environment Protection',
            ),
            'IN HOUSE TRAINING' => array(
                43 => 'English',
                44 => 'ISM Code/Safety',
                45 => 'Risk Management',
                46 => 'Deck or Engine Knowledge',
                47 => 'Operating Procedur Manual',
                48 => 'Others',
            ),
            'LEAVE / DOCUMENTS' => array(
                49 => 'Reporting system',
                50 => 'On leave surrender documents',
                51 => 'Validity of documents',
                52 => 'Present address',
            ),
            'WORKING HOURS' => array(
                53 => 'Working Hours (Max. 72 hours in any 7 days or max. 14 hrs/day)',
                54 => 'Rest Periods (Min. 77 hours in any 7 days or min. 10 hrs/day)',
            )
        );
        ?>

        <div class="row">
        <?php 
        $col1 = array('ABOUT AES', 'ABOUT PRINCIPALS', 'EMPLOYMENT CONTRACT', 'SALARY', 'HEALTH SAFETY N ENVIRONMENT', 'IN HOUSE TRAINING');
        $col2 = array('DISCIPLINE & COMPLAIN', 'MEDICAL', 'LATEST INCIDENCES', 'TRAVEL TO JOIN VESSEL', 'LEAVE / DOCUMENTS', 'WORKING HOURS');

        function render_section($sections, $sec_names, $checklist_items) {
            echo '<div class="col-md-6">';
            echo '<table class="table table-bordered table-sm table-briefing">';
            echo '<tbody>';
            foreach($sec_names as $sec_name) {
                echo '<tr><td colspan="2" class="section-header">'.$sec_name.'</td></tr>';
                foreach($sections[$sec_name] as $idx => $item_text) {
                    $val = isset($checklist_items[$idx-1]) ? $checklist_items[$idx-1] : '';
                    $checked_yes = ($val === '1') ? 'checked' : '';
                    $checked_no = ($val === '0') ? 'checked' : '';
                    echo '<tr>';
                    echo '<td style="width:70%;">'.$item_text.'</td>';
                    echo '<td style="width:30%; text-align:center;">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="item_'.$idx.'" id="item_'.$idx.'_yes" value="1" '.$checked_yes.' required>
                                <label class="form-check-label text-success fw-bold" for="item_'.$idx.'_yes">✓ Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="item_'.$idx.'" id="item_'.$idx.'_no" value="0" '.$checked_no.'>
                                <label class="form-check-label text-danger fw-bold" for="item_'.$idx.'_no">✗ No</label>
                            </div>
                          </td>';
                    echo '</tr>';
                }
            }
            echo '</tbody></table></div>';
        }
        
        render_section($sections, $col1, $checklist_items);
        render_section($sections, $col2, $checklist_items);
        ?>
        </div>

        <div class="alert alert-secondary mt-4">
            <div class="mb-2">
                I (Rank, Name & Signature) <strong><?php echo htmlspecialchars($history->rank . ', ' . $history->nama_crew); ?></strong> was carried out and briefed on the above by Mr/Ms
            </div>
            <div class="mb-2">
                <input type="text" class="form-control form-control-sm w-50 d-inline-block" value="<?php echo htmlspecialchars($history->mr_ms_by); ?>" disabled>
            </div>
            <div class="mb-2">
                date <strong><?php echo !empty($history->date_briefing) ? date('d F Y', strtotime($history->date_briefing)) : ''; ?></strong>
            </div>
            <div>
                prior joining vessel MV/MT <input type="text" class="form-control form-control-sm w-50 d-inline-block" value="<?php echo htmlspecialchars($history->prior_joining_vessel); ?>" disabled>
            </div>
        </div>

        <div class="text-end mt-4">
            <?php if($history->is_submitted == 1): ?>
                <div class="alert alert-success text-center d-inline-block px-5 py-2">
                    <i class="fa fa-check-circle me-2"></i> Form has been submitted. Thank you!
                </div>
            <?php else: ?>
                <button type="button" id="btnSubmitBriefing" class="btn btn-primary px-5 py-2 fw-bold" style="background-color: #000999;">
                    <i class="fa fa-paper-plane me-2"></i> Submit Briefing
                </button>
            <?php endif; ?>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {
    $('#btnSubmitBriefing').on('click', function() {
        var isValid = true;
        
        // Cek validasi form required
        if (!$('#formBriefingCrew')[0].checkValidity()) {
            $('#formBriefingCrew')[0].reportValidity();
            return;
        }

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Submitting...');

        $.ajax({
            url: '<?php echo base_url("PublicBriefing/submit_form"); ?>',
            type: 'POST',
            data: $('#formBriefingCrew').serialize(),
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#000999'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-2"></i> Submit Briefing');
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-2"></i> Submit Briefing');
                Swal.fire('Error', 'System error occurred!', 'error');
            }
        });
    });
});
</script>

</body>
</html>
