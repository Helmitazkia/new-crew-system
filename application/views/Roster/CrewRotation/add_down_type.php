<?php
$batch_id_val = isset($batch_id) ? $batch_id : '';
$is_edit = (!empty($batch_id_val)) ? true : false;
?>

<div class="row">
    <div class="col-md-12">
        <form id="formCrewRotationDown">
            <input type="hidden" name="batch_id" value="<?php echo htmlspecialchars($batch_id_val); ?>">
            
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-header bg-light border-bottom-0 py-3">
                    <h6 class="mb-0 fw-bold text-primary"><i class="fa fa-user-minus me-2"></i> Down Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Candidate Down(s) -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Candidate Down(s) <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker-down" name="idperson[]" id="new_idperson_multi" data-live-search="true" data-size="8" multiple required <?php echo $is_edit ? 'disabled' : ''; ?>>
                                <!-- Options will be populated via JS -->
                            </select>
                            <div class="alert alert-primary py-1 px-2 mb-0 mt-1 border-0 bg-primary bg-opacity-10 text-primary" style="font-size: 11px;">
                              <i class="fa fa-lightbulb me-1"></i> <strong>Tips:</strong> Bisa pilih lebih dari satu kandidat.
                            </div>
                            <small class="text-muted d-block mt-1">Hanya menampilkan kru yang saat ini berstatus Onboard.</small>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Sign Off Date -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Sign Off Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="signoffdt" id="new_signoffdt" required>
                        </div>
                        <!-- Sign Off Reason -->
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-semibold">Sign Off Reason <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker-down" name="signoffremark" id="new_signoffremark" data-live-search="true" required>
                                <!-- Options populated via JS -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Remarks -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Remarks / Notes</label>
                            <textarea class="form-control" name="estremark" id="new_estremark" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end mt-4 border-top pt-3">
                <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" id="btnSaveNewCrewRotationDown">
                    <i class="fa fa-save me-2"></i> <?php echo $is_edit ? 'Update Data' : 'Save Down'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    var rawPersonOptions = <?php echo isset($optionsPersonActiveRosterJson) ? $optionsPersonActiveRosterJson : '[]'; ?>;
    var rawSignoffRemarks = <?php echo isset($optionsSignOffRemarkJson) ? $optionsSignOffRemarkJson : '[]'; ?>;
    
    // Filter person: Hanya Onboard (signoffdt kosong/null/0000-00-00)
    function populateDropdown(selId, dataArray) {
        var $sel = $(selId);
        $sel.empty();
        
        var cleanArray = (dataArray || []).filter(function(item) {
            return item.value !== '';
        });

        if (!$sel.prop('multiple')) {
            $sel.append('<option value="">- Select -</option>');
        }
        
        $.each(cleanArray, function(i, item) {
            $sel.append('<option value="' + item.value + '">' + item.text + '</option>');
        });
    }

    var onboardPersons = rawPersonOptions.filter(function(p) {
        var isOff = p.signoffdt && p.signoffdt !== '0000-00-00';
        return !isOff; // Not off means they are currently onboard
    });

    populateDropdown('#new_idperson_multi', onboardPersons);
    populateDropdown('#new_signoffremark', rawSignoffRemarks);

    // Initialize Selectpicker
    $('.selectpicker-down').each(function() {
        var $el = $(this);
        var opts = {
            style: 'btn-outline-secondary btn-sm',
            size: 5,
            noneSelectedText: '- Select -'
        };
        if ($el.attr('id') === 'new_idperson_multi') {
            opts.noneSelectedText = '- Select Candidate(s) -';
            opts.size = 8;
        }
        $el.selectpicker(opts);
        if ($el.attr('id') === 'new_idperson_multi') {
            $el.parent('.bootstrap-select').addClass('replacement-select');
        }
    });
    
    // Refresh
    // selPerson.selectpicker('refresh');
    // selRemark.selectpicker('refresh');

    // --- Candidate Chips Logic ---
    function renderCandidateChipsDown() {
        var $sel = $('#new_idperson_multi');
        if (!$sel.length) return;
        var $wrap = $sel.parent('.bootstrap-select');
        if (!$wrap.length) return;
        var $label = $wrap.find('.filter-option-inner-inner');
        if (!$label.length) return;

        var selected = $sel.find('option:selected').map(function() {
            return { value: this.value, text: $(this).text() };
        }).get();

        if (!selected || selected.length === 0) {
            $label.text('- Select Candidate(s) -');
            return;
        }

        $label.empty();
        selected.forEach(function(o) {
            if (!o.value) return;
            var $chip = $('<span class="repl-chip"></span>').attr('data-value', o.value);
            $chip.append($('<span class="repl-chip-text"></span>').text(o.text));
            var $btn = $('<button type="button" class="repl-chip-remove" aria-label="Remove">×</button>').attr('data-value', o.value);
            
            $btn.on('mousedown click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (e.type === 'click') {
                    var removeVal = $(this).attr('data-value').toString();
                    var cur = $sel.val();
                    if (!Array.isArray(cur)) cur = cur ? [cur] : [];
                    var next = cur.filter(function(v) { return v !== removeVal; });
                    $sel.selectpicker('val', next);
                    renderCandidateChipsDown();
                }
            });
            
            $chip.append($btn);
            $label.append($chip);
        });
    }

    $('#new_idperson_multi')
      .off('loaded.bs.select.replChipDown changed.bs.select.replChipDown')
      .on('loaded.bs.select.replChipDown changed.bs.select.replChipDown', function() {
        renderCandidateChipsDown();
      });

    renderCandidateChipsDown();

    // Save Action
    $('#btnSaveNewCrewRotationDown').off('click').on('click', function(e) {
        e.preventDefault();
        var form = $('#formCrewRotationDown');

        // Validasi Manual
        var idpersons = $('#new_idperson_multi').val();
        var signoffdt = $('#new_signoffdt').val();
        var signoffremark = $('#new_signoffremark').val();

        if (!idpersons || idpersons.length === 0) {
            Swal.fire('Oops', 'Candidate Down(s) wajib diisi.', 'warning');
            return;
        }
        if (!signoffdt) {
            Swal.fire('Oops', 'Sign Off Date wajib diisi.', 'warning');
            return;
        }
        if (!signoffremark) {
            Swal.fire('Oops', 'Sign Off Reason wajib diisi.', 'warning');
            return;
        }

        var btn = $(this);
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

        var formData = form.serialize();

        $.ajax({
            url: "<?php echo base_url('CrewRotation/CrewRotation_Down/save_down_type'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalCrewRotationForm').modal('hide');
                        if (typeof $('#crewTable').DataTable === 'function') {
                            $('#crewTable').DataTable().ajax.reload(null, false);
                        }
                    });
                } else {
                    Swal.fire('Error', res.message || 'Gagal menyimpan data', 'error');
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Terjadi kesalahan sistem: ' + error, 'error');
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

});
</script>

<style>
/* Replacement select: show selected as chips with × (email-like) */
.bootstrap-select.replacement-select .filter-option-inner-inner {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  align-items: center;
}
.bootstrap-select.replacement-select .repl-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 2px 8px;
  background: #e9ecef;
  border: 1px solid #dee2e6;
  border-radius: 4px;
  font-size: 12px;
  line-height: 1.4;
}
.bootstrap-select.replacement-select .repl-chip-remove {
  font-weight: 700;
  padding: 0 2px;
  line-height: 1;
  border: none;
  background: none;
  font-size: 14px;
}
.bootstrap-select.replacement-select .repl-chip-remove:hover {
  color: #dc3545;
}
.bootstrap-select .dropdown-menu li a {
  color: #000 !important;
}
.bootstrap-select .dropdown-menu li a:hover,
.bootstrap-select .dropdown-menu li a:focus,
.bootstrap-select .dropdown-menu li.active a {
  background-color: #e3f2fd !important;
  color: #000 !important;
}
.bootstrap-select .filter-option-inner-inner {
  color: #000 !important;
}
</style>
