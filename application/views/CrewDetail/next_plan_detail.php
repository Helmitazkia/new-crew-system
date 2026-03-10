<?php
$row = isset($row) ? $row : null;
$r = $row;
if (!function_exists('_np_fmt')) {
  function _np_fmt($d) {
    return ($d && $d !== '0000-00-00') ? date('d M Y', strtotime($d)) : '-';
  }
}
if (!function_exists('_np_val')) {
  function _np_val($arr, $key, $def = '-') {
    return (isset($arr[$key]) && $arr[$key] !== '' && $arr[$key] !== null) ? $arr[$key] : $def;
  }
}
?>
<div class="next-plan-detail-content mb-0 pb-0">
  <div class="row g-3 pb-3">
    <!-- ========== LEFT: OFF-SIGNER ========== -->
    <div class="col-lg-4">
      <div class="card h-100 border">
        <div class="card-header bg-light fw-semibold fst-italic">Off Signer (yang turun)</div>
        <div class="card-body">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="rounded bg-primary bg-opacity-25 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
              <i class="fa fa-user text-primary"></i>
            </div>
            <div class="flex-grow-1">
              <label class="form-label mb-0 small fw-semibold">Name</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'onboard_name')) : '-'; ?>">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== RIGHT: ON SIGNER (New Contract Details) ========== -->
    <div class="col-lg-8">
      <div class="card h-100 border">
        <div class="card-header bg-light fw-semibold fst-italic">On Signer (New Contract Details)</div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Replacement Candidate</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'replacement_name')) : '-'; ?>">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Replacement Rank</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'replacement_rank')) : '-'; ?>">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Company Name</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'company_name')) : '-'; ?>">
            </div>
            <div class="col-md-3 mb-2">
              <label class="form-label small fw-semibold">Sign on Date</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? _np_fmt(_np_val($r, 'signondt', '')) : '-'; ?>">
            </div>
            <div class="col-md-3 mb-2">
              <label class="form-label small fw-semibold">Estimate Sign off Date</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? _np_fmt(_np_val($r, 'estsignoffdt', '')) : '-'; ?>">
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label small fw-semibold">Sign on Rank</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'onboard_rank_name') !== '-' ? _np_val($r, 'onboard_rank_name') : _np_val($r, 'signonrank')) : '-'; ?>">
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label small fw-semibold">Sign on Vessel</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'onboard_vessel_name') !== '-' ? _np_val($r, 'onboard_vessel_name') : _np_val($r, 'signonvsl')) : '-'; ?>">
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label small fw-semibold">Sign on Port</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'signonport')) : '-'; ?>">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Last Vessel</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'lastvsl_name') !== '-' ? _np_val($r, 'lastvsl_name') : _np_val($r, 'lastvsl')) : '-'; ?>">
            </div>
            <div class="col-12 mb-2">
              <label class="form-label small fw-semibold">Sign on Description</label>
              <textarea class="form-control form-control-sm bg-light" rows="2" readonly><?php echo $r ? htmlspecialchars(_np_val($r, 'signondesc', '')) : ''; ?></textarea>
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label small fw-semibold">No. PKL</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'no_pkl')) : '-'; ?>">
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label small fw-semibold">Remarks</label>
              <textarea class="form-control form-control-sm bg-light" rows="2" readonly><?php echo $r ? htmlspecialchars(_np_val($r, 'estremark', '')) : ''; ?></textarea>
            </div>
            <div class="col-md-4 mb-2">
              <label class="form-label small fw-semibold">Sign off Date</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? _np_fmt(_np_val($r, 'signoffdt', '')) : '-'; ?>">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Sign off remarks</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'signoffremark_name')) : '-'; ?>">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Status</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'status')) : '-'; ?>">
            </div>
            <div class="col-md-6 mb-2">
              <label class="form-label small fw-semibold">Next Vessel</label>
              <input type="text" class="form-control form-control-sm bg-light" readonly value="<?php echo $r ? htmlspecialchars(_np_val($r, 'next_vessel_name') !== '-' ? _np_val($r, 'next_vessel_name') : _np_val($r, 'next_vessel')) : '-'; ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.next-plan-detail-content .card.border { border-color: #dee2e6 !important; }
.next-plan-detail-content .form-label.small { font-size: 0.875rem; }
</style>
