<div class="container-fluid content-wrapper">
  <div class="row mb-2 ms-2">
    <div class="col-12 d-flex align-items-center gap-2">

      <!-- TABS -->
      <div class="d-flex flex-wrap justify-content-center gap-2 main-tabs flex-grow-1">
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">
          <i class="fa fa-arrow-left"></i> Back
        </button>
        <button class="btn btn-primary rounded-pill px-3 active fst-italic fw-semibold">Profile</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Family</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Certificates</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Experience</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Education</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Contract</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Medical</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Next Plan</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Performance & Tranning</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">Competence</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">List Report</button>
      </div>

    </div>
  </div>

  <!-- RIBBON (KANAN, DI BAWAH TAB) -->
  <!-- <div class="crew-ribbon-wrapper">
    <div class="crew-ribbon-triangle">
      <span class="crew-id">(004059)</span>
      <span class="crew-name">Muhamad Helmi Tazkia</span>
    </div>
  </div> -->

  <hr>
</div>


<style>
  /* posisi kanan bawah tab */
.crew-ribbon-wrapper {
  display: flex;
  justify-content: flex-end;
  margin-right: 16px;
  margin-top: 6px;
}

/* main ribbon */
.crew-ribbon-triangle {
  position: relative;
  background: linear-gradient(135deg, #4b3cff, #6f5cff);
  color: #fff;
  padding: 6px 18px 6px 14px;
  font-size: 13px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border-radius: 16px 0 0 16px;
  white-space: nowrap;
}

/* segitiga kanan */
.crew-ribbon-triangle::after {
  content: '';
  position: absolute;
  right: -18px;
  top: 50%;
  transform: translateY(-50%);
  width: 0;
  height: 0;
  border-top: 14px solid transparent;
  border-bottom: 14px solid transparent;
  border-left: 18px solid #6f5cff;
}

/* text */
.crew-id {
  font-size: 12px;
  opacity: 0.85;
}

.crew-name {
  white-space: nowrap;
}

/* mobile */
@media (max-width: 576px) {
  .crew-ribbon-triangle {
    font-size: 11px;
    padding: 5px 14px 5px 10px;
  }
}

</style>


<script>

</script>