<div class="crew-rotation-content">
  <div class="container-fluid">
    <style>
      /* ===============================
            GLOBAL TABLE STYLE – CREW PLAN
            =============================== */
      :root {
        --crew-blue: #000099;
        --crew-font-sm: 12px;
        --crew-font-xs: 11px;
      }

      /* TABLE BASE */
      .crew-table th,
      .crew-table td {
        font-size: var(--crew-font-sm);
        vertical-align: middle;
      }

      .crew-table th {
        font-weight: 600;
        text-align: center;
      }

      /* BUTTON INSIDE TABLE */
      .crew-table .btn {
        font-size: var(--crew-font-xs);
        padding: 2px 6px;
      }

      /* HEADER COLOR (BLUE) */
      .crew-header th {
        background-color: var(--crew-blue) !important;
        color: #fff !important;
      }

      /* HEADER GROUP (ONBOARD / REPLACEMENT) */
      .crew-header-group {
        background-color: var(--crew-blue) !important;
        color: #fff !important;
      }

      /* BADGE STATUS */
      .badge-status {
        font-size: 11px;
        padding: 4px 8px;
      }

      /* LINK NAME */
      .crew-name {
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
      }

      .crew-name:hover {
        text-decoration: underline;
      }

      /* DataTables Customization */
      .custom-btn {
        justify-content: flex-end;
      }

      .dataTables_wrapper {
        padding: 15px 0;
      }

      .dataTables_length {
        padding: 10px 0;
        margin-bottom: 10px;
      }

      .dataTables_length label,
      .dataTables_filter label {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 20px 0;
      }

      .dataTables_length select {
        width: auto;
        margin: 0 8px;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #ced4da;
      }

      .dataTables_filter {
        text-align: right;
        margin-bottom: 10px;
      }

      .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        margin: 0;
        padding: 8px 0;
        font-weight: normal;
      }

      .dataTables_filter input {
        margin-left: 10px;
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        width: 200px;
      }

      /* PAGINATION STYLING */
      .dataTables_paginate {
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
      }

      .paginate_button {
        margin: 0 2px;
        padding: 6px 12px !important;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        background: #fff !important;
        color: #0d6efd !important;
      }

      .paginate_button.current {
        background: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
      }

      .paginate_button:hover {
        background: #e9ecef !important;
        border-color: #dee2e6;
      }

      /* INFO TEXT STYLING */
      .dataTables_info {
        padding: 10px 0;
        color: #6c757d;
        font-size: 14px;
      }

      /* Baris search di bawah header (column search) */
      .crew-search-row {
        background: #f8f9fa !important;
      }
      .crew-search-row th {
        background: #f8f9fa !important;
        color: #495057 !important;
        padding: 6px 8px;
        vertical-align: middle;
      }
      .crew-search-row .column-search {
        width: 100%;
        max-width: 160px;
        margin: 0 auto;
        display: block;
      }

      /* Column Search Input */
      .column-search {
        padding: 6px 8px;
        box-sizing: border-box;
        font-size: 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: #fff;
      }

      /* Responsive Card */
      .card {
        margin-top: 20px;
        border-radius: 8px;
      }

      .card-header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .card-body {
        padding: 20px;
        overflow-x: auto;
      }

      /* Table responsive fixes */
      .table-responsive {
        margin: 0;
      }

      /* Custom layout for DataTables controls */
      .dataTables_wrapper .row {
        margin: 0;
      }

      .dataTables_wrapper .col-sm-12 {
        padding: 0;
      }

      /* Ensure proper spacing */
      .dt-length {
        float: left;
      }

      .dt-search {
        float: right;
      }

      .dt-info {
        float: left;
        margin-top: 10px;
      }

      .dt-paging {
        float: right;
        margin-top: 10px;
      }

      /* Clear floats */
      .dataTables_wrapper:after {
        content: "";
        display: table;
        clear: both;
      }
    </style>

    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th rowspan="2">No</th>
                    <th colspan="5" class="crew-header-group text-center">ONBOARD</th>
                    <th colspan="3" class="crew-header-group text-center">REPLACEMENT</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Next Vessel</th>
                    <th rowspan="2" class="text-center">Action</th>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>S/ON</th>
                    <th>Vessel</th>
                    <th>S/OFF Plan</th>
                    <th>Remark</th>
                    <th>Rank</th>
                    <th>Name</th>
                  </tr>
                  <tr class="crew-search-row">
                    <th></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Data akan diisi oleh DataTables -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Remarks Cancel -->
<div class="modal fade" id="modalRemarksCancel" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title">Remarks Cancel</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="remarksCancel_idcrewrotation">
        <label class="form-label fw-semibold">Remarks Cancel <span class="text-danger">*</span></label>
        <textarea class="form-control" id="remarksCancel_input" rows="4" placeholder="Alasan / keterangan cancel..."></textarea>
        <small id="remarksCancel_feedback" class="text-danger d-none">Remarks Cancel wajib diisi.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSubmitRemarksCancel">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  var baseUrlCrewRotation = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";

  function loadCrewRotationList() {
    $.ajax({
      url: baseUrlCrewRotation + "/ajaxCrewRotation",
      type: "GET",
      success: function (html) {
        $("#contentArea").html(html);
      },
      error: function () {
        alert("Gagal memuat Crew Rotation");
      }
    });
  }

  window.showCrewDetail = function (idcrewrotation) {
    $.ajax({
      url: baseUrlCrewRotation + "/detail",
      type: "GET",
      data: { idcrewrotation: idcrewrotation },
      success: function (html) {
        $("#contentArea").html(html);
      },
      error: function () {
        $("#contentArea").html('<div class="alert alert-danger">Gagal memuat detail</div>');
      }
    });
  };

  $(document).ready(function () {
    let table = $('#crewTable').DataTable({
      dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
      processing: true,
      serverSide: false,
      ajax: {
        url: baseUrlCrewRotation + "/getAllData_crewRotation",
        type: "GET",
        dataSrc: function (json) {
          return json.success ? json.data : [];
        }
      },
      columns: [
        {
          data: null,
          className: "text-center",
          orderable: false,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: "onboard_name",
          render: function (data, type, row) {
            var name = data || "-";
            return '<a href="#" class="crew-name" onclick="showCrewDetail(' + row.idcrewrotation + '); return false;">' + name + "</a>";
          }
        },
        { data: "onboard_rank", className: "text-center" },
        { data: "onboard_son", className: "text-center" },
        { data: "onboard_vessel" },
        { data: "onboard_soff", className: "text-center" },
        { data: "remark", className: "text-center" },
        { data: "replacement_rank", className: "text-center" },
        { data: "replacement_name" },
        {
          data: "status",
          className: "text-center",
          render: function (data) {
            var badgeClass = "bg-secondary";
            if (data === "Submit") badgeClass = "bg-success";
            else if (data === "Cancel") badgeClass = "bg-danger";
            else if (data === "Joined") badgeClass = "bg-primary";
            return '<span class="badge ' + badgeClass + ' badge-status">' + (data || "") + "</span>";
          }
        },
        { data: "next_vessel" },
        {
          data: null,
          orderable: false,
          searchable: false,
          className: "text-center",
          render: function (data, type, row) {
            var disabled = row.status === "Cancel" ? " disabled" : "";
            var statusOpt = '<select class="form-select form-select-sm d-inline-block w-auto status-select" data-id="' + row.idcrewrotation + '" data-current="' + (row.status || "") + '"' + disabled + '>' +
              '<option value="Submit"' + (row.status === "Submit" ? " selected" : "") + '>Submit</option>' +
              '<option value="Cancel"' + (row.status === "Cancel" ? " selected" : "") + '>Cancel</option>' +
              '<option value="Joined"' + (row.status === "Joined" ? " selected" : "") + '>Joined</option></select>';
            return '<div class="d-flex gap-1 justify-content-center flex-wrap">' +
              '<button type="button" class="btn btn-sm btn-outline-primary" onclick="showCrewDetail(' + row.idcrewrotation + ')" title="Detail"><i class="fa fa-eye"></i></button>' +
              statusOpt +
              '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-rotation" data-id="' + row.idcrewrotation + '" title="Delete"><i class="fa fa-trash"></i></button></div>';
          }
        }
      ],
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        lengthMenu: " _MENU_ &nbsp; Entries",
        search: "",
        paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" },
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries"
      },
      order: [[1, "asc"]],
      initComplete: function () {
        $(".dataTables_info").css({ padding: "10px 0", color: "#6c757d", "font-size": "14px" });
        $(".custom-btn").html(
          '<button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewCrewRotation">' +
          '<i class="fa fa-plus"></i> New</button>'
        );
      }
    });

    $(document).on("change", ".status-select", function (e) {
      var $sel = $(this);
      var id = $sel.data("id");
      var currentStatus = $sel.data("current");
      var newStatus = $sel.val();
      if (currentStatus === "Cancel") {
        e.preventDefault();
        e.stopPropagation();
        $sel.val("Cancel");
        if (typeof Swal !== "undefined") {
          Swal.fire({ icon: "info", title: "Tidak dapat diubah", text: "Status sudah Cancel. Harus buat data baru." });
        } else {
          alert("Status sudah Cancel. Harus buat data baru.");
        }
        return false;
      }
      if (currentStatus === "Joined" && newStatus === "Submit") {
        e.preventDefault();
        e.stopPropagation();
        $sel.val("Joined");
        if (typeof Swal !== "undefined") {
          Swal.fire({
            icon: "warning",
            title: "Tidak dapat diubah",
            text: "Dari Joined tidak bisa kembali ke Submit. Data sudah masuk ke Contract. Hanya bisa di-Cancel jika dibatalkan."
          });
        } else {
          alert("Dari Joined tidak bisa kembali ke Submit. Hanya bisa di-Cancel.");
        }
        return false;
      }
      if (newStatus === "Cancel") {
        e.preventDefault();
        e.stopPropagation();
        if (typeof Swal !== "undefined") {
          Swal.fire({
            icon: "question",
            title: "Ubah ke Cancel?",
            text: "Anda yakin akan mengubah status menjadi Cancel?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
          }).then(function (result) {
            if (result.isConfirmed) {
              $("#remarksCancel_idcrewrotation").val(id);
              $("#remarksCancel_input").val("");
              $("#remarksCancel_feedback").addClass("d-none");
              $("#modalRemarksCancel").modal("show");
            } else {
              $sel.val(currentStatus);
            }
          });
        } else {
          if (confirm("Ubah ke Cancel? Jika Yes, isi Remarks Cancel.")) {
            $("#remarksCancel_idcrewrotation").val(id);
            $("#remarksCancel_input").val("");
            $("#remarksCancel_feedback").addClass("d-none");
            $("#modalRemarksCancel").modal("show");
          } else {
            $sel.val(currentStatus);
          }
        }
        return false;
      }
      $.post(baseUrlCrewRotation + "/updateStatus", { idcrewrotation: id, status: newStatus })
        .done(function (res) {
          var r = typeof res === "string" ? JSON.parse(res) : res;
          if (r.status) {
            table.ajax.reload(null, false);
            if (typeof Swal !== "undefined") Swal.fire({ icon: "success", title: "Berhasil", text: r.message });
            else alert(r.message);
          } else {
            if (typeof Swal !== "undefined") Swal.fire({ icon: "error", title: "Error", text: r.message || "Update failed" });
            else alert(r.message || "Update failed");
            $sel.val(currentStatus);
          }
        })
        .fail(function () {
          if (typeof Swal !== "undefined") Swal.fire({ icon: "error", title: "Error", text: "Request failed" });
          else alert("Request failed");
          $sel.val(currentStatus);
        });
    });

    $("#btnSubmitRemarksCancel").on("click", function () {
      var id = $("#remarksCancel_idcrewrotation").val();
      var remaks = $("#remarksCancel_input").val().trim();
      if (!remaks) {
        $("#remarksCancel_feedback").removeClass("d-none");
        return false;
      }
      $("#remarksCancel_feedback").addClass("d-none");
      $.post(baseUrlCrewRotation + "/updateStatus", { idcrewrotation: id, status: "Cancel", remaks_cancel: remaks })
        .done(function (res) {
          var r = typeof res === "string" ? JSON.parse(res) : res;
          $("#modalRemarksCancel").modal("hide");
          if (r.status) {
            table.ajax.reload(null, false);
            if (typeof Swal !== "undefined") Swal.fire({ icon: "success", title: "Berhasil", text: r.message });
            else alert(r.message);
          } else {
            if (typeof Swal !== "undefined") Swal.fire({ icon: "error", title: "Error", text: r.message || "Update failed" });
            else alert(r.message || "Update failed");
          }
        })
        .fail(function () {
          $("#modalRemarksCancel").modal("hide");
          if (typeof Swal !== "undefined") Swal.fire({ icon: "error", title: "Error", text: "Request failed" });
          else alert("Request failed");
        });
    });

    $(document).on("click", ".btn-delete-rotation", function (e) {
      e.preventDefault();
      var id = $(this).data("id");
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "warning",
          title: "Hapus data?",
          text: "Yakin akan menghapus crew rotation ini?",
          showCancelButton: true,
          confirmButtonText: "Yes, Hapus",
          cancelButtonText: "Cancel",
          confirmButtonColor: "#d33"
        }).then(function (result) {
          if (result.isConfirmed) {
            $.post(baseUrlCrewRotation + "/delete_crewRotation", { idcrewrotation: id })
              .done(function (res) {
                var r = typeof res === "string" ? JSON.parse(res) : res;
                if (r.status) {
                  table.ajax.reload(null, false);
                  Swal.fire({ icon: "success", title: "Terhapus", text: r.message || "Data berhasil dihapus." });
                } else {
                  Swal.fire({ icon: "error", title: "Gagal", text: r.message || "Delete failed" });
                }
              })
              .fail(function () {
                Swal.fire({ icon: "error", title: "Error", text: "Request failed" });
              });
          }
        });
      } else {
        if (!confirm("Delete this crew rotation record?")) return false;
        $.post(baseUrlCrewRotation + "/delete_crewRotation", { idcrewrotation: id })
          .done(function (res) {
            var r = typeof res === "string" ? JSON.parse(res) : res;
            if (r.status) {
              table.ajax.reload(null, false);
            } else {
              alert(r.message || "Delete failed");
            }
          })
          .fail(function () {
            alert("Request failed");
          });
      }
    });

    $(document).on("click", "#btnNewCrewRotation", function () {
      $.ajax({
        url: baseUrlCrewRotation + "/detail",
        type: "GET",
        success: function (html) {
          $("#contentArea").html(html);
        },
        error: function () {
          alert("Gagal memuat form");
        }
      });
    });

    // Column search (baris search di bawah header)
    $("#crewTable thead tr.crew-search-row th").each(function (i) {
      var $input = $(this).find("input.column-search");
      if (!$input.length) return;
      $input.on("keyup change", function () {
        if (table.column(i).search() !== this.value) {
          table.column(i).search(this.value).draw();
        }
      });
    });

  });
</script>