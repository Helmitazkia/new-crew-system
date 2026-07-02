<div class="next-content">
  <div class="container-fluid mb-4">
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
      .column-search {
        width: 100%;
        padding: 6px 8px;
        box-sizing: border-box;
        font-size: 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: #f8f9fa;
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
        font-style: italic;
      }

      /* BADGE STATUS */
      .badge-status {
        font-size: 11px;
        padding: 4px 8px;
      }

      /* LINK NAME - hitam, cursor tangan (untuk Next Plan) */
      .next-plan-name {
        font-weight: 600;
        color: #000;
        text-decoration: none;
        cursor: pointer;
      }

      .next-plan-name:hover {
        text-decoration: underline;
        color: #333;
      }
      .batch-toggle {
        cursor: pointer;
        min-width: 22px;
        font-weight: bold;
        user-select: none;
      }
      .batch-toggle:hover {
        opacity: 0.8;
      }
    </style>

  
    <div class="card shadow-sm">
      <div class="card-body p-3">
        <div class="table-responsive">
          <table id="nextPlanHistoryTable" class="table table-sm table-bordered align-middle mb-0 crew-table" style="width:100%">
            <thead class="crew-header">
              <tr>
                <td colspan="6" class="text-center fw-bold" style="background-color:#000099; color:#fff;">ONBOARD</td>
                <td colspan="9" class="text-center fw-bold" style="background-color:#000099; color:#fff;">REPLACEMENT</td>
              </tr>
              <tr>
                <th class="text-center">No</th>
                <th class="text-center">Batch</th>
                <th class="text-center">Type</th>
                <th>Name</th>
                <th class="text-center">Rank</th>
                <th>Vessel</th>
                <th class="text-center">S/ON</th>
                <th class="text-center">S/OFF Plan</th>
                <th class="text-center">Remark</th>
                <th class="text-center">Remarks Cancel</th>
                <th class="text-center">Rank</th>
                <th>Name</th>
                <th class="text-center">Status</th>
                <th>Next Vessel</th>
                <th class="text-center" style="background-color: #000099 !important;">Act</th>
              </tr>
            </thead>
            <thead>
              <tr>
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
                <th><input type="text" class="column-search" placeholder="Search"></th>
                <th><input type="text" class="column-search" placeholder="Search"></th>
                <th><input type="text" class="column-search" placeholder="Search"></th>
                <th></th>
              </tr>
            </thead>
            <tbody></tbody>
              <!-- <tfoot>
                <tr>
                  <td colspan="3" class="text-center fw-bold" style="background-color:#000099; color:#fff;">ONBOARD</td>
                  <td colspan="10" class="text-center fw-bold" style="background-color:#000099; color:#fff;">REPLACEMENT</td>
                </tr>
              </tfoot> -->
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal Next Plan Detail (View Only) -->
<div class="modal fade" id="modalNextPlanDetail" tabindex="-1" aria-labelledby="modalNextPlanDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="modalNextPlanDetailLabel">Next Plan – Detail</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mb-0 pb-8 pt-2" id="modalNextPlanDetailBody">
        <div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>
      </div>
    </div>
  </div>
</div>

<script>
var baseUrlNextPlan = "<?php echo base_url('CrewDetail/NextPlan'); ?>";

window.showNextPlanDetail = function(idcrewrotation) {
  if (!idcrewrotation) return;
  $('#modalNextPlanDetail').modal('show');
  $('#modalNextPlanDetailBody').html('<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
  $.ajax({
    url: baseUrlNextPlan + '/detail',
    type: 'GET',
    data: { idcrewrotation: idcrewrotation },
    success: function(html) {
      $('#modalNextPlanDetailBody').html(html);
    },
    error: function() {
      $('#modalNextPlanDetailBody').html('<div class="alert alert-danger">Gagal memuat detail</div>');
    }
  });
};

  $(document).ready(function () {
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
      $('#nextPlanHistoryTable').closest('.card-body').html('<p class="text-muted p-3">idperson not found. Open this tab from Crew Detail.</p>');
      return;
    }
    var baseUrl = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";
    var collapsedBatches = {};
    var BATCH_COL_INDEX = 1;
    var TOTAL_COLUMNS = 15;
    var table = $('#nextPlanHistoryTable').DataTable({
      serverSide: false,
      ajax: {
        url: baseUrl + '/getHistoryByPerson',
        type: 'GET',
        data: { idperson: idperson },
        dataSrc: function (json) {
          var data = json.success ? json.data : [];
          var batchHasJoined = {};
          data.forEach(function (r) {
            var bid = (r.batch_id || '').toString();
            if (r.status === 'Joined') batchHasJoined[bid] = true;
          });
          data.forEach(function (r) {
            r._batchHasJoined = batchHasJoined[(r.batch_id || '').toString()] || false;
          });
          return data;
        }
      },
      columns: [
        {
          data: null,
          className: 'text-center',
          orderable: false,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          }
        },
        { data: 'batch_id', className: 'text-center', defaultContent: '-', render: function (d) { return d || '-'; } },
        { 
          data: 'status_crew_change', 
          className: 'text-center', 
          defaultContent: '-',
          render: function(d) {
            var val = d ? d : 'Change';
            var c = val === 'New'  ? 'bg-success'  : val === 'Down' ? 'bg-danger' : 'bg-primary';
            return '<span class="badge ' + c + ' badge-status">' + val + '</span>';
          }
        },
        {
          data: 'onboard_name',
          defaultContent: '-',
          render: function (data, type, row) {
            var name = data || '-';
            return name !== '-' ? name : '-';
          }
        },
        { data: 'replacement_rank', className: 'text-center', defaultContent: '-' },
        { data: 'onboard_vessel', defaultContent: '-' },
        { data: 'onboard_son', className: 'text-center', defaultContent: '-' },
        { data: 'onboard_soff', className: 'text-center', defaultContent: '-' },
        { data: 'remark', className: 'text-center', defaultContent: '-' },
        { data: 'remarks_cancel', className: 'text-center', defaultContent: '-' },
        { data: 'onboard_rank', className: 'text-center', defaultContent: '-' },
        { data: 'replacement_name', defaultContent: '-' },
        {
          data: 'status',
          className: 'text-center',
          render: function (data, type, row) {
            if (row._batchHasJoined && data !== 'Joined') {
              return  '<span class="badge bg-dark badge-status">Delete</span>';
            }
            var c = 'bg-secondary';
            var label = '';
            if (data === 'Submit') {
              c = 'bg-success';
              label = 'Planned';
            } else if (data === 'Cancel') {
              c = 'bg-danger';
              label = 'Cancelled';
            } else if (row.status_crew_change == "Down") {
              c = 'bg-warning text-dark';
              label = 'Down';
            } else if (data === 'Joined') {
              c = 'bg-primary';
              label = 'Joined';
            }
            return '<span class="badge ' + c + ' badge-status">' + label + '</span>';
          }
        },
        { data: 'next_vessel', defaultContent: '-' },
        {
          data: null,
          className: 'text-center',
          orderable: false,
          render: function (data, type, row) {
            return '<button type="button" class="btn btn-sm btn-outline-primary" onclick="showNextPlanDetail(' + (row.idcrewrotation || 0) + ')" title="View Detail"><i class="fa fa-eye"></i></button>';
          }
        }
      ],
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50],
      language: {
        lengthMenu: ' _MENU_ &nbsp; Entries',
        search: 'Search:',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'No records'
      },
      order: [[1, 'desc'],],
      createdRow: function (row, data) {
        $(row).attr('data-batch-id', (data.batch_id || '').toString());
      },
      drawCallback: function () {
        var api = this.api();
        var data = api.rows({ page: 'current' }).data();
        var nodes = api.rows({ page: 'current' }).nodes();
        if (!data.length) return;
        var groups = [];
        var g = [];
        for (var i = 0; i < data.length; i++) {
          var bid = (data[i].batch_id || '').toString();
          if (g.length && g[0].batch_id !== bid) {
            groups.push(g);
            g = [];
          }
          g.push({ batch_id: bid, rowIndex: i, node: nodes[i] });
        }
        if (g.length) groups.push(g);
        groups.forEach(function (grp) {
          if (grp.length === 0) return;
          var first = grp[0];
          var firstNode = first.node;
          var firstCells = firstNode.getElementsByTagName('td');
          if (firstCells.length <= BATCH_COL_INDEX) return;
          var batchTd = firstCells[BATCH_COL_INDEX];
          var isCollapsed = collapsedBatches[first.batch_id];
          var j;
          for (j = 0; j < grp.length; j++) {
            var rowCells = grp[j].node.getElementsByTagName('td');
            if (rowCells.length > BATCH_COL_INDEX) {
              rowCells[BATCH_COL_INDEX].style.display = '';
            }
          }
          if (isCollapsed) {
            for (j = 1; j < grp.length; j++) {
              grp[j].node.style.display = 'none';
            }
            batchTd.rowSpan = 1;
            batchTd.innerHTML = (first.batch_id || '-') + ' <button type="button" class="btn btn-sm btn-link p-0 batch-toggle" data-batch="' + (first.batch_id || '').replace(/"/g, '&quot;') + '" title="Expand">+</button>';
          } else {
            for (j = 0; j < grp.length; j++) {
              grp[j].node.style.display = '';
            }
            batchTd.rowSpan = grp.length;
            batchTd.innerHTML = (first.batch_id || '-') + ' <button type="button" class="btn btn-sm btn-link p-0 batch-toggle" data-batch="' + (first.batch_id || '').replace(/"/g, '&quot;') + '" title="Collapse">−</button>';
            for (j = 1; j < grp.length; j++) {
              var rowCells = grp[j].node.getElementsByTagName('td');
              if (rowCells.length > BATCH_COL_INDEX) {
                rowCells[BATCH_COL_INDEX].style.display = 'none';
                rowCells[BATCH_COL_INDEX].innerHTML = '';
              }
            }
          }
        });
        $('#nextPlanHistoryTable').off('click.batchToggle').on('click.batchToggle', '.batch-toggle', function (e) {
          e.preventDefault();
          e.stopPropagation();
          var batch = $(this).data('batch');
          if (!batch) return;
          collapsedBatches[batch] = !collapsedBatches[batch];
          table.draw(false);
        });
      }
    });

      // Column Search - AMBIL ROW SEARCH TERAKHIR
      $('#nextPlanHistoryTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
          if (table.column(i).search() !== this.value) {
            table
              .column(i)
              .search(this.value)
              .draw();
          }
        });
      });

    $('#btnCloseNextPlan').on('click', function () {
      $('#nextPlanVesselCard').addClass('d-none');
    });
  });
</script>