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

      /* LINK NAME */
      .crew-name {
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
      }

      .crew-name:hover {
        text-decoration: underline;
      }
    </style>

  
    <div class="card shadow-sm">
      <div class="card-body p-3">
        <div class="table-responsive">
          <table id="nextPlanHistoryTable" class="table table-sm table-bordered align-middle mb-0 crew-table" style="width:100%">
            <thead class="crew-header">
              <tr>
                <th class="text-center">No</th>
                <th>Name</th>
                <th class="text-center">Rank</th>
                <th class="text-center">S/ON</th>
                <th>Vessel</th>
                <th class="text-center">S/OFF Plan</th>
                <th class="text-center">Remark</th>
                <th class="text-center">Repl. Rank</th>
                <th>Repl. Name</th>
                <th class="text-center">Status</th>
                <th>Next Vessel</th>
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
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  $(document).ready(function () {
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
      $('#nextPlanHistoryTable').closest('.card-body').html('<p class="text-muted p-3">idperson not found. Open this tab from Crew Detail.</p>');
      return;
    }
    var baseUrl = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";
    var table = $('#nextPlanHistoryTable').DataTable({
      serverSide: false,
      ajax: {
        url: baseUrl + '/getHistoryByPerson',
        type: 'GET',
        data: { idperson: idperson },
        dataSrc: function (json) {
          return json.success ? json.data : [];
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
        { data: 'onboard_name', defaultContent: '-' },
        { data: 'onboard_rank', className: 'text-center', defaultContent: '-' },
        { data: 'onboard_son', className: 'text-center', defaultContent: '-' },
        { data: 'onboard_vessel', defaultContent: '-' },
        { data: 'onboard_soff', className: 'text-center', defaultContent: '-' },
        { data: 'remark', className: 'text-center', defaultContent: '-' },
        { data: 'replacement_rank', className: 'text-center', defaultContent: '-' },
        { data: 'replacement_name', defaultContent: '-' },
        {
          data: 'status',
          className: 'text-center',
          render: function (data) {
            var c = 'bg-secondary';
            if (data === 'Submit') c = 'bg-success';
            else if (data === 'Cancel') c = 'bg-danger';
            else if (data === 'Joined') c = 'bg-primary';
            return '<span class="badge ' + c + ' badge-status">' + (data || '') + '</span>';
          }
        },
        { data: 'next_vessel', defaultContent: '-' }
      ],
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50],
      language: {
        lengthMenu: ' _MENU_ &nbsp; Entries',
        search: 'Search:',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'No records'
      },
      order: [[2, 'desc']]
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