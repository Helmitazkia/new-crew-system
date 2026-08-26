<div class="row">
    <div class="col-xl-6 col-lg-6">
        <!-- ============================================================
     SECTION 1: FAMILIARIZATION MODULE
     ============================================================ -->
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div
                class="card-header bg-white border-bottom-0 pt-4 pb-2 d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="fw-bold m-0" style="color: #334155;">
                    <i class="fa fa-file-text-o me-2" style="color: #3b82f6;"></i> Familiarization Overview
                </h5>
                <button class="btn btn-sm btn-light border-0 shadow-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFamiliarization" aria-expanded="true"
                    aria-controls="collapseFamiliarization">
                    <i class="fa fa-chevron-down"></i>
                </button>
            </div>

            <div id="collapseFamiliarization" class="collapse show">
                <div class="card-body bg-light rounded-bottom-4" style="padding: 1.5rem;">

                    <!-- Filter Section -->
                    <div class="row mb-4 bg-white p-3 shadow-sm mx-0"
                        style="border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small"><i class="fa fa-calendar me-1"></i>
                                Rentang Tanggal</label>
                            <input type="text" class="form-control form-control-sm border-0 bg-light"
                                id="fam_daterange" placeholder="Pilih Rentang Tanggal">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-muted small"><i class="fa fa-ship me-1"></i>
                                Vessel</label>
                            <select class="form-control selectpicker border-0 bg-light" data-live-search="true"
                                data-size="6" id="fam_vessel_filter">
                                <option value="">Semua Vessel</option>
                                <?php if(isset($vessels)) { 
                            foreach($vessels as $v) { ?>
                                <option value="<?php echo $v->nmvsl; ?>"><?php echo $v->nmvsl; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-sm btn-primary w-100 shadow-sm rounded-3" id="btnFilterFam"
                                style="background-color: #000999; border: none; padding: 0.4rem 1rem;">
                                <i class="fa fa-filter me-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>

                    <!-- KPI Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100"
                                style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1"
                                                style="color: #64748b;">Total Requests</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;"
                                                id="kpi_fam_batches">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #e2e8f0;"><i class="fa fa-files-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-primary border-0 rounded-bottom-4 p-1"
                                    style="opacity: 0.8;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100"
                                style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1"
                                                style="color: #64748b;">Total Crew</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;" id="kpi_fam_crew">0
                                            </div>
                                        </div>
                                        <div class="fs-1" style="color: #e2e8f0;"><i class="fa fa-users"></i></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-info border-0 rounded-bottom-4 p-1"
                                    style="opacity: 0.8;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100"
                                style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1"
                                                style="color: #64748b;">Completed</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;"
                                                id="kpi_fam_completed">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #e2e8f0;"><i class="fa fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-success border-0 rounded-bottom-4 p-1"
                                    style="opacity: 0.8;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100"
                                style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1"
                                                style="color: #64748b;">Pending</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;"
                                                id="kpi_fam_pending">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #000099;"><i class="fa fa-hourglass-end"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-warning border-0 rounded-bottom-4 p-1"
                                    style="opacity: 0.8;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="row">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-sm border-0 h-100 rounded-4">
                                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                                    <h6 class="m-0 fw-bold text-muted">Trend Familiarization (Bulanan)</h6>
                                </div>
                                <div class="card-body p-4">
                                    <canvas id="chartFamTrend" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm border-0 h-100 rounded-4">
                                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                                    <h6 class="m-0 fw-bold text-muted">Status Completion</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center p-4">
                                    <canvas id="chartFamStatus" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                                    <h6 class="m-0 fw-bold text-muted">Distribusi Crew per Vessel</h6>
                                </div>
                                <div class="card-body p-4">
                                    <canvas id="chartFamVessel" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ============================================================
     SECTION 2: MODULE LAIN (Contoh placeholder)
     ============================================================ -->
        <div class="card shadow-sm border-0 mb-4 rounded-4" style="opacity: 0.6; background-color: #f1f5f9;">
            <div
                class="card-header bg-transparent border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0 text-muted">
                    <i class="fa fa-plus-square-o me-2"></i> Modul Lainnya (Segera Hadir)
                </h5>
                <button class="btn btn-sm btn-light border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOther" aria-expanded="false" aria-controls="collapseOther">
                    <i class="fa fa-chevron-down"></i>
                </button>
            </div>
            <div id="collapseOther" class="collapse">
                <div class="card-body text-center py-5">
                    <p class="text-muted">Section ini disiapkan untuk dashboard dari modul lain di masa mendatang.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var BASE_URL_DASHBOARD = '<?php echo base_url('Dashboard'); ?>';
    var famTrendChart, famStatusChart, famVesselChart;

    function createGradient(ctx, colorStart, colorEnd) {
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    }
    
    function animateValue(id, start, end, duration) {
        if (start === end) return;
        var obj = document.getElementById(id);
        var range = end - start;
        var minTimer = 50;
        var stepTime = Math.abs(Math.floor(duration / range));
        stepTime = Math.max(stepTime, minTimer);
        var startTime = new Date().getTime();
        var endTime = startTime + duration;
        var timer;

        function run() {
            var now = new Date().getTime();
            var remaining = Math.max((endTime - now) / duration, 0);
            var value = Math.round(end - (remaining * range));
            obj.innerHTML = value;
            if (value == end) {
                clearInterval(timer);
            }
        }
        timer = setInterval(run, stepTime);
        run();
    }

    $('#fam_daterange').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Clear', format: 'YYYY-MM-DD' }
    });
    $('#fam_daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#fam_daterange').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    function loadFamiliarizationData() {
        var vessel = $('#fam_vessel_filter').val();
        var dr = $('#fam_daterange').val();
        var date_start = '';
        var date_end = '';

        if (dr) {
            var parts = dr.split(' - ');
            date_start = parts[0];
            date_end = parts[1];
        }

        $('#btnFilterFam').html('<i class="fa fa-spinner fa-spin me-1"></i> Loading...');
        $('#btnFilterFam').prop('disabled', true);

        $.ajax({
            url: BASE_URL_DASHBOARD + '/get_familiarization_stats',
            type: 'POST',
            data: {
                vessel: vessel,
                date_start: date_start,
                date_end: date_end
            },
            dataType: 'json',
            success: function (res) {
                $('#btnFilterFam').html('<i class="fa fa-filter me-1"></i> Terapkan Filter');
                $('#btnFilterFam').prop('disabled', false);

                if (res.success) {
                    animateValue("kpi_fam_batches", parseInt($('#kpi_fam_batches').text()), res.summary.total_batches, 500);
                    animateValue("kpi_fam_crew", parseInt($('#kpi_fam_crew').text()), res.summary.total_crew, 500);
                    animateValue("kpi_fam_completed", parseInt($('#kpi_fam_completed').text()), res.summary.completed, 500);
                    animateValue("kpi_fam_pending", parseInt($('#kpi_fam_pending').text()), res.summary.pending, 500);
                    updateCharts(res.charts, res.summary);
                }
            },
            error: function () {
                $('#btnFilterFam').html('<i class="fa fa-filter me-1"></i> Terapkan Filter');
                $('#btnFilterFam').prop('disabled', false);
                alert("Gagal memuat data Dashboard.");
            }
        });
    }

    function updateCharts(chartsData, summary) {
        var ctxTrend = document.getElementById('chartFamTrend').getContext('2d');
        if (famTrendChart) famTrendChart.destroy();
        var gradientTrend = createGradient(ctxTrend, 'rgba(59, 130, 246, 0.4)', 'rgba(59, 130, 246, 0.0)');
        famTrendChart = new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: chartsData.trend.labels,
                datasets: [{
                    label: 'Requests',
                    data: chartsData.trend.data,
                    backgroundColor: gradientTrend,
                    borderColor: '#0ea5e9',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#0ea5e9',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)' }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                },
                layout: { padding: { top: 25 } }
            },
            plugins: [{
                id: 'dataLabels',
                afterDatasetsDraw: function (chart) {
                    var ctx = chart.ctx;
                    chart.data.datasets.forEach(function (dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function (element, index) {
                                ctx.fillStyle = '#0ea5e9';
                                ctx.font = "bold 12px Inter";
                                var dataString = dataset.data[index].toString();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                var position = element.tooltipPosition();
                                ctx.fillText(dataString, position.x, position.y - 18);
                            });
                        }
                    });
                }
            }]
        });

        var ctxStatus = document.getElementById('chartFamStatus').getContext('2d');
        if (famStatusChart) famStatusChart.destroy();
        famStatusChart = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [summary.completed, summary.pending],
                    backgroundColor: ['#22c55e', '#f59e0b'],
                    hoverBackgroundColor: ['#16a34a', '#d97706'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: 'Inter', size: 12 } } },
                    tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)' }
                }
            },
            plugins: [{
                id: 'textCenter',
                beforeDraw: function (chart) {
                    var width = chart.width, height = chart.height, ctx = chart.ctx;
                    ctx.restore();
                    var fontSize = (height / 114).toFixed(2);
                    ctx.font = "bold " + fontSize + "em Inter";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#1e293b";
                    var text = summary.completed + summary.pending,
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2 - 10;
                    ctx.fillText(text, textX, textY);
                    ctx.save();
                    ctx.font = "normal " + (fontSize / 2.5).toFixed(2) + "em Inter";
                    ctx.fillStyle = "#64748b";
                    var text2 = "Total",
                        text2X = Math.round((width - ctx.measureText(text2).width) / 2),
                        text2Y = height / 2 + 15;
                    ctx.fillText(text2, text2X, text2Y);
                    ctx.save();
                }
            }]
        });

        var ctxVessel = document.getElementById('chartFamVessel').getContext('2d');
        if (famVesselChart) famVesselChart.destroy();
        famVesselChart = new Chart(ctxVessel, {
            type: 'bar',
            data: {
                labels: chartsData.vessel.labels,
                datasets: [{
                    label: 'Crew',
                    data: chartsData.vessel.data,
                    backgroundColor: '#0ea5e9',
                    hoverBackgroundColor: '#0284c7',
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 } }
                }
            }
        });
    }

    $('#btnFilterFam').on('click', function () {
        loadFamiliarizationData();
    });

    loadFamiliarizationData();
});
</script>
