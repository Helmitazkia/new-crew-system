<div class="row mb-4">
    <div class="col-10">
        <!-- <h4 class="fw-bold mb-4" style="color: #1e293b;">
            <i class="fa fa-dashboard me-2 text-primary"></i> Dashboard System
        </h4> -->
        <!-- ============================================================
             SECTION: CREW ROTATION MODULE
             ============================================================ -->
        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-2 d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="fw-bold m-0" style="color: #334155;">
                    <i class="fa fa-refresh me-2" style="color: #8b5cf6;"></i> Crew Rotation Overview
                </h5>
                <button class="btn btn-sm btn-light border-0 shadow-sm" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseRotation" aria-expanded="true">
                    <i class="fa fa-chevron-down"></i>
                </button>
            </div>

            <div id="collapseRotation" class="collapse show">
                <div class="card-body bg-light rounded-bottom-4" style="padding: 1.5rem;">
                    <!-- Filter Section -->
                    <div class="row mb-4 bg-white p-3 shadow-sm mx-0" style="border-radius: 12px; border-left: 4px solid #8b5cf6;">
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small"><i class="fa fa-calendar me-1"></i> Rentang Tanggal</label>
                            <input type="text" class="form-control form-control-sm border-0 bg-light" id="rot_daterange" placeholder="Pilih Rentang Tanggal">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small"><i class="fa fa-ship me-1"></i> Vessel</label>
                            <select class="form-control selectpicker border-0 bg-light" data-live-search="true" data-size="6" id="rot_vessel_filter">
                                <option value="">Semua Vessel</option>
                                <?php if(isset($vessels)) { foreach($vessels as $v) { ?>
                                    <option value="<?php echo $v->kdvsl; ?>"><?php echo $v->nmvsl; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-muted small"><i class="fa fa-info-circle me-1"></i> Status</label>
                            <select class="form-control form-control-sm border-0 bg-light" id="rot_status_filter">
                                <option value="">Semua Status</option>
                                <option value="Planned">Planned</option>
                                <option value="Joined">Joined</option>
                                <option value="Sign Off">Sign Off</option>
                                <option value="Cancel">Cancel</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-sm btn-primary w-100 shadow-sm rounded-3" id="btnFilterRot" style="background-color: #000999; border: none; padding: 0.4rem 1rem;">
                                <i class="fa fa-filter me-1"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>

                    <!-- KPI Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1" style="color: #64748b;">Total Plans</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;" id="kpi_rot_plans">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #000099;"><i class="fa fa-share-square"></i></div>
                                    </div>
                                </div>
                                <div class="card-footer border-0 rounded-bottom-4 p-1" style="background-color: #64748b; opacity: 0.8;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1" style="color: #64748b;">Planned / Ready</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;" id="kpi_rot_ready">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #000099;"><i class="fa fa-paper-plane"></i></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-success border-0 rounded-bottom-4 p-1" style="opacity: 0.8;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1" style="color: #64748b;">Joined</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;" id="kpi_rot_joined">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #000099;"><i class="fa fa-ship"></i></div>
                                    </div>
                                </div>
                                <div class="card-footer bg-primary border-0 rounded-bottom-4 p-1" style="opacity: 0.8;"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs fw-bold text-uppercase mb-1" style="color: #64748b;">Sign Off / Cancel</div>
                                            <div class="h3 mb-0 fw-bold" style="color: #0f172a;" id="kpi_rot_cancel">0</div>
                                        </div>
                                        <div class="fs-1" style="color: #000099;"><i class="fa fa-ban"></i></div>
                                    </div>
                                </div>
                                <div class="card-footer border-0 rounded-bottom-4 p-1" style="background-color: #f59e0b; opacity: 0.8;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="row">
                        <div class="col-lg-5 mb-4">
                            <div class="card shadow-sm border-0 h-100 rounded-4">
                                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                                    <h6 class="m-0 fw-bold text-muted">Trend Rotasi (Bulanan)</h6>
                                </div>
                                <div class="card-body p-4">
                                    <canvas id="chartRotTrend" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-4">
                            <div class="card shadow-sm border-0 h-100 rounded-4">
                                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                                    <h6 class="m-0 fw-bold text-muted">Status Rotasi</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center align-items-center p-4">
                                    <canvas id="chartRotStatus" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm border-0 h-100 rounded-4">
                                <div class="card-header bg-white border-0 py-3 rounded-top-4">
                                    <h6 class="m-0 fw-bold text-muted">Distribusi per Vessel</h6>
                                </div>
                                <div class="card-body p-4">
                                    <canvas id="chartRotVessel" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    var BASE_URL_DASHBOARD = '<?php echo base_url('Dashboard'); ?>';
    var rotTrendChart, rotStatusChart, rotVesselChart;

    // Helper functions
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

    // Initialize Daterangepicker
    $('#rot_daterange').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Clear', format: 'YYYY-MM-DD' }
    });
    $('#rot_daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#rot_daterange').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });

    function loadRotationData() {
        var vessel = $('#rot_vessel_filter').val();
        var status = $('#rot_status_filter').val();
        var dr = $('#rot_daterange').val();
        var date_start = '';
        var date_end = '';

        if (dr) {
            var parts = dr.split(' - ');
            date_start = parts[0];
            date_end = parts[1];
        }

        $('#btnFilterRot').html('<i class="fa fa-spinner fa-spin me-1"></i> Loading...');
        $('#btnFilterRot').prop('disabled', true);

        $.ajax({
            url: BASE_URL_DASHBOARD + '/get_crew_rotation_stats',
            type: 'POST',
            data: {
                vessel: vessel,
                status: status,
                date_start: date_start,
                date_end: date_end
            },
            dataType: 'json',
            success: function (res) {
                $('#btnFilterRot').html('<i class="fa fa-filter me-1"></i> Terapkan Filter');
                $('#btnFilterRot').prop('disabled', false);

                if (res.success) {
                    animateValue("kpi_rot_plans", parseInt($('#kpi_rot_plans').text()), res.summary.total_plans, 500);
                    animateValue("kpi_rot_ready", parseInt($('#kpi_rot_ready').text()), res.summary.planned_ready, 500);
                    animateValue("kpi_rot_joined", parseInt($('#kpi_rot_joined').text()), res.summary.joined, 500);
                    animateValue("kpi_rot_cancel", parseInt($('#kpi_rot_cancel').text()), res.summary.signoff_cancel, 500);
                    updateRotCharts(res.charts, res.summary);
                }
            },
            error: function () {
                $('#btnFilterRot').html('<i class="fa fa-filter me-1"></i> Terapkan Filter');
                $('#btnFilterRot').prop('disabled', false);
                alert("Gagal memuat data Crew Rotation Dashboard.");
            }
        });
    }

    function updateRotCharts(chartsData, summary) {
        var ctxTrend = document.getElementById('chartRotTrend').getContext('2d');
        if (rotTrendChart) rotTrendChart.destroy();
        var gradTrend = createGradient(ctxTrend, 'rgba(139, 92, 246, 0.4)', 'rgba(139, 92, 246, 0.0)');
        rotTrendChart = new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: chartsData.trend.labels,
                datasets: [{
                    label: 'Plans',
                    data: chartsData.trend.data,
                    backgroundColor: gradTrend,
                    borderColor: '#8b5cf6',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#8b5cf6',
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
                                ctx.fillStyle = '#8b5cf6';
                                ctx.font = "bold 12px Inter";
                                var dataString = dataset.data[index].toString();
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                var pos = element.tooltipPosition();
                                ctx.fillText(dataString, pos.x, pos.y - 18);
                            });
                        }
                    });
                }
            }]
        });

        var ctxStatus = document.getElementById('chartRotStatus').getContext('2d');
        if (rotStatusChart) rotStatusChart.destroy();
        var bgColors = [];
        chartsData.status.labels.forEach(function(label) {
            if (label === 'Planned') bgColors.push('#22c55e');
            else if (label === 'Joined') bgColors.push('#3b82f6');
            else if (label === 'Sign Off') bgColors.push('#f59e0b');
            else if (label === 'Cancel') bgColors.push('#ef4444');
            else bgColors.push('#64748b');
        });
        rotStatusChart = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: chartsData.status.labels,
                datasets: [{
                    data: chartsData.status.data,
                    backgroundColor: bgColors,
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
                    var text = summary.total_plans,
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

        var ctxVessel = document.getElementById('chartRotVessel').getContext('2d');
        if (rotVesselChart) rotVesselChart.destroy();
        rotVesselChart = new Chart(ctxVessel, {
            type: 'bar',
            data: {
                labels: chartsData.vessel.labels,
                datasets: [{
                    label: 'Plans',
                    data: chartsData.vessel.data,
                    backgroundColor: '#8b5cf6',
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

    $('#btnFilterRot').on('click', function () {
        loadRotationData();
    });

    loadRotationData();
});
</script>
