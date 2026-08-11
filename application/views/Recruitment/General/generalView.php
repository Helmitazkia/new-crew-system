<style>
.chart-wrapper {
    overflow: hidden;
    transition:
        max-height .5s cubic-bezier(.4, 0, .2, 1),
        opacity .35s ease,
        transform .35s ease;
    will-change: max-height, opacity, transform;
}

.chart-wrapper.hide {
    max-height: 0;
    opacity: 0;
    transform: translateY(-10px);
    pointer-events: none;
}

.chart-wrapper.show {
    max-height: 1200px;
    opacity: 1;
    transform: translateY(0);
}


.chart-box {
    position: relative;
    background: linear-gradient(180deg,
            #ffffff 0%,
            #fafbfc 100%);
    border-radius: 20px;
    padding: 26px 26px 22px;
    min-height: 400px;

    /* ultra-soft shadow */
    box-shadow:
        0 1px 2px rgba(0, 0, 0, .04),
        0 8px 24px rgba(0, 0, 0, .06);

    border: 1px solid rgba(0, 0, 0, .04);

    transition:
        box-shadow .35s ease,
        transform .35s ease,
        border-color .35s ease;
}

/* subtle hover — enterprise style */
.chart-box:hover {
    transform: translateY(-3px);
    box-shadow:
        0 4px 8px rgba(0, 0, 0, .05),
        0 16px 40px rgba(0, 0, 0, .08);
    border-color: rgba(0, 0, 0, .06);
}


.chart-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 24px;
    right: 24px;
    height: 3px;
    border-radius: 0 0 6px 6px;
    background: linear-gradient(90deg,
            #2563eb,
            #6366f1);
    opacity: .9;
}

#newApplicantChartContainer,
#talentPoolChartContainer {
    width: 100%;
    min-height: 360px;
}

#chartStack .row {
    margin-left: 0;
    margin-right: 0;
}

.kpi-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 16px;
    width: 3px;
    height: calc(100% - 32px);
    background: #0F172A;
    opacity: 0.08;
    border-radius: 2px;
}

.kpi-card {
    position: relative;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 22px;
    border: 1px solid #E6EAF0;

    box-shadow:
        0 1px 2px rgba(15, 23, 42, 0.04),
        0 6px 18px rgba(15, 23, 42, 0.06);

    transition:
        box-shadow .25s ease,
        transform .25s ease,
        border-color .25s ease;
}

.kpi-card:hover {
    transform: translateY(-2px);
    border-color: #CBD5E1;
    box-shadow:
        0 2px 4px rgba(15, 23, 42, 0.06),
        0 10px 26px rgba(15, 23, 42, 0.10);
}

.kpi-title {
    font-size: 11px;
    font-weight: 600;
    color: #000000;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.kpi-value {
    font-size: 32px;
    font-weight: 700;
    color: #0F172A;
    margin-top: 6px;
    line-height: 1.15;
}

.kpi-sub {
    font-size: 12px;
    color: #000000;
    margin-top: 4px;
}


.kpi-muted {
    background: #FAFAFB;
    border-color: #E5E7EB;
}

.kpi-muted .kpi-value {
    font-size: 26px;
    font-weight: 600;
    color: #334155;
}

.kpi-section-header {
    padding-left: 2px;
}

.kpi-section-title {
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    letter-spacing: -0.01em;
}

.kpi-section-sub {
    font-size: 13px;
    color: #64748B;
    margin-top: 2px;
}
</style>

<script>
$(document).ready(function() {
    loadDefaultCharts();
    loadRankCheckbox();
    loadFunnelChart();
});

$(document).ready(function() {

    const bulanMap = {
        '01': 'Januari',
        '02': 'Februari',
        '03': 'Maret',
        '04': 'April',
        '05': 'Mei',
        '06': 'Juni',
        '07': 'Juli',
        '08': 'Agustus',
        '09': 'September',
        '10': 'Oktober',
        '11': 'November',
        '12': 'Desember'
    };


    const categoriesX = Array.from({
            length: 31
        },
        function(value, index) {
            return String(index + 1);
        }
    );


    const monthlyData = {};

    let bulanSekarangKey = '';


    let chartSubmitCV = null;


    function convertMonthValueToKey(monthValue) {

        if (!monthValue) {
            return '';
        }


        const dateParts = monthValue.split('-');


        if (dateParts.length !== 2) {
            return '';
        }


        const year = dateParts[0];

        const month = dateParts[1];


        if (!bulanMap[month]) {
            return '';
        }


        return bulanMap[month] + ' ' + year;

    }


    $('#selectBulan')
        .off('change.submitCV')
        .on('change.submitCV', function() {

            const selectedValue = $(this).val();


            const bulanKey =
                convertMonthValueToKey(
                    selectedValue
                );


            if (!bulanKey) {
                return;
            }

            bulanSekarangKey = bulanKey;


            tampilkanBulan(
                bulanKey
            );

        });


    $.ajax({

        url: "<?php echo base_url('generalTotalSubmitted'); ?>",

        method: "GET",

        dataType: "json",


        success: function(response) {

            const data = Array.isArray(response) ?
                response : [];



            data.forEach(function(item) {

                if (
                    !item ||
                    !item.tanggal
                ) {
                    return;
                }


                const tanggal =
                    String(item.tanggal)
                    .split('-');


                if (
                    tanggal.length < 3
                ) {
                    return;
                }


                const year = tanggal[0];

                const month = tanggal[1];

                const day = parseInt(
                    tanggal[2],
                    10
                );


                if (
                    !bulanMap[month]
                ) {
                    return;
                }


                if (
                    isNaN(day) ||
                    day < 1 ||
                    day > 31
                ) {
                    return;
                }


                const bulanKey =
                    bulanMap[month] +
                    ' ' +
                    year;

                if (
                    !Array.isArray(
                        monthlyData[bulanKey]
                    )
                ) {

                    monthlyData[bulanKey] =
                        Array(31).fill(0);

                }


                const jumlah =
                    parseInt(
                        item.jumlah,
                        10
                    );


                monthlyData[bulanKey][day - 1] =
                    isNaN(jumlah) ?
                    0 :
                    jumlah;

            });

            const now = new Date();


            const yearNow =
                now.getFullYear();


            const monthNow =
                String(
                    now.getMonth() + 1
                ).padStart(
                    2,
                    '0'
                );


            const monthInputValue =
                yearNow +
                '-' +
                monthNow;


            bulanSekarangKey =
                convertMonthValueToKey(
                    monthInputValue
                );


            // Isi input bulan
            $('#selectBulan').val(
                monthInputValue
            );



            tampilkanBulan(
                bulanSekarangKey
            );

        },


        error: function(
            xhr,
            status,
            error
        ) {

            console.error(
                'Gagal mengambil data submit CV:',
                error
            );


            $('#totalSubmitCV').html(

                '<div class="alert alert-danger">' +
                'Gagal mengambil data submit CV.' +
                '</div>'

            );

        }

    });

    $('#listCrewNewModal')
        .off('shown.bs.modal.submitCV')
        .on(
            'shown.bs.modal.submitCV',
            function() {
                const selectedValue =
                    $('#selectBulan').val();


                const bulanKey =
                    convertMonthValueToKey(
                        selectedValue
                    );


                if (bulanKey) {

                    bulanSekarangKey =
                        bulanKey;


                    tampilkanBulan(
                        bulanKey
                    );

                } else {

                    $('#totalSubmitCV').html(

                        '<div class="alert alert-warning">' +
                        'Silakan pilih bulan terlebih dahulu.' +
                        '</div>'

                    );

                }

            }
        );

    function tampilkanBulan(
        bulanKey
    ) {

        if (!bulanKey) {

            renderChartKosong(
                'Bulan belum dipilih'
            );

            return;

        }
        renderChart(
            bulanKey
        );

    }


    function renderChart(
        bulanKey
    ) {

        let data =
            monthlyData[bulanKey];


        if (
            !Array.isArray(data)
        ) {

            data =
                Array(31).fill(0);

        }


        data =
            data.slice(
                0,
                31
            );


        while (
            data.length < 31
        ) {

            data.push(0);

        }


        data =
            data.map(
                function(value) {

                    const numberValue =
                        parseInt(
                            value,
                            10
                        );


                    return isNaN(
                            numberValue
                        ) ?
                        0 :
                        numberValue;

                }
            );

        const total =
            data.reduce(
                function(
                    accumulator,
                    value
                ) {

                    return (
                        accumulator +
                        value
                    );

                },
                0
            );

        if (
            chartSubmitCV &&
            !chartSubmitCV.destroyed
        ) {

            chartSubmitCV.destroy();

            chartSubmitCV = null;

        }

        chartSubmitCV =
            Highcharts.chart(

                'totalSubmitCV',

                {

                    chart: {

                        type: 'line',

                        backgroundColor: '#ffffff',

                        animation: {

                            duration: 800

                        }

                    },

                    title: {

                        useHTML: true,

                        text:

                            'Submit CV - ' +

                            bulanKey +

                            '<br>' +

                            '<span style="' +

                            'font-size:16px;' +

                            'color:#333333;' +

                            '">' +

                            'Total: ' +

                            '<b>' +

                            total +

                            '</b>' +

                            '</span>',


                        style: {

                            color: '#000000',

                            fontSize: '1.5em'

                        }

                    },


                    legend: {

                        enabled: false

                    },

                    xAxis: {

                        categories: categoriesX,


                        title: {

                            text: 'Tanggal Dalam Bulan',


                            style: {

                                color: '#000000',

                                fontSize: '1.2em'

                            }

                        }

                    },

                    yAxis: {

                        min: 0,


                        allowDecimals: false,


                        title: {

                            text: 'Jumlah Submit CV',


                            style: {

                                color: '#000000',

                                fontSize: '1.2em'

                            }

                        }

                    },

                    tooltip: {

                        enabled: false

                    },

                    plotOptions: {

                        series: {

                            animation: {

                                duration: 1200,

                                defer: 100

                            },


                            marker: {

                                enabled: true,


                                radius: 5,


                                fillColor: '#007bff',


                                states: {

                                    hover: {

                                        enabled: true,


                                        radius: 7

                                    }

                                }

                            },


                            dataLabels: {

                                enabled: true,


                                formatter: function() {

                                    return (
                                            this.y > 0
                                        )

                                        ?
                                        this.y

                                        :
                                        '';

                                },


                                style: {

                                    color: '#000000',


                                    fontSize: '10px',


                                    textOutline: 'none'

                                }

                            }

                        }

                    },

                    series: [

                        {

                            name: bulanKey,


                            data: data,


                            color: '#007bff',


                            lineWidth: 3

                        }

                    ],

                    credits: {

                        enabled: false

                    },

                    exporting: {

                        enabled: false

                    }

                }

            );

    }

    function renderChartKosong(
        bulanKey
    ) {

        // Hapus chart lama
        if (
            chartSubmitCV &&
            !chartSubmitCV.destroyed
        ) {

            chartSubmitCV.destroy();

            chartSubmitCV = null;

        }


        chartSubmitCV =
            Highcharts.chart(

                'totalSubmitCV',

                {

                    chart: {

                        type: 'line',

                        backgroundColor: '#ffffff'

                    },


                    title: {

                        text:

                            'Submit CV - ' +

                            bulanKey +

                            ' (tidak ada data)'

                    },


                    xAxis: {

                        categories: categoriesX,


                        title: {

                            text: 'Tanggal Dalam Bulan'

                        }

                    },


                    yAxis: {

                        min: 0,


                        allowDecimals: false,


                        title: {

                            text: 'Jumlah Submit CV'

                        }

                    },


                    tooltip: {

                        enabled: false

                    },


                    legend: {

                        enabled: false

                    },


                    series: [

                        {

                            name: bulanKey,


                            data:

                                Array(31)
                                .fill(0),


                            color: '#000000',


                            dataLabels: {

                                enabled: false

                            }

                        }

                    ],


                    credits: {

                        enabled: false

                    }


                }

            );

    }


});

function loadDefaultCharts() {
    $('#newApplicantChartContainer').html('Loading...');
    $('#talentPoolChartContainer').html('Loading...');

    $.ajax({
        url: '<?php echo base_url("generalData") ?>',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            renderKPICards(data);
            renderApplicantPieChart(data);
            renderTalentPoolPieChart(data);
        }
    });
}

function getEnterprisePieBaseConfig() {
    return {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent',
            height: 550,
            style: {
                fontFamily: 'Inter, Segoe UI, Roboto, Arial'
            }
        },
        colors: [
            '#2563EB',
            '#10B981',
            '#F59E0B',
            '#EF4444',
            '#6366F1',
            '#14B8A6',
            '#8B5CF6',
            '#64748B'
        ],
        credits: {
            enabled: false
        },
        tooltip: {
            borderRadius: 10,
            shadow: true
        }
    };
}

function calcPipelineTotal(item) {
    return (
        (item.qualified || 0) +
        (item.pickup || 0) +
        (item.not_position || 0) +
        (item.not_qualified_total || 0) +
        (item.not_reference_total || 0) +
        (item.interview || 0) +
        (item.mcu || 0)
    );
}

function renderApplicantPieChart(data) {

    const normalized = data
        .map(item => ({
            name: item.name,
            y: Number(item.y)
        }))
        .filter(i => i.y > 0);

    const grandTotal = normalized.reduce((s, i) => s + i.y, 0);
    const baseConfig = getEnterprisePieBaseConfig();

    const chart = Highcharts.chart(
        'newApplicantChartContainer',
        Highcharts.merge(baseConfig, {

            title: {
                text: 'New Applicants Pipeline',
                align: 'left',
                style: {
                    fontSize: '18px',
                    fontWeight: 600,
                    color: '#1f2937'
                }
            },

            subtitle: {
                text: 'Distribution by position',
                align: 'left',
                style: {
                    fontSize: '13px',
                    color: '#1f2937'
                }
            },

            plotOptions: {
                pie: {
                    innerSize: '62%',
                    size: '95%',
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br>' +
                            '{point.y} applicants ({point.percentage:.1f}%)',
                        style: {
                            fontSize: '12px',
                            textOutline: 'none'
                        }
                    }
                }
            },

            tooltip: {
                headerFormat: '<b>{point.name}</b><br>',
                pointFormat: 'Total: <b>{point.y}</b>'
            },

            series: [{
                data: data.map(item => ({
                    name: item.name,
                    y: item.qualified +
                        item.pickup +
                        item.not_position +
                        item.not_qualified_total +
                        item.not_reference_total +
                        item.not_qualified_experience +
                        item.not_qualified_certificate +
                        item.not_qualified_interview +
                        item.interview +
                        item.mcu
                }))
            }]
        })
    );

    chart.renderer
        .label(
            `<div style="text-align:center">
                <div style="font-size:26px;font-weight:700">${grandTotal}</div>
                <div style="font-size:13px;color:#64748B">Total Applicants</div>
            </div>`,
            chart.plotLeft + chart.plotWidth / 2 - 60,
            chart.plotTop + chart.plotHeight / 2 - 35,
            null,
            null,
            null,
            true
        )
        .add();
}

function renderTalentPoolPieChart(data) {

    const filtered = data.map(item => {
        item.pipelineTotal =
            (item.qualified || 0) +
            (item.pickup || 0) +
            (item.not_position || 0) +
            (item.not_qualified_total || 0) +
            (item.not_reference_total || 0) +
            (item.interview || 0) +
            (item.mcu || 0) +
            (item.not_qualified_experience || 0) +
            (item.not_qualified_certificate || 0) +
            (item.not_qualified_interview || 0);
        return item;
    }).filter(i => i.pipelineTotal > 0);

    const baseConfig = getEnterprisePieBaseConfig();
    const seriesData = [];
    const drilldownSeries = [];

    filtered.forEach(item => {

        seriesData.push({
            name: item.name,
            y: item.pipelineTotal,
            drilldown: item.name
        });

        drilldownSeries.push({
            id: item.name,
            name: `${item.name} – Status Breakdown`,
            data: [
                ['Qualified', item.qualified],
                ['Pick Up', item.pickup],
                ['Interview', item.interview],
                ['MCU', item.mcu],
                ['No Position', item.not_position],
                ['Not Qualified', item.not_qualified_total],
                ['Not Qualified - Experience', item.not_qualified_experience],
                ['Not Qualified - Certificate', item.not_qualified_certificate],
                ['Not Qualified - Interview', item.not_qualified_interview],
                ['Not Reference', item.not_reference_total]
            ].filter(d => d[1] > 0)
        });
    });

    Highcharts.chart(
        'talentPoolChartContainer',
        Highcharts.merge(baseConfig, {

            title: {
                text: 'Talent Pool Pipeline',
                align: 'left',
                style: {
                    fontSize: '18px',
                    fontWeight: 600,
                    color: '#1f2937'
                }
            },

            subtitle: {
                text: 'Click slice to view pipeline detail',
                align: 'left',
                style: {
                    fontSize: '13px',
                    color: '#1f2937'
                }
            },

            plotOptions: {
                pie: {
                    innerSize: '60%',
                    size: '95%',
                    dataLabels: {
                        enabled: true,
                        distance: 28,
                        connectorWidth: 1.2,
                        connectorColor: '#CBD5E1',
                        format: '<b>{point.name}</b><br>' +
                            '{point.y} ({point.percentage:.1f}%)',
                        style: {
                            fontSize: '12px',
                            color: '#334155',
                            textOutline: 'none'
                        }
                    }
                }
            },

            series: [{
                name: 'Applicants',
                data: seriesData
            }],

            drilldown: {
                series: drilldownSeries,
                breadcrumbs: {
                    position: {
                        align: 'left'
                    }
                }
            }
        })
    );
}

function renderKPICards(data) {

    let totalApplicants = 0;
    let pipelineTotal = 0;

    let qualifiedTotal = 0;
    let pickupTotal = 0;
    let interviewMCUTotal = 0;
    let notPositionTotal = 0;
    let notReferenceTotal = 0;
    let notQualifiedTotal = 0;

    let notQualifiedExperienceTotal = 0;
    let notQualifiedCertificateTotal = 0;
    let notQualifiedInterviewTotal = 0;

    data.forEach(item => {

        totalApplicants += item.y || 0;

        const pipeline =
            (item.qualified || 0) +
            (item.pickup || 0) +
            (item.not_position || 0) +
            (item.not_qualified_total || 0) +
            (item.not_reference_total || 0) +
            (item.interview || 0) +
            (item.mcu || 0);

        pipelineTotal += pipeline;

        qualifiedTotal += item.qualified || 0;
        pickupTotal += item.pickup || 0;
        interviewMCUTotal +=
            (item.interview || 0) +
            (item.mcu || 0);

        notPositionTotal += item.not_position || 0;
        notReferenceTotal += item.not_reference_total || 0;
        notQualifiedTotal += item.not_qualified_total || 0;

        notQualifiedExperienceTotal += item.not_qualified_experience || 0;
        notQualifiedCertificateTotal += item.not_qualified_certificate || 0;
        notQualifiedInterviewTotal += item.not_qualified_interview || 0;
    });

    $('#kpiTotalApplicants').text(totalApplicants.toLocaleString());
    $('#kpiPipeline').text(pipelineTotal.toLocaleString());
    $('#kpiQualified').text(qualifiedTotal.toLocaleString());
    $('#kpiInterviewMCU').text(interviewMCUTotal.toLocaleString());
    $('#kpiNotQualified').text(notQualifiedTotal.toLocaleString());
    $('#kpiPickup').text(pickupTotal.toLocaleString());
    $('#kpiNotPosition').text(notPositionTotal.toLocaleString());
    $('#kpiNotReference').text(notReferenceTotal.toLocaleString());
}

function loadRankCheckbox() {

    const container = $('#checkboxRankContainer');
    container.html('<div style="font-size:12px;color:#9ca3af;">Loading rank...</div>');

    $.ajax({
        url: '<?php echo base_url("generalRankList"); ?>',
        method: 'GET',
        dataType: 'json',
        success: function(data) {

            if (!data || data.length === 0) {
                container.html('<div style="font-size:12px;color:#9ca3af;">No rank available</div>');
                return;
            }

            let html = '';

            data.forEach(item => {
                html += `
                    <label style="
                        display:flex;
                        align-items:center;
                        gap:8px;
                        font-size:12px;
                        padding:6px 4px;
                        cursor:pointer;
                    ">
                        <input type="checkbox"
                               name="rank[]"
                               value="${item.id}">
                        <span>${item.name}</span>
                    </label>
                `;
            });

            container.html(html);
        },
        error: function() {
            container.html('<div style="font-size:12px;color:#ef4444;">Failed to load rank</div>');
        }
    });
}

function getCheckedValues(name) {
    return $(`input[name="${name}[]"]:checked`)
        .map(function() {
            return this.value;
        })
        .get();
}

function applyTopFourFilter() {

    const filters = {
        ranks: getCheckedValues('rank'),
        vessels: getCheckedValues('vessel'),
        date_start: $('#selectTanggalTopFourStart').val(),
        date_end: $('#selectTanggalTopFourEnd').val()
    };

    const hasFilter =
        filters.ranks.length ||
        filters.vessels.length ||
        filters.date_start ||
        filters.date_end;

    if (!hasFilter) return;

    $('#newApplicantWrapper')
        .removeClass('show')
        .addClass('hide');

    $('#chartStack').prepend($('#talentPoolWrapper'));
    $('#resetTopFourFilterBtn').fadeIn(200);

    $('#talentPoolChartContainer').html('Loading...');

    $.ajax({
        url: '<?php echo base_url("DataFilter"); ?>',
        method: 'POST',
        data: filters,
        dataType: 'json',
        success: function(data) {
            renderTalentPoolPieChart(data);
        }
    });
}

function resetTopFourFilter() {

    $('input[type=checkbox]').prop('checked', false);
    $('input[type=date]').val('');

    // 1. Kembalikan posisi chart
    $('#chartStack').append($('#talentPoolWrapper'));

    // 2. Munculkan New Applicant
    $('#newApplicantWrapper')
        .removeClass('hide')
        .addClass('show');

    // 3. Hide reset button
    $('#resetTopFourFilterBtn').fadeOut(150);

    // 4. Reload default
    loadDefaultCharts();
}

function cleanTimestamp(val) {
    if (!val || val === '-') return '-';

    let arr = val.split('#');
    return arr.length > 1 ? arr[1] : val;
}

function showAlerts(res) {
    let alerts = [];

    if (res.aging_applicants > 3) {
        alerts.push("🔥 Applicants stuck > 3 hari");
    }

    if (res.aging_qualified > res.sla_qualified) {
        alerts.push("⚠️ Qualified over SLA");
    }

    if (res.aging_interview > res.sla_interview) {
        alerts.push("⚠️ Interview over SLA");
    }

    if (res.aging_mcu > res.sla_mcu) {
        alerts.push("⚠️ MCU over SLA");
    }

    if (res.bottleneck_value > 2) {
        alerts.push(`🚨 Bottleneck di ${res.bottleneck_stage}`);
    }

    let html = alerts.length ?
        alerts.map(a => `<div style="color:red;font-weight:600">${a}</div>`).join('') :
        `<div style="color:green;font-weight:600">✅ Semua aman</div>`;

    $('#alertBox').html(html);
}

function getBarColor(stage, bottleneck) {
    return stage === bottleneck ? '#ff4d4f' : '#1890ff';
}

// function loadFunnelChart() {
//     $.ajax({
//         url: "<?php echo base_url('funnelChart') ?>",
//         type: "GET",
//         dataType: "json",
//         success: function(res) {

//             showAlerts(res);

//             Highcharts.chart('mainChart', {
//                 chart: {
//                     type: 'funnel',
//                     height: 1000,
//                     spacingTop: 20,
//                     spacingBottom: 20
//                 },

//                 title: {
//                     text: 'Recruitment Funnel Overview'
//                 },

//                 subtitle: {
//                     text: 'SLA Recruitment'
//                 },

//                 tooltip: {
//                     pointFormat: '<b>{point.name}</b><br>' +
//                         'Candidates: {point.y}<br>' +
//                         'SLA: {point.sla} hari<br>' +
//                         'Aging: {point.aging} hari<br>'
//                 },

//                 plotOptions: {
//                     series: {
//                         center: ['50%', '54%'],
//                         width: '38%',
//                         neckWidth: '14%',
//                         height: '88%',
//                         neckHeight: '24%',
//                         borderWidth: 1,

//                         dataLabels: {
//                             enabled: true,
//                             softConnector: true,
//                             distance: 22,
//                             allowOverlap: false,
//                             style: {
//                                 fontSize: '11px',
//                                 fontWeight: '500',
//                                 textOutline: 'none'
//                             },
//                             format: '<b>{point.name}</b><br>' +
//                                 '{point.y} cand<br>' +
//                                 'SLA {point.sla}d | Aging {point.aging}d'
//                         }
//                     }
//                 },
//                 series: [{
//                     name: 'Recruitment',
//                     data: [{
//                             name: 'Applicants',
//                             y: res.applicants,
//                             sla: 0,
//                             aging: res.aging_applicants,
//                             last: cleanTimestamp(res.last_applicants),
//                             color: getBarColor('Applicants', res.bottleneck_stage)
//                         },
//                         {
//                             name: 'Qualified',
//                             y: res.qualified,
//                             sla: res.sla_qualified,
//                             aging: res.aging_qualified,
//                             last: cleanTimestamp(res.last_qualified),
//                             color: getBarColor('Qualified', res.bottleneck_stage)
//                         }

//                     ]
//                 }]
//             });
//         }
//     });
// }

function loadFunnelChart() {
    $.ajax({
        url: "<?php echo base_url('funnelChart') ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {

            let data = [{
                    title: 'All Applicants',
                    value: res.applicants
                },
                {
                    title: 'Qualified Certificate',
                    value: res.qualified_certificate
                },
                {
                    title: 'Qualified Experience',
                    value: res.qualified_experience
                },
                {
                    title: 'Interview',
                    value: res.qualified_interview
                },
                {
                    title: 'MCU',
                    value: res.mcu
                },
                {
                    title: 'Onboarded',
                    value: res.onboard
                }
            ];

            let html = `<div style="text-align:center; font-family:Arial;">`;

            data.forEach((item, i) => {
                html += buildItem(
                    item.title,
                    item.value,
                    (100 - (i * 15)) + '%',
                    (32 - (i * 3)) + 'px',
                    i + 1
                );
            });

            html += `</div>`;

            $('#mainChart').html(html);

            animateFunnel();
        }
    });
}


/* =========================
GRADIENT
========================= */
function getGradient(level) {
    const gradients = {
        1: 'linear-gradient(90deg, #667eea, #764ba2)',
        2: 'linear-gradient(90deg, #5a8dee, #6fc3ff)',
        3: 'linear-gradient(90deg, #42e695, #3bb2b8)',
        4: 'linear-gradient(90deg, #f6d365, #fda085)',
        5: 'linear-gradient(90deg, #ff9a9e, #fecfef)',
        6: 'linear-gradient(90deg, #d4fc79, #96e6a1)'
    };
    return gradients[level];
}


/* =========================
BUILD ITEM (NO PERCENT)
========================= */
function buildItem(title, value, width, fontSize, level) {
    return `
            <div class="funnel-item" style="
                margin:25px auto;
                opacity:0;
                transform:translateY(-50px);
                transition:all 0.6s ease;
                width:${width};
                font-size:${fontSize};
            ">
                
                <div style="
                    padding:12px;
                    border-radius:20px;
                    background:#f5f5f5;
                    position:relative;
                    overflow:hidden;
                ">

                    <!-- PROGRESS BAR (PURE VISUAL) -->
                    <div class="progress-bar" style="
                        position:absolute;
                        top:0;
                        left:0;
                        height:100%;
                        width:0%;
                        background:${getGradient(level)};
                        transition:width 1.2s ease;
                        border-radius:20px;
                    "></div>

                    <!-- CONTENT -->
                    <div style="position:relative; z-index:2;">
                        <div style="font-weight:500;">${title}</div>
                        <div class="counter" data-target="${value}" style="font-weight:bold;">0</div>
                    </div>

                </div>
            </div>
        `;
}


/* =========================
ANIMATION
========================= */
function animateFunnel() {
    $('.funnel-item').each(function(index) {
        let el = $(this);

        setTimeout(function() {
            el.css({
                opacity: 1,
                transform: 'translateY(0)'
            });

            // 🔥 progress selalu full (100%)
            let bar = el.find('.progress-bar');

            setTimeout(() => {
                bar.css('width', '100%');
            }, 200);

            // counter tetap jalan
            animateCounter(el.find('.counter'));

        }, index * 500);
    });
}


/* =========================
COUNTER
========================= */
function animateCounter(el) {
    let target = parseInt(el.attr('data-target')) || 0;
    let duration = 1200;
    let stepTime = 20;
    let steps = duration / stepTime;
    let increment = target / steps;

    let current = 0;

    let timer = setInterval(function() {
        current += increment;

        if (current >= target) {
            current = target;
            clearInterval(timer);
        }

        el.text(Math.floor(current).toLocaleString());
    }, stepTime);
}
</script>
<div class="row" style="margin:15px 5px 25px 5px;">

    <div class="col-md-3">
        <div style="
        background:#ffffff;
        border-radius:16px;
        padding:20px;
        min-height:650px;
        box-shadow:0 8px 24px rgba(0,0,0,.08);
        border:1px solid #eaeaea;
    ">

            <div style="
            font-size:17px;
            font-weight:600;
            color:#1f2937;
            margin-bottom:22px;
            text-align:center;
            letter-spacing:.3px;
        ">
                Explore Applicant
            </div>

            <div style="margin-bottom:20px;">
                <div style="
                    font-size:13px;
                    font-weight:600;
                    color:#374151;
                    margin-bottom:8px;
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                ">
                    <span>Select Rank</span>
                    <span style="font-size:11px;color:#9ca3af;">▼</span>
                </div>

                <div id="checkboxRankContainer" style="
                    background:#f9fafb;
                    border:1px solid #e5e7eb;
                    border-radius:10px;
                    padding:10px;
                    max-height:160px;
                    overflow-y:auto;
                ">
                    <div style="font-size:12px;color:#9ca3af;">Loading rank...</div>
                </div>
            </div>
            <div style="margin-bottom:20px;">
                <div style="
                font-size:13px;
                font-weight:600;
                color:#374151;
                margin-bottom:8px;
                display:flex;
                justify-content:space-between;
                align-items:center;
            ">
                    <span>Select Vessel</span>
                    <span style="font-size:11px;color:#9ca3af;">▼</span>
                </div>

                <div id="checkboxVesselContainer" style="
                    background:#f9fafb;
                    border:1px solid #e5e7eb;
                    border-radius:10px;
                    padding:10px;
                    max-height:180px;
                    overflow-y:auto;
                ">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="BULK CARRIER"
                            id="vesselBulk">
                        <label class="form-check-label" for="vesselBulk">BULK CARRIER</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="CARGO" id="vesselCargo">
                        <label class="form-check-label" for="vesselCargo">CARGO</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="GENERAL CARGO"
                            id="vesselGeneral">
                        <label class="form-check-label" for="vesselGeneral">GENERAL CARGO</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="CONTAINER"
                            id="vesselContainer">
                        <label class="form-check-label" for="vesselContainer">CONTAINER</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="TANKER PRODUCT"
                            id="vesselTP">
                        <label class="form-check-label" for="vesselTP">TANKER PRODUCT</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="TANKER OIL"
                            id="vesselTO">
                        <label class="form-check-label" for="vesselTO">TANKER OIL</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="CRUDE OIL" id="vesselCO">
                        <label class="form-check-label" for="vesselCO">CRUDE OIL</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="TANKER CHEMICAL"
                            id="vesselTC">
                        <label class="form-check-label" for="vesselTC">TANKER CHEMICAL</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="TANKER GAS"
                            id="vesselTG">
                        <label class="form-check-label" for="vesselTG">TANKER GAS</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="FLOATING CRANE"
                            id="vesselFC">
                        <label class="form-check-label" for="vesselFC">FLOATING CRANE</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="TUG BOAT" id="vesselTB">
                        <label class="form-check-label" for="vesselTB">TUG BOAT</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="SUPPLY VESSEL"
                            id="vesselSV">
                        <label class="form-check-label" for="vesselSV">SUPPLY VESSEL</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="CREW BOAT" id="vesselCB">
                        <label class="form-check-label" for="vesselCB">CREW BOAT</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="vessel[]" value="RORO/PASSENGER"
                            id="vesselRORO">
                        <label class="form-check-label" for="vesselRORO">RORO/PASSENGER</label>
                    </div>
                </div>
            </div>

            <div style="margin-bottom:25px;">
                <div style="
                font-size:13px;
                font-weight:600;
                color:#374151;
                margin-bottom:8px;
                display:flex;
                justify-content:space-between;
                align-items:center;
            ">
                    <span>Filter By Date</span>
                    <span style="font-size:11px;color:#9ca3af;">▼</span>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:11px;color:#6b7280;">From</label>
                    <input type="date" id="selectTanggalTopFourStart" placeholder="yyyy-mm-dd" style="
                        width:100%;
                        border:1px solid #e5e7eb;
                        padding:8px 10px;
                        border-radius:8px;
                        outline:none;
                        background:#fff;
                    ">
                </div>

                <div>
                    <label style="font-size:11px;color:#6b7280;">To</label>
                    <input type="date" id="selectTanggalTopFourEnd" placeholder="yyyy-mm-dd" style="
                        width:100%;
                        border:1px solid #e5e7eb;
                        padding:8px 10px;
                        border-radius:8px;
                        outline:none;
                        background:#fff;
                    ">
                </div>
            </div>

            <div style="margin-bottom:25px;">
                <div style="font-size:13px;
                font-weight:600;
                color:#374151;
                margin-bottom:8px;
                display:flex;
                justify-content:space-between;
                align-items:center;">
                    <span>Filter By Info Source</span>
                </div>

            </div>

            <div>
                <button style="
                    width:100%;
                    padding:10px;
                    border-radius:10px;
                    border:none;
                    font-weight:600;
                    background:#2563eb;
                    color:#fff;
                    box-shadow:0 4px 12px rgba(37,99,235,.25);
                " onclick="applyTopFourFilter();">
                    Apply Filter
                </button>

                <button style="
                    width:100%;
                    padding:8px;
                    margin-top:8px;
                    border-radius:10px;
                    border:1px solid #e5e7eb;
                    background:#fff;
                    color:#374151;
                    font-size:12px;
                    display:none;
                " onclick="resetTopFourFilter();" id="resetTopFourFilterBtn">
                    Reset
                </button>
            </div>

        </div>
    </div>

    <div class="col-12 col-md-9">

        <div class="row pt-2">
            <div class="col-12">
                <input type="month" id="selectBulan" class="form-control" style="max-width: 220px;">

                <!-- <button id="btnSearchBulan" class="btn btn-primary ms-2">
                    Search
                </button> -->
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div id="totalSubmitCV" style="min-height:400px;"></div>
            </div>
        </div>

        <hr style="margin-top:20px; margin-bottom:20px; color:#000000;">

        <div class="row mt-4 mb-2">
            <div class="col-12">
                <div class="kpi-section-header">
                    <div class="kpi-section-title">Recruitment Overview</div>
                    <div class="kpi-section-sub">High-level applicant pipeline status</div>
                </div>
            </div>
        </div>

        <div class="row mt-3">

            <!-- KPI CARDS
            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h6>Total Applicants</h6>
                    <h3 id="kpi_applicants">0</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h6>Total Hired</h6>
                    <h3 id="kpi_hired">0</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h6>Conversion Rate</h6>
                    <h3 id="kpi_conversion">0%</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h6>Bottleneck</h6>
                    <h5 id="kpi_bottleneck">-</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm p-3">
                    <h6>Productivity</h6>
                    <h3 id="kpi_productivity">0</h3>
                </div>
            </div> -->

        </div>

        <!-- MAIN CHART -->
        <div class="row mt-3">
            <div class="col-12">
                <div id="mainChart" style="height:750px;"></div>
            </div>
        </div>

        <!-- AGING CHART
        <div class="row mt-3">
            <div class="col-12">
                <div id="agingChart" style="height:320px;"></div>
            </div>
        </div> -->

        <div id="chartStack">

            <!-- NEW APPLICANT -->
            <div id="newApplicantWrapper" class="chart-wrapper show">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="chart-box">
                            <div id="newApplicantChartContainer" style="width:100%; min-height:360px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TALENT POOL -->
            <div id="talentPoolWrapper" class="chart-wrapper show">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="chart-box">
                            <div id="talentPoolChartContainer" style="width:100%; min-height:360px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>