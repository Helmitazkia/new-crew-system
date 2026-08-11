<style>
/* ===== CONTAINER ===== */
.sap-menu-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    padding: 14px 18px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
    flex-wrap: wrap;
}

/* ===== GROUP ===== */
.sap-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.sap-group-title {
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .6px;
}

/* ===== TAB WRAPPER ===== */
.sap-tabs {
    display: flex;
    gap: 6px;
    background: #f3f4f6;
    padding: 6px;
    border-radius: 12px;
}

/* ===== TAB BUTTON ===== */
.sap-tab {
    padding: 8px 16px;
    border-radius: 8px;
    background: transparent;
    color: #374151;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s ease;
    border: 1px solid transparent;
}

/* Hover */
.sap-tab:hover {
    background: #e0e7ff;
    color: #1e3a8a;
    transform: translateY(-1px);
}

/* Active */
.sap-tab.active {
    background: #1e3a8a;
    color: #fff;
    box-shadow: 0 4px 12px rgba(30, 58, 138, .25);
}

/* ===== DIVIDER ===== */
.sap-divider {
    width: 1px;
    height: 46px;
    background: linear-gradient(to bottom, transparent, #d1d5db, transparent);
}

/* ===== PIPELINE SPECIAL ===== */
.sap-tab-pipeline {
    background: #eef2ff;
    color: #1e40af;
    border: 1px solid #c7d2fe;
}

.sap-tab-pipeline:hover {
    background: #dbeafe;
}

.sap-tab-pipeline.active {
    background: #1e3a8a;
    color: #fff;
    border-color: #1e3a8a;
}

/* ===== OPTIONAL BADGE ===== */
.sap-badge {
    background: #1e3a8a;
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 6px;
    margin-left: 6px;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 576px) {
    .sap-menu-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .sap-divider {
        display: none;
    }
}
</style>

<div class="container-fluid content-wrapper">
    <div class="row mb-3 ms-2 justify-content-center">
        <div class="col-12">

            <div class="sap-menu-container">

                <!-- ================= LEFT: RECRUITMENT PROCESS ================= -->
                <div class="sap-group">
                    <div class="sap-group-title">Recruitment Process</div>

                    <div class="sap-tabs">

                        <a href="<?php echo base_url('general') ?>"
                            class="sap-tab <?php echo ($active_submenu == 'sub_general_recruitment') ? 'active' : '' ?>">
                            General
                        </a>

                        <a href="<?php echo base_url('newApplicant') ?>"
                            class="sap-tab <?php echo ($active_submenu == 'new_applicant') ? 'active' : '' ?>">
                            New Applicant
                        </a>

                        <a href="<?php echo base_url('qualifyApplicant') ?>"
                            class="sap-tab <?php echo ($active_submenu == 'qualify_applicant') ? 'active' : '' ?>">
                            Qualify
                        </a>

                        <a href="<?php echo base_url('interviewApplicant') ?>"
                            class="sap-tab <?php echo ($active_submenu == 'interview_applicant') ? 'active' : '' ?>">
                            Interview
                        </a>

                        <a href="<?php echo base_url('mcuApplicant') ?>"
                            class="sap-tab <?php echo ($active_submenu == 'mcu_applicant') ? 'active' : '' ?>">
                            MCU
                        </a>

                    </div>
                </div>

                <!-- ================= DIVIDER ================= -->
                <div class="sap-divider"></div>

                <!-- ================= RIGHT: PIPELINE ================= -->
                <div class="sap-group">
                    <div class="sap-group-title">Monitoring</div>

                    <div class="sap-tabs">

                        <a href="<?php echo base_url('pipelineApplicant') ?>"
                            class="sap-tab sap-tab-pipeline <?php echo ($active_submenu == 'pipeline_applicant') ? 'active' : '' ?>">
                            Pipeline
                        </a>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>