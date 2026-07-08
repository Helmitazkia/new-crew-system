<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="icon" href="<?php echo base_url("assets/img/andhika.gif"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {

            document.querySelectorAll('.nav-link').forEach(l => {
                l.style.background = '';
                l.style.color = '#555';
            });

            this.style.background = '#067780';
            this.style.color = '#fff';
        });
    });

    $(document).on("click", ".nav-link", function(e) {
        e.preventDefault();

        let target = $(this).data("section");
        if (!target) return;

        $(".nav-link").css({
            background: "transparent",
            color: "#555"
        });

        $(this).css({
            background: "#067780",
            color: "#fff"
        });

        $("#sectionPersonal, #sectionCertificate, #sectionPersonalID, #sectionViewData, #sectionEmpty")
            .hide()
            .css({
                opacity: 0,
                transform: "translateY(10px)"
            });

        let el = $("#" + target);

        el.show();

        setTimeout(() => {
            el.css({
                opacity: 1,
                transform: "translateY(0)"
            });
        }, 50);
    });

    $(document).ready(function() {
        $(".navbar-toggler").click(function() {
            $("#navbarMain").toggleClass("show");
        });
        $(".nav-link").click(function() {
            $(".navbar-collapse").removeClass("show");
        });

    });

    function saveDataPersonalCrew() {
        var formData = new FormData();
        var idPerson = $("#txtIdPersonCrew").val();

        var fullname = $("#txtFnameCrew").val().trim();
        var nameParts = splitFullName(fullname);

        formData.append('fname', nameParts.fname);
        formData.append('mname', nameParts.mname);
        formData.append('lname', nameParts.lname);

        formData.append('slcGenderCrew', $("#slcGenderCrew").val());
        formData.append('pob', $("#slcPobCrew").val());
        formData.append('dob', $("#txtDobCrew").val());
        formData.append('paddress', $("#txtAddressCrew").val());
        formData.append('ssn', $("#txtSsnCrew").val());
        formData.append('ptn', $("#txtPtnCrew").val());
        formData.append('txtKodePelautCrew', $("#txtKodePelautCrew").val());
        formData.append('mobileno', $("#txtMobileNoCrew").val());
        formData.append('telpno', $("#txtTelpNoCrew").val());
        formData.append('next_of_kin', $("#txtNextOfKinCrew").val());
        formData.append('email', $("#txtEmailCrew").val());
        //home
        formData.append('norek', $("#txtNorekHomeCrew").val());
        formData.append('bank_name', $("#txtNamaBankHomeCrew").val());
        formData.append('norek_name', $("#txtPemilikHomeCrew").val());
        //board
        formData.append('norek_boat', $("#txtNorekBoardCrew").val());
        formData.append('bank_name_boat', $("#txtNamaBankBoardCrew").val());
        formData.append('norek_name_boat', $("#txtPemilikBoardCrew").val());
        formData.append('applyfor', $("#slcApplyForCrew").val());
        formData.append('crew_vessel_type', $("#slcVesselTypeCrew").val());
        formData.append('religion', $("#slcReligionCrew").val());
        formData.append('newapplicent', '1');

        var picFile = $("#filePicCrew")[0].files[0];
        if (picFile) {
            formData.append('pic', picFile);
        }

        $("#btnSaveCrew").prop('disabled', true);
        $("#btnSaveCrew").html('<i class="glyphicon glyphicon-hourglass"></i> Saving...');

        $.ajax({
            url: "<?php echo base_url('savePersonalData'); ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    if (response.idperson) {
                        $("#txtIdPersonCrew").val(response.idperson);
                        checkPersonalDataStatus();
                        loadCrewData(response.idperson);
                    }
                    location.reload();
                } else {
                    alert(response.error || "Terjadi kesalahan saat menyimpan data.");
                }

                $("#btnSaveCrew").prop('disabled', false);
                $("#btnSaveCrew").html('💾 Save Data Crew');
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
                $("#btnSaveCrew").prop('disabled', false);
                $("#btnSaveCrew").html('💾 Save Data Crew');
            }
        });
    }

    function saveDataCertificate() {

        if (!$("#slcMstCertAllCert").val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation',
                text: 'Certificate Name wajib diisi'
            });
            return;
        }

        let formData = new FormData();

        formData.append('slcMstCert', $("#slcMstCertAllCert").val());
        formData.append('useThisAll', $("#chkUseThisAllCert").is(":checked") ? 'Y' : '');
        formData.append('certDisplay', $("#chkDisplayAllCert").is(":checked") ? 'Y' : '');

        formData.append('slcLicense', $("#slcLicenseAllCert").val());
        formData.append('slcLevel', $("#slcLevelAllCert").val());
        formData.append('rank', $("#slcRankAllCert").val());
        formData.append('rankName', $("#slcRankAllCert option:selected").text());
        formData.append('slcVesselType', $("#slcVesselTypeAllCert").val());
        formData.append('slcCountryIssue', $("#slcCountryIssueAllCert").val());
        formData.append('slcCountryIssueName', $("#slcCountryIssueAllCert option:selected").text());

        formData.append('txtNoDocument', $("#txtNoDocumentAllCert").val());
        formData.append('txtDate_ofIssue', $("#txtDate_ofIssueAllCert").val());
        formData.append('txtDate_expiry', $("#txtDate_expiryAllCert").val());
        formData.append('txtPlaceofIssue', $("#txtPlaceofIssueAllCert").val());
        formData.append('txtIssuingAuthority', $("#txtIssuingAuthorityAllCert").val());
        formData.append('txtRemark', $("#txtRemarkAllCert").val());
        formData.append('slcRedSing', $("#slcRedSingAllCert").val());

        let file = $("#uploadFile")[0].files[0];
        if (file) {
            // Validasi ukuran file di client
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cek Ukuran File! ',
                    text: 'Ukuran file maksimal 2MB'
                });
                return;
            }
            formData.append('fileUpload', file);
        }

        Swal.fire({
            title: 'Saving...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "<?php echo base_url('saveCertificate'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {
                Swal.close();
                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Saving Success',
                        text: res.message
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation',
                        text: res.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                let errorMsg = 'Internal Server Error';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    errorMsg = xhr.responseText;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: errorMsg
                });
            }
        });
    }


    $(document).ready(function() {

        $.ajax({
            url: "<?php echo base_url('personalData'); ?>",
            type: "GET",
            dataType: "json",
            success: function(res) {

                if (res.error || !res.data) {
                    console.warn(res.message || 'Personal data not found');
                    $('body').data('hasPersonal', false);
                    $('body').data('idperson', '');
                    return;
                }

                const d = res.data;

                $('body').data('hasPersonal', true);
                $('body').data('idperson', d.idperson || '');

                $("#txtFnameCrew").val(d.fullname || '');
                $("#txtDobCrew").val(d.dob || '');
                $("#txtEmailCrew").val(d.email || '');
                $("#txtMobileNoCrew").val(d.mobileno || '');
                $("#txtTelpNoCrew").val(d.telpno || '');
                $("#txtIdPersonCrew").val(d.idperson || '');

                $("#slcGenderCrew").val(
                    d.gender === 'Male' ? 'Male' :
                    d.gender === 'Female' ? 'Female' : d.gender
                );

                $("#slcPobCrew").val(d.pob_code || '');
                $("#slcReligionCrew").val(d.religion || '');
                $("#slcApplyForCrew").val(d.applyfor || '');
                $("#slcVesselTypeCrew").val(d.crew_vessel_type || '');

                $("#txtKodePelautCrew").val(d.kodepelaut || '');
                $("#txtSsnCrew").val(d.ssn || '');
                $("#txtPtnCrew").val(d.ptn || '');
                $("#txtAddressCrew").val(d.paddress || '');

                $("#txtNextOfKinCrew").val(d.next_of_kin || '');
                $("#txtNextOfKinNameCrew").val(d.famfullname || '');

                $("#txtNamaBankHomeCrew").val(d.bank_name || '');
                $("#txtNorekHomeCrew").val(d.norek || '');
                $("#txtPemilikHomeCrew").val(d.norek_name || '');

                $("#txtNamaBankBoardCrew").val(d.bank_name_boat || '');
                $("#txtNorekBoardCrew").val(d.norek_boat || '');
                $("#txtPemilikBoardCrew").val(d.norek_name_boat || '');
            },
            error: function() {
                console.error('Gagal mengambil data personal');
            }
        });

    });


    function splitFullName(fullname) {
        var cleanName = fullname.trim().replace(/\s+/g, ' ');
        var words = cleanName.split(' ');

        var result = {
            fname: '',
            mname: '',
            lname: ''
        };

        var total = words.length;

        if (total === 0 || words[0] === '') {
            return result;
        }

        if (total === 1) {
            result.fname = words[0];

        } else if (total === 2) {
            result.fname = words[0];
            result.lname = words[1];

        } else if (total === 3) {
            result.fname = words[0];
            result.mname = words[1];
            result.lname = words[2];

        } else if (total > 3) {
            result.fname = words[0];
            result.mname = words[1];
            result.lname = words.slice(2).join(' ');
        }

        return result;
    }

    $(document).on("focus", "#slcMstCertAllCert", function() {
        $.ajax({
            url: "<?php echo base_url('crewCertificate'); ?>",
            type: "POST",
            data: {},
            dataType: "html",
            success: function(res) {
                console.log("RAW:", res);
                $('#slcMstCertAllCert').html(res);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#slcMstCertAllCert').html("<option value=''>Error</option>");
            }
        });
    });


    $(document).on('change', '#slcMstCertAllCert', function() {

        let certId = $(this).val();
        let idPerson = $("#txtIdPersonCrew").val();

        if (!certId || !idPerson) return;

        // RESET STATE (WAJIB)
        $("#uploadFile").val('');
        $("#previewCertificateFile").html('');

        $("#idLoadingSpinner").css("display", "flex");

        $.ajax({
            url: "<?php echo base_url('certificateDetail'); ?>",
            type: "POST",
            data: {
                idPerson: idPerson,
                cert_id: certId
            },
            dataType: "json",
            success: function(res) {

                $("#idLoadingSpinner").hide();

                // RESET FORM
                $("#txtNoDocumentAllCert").val('');
                $("#txtDate_ofIssueAllCert").val('');
                $("#txtDate_expiryAllCert").val('');
                $("#txtPlaceofIssueAllCert").val('');
                $("#txtIssuingAuthorityAllCert").val('');
                $("#txtRemarkAllCert").val('');

                $("#slcLicenseAllCert").val("-");
                $("#slcLevelAllCert").val("-");
                $("#slcRankAllCert").val("");
                $("#slcVesselTypeAllCert").val("");
                $("#slcCountryIssueAllCert").val("");

                let preview = $("#previewCertificateFile");
                let fileInput = $("#uploadFile")[0];

                if (!res) {
                    preview.html(
                        '<span style="color:#999;">Belum ada data. Silakan isi dan upload file.</span>'
                    );
                    return;
                }

                $("#txtNoDocumentAllCert").val(res.docno || "");
                $("#txtDate_ofIssueAllCert").val(res.issdate && res.issdate !== "0000-00-00" ? res
                    .issdate : "");
                $("#txtDate_expiryAllCert").val(res.expdate && res.expdate !== "0000-00-00" ? res
                    .expdate : "");
                $("#txtPlaceofIssueAllCert").val(res.issplace || "");
                $("#txtIssuingAuthorityAllCert").val(res.issauth || "");
                $("#txtRemarkAllCert").val(res.remarks || "");

                $("#slcLicenseAllCert").val(res.license || "-");
                $("#slcLevelAllCert").val(res.level || "-");
                $("#slcRankAllCert").val(res.kdrank || "");
                $("#slcVesselTypeAllCert").val(res.vsltype || "");
                $("#slcCountryIssueAllCert").val(res.kdnegara || "");

                // PREVIEW FILE
                if (!fileInput.files || fileInput.files.length === 0) {
                    if (res.certificate_file) {
                        preview.html(
                            '<a href="<?php echo base_url('uploadCertificate/'); ?>' + res
                            .certificate_file + '" ' +
                            'target="_blank" style="color:blue;font-weight:bold;">View Uploaded File</a>'
                        );
                    } else {
                        preview.html(
                            '<span style="color:red;">No file uploaded</span>'
                        );
                    }
                } else {
                    preview.html(
                        '<span style="color:green;">File ready: ' + fileInput.files[0].name +
                        '</span>'
                    );
                }
            },
            error: function() {
                $("#idLoadingSpinner").hide();
                alert("Error connecting to server.");
            }
        });
    });

    function saveDataPersonalID() {
        var formData = new FormData();

        formData.append("txtIssueAtPlace", $("#txtIssueAtPlace").val());
        formData.append("slcCountryIssuePI", $("#slcCountryIssuePI").val());
        formData.append("txtDate_issuePI", $("#txtDate_issuePI").val());
        formData.append("txtDate_validUntiPI", $("#txtDate_validUntiPI").val());
        formData.append("txtTypeDocPI", $("#txtTypeDocPI").val());
        formData.append("txtNoDocPI", $("#txtNoDocPI").val());

        var file = document.getElementById("uploadFilePersonalID").files[0];

        if (file) {
            formData.append("fileUpload", file);
            formData.append("cekFileUpload", "yes");
        } else {
            formData.append("cekFileUpload", "no");
        }

        $.ajax({
            url: "<?php echo base_url('crew/saveDataPersonalId'); ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                console.log("File object:", file);
                alert(res);
                location.reload();
            }
        });
    }


    function checkPersonalDataStatus() {
        let idperson = $("#txtIdPersonCrew").val();

        if (!idperson) return;

        $.ajax({
            url: "<?php echo base_url('checkPersonData'); ?> ",
            method: "POST",
            data: {
                idperson: idperson
            },
            dataType: "json",
            success: function(res) {
                if (res.exists) {
                    $("#navPersonal")
                        .prop("disabled", true)
                        .css({
                            background: "linear-gradient(90deg,#b3b3b3,#d1d1d1)",
                            color: "#eee",
                            cursor: "not-allowed",
                            boxShadow: "none",
                            transform: "none"
                        })
                        .attr("title", "Data Personal sudah tersimpan");

                } else {
                    $("#navPersonal")
                        .prop("disabled", false)
                        .css({
                            background: "linear-gradient(90deg,#0066d6,#36b7ff)",
                            color: "#fff",
                            cursor: "pointer",
                            boxShadow: "0 6px 16px rgba(8,61,119,0.12)"
                        })
                        .attr("title", "Isi Data Personal");
                }
            },
            error: function(xhr, status, error) {
                console.error("Gagal cek data personal:", error);
            }
        });
    }

    function createBioItem(label, value) {
        return `
            <div style="
                background:#f4f7fb;
                border-radius:12px;
                padding:12px;
                transition:.2s;
            " onmouseover="this.style.transform='translateY(-2px)'"
            onmouseout="this.style.transform='none'">

                <div style="font-size:11px;color:#7a8ca3;">
                    ${label}
                </div>
                <div style="font-weight:600;color:#1c2b36;">
                    ${value || "-"}
                </div>
            </div>
        `;
    }

    function getCertStatus(date) {
        if (!date) return `<span style="color:#999;">Unknown</span>`;

        let today = new Date();
        let exp = new Date(date);

        if (exp < today) {
            return `<span style="
                background:#ffecec;
                color:#d90429;
                padding:5px 10px;
                border-radius:20px;
                font-size:11px;
                font-weight:600;
            ">Expired</span>`;
        }

        return `<span style="
            background:#e6f7ee;
            color:#0f9d58;
            padding:5px 10px;
            border-radius:20px;
            font-size:11px;
            font-weight:600;
        ">Valid</span>`;
    }

    function showSkeleton() {
        $("#tblBioCrew").html(`
            <div style="grid-column:1/-1;text-align:center;padding:20px;color:#999;">
                Loading crew data...
            </div>
        `);

        $("#tblCertificateList").html(`
            <tr><td colspan="5" style="text-align:center;padding:20px;color:#999;">
                Loading certificates...
            </td></tr>
        `);
    }

    function loadCrewData(idperson) {

        showSkeleton();

        $.ajax({
            url: "<?php echo base_url('personalDataCertificateCrew'); ?>",
            type: "GET",
            data: idperson ? {
                idperson
            } : {},
            dataType: "json",

            success: function(response) {

                if (response.error) return;

                let p = response.personal;
                if (p) {

                    let baseImgUrl = "<?php echo rtrim(base_url('assets/img/imgProfile'), '/'); ?>/";
                    let picUrl = p.pic ? baseImgUrl + p.pic + "?v=" + Date.now() : baseImgUrl +
                        "default.png";

                    $("#crewHeader").html(`
                        <div style="display:flex;align-items:center;gap:20px;">
                            <img src="${picUrl}"
                                onerror="this.src='${baseImgUrl}default.png';"
                                style="
                                    width:95px;height:95px;
                                    border-radius:50%;
                                    object-fit:cover;
                                    border:3px solid #e6ecf2;
                                ">

                            <div>
                                <div style="font-size:22px;font-weight:700;color:#1c2b36;">
                                    ${p.fullName || "-"}
                                </div>

                                <div style="font-size:13px;color:#6b7c93;margin-top:6px;">
                                    ${p.applyfor || "-"} • ${p.crew_vessel_type || "-"}
                                </div>

                                <div style="margin-top:8px;">
                                    <span style="
                                        background:#e6f0ff;
                                        color:#0b63f6;
                                        padding:4px 10px;
                                        border-radius:20px;
                                        font-size:11px;
                                        font-weight:600;
                                    ">
                                        Active Crew
                                    </span>
                                </div>
                            </div>
                        </div>
                    `);

                    // BIODATA GRID
                    $("#tblBioCrew").html(`
                    ${createBioItem("Full Name", p.fullName)}
                    ${createBioItem("Place of Birth", p.pob)}
                    ${createBioItem("Date of Birth", p.dob)}
                    ${createBioItem("Gender", p.gender)}
                    ${createBioItem("Religion", p.religion)}
                    ${createBioItem("Email", p.email)}
                    ${createBioItem("Phone", p.mobileno)}
                    ${createBioItem("Position", p.applyfor)}
                    ${createBioItem("Vessel Type", p.crew_vessel_type)}
                `);
                }

                // CERTIFICATES
                let certs = response.certificates;
                let html = "";

                if (certs && certs.length > 0) {

                    certs.forEach(c => {

                        let fileLink = c.certificate_file ?
                            `<a href="<?php echo base_url(); ?>${c.certificate_file}" 
                            target="_blank"
                            style="color:#0b63f6;font-weight:600;text-decoration:none;">
                            View
                           </a>` :
                            `<span style="color:#aaa;">No File</span>`;

                        html += `
                    <tr style="
                        background:#fff;
                        box-shadow:0 6px 18px rgba(0,0,0,.06);
                        transition:.2s;
                    " onmouseover="this.style.transform='scale(1.01)'"
                       onmouseout="this.style.transform='none'">

                        <td style="padding:12px;border-radius:10px 0 0 10px;">
                            ${c.certname || "-"}
                        </td>

                        <td>${c.docno || "-"}</td>

                        <td>${getCertStatus(c.expdate)}</td>

                        <td>${c.nmnegara || "-"}</td>

                        <td style="border-radius:0 10px 10px 0;">
                            ${fileLink}
                            <span class="linkDeleteCert"
                                data-idcert="${c.idcertdoc}"
                                style="
                                    margin-left:10px;
                                    color:#d90429;
                                    cursor:pointer;
                                    font-weight:600;
                                ">
                                Delete
                            </span>
                        </td>
                    </tr>`;
                    });

                } else {
                    html = `
                <tr>
                    <td colspan="5" style="text-align:center;padding:20px;color:#999;">
                        No certificates uploaded
                    </td>
                </tr>`;
                }

                $("#tblCertificateList").html(html);

                // SHOW ANIMATION
                $("#sectionViewData").css({
                    display: "block"
                });

                setTimeout(() => {
                    $("#sectionViewData").css({
                        opacity: 1,
                        transform: "translateY(0)"
                    });
                }, 50);
            }
        });
    }

    $(document).on("click", ".linkDeleteCert", function(e) {

        let idcert = $(this).data("idcert");

        if (!confirm("Yakin ingin menghapus sertifikat ini?")) return;

        $.ajax({
            url: "<?php echo base_url('crew/deleteCertificate'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                idcert: idcert
            },
            success: function(res) {

                if (res.status === "success") {
                    alert("Sertifikat berhasil dihapus!");
                    loadCrewData($("#txtIdPersonCrew").val());
                } else {
                    alert("Gagal menghapus: " + (res.message || "Unknown error"));
                }
            },
            error: function(xhr) {
                alert("Terjadi error dalam menghapus sertifikat");
                console.error(xhr.responseText);
            }
        });
    });

    $('#txtTypeDocPI').on('change', function() {
        let jenis = $(this).val();

        const mapPlaceholder = {
            "KTP": "Nomor KTP",
            "Kartu Keluarga": "Nomor KK",
            "NPWP": "Nomor NPWP",
            "Buku Rekening": "Nomor Rekening",
            "Passport": "Passport Number",
            "Seaman Book": "Seaman Book Number"
        };

        let text = mapPlaceholder[jenis] || "No Document";
        $('#txtNoDocPI').attr('placeholder', text);
        $('#labelNoDoc').text(text);
    });

    $('#btnClearFile').on('click', function() {
        $('#uploadFile').val('');
    });

    $(document).ready(function() {

        const $sections = $('[id^="section"]');
        const $links = $('[data-section]');
        const $menuLinks = $('[data-menu="nav"]');
        const $body = $('body');

        $body.data('hasPersonal', false);
        $body.data('idperson', '');

        function hideAllSections() {
            $sections.hide().css({
                opacity: 0,
                transform: 'translateY(10px)'
            });
        }

        function showSection(id) {
            hideAllSections();

            const $target = $('#' + id);
            if (!$target.length) return;

            $target.show();
            setTimeout(() => {
                $target.css({
                    opacity: 1,
                    transform: 'translateY(0)'
                });
            }, 20);
        }

        function resetActiveMenu() {
            $menuLinks.each(function() {
                $(this).css({
                    background: 'transparent',
                    fontWeight: '400',
                    color: '',
                    boxShadow: 'none',
                    borderBottom: 'none',
                    borderRadius: '6px'
                });
            });
        }

        function setActiveMenu($el) {
            resetActiveMenu();

            $el.css({
                background: '#e8f3f7',
                fontWeight: '700',
                color: '#004d66',
                boxShadow: 'inset 2px 2px 5px rgba(0,0,0,0.15)',
                borderBottom: '3px solid #00bcd4',
                borderRadius: '6px'
            });
        }

        $links.on('click', function(e) {
            e.preventDefault();

            const target = $(this).data('section');
            const hasPersonal = $body.data('hasPersonal');

            if (
                (target === 'sectionCertificate' ||
                    target === 'sectionPersonalID' ||
                    target === 'sectionViewData') &&
                !hasPersonal
            ) {
                alert('⚠️ Data personal belum tersedia.\nSilakan lengkapi Data Personal.');
                return;
            }

            showSection(target);
            setActiveMenu($(this));

            if (target === 'sectionViewData') {
                const idperson = $body.data('idperson');
                if (idperson) {
                    loadCrewData(idperson);
                }
            }
        });
        showSection('sectionEmpty');
        resetActiveMenu();

    });

    $(document).ready(function() {

        $("#showAllPassword").on("change", function() {
            let type = this.checked ? "text" : "password";
            $("#cpOld, #cpNew, #cpConfirm").attr("type", type);
        });

        $("#cpNew").on("keyup", function() {
            let val = $(this).val();
            let strength = 0;

            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;

            let percent = strength * 25;
            let bar = $("#passStrength");
            let text = $("#strengthText");

            bar.css("width", percent + "%");

            if (strength <= 1) {
                bar.css("background", "#dc3545");
                text.text("Weak password").css("color", "#dc3545");
            } else if (strength == 2) {
                bar.css("background", "#ffc107");
                text.text("Medium password").css("color", "#856404");
            } else {
                bar.css("background", "#28a745");
                text.text("Strong password").css("color", "#28a745");
            }
        });

        $("#btnChangePass").click(function() {

            let oldPass = $("#cpOld").val();
            let newPass = $("#cpNew").val();
            let confirm = $("#cpConfirm").val();

            if (!oldPass || !newPass || !confirm) {
                alert("All fields are required");
                return;
            }

            if (newPass !== confirm) {
                alert("New password & confirmation do not match");
                return;
            }

            if (!/[A-Z]/.test(newPass) || !/[0-9]/.test(newPass)) {
                alert("Password must contain at least 1 uppercase letter and 1 number");
                return;
            }

            $.post("<?php echo base_url('crew/changePasswordCrew'); ?>", {
                old_password: oldPass,
                new_password: newPass
            }, function(res) {

                if (res.status) {
                    alert("Password successfully changed.\nPlease login again.");

                    window.location = "<?php echo base_url('crew/logOut'); ?>";
                } else {
                    alert(res.message || "Failed to change password");
                }

            }, "json");
        });
    });


    $('#modalChangePassword').on('hidden.bs.modal', function() {
        $('#cpOld, #cpNew, #cpConfirm').val('').attr('type', 'password');
        $('#showAllPassword').prop('checked', false);

        $('#passStrength').css({
            width: '0%',
            background: ''
        });
        $('#strengthText').text('');
        $('#lblChangePass').text('').css('color', 'red');
    });

    function joinFullName(fname, mname, lname) {
        let parts = [];

        if (fname && fname.trim() !== '') parts.push(fname);
        if (mname && mname.trim() !== '') parts.push(mname);
        if (lname && lname.trim() !== '') parts.push(lname);

        return parts.join(' ');
    }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 sticky-top" style="
        z-index:9999;
        box-shadow:0 2px 10px rgba(0,0,0,0.05);
        border-bottom:1px solid #eee;
        ">

        <div class="container-fluid">

            <a class="navbar-brand d-flex align-items-center gap-2">
                <img src="<?php echo base_url("/assets/img/banner/andhika.png");?>"
                    style="width:120px; border-radius:50px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation"
                style="border:none;outline:none;">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a href="#" data-section="sectionPersonal" class="nav-link"
                            style="display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;color:#555;font-size:14px;">
                            <i class="fa fa-compass"></i> Personal
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" data-section="sectionCertificate" class="nav-link"
                            style="display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;color:#555;font-size:14px;">
                            <i class="fa fa-file"></i> Certificate
                        </a>
                    </li>

                    <!-- <li class="nav-item">
                        <a href="#" data-section="sectionPersonalID" class="nav-link"
                            style="display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;color:#555;font-size:14px;">
                            <i class="fa fa-id-card"></i> ID
                        </a>
                    </li> -->

                    <li class="nav-item">
                        <a href="#" data-section="sectionViewData" class="nav-link"
                            style="display:flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;color:#555;font-size:14px;">
                            <i class="fa fa-chart-bar"></i> Summary
                        </a>
                    </li>

                </ul>

                <!-- USER -->
                <div style="display:flex;align-items:center;gap:12px;">

                    <div style="
                    width:32px;height:32px;background:#067780;color:#fff;
                    border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    font-size:14px;font-weight:bold;">
                        <?php echo strtoupper(substr($this->session->userdata('fullnameUserCrewLoginSystem'),0,1)); ?>
                    </div>

                    <span style="font-weight:600;font-size:14px;">
                        <?php echo $this->session->userdata('fullnameUserCrewLoginSystem') ?: 'Guest'; ?>
                    </span>

                    <a href="<?php echo base_url('logoutCrew'); ?>"
                        style="background:#dc3545;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none;font-size:13px;">
                        <i class="fa fa-sign-out"></i>
                    </a>

                </div>

            </div>
        </div>
    </nav>

    <div id="sectionEmpty" style="text-align:center;color:#8a98a6;padding:80px 10px;border-radius:12px;">
        <p style="font-size:16px;font-style:italic;margin:0;">Silakan pilih menu di atas untuk melanjutkan ⬆️</p>
    </div>

    <div id="sectionPersonal"
        style="display:none;opacity:0;transform:translateY(20px);transition:all .45s cubic-bezier(.4,0,.2,1);padding:14px;background:#f5f7fb;">

        <div style="
            border-radius:22px;
            background:#ffffff;
            box-shadow:
                0 25px 60px rgba(0,0,0,0.05),
                0 2px 6px rgba(0,0,0,0.04);
            overflow:hidden;
            border:1px solid #eef2f7;
        ">

            <!-- HEADER -->
            <div style="
                padding:22px 30px;
                border-bottom:1px solid #eef2f7;
                background:linear-gradient(120deg,#ffffff,#f8fbff);
            ">
                <div style="font-size:18px;font-weight:700;color:#1e293b;">
                    Personal Information
                </div>
                <div style="font-size:12px;color:#64748b;margin-top:4px;">
                    Lengkapi data pribadi crew dengan benar
                </div>
            </div>

            <div class="row" style="padding:30px;">

                <div style="
                    display:grid;
                    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
                    gap:24px;
                ">

                    <!-- INPUT TEMPLATE -->
                    <div>
                        <label
                            style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;display:block;">Nama
                            Lengkap</label>
                        <input id="txtFnameCrew" type="text"
                            style="width:100%;padding:13px 14px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;transition:.25s;outline:none;"
                            onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.15)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Tempat
                            Lahir</label>
                        <select id="slcPobCrew"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                            <?php echo $optCity; ?>
                        </select>
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Tanggal
                            Lahir</label>
                        <input id="txtDobCrew" type="date"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Jenis
                            Kelamin</label>
                        <select id="slcGenderCrew"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;"
                            name="gender">
                            <option value="">Pilih</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Kode
                            Pelaut</label>
                        <input id="txtKodePelautCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div style="grid-column:1 / -1;">
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Alamat
                            Lengkap</label>
                        <textarea id="txtAddressCrew" rows="2"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;resize:none;"></textarea>
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">No KTP</label>
                        <input id="txtSsnCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">No NPWP</label>
                        <input id="txtPtnCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">No HP</label>
                        <input id="txtMobileNoCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Telpon
                            Rumah</label>
                        <input id="txtTelpNoCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Kontak
                            Darurat</label>
                        <input id="txtNextOfKinCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Nama Kontak
                            Darurat</label>
                        <input id="txtNextOfKinNameCrew" type="text"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Email</label>
                        <input id="txtEmailCrew" type="email"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;background:#fff;">
                    </div>

                    <!-- SALARY -->
                    <div
                        style="grid-column:1 / -1;display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px;margin-top:10px;">

                        <div style="
                        border-radius:18px;
                        background:#f8fafc;
                        padding:22px;
                        border:1px solid #e2e8f0;
                        box-shadow:0 10px 25px rgba(0,0,0,0.04);
                    ">
                            <legend style="font-weight:700;color:#1e293b;margin-bottom:14px;">🏠 Home Salary</legend>

                            <input id="txtNorekHomeCrew" placeholder="No Rekening"
                                style="width:100%;margin-bottom:10px;padding:12px;border-radius:12px;border:1px solid #e2e8f0;">
                            <input id="txtNamaBankHomeCrew" placeholder="Nama Bank"
                                style="width:100%;margin-bottom:10px;padding:12px;border-radius:12px;border:1px solid #e2e8f0;">
                            <input id="txtPemilikHomeCrew" placeholder="Pemilik Rekening"
                                style="width:100%;padding:12px;border-radius:12px;border:1px solid #e2e8f0;">
                        </div>

                        <div style="
                        border-radius:18px;
                        background:#f8fafc;
                        padding:22px;
                        border:1px solid #e2e8f0;
                        box-shadow:0 10px 25px rgba(0,0,0,0.04);
                    ">
                            <legend style="font-weight:700;color:#1e293b;margin-bottom:14px;">🚢 Board Salary</legend>

                            <input id="txtNorekBoardCrew" placeholder="No Rekening"
                                style="width:100%;margin-bottom:10px;padding:12px;border-radius:12px;border:1px solid #e2e8f0;">
                            <input id="txtNamaBankBoardCrew" placeholder="Nama Bank"
                                style="width:100%;margin-bottom:10px;padding:12px;border-radius:12px;border:1px solid #e2e8f0;">
                            <input id="txtPemilikBoardCrew" placeholder="Pemilik Rekening"
                                style="width:100%;padding:12px;border-radius:12px;border:1px solid #e2e8f0;">
                        </div>

                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Jabatan</label>
                        <select id="slcApplyForCrew"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;">
                            <?php echo $optRank; ?>
                        </select>
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Type
                            Kapal</label>
                        <select id="slcVesselTypeCrew"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;">
                            <?php echo $getVesselType; ?>
                        </select>
                    </div>

                    <div>
                        <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Agama</label>
                        <select id="slcReligionCrew"
                            style="width:100%;padding:13px;border-radius:14px;border:1px solid #e2e8f0;">
                            <?php echo $optReligion; ?>
                        </select>
                    </div>

                </div>

                <!-- FOTO -->
                <div style="margin-top:24px;">
                    <label style="font-size:11px;font-weight:700;color:#64748b;margin-bottom:6px;">Foto Crew</label>
                    <input id="filePicCrew" type="file" accept="image/*"
                        style="width:100%;padding:16px;border-radius:14px;border:2px dashed #cbd5e1;background:#f8fafc;">
                </div>

                <!-- BUTTON -->
                <div style="display:flex;justify-content:flex-end;margin-top:32px;">
                    <input type="hidden" id="txtIdPersonCrew" value="">
                    <button onclick="saveDataPersonalCrew();" style="
                    padding:14px 32px;
                    border-radius:14px;
                    border:none;
                    background:linear-gradient(135deg,#2563eb,#38bdf8);
                    color:#fff;
                    font-weight:700;
                    letter-spacing:.4px;
                    cursor:pointer;
                    box-shadow:0 15px 35px rgba(37,99,235,0.25);
                    transition:.3s;
                " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 20px 40px rgba(37,99,235,0.35)'"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 15px 35px rgba(37,99,235,0.25)'">
                        💾 Simpan Data
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div id="sectionCertificate"
        style="display:none;opacity:0;transform:translateY(10px);transition:all .36s ease;margin-top:18px;">
        <div id="idLoadingSpinner" style="
                    display:none;
                    position:fixed;
                    top:0; left:0;
                    width:100%; height:100%;
                    background:rgba(0,0,0,0.6);
                    z-index:9999;
                    justify-content:center;
                    align-items:center;
                    flex-direction:column;
                    ">

            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 50 50"
                style="margin:auto; background:none; display:block;">
                <circle cx="25" cy="25" r="20" fill="none" stroke="white" stroke-width="5" stroke-linecap="round"
                    stroke-dasharray="31.4 31.4" transform="rotate(-90 25 25)">
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s"
                        repeatCount="indefinite" />
                </circle>
            </svg>

            <p style="margin-top:20px; font-size:16px; color:#fff; font-weight:bold; text-align:center;">
                ⏳ Please wait... Processing data
            </p>
        </div>
        <div style="border-radius:14px;box-shadow:0 8px 30px rgba(8,34,67,0.04);overflow:hidden;">
            <div style="padding:24px;">
                <div class="col-md-4 col-xs-12">
                    <input type="checkbox" id="chkDisplayAllCert" value="Y" checked="checked">
                    <label for="chkDisplayAllCert" style="font-size:12px;">Display</label>
                </div>
                <div style="text-align:center;margin-bottom:16px;color:#55686f;">
                    <input type="checkbox" id="chkUseThisAllCert" value="Y" checked style="transform:translateY(2px);">
                    <label for="chkUseThisAllCert" style="margin-left:8px;font-weight:600;">Use this for All
                        Certificates</label>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:12px;">
                    <div style="flex:1;min-width:240px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Certificate
                            Name</label>
                        <select id="slcMstCertAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                        </select>

                    </div>

                    <div style="flex:1;min-width:240px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Upload
                            File <span style="color:#d9534f;font-size:12px;">(Max 2MB)</span></label>
                        <input id="uploadFile" type="file" class="form-control"
                            style="width:100%;padding:8px;border-radius:10px;border:1px solid #e3e8ee;">
                        <div id="previewCertificateFile" style="margin-top:10px;"></div>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:12px;">
                    <div style="flex:1;min-width:200px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">License</label>
                        <select id="slcLicenseAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                            <option value="-">-</option>
                            <option value="COC">COC</option>
                            <option value="Endorsement">Endorsement</option>
                        </select>
                    </div>

                    <div style="flex:1;min-width:200px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Level</label>
                        <select id="slcLevelAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                            <option value="-">-</option>
                            <option value="Incharge">Incharge</option>
                            <option value="Asst.">Asst.</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:12px;">
                    <div style="flex:1;min-width:220px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Rank</label>
                        <select id="slcRankAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                            <?php echo $optRank; ?>
                        </select>
                    </div>

                    <div style="flex:1;min-width:220px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Vessel
                            Type</label>
                        <select id="slcVesselTypeAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                            <?php echo $optType; ?>
                        </select>
                    </div>

                    <div style="flex:1;min-width:220px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Country
                            of Issue</label>
                        <select id="slcCountryIssueAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                            <?php echo $optCountry; ?>
                        </select>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:12px;">
                    <div style="flex:1;min-width:200px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">No
                            Document</label>
                        <input id="txtNoDocumentAllCert" type="text"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                    </div>

                    <div style="flex:1;min-width:200px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Date
                            of Issue</label>
                        <input id="txtDate_ofIssueAllCert" type="date"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                    </div>

                    <div style="flex:1;min-width:200px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Date
                            of Expiry</label>
                        <input id="txtDate_expiryAllCert" type="date"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:12px;">
                    <div style="flex:1;min-width:220px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Place
                            of Issue</label>
                        <input id="txtPlaceofIssueAllCert" type="text"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                    </div>

                    <div style="flex:1;min-width:220px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Issuing
                            Authority</label>
                        <input id="txtIssuingAuthorityAllCert" type="text"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                    </div>

                    <div style="flex:1;min-width:220px;">
                        <label
                            style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Remark</label>
                        <textarea id="txtRemarkAllCert" rows="2"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;resize:none;"></textarea>
                    </div>
                </div>

                <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:18px;">
                    <div style="flex:1;min-width:160px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#213244;margin-bottom:6px;">Red
                            Sign</label>
                        <select id="slcRedSingAllCert"
                            style="width:100%;padding:10px;border-radius:10px;border:1px solid #e3e8ee;">
                            <option value="N">NO</option>
                            <option value="Y">YES</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:10px;">
                    <button onclick="saveDataCertificate();"
                        style="padding:11px 22px;border-radius:10px;border:none;background:linear-gradient(90deg,#0066d6,#36b7ff);color:#fff;font-weight:700;cursor:pointer;box-shadow:0 8px 20px rgba(3,96,197,0.12);">
                        💾 Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="sectionViewData" style="
        display:none;
        opacity:0;
        transform:translateY(20px);
        transition:all .5s cubic-bezier(.4,0,.2,1);
        margin-top:24px;
        font-family:Inter,system-ui,-apple-system,Segoe UI;
    ">

        <div style="
            border-radius:22px;
            background:linear-gradient(180deg,#f8fafc,#eef3f8);
            padding:24px;
            box-shadow:0 10px 40px rgba(0,0,0,0.06);
            color:#1c2b36;
        ">

            <div id="crewHeader"></div>

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin:20px 0;
            ">
                <div style="font-size:16px;color:#6b7c93;">
                    Crew Profile
                </div>

                <!-- <button data-bs-toggle="modal" data-bs-target="#modalChangePassword" style="
                background:#0b63f6;
                border:none;
                padding:10px 16px;
                border-radius:10px;
                color:#fff;
                cursor:pointer;
                font-weight:500;
                box-shadow:0 6px 14px rgba(11,99,246,.25);
            ">
                    🔑 Change Password
                </button> -->
            </div>

            <!-- BIODATA -->
            <div style="
                background:#ffffff;
                border-radius:18px;
                padding:20px;
                margin-bottom:18px;
                box-shadow:0 6px 20px rgba(0,0,0,0.05);
                border:1px solid #eef2f6;
            ">
                <div style="
                    font-weight:700;
                    color:#0b3d5c;
                    margin-bottom:14px;
                    font-size:15px;
                ">
                    📋 Crew Biodata
                </div>

                <div id="tblBioCrew" style="
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
                gap:14px;
            "></div>
            </div>

            <!-- CERTIFICATES -->
            <div style="
            background:#ffffff;
            border-radius:18px;
            padding:20px;
            box-shadow:0 6px 20px rgba(0,0,0,0.05);
            border:1px solid #eef2f6;
        ">
                <div style="
                font-weight:700;
                color:#0b3d5c;
                margin-bottom:14px;
                font-size:15px;
            ">
                    📜 Certificates
                </div>

                <div style="overflow-x:auto;">
                    <table style="
                    width:100%;
                    border-collapse:separate;
                    border-spacing:0 10px;
                    font-size:13px;
                    min-width:720px;
                ">
                        <thead>
                            <tr style="color:#7a8ca3;font-weight:600;">
                                <th style="padding:10px;">Certificate</th>
                                <th>No</th>
                                <th>Status</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tblCertificateList"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- <div id="sectionPersonalID"
        style="display:none; opacity:0; transform:translateY(10px); transition:all .36s ease; margin-top:18px;">
        <div style="border-radius:14px; box-shadow:0 8px 30px rgba(8,34,67,0.04); overflow:hidden;">
            <div style="padding:26px 30px;">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">Issue at (Place)</label>
                        <input id="txtIssueAtPlace" type="text" class="form-control" placeholder="Issue at Place">
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">Country of Issue</label>
                        <select id="slcCountryIssuePI" class="form-control">
                            <?php echo $optCountry; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">Date of Issue</label>
                        <input id="txtDate_issuePI" type="date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">Valid Until</label>
                        <input id="txtDate_validUntiPI" type="date" class="form-control">
                    </div>

                </div>

                <div class="row g-3 mt-3">

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">Type of Document</label>
                        <select id="txtTypeDocPI" class="form-control">
                            <option value="">-- Select Document --</option>
                            <option>KTP</option>
                            <option>Kartu Keluarga</option>
                            <option>NPWP</option>
                            <option>Buku Rekening</option>
                            <option>Passport</option>
                            <option>Seaman Book</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">No Document</label>
                        <input id="txtNoDocPI" type="text" class="form-control" placeholder="Document Number">
                    </div>

                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">File</label>
                        <input id="uploadFilePersonalID" type="file" class="form-control">
                        <div id="idViewFile" class="mt-2"></div>
                    </div>

                    <div class="col-md-3">
                        <label class="mb-1">&nbsp;</label>
                        <button class="btn btn-warning w-100 fw-bold"
                            onclick="$('#uploadFile').val(''); $('#idViewFile').html('');">
                            Clear
                        </button>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button onclick="saveDataPersonalID();" class="fw-bold"
                        style="padding:12px 24px; border-radius:10px; border:none; background:linear-gradient(90deg,#0066d6,#36b7ff); color:#fff;">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div> -->

    <div id="loadingOverlay" style="
        display: none;
        position: fixed;
        z-index: 99999;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(2px);
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: white;
        font-size: 1.5em;
        text-align: center;
        transition: opacity 0.3s ease;
        opacity: 0;
    ">
        <div style="margin-bottom: 15px;">
            <svg width="80" height="80" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                <g fill="none" fill-rule="evenodd" stroke-width="4">
                    <circle cx="22" cy="22" r="20" stroke-opacity="0.3" />
                    <path d="M42 22c0-11.046-8.954-20-20-20">
                        <animateTransform attributeName="transform" type="rotate" from="0 22 22" to="360 22 22" dur="1s"
                            repeatCount="indefinite" />
                    </path>
                </g>
            </svg>
        </div>
        <div>Menyimpan data, mohon tunggu...</div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.hc-sticky.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
</body>

</html>