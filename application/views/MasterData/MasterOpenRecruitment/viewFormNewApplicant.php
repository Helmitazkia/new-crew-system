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
    $(document).ready(function() {
        $('#otherKapalCheckbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#inputOtherKapal').show();
            } else {
                $('#inputOtherKapal').hide();
            }
        });

        $('#otherCrewCheckbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#inputOtherCrew').show();
            } else {
                $('#inputOtherCrew').hide();
            }
        });
    });

    $(document).ready(function() {
        $("input[name='crew_foreign']").on('change', function() {
            if ($(this).val() === 'Y') {
                $("#foreignCountryInput").show();
            } else {
                $("#foreignCountryInput").hide();
                $("input[name='foreign_country']").val('');
            }
        });
        $("#alasanGabung").on("input", function() {
            const words = $(this).val().trim().split(/\s+/).filter(w => w.length > 0);
            $("#wordCountHelp").text(`${words.length} / 150 kata`);
        });
    });

    /* ============================================================
     * GLOBAL SUBMIT LOCK
     * ============================================================ */
    window.isSubmittingApplicant = false;


    /* ============================================================
     * SHOW ERROR
     * ============================================================ */
    function showConnectionError(message) {

        Swal.fire({

            icon: "warning",

            title: "Koneksi Internet Bermasalah",

            html: `
            <div style="
                font-size:14px;
                line-height:1.7;
                color:#475569;
            ">
                ${message}

                <div style="
                    margin-top:15px;
                    padding:12px 14px;
                    background:#fff7ed;
                    border:1px solid #fed7aa;
                    border-radius:10px;
                    text-align:left;
                    font-size:13px;
                ">

                    <b>Yang dapat dilakukan:</b>

                    <br>

                    • Pastikan sinyal internet cukup stabil

                    <br>

                    • Coba pindah ke tempat dengan sinyal lebih baik

                    <br>

                    • Jika menggunakan WiFi, coba dekatkan ke router

                    <br>

                    • Jangan menutup halaman selama proses pengiriman

                </div>
            </div>
        `,

            confirmButtonText: "Coba Lagi",

            confirmButtonColor: "#2563eb"

        });

    }


    function showCheckingConnection() {

        Swal.fire({

            title: "Memeriksa koneksi...",

            html: `
            <div style="
                margin-top:10px;
                color:#64748b;
                font-size:14px;
            ">
                Sedang memastikan koneksi internet kamu
                cukup stabil untuk mengirim CV.
            </div>
        `,

            allowOutsideClick: false,

            allowEscapeKey: false,

            showConfirmButton: false,

            didOpen: function() {

                Swal.showLoading();

            }

        });

    }

    function checkInternetConnection() {

        return new Promise(function(resolve, reject) {

            if (!navigator.onLine) {

                reject({

                    type: "offline",

                    message: "Perangkat kamu sedang tidak terhubung ke internet."

                });

                return;

            }


            const startTime =
                Date.now();

            $.ajax({

                url: "<?php echo base_url('checkInternetConnection'); ?>?_=" +
                    Date.now(),

                type: "GET",

                dataType: "json",

                timeout: 8000,

                cache: false,


                success: function(res) {

                    const responseTime =
                        Date.now() - startTime;


                    if (
                        res &&
                        res.status === "success"
                    ) {

                        resolve({

                            online: true,

                            responseTime: responseTime

                        });

                    } else {

                        reject({

                            type: "server",

                            message: "Server tidak memberikan respons yang valid."

                        });

                    }

                },
                error: function(xhr, status) {

                    if (
                        status === "timeout"
                    ) {

                        reject({

                            type: "timeout",

                            message: "Server terlalu lama merespons."

                        });

                    } else {

                        reject({

                            type: "server",

                            message: "Tidak dapat menghubungi server aplikasi."

                        });

                    }

                }

            });

        });

    }

    /* ============================================================
     * UPLOAD APPLICANT CV
     * ============================================================ */
    function uploadApplicantCV(formData) {

        Swal.fire({

            title: "Mengirim CV...",

            html: `

                <div style="
                    margin-top:10px;
                    color:#64748b;
                    font-size:14px;
                ">

                    Jangan tutup halaman ini sampai
                    proses pengiriman selesai.

                </div>


                <div style="
                    margin-top:20px;
                    width:100%;
                    height:8px;
                    background:#e2e8f0;
                    border-radius:10px;
                    overflow:hidden;
                ">

                    <div
                        id="uploadProgressBar"
                        style="
                            width:0%;
                            height:100%;
                            background:#2563eb;
                            transition:width .2s ease;
                        "
                    ></div>

                </div>


                <div
                    id="uploadProgressText"
                    style="
                        margin-top:8px;
                        font-size:13px;
                        font-weight:600;
                        color:#334155;
                    "
                >
                    0%
                </div>

            `,

            allowOutsideClick: false,

            allowEscapeKey: false,

            showConfirmButton: false

        });


        $.ajax({

            url: "<?php echo base_url('saveNewApplicant'); ?>",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            dataType: "json",

            /*
             * 2 menit.
             *
             * Jangan terlalu kecil karena CV 5MB
             * di daerah dengan koneksi lambat
             * bisa membutuhkan waktu cukup lama.
             */
            timeout: 120000,


            /* =====================================================
             * XHR
             * ===================================================== */

            xhr: function() {

                const xhr =
                    new window.XMLHttpRequest();


                /* -------------------------------------------------
                 * UPLOAD PROGRESS
                 * ------------------------------------------------- */

                xhr.upload.addEventListener(

                    "progress",

                    function(event) {

                        if (
                            event.lengthComputable
                        ) {

                            const percent =
                                Math.round(
                                    (
                                        event.loaded /
                                        event.total
                                    ) * 100
                                );


                            $("#uploadProgressBar")
                                .css(
                                    "width",
                                    percent + "%"
                                );


                            $("#uploadProgressText")
                                .text(
                                    "Mengirim CV... " +
                                    percent +
                                    "%"
                                );

                        }

                    },

                    false

                );


                return xhr;

            },


            /* =====================================================
             * SUCCESS
             * ===================================================== */

            success: function(res) {

                Swal.close();


                window.isSubmittingApplicant =
                    false;


                if (
                    res.status === "success"
                ) {

                    Swal.fire({

                        icon: "success",

                        title: "Pendaftaran Berhasil 🎉",

                        html: `
                            <div style="
                                font-size:14px;
                                line-height:1.6;
                                color:#475569;
                            ">

                                Data dan CV berhasil dikirim.

                            </div>
                        `,

                        confirmButtonText: "OK",

                        confirmButtonColor: "#2563eb"

                    }).then(function() {

                        window.location.reload();

                    });

                } else {

                    showError(

                        res.message ||
                        "Terjadi kesalahan."

                    );

                }

            },
            error: function(
                xhr,
                status,
                error
            ) {

                Swal.close();


                window.isSubmittingApplicant =
                    false;


                /* -------------------------------------------------
                 * TIMEOUT
                 * ------------------------------------------------- */

                if (
                    status === "timeout"
                ) {

                    Swal.fire({

                        icon: "warning",

                        title: "Upload Terlalu Lama",

                        html: `

                            <div style="
                                font-size:14px;
                                line-height:1.7;
                                color:#475569;
                            ">

                                Proses upload CV membutuhkan
                                waktu terlalu lama.

                                <br><br>

                                Kemungkinan koneksi internet
                                sedang terlalu lambat atau
                                tidak stabil.

                                <br><br>

                                <b>
                                    Data belum dapat dipastikan
                                    berhasil dikirim ke server.
                                </b>

                            </div>

                        `,

                        confirmButtonText: "Coba Lagi",

                        confirmButtonColor: "#2563eb"

                    });

                    return;

                }


                /* -------------------------------------------------
                 * INTERNET PUTUS
                 * ------------------------------------------------- */

                if (
                    !navigator.onLine
                ) {

                    Swal.fire({

                        icon: "warning",

                        title: "Koneksi Terputus",

                        html: `

                        <div style="
                            font-size:14px;
                            line-height:1.7;
                            color:#475569;
                        ">

                            Koneksi internet terputus
                            saat proses pengiriman CV.

                            <br><br>

                            <br>

                            Setelah koneksi kembali stabil,
                            silakan coba kirim kembali.

                        </div>

                    `,

                        confirmButtonText: "Mengerti",

                        confirmButtonColor: "#2563eb"

                    });

                    return;

                }


                /* -------------------------------------------------
                 * SERVER / NETWORK ERROR
                 * ------------------------------------------------- */

                Swal.fire({

                    icon: "error",

                    title: "Gagal Mengirim CV",

                    html: `

                    <div style="
                        font-size:14px;
                        line-height:1.7;
                        color:#475569;
                    ">

                        CV belum berhasil dikirim
                        ke server.

                        <br><br>

                        Kemungkinan penyebab:

                        <br>

                        • Koneksi internet tidak stabil

                        <br>

                        • Sinyal terlalu lemah

                        <br>

                        • Server tidak dapat dijangkau

                        <br>

                        • Proses upload terputus

                        <br><br>

                        Silakan coba kembali ketika
                        koneksi internet lebih stabil.

                    </div>

                `,

                    confirmButtonText: "Coba Lagi",

                    confirmButtonColor: "#ef4444"

                });

            }

        });

    }

    function saveNewApplicant() {


        /* ========================================================
         * PREVENT DOUBLE SUBMIT
         * ======================================================== */

        if (
            window.isSubmittingApplicant
        ) {

            return;

        }


        /* ========================================================
         * FORM DATA
         * ======================================================== */

        const formData =
            new FormData();


        /* ========================================================
         * HELPER
         * ======================================================== */

        const v = selector => {

            const el =
                $(selector);

            return el.length ?
                (el.val() || "").trim() :
                "";

        };


        /* ========================================================
         * GET FORM VALUE
         * ======================================================== */

        const email =
            v("input[name='txtemail']");


        const nama =
            v("input[name='txtnama']");


        const tempatLahir =
            v("input[name='txttempat_lahir']");


        const handphone =
            v("input[name='txthandphone']");


        const posisi =
            $("#slcRank").val();


        const ijazah =
            $("select[name='ijazah_terakhir']").val();


        const pengalaman =
            $("select[name='pengalaman_terakhir']").val();


        const ipk =
            v("#ipk_terakhir");


        const gaji =
            v("input[name='last_salary']");


        const infoSource =
            $("input[name='info_source']:checked").val();


        const tanggalLahir =
            v("input[name='txttanggal_lahir']");


        const gender =
            $("select[name='gender']").val();


        const applicantId =
            v("input[name='txtIdNewApplicant']");


        const joinDate =
            v("input[name='join_date']");


        const recruitmentId =
            $("#recruitment_id").val();


        const vesselType =
            $("#vessel_type").val();


        const expectedSalary =
            $("input[name='expected_salary']").val();


        const lastSalaryCurrency =
            $("select[name='last_salary_currency']").val();


        const expectedSalaryCurrency =
            $("select[name='expected_salary_currency']").val();


        /* ========================================================
         * VALIDASI EXPECTED SALARY CURRENCY
         * ======================================================== */

        if (
            !expectedSalaryCurrency
        ) {

            return showError(
                "Silakan pilih Expected Salary Currency."
            );

        }


        /* ========================================================
         * VALIDASI LAST SALARY CURRENCY
         * ======================================================== */

        if (
            posisi &&
            !posisi
            .toLowerCase()
            .includes("cadet") &&
            !lastSalaryCurrency
        ) {

            return showError(
                "Silakan pilih Last Salary Currency."
            );

        }


        /* ========================================================
         * POSITION
         * ======================================================== */

        if (!posisi) {

            return showError(
                "Silakan pilih jabatan yang dilamar."
            );

        }


        /* ========================================================
         * VESSEL TYPE
         * ======================================================== */

        if (!vesselType) {

            return showError(
                "Silakan pilih vessel type."
            );

        }


        /* ========================================================
         * RECRUITMENT
         * ======================================================== */

        if (!recruitmentId) {

            if (!posisi) {

                return showError(
                    "Silakan pilih rank."
                );

            }


            if (!vesselType) {

                return showError(
                    "Silakan pilih vessel type."
                );

            }

        }


        /* ========================================================
         * GENDER
         * ======================================================== */

        if (!gender) {

            return showError(
                "Silakan pilih jenis kelamin."
            );

        }


        /* ========================================================
         * REQUIRED DATA
         * ======================================================== */

        if (
            !nama ||
            !tempatLahir ||
            !handphone ||
            !posisi ||
            !ijazah ||
            !tanggalLahir
        ) {

            return showError(
                "Silakan lengkapi semua field wajib terlebih dahulu."
            );

        }


        /* ========================================================
         * INFO SOURCE
         * ======================================================== */

        if (!infoSource) {

            return showError(
                "Silakan pilih sumber informasi."
            );

        }


        /* ========================================================
         * EMAIL
         * ======================================================== */

        const emailRegex =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


        if (
            !emailRegex.test(email)
        ) {

            return showError(
                "Format email tidak valid."
            );

        }


        /* ========================================================
         * AGE
         * ======================================================== */

        const birthDate =
            new Date(tanggalLahir);


        const today =
            new Date();


        let age =
            today.getFullYear() -
            birthDate.getFullYear();


        const m =
            today.getMonth() -
            birthDate.getMonth();


        if (
            m < 0 ||
            (
                m === 0 &&
                today.getDate() <
                birthDate.getDate()
            )
        ) {

            age--;

        }


        if (
            age < 18 ||
            age > 55
        ) {

            return showError(
                "Usia pelamar harus antara 18 hingga 55 tahun."
            );

        }


        /* ========================================================
         * GENDER
         * ======================================================== */

        formData.append(
            "gender",
            gender
        );


        /* ========================================================
         * CADET
         * ======================================================== */

        if (
            posisi
            .toLowerCase()
            .includes("cadet")
        ) {


            if (!ipk) {

                return showError(
                    "Silakan isi IPK terakhir untuk posisi Cadet."
                );

            }


            const sekolah =
                v("#sekolah");


            const jurusan =
                v("#jurusan");


            if (!sekolah) {

                return showError(
                    "Silakan isi nama sekolah."
                );

            }


            if (!jurusan) {

                return showError(
                    "Silakan isi jurusan."
                );

            }


            formData.append(
                "ipk_terakhir",
                ipk
            );


            formData.append(
                "sekolah",
                sekolah
            );


            formData.append(
                "jurusan",
                jurusan
            );


            formData.append(
                "pengalaman_terakhir",
                ""
            );


            formData.append(
                "crew_foreign",
                "N"
            );


            formData.append(
                "last_salary",
                ""
            );


            formData.append(
                "last_salary_currency",
                ""
            );


            formData.append(
                "expected_salary",
                expectedSalary
            );


            formData.append(
                "expected_salary_currency",
                expectedSalaryCurrency
            );

        }


        /* ========================================================
         * NON CADET
         * ======================================================== */
        else {


            if (!pengalaman) {

                return showError(
                    "Silakan isi pengalaman terakhir."
                );

            }


            if (!gaji) {

                return showError(
                    "Silakan isi gaji terakhir."
                );

            }


            const crewForeign =
                $(
                    "input[name='crew_foreign']:checked"
                ).val();


            if (!crewForeign) {

                return showError(
                    "Silakan pilih pengalaman crew asing."
                );

            }


            formData.append(
                "pengalaman_terakhir",
                pengalaman
            );


            formData.append(
                "last_salary",
                gaji
            );


            formData.append(
                "last_salary_currency",
                lastSalaryCurrency
            );


            formData.append(
                "crew_foreign",
                crewForeign
            );


            formData.append(
                "ipk_terakhir",
                ""
            );


            formData.append(
                "expected_salary",
                expectedSalary
            );


            formData.append(
                "expected_salary_currency",
                expectedSalaryCurrency
            );


            if (
                crewForeign === "Y"
            ) {


                const foreignCountry =
                    v("input[name='foreign_country']");


                if (!foreignCountry) {

                    return showError(
                        "Silakan isi negara crew asing."
                    );

                }


                formData.append(
                    "foreign_country",
                    foreignCountry
                );

            }

        }


        /* ========================================================
         * BASIC DATA
         * ======================================================== */

        formData.append(
            "txtIdNewApplicant",
            applicantId
        );


        formData.append(
            "txtemail",
            email
        );


        formData.append(
            "txtnama",
            nama
        );


        formData.append(
            "txttempat_lahir",
            tempatLahir
        );


        formData.append(
            "txttanggal_lahir",
            tanggalLahir
        );


        formData.append(
            "txthandphone",
            handphone
        );


        formData.append(
            "position_applied",
            posisi
        );


        formData.append(
            "ijazah_terakhir",
            ijazah
        );


        formData.append(
            "pernah_join",
            $(
                "input[name='pernah_join']:checked"
            ).val() || "N"
        );


        formData.append(
            "info_source",
            infoSource
        );


        formData.append(
            "join_date",
            joinDate
        );


        formData.append(
            "recruitment_id",
            recruitmentId
        );


        formData.append(
            "vessel_type",
            vesselType
        );


        /* ========================================================
         * KAPAL
         * ======================================================== */

        $(
            "input[name='kapal[]']:checked"
        ).each(function() {

            formData.append(
                "kapal[]",
                $(this).val()
            );

        });


        /* ========================================================
         * OTHER KAPAL
         * ======================================================== */

        if (
            $("#otherKapalCheckbox")
            .is(":checked")
        ) {


            const kapalOther =
                v("input[name='kapal_other']");


            if (kapalOther) {

                formData.append(
                    "kapal[]",
                    "OTHER: " +
                    kapalOther
                );

            }

        }


        /* ========================================================
         * CV
         * ======================================================== */

        const cvInput =
            $("input[name='cv_files[]']");


        if (
            !cvInput.length ||
            cvInput[0].files.length === 0
        ) {

            return showError(
                "Silakan unggah CV."
            );

        }


        for (
            let file of cvInput[0].files
        ) {


            /* ----------------------------------------------------
             * SIZE
             * ---------------------------------------------------- */

            if (
                file.size /
                (1024 * 1024) > 5
            ) {

                return showError(
                    `File ${file.name} melebihi 5MB.`
                );

            }


            /* ----------------------------------------------------
             * EXTENSION
             * ---------------------------------------------------- */

            const extension =
                file.name
                .split(".")
                .pop()
                .toLowerCase();


            if (
                extension !== "pdf"
            ) {

                return showError(
                    `File ${file.name} harus berupa PDF.`
                );

            }


            formData.append(
                "cv_files[]",
                file
            );

        }


        /* ========================================================
         * REQUEST ID
         * ======================================================== */

        const requestId =
            "APP-" +
            Date.now() +
            "-" +
            Math.random()
            .toString(36)
            .substring(2, 8)
            .toUpperCase();


        formData.append(
            "request_id",
            requestId
        );


        console.log(
            "Applicant Request ID:",
            requestId
        );


        /* ========================================================
         * LOCK
         * ======================================================== */

        window.isSubmittingApplicant =
            true;


        /* ========================================================
         * CHECK CONNECTION
         * ======================================================== */

        showCheckingConnection();


        checkInternetConnection()

            .then(function(connection) {


                console.log(
                    "Server response time:",
                    connection.responseTime +
                    " ms"
                );


                /* =================================================
                 * CONNECTION VERY SLOW
                 * ================================================= */

                if (
                    connection.responseTime > 5000
                ) {


                    Swal.fire({

                            icon: "warning",

                            title: "Koneksi Internet Lambat",

                            html: `

                        <div style="
                            font-size:14px;
                            line-height:1.7;
                            color:#475569;
                        ">

                            Koneksi ke server terdeteksi
                            cukup lambat.

                            <br><br>

                            Waktu respons:

                            <b>
                                ${(connection.responseTime / 1000).toFixed(1)}
                                detik
                            </b>

                            <br><br>

                            Mengirim CV membutuhkan
                            koneksi yang cukup stabil.

                            <br><br>

                            <b>
                                Apakah kamu tetap ingin
                                mencoba mengirim?
                            </b>

                        </div>

                    `,

                            showCancelButton: true,

                            confirmButtonText: "Tetap Kirim CV",

                            cancelButtonText: "Batal",

                            confirmButtonColor: "#2563eb",

                            cancelButtonColor: "#64748b"

                        })

                        .then(function(result) {


                            if (
                                result.isConfirmed
                            ) {

                                uploadApplicantCV(
                                    formData
                                );

                            } else {

                                window.isSubmittingApplicant =
                                    false;

                            }

                        });


                    return;

                }


                /* =================================================
                 * CONNECTION OK
                 * ================================================= */

                uploadApplicantCV(
                    formData
                );

            })


            /* ====================================================
             * CONNECTION FAILED
             * ==================================================== */

            .catch(function(error) {


                window.isSubmittingApplicant =
                    false;


                Swal.close();


                if (
                    error.type === "offline"
                ) {

                    showConnectionError(
                        "Perangkat kamu sedang tidak terhubung ke internet."
                    );

                    return;

                }


                if (
                    error.type === "timeout"
                ) {

                    showConnectionError(
                        "Koneksi ke server terlalu lambat atau tidak stabil."
                    );

                    return;

                }


                showConnectionError(
                    "Server aplikasi tidak dapat dihubungi."
                );

            });

    }


    /* ============================================================
     * DEVICE OFFLINE
     * ============================================================ */

    window.addEventListener(
        "offline",
        function() {


            /*
             * Jangan tampilkan alert kalau sedang tidak
             * melakukan submit.
             */
            if (
                !window.isSubmittingApplicant
            ) {

                return;

            }


            Swal.fire({

                icon: "warning",

                title: "Internet Terputus",

                text: "Koneksi internet perangkat kamu terputus.",

                confirmButtonText: "Mengerti",

                confirmButtonColor: "#f59e0b"

            });

        }
    );


    /* ============================================================
     * DEVICE ONLINE AGAIN
     * ============================================================ */

    window.addEventListener(
        "online",
        function() {


            /*
             * Hanya tampilkan kalau sedang submit.
             */
            if (
                !window.isSubmittingApplicant
            ) {

                return;

            }


            Swal.fire({

                icon: "success",

                title: "Internet Terhubung",

                text: "Koneksi internet kembali tersedia.",

                timer: 2000,

                showConfirmButton: false

            });

        }
    );

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            text: message,
            confirmButtonColor: '#ef4444'
        });
    }

    function showLoading(text = 'Sedang memproses...') {
        Swal.fire({
            title: text,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
    }

    function showHiddenQuali(id, type) {
        if (type === 'show') {
            $("#qualification_" + id).css("display", "");
            $("#showQuali_" + id).attr("onclick", "showHiddenQuali(" + id + ", 'hidden')");
            $("#showQuali_" + id).text("Sembunyikan Persyaratan");
        } else {
            $("#qualification_" + id).css("display", "none");
            $("#showQuali_" + id).attr("onclick", "showHiddenQuali(" + id + ", 'show')");
            $("#showQuali_" + id).text("Persyaratan");
        }

    }

    function loadRankDropdown() {

        $('#rankContainer').html(`
            <select
                name="position_applied"
                id="slcRank"
                class="form-control"
                required>
            </select>
        `);

        $.ajax({
            url: '<?php echo base_url('getRankOptions'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(res) {

                renderRankOption(res);

                $('#slcRank').on('change', function() {
                    triggerCadetValidation();
                });
            }
        });
    }

    function loadVesselDropdown() {

        $('#vesselContainer').html(`
            <select
                name="vessel_type"
                id="vessel_type"
                class="form-control"
                required>
            </select>
        `);

        $.ajax({
            url: '<?php echo base_url('getVesselTypeOptions'); ?>',
            type: 'GET',
            success: function(res) {

                $('#vessel_type').html(JSON.parse(res));
            }
        });
    }

    function showRecruitment() {

        isOpenRecruitment = false;

        $('#recruitment_id').val('');

        loadRankDropdown();
        loadVesselDropdown();

        $('#selectedJobCard').hide();

        $('#idWelcome').hide();
        $('#formRecruitment').fadeIn();

        $('html, body').animate({
            scrollTop: $("#formRecruitment").offset().top
        }, 500);
    }

    function goBackToWelcome() {
        document.getElementById('formRecruitment').style.display = 'none';
        document.getElementById('idWelcome').style.display = 'block';
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function triggerCadetValidation() {

        let value = ($('#slcRank').val() || '').toLowerCase();

        let isCadet = value.includes('cadet');

        if (isCadet) {

            $('#pengalaman_terakhir')
                .prop('disabled', true)
                .prop('required', false)
                .val('');

            $('#ipk_terakhir')
                .removeClass('d-none')
                .prop('required', true);

            $('#labelLastExp').text('IPK Terakhir *');

            $('#groupJenisKapal').hide();
            $('#groupCrewAsing').hide();
            $('#groupSalary').hide();
            $('#groupJoin').hide();

            $('#groupSekolahJurusan').show();

        } else {

            $('#pengalaman_terakhir')
                .prop('disabled', false)
                .prop('required', true);

            $('#ipk_terakhir')
                .addClass('d-none')
                .prop('required', false);

            $('#labelLastExp').text('Pengalaman / Jabatan Terakhir *');

            $('#groupJenisKapal').show();
            $('#groupCrewAsing').show();
            $('#groupSalary').show();
            $('#groupJoin').show();

            $('#groupSekolahJurusan').hide();
        }
    }
    $(document).ready(function() {
        $("#alasanGabung").on("input", function() {
            let text = $(this).val().trim();
            let words = text.split(/\s+/).filter(w => w.length > 0);
            let count = words.length;

            $("#4")
                .text(count + " / 150 kata")
                .css("color", count > 150 ? "red" : "#666");
        });
    });

    function toggleStepNumber(isCadet) {
        const $divExperience = $("#divExperience");
        const $stepExperience = $("#stepExperienceNumber");
        const $stepOther = $("#stepOtherNumber");

        if (isCadet) {
            $divExperience.slideUp(300);

            $stepOther.text("02");
        } else {
            $divExperience.slideDown(300);

            $stepExperience.text("02");
            $stepOther.text("03");
        }
    }

    $(document).ready(function() {
        let $posApplied = $("select[name='position_applied']");
        let $lastExpSelect = $("#pengalaman_terakhir");
        let $ipkInput = $("#ipk_terakhir");
        let $label = $("#labelLastExp");

        let $groupJenisKapal = $("#groupJenisKapal");
        let $groupCrewAsing = $("#groupCrewAsing");
        let $groupSalary = $("#groupSalary");
        let $groupJoin = $("#groupJoin");
        let $groupSekolahJurusan = $("#groupSekolahJurusan");

        function hideGroup($group) {
            if ($group.length) {
                $group.hide();
                $group.find("input, select, textarea").removeAttr("required");
            }
        }

        function showGroup($group) {
            if ($group.length) {
                $group.show();
                $group.find("input, select, textarea").attr("required", true);
            }
        }

        function toggleLastExp() {
            const isCadet = ($posApplied.val() || "").toLowerCase().includes("cadet");

            if (isCadet) {
                $lastExpSelect.addClass("d-none").removeAttr("required").val("");
                $ipkInput.removeClass("d-none").attr("required", true);
                $label.text("IPK Terakhir *");

                hideGroup($groupJenisKapal);
                hideGroup($groupCrewAsing);
                hideGroup($groupSalary);
                hideGroup($groupJoin);

                showGroup($groupSekolahJurusan);
            } else {
                $lastExpSelect.removeClass("d-none").attr("required", true);
                $ipkInput.addClass("d-none").removeAttr("required").val("");
                $label.text("Pengalaman / Jabatan Terakhir *");

                showGroup($groupJenisKapal);
                showGroup($groupCrewAsing);
                showGroup($groupSalary);
                showGroup($groupJoin);

                hideGroup($groupSekolahJurusan);
            }

            toggleStepNumber(isCadet);
        }

        $posApplied.on("change", toggleLastExp);
        toggleLastExp();
    });

    $(document).ready(function() {
        loadOpenRecruitment();
    });

    function loadOpenRecruitment() {
        $.ajax({
            url: "<?php echo base_url('getOpenRecruitment'); ?>",
            type: "POST",
            dataType: "json",
            success: function(res) {
                if (res.status) {
                    renderRankOption(res.rankOption);
                }
            }
        });
    }

    function renderRankOption(data) {

        let html = '<option value="">- Select Rank -</option>';

        for (let i = 0; i < data.length; i++) {

            html += `
                <option value="${data[i].name}">
                    ${data[i].name}
                </option>
            `;
        }

        $('#slcRank').html(html);
        $('#pengalaman_terakhir').html(html);
    }

    document.addEventListener("DOMContentLoaded", function() {

        const wrappers = document.querySelectorAll('.vessel-wrapper');

        wrappers.forEach((wrapper) => {

            const header = wrapper.querySelector('.vessel-header');

            header.addEventListener('click', function(e) {
                e.stopPropagation();

                let isOpen = wrapper.classList.contains('active');

                wrappers.forEach(w => w.classList.remove('active'));

                if (!isOpen) {
                    wrapper.classList.add('active');
                }

            });

        });

    });

    let isOpenRecruitment = false;

    function selectRecruitment(id, vesselType, rank) {

        isOpenRecruitment = true;

        $('#recruitment_id').val(id);

        // Rank readonly
        $('#rankContainer').html(`
            <input
                type="text"
                name="position_applied"
                id="slcRank"
                readonly
                class="form-control"
                style="
                    border-radius:14px;
                    padding:14px;
                    background:#f8fafc;
                    font-weight:700;
                ">
        `);

        // Vessel readonly
        $('#vesselContainer').html(`
            <input
                type="text"
                name="vessel_type"
                id="vessel_type"
                readonly
                class="form-control"
                style="
                    border-radius:14px;
                    padding:14px;
                    background:#f8fafc;
                    font-weight:700;
                ">
        `);

        $('#slcRank').val(rank);
        $('#vessel_type').val(vesselType);

        $('#selectedRank').html(rank);
        $('#selectedVessel').html(vesselType);

        $('#selectedJobCard').show();

        $('#idWelcome').hide();
        $('#formRecruitment').fadeIn();

        $('html, body').animate({
            scrollTop: $("#formRecruitment").offset().top
        }, 500);

        triggerCadetValidation();
    }

    $(document).ready(function() {

        $(".vesselJobs").hide().removeClass("opened");

        $(".toggleIcon").css({
            transform: "rotate(0deg)"
        });

    });

    $(document).on("click", ".vesselToggle", function() {

        const parent = $(this).closest("div");
        const jobs = $(this).next(".vesselJobs");
        const icon = $(this).find(".toggleIcon");

        if (!jobs.hasClass("opened")) {

            jobs
                .addClass("opened")
                .css("display", "block")
                .hide()
                .slideDown(260);

            icon.css({
                transform: "rotate(-180deg)",
                background: "#2563eb",
                color: "#fff"
            });

            parent.css({
                transform: "translateY(-2px)",
                boxShadow: "0 20px 45px rgba(15,23,42,.08)"
            });

        } else {

            jobs
                .removeClass("opened")
                .slideUp(220);

            icon.css({
                transform: "rotate(0deg)",
                background: "#eff6ff",
                color: "#2563eb"
            });

            parent.css({
                transform: "translateY(0)",
                boxShadow: "0 12px 40px rgba(15,23,42,.05)"
            });
        }

    });

    window.addEventListener("load", () => setTimeout(() => new bootstrap.Modal(document.getElementById(
        "modalBewareScam")).show(), 300));

    function closeBewareScam() {

        $("#modalBewareScam").modal("hide");

    }
    </script>
    <style>
    body {
        background: #eef2f7;
        font-family: Segoe UI, Tahoma, sans-serif
    }

    @media(max-width:768px) {
        .hero {
            flex-direction: column !important
        }

        .grid1,
        .grid2 {
            grid-template-columns: 1fr !important
        }

        .title {
            font-size: 34px !important
        }
    }

    .modal-content {
        border: none;
        border-radius: 22px;
        overflow: hidden
    }

    .modal-backdrop.show {
        opacity: .65;
    }

    .vessel-content {
        overflow: hidden;
        max-height: 0;
        transition: max-height 0.4s ease;
    }

    .vessel-wrapper.active .vessel-content {
        max-height: 9999px;
    }

    .vessel-header.active .icon {
        transform: rotate(180deg);
    }

    .vessel-header:hover {
        background: #e2e8f0;
    }

    @keyframes popupAnimation {

        from {

            opacity: 0;
            transform: translateY(25px) scale(.96);

        }

        to {

            opacity: 1;
            transform: translateY(0) scale(1);

        }

    }
    </style>
</head>

<body>

    <div class="modal fade" id="modalBewareScam" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="max-width:760px">
            <div class="modal-content" style="
                border:none;
                border-radius:18px;
                overflow:hidden;
                max-height:calc(100vh - 50px);
            ">
                <div style="
                    background:linear-gradient(135deg,#b91c1c 0%,#dc2626 60%,#ef4444 100%);
                    color:#fff;
                    padding:18px 20px;
                    position:relative;
                    
                    ">

                    <!-- Decorative -->
                    <div style="
                        position:absolute;
                        width:120px;
                        height:120px;
                        border-radius:50%;
                        background:rgba(255,255,255,.08);
                        top:-55px;
                        right:-45px;
                    "></div>

                    <div style="
                        position:absolute;
                        width:90px;
                        height:90px;
                        border-radius:50%;
                        background:rgba(255,255,255,.05);
                        bottom:-45px;
                        left:-35px;
                    "></div>

                    <div style="
                            position:relative;
                            z-index:2;
                            display:flex;
                            align-items:flex-start;
                            gap:14px;
                        ">

                        <!-- Icon -->
                        <div style="
                            width:50px;
                            height:50px;
                            min-width:50px;
                            border-radius:14px;
                            background:rgba(255,255,255,.15);
                            display:flex;
                            justify-content:center;
                            align-items:center;
                            font-size:24px;
                        ">
                            🚨
                        </div>

                        <div style="flex:1;">

                            <!-- Badge -->
                            <div style="
                                display:inline-block;
                                padding:5px 12px;
                                border-radius:999px;
                                background:rgba(255,255,255,.16);
                                font-size:11px;
                                font-weight:700;
                                letter-spacing:.6px;
                                margin-bottom:10px;
                            ">
                                ⚠️ BEWARE OF SCAM
                            </div>

                            <!-- Title -->
                            <div style="
                                font-size:20px;
                                font-weight:800;
                                line-height:1.2;
                                margin-bottom:8px;
                            ">
                                Hati-Hati Terhadap Penipuan Rekrutmen
                            </div>

                            <div style="
                                font-size:14px;
                                line-height:1.6;
                                opacity:.95;
                            ">
                                <strong>Andhika Group</strong> tidak pernah memungut biaya dalam bentuk apa pun selama
                                proses rekrutmen.
                            </div>

                        </div>

                    </div>

                    <div style="
                        margin-top:16px;
                        display:grid;
                        grid-template-columns:1fr 1fr;
                        gap:10px;
                    ">

                        <div style="
                            background:rgba(255,255,255,.10);
                            padding:12px;
                            border-radius:10px;
                            font-size:13px;
                            line-height:1.55;
                        ">
                            💰 Tidak ada biaya administrasi.
                        </div>

                        <div style="
                            background:rgba(255,255,255,.10);
                            padding:12px;
                            border-radius:10px;
                            font-size:13px;
                            line-height:1.55;
                        ">
                            📱 Abaikan pihak yang meminta transfer uang.
                        </div>

                        <div style="
                            background:rgba(255,255,255,.10);
                            padding:12px;
                            border-radius:10px;
                            font-size:13px;
                            line-height:1.55;
                        ">
                            📄 Waspadai surat panggilan kerja yang meminta pembayaran.
                        </div>

                        <div style="
                            background:rgba(255,255,255,.10);
                            padding:12px;
                            border-radius:10px;
                            font-size:13px;
                            line-height:1.55;
                        ">
                            🏦 Jangan transfer ke rekening pribadi maupun perusahaan.
                        </div>
                    </div>

                </div>

                <div class="modal-body" style="margin:0;padding:0;overflow:auto;max-height:calc(100vh - 200px)">
                    <div style="padding:22px;background:#fafbfd">
                        <div
                            style="margin-top:16px;padding:16px;background:#eaf3ff;border:1px solid #bfd9ff;border-radius:12px;text-align:center;color:#1e3a8a">
                            ℹ️ Seluruh proses rekrutmen di Andhika Group tidak dipungut biaya (free of charge). Harap
                            berhati-hati terhadap segala bentuk penipuan yang mengatasnamakan Andhika Group.</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center"><button class="btn btn-primary px-4"
                        data-bs-dismiss="modal">Saya Mengerti</button></div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 sticky-top">
        <a class="navbar-brand fw-bold text-primary">
            <img src="<?php echo base_url("/assets/img/banner/andhika.png");?>" class="rounded-circle rounded-pill"
                width="150">
        </a>
    </nav>
    <section id="idWelcome" style="
        margin:35px 35px;
        font-family:'Segoe UI',sans-serif;
    ">

        <header style="text-align:center;margin-bottom:40px;">


            <h2 style="
                margin-top:25px;
                font-size:15px;
                font-weight:800;
                color:#1e3a8a;
            ">
                Informasi Penting Sebelum Melamar
            </h2>

            <p style="color:#6b7280;font-size:15px;">
                Pastikan Anda membaca seluruh informasi berikut sebelum melanjutkan.
            </p>
        </header>

        <article style="
                position:relative;
                margin-bottom:60px;
                padding:36px;
                border-radius:24px;
                background:linear-gradient(145deg,#ffffff,#f8fafc);
                border:1px solid rgba(15,23,42,0.06);
                box-shadow:0 15px 40px rgba(0,0,0,0.05);
                overflow:hidden;
            ">

            <div style="
                position:absolute;
                top:0;
                left:0;
                right:0;
                height:5px;
                background:linear-gradient(90deg,#1e3a8a,#2563eb,#60a5fa);
            "></div>

            <h4 style="
                font-weight:800;
                font-size:15px;
                margin-bottom:28px;
                color:#0f172a;
                letter-spacing:.3px;
            ">
                📄 Ketentuan Melamar
            </h4>

            <ul style="
                list-style:none;
                padding:0;
                margin:0;
            ">

                <li style="
                    display:flex;
                    gap:16px;
                    align-items:flex-start;
                    margin-bottom:20px;
                ">
                    <span style="
                        min-width:28px;
                        height:28px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:50%;
                        background:linear-gradient(135deg,#2563eb,#1e40af);
                        color:#fff;
                        font-size:13px;
                        font-weight:700;
                        box-shadow:0 6px 14px rgba(37,99,235,0.35);
                    ">1</span>

                    <span style="
                        font-size:15px;
                        color:#334155;
                        line-height:1.8;
                    ">
                        Pastikan seluruh dokumen dan data diisi <b>lengkap dan benar</b>.
                    </span>
                </li>

                <li style="
                        display:flex;
                        gap:16px;
                        align-items:flex-start;
                        margin-bottom:20px;
                    ">
                    <span style="
                        min-width:28px;
                        height:28px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:50%;
                        background:linear-gradient(135deg,#2563eb,#1e40af);
                        color:#fff;
                        font-size:13px;
                        font-weight:700;
                        box-shadow:0 6px 14px rgba(37,99,235,0.35);
                    ">2</span>

                    <span style="
                        font-size:15px;
                        color:#334155;
                        line-height:1.8;
                    ">
                        Sistem melakukan seleksi otomatis berdasarkan kelengkapan data.
                    </span>
                </li>

                <!-- Premium Warning Box -->
                <li style="
                    display:flex;
                    gap:16px;
                    align-items:flex-start;
                    margin-bottom:24px;
                    padding:18px 22px;
                    border-radius:16px;
                    background:linear-gradient(145deg,#fef2f2,#fee2e2);
                    border:1px solid #fecaca;
                ">
                    <span style="
                        min-width:30px;
                        height:30px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:50%;
                        background:#dc2626;
                        color:#fff;
                        font-size:14px;
                        font-weight:800;
                        box-shadow:0 6px 16px rgba(220,38,38,0.4);
                    ">3</span>

                    <span style="
                        font-size:15px;
                        color:#991b1b;
                        line-height:1.8;
                        font-weight:600;
                    ">
                        Dokumen tidak lengkap atau tidak sesuai berpotensi ditolak sistem.
                    </span>
                </li>

                <li style="
                    display:flex;
                    gap:16px;
                    align-items:flex-start;
                ">
                    <span style="
                        min-width:28px;
                        height:28px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:50%;
                        background:linear-gradient(135deg,#2563eb,#1e40af);
                        color:#fff;
                        font-size:13px;
                        font-weight:700;
                        box-shadow:0 6px 14px rgba(37,99,235,0.35);
                    ">4</span>

                    <span style="
                        font-size:15px;
                        color:#334155;
                        line-height:1.8;
                    ">
                        Jika tidak ada respons dalam 14 hari setelah pengajuan lamaran, berarti Anda belum memenuhi
                        kriteria untuk posisi yang dilamar.
                    </span>
                </li>

            </ul>

        </article>


        <aside style="
            position:relative;
            margin-bottom:50px;
            padding:28px 30px;
            border-radius:20px;
            background:linear-gradient(145deg,#ffffff,#f8fafc);
            border:1px solid rgba(220,38,38,0.15);
            box-shadow:0 15px 40px rgba(0,0,0,0.05);
            overflow:hidden;
        ">

            <!-- Top alert accent bar -->
            <div style="
                position:absolute;
                top:0;
                left:0;
                right:0;
                height:5px;
                background:linear-gradient(90deg,#dc2626,#ef4444,#f87171);
            "></div>

            <div style="
                display:flex;
                gap:18px;
                align-items:flex-start;
            ">

                <!-- Icon Circle -->
                <div style="
                    min-width:50px;
                    height:50px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    border-radius:50%;
                    background:linear-gradient(135deg,#dc2626,#b91c1c);
                    color:#ffffff;
                    font-size:22px;
                    font-weight:800;
                    box-shadow:0 10px 25px rgba(220,38,38,0.35);
                ">
                    ⚠
                </div>

                <div>

                    <div style="
                        font-size:13px;
                        font-weight:800;
                        color:#991b1b;
                        margin-bottom:8px;
                        letter-spacing:.4px;
                    ">
                        Penting - Informasi Resmi Rekrutmen
                    </div>

                    <div style="
                        font-size:15px;
                        color:#374151;
                        line-height:1.9;
                    ">
                        <strong style="color:#111827;">Andhika Group</strong>
                        <u style="text-decoration-color:#dc2626;">tidak memungut biaya apapun</u>
                        dalam seluruh proses rekrutmen.

                        <br><br>

                        Waspadai segala bentuk penipuan yang mengatasnamakan perusahaan
                        dan meminta sejumlah pembayaran.
                    </div>

                </div>

            </div>

        </aside>

        <article style="margin-bottom:60px;">
            <h4 style="
                font-weight:800;
                font-size:15px;
                color:#0f172a;
                margin-bottom:28px;
            ">
                Posisi / Jabatan yang Dibuka
            </h4>

            <section style="
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(420px,1fr));
                gap:32px;
                width:100%;
            ">
                <?php echo $liNamaJabatan; ?>
            </section>
        </article>

        <div style="
            display:flex;
            flex-direction:column;
            align-items:center;
            gap:18px;
            margin-bottom:50px;
        ">
            <div style="
                background:#f8fafc;
                border:1px solid #e2e8f0;
                border-radius:14px;
                padding:16px 24px;
                max-width:700px;
                text-align:center;
                box-shadow:0 4px 12px rgba(15,23,42,0.05);
            ">
                <div style="
                    font-size:16px;
                    font-weight:700;
                    color:#0f172a;
                    margin-bottom:6px;
                ">
                    Posisi yang Anda Cari Belum Tersedia?
                </div>

                <div style="
                    font-size:14px;
                    line-height:1.8;
                    color:#64748b;
                ">
                    Kirimkan CV Anda ke Talent Pool kami agar profil Anda dapat dipertimbangkan untuk peluang kerja yang
                    sesuai di masa mendatang. Tim rekrutmen akan menghubungi Anda apabila terdapat posisi yang relevan
                </div>

                <button id="btnNext" onclick="showRecruitment()" style="
                    padding: 20px 20px;
                    background:linear-gradient(135deg,#1976d2,#1565c0);
                    color:#fff;
                    border:none;
                    border-radius:40px;
                    font-size:16px;
                    font-weight:700;
                    cursor:pointer;
                    box-shadow:0 8px 24px rgba(25,118,210,0.30);
                    transition:all .3s ease;
                ">
                    Bergabung dengan Talent Pool Kami!
                </button>

            </div>


    </section>

    <div id="formRecruitment" style="
        display:none;
        margin:40px auto;
        padding:20px 20px;">
        <!-- Header Container -->
        <div style="
            display:flex;
            flex-direction:column;
            gap:18px;
            margin-bottom:36px;
        ">

            <div style="display:flex;align-items:center;gap:12px;">
                <button type="button" onclick="goBackToWelcome()" style="
                    display:flex;
                    align-items:center;
                    gap:10px;
                    background:#ffffff;
                    border:1px solid #e5e7eb;
                    padding:10px 18px;
                    border-radius:14px;
                    font-size:14px;
                    font-weight:600;
                    color:#1e3a8a;
                    cursor:pointer;
                    box-shadow:0 4px 14px rgba(0,0,0,.04);
                    transition:all .2s ease;
                " onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                    <span style="
                        width:26px;
                        height:26px;
                        border-radius:8px;
                        background:#2563eb;
                        color:#ffffff;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:13px;
                    ">
                        ←
                    </span>
                    Kembali
                </button>
            </div>

            <!-- Title -->
            <div style="
                display:flex;
                align-items:flex-start;
                justify-content:space-between;
                gap:20px;
                flex-wrap:wrap;
            ">
                <div>
                    <h1 style="
                        margin:0;
                        font-size:26px;
                        font-weight:900;
                        color:#0f172a;
                        letter-spacing:-0.3px;
                    ">
                        Form Recruitment Crew
                    </h1>

                    <div id="selectedJobCard" style="
                        display:none;
                        position:relative;
                        overflow:hidden;
                        margin-top:24px;
                        border-radius:28px;
                        padding:28px;
                        background:
                            linear-gradient(
                                135deg,
                                #0f172a 0%,
                                #1e3a8a 45%,
                                #2563eb 100%
                            );
                        box-shadow:0 24px 50px rgba(37,99,235,.22);
                    ">

                        <!-- Decorative Blur -->
                        <div style="
                            position:absolute;
                            top:-60px;
                            right:-60px;
                            width:180px;
                            height:180px;
                            border-radius:50%;
                            background:rgba(255,255,255,.08);
                        "></div>

                        <div style="
                            position:absolute;
                            bottom:-70px;
                            left:-50px;
                            width:160px;
                            height:160px;
                            border-radius:50%;
                            background:rgba(255,255,255,.05);
                        "></div>

                        <!-- Content -->
                        <div style="position:relative;z-index:2;">

                            <!-- Header -->
                            <div style="
                                display:flex;
                                justify-content:space-between;
                                align-items:flex-start;
                                gap:20px;
                                flex-wrap:wrap;
                                margin-bottom:26px;
                            ">

                                <div>

                                    <div style="
                                        display:inline-flex;
                                        align-items:center;
                                        gap:8px;
                                        padding:8px 14px;
                                        border-radius:999px;
                                        background:rgba(255,255,255,.12);
                                        color:#ffffff;
                                        font-size:12px;
                                        font-weight:700;
                                        letter-spacing:.4px;
                                        backdrop-filter:blur(8px);
                                    ">
                                        ⚓ SELECTED POSITION
                                    </div>

                                    <div style="
                                        margin-top:18px;
                                        font-size:30px;
                                        font-weight:900;
                                        line-height:1.2;
                                        color:#ffffff;
                                        letter-spacing:-0.7px;
                                    " id="selectedRank"></div>

                                </div>

                                <!-- Status -->
                                <div style="
                                    background:rgba(255,255,255,.10);
                                    border:1px solid rgba(255,255,255,.14);
                                    border-radius:18px;
                                    padding:14px 18px;
                                    backdrop-filter:blur(10px);
                                    min-width:170px;
                                ">

                                    <div style="
                                        font-size:11px;
                                        font-weight:700;
                                        color:rgba(255,255,255,.75);
                                        letter-spacing:.5px;
                                        margin-bottom:8px;
                                    ">
                                        RECRUITMENT STATUS
                                    </div>

                                    <div style="
                                        display:flex;
                                        align-items:center;
                                        gap:8px;
                                        color:#ffffff;
                                        font-size:14px;
                                        font-weight:800;
                                    ">
                                        <span style="
                                            width:10px;
                                            height:10px;
                                            border-radius:50%;
                                            background:#4ade80;
                                            box-shadow:0 0 12px #4ade80;
                                        "></span>

                                        OPEN RECRUITMENT
                                    </div>

                                </div>

                            </div>

                            <!-- Vessel Card -->
                            <div style="
                                display:flex;
                                align-items:center;
                                gap:18px;
                                padding:20px;
                                border-radius:22px;
                                background:rgba(255,255,255,.10);
                                border:1px solid rgba(255,255,255,.14);
                                backdrop-filter:blur(10px);
                            ">

                                <!-- Icon -->
                                <div style="
                                    width:70px;
                                    height:70px;
                                    border-radius:22px;
                                    background:rgba(255,255,255,.14);
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:32px;
                                    color:#ffffff;
                                    box-shadow:0 10px 25px rgba(0,0,0,.15);
                                    flex-shrink:0;
                                ">
                                    🚢
                                </div>

                                <!-- Vessel Info -->
                                <div style="flex:1;min-width:0;">

                                    <div style="
                                        font-size:12px;
                                        font-weight:700;
                                        color:rgba(255,255,255,.7);
                                        letter-spacing:.5px;
                                        margin-bottom:8px;
                                    ">
                                        SELECTED VESSEL TYPE
                                    </div>

                                    <div style="
                                        font-size:22px;
                                        font-weight:900;
                                        color:#ffffff;
                                        line-height:1.3;
                                        word-break:break-word;
                                    " id="selectedVessel"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div style="
                        margin-top:6px;
                        font-size:14px;
                        color:#64748b;
                        max-width:680px;
                        line-height:1.6;
                    ">
                        Silakan lengkapi data dengan benar. Sistem akan melakukan
                        <strong style="color:#334155;">validasi</strong>
                        sebelum proses pengiriman.
                    </div>
                </div>

                <div style="
                    background:linear-gradient(135deg,#2563eb,#1e40af);
                    color:#ffffff;
                    padding:10px 16px;
                    border-radius:999px;
                    font-size:13px;
                    font-weight:700;
                    box-shadow:0 6px 18px rgba(37,99,235,.35);
                    white-space:nowrap;
                ">
                    Recruitment System
                </div>
            </div>

            <div style="
                height:1px;
                background:linear-gradient(
                    to right,
                    #e5e7eb,
                    #c7d2fe,
                    #e5e7eb
                );
                margin-top:12px;
            "></div>

        </div>

        <div style="
            background:#ffffff;
            border-radius:22px;
            padding:32px 34px;
            margin-bottom:34px;
            box-shadow:0 12px 40px rgba(15,23,42,.06);
            border:1px solid #e5e7eb;
            position:relative;
        ">

            <div style="
                position:absolute;
                top:0; left:0;
                height:5px;
                width:0%;
                background:linear-gradient(90deg,#2563eb,#1e40af);
                animation:accentLoad .9s ease-out forwards;
            "></div>

            <div class="row" style="margin-bottom:28px;">

                <div class="col-md-4 col-12">

                    <label style="font-weight:600;color:#374151;margin-bottom:6px;display:block;">
                        Jabatan yang Dilamar <span style="color:#dc2626">*</span>
                    </label>

                    <div id="rankContainer">

                        <input type="text" name="position_applied" id="slcRank" readonly class="form-control" style="
                            border-radius:14px;
                            padding:14px;
                            background:#f8fafc;
                            font-weight:700;
                        ">

                    </div>

                </div>

                <div class="col-md-4 col-12">

                    <label style="font-weight:600;color:#374151;margin-bottom:6px;display:block;">
                        Vessel Type <span style="color:#dc2626">*</span>
                    </label>

                    <div id="vesselContainer">

                        <input type="text" name="vessel_type" id="vessel_type" readonly class="form-control" style="
                            border-radius:14px;
                            padding:14px;
                            background:#f8fafc;
                            font-weight:700;
                        ">

                    </div>

                </div>

            </div>


            <div style="
                display:flex;
                align-items:center;
                gap:14px;
                margin-bottom:28px;
                padding-bottom:16px;
                border-bottom:1px solid #e5e7eb;
            ">
                <div id="basicData" style="
                    width:44px;
                    height:44px;
                    border-radius:14px;
                    background:#2563eb;
                    color:#fff;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-weight:800;
                    font-size:14px;
                    box-shadow:0 6px 18px rgba(37,99,235,.35);
                ">
                    01
                </div>
                <div>
                    <div style="font-size:15px;font-weight:800;color:#111827;">
                        Data Diri
                    </div>
                    <div style="font-size:13px;color:#6b7280;">
                        Informasi dasar kandidat
                    </div>
                </div>
            </div>

            <!-- FORM -->
            <div class="row g-3">
                <!-- Email -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">Email *</label>
                    <input type="email" name="txtemail" required class="form-control"
                        style="border-radius:14px;padding:13px;">
                </div>

                <!-- Nama -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">Nama Lengkap *</label>
                    <input type="text" name="txtnama" required class="form-control"
                        style="border-radius:14px;padding:13px;">
                </div>

                <!-- Tempat Lahir -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">Tempat Lahir *</label>
                    <input type="text" name="txttempat_lahir" required class="form-control"
                        style="border-radius:14px;padding:13px;">
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">Tanggal Lahir *</label>
                    <input type="date" name="txttanggal_lahir" required class="form-control"
                        style="border-radius:14px;padding:13px;">
                </div>

                <!-- Gender -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">Jenis Kelamin *</label>
                    <div style="position:relative;">
                        <select name="gender" required style="
                            width:100%;
                            appearance:none;
                            background:#fff;
                            border-radius:14px;
                            padding:14px 44px 14px 14px;
                            border:1px solid #d1d5db;
                            font-size:14px;
                            color:#111827;
                        ">
                            <option value="">- PILIH -</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                </div>

                <!-- Phone -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">No. WhatsApp *</label>
                    <input type="tel" name="txthandphone" required class="form-control" placeholder="08xxxxxxxxxx"
                        style="border-radius:14px;padding:13px;">
                </div>

                <!-- Certificate -->
                <div class="col-md-3 col-12">
                    <label style="font-weight:600;font-size:13px;">Ijazah / Sertifikat *</label>
                    <div style="position:relative;">
                        <select name="ijazah_terakhir" required style="
                            width:100%;
                            appearance:none;
                            background:#ffffff;
                            border-radius:14px;
                            padding:14px 44px 14px 14px;
                            border:1px solid #d1d5db;
                            font-size:14px;
                            font-weight:500;
                        ">
                            <option value="">- PILIH -</option>
                            <option value="ANT I">ANT I</option>
                            <option value="ANT II">ANT II</option>
                            <option value="ANT III">ANT III</option>
                            <option value="ANT IV">ANT IV</option>
                            <option value="ANT V">ANT V</option>
                            <option value="ATT I">ATT I</option>
                            <option value="ATT II">ATT II</option>
                            <option value="ATT III">ATT III</option>
                            <option value="ATT IV">ATT IV</option>
                            <option value="ATT V">ATT V</option>
                            <option value="ETO">ETO</option>
                            <option value="ETR">ETR</option>
                            <option value="RATING AS ABLE SEAFARER DECK ">RATING AS ABLE SEAFARER DECK </option>
                            <option value="RATINGS FORMING PART OF NAVIGATION WATCH">RATINGS FORMING PART OF NAVIGATION
                                WATCH</option>
                            <option value="RATING AS ABLE ENGINE">RATING AS ABLE ENGINE</option>
                            <option value="RATINGS FORMING PART OF A WATCH ENGINE ROOM">RATINGS FORMING PART OF A WATCH
                                ENGINE ROOM</option>
                            <option value="BASIC SAFETY TRAINING">BASIC SAFETY TRAINING</option>
                            <option value="SIO">SIO</option>
                            <option value="WELDER CERTIFICATE">WELDER CERTIFICATE</option>
                            <option value="FOOD HANDLING">FOOD HANDLING</option>
                            <option value="SHIP COOK">SHIP COOK</option>
                        </select>

                    </div>

                </div>

                <!-- Experience / IPK -->
                <div class="col-md-3 col-12">
                    <label id="labelLastExp" style="font-weight:600;font-size:13px;">
                        Pengalaman / Jabatan Terakhir *
                    </label>

                    <div style="position:relative;">
                        <select id="pengalaman_terakhir" name="pengalaman_terakhir" required style="
                            width:100%;
                            appearance:none;
                            background:#ffffff;
                            border-radius:14px;
                            padding:14px 44px 14px 14px;
                            border:1px solid #d1d5db;
                            font-size:14px;
                            font-weight:500;
                            color:#111827;
                            box-shadow:0 1px 2px rgba(0,0,0,.04);
                            cursor:pointer;
                            transition:all .2s ease;
                        ">
                            <option value="">- PILIH -</option>
                        </select>
                    </div>

                    <input type="number" step="0.01" min="0" max="4" id="ipk_terakhir" name="ipk_terakhir"
                        class="form-control d-none" placeholder="Contoh: 3.25" style="border-radius:14px;padding:13px;">
                </div>
            </div>

            <!-- School -->
            <div class="row g-3 mt-2" id="groupSekolahJurusan" style="display:none;">
                <div class="col-md-6">
                    <label style="font-weight:600;font-size:13px;">Sekolah *</label>
                    <input type="text" name="sekolah" id="sekolah" class="form-control"
                        style="border-radius:14px;padding:13px;">
                </div>
                <div class="col-md-6">
                    <label style="font-weight:600;font-size:13px;">Jurusan *</label>
                    <input type="text" name="jurusan" id="jurusan" x` class="form-control"
                        style="border-radius:14px;padding:13px;">
                </div>
            </div>

            <!-- CV -->
            <div class="row mt-3">
                <div class="col-md-6 col-12">
                    <label style="font-weight:600;font-size:13px;">CV Terbaru *</label>
                    <input type="file" name="cv_files[]" class="form-control" accept=".pdf" multiple required>
                    <div style="font-size:12px;color:#dc2626;margin-top:4px;">
                        Maks. 5MB · PDF Only
                    </div>
                    <div id="cvPreviewContainer" class="mt-2"></div>
                </div>
            </div>

        </div>


        <div id="divExperience" style="
            background:#ffffff;
            border-radius:22px;
            padding:32px 34px;
            margin-bottom:34px;
            box-shadow:0 12px 40px rgba(15,23,42,.06);
            border:1px solid #e5e7eb;
            position:relative;
        ">

            <div style="
                position:absolute;
                top:0; left:0;
                height:5px;
                width:0%;
                background:linear-gradient(90deg,#2563eb,#1e40af);
                animation:accentLoad .9s ease-out forwards;
            "></div>

            <!-- Step Header -->
            <div style="
                display:flex;
                align-items:center;
                gap:14px;
                margin-bottom:28px;
                padding-bottom:16px;
                border-bottom:1px solid #e5e7eb;
            ">
                <div style="
                    width:44px;
                    height:44px;
                    border-radius:14px;
                    background:#2563eb;
                    color:#fff;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-weight:800;
                    font-size:14px;
                    box-shadow:0 6px 18px rgba(37,99,235,.35);
                " id="stepExperienceNumber">
                    02
                </div>
                <div>
                    <div style="font-size:15px;font-weight:800;color:#111827;">
                        Experience
                    </div>
                    <div style="font-size:13px;color:#6b7280;">
                        Riwayat pengalaman pelayaran & lingkungan kerja
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="row g-4">

                <!-- Vessel Type Experience -->
                <div class="col-md-6 col-12">
                    <label style="font-weight:700;font-size:13px;color:#374151;display:block;margin-bottom:10px;">
                        Pengalaman Berlayar di Jenis Kapal <span style="color:#dc2626">*</span>
                    </label>

                    <div style="
                        border:1px solid #e5e7eb;
                        border-radius:16px;
                        padding:18px;
                        background:#f9fafb;
                    ">
                        <div class="row row-cols-2 g-2">

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="AHTS DP2"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                AHTS DP2
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="AHTS LCT & SSRV"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                AHTS, LCT & SSRV
                            </label>

                            <label style="
                                        display:flex;align-items:center;gap:10px;
                                        background:#ffffff;border:1px solid #e5e7eb;
                                        border-radius:12px;padding:10px 12px;
                                        font-size:13px;cursor:pointer;
                                    ">
                                <input type="checkbox" name="kapal[]" value="BULK CARRIER"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                BULK CARRIER
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="CARGO"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                CARGO
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="GENERAL CARGO"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                GENERAL CARGO
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="CONTAINER"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                CONTAINER
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="TANKER PRODUCT"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                TANKER PRODUCT
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="TANKER OIL"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                TANKER CRUDE
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="CRUDE OIL"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                TANKER OIL
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="TANKER CHEMICAL"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                TANKER CHEMICAL
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="TANKER GAS"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                TANKER GAS
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="FLOATING CRANE"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                FLOATING CRANE
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="TUG BOAT"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                TUG BOAT
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="SUPPLY VESSEL"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                SUPPLY VESSEL
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="CREW BOAT"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                CREW BOAT
                            </label>

                            <label
                                style="display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:10px 12px;font-size:13px;cursor:pointer;">
                                <input type="checkbox" name="kapal[]" value="RORO/PASSENGER"
                                    style="width:16px;height:16px;accent-color:#2563eb;">
                                RORO / PASSENGER
                            </label>


                        </div>

                        <!-- OTHER -->
                        <label style="
                                    display:flex;align-items:center;gap:10px;
                                    background:#ffffff;border:1px dashed #c7d2fe;
                                    border-radius:12px;padding:10px 12px;
                                    margin-top:12px;font-size:13px;cursor:pointer;
                                ">
                            <input type="checkbox" id="otherKapalCheckbox" name="kapal[]" value="OTHER"
                                style="width:16px;height:16px;accent-color:#2563eb;">
                            OTHER
                        </label>

                        <div id="inputOtherKapal" style="display:none;margin-top:10px;">
                            <input type="text" name="kapal_other" placeholder="Sebutkan jenis kapal lainnya" style="
                                        width:100%;
                                        border-radius:14px;
                                        padding:12px 14px;
                                        border:1px solid #d1d5db;
                                    ">
                        </div>


                    </div>
                </div>

                <!-- Foreign Crew Experience -->
                <div class="col-md-6 col-12">
                    <label style="font-weight:700;font-size:13px;color:#374151;display:block;margin-bottom:10px;">
                        Pernah Berlayar dengan Crew Asing? <span style="color:#dc2626">*</span>
                    </label>

                    <div style="
                        border:1px solid #e5e7eb;
                        border-radius:16px;
                        padding:18px;
                        background:#f9fafb;
                    ">
                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            border-radius:12px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="crew_foreign" value="Y" required
                                style="width:16px;height:16px;accent-color:#2563eb;">
                            Ya, pernah bekerja dengan crew asing
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            background:#ffffff;
                            border:1px solid #e5e7eb;
                            border-radius:12px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                        ">
                            <input type="radio" name="crew_foreign" value="N"
                                style="width:16px;height:16px;accent-color:#2563eb;">
                            Tidak pernah
                        </label>

                        <div id="foreignCountryInput" style="display:none;margin-top:12px;">
                            <label style="font-size:12px;font-weight:600;color:#374151;">
                                Negara Crew Asing <span style="color:#dc2626">*</span>
                            </label>
                            <input type="text" name="foreign_country" placeholder="Contoh: Jepang, Korea Selatan" style="
                            width:100%;
                            margin-top:6px;
                            border-radius:14px;
                            padding:12px 14px;
                            border:1px solid #d1d5db;
                        ">
                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div id="divOtherInformation" style="
            background:#ffffff;
            border-radius:22px;
            padding:32px;
            padding-top:42px; 
            margin-bottom:40px;
            box-shadow:0 20px 45px rgba(15,23,42,.08);
            position:relative;   
            overflow:hidden;     
        ">

            <div style="
                position:absolute;
                top:0; left:0;
                height:5px;
                width:0%;
                background:linear-gradient(90deg,#2563eb,#1e40af);
                animation:accentLoad .9s ease-out forwards;
            "></div>

            <!-- Step Header -->
            <div style="
                display:flex;
                align-items:center;
                gap:14px;
                margin-bottom:28px;
                padding-bottom:16px;
                border-bottom:1px solid #e5e7eb;
            ">
                <div style="
                    width:44px;
                    height:44px;
                    border-radius:14px;
                    background:#2563eb;
                    color:#fff;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-weight:800;
                    font-size:14px;
                    box-shadow:0 6px 18px rgba(37,99,235,.35);
                " id="stepOtherNumber">
                    03
                </div>
                <div>
                    <div style="font-size:15px;font-weight:800;color:#111827;">
                        Other Information
                    </div>
                    <div style="font-size:13px;color:#6b7280;">
                        Informasi tambahan untuk proses seleksi
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="form-group">
                    <label>Last Salary <span style="color:red">*</span></label>

                    <div class="col-md-8">
                        <input type="number" name="last_salary" class="form-control" placeholder="Last Salary">
                    </div>

                    <div class="col-md-4">
                        <label>Select Currency <span style="color:red">*</span></label>
                        <select name="last_salary_currency" class="form-control">
                            <option value="USD" selected>USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Expected Salary <span style="color:red">*</span></label>

                    <div class="col-md-8">
                        <input type="number" name="expected_salary" class="form-control" placeholder="Expected Salary">
                    </div>

                    <div class="col-md-4">
                        <label>Select Currency <span style="color:red">*</span></label>
                        <select name="expected_salary_currency" class="form-control">
                            <option value="USD" selected>USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pernah Join Andhika Group? *</label>
                    <div style="display:flex;gap:16px;">
                        <label style="flex:1;border:1px solid #e5e7eb;border-radius:14px;padding:12px;cursor:pointer;">
                            <input type="radio" name="pernah_join" value="Y" required> Ya
                        </label>
                        <label style="flex:1;border:1px solid #e5e7eb;border-radius:14px;padding:12px;cursor:pointer;">
                            <input type="radio" name="pernah_join" value="N"> Tidak
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kesiapan Join *</label>
                    <input type="date" name="join_date" required class="form-control"
                        style="border-radius:14px;padding:12px;">
                </div>
            </div>

            <div style="
                border-top:1px solid #e5e7eb;
                padding-top:28px;
                margin-top:10px;
            ">
                <label style="font-weight:600; margin-bottom:14px; display:block;">
                    Dari Mana Anda Mengetahui Lowongan Ini?
                </label>

                <div class="row g-3">

                    <div class="col-md-4">
                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="info_source" value="website" required>
                            Website Resmi Perusahaan
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="info_source" value="social_media">
                            Media Sosial
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                        ">
                            <input type="radio" name="info_source" value="whatsapp_group">
                            Group WhatsApp / Telegram
                        </label>
                    </div>

                    <div class="col-md-4">
                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="info_source" value="referral">
                            Rekomendasi Teman / Kerabat
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="info_source" value="office">
                            Datang Langsung ke Kantor
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                        ">
                            <input type="radio" name="info_source" value="job_fair">
                            Job Fair / Event Rekrutmen
                        </label>
                    </div>

                    <!-- COL 3 -->
                    <div class="col-md-4">
                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="info_source" value="job_portal">
                            Situs Lowongan Kerja
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                            margin-bottom:10px;
                        ">
                            <input type="radio" name="info_source" value="agent_crewing">
                            Agent Crewing
                        </label>

                        <label style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            border:1px solid #e5e7eb;
                            border-radius:14px;
                            padding:12px;
                            font-size:13px;
                            cursor:pointer;
                            background:#ffffff;
                        ">
                            <input type="radio" name="info_source" value="alumni">
                            Alumni / Internal
                        </label>
                    </div>

                </div>
            </div>


            <!-- SUBMIT -->
            <div style="
                display:flex; 
                justify-content:flex-end;
                margin-top:40px;
            ">
                <input type="hidden" name="recruitment_id" id="recruitment_id">
                <input type="hidden" name="vessel_type" id="vessel_type">
                <input type="hidden" name="txtIdNewApplicant" id="txtIdNewApplicant" value="">
                <button type="button" class="btn btn-primary px-5 py-3" style="border-radius:16px;font-weight:600;"
                    onclick="saveNewApplicant()">
                    🚀 Kirim Formulir
                </button>
            </div>
        </div>

    </div>

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
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.hc-sticky.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>