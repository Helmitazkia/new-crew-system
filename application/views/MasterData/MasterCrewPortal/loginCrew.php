<!DOCTYPE html>
<html lang="en" style="height:100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crewing System">
    <meta name="author" content="andhika group">
    <title>Crew Portal</title>

    <link rel="shortcut icon" type="image/icon" href="<?php echo base_url(); ?>image/AndhikaTransparentBkGndBlue.png" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-responsive.css">
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.backstretch.min.js"></script>
    <style>
    #login-page {
        animation: fadeInUp .5s ease;
    }

    .page-exit {
        animation: fadeOutDown .4s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(25px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOutDown {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(30px);
        }
    }

    @keyframes gradientMove {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* RESPONSIVE (AUTO STACK) */
    @media(max-width:768px) {
        body>div {
            flex-direction: column;
        }

        body>div>div:first-child {
            height: 200px;
        }
    }

    /* MOBILE */
    @media(max-width:768px) {
        body>div {
            flex-direction: column;
        }

        body>div>div:first-child {
            height: 200px;
        }
    }
    </style>
    <script type="text/javascript">
    $(function() {

        $("#btnLogin").click(function() {
            let btn = $(this);
            btn.text("Signing in...");
            btn.prop("disabled", true);

            let user = $("#txtUser").val();
            let pass = $("#txtPass").val();

            if (user == "" || pass == "") {
                $("#lblAlertUser").text("User ID & Password required");
                btn.text("SIGN IN").prop("disabled", false);
                return;
            }

            $.post("<?php echo base_url('loginCrew'); ?>", {
                user: user,
                pass: pass
            }, function(res) {
                if (res.status) {
                    $("#login-page").addClass("page-exit");
                    setTimeout(() => {
                        window.location = "<?php echo base_url('portalCrew'); ?>";
                    }, 400);
                } else {
                    $("#lblAlertUser").text("Login failed");
                    btn.text("SIGN IN").prop("disabled", false);
                }
            }, "json");
        });

        $("#goRegister").click(function(e) {
            e.preventDefault();
            $("#login-page").addClass("page-exit");
            setTimeout(() => {
                window.location = "<?php echo base_url('registerCrewView'); ?>";
            }, 350);
        });
    });

    function showPass() {
        let x = document.getElementById("txtPass");
        x.type = (x.type === "password") ? "text" : "password";
    }
    </script>

</head>

<body style="margin:0; height:100%; font-family:'Segoe UI', sans-serif;">

    <div style="
    display:flex;
    height:100vh;
    width:100%;
    overflow:hidden;
">

        <!-- LEFT SIDE -->
        <div style="
        flex:1;
        background:url('<?php echo base_url(); ?>assets/img/bgCrewPortal.jpg') center/cover;
        position:relative;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
    ">

            <!-- DARK OVERLAY (lebih dalam biar balance) -->
            <div style="
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.65);
        "></div>

            <div style="
            position:relative;
            text-align:center;
            padding:30px;
        ">
                <div style="font-size:32px; font-weight:700; letter-spacing:1px;">
                    ANDHIKA CREW PORTAL
                </div>
                <div style="opacity:.75; margin-top:10px;">
                    Manage Your Personal & Crew Information Securely
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div style="
        flex:1;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;

        /* MARITIME COLOR (fix utama disini) */
        background: linear-gradient(135deg,#0a1923,#102a3a,#1c3d52);
    ">

            <form style="
            width:100%;
            max-width:400px;

            /* GLASS UPGRADE */
            background:rgba(255,255,255,0.08);
            backdrop-filter: blur(18px);
            border:1px solid rgba(255,255,255,0.1);

            border-radius:20px;
            padding:30px 25px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.4);
            color:#fff;
        ">

                <!-- TITLE -->
                <div style="text-align:center; margin-bottom:30px;">
                    <div style="font-size:26px; font-weight:700;">Login</div>
                    <small style="opacity:.7;">Crew Portal Access</small>
                </div>

                <!-- USER -->
                <div style="position:relative; margin-bottom:20px;">
                    <i class="fa fa-user" style="
                    position:absolute;
                    top:50%;
                    left:12px;
                    transform:translateY(-50%);
                    opacity:.6;
                "></i>

                    <input type="text" id="txtUser" required style="
                    width:90%;
                    padding:12px 12px 12px 35px;
                    border:none;
                    border-bottom:1px solid rgba(255,255,255,0.3);
                    background:transparent;
                    color:#fff;
                    outline:none;
                " onfocus="this.nextElementSibling.style.top='-8px';this.nextElementSibling.style.fontSize='11px';"
                        onblur="if(!this.value){this.nextElementSibling.style.top='10px';this.nextElementSibling.style.fontSize='13px';}">

                    <label style="
                    position:absolute;
                    left:35px;
                    top:10px;
                    font-size:13px;
                    opacity:.7;
                    transition:.3s;
                ">User ID</label>
                </div>

                <!-- PASS -->
                <div style="position:relative; margin-bottom:20px;">
                    <i class="fa fa-lock" style="
                    position:absolute;
                    top:50%;
                    left:12px;
                    transform:translateY(-50%);
                    opacity:.6;
                "></i>

                    <input type="password" id="txtPass" required style="
                    width:90%;
                    padding:12px 12px 12px 35px;
                    border:none;
                    border-bottom:1px solid rgba(255,255,255,0.3);
                    background:transparent;
                    color:#fff;
                    outline:none;
                " onfocus="this.nextElementSibling.style.top='-8px';this.nextElementSibling.style.fontSize='11px';"
                        onblur="if(!this.value){this.nextElementSibling.style.top='10px';this.nextElementSibling.style.fontSize='13px';}">

                    <label style="
                    position:absolute;
                    left:35px;
                    top:10px;
                    font-size:13px;
                    opacity:.7;
                    transition:.3s;
                ">Password</label>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:13px;">
                        <input type="checkbox" onclick="showPass()"> Show Password
                    </label>
                </div>

                <div id="lblAlertUser" style="
                color:#ff6b6b;
                font-size:13px;
                margin-bottom:10px;
                min-height:16px;
            "></div>

                <button id="btnLogin" type="button" style="
                width:100%;
                padding:12px;
                border:none;
                border-radius:12px;
                background: linear-gradient(270deg,#1e90ff,#0a58ca,#1e90ff);
                background-size:200% 200%;
                color:#fff;
                font-weight:600;
                cursor:pointer;
                transition:.3s;
                animation: gradientMove 4s ease infinite;
            ">
                    SIGN IN
                </button>

                <div style="margin-top:15px; text-align:center; font-size:13px;">
                    Don’t have an account?
                    <a href="#" id="goRegister" style="color:#4db8ff;">Create here</a>
                </div>

            </form>
        </div>

    </div>
    <script>
    $.backstretch(["<?php echo base_url(); ?>assets/img/bgCrewPortal.jpg",
        "<?php echo base_url(); ?>assets/img/bgCrewCV.jpg",
        "<?php echo base_url(); ?>assets/img/bgCrewPortal2.jpg"
    ], {
        speed: 1500,
        duration: 3000,
        fade: 750
    });
    </script>

</html>