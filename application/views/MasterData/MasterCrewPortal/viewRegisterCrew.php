<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER - USER CREW CV</title>

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

    @keyframes premiumExit {
        0% {
            opacity: 1;
            transform: scale(1) translateY(0);
            filter: blur(0);
        }

        100% {
            opacity: 0;
            transform: scale(0.95) translateY(40px);
            filter: blur(6px);
        }
    }

    .page-exit {
        animation: premiumExit .45s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

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

    <script>
    $(function() {

        function strongPass(p) {
            return /^(?=[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(p);
        }

        $("#txtPass").on("keyup blur", function() {
            let p = $(this).val();
            if (p != "" && !strongPass(p)) {
                $("#passHint").show();
            } else {
                $("#passHint").hide();
            }
        });

        $("#btnRegister").click(function() {

            let data = {
                fullname: $("#txtFullname").val().trim(),
                email: $("#txtEmail").val().trim(),
                userid: $("#txtUser").val().trim(),
                password: $("#txtPass").val()
            };

            let cpass = $("#txtConfirmPass").val();

            $("#lblAlert").text("");

            if (Object.values(data).includes("") || cpass == "") {
                $("#lblAlert").text("All fields are required");
                return;
            }
            if (data.password !== cpass) {
                $("#lblAlert").text("Password not match");
                return;
            }
            if (!strongPass(data.password)) {
                $("#passHint").show();
                return;
            }

            $.post("<?php echo base_url('saveRegisterCrew'); ?>", data, function(res) {
                if (res.status) {
                    $("#login-page").addClass("page-exit");
                    alert("Registration successful. Please login!");
                    setTimeout(() => {
                        window.location =
                            "<?php echo base_url('crewPortal'); ?>";
                    }, 400);
                } else {
                    $("#lblAlert").text(res.message);
                }
            }, "json");
        });

        $("#goLogin").click(function(e) {
            e.preventDefault();
            $("#login-page").addClass("page-exit");
            setTimeout(() => {
                window.location = "<?php echo base_url('crewPortal'); ?>";
            }, 350);
        });
    });

    function showPass() {
        $("#txtPass,#txtConfirmPass").each(function() {
            this.type = (this.type === "password") ? "text" : "password";
        });
    }
    </script>
</head>

<body style="margin:0;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    font-family: 'Segoe UI',sans-serif;
    height:100vh;">
    <div id="login-page" style="
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
        animation: fadeInUp .5s ease;
        ">

        <form style="
        width:420px;
        backdrop-filter: blur(18px);
        background: rgba(255, 255, 255, 0.55);
        border-radius:20px;
        padding:30px;
        box-shadow:0 20px 60px rgba(255, 255, 255, 0.55);
        border:1px solid rgba(255, 255, 255, 0.55);
        color:#fff;
        ">

            <!-- HEADER -->
            <div style="text-align:center;margin-bottom:25px;">
                <div style="
                width:70px;
                height:70px;
                margin:auto;
                border-radius:50%;
                background: linear-gradient(135deg,#00c6ff,#0072ff);
                display:flex;
                align-items:center;
                justify-content:center;
                box-shadow:0 10px 30px rgba(0,114,255,0.6);
                ">
                    <i class="fa fa-user-plus" style="font-size:28px;color:white;"></i>
                </div>

                <h2 style="margin-top:15px;font-weight:600;letter-spacing:1px; color:black;">
                    Crew Registration
                </h2>

                <small style="color:rgba(0, 0, 0, 0.6);">
                    Create your account
                </small>
            </div>

            <!-- INPUT -->
            <div style="display:flex;flex-direction:column;gap:12px;">

                <input id="txtFullname" type="text" placeholder="Full Name" style="
                padding:12px 14px;
                border-radius:10px;
                border:none;
                outline:none;
                background:rgba(255,255,255,0.1);
                color:#black;
                ">

                <input id="txtEmail" type="email" placeholder="Email" style="
                padding:12px;
                border-radius:10px;
                border:none;
                outline:none;
                background:rgba(255,255,255,0.1);
                color:#black;
                ">

                <input id="txtUser" type="text" placeholder="Username" style="
                padding:12px;
                border-radius:10px;
                border:none;
                outline:none;
                background:rgba(255,255,255,0.1);
                color:#black;
                ">

                <input id="txtPass" type="password" placeholder="Password" style="
                padding:12px;
                border-radius:10px;
                border:none;
                outline:none;
                background:rgba(255,255,255,0.1);
                color:#black;
                ">

                <small id="passHint" style="
                display:none;
                color:black;
                font-size:11px;
                margin-top:-5px;">
                    Password must start with capital letter, include number & symbol
                </small>

                <input id="txtConfirmPass" type="password" placeholder="Confirm Password" style="
                padding:12px;
                border-radius:10px;
                border:none;
                outline:none;
                background:rgba(255,255,255,0.1);
                color:#black;
                ">

            </div>

            <!-- OPTIONS -->
            <div style="margin-top:15px;display:flex;justify-content:space-between;align-items:center;">
                <label style="font-size:12px;color:black    ;">
                    <input type="checkbox" onclick="showPass()"> Show Password
                </label>
            </div>

            <!-- ALERT -->
            <div style="margin-top:10px;">
                <small id="lblAlert" style="color:#ff6b6b;"></small>
            </div>

            <!-- BUTTON -->
            <button type="button" id="btnRegister" style="
            width:100%;
            margin-top:15px;
            padding:12px;
            border:none;
            border-radius:12px;
            background: linear-gradient(135deg,#00c6ff,#0072ff);
            color:white;
            font-weight:600;
            letter-spacing:1px;
            cursor:pointer;
            transition: all .3s ease;
            box-shadow:0 10px 25px rgba(0,114,255,0.5);
            " onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 15px 35px rgba(0,114,255,0.7)'"
                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 10px 25px rgba(0,114,255,0.5)'">
                REGISTER
            </button>

            <!-- FOOTER -->
            <div style="text-align:center;margin-top:15px;font-size:13px;color:black;">
                Already have an account?
                <a href="#" id="goLogin" style="
                color:black;
                font-weight:600;
                text-decoration:none;">
                    Sign In
                </a>
            </div>

            <hr style="margin:20px 0;border-color:black;">

            <div style="text-align:center;font-size:11px;color:black;">
                © <?php echo date("Y"); ?> Andhika Group
            </div>

        </form>

    </div>
</body>

</html>
<script>
$.backstretch(["<?php echo base_url(); ?>assets/img/bgCrewPortal.jpg",
    "<?php echo base_url(); ?>assets/img/bgCrewCV.jpg", "<?php echo base_url(); ?>assets/img/bgCrewPortal2.jpg"
], {
    speed: 1500,
    duration: 3000,
    fade: 750
});
</script>