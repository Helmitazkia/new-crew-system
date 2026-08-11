<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crew Recruitment Maintenance</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        min-height: 100vh;
        overflow: hidden;
        background: linear-gradient(180deg, #0f172a 0%, #1e40af 50%, #3b82f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Floating circles */
    .circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        animation: float 12s infinite linear;
    }

    .circle:nth-child(1) {
        width: 250px;
        height: 250px;
        top: 10%;
        left: 10%;
    }

    .circle:nth-child(2) {
        width: 180px;
        height: 180px;
        bottom: 15%;
        right: 15%;
        animation-duration: 18s;
    }

    .circle:nth-child(3) {
        width: 100px;
        height: 100px;
        top: 25%;
        right: 20%;
        animation-duration: 15s;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-30px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .maintenance-card {
        position: relative;
        z-index: 10;
        width: 90%;
        max-width: 750px;
        padding: 60px;
        text-align: center;
        border-radius: 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border: 1px solid rgba(255, 255, 255, .15);
        box-shadow: 0 30px 60px rgba(0, 0, 0, .35);
    }

    .ship-icon {
        font-size: 80px;
        margin-bottom: 25px;
        animation: shipFloat 3s ease-in-out infinite;
    }

    @keyframes shipFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-12px);
        }
    }

    .badge {
        display: inline-block;
        background: #f59e0b;
        color: #fff;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    h1 {
        color: #fff;
        font-size: 48px;
        margin-bottom: 20px;
    }

    p {
        color: rgba(255, 255, 255, .85);
        line-height: 1.8;
        font-size: 18px;
        margin-bottom: 30px;
    }

    .status-box {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 28px;
        background: rgba(255, 255, 255, .12);
        border-radius: 50px;
        color: white;
        font-weight: 600;
    }

    .dot {
        width: 10px;
        height: 10px;
        background: #22c55e;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .footer {
        margin-top: 40px;
        color: rgba(255, 255, 255, .65);
        font-size: 14px;
    }

    /* Ocean waves */
    .ocean {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .wave {
        position: absolute;
        width: 200%;
        height: 180px;
        background: rgba(255, 255, 255, .15);
        border-radius: 45%;
        animation: wave 12s linear infinite;
    }

    .wave:nth-child(2) {
        opacity: .5;
        animation-duration: 18s;
        bottom: -20px;
    }

    @keyframes wave {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    @media(max-width:768px) {

        .maintenance-card {
            padding: 40px 25px;
        }

        h1 {
            font-size: 34px;
        }

        p {
            font-size: 16px;
        }

        .ship-icon {
            font-size: 60px;
        }
    }
    </style>
</head>

<body>

    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="maintenance-card">

        <div class="ship-icon">🚢</div>

        <div class="badge">
            RECRUITMENT PORTAL
        </div>

        <h1>Under Maintenance</h1>

        <p>
            Our Crew Recruitment Application System is currently undergoing
            scheduled maintenance and feature enhancements.
            <br><br>
            We are working to improve performance, security, and the overall
            candidate application experience.
        </p>

        <div class="status-box">
            <span class="dot"></span>
            System Upgrade In Progress
        </div>

        <div class="footer">
            © 2026 Crew Recruitment Management System
            <br>
            Thank you for your patience.
        </div>

    </div>

    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

</body>

</html>