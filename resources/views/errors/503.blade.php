<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <title>Maintenance - Magic Barrage</title>

    <meta name="description" content="Magic Barrage is pushing a new update!" />

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">

    <style>
        body {
            position: relative;
            padding: 0;
            margin: 0;
            font-family: "Source Sans Pro", Helvetica, Arial, sans-serif;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.8;
            color: #333;
        }

        .container-fluid {
            width: 100%;
            display: flex;
            justify-content: center;
            text-align: center;
        }

        @-webkit-viewport {
            width: device-width;
        }

        @-moz-viewport {
            width: device-width;
        }

        @-ms-viewport {
            width: device-width;
        }

        @-o-viewport {
            width: device-width;
        }

        @viewport {
            width: device-width;
        }

        h1,
        .h1 {
            font-family: "Montserrat", Helvetica, Arial, sans-serif;
            font-size: 45px;
            font-weight: 400;
            line-height: 1.5;
            margin-top: 0;
            margin-bottom: 10px;
        }

        h2,
        .h2 {
            font-family: "Montserrat", Helvetica, Arial, sans-serif;
            font-size: 28px;
            font-weight: 400;
            line-height: 1.5;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-top: 0;
            margin-bottom: 30px;
        }

        h3,
        .h3 {
            font-family: "Montserrat", Helvetica, Arial, sans-serif;
            font-size: 26px;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 0;
        }

        h4,
        .h4 {
            font-family: "Montserrat", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 10px;
        }

        p,
        .lead {
            font-family: "Source Sans Pro", Helvetica, Arial, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            margin-bottom: 0;
        }

        strong,
        b {
            font-weight: 700;
        }

        .font-weight-200 {
            font-weight: 200;
        }

        .wrap-line {
            margin: 20px 0 50px 0;
            position: relative;
        }

        .wrap-line:before {
            position: absolute;
            width: 40px;
            height: 1px;
            bottom: -30px;
            left: 50%;
            margin-left: -20px;
            content: "";
            border-bottom: 1px solid;
        }

        .icon {
            line-height: 1;
        }

        .icon:before {
            vertical-align: bottom;
        }

        .icon-sm {
            font-size: 24px;
        }

        .icon-lg {
            font-size: 34px;
        }

        .text-color {
            color: #00ACC1;
        }

        .text-white {
            color: #fff;
        }

        .text-light {
            color: #aaa;
        }

        .text-grey {
            color: #444;
        }

        .bg-color {
            background-color: #00ACC1;
        }

        .bg-white {
            background-color: #fff;
        }

        .bg-white-09 {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .bg-black {
            background-color: #000;
        }

        .bg-solid-color {
            background-color: #1f64c5;
        }

        .bg-dark {
            background-color: #333;
        }

        .bg-light {
            background-color: #aaa;
        }

        .bg-bubble-color {
            background-color: #00457c
        }

        .bg-square-color {
            background-color: #5E35B1;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a>i {
            margin: 0 7px;
        }

        a:hover,
        a:active,
        a:focus {
            color: #000;
            text-decoration: underline;
            outline: none;
        }

        a.link-white,
        a.link-white:hover,
        a.link-white:active,
        a.link-white:focus {
            color: #fff;
        }

        a.link-light,
        a.link-light:hover,
        a.link-light:active,
        a.link-light:focus {
            color: #fff;
        }

        .btn-row {
            margin-left: -5px;
            margin-right: -5px;
        }

        .btn,
        a.btn {
            display: inline-block;
            margin: 0 5px;
            padding: 14px;
            font-family: "Montserrat", Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border-radius: 0;
            transition: background .3s ease-in-out;
        }

        .btn i {
            margin-right: 15px;
        }

        .btn.active.focus,
        .btn.active:focus,
        .btn.focus,
        .btn:active.focus,
        .btn:active:focus,
        .btn:focus {
            outline: none;
        }

        .input-group-btn:last-child>.btn {
            margin: 0 !important;
            padding: 12px 13px 13px 13px;
            line-height: 1.392;
            border: none;
        }

        .input-group-btn:last-child>.btn i,
        .input-group-btn:last-child>.btn-group i {
            margin: 0 !important;
        }

        .btn.btn-dark,
        a.btn.btn-dark {
            color: #fff;
            background-color: #333;
        }

        .btn.btn-dark:hover,
        a.btn.btn-dark:hover,
        .btn.btn-dark:active,
        a.btn.btn-dark:active,
        .btn.btn-dark:focus,
        a.btn.btn-dark:focus {
            color: #fff;
            background-color: #000;
            box-shadow: none;
        }

        .btn-color,
        a.btn-color {
            color: #fff;
            background-color: #00ACC1;
        }

        .btn.btn-color:hover,
        .btn.btn-color:active,
        .btn.btn-color:focus,
        a.btn.btn-color:hover,
        a.btn.btn-color:active,
        a.btn.btn-color:focus {
            color: #fff;
            background-color: #0097A7;
        }

        .btn-white,
        a.btn-white {
            color: #333;
            background-color: #fff;
        }

        .btn.btn-white:hover,
        .btn.btn-white:active,
        .btn.btn-white:focus,
        a.btn.btn-white:hover,
        a.btn.btn-white:active,
        a.btn.btn-white:focus {
            color: #333;
            background-color: #fff;
        }

        .btn.btn-border-white,
        a.btn.btn-border-white {
            color: #fff;
            background-color: transparent;
            border: 1px solid #fff;
        }

        .btn.btn-border-white:hover,
        .btn.btn-border-white:active,
        .btn.btn-border-white:focus,
        a.btn.btn-border-white:hover,
        a.btn.btn-border-white:active,
        a.btn.btn-border-white:focus {
            color: #333;
            background-color: #fff;
            border: 1px solid #fff;
        }

        .vert-middle {
            min-height: 700px;
            height: 100%;
            align-items: center;
            display: flex;
        }

        .vert-middle>div {
            width: 100%;
            vertical-align: middle;
        }

        .p-t-b-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .p-t-b-15 {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .p-t-b-20 {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .p-t-b-30 {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .p-t-b-40 {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .p-t-b-50 {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .p-t-30 {
            padding-top: 30px;
        }

        .arrow-wrapper {
            padding: 30px;
        }

        .section-overlay {
            position: fixed;
            top: 0;
            height: 100%;
            min-height: 700px;
            width: 100%;
            z-index: -100;
        }

        .section-overlay.youtube {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            transform: translate(-50%, -50%);
        }

        .section-overlay.media {
            z-index: -250;
        }

        .section-overlay img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            min-height: 100%;
            min-width: 100%;
        }

        .overlay-opacity {
            filter: alpha(opacity=50);
            opacity: 0.3;
        }

        .overlay-opacity-2 {
            filter: alpha(opacity=40);
            opacity: 0.4;
        }

        .overlay-opacity-3 {
            filter: alpha(opacity=60);
            opacity: 0.6;
        }

        .page-image-min {
            background: url("/img/backgrounds/home.jpg") no-repeat center center;
            background-size: cover;
            height: 100%;
            width: 100%;
            min-height: 700px;
        }

        .page-info {
            min-height: 700px;
            height: 100%;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .sr .reveal {
            visibility: hidden;
        }

        .map>div {
            width: 100%;
            height: 400px;
        }

        .map h4,
        .map h5 {
            margin-top: 0;
        }

        @media only screen and (min-width: 991px) {

            body.vegas-container,
            body {
                overflow: hidden;
            }

            body.show-content {
                overflow: scroll;
            }

            header {
                display: block;
            }

            .page-info {
                padding-top: 60px;
                position: fixed;
            }

            .col-transform {
                transition: all 0.6s ease-in-out;
            }

            .page-content {
                position: absolute;
                visibility: hidden;
                right: -50%;
                transition: all 0.6s ease-in-out;
            }

            .show-content .page-content {
                overflow: scroll;
                position: absolute;
                right: 0;
                visibility: visible;
            }

            .page-amplitude-wrapper {
                position: fixed;
            }

            .count-down {
                margin-left: -30px;
                margin-right: -30px;
            }
        }
    </style>
</head>

<body class="bg-dark">
    <div id="page">

        <div class="section-overlay media page-image-min reveal scale-in"></div>

        <div class="section-overlay bg-black overlay-opacity"></div>

        <div class="container-fluid">



            <div id="info" class="col-md-12 text-white text-center page-info col-transform">
                <div class="vert-middle">
                    <div class="reveal scale-out">
                        <div class="p-t-b-15">
                            <h2><span class="font-weight-200">We're updating</span><br>the game</h2>

                            <p>Magic Barrage will be back soon!<br />Here's a button to click if you are
                                impatient!<br />
                            </p>
                        </div>
                        <div class="p-t-b-15 btn-row">
                            <button class="btn btn-color" role="button"
                                onclick="window.location.reload()">Refresh</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>