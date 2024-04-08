<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME ?></title>

    <!-- External CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/style.css">

    <!-- External js -->
    <script src="<?php echo URLROOT ?>/js/script.js" defer></script>

    <!-- AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <style>
        #map {
            height: 225px;
            width: 100%;
        }

        .map{
            display: none;
            border-radius: 5px;
        }

        .map-active{
            display: block;
        }

        .map-btn{
            background-color: #e09b01;
            color: white;
            display: none;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }

        .map-btn-active{
            display: block;
        }

        .map-details{
            display: block;
        }

        .map-details-hide{
            display: none;
        }

        .map-trigger-btn{
            cursor: pointer;
            background-color: #e29c00;
            padding: 12px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }

    </style>
</head>
<body>

    <!-- Loading screen -->
    <div class="loader-wrapper">
        <div class="logo-container">
            <img src="<?php echo URLROOT ?>/images/logo.png" alt="">
        </div>
        <div class="loader"></div>
    </div>