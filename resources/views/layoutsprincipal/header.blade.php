<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Full Bigotes | La Mejor Tienda de Accesorios para tus Mascotas en Chiloé</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/gallery/iconof.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/gallery/iconof.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/gallery/iconof.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/gallery/iconof.png') }}">
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/gallery/iconof.png') }}">
    @vite([ 'resources/js/app.js'])
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" />

    <style>
        .text-gradient {
            background: linear-gradient(to right, #1abc9c, #f39c12);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .badge-foodwagon {
            background-color: #40e0d0 !important;
        }
        .card-body {
            padding: 1rem !important;
        }
        .img-fluid.position-absolute {
            z-index: 1000;
        }
        .nav-item {
            margin: 0 10px;
        }
        .nav-link {
            color: #333;
            transition: color 0.3s ease-in-out;
        }
        .nav-link:hover,
        .nav-link:focus {
            color: #ffa500;
            text-decoration: none;
        }
        .navbar-nav {
            border-top: 2px solid #ffa500;
            padding-top: 10px;
        }
        body {
            padding-top: 80px;
        }
        .navbar {
            background-color: #f8f9fa !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }
        .btn-turquoise {
            background-color: #1abc9c;
            color: #fff;
            border: none;
        }
        .btn-turquoise:hover {
            background-color: #16a085;
            color: #fff;
        }
        .btn-outline-turquoise {
            border: 2px solid #1abc9c;
            color: #1abc9c;
            background-color: transparent;
        }
        .btn-outline-turquoise:hover {
            border-color: #16a085;
            color: #16a085;
            background-color: transparent;
        }
        .btn-orange {
            background-color: #f39c12;
            color: #fff;
            border: none;
        }
        .btn-orange:hover {
            background-color: #e67e22;
            color: #fff;
        }
        .cart-button {
            position: fixed;
            bottom: 20px;
            border: 3px solid #40E0D0;
            right: 20px;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1060;
            background-color: #FFFFFF;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }
        .cart-button i {
            font-size: 24px;
        }
        .cart-button:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.45);
        }
        .cart-button:active {
            transform: scale(0.9);
        }
        .dropdown-menu .dropdown-submenu {
            position: relative;
        }
        .dropdown-menu .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
        .item-name {
            display: inline-block;
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        @media (max-width: 768px) {
            .item-name {
                max-width: 100px;
            }
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .remove-icon {
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .cart-item-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 10px;
        }
        .discounted .item-price {
            color: red;
            font-weight: bold;
        }
        .price-original {
            color: grey;
            text-decoration: line-through;
        }
        .price-with-discount {
            color: red;
            font-weight: bold;
        }
        .cart-button .badge {
            top: -10px;
            right: -10px;
            font-size: 0.75rem;
            display: none;
        }
        @media (max-width: 991px) {
            .dropdown-submenu .dropdown-menu {
                display: none;
            }
            .dropdown-submenu.show .dropdown-menu {
                display: block;
            }
        }
        @media (min-width: 992px) {
            .dropdown-submenu:hover .dropdown-menu {
                display: block;
            }
        }
    </style>
</head>
<body>

    <main class="main" id="top">
        <script>
            window.productos = @json($productos);
        </script>
        