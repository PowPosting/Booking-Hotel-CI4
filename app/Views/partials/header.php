<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxStay - Pemesanan Hotel Premium</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --light-color: #f3f4f6;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-color);
            background-color: #f8fafc;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #152b65;
            border-color: #152b65;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
        }
        
        .btn-accent:hover {
            background-color: #d97706;
            border-color: #d97706;
            color: white;
        }
        
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= base_url('images/hero.jpg') ?>') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 150px 0;
            margin-top: -56px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 15px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        .room-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .room-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .feature-icon {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5 {
            color: var(--accent-color);
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        footer ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        footer ul li {
            margin-bottom: 10px;
        }
        
        footer ul li a {
            color: #d1d5db;
            text-decoration: none;
        }
        
        footer ul li a:hover {
            color: white;
        }
        
        .social-icons a {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--accent-color);
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }
        
        .datepicker-container {
            position: relative;
        }
        
        .datepicker-container i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        /* Modal Styles */
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .modal-header .btn-close {
            color: white;
            box-shadow: none;
        }
        
        /* Auth Form Styles */
        .auth-form-container {
            position: fixed;
            top: 70px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: height 0.3s ease;
            z-index: 1050;
            display: none;
        }
        
        .auth-form-container.active {
            display: block;
        }
        
        .auth-forms {
            position: relative;
            width: 700px;
            display: flex;
            transition: transform 0.3s ease;
        }
        
        .auth-form {
            width: 350px;
            padding: 20px;
        }
        
        .auth-toggle {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .auth-header h4 {
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .password-field {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary-color);
            cursor: pointer;
            padding: 0;
            font-size: 16px;
        }
        
        /* Room Detail Styles */
        .room-gallery img {
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .room-gallery img:hover {
            opacity: 0.8;
        }
        
        .facility-item {
            margin-bottom: 15px;
        }
        
        .facility-item i {
            color: var(--accent-color);
            margin-right: 10px;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>