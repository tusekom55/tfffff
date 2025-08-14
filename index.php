<?php
require_once 'includes/functions.php';

$page_title = 'GlobalBorsa - Türkiye\'nin En Güvenilir Yatırım Platformu';

// Get some sample market data for display  
$markets = getMarketData('us_stocks', 6);
?>

<!DOCTYPE html>
<html lang="<?php echo getCurrentLang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="Türkiye'nin en güvenilir yatırım platformu. 7/24 Türkçe destek, güvenli altyapı, düşük komisyonlar.">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #0d1b4c;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }
        
        /* Mobile-First Header */
        .main-header {
            background: #fff;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            padding: 0.75rem 0;
        }
        
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .main-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .nav-link:hover, .nav-link.active {
            background: var(--primary-color);
            color: #fff;
            text-decoration: none;
        }
        
        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: #fff;
        }
        
        /* Mobile Header Responsive */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 0.75rem;
            }
            
            .logo {
                font-size: 1.3rem;
            }
            
            .main-nav {
                gap: 0.25rem;
            }
            
            .nav-link {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
            }
            
            .nav-link i {
                font-size: 0.8rem;
            }
            
            .auth-buttons {
                gap: 0.25rem;
            }
            
            .btn-primary, .btn-outline-primary {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .header-container {
                padding: 0 0.5rem;
            }
            
            .logo {
                font-size: 1.2rem;
            }
            
            .nav-link span {
                display: none;
            }
            
            .nav-link {
                padding: 0.4rem;
                min-width: 32px;
                justify-content: center;
            }
            
            .btn-primary, .btn-outline-primary {
                padding: 0.4rem 0.6rem;
                font-size: 0.75rem;
            }
        }
        
        /* Hero Section */
        .hero-section {
            background: 
                linear-gradient(135deg, rgba(10, 14, 26, 0.8) 0%, rgba(26, 31, 58, 0.8) 25%, rgba(13, 27, 76, 0.8) 50%, rgba(0, 123, 255, 0.8) 100%),
                url('6256878.jpg') center/cover no-repeat;
            color: #fff;
            padding: 120px 0 80px;
            margin-top: 70px;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 123, 255, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(40, 167, 69, 0.2) 0%, transparent 50%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.05"/><circle cx="20" cy="20" r="1" fill="white" opacity="0.05"/><circle cx="80" cy="30" r="1.5" fill="white" opacity="0.05"/></svg>') repeat;
            animation: heroBackground 20s ease-in-out infinite;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.02) 50%, transparent 70%);
            animation: shine 8s ease-in-out infinite;
        }
        
        @keyframes heroBackground {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: 1; }
            50% { transform: scale(1.1) rotate(1deg); opacity: 0.8; }
        }
        
        @keyframes shine {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }
        
        .hero-floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .floating-icon {
            position: absolute;
            color: rgba(255,255,255,0.15);
            animation: float 6s ease-in-out infinite;
            text-shadow: 0 0 20px rgba(255,255,255,0.2);
        }
        
        .floating-icon:nth-child(1) {
            top: 15%;
            left: 8%;
            font-size: 2.5rem;
            animation-delay: 0s;
        }
        
        .floating-icon:nth-child(2) {
            top: 65%;
            right: 12%;
            font-size: 1.8rem;
            animation-delay: 2s;
        }
        
        .floating-icon:nth-child(3) {
            bottom: 25%;
            left: 15%;
            font-size: 2rem;
            animation-delay: 4s;
        }
        
        .floating-icon:nth-child(4) {
            top: 35%;
            right: 25%;
            font-size: 1.5rem;
            animation-delay: 1s;
        }
        
        .floating-icon:nth-child(5) {
            bottom: 55%;
            right: 8%;
            font-size: 2.5rem;
            animation-delay: 3s;
        }
        
        .floating-icon:nth-child(6) {
            top: 25%;
            left: 25%;
            font-size: 1.3rem;
            animation-delay: 5s;
        }
        
        .floating-icon:nth-child(7) {
            bottom: 40%;
            right: 35%;
            font-size: 1.7rem;
            animation-delay: 1.5s;
        }
        
        .floating-icon:nth-child(8) {
            top: 50%;
            left: 5%;
            font-size: 1.4rem;
            animation-delay: 3.5s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.15; }
            50% { transform: translateY(-25px) rotate(8deg); opacity: 0.25; }
        }
        
        /* Stock ticker elements */
        .hero-stock-ticker {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            height: 40px;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255,255,255,0.1);
            z-index: 2;
            overflow: hidden;
        }
        
        .stock-ticker-track {
            display: flex;
            align-items: center;
            height: 100%;
            animation: stockTicker 30s linear infinite;
            gap: 2rem;
            white-space: nowrap;
        }
        
        .stock-ticker-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.9);
            flex-shrink: 0;
        }
        
        .stock-price {
            color: #fff;
            font-weight: 600;
        }
        
        .stock-change.positive {
            color: #22c55e;
        }
        
        .stock-change.negative {
            color: #ef4444;
        }
        
        @keyframes stockTicker {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        
        /* Mobile Stock Ticker Optimization */
        @media (max-width: 768px) {
            .hero-stock-ticker {
                height: 32px;
                bottom: 10px;
            }
            
            .stock-ticker-track {
                gap: 1.5rem;
                animation: stockTicker 35s linear infinite;
            }
            
            .stock-ticker-item {
                gap: 0.3rem;
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-stock-ticker {
                height: 28px;
                bottom: 5px;
            }
            
            .stock-ticker-track {
                gap: 1rem;
                animation: stockTicker 40s linear infinite;
            }
            
            .stock-ticker-item {
                gap: 0.25rem;
                font-size: 0.7rem;
            }
        }
        
        /* Financial particles */
        .financial-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .particle {
            position: absolute;
            color: rgba(255,255,255,0.1);
            font-size: 0.8rem;
            animation: particle 20s linear infinite;
        }
        
        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 4s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 8s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 12s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 16s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 2s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 6s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 10s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 14s; }
        .particle:nth-child(10) { left: 15%; animation-delay: 18s; }
        
        @keyframes particle {
            0% { 
                transform: translateY(100vh) rotate(0deg); 
                opacity: 0; 
            }
            10% { 
                opacity: 0.3; 
            }
            90% { 
                opacity: 0.3; 
            }
            100% { 
                transform: translateY(-10vh) rotate(360deg); 
                opacity: 0; 
            }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .hero-cta {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-hero-primary {
            background: #fff;
            color: var(--primary-color);
        }
        
        .btn-hero-secondary {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        /* Mobile Hero */
        @media (max-width: 768px) {
            .hero-section {
                padding: 100px 0 60px;
                margin-top: 60px;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-cta {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-hero {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
                width: 250px;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .hero-section {
                padding: 80px 0 50px;
            }
            
            .hero-title {
                font-size: 1.7rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
        }
        
        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fff;
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }
        
        .feature-text {
            color: #666;
            line-height: 1.6;
        }
        
        /* Markets Ticker */
        .markets-ticker {
            background: var(--secondary-color);
            padding: 60px 0;
            overflow: hidden;
        }
        
        .ticker-title {
            text-align: center;
            color: #fff;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }
        
        .ticker-container {
            overflow: hidden;
            position: relative;
            mask: linear-gradient(90deg, transparent, white 10%, white 90%, transparent);
            -webkit-mask: linear-gradient(90deg, transparent, white 10%, white 90%, transparent);
        }
        
        .ticker-track {
            display: flex;
            animation: ticker 25s linear infinite;
            gap: 1.5rem;
            width: max-content;
        }
        
        .ticker-item {
            flex-shrink: 0;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1.5rem;
            min-width: 200px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .ticker-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-5px);
        }
        
        /* Mobile Market Ticker Optimization */
        @media (max-width: 768px) {
            .markets-ticker {
                padding: 40px 0 !important;
            }
            
            .ticker-title {
                font-size: 1.3rem !important;
                margin-bottom: 1.5rem !important;
            }
            
            .ticker-item {
                min-width: 140px !important;
                padding: 1rem !important;
                border-radius: 8px !important;
            }
            
            .ticker-item > div:first-child {
                margin-bottom: 0.5rem !important;
            }
            
            .ticker-item img {
                width: 24px !important;
                height: 24px !important;
                margin-right: 0.3rem !important;
            }
            
            .ticker-item > div:first-child > div {
                font-size: 1rem !important;
                font-weight: 600 !important;
            }
            
            .ticker-item > div:nth-child(2) {
                font-size: 0.75rem !important;
                margin-bottom: 0.3rem !important;
                line-height: 1.2 !important;
            }
            
            .ticker-item > div:nth-child(3) {
                font-size: 0.9rem !important;
                font-weight: 500 !important;
                margin-bottom: 0.2rem !important;
            }
            
            .ticker-item > div:last-child {
                font-size: 0.75rem !important;
                padding: 0.2rem 0.4rem !important;
                border-radius: 3px !important;
            }
        }
        
        @media (max-width: 480px) {
            .markets-ticker {
                padding: 30px 0 !important;
            }
            
            .ticker-title {
                font-size: 1.1rem !important;
                margin-bottom: 1rem !important;
            }
            
            .ticker-item {
                min-width: 120px !important;
                padding: 0.75rem !important;
            }
            
            .ticker-item img {
                width: 20px !important;
                height: 20px !important;
            }
            
            .ticker-item > div:first-child > div {
                font-size: 0.9rem !important;
            }
            
            .ticker-item > div:nth-child(2) {
                font-size: 0.7rem !important;
                display: -webkit-box !important;
                -webkit-line-clamp: 2 !important;
                -webkit-box-orient: vertical !important;
                overflow: hidden !important;
            }
            
            .ticker-item > div:nth-child(3) {
                font-size: 0.8rem !important;
            }
            
            .ticker-item > div:last-child {
                font-size: 0.7rem !important;
            }
        }
        
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Education Section */
        .education-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 50%, #f8f9fa 100%);
            position: relative;
            overflow: hidden;
        }
        
        .education-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(13,27,76,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>') repeat;
        }
        
        .education-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            margin-top: 4rem;
            position: relative;
            z-index: 2;
        }
        
        .education-card {
            background: #fff;
            border-radius: 24px;
            padding: 0;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(13,27,76,0.1);
        }
        
        .education-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 48px rgba(0,0,0,0.15);
        }
        
        .education-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--success-color), var(--warning-color));
        }
        
        .education-header {
            padding: 2rem 2rem 1rem;
            background: linear-gradient(135deg, rgba(0,123,255,0.05), rgba(40,167,69,0.05));
            position: relative;
        }
        
        .education-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(0,123,255,0.3);
            position: relative;
        }
        
        .education-icon::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            border-radius: 22px;
            z-index: -1;
            filter: blur(8px);
            opacity: 0.6;
        }
        
        .education-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            text-align: center;
        }
        
        .education-subtitle {
            font-size: 0.9rem;
            color: #666;
            text-align: center;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .education-content {
            padding: 1.5rem 2rem 2rem;
        }
        
        .education-features {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem;
        }
        
        .education-features li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            color: #555;
            line-height: 1.6;
        }
        
        .education-features li::before {
            content: '✓';
            background: linear-gradient(135deg, var(--success-color), #20c997);
            color: #fff;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .education-cta {
            background: linear-gradient(135deg, var(--primary-color), #0056b3);
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .education-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,123,255,0.4);
            color: #fff;
            text-decoration: none;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #0a0e1a 0%, #1a1f3a 25%, var(--secondary-color) 50%, var(--primary-color) 100%);
            color: #fff;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 20%, rgba(40, 167, 69, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(0, 123, 255, 0.2) 0%, transparent 50%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/><circle cx="25" cy="25" r="0.5" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1.5" fill="white" opacity="0.1"/></svg>') repeat;
        }
        
        .cta-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.03) 50%, transparent 70%);
            animation: ctaShine 12s ease-in-out infinite;
        }
        
        @keyframes ctaShine {
            0%, 100% { transform: translateX(-100%) skewX(-15deg); }
            50% { transform: translateX(100%) skewX(-15deg); }
        }
        
        .cta-container {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .cta-badge {
            display: inline-block;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .cta-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            background: linear-gradient(135deg, #fff 0%, rgba(255,255,255,0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .cta-text {
            font-size: 1.3rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .cta-btn {
            padding: 1.2rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.4s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            position: relative;
            overflow: hidden;
            min-width: 200px;
            justify-content: center;
        }
        
        .cta-btn-primary {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            color: var(--primary-color);
            box-shadow: 0 8px 32px rgba(255,255,255,0.2);
        }
        
        .cta-btn-secondary {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border: 2px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
        }
        
        .cta-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.3);
        }
        
        .cta-btn-primary:hover {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .cta-btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
            text-decoration: none;
        }
        
        /* Footer */
        .main-footer {
            background: var(--secondary-color);
            color: #fff;
            padding: 40px 0 20px;
            text-align: center;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #fff;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1rem;
            color: rgba(255,255,255,0.6);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .features-section {
                padding: 60px 0;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .feature-card {
                padding: 1.5rem;
            }
            
            .ticker-title {
                font-size: 1.5rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
            
            .cta-text {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 480px) {
            .features-section {
                padding: 40px 0;
            }
            
            .markets-ticker {
                padding: 40px 0;
            }
            
            .cta-section {
                padding: 60px 0;
            }
            
            .cta-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <i class="fas fa-chart-line"></i>
                <?php echo SITE_NAME; ?>
            </a>
            
            <nav class="main-nav">
                <a href="markets.php" class="nav-link">
                    <i class="fas fa-chart-line"></i>
                    <span><?php echo getCurrentLang() == 'tr' ? 'Piyasalar' : 'Markets'; ?></span>
                </a>
                <a href="portfolio.php" class="nav-link">
                    <i class="fas fa-chart-pie"></i>
                    <span><?php echo getCurrentLang() == 'tr' ? 'Portföy' : 'Portfolio'; ?></span>
                </a>
                <a href="wallet.php" class="nav-link">
                    <i class="fas fa-wallet"></i>
                    <span><?php echo getCurrentLang() == 'tr' ? 'Cüzdan' : 'Wallet'; ?></span>
                </a>
                <a href="profile.php" class="nav-link">
                    <i class="fas fa-user"></i>
                    <span><?php echo getCurrentLang() == 'tr' ? 'Profil' : 'Profile'; ?></span>
                </a>
            </nav>
            
            <div class="auth-buttons">
                <?php if (isLoggedIn()): ?>
                    <a href="profile.php" class="btn-outline-primary">
                        <i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?>
                    </a>
                    <a href="logout.php" class="btn-primary">
                        <i class="fas fa-sign-out-alt"></i> <?php echo getCurrentLang() == 'tr' ? 'Çıkış' : 'Logout'; ?>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn-outline-primary">
                        <?php echo getCurrentLang() == 'tr' ? 'Giriş' : 'Login'; ?>
                    </a>
                    <a href="register.php" class="btn-primary">
                        <?php echo getCurrentLang() == 'tr' ? 'Kayıt' : 'Register'; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Financial Floating Elements -->
        <div class="hero-floating-elements">
            <div class="floating-icon"><i class="fas fa-chart-line"></i></div>
            <div class="floating-icon"><i class="fas fa-coins"></i></div>
            <div class="floating-icon"><i class="fas fa-chart-bar"></i></div>
            <div class="floating-icon"><i class="fas fa-dollar-sign"></i></div>
            <div class="floating-icon"><i class="fas fa-trending-up"></i></div>
            <div class="floating-icon"><i class="fas fa-exchange-alt"></i></div>
            <div class="floating-icon"><i class="fas fa-piggy-bank"></i></div>
            <div class="floating-icon"><i class="fab fa-bitcoin"></i></div>
        </div>
        
        <!-- Financial Particles -->
        <div class="financial-particles">
            <div class="particle">$</div>
            <div class="particle">€</div>
            <div class="particle">£</div>
            <div class="particle">¥</div>
            <div class="particle">₿</div>
            <div class="particle">₹</div>
            <div class="particle">₺</div>
            <div class="particle">+1.2%</div>
            <div class="particle">-0.8%</div>
            <div class="particle">📈</div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">
                <?php echo getCurrentLang() == 'tr' ? 
                    'Türkiye\'nin En Güvenilir <br>Yatırım Platformu' : 
                    'Turkey\'s Most Trusted <br>Investment Platform'; ?>
            </h1>
            <p class="hero-subtitle">
                <?php echo getCurrentLang() == 'tr' ? 
                    'Düşük komisyonlar, güvenli altyapı ve profesyonel destek ile yatırımlarınızı büyütün.' : 
                    'Grow your investments with low commissions, secure infrastructure and professional support.'; ?>
            </p>
            <div class="hero-cta">
                <a href="register.php" class="btn-hero btn-hero-primary">
                    <i class="fas fa-rocket"></i>
                    <?php echo getCurrentLang() == 'tr' ? 'Hemen Başla' : 'Get Started'; ?>
                </a>
                <a href="markets.php" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-chart-line"></i>
                    <?php echo getCurrentLang() == 'tr' ? 'Piyasaları İncele' : 'Explore Markets'; ?>
                </a>
            </div>
        </div>
        
        <!-- Hero Stock Ticker -->
        <div class="hero-stock-ticker">
            <div class="stock-ticker-track">
                <div class="stock-ticker-item">
                    <span>AAPL</span>
                    <span class="stock-price">$175.50</span>
                    <span class="stock-change positive">+2.3%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>MSFT</span>
                    <span class="stock-price">$338.00</span>
                    <span class="stock-change positive">+1.8%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>TSLA</span>
                    <span class="stock-price">$248.00</span>
                    <span class="stock-change negative">-0.9%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>EUR/USD</span>
                    <span class="stock-price">1.0925</span>
                    <span class="stock-change positive">+0.2%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>USD/TRY</span>
                    <span class="stock-price">27.45</span>
                    <span class="stock-change negative">-0.1%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>GOLD</span>
                    <span class="stock-price">$1985</span>
                    <span class="stock-change positive">+1.1%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>BTC</span>
                    <span class="stock-price">$43,200</span>
                    <span class="stock-change positive">+3.2%</span>
                </div>
                <div class="stock-ticker-item">
                    <span>S&P 500</span>
                    <span class="stock-price">4,485</span>
                    <span class="stock-change positive">+0.8%</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center">
                <h2 style="font-size: 2.5rem; font-weight: 700; color: var(--secondary-color); margin-bottom: 1rem;">
                    <?php echo getCurrentLang() == 'tr' ? 'Neden GlobalBorsa?' : 'Why GlobalBorsa?'; ?>
                </h2>
                <p style="font-size: 1.1rem; color: #666; max-width: 600px; margin: 0 auto;">
                    <?php echo getCurrentLang() == 'tr' ? 
                        'Türkiye\'nin en güvenilir yatırım platformu olarak size sunduğumuz avantajlar' : 
                        'Advantages we offer as Turkey\'s most trusted investment platform'; ?>
                </p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">
                        <?php echo getCurrentLang() == 'tr' ? 'Güvenli Altyapı' : 'Secure Infrastructure'; ?>
                    </h3>
                    <p class="feature-text">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'Çoklu imza, soğuk cüzdan depolama ve 2FA ile paranız %100 güvende. Sigortalı varlık koruması.' : 
                            'Your money is 100% safe with multi-signature, cold wallet storage and 2FA. Insured asset protection.'; ?>
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 class="feature-title">
                        <?php echo getCurrentLang() == 'tr' ? 'Hızlı İşlemler' : 'Fast Transactions'; ?>
                    </h3>
                    <p class="feature-text">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'Milisaniye hızında emir eşleştirme motoru ile anlık alım-satım yapın. 0.1 saniyede işlem tamamlama.' : 
                            'Trade instantly with millisecond-speed order matching engine. Complete transactions in 0.1 seconds.'; ?>
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h3 class="feature-title">
                        <?php echo getCurrentLang() == 'tr' ? 'Düşük Komisyonlar' : 'Low Commissions'; ?>
                    </h3>
                    <p class="feature-text">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'Türkiye\'nin en düşük komisyon oranları ile daha fazla kar edin. Şeffaf ve adil fiyatlandırma.' : 
                            'Earn more with Turkey\'s lowest commission rates. Transparent and fair pricing.'; ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Markets Ticker -->
    <section class="markets-ticker">
        <div class="container">
            <h2 class="ticker-title">
                <?php echo getCurrentLang() == 'tr' ? 'Canlı Piyasa Verileri' : 'Live Market Data'; ?>
            </h2>
            
            <div class="ticker-container">
                <div class="ticker-track">
                    <?php if (!empty($markets)): ?>
                        <?php foreach ($markets as $market): ?>
                        <div class="ticker-item">
                            <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 0.8rem;">
                                <?php if ($market['logo_url']): ?>
                                <img src="<?php echo $market['logo_url']; ?>" 
                                     alt="<?php echo $market['symbol']; ?>" 
                                     style="width: 32px; height: 32px; border-radius: 50%; margin-right: 0.5rem;"
                                     onerror="this.style.display='none';">
                                <?php endif; ?>
                                <div style="color: #ffd700; font-size: 1.2rem; font-weight: 700;">
                                    <?php echo $market['symbol']; ?>
                                </div>
                            </div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 0.5rem;">
                                <?php echo $market['name']; ?>
                            </div>
                            <div style="color: #fff; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.25rem;">
                                $<?php echo formatPrice($market['price']); ?>
                            </div>
                            <div style="color: <?php echo $market['change_24h'] >= 0 ? '#22c55e' : '#ef4444'; ?>; font-size: 0.9rem; background: <?php echo $market['change_24h'] >= 0 ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)'; ?>; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                <?php echo ($market['change_24h'] >= 0 ? '+' : '') . formatTurkishNumber($market['change_24h'], 2); ?>%
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <!-- Duplicate for seamless loop -->
                        <?php foreach ($markets as $market): ?>
                        <div class="ticker-item">
                            <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 0.8rem;">
                                <?php if ($market['logo_url']): ?>
                                <img src="<?php echo $market['logo_url']; ?>" 
                                     alt="<?php echo $market['symbol']; ?>" 
                                     style="width: 32px; height: 32px; border-radius: 50%; margin-right: 0.5rem;"
                                     onerror="this.style.display='none';">
                                <?php endif; ?>
                                <div style="color: #ffd700; font-size: 1.2rem; font-weight: 700;">
                                    <?php echo $market['symbol']; ?>
                                </div>
                            </div>
                            <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 0.5rem;">
                                <?php echo $market['name']; ?>
                            </div>
                            <div style="color: #fff; font-size: 1.1rem; font-weight: 600; margin-bottom: 0.25rem;">
                                $<?php echo formatPrice($market['price']); ?>
                            </div>
                            <div style="color: <?php echo $market['change_24h'] >= 0 ? '#22c55e' : '#ef4444'; ?>; font-size: 0.9rem; background: <?php echo $market['change_24h'] >= 0 ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)'; ?>; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                <?php echo ($market['change_24h'] >= 0 ? '+' : '') . formatTurkishNumber($market['change_24h'], 2); ?>%
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section class="education-section">
        <div class="container">
            <div class="text-center">
                <h2 style="font-size: 3rem; font-weight: 800; color: var(--secondary-color); margin-bottom: 1rem;">
                    <?php echo getCurrentLang() == 'tr' ? 'Trading Akademisi' : 'Trading Academy'; ?>
                </h2>
                <p style="font-size: 1.2rem; color: #666; max-width: 700px; margin: 0 auto;">
                    <?php echo getCurrentLang() == 'tr' ? 
                        'Profesyonel trader olmak için ihtiyacınız olan tüm bilgileri uzman analistlerimizden öğrenin' : 
                        'Learn everything you need to become a professional trader from our expert analysts'; ?>
                </p>
            </div>
            
            <div class="education-grid">
                <!-- Forex Trading Card -->
                <div class="education-card">
                    <div class="education-header">
                        <div class="education-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h3 class="education-title">
                            <?php echo getCurrentLang() == 'tr' ? 'Forex Trading' : 'Forex Trading'; ?>
                        </h3>
                        <p class="education-subtitle">
                            <?php echo getCurrentLang() == 'tr' ? 'Döviz Piyasası Uzmanı' : 'Currency Market Expert'; ?>
                        </p>
                    </div>
                    <div class="education-content">
                        <ul class="education-features">
                            <li><?php echo getCurrentLang() == 'tr' ? 'Major çiftler analizi (EUR/USD, GBP/USD)' : 'Major pairs analysis (EUR/USD, GBP/USD)'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Teknik analiz ve chart pattern\'ları' : 'Technical analysis and chart patterns'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Risk yönetimi ve pozisyon boyutlandırma' : 'Risk management and position sizing'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Ekonomik takvim ve haber analizi' : 'Economic calendar and news analysis'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Demo hesap ile pratik yapma' : 'Practice with demo account'; ?></li>
                        </ul>
                        <a href="markets.php?category=forex_major" class="education-cta">
                            <i class="fas fa-play me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Forex\'e Başla' : 'Start Forex'; ?>
                        </a>
                    </div>
                </div>

                <!-- Stock Trading Card -->
                <div class="education-card">
                    <div class="education-header">
                        <div class="education-icon" style="background: linear-gradient(135deg, var(--success-color), #20c997);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="education-title">
                            <?php echo getCurrentLang() == 'tr' ? 'Hisse Senedi Analizi' : 'Stock Analysis'; ?>
                        </h3>
                        <p class="education-subtitle">
                            <?php echo getCurrentLang() == 'tr' ? 'Borsa Uzmanı' : 'Stock Market Expert'; ?>
                        </p>
                    </div>
                    <div class="education-content">
                        <ul class="education-features">
                            <li><?php echo getCurrentLang() == 'tr' ? 'Apple, Tesla, Microsoft hisse analizi' : 'Apple, Tesla, Microsoft stock analysis'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Fundamental analiz teknikleri' : 'Fundamental analysis techniques'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Portföy diversifikasyonu stratejileri' : 'Portfolio diversification strategies'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Kazanç raporları değerlendirmesi' : 'Earnings reports evaluation'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Long-term yatırım stratejileri' : 'Long-term investment strategies'; ?></li>
                        </ul>
                        <a href="markets.php?category=us_stocks" class="education-cta">
                            <i class="fas fa-play me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Hisse Senetlerine Başla' : 'Start Stock Trading'; ?>
                        </a>
                    </div>
                </div>

                <!-- Crypto Trading Card -->
                <div class="education-card">
                    <div class="education-header">
                        <div class="education-icon" style="background: linear-gradient(135deg, var(--warning-color), #e0a800);">
                            <i class="fab fa-bitcoin"></i>
                        </div>
                        <h3 class="education-title">
                            <?php echo getCurrentLang() == 'tr' ? 'Kripto Para Trading' : 'Crypto Trading'; ?>
                        </h3>
                        <p class="education-subtitle">
                            <?php echo getCurrentLang() == 'tr' ? 'Blockchain Uzmanı' : 'Blockchain Expert'; ?>
                        </p>
                    </div>
                    <div class="education-content">
                        <ul class="education-features">
                            <li><?php echo getCurrentLang() == 'tr' ? 'Bitcoin ve Ethereum analizi' : 'Bitcoin and Ethereum analysis'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Altcoin seçim stratejileri' : 'Altcoin selection strategies'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'DeFi protokolleri ve yield farming' : 'DeFi protocols and yield farming'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Blockchain teknolojisi temelleri' : 'Blockchain technology fundamentals'; ?></li>
                            <li><?php echo getCurrentLang() == 'tr' ? 'Kripto volatilitesi yönetimi' : 'Crypto volatility management'; ?></li>
                        </ul>
                        <a href="markets.php?category=commodities" class="education-cta">
                            <i class="fas fa-play me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Kripto\'ya Başla' : 'Start Crypto'; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <div class="cta-badge">
                <?php echo getCurrentLang() == 'tr' ? '🚀 Sınırlı Süreli Fırsat' : '🚀 Limited Time Offer'; ?>
            </div>
            <h2 class="cta-title">
                <?php echo getCurrentLang() == 'tr' ? 'Yatırım Yolculuğunuza Hemen Başlayın!' : 'Start Your Investment Journey Now!'; ?>
            </h2>
            <p class="cta-text">
                <?php echo getCurrentLang() == 'tr' ? 
                    'Profesyonel araçlar, uzman analizler ve güvenli altyapı ile yatırımlarınızı bir sonraki seviyeye taşıyın. İlk yatırımınızda %100 bonus kazanma fırsatını kaçırmayın!' : 
                    'Take your investments to the next level with professional tools, expert analysis and secure infrastructure. Don\'t miss the opportunity to earn 100% bonus on your first investment!'; ?>
            </p>
            <div class="cta-buttons">
                <a href="register.php" class="cta-btn cta-btn-primary">
                    <i class="fas fa-rocket"></i>
                    <?php echo getCurrentLang() == 'tr' ? 'Ücretsiz Hesap Aç' : 'Open Free Account'; ?>
                </a>
                <a href="markets.php" class="cta-btn cta-btn-secondary">
                    <i class="fas fa-chart-line"></i>
                    <?php echo getCurrentLang() == 'tr' ? 'Piyasaları Keşfet' : 'Explore Markets'; ?>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><?php echo getCurrentLang() == 'tr' ? 'Platform' : 'Platform'; ?></h4>
                    <ul class="footer-links">
                        <li><a href="markets.php"><?php echo getCurrentLang() == 'tr' ? 'Piyasalar' : 'Markets'; ?></a></li>
                        <li><a href="portfolio.php"><?php echo getCurrentLang() == 'tr' ? 'Portföy' : 'Portfolio'; ?></a></li>
                        <li><a href="profile.php"><?php echo getCurrentLang() == 'tr' ? 'Profil' : 'Profile'; ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo getCurrentLang() == 'tr' ? 'Destek' : 'Support'; ?></h4>
                    <ul class="footer-links">
                        <li><a href="#"><?php echo getCurrentLang() == 'tr' ? 'Yardım Merkezi' : 'Help Center'; ?></a></li>
                        <li><a href="#"><?php echo getCurrentLang() == 'tr' ? 'Canlı Destek' : 'Live Support'; ?></a></li>
                        <li><a href="#"><?php echo getCurrentLang() == 'tr' ? 'İletişim' : 'Contact'; ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo getCurrentLang() == 'tr' ? 'Yasal' : 'Legal'; ?></h4>
                    <ul class="footer-links">
                        <li><a href="#"><?php echo getCurrentLang() == 'tr' ? 'Kullanım Şartları' : 'Terms of Service'; ?></a></li>
                        <li><a href="#"><?php echo getCurrentLang() == 'tr' ? 'Gizlilik Politikası' : 'Privacy Policy'; ?></a></li>
                        <li><a href="#"><?php echo getCurrentLang() == 'tr' ? 'Risk Uyarısı' : 'Risk Warning'; ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo getCurrentLang() == 'tr' ? 'Takip Edin' : 'Follow Us'; ?></h4>
                    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1rem;">
                        <a href="#" style="color: rgba(255,255,255,0.8); font-size: 1.5rem; transition: color 0.3s ease;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="color: rgba(255,255,255,0.8); font-size: 1.5rem; transition: color 0.3s ease;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" style="color: rgba(255,255,255,0.8); font-size: 1.5rem; transition: color 0.3s ease;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo SITE_NAME; ?>. <?php echo getCurrentLang() == 'tr' ? 'Tüm hakları saklıdır.' : 'All rights reserved.'; ?></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.main-header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = '#fff';
                header.style.backdropFilter = 'none';
            }
        });
        
        // Ticker hover pause
        const tickerTrack = document.querySelector('.ticker-track');
        if (tickerTrack) {
            tickerTrack.addEventListener('mouseenter', () => {
                tickerTrack.style.animationPlayState = 'paused';
            });
            
            tickerTrack.addEventListener('mouseleave', () => {
                tickerTrack.style.animationPlayState = 'running';
            });
        }
    </script>
</body>
</html>
