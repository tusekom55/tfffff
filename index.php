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
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: #fff;
            padding: 120px 0 80px;
            margin-top: 70px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/><circle cx="20" cy="20" r="1" fill="white" opacity="0.1"/><circle cx="80" cy="30" r="1.5" fill="white" opacity="0.1"/></svg>') repeat;
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
        
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            padding: 80px 0;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
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
                            <div style="color: #ffd700; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">
                                <?php echo $market['symbol']; ?>
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
                            <div style="color: #ffd700; font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">
                                <?php echo $market['symbol']; ?>
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

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">
                <?php echo getCurrentLang() == 'tr' ? 'Yatırıma Başlamaya Hazır Mısınız?' : 'Ready to Start Investing?'; ?>
            </h2>
            <p class="cta-text">
                <?php echo getCurrentLang() == 'tr' ? 
                    'Dakikalar içinde hesap açın ve yatırım dünyasına adım atın. Uzman ekibimiz size yardımcı olmaya hazır.' : 
                    'Open an account in minutes and step into the investment world. Our expert team is ready to help you.'; ?>
            </p>
            <div class="hero-cta">
                <a href="register.php" class="btn-hero btn-hero-primary">
                    <i class="fas fa-user-plus"></i>
                    <?php echo getCurrentLang() == 'tr' ? 'Ücretsiz Hesap Aç' : 'Open Free Account'; ?>
                </a>
                <a href="markets.php" class="btn-hero btn-hero-secondary">
                    <i class="fas fa-chart-bar"></i>
                    <?php echo getCurrentLang() == 'tr' ? 'Demo Hesap Deneyin' : 'Try Demo Account'; ?>
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
