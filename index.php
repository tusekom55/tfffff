<?php
require_once 'includes/functions.php';

$page_title = 'GlobalBorsa - Türkiye\'nin En Güvenilir Kripto Borsası';

// Get some sample market data for display  
$markets = getMarketData('us_stocks', 6);
?>

<!DOCTYPE html>
<html lang="<?php echo getCurrentLang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="Türkiye'nin en güvenilir kripto borsası. 7/24 Türkçe destek, güvenli altyapı, düşük komisyonlar.">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link href="assets/css/landing-new.css" rel="stylesheet">
    <link href="assets/css/landing-index.css" rel="stylesheet">
    
    <style>
        /* Ticker Animation Keyframes */
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Force ticker styles */
        .ticker-track {
            display: flex !important;
            animation: ticker 30s linear infinite !important;
            gap: 2rem !important;
            width: max-content !important;
        }
        
        .coin-ticker:hover .ticker-track {
            animation-play-state: paused !important;
        }
        
        .coin-item {
            flex-shrink: 0 !important;
            background: white !important;
            border-radius: 15px !important;
            padding: 1.5rem !important;
            min-width: 200px !important;
            text-align: center !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1) !important;
            transition: transform 0.3s ease !important;
        }
        
        .coin-item:hover {
            transform: translateY(-5px) !important;
        }
        
        .coin-flag {
            font-size: 2rem !important;
            margin-bottom: 0.5rem !important;
        }

        /* Mobile Responsive Optimizations */
        @media (max-width: 768px) {
            /* Mobile Navbar Optimizations */
            nav .container {
                padding: 0 15px;
            }
            
            nav .d-flex.align-items-center.gap-2 {
                flex-wrap: wrap;
                gap: 8px !important;
            }
            
            /* Mobile Navigation Links - Hide some on mobile */
            nav .d-flex.gap-1 a:nth-child(3),
            nav .d-flex.gap-1 a:nth-child(4) {
                display: none;
            }
            
            /* Mobile Balance Display */
            nav .d-flex.align-items-center .d-flex:first-child {
                order: 1;
                margin-right: 8px !important;
                margin-left: 12px;
            }
            
            /* Mobile Language Switcher */
            nav .d-flex.align-items-center > div:first-child {
                margin-right: 8px !important;
            }
            
            /* Mobile User Menu */
            nav .d-flex.align-items-center > div:last-child button {
                padding: 6px 12px !important;
                font-size: 0.8rem !important;
            }
            
            /* Mobile Login Buttons */
            nav .d-flex.align-items-center a {
                padding: 6px 12px !important;
                font-size: 0.85rem !important;
                margin-right: 4px !important;
            }
            
            /* Hero Section Mobile */
            .hero-slider {
                padding-top: 60px;
            }
            
            .hero-title {
                font-size: 1.8rem !important;
                line-height: 1.2 !important;
                margin-bottom: 1rem !important;
            }
            
            .hero-subtitle {
                font-size: 0.9rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .hero-description {
                font-size: 1rem !important;
                margin-bottom: 1.5rem !important;
            }
            
            .btn-cta {
                padding: 12px 24px !important;
                font-size: 0.9rem !important;
                margin-bottom: 1rem !important;
            }
            
            .hero-disclaimer {
                font-size: 0.8rem !important;
            }
            
            /* Service Cards Mobile Grid */
            section[style*="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr))"] {
                display: block !important;
            }
            
            section[style*="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr))"] > div {
                margin-bottom: 20px !important;
                max-width: 100% !important;
            }
            
            /* Mobile Ticker */
            section[style*="background: #0d1b4c"] .container h2 {
                font-size: 1.5rem !important;
                margin-bottom: 30px !important;
            }
            
            div[style*="animation: marketTicker"] > div {
                min-width: 160px !important;
                padding: 15px !important;
            }
            
            div[style*="animation: marketTicker"] > div > div:first-child {
                width: 40px !important;
                height: 40px !important;
                margin: 0 auto 10px !important;
            }
            
            div[style*="animation: marketTicker"] > div > div:nth-child(2) {
                font-size: 1rem !important;
            }
            
            div[style*="animation: marketTicker"] > div > div:nth-child(3) {
                font-size: 0.8rem !important;
            }
            
            div[style*="animation: marketTicker"] > div > div:nth-child(4) {
                font-size: 1.1rem !important;
            }
            
            div[style*="animation: marketTicker"] > div > div:nth-child(5) {
                font-size: 0.8rem !important;
            }
            
            /* Promo Cards Mobile */
            .promo-grid {
                display: block !important;
            }
            
            .promo-card {
                margin-bottom: 20px !important;
                flex-direction: column !important;
            }
            
            .promo-content,
            .promo-visual {
                width: 100% !important;
                text-align: center !important;
            }
            
            .promo-visual {
                margin-top: 20px !important;
                order: 2 !important;
            }
            
            /* Education Section Mobile */
            section[style*="background: #f8f9fa; padding: 80px 0"] {
                padding: 40px 0 !important;
            }
            
            section[style*="background: #f8f9fa; padding: 80px 0"] h2 {
                font-size: 1.8rem !important;
                margin-bottom: 15px !important;
            }
            
            section[style*="background: #f8f9fa; padding: 80px 0"] p {
                font-size: 1rem !important;
                margin-bottom: 40px !important;
            }
            
            section[style*="background: #f8f9fa; padding: 80px 0"] > div > div:last-child {
                display: block !important;
            }
            
            section[style*="background: #f8f9fa; padding: 80px 0"] > div > div:last-child > div {
                margin-bottom: 25px !important;
            }
            
            /* Contact CTA Mobile */
            .contact-cta .contact-content {
                flex-direction: column !important;
            }
            
            .contact-info,
            .contact-form {
                width: 100% !important;
                margin-bottom: 30px !important;
            }
            
            .contact-info h2 {
                font-size: 1.6rem !important;
                margin-bottom: 15px !important;
            }
            
            .contact-features {
                margin-bottom: 30px !important;
            }
            
            .contact-features .feature {
                margin-bottom: 10px !important;
                font-size: 0.9rem !important;
            }
            
            /* Live Support Button Mobile */
            .live-support {
                bottom: 80px !important;
                right: 15px !important;
            }
            
            .support-btn {
                padding: 10px 15px !important;
                font-size: 0.85rem !important;
            }
            
            .support-btn span {
                display: none !important;
            }
            
            .support-btn i {
                margin-right: 0 !important;
                font-size: 1.2rem !important;
            }
        }

        /* Very Small Mobile (320px-480px) */
        @media (max-width: 480px) {
            .container {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            
            /* Extra small mobile navbar */
            nav .d-flex.gap-1 a {
                font-size: 0.75rem !important;
                padding: 6px 8px !important;
            }
            
            nav a[href="index.php"] {
                font-size: 1.2rem !important;
            }
            
            /* Hero mobile extra small */
            .hero-title {
                font-size: 1.5rem !important;
            }
            
            .hero-description {
                font-size: 0.9rem !important;
            }
            
            .btn-cta {
                font-size: 0.8rem !important;
                padding: 10px 20px !important;
            }
            
            /* Service cards extra small */
            div[style*="padding: 40px 30px"] {
                padding: 25px 20px !important;
            }
            
            div[style*="font-size: 1.4rem"] {
                font-size: 1.2rem !important;
            }
            
            /* Education cards extra small */
            div[style*="padding: 30px"] {
                padding: 20px !important;
            }
        }
    </style>
</head>
<body>
    <!-- STYLED NAVBAR (Bootstrap-like) -->
    <nav style="position: fixed; top: 0; left: 0; right: 0; background: #ffffff; z-index: 999999; padding: 12px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border-bottom: 1px solid #dee2e6;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Brand -->
                <a href="index.php" style="text-decoration: none; color: #007bff; font-weight: 700; font-size: 1.5rem; display: flex; align-items: center;">
                    <i class="fas fa-chart-line" style="margin-right: 8px; color: #007bff;"></i>
                    <?php echo SITE_NAME; ?>
                </a>
                
                <!-- Navigation Links -->
                <div class="d-flex align-items-center" style="flex-grow: 1; justify-content: center;">
                    <div class="d-flex gap-1">
                        <a href="index.php" style="text-decoration: none; color: <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? '#007bff' : '#495057'; ?>; padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.2s ease; background: <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>;" onmouseover="this.style.background='rgba(0,123,255,0.1)'; this.style.color='#007bff';" onmouseout="this.style.background='<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>'; this.style.color='<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? '#007bff' : '#495057'; ?>';">
                            <i class="fas fa-home" style="margin-right: 6px; font-size: 14px;"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Ana Sayfa' : 'Home'; ?>
                        </a>
                        
                        <a href="markets.php" style="text-decoration: none; color: <?php echo basename($_SERVER['PHP_SELF']) == 'markets.php' ? '#007bff' : '#495057'; ?>; padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.2s ease; background: <?php echo basename($_SERVER['PHP_SELF']) == 'markets.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>;" onmouseover="this.style.background='rgba(0,123,255,0.1)'; this.style.color='#007bff';" onmouseout="this.style.background='<?php echo basename($_SERVER['PHP_SELF']) == 'markets.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>'; this.style.color='<?php echo basename($_SERVER['PHP_SELF']) == 'markets.php' ? '#007bff' : '#495057'; ?>';">
                            <i class="fas fa-chart-bar" style="margin-right: 6px; font-size: 14px;"></i>
                            <?php echo t('markets'); ?>
                        </a>
                        
                        <?php if (isLoggedIn()): ?>
                        <a href="trading.php" style="text-decoration: none; color: <?php echo basename($_SERVER['PHP_SELF']) == 'trading.php' ? '#007bff' : '#495057'; ?>; padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.2s ease; background: <?php echo basename($_SERVER['PHP_SELF']) == 'trading.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>;" onmouseover="this.style.background='rgba(0,123,255,0.1)'; this.style.color='#007bff';" onmouseout="this.style.background='<?php echo basename($_SERVER['PHP_SELF']) == 'trading.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>'; this.style.color='<?php echo basename($_SERVER['PHP_SELF']) == 'trading.php' ? '#007bff' : '#495057'; ?>';">
                            <i class="fas fa-exchange-alt" style="margin-right: 6px; font-size: 14px;"></i>
                            <?php echo t('trading'); ?>
                        </a>
                        
                        <a href="wallet.php" style="text-decoration: none; color: <?php echo basename($_SERVER['PHP_SELF']) == 'wallet.php' ? '#007bff' : '#495057'; ?>; padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.2s ease; background: <?php echo basename($_SERVER['PHP_SELF']) == 'wallet.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>;" onmouseover="this.style.background='rgba(0,123,255,0.1)'; this.style.color='#007bff';" onmouseout="this.style.background='<?php echo basename($_SERVER['PHP_SELF']) == 'wallet.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>'; this.style.color='<?php echo basename($_SERVER['PHP_SELF']) == 'wallet.php' ? '#007bff' : '#495057'; ?>';">
                            <i class="fas fa-wallet" style="margin-right: 6px; font-size: 14px;"></i>
                            <?php echo t('wallet'); ?>
                        </a>
                        
                        <a href="profile.php" style="text-decoration: none; color: <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? '#007bff' : '#495057'; ?>; padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.2s ease; background: <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>;" onmouseover="this.style.background='rgba(0,123,255,0.1)'; this.style.color='#007bff';" onmouseout="this.style.background='<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'rgba(0,123,255,0.1)' : 'transparent'; ?>'; this.style.color='<?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? '#007bff' : '#495057'; ?>';">
                            <i class="fas fa-user" style="margin-right: 6px; font-size: 14px;"></i>
                            <?php echo t('profile'); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Language Switcher -->
                    <div class="d-flex" style="margin-right: 16px;">
                        <a href="?lang=tr" style="text-decoration: none; padding: 6px 12px; background: <?php echo getCurrentLang() == 'tr' ? '#007bff' : '#f8f9fa'; ?>; color: <?php echo getCurrentLang() == 'tr' ? 'white' : '#6c757d'; ?>; border-radius: 4px 0 0 4px; font-size: 0.875rem; font-weight: 500; border: 1px solid <?php echo getCurrentLang() == 'tr' ? '#007bff' : '#dee2e6'; ?>; border-right: none;">TR</a>
                        <a href="?lang=en" style="text-decoration: none; padding: 6px 12px; background: <?php echo getCurrentLang() == 'en' ? '#007bff' : '#f8f9fa'; ?>; color: <?php echo getCurrentLang() == 'en' ? 'white' : '#6c757d'; ?>; border-radius: 0 4px 4px 0; font-size: 0.875rem; font-weight: 500; border: 1px solid <?php echo getCurrentLang() == 'en' ? '#007bff' : '#dee2e6'; ?>;">EN</a>
                    </div>
                    
                    <?php if (isLoggedIn()): ?>
                        <!-- User Balance -->
                        <div style="margin-right: 16px; font-size: 0.875rem;">
                            <span style="color: #6c757d;"><?php echo t('balance'); ?>:</span>
                            <strong style="color: #28a745;"><?php echo getFormattedHeaderBalance($_SESSION['user_id']); ?></strong>
                        </div>
                        
                        <!-- User Menu Button -->
                        <div style="position: relative; display: inline-block;">
                            <button style="background: #fff; border: 1px solid #007bff; color: #007bff; padding: 8px 16px; border-radius: 6px; font-weight: 500; cursor: pointer; display: flex; align-items: center; font-size: 0.9rem;" onclick="toggleUserMenu()">
                                <i class="fas fa-user" style="margin-right: 6px; font-size: 14px;"></i>
                                <?php echo $_SESSION['username']; ?>
                                <i class="fas fa-chevron-down" style="margin-left: 6px; font-size: 12px;"></i>
                            </button>
                            <div id="userMenu" style="position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6; border-radius: 6px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); min-width: 180px; z-index: 1000; display: none; margin-top: 4px;">
                                <a href="profile.php" style="display: block; padding: 12px 16px; color: #495057; text-decoration: none; border-bottom: 1px solid #f8f9fa;" onmouseover="this.style.background='#f8f9fa';" onmouseout="this.style.background='white';">
                                    <i class="fas fa-user" style="margin-right: 8px; color: #6c757d;"></i><?php echo t('profile'); ?>
                                </a>
                                <a href="wallet.php" style="display: block; padding: 12px 16px; color: #495057; text-decoration: none; border-bottom: 1px solid #f8f9fa;" onmouseover="this.style.background='#f8f9fa';" onmouseout="this.style.background='white';">
                                    <i class="fas fa-wallet" style="margin-right: 8px; color: #6c757d;"></i><?php echo t('wallet'); ?>
                                </a>
                                <a href="logout.php" style="display: block; padding: 12px 16px; color: #dc3545; text-decoration: none;" onmouseover="this.style.background='#f8f9fa';" onmouseout="this.style.background='white';">
                                    <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i><?php echo t('logout'); ?>
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" style="text-decoration: none; color: #007bff; padding: 8px 16px; border: 1px solid #007bff; border-radius: 6px; font-weight: 500; margin-right: 8px; transition: all 0.2s ease;" onmouseover="this.style.background='#007bff'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.color='#007bff';">
                            <?php echo t('login'); ?>
                        </a>
                        <a href="register.php" style="text-decoration: none; color: white; padding: 8px 16px; background: #007bff; border: 1px solid #007bff; border-radius: 6px; font-weight: 500; transition: all 0.2s ease;" onmouseover="this.style.background='#0056b3'; this.style.borderColor='#0056b3';" onmouseout="this.style.background='#007bff'; this.style.borderColor='#007bff';">
                            <?php echo t('register'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Slider -->
    <section class="hero-slider" id="hero">
        <div class="slider-container">
            <!-- Slide 1 -->
            <div class="slide active">
                <div class="slide-background"></div>
                <div class="slide-content">
                    <div class="container">
                        <p class="hero-subtitle"><?php echo getCurrentLang() == 'tr' ? 'Binlerce yatırımcı bize güveniyor' : 'Thousands of investors trust us'; ?></p>
                        <h1 class="hero-title">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Türkiye\'nin en güvenilir <span class="highlight">kripto borsası</span> olmamız tesadüf değil' : 
                                'Being Turkey\'s most trusted <span class="highlight">crypto exchange</span> is no coincidence'; ?>
                        </h1>
                        <p class="hero-description">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Yatırımcılara rahatça kâr edebilecekleri seçkin bir yatırım ortamı sağlıyoruz.' : 
                                'We provide an exclusive investment environment where investors can easily profit.'; ?>
                        </p>
                        <a href="register.php" class="btn-cta">
                            <?php echo getCurrentLang() == 'tr' ? '1.000 TL\'ye varan %100 bonus alın' : 'Get up to 1,000 TL 100% bonus'; ?>
                        </a>
                        <p class="hero-disclaimer">
                            *<?php echo getCurrentLang() == 'tr' ? 'Sınırlı süreli teklif' : 'Limited time offer'; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <div class="slide-background slide-bg-2"></div>
                <div class="slide-content">
                    <div class="container">
                        <p class="hero-subtitle"><?php echo getCurrentLang() == 'tr' ? 'Kripto pazarında lider pozisyon' : 'Leading position in crypto market'; ?></p>
                        <h1 class="hero-title">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Bitcoin ve Altcoin Ticaretinde <span class="highlight">Lider Platform</span>' : 
                                'Leading Platform in <span class="highlight">Bitcoin & Altcoin Trading</span>'; ?>
                        </h1>
                        <p class="hero-description">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Türkiye\'de 100.000\'den fazla yatırımcının tercih ettiği güvenilir platform. Düşük komisyonlar ve hızlı işlem garantisi.' : 
                                'Trusted platform preferred by over 100,000 investors in Turkey. Low commissions and fast transaction guarantee.'; ?>
                        </p>
                        <a href="register.php" class="btn-cta">
                            <?php echo getCurrentLang() == 'tr' ? 'Canlı Hesap Aç' : 'Open Live Account'; ?>
                        </a>
                        <p class="hero-disclaimer">
                            *<?php echo getCurrentLang() == 'tr' ? 'Risk uyarısı geçerlidir' : 'Risk warning applies'; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <div class="slide-background slide-bg-3"></div>
                <div class="slide-content">
                    <div class="container">
                        <p class="hero-subtitle"><?php echo getCurrentLang() == 'tr' ? 'Profesyonel analist desteği' : 'Professional analyst support'; ?></p>
                        <h1 class="hero-title">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Uzman Analist Desteği ile <span class="highlight">Kazanmaya Başlayın</span>' : 
                                'Start Winning with <span class="highlight">Expert Analyst Support</span>'; ?>
                        </h1>
                        <p class="hero-description">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Günlük kripto analizleri, webinarlar ve eğitim materyalleri ile yatırım bilginizi artırın. Başarılı trader\'ların sırlarını öğrenin.' : 
                                'Increase your investment knowledge with daily crypto analysis, webinars and training materials. Learn the secrets of successful traders.'; ?>
                        </p>
                        <a href="markets.php" class="btn-cta">
                            <?php echo getCurrentLang() == 'tr' ? 'Piyasalara Göz Atın' : 'View Markets'; ?>
                        </a>
                        <p class="hero-disclaimer">
                            *<?php echo getCurrentLang() == 'tr' ? 'Eğitim materyalleri ücretsizdir' : 'Training materials are free'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Auto-play Progress Bar -->
        <div class="slider-progress" id="sliderProgress"></div>
    </section>


    <!-- BORSA TEMALI SERVICE CARDS -->
    <section style="background: #f8f9fa; padding: 80px 0; z-index: 100; position: relative;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h2 style="font-size: 2.5rem; font-weight: 700; color: #0d1b4c; margin-bottom: 20px;">
                    <?php echo getCurrentLang() == 'tr' ? 'Neden GlobalBorsa?' : 'Why GlobalBorsa?'; ?>
                </h2>
                <p style="font-size: 1.1rem; color: #666; max-width: 600px; margin: 0 auto;">
                    <?php echo getCurrentLang() == 'tr' ? 'Türkiye\'nin en güvenilir kripto borsası olarak size sunduğumuz avantajlar' : 'Advantages we offer as Turkey\'s most trusted crypto exchange'; ?>
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; margin-top: 20px;">
                
                <!-- Düşük Komisyon Card -->
                <div style="background: #fff; padding: 40px 30px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; border-top: 3px solid #28a745; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0, 0, 0, 0.1)'">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #28a745, #1e7e34); border-radius: 50%; color: #fff; font-size: 2rem;">
                        💰
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 600; color: #0d1b4c; margin-bottom: 15px;">
                        <?php echo getCurrentLang() == 'tr' ? 'Düşük Komisyonlar' : 'Low Commissions'; ?>
                    </h3>
                    <p style="color: #666; line-height: 1.6; margin: 0;">
                        <?php echo getCurrentLang() == 'tr' ? 'Türkiye\'nin en düşük komisyon oranları ile daha fazla kar edin. Maker %0.05, Taker %0.10' : 'Earn more with Turkey\'s lowest commission rates. Maker 0.05%, Taker 0.10%'; ?>
                    </p>
                </div>

                <!-- Hızlı İşlem Card -->
                <div style="background: #fff; padding: 40px 30px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; border-top: 3px solid #007bff; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0, 0, 0, 0.1)'">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #007bff, #0056b3); border-radius: 50%; color: #fff; font-size: 2rem;">
                        ⚡
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 600; color: #0d1b4c; margin-bottom: 15px;">
                        <?php echo getCurrentLang() == 'tr' ? 'Hızlı İşlemler' : 'Fast Transactions'; ?>
                    </h3>
                    <p style="color: #666; line-height: 1.6; margin: 0;">
                        <?php echo getCurrentLang() == 'tr' ? 'Milisaniye hızında emir eşleştirme motoru ile anlık alım-satım yapın. 0.1 saniyede işlem tamamlama.' : 'Trade instantly with millisecond-speed order matching engine. Complete transactions in 0.1 seconds.'; ?>
                    </p>
                </div>

                <!-- Güvenlik Card -->
                <div style="background: #fff; padding: 40px 30px; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; border-top: 3px solid #dc3545; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0, 0, 0, 0.1)'">
                    <div style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #dc3545, #c82333); border-radius: 50%; color: #fff; font-size: 2rem;">
                        🛡️
                    </div>
                    <h3 style="font-size: 1.4rem; font-weight: 600; color: #0d1b4c; margin-bottom: 15px;">
                        <?php echo getCurrentLang() == 'tr' ? 'Güvenli Altyapı' : 'Secure Infrastructure'; ?>
                    </h3>
                    <p style="color: #666; line-height: 1.6; margin: 0;">
                        <?php echo getCurrentLang() == 'tr' ? 'Çoklu imza, soğuk cüzdan depolama ve 2FA ile paranız %100 güvende. Sigortalı varlık koruması.' : 'Your money is 100% safe with multi-signature, cold wallet storage and 2FA. Insured asset protection.'; ?>
                    </p>
                </div>
                
            </div>
        </div>
    </section>

    <!-- WORKING TICKER AS MARKET INDICATORS -->
    <section style="background: #0d1b4c; padding: 60px 0; overflow: hidden;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 style="color: #fff; font-size: 2rem; font-weight: 600; margin: 0;">
                    <?php echo getCurrentLang() == 'tr' ? 'Canlı Piyasa Göstergeleri' : 'Live Market Indicators'; ?>
                </h2>
            </div>
            
            <div style="overflow: hidden; position: relative; mask: linear-gradient(90deg, transparent, white 10%, white 90%, transparent); -webkit-mask: linear-gradient(90deg, transparent, white 10%, white 90%, transparent);">
                <div style="display: flex; animation: marketTicker 25s linear infinite; gap: 30px; width: max-content;" onmouseover="this.style.animationPlayState='paused'" onmouseout="this.style.animationPlayState='running'">
                    
                    <!-- Apple -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #000, #333); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🍎</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">AAPL</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Apple Inc.</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$189.25</div>
                        <div style="font-size: 0.9rem; color: #22c55e; background: rgba(34, 197, 94, 0.2); padding: 4px 8px; border-radius: 4px;">+2.15%</div>
                    </div>
                    
                    <!-- Microsoft -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #0078d4, #005a9e); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem; font-weight: bold;">MS</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">MSFT</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Microsoft</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$412.80</div>
                        <div style="font-size: 0.9rem; color: #22c55e; background: rgba(34, 197, 94, 0.2); padding: 4px 8px; border-radius: 4px;">+1.87%</div>
                    </div>
                    
                    <!-- Google -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #4285f4, #34a853, #fbbc04, #ea4335); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem; font-weight: bold;">G</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">GOOGL</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Alphabet Inc.</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$139.65</div>
                        <div style="font-size: 0.9rem; color: #ef4444; background: rgba(239, 68, 68, 0.2); padding: 4px 8px; border-radius: 4px;">-0.95%</div>
                    </div>
                    
                    <!-- Amazon -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #ff9900, #ff6600); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem;">📦</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">AMZN</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Amazon</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$145.32</div>
                        <div style="font-size: 0.9rem; color: #22c55e; background: rgba(34, 197, 94, 0.2); padding: 4px 8px; border-radius: 4px;">+3.24%</div>
                    </div>
                    
                    <!-- Tesla -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #cc0000, #990000); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem;">⚡</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">TSLA</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Tesla Inc.</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$248.50</div>
                        <div style="font-size: 0.9rem; color: #ef4444; background: rgba(239, 68, 68, 0.2); padding: 4px 8px; border-radius: 4px;">-1.45%</div>
                    </div>
                    
                    <!-- Meta -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #1877f2, #0d47a1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem; font-weight: bold;">f</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">META</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Meta Platforms</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$494.75</div>
                        <div style="font-size: 0.9rem; color: #22c55e; background: rgba(34, 197, 94, 0.2); padding: 4px 8px; border-radius: 4px;">+0.87%</div>
                    </div>
                    
                    <!-- DUPLICATE FOR SEAMLESS LOOP -->
                    
                    <!-- Apple Duplicate -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #000, #333); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🍎</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">AAPL</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Apple Inc.</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$189.25</div>
                        <div style="font-size: 0.9rem; color: #22c55e; background: rgba(34, 197, 94, 0.2); padding: 4px 8px; border-radius: 4px;">+2.15%</div>
                    </div>
                    
                    <!-- Microsoft Duplicate -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #0078d4, #005a9e); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem; font-weight: bold;">MS</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">MSFT</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Microsoft</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$412.80</div>
                        <div style="font-size: 0.9rem; color: #22c55e; background: rgba(34, 197, 94, 0.2); padding: 4px 8px; border-radius: 4px;">+1.87%</div>
                    </div>
                    
                    <!-- Google Duplicate -->
                    <div style="flex-shrink: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; min-width: 200px; text-align: center; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.transform='translateY(-5px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='translateY(0)'">
                        <div style="width: 50px; height: 50px; margin: 0 auto 12px; background: linear-gradient(135deg, #4285f4, #34a853, #fbbc04, #ea4335); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.3rem; font-weight: bold;">G</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px;">GOOGL</div>
                        <div style="font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 8px;">Alphabet Inc.</div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: #ffd700; margin-bottom: 4px;">$139.65</div>
                        <div style="font-size: 0.9rem; color: #ef4444; background: rgba(239, 68, 68, 0.2); padding: 4px 8px; border-radius: 4px;">-0.95%</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        @keyframes marketTicker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>

    <!-- Promo Cards Section -->
    <section class="promo-cards" id="promo-cards">
        <div class="container">
            <h2 class="section-title animate-on-scroll">
                <?php echo getCurrentLang() == 'tr' ? 'Yatırımcılarımızın' : 'Take a look at our investors\''; ?>
                <span class="highlight"><?php echo getCurrentLang() == 'tr' ? 'favorilerine' : 'favorites'; ?></span> 
                <?php echo getCurrentLang() == 'tr' ? 'göz atın' : ''; ?>
            </h2>
            <p class="section-subtitle animate-on-scroll">
                <?php echo getCurrentLang() == 'tr' ? 
                    'Yatırımda herkesin ilk tercihi olmamızı sağlayan bazı vazgeçilmez ürünlerimiz hakkında bilgi edinin.' : 
                    'Learn about some of our indispensable products that make us everyone\'s first choice in investment.'; ?>
            </p>
            
            <div class="promo-grid">
                <!-- App Card -->
                <div class="promo-card dark-card">
                    <div class="promo-content">
                        <div class="promo-header">
                            <h3><?php echo getCurrentLang() == 'tr' ? 'GlobalBorsa uygulaması' : 'GlobalBorsa app'; ?></h3>
                            <div class="app-ratings">
                                <div class="rating">
                                    <i class="fab fa-apple"></i>
                                    <span>★★★★★</span>
                                </div>
                                <div class="rating">
                                    <i class="fab fa-google-play"></i>
                                    <span>★★★★★</span>
                                </div>
                            </div>
                        </div>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Yüksek puanlı, ödüllü GlobalBorsa uygulamasıyla hizmetlerine eksiksiz erişin.' : 'Get complete access to services with the highly-rated, award-winning GlobalBorsa app.'; ?></p>
                        <a href="profile.php" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Hesabınıza Giriş Yapın' : 'Login to Your Account'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="phone-mockup">
                            <div class="phone-screen">
                                <div class="app-icon">📱</div>
                                <div class="app-name">GlobalBorsa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bonus Card -->
                <div class="promo-card blue-card">
                    <div class="promo-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? '%100 bonus' : '100% bonus'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Daha fazla yatırım, daha az risk ve daha çok getiri için fonlarınızı kullanın.' : 'Use your funds for more investment, less risk and more returns.'; ?></p>
                        <div class="bonus-amount">
                            <?php echo getCurrentLang() == 'tr' ? '1.000 TL\'ye varan %100 bonus alın' : 'Get up to 1,000 TL 100% bonus'; ?>
                        </div>
                        <a href="register.php" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Bonusunuzu alın' : 'Get your bonus'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="bonus-visual">
                            <div class="gift-box">🎁</div>
                            <div class="bonus-text">%100</div>
                        </div>
                    </div>
                </div>

                <!-- Competition Card -->
                <div class="promo-card green-card">
                    <div class="promo-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'GlobalBorsa yarışmaları' : 'GlobalBorsa competitions'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Yatırımlarınızla zirveye ilerleyin ve toplam 50.000 TL çekilebilir nakit ödülden payınızı alın.' : 'Advance to the top with your investments and get your share of 50,000 TL total withdrawable cash prizes.'; ?></p>
                        <a href="trading.php" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Hemen katılın' : 'Join now'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="trophy-visual">
                            <div class="trophy">🏆</div>
                            <div class="prize-text">50.000 TL</div>
                        </div>
                    </div>
                </div>

                <!-- Copy Trade Card -->
                <div class="promo-card light-card">
                    <div class="promo-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'GlobalBorsa copy trade' : 'GlobalBorsa copy trade'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Kazançlı yatırım stratejilerini kopyalayan 1.000\'den fazla yatırımcıya katılın ya da işlemlerinizi paylaşıp komisyon kazanın.' : 'Join over 1,000 investors copying profitable investment strategies or share your trades and earn commissions.'; ?></p>
                        <a href="wallet.php" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Cüzdanınızı Görüntüleyin' : 'View Your Wallet'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="copy-visual">
                            <div class="user-avatar">👤</div>
                            <div class="copy-arrows">📈</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BORSA TEMALI EDUCATION SECTION -->
    <section style="background: #f8f9fa; padding: 80px 0; z-index: 100; position: relative;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 2.5rem; font-weight: 700; color: #0d1b4c; margin-bottom: 20px;">
                    <?php echo getCurrentLang() == 'tr' ? 'Kripto Trading Akademisi' : 'Crypto Trading Academy'; ?>
                </h2>
                <p style="font-size: 1.1rem; color: #666; max-width: 700px; margin: 0 auto;">
                    <?php echo getCurrentLang() == 'tr' ? 'Profesyonel trader olmak için ihtiyacınız olan tüm bilgileri uzman analistlerimizden öğrenin' : 'Learn everything you need to become a professional trader from our expert analysts'; ?>
                </p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
                
                <!-- Bitcoin Trading Card -->
                <div style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1)'">
                    <div style="height: 200px; background: linear-gradient(135deg, #f7931a, #ff8c00); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"50\" cy=\"50\" r=\"40\" fill=\"none\" stroke=\"white\" stroke-width=\"2\" opacity=\"0.1\"/><path d=\"M30 40h40M30 50h40M30 60h40\" stroke=\"white\" stroke-width=\"1\" opacity=\"0.1\"/></svg>') repeat; opacity: 0.1;"></div>
                        ₿
                    </div>
                    <div style="padding: 30px;">
                        <h3 style="font-size: 1.5rem; font-weight: 600; color: #0d1b4c; margin-bottom: 15px;">
                            <?php echo getCurrentLang() == 'tr' ? 'Bitcoin Trading Rehberi' : 'Bitcoin Trading Guide'; ?>
                        </h3>
                        <p style="color: #666; line-height: 1.6; margin-bottom: 25px;">
                            <?php echo getCurrentLang() == 'tr' ? 'Bitcoin\'in temellerinden profesyonel trading stratejilerine kadar her şeyi öğrenin. Volatilite yönetimi ve risk kontrolü.' : 'Learn everything from Bitcoin basics to professional trading strategies. Volatility management and risk control.'; ?>
                        </p>
                        <button style="background: linear-gradient(135deg, #f7931a, #ff8c00); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; width: 100%;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(247, 147, 26, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <?php echo getCurrentLang() == 'tr' ? 'Ücretsiz Eğitime Başla' : 'Start Free Training'; ?>
                        </button>
                    </div>
                </div>

                <!-- Altcoin Strategy Card -->
                <div style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1)'">
                    <div style="height: 200px; background: linear-gradient(135deg, #627eea, #4f46e5); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 20px; left: 20px; width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 50%;"></div>
                        <div style="position: absolute; top: 40px; right: 30px; width: 20px; height: 20px; background: rgba(255,255,255,0.15); border-radius: 50%;"></div>
                        <div style="position: absolute; bottom: 30px; left: 40px; width: 25px; height: 25px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                        ⟐
                    </div>
                    <div style="padding: 30px;">
                        <h3 style="font-size: 1.5rem; font-weight: 600; color: #0d1b4c; margin-bottom: 15px;">
                            <?php echo getCurrentLang() == 'tr' ? 'Altcoin Seçim Stratejisi' : 'Altcoin Selection Strategy'; ?>
                        </h3>
                        <p style="color: #666; line-height: 1.6; margin-bottom: 25px;">
                            <?php echo getCurrentLang() == 'tr' ? 'Binlerce altcoin arasından kazandıracak projeleri nasıl seçeceğinizi öğrenin. Fundamentals analiz teknikleri.' : 'Learn how to select profitable projects among thousands of altcoins. Fundamental analysis techniques.'; ?>
                        </p>
                        <button style="background: linear-gradient(135deg, #627eea, #4f46e5); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; width: 100%;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(79, 70, 229, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <?php echo getCurrentLang() == 'tr' ? 'Stratejileri Keşfet' : 'Discover Strategies'; ?>
                        </button>
                    </div>
                </div>

                <!-- Technical Analysis Card -->
                <div style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.1)'">
                    <div style="height: 200px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 30px; left: 30px; right: 30px; height: 2px; background: rgba(255,255,255,0.3);"></div>
                        <div style="position: absolute; top: 60px; left: 30px; right: 30px; height: 2px; background: rgba(255,255,255,0.2);"></div>
                        <div style="position: absolute; top: 90px; left: 30px; right: 30px; height: 2px; background: rgba(255,255,255,0.1);"></div>
                        <div style="position: absolute; bottom: 30px; left: 30px; width: 2px; height: 100px; background: rgba(255,255,255,0.2);"></div>
                        <div style="position: absolute; bottom: 30px; left: 60px; width: 2px; height: 80px; background: rgba(255,255,255,0.2);"></div>
                        <div style="position: absolute; bottom: 30px; left: 90px; width: 2px; height: 60px; background: rgba(255,255,255,0.2);"></div>
                        📈
                    </div>
                    <div style="padding: 30px;">
                        <h3 style="font-size: 1.5rem; font-weight: 600; color: #0d1b4c; margin-bottom: 15px;">
                            <?php echo getCurrentLang() == 'tr' ? 'İleri Teknik Analiz' : 'Advanced Technical Analysis'; ?>
                        </h3>
                        <p style="color: #666; line-height: 1.6; margin-bottom: 25px;">
                            <?php echo getCurrentLang() == 'tr' ? 'Candlestick pattern\'ları, indikatörler ve support/resistance seviyeleri ile profesyonel analiz yapın.' : 'Perform professional analysis with candlestick patterns, indicators and support/resistance levels.'; ?>
                        </p>
                        <button style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; width: 100%;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <?php echo getCurrentLang() == 'tr' ? 'Analiz Teknikleri Öğren' : 'Learn Analysis Techniques'; ?>
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Contact/CTA Section -->
    <section class="contact-cta" id="iletisim">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2><?php echo getCurrentLang() == 'tr' ? 'Sizi Arayalım' : 'Let Us Call You'; ?></h2>
                    <p><?php echo getCurrentLang() == 'tr' ? 'Yatırım danışmanlarımız size en uygun hesap türünü ve yatırım stratejisini belirlemek için iletişime geçsin.' : 'Let our investment advisors contact you to determine the most suitable account type and investment strategy for you.'; ?></p>
                    <div class="contact-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo getCurrentLang() == 'tr' ? 'Ücretsiz danışmanlık' : 'Free consultation'; ?></span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo getCurrentLang() == 'tr' ? 'Kişiselleştirilmiş strateji' : 'Personalized strategy'; ?></span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo getCurrentLang() == 'tr' ? 'Risk yönetimi' : 'Risk management'; ?></span>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <form id="callbackForm">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="<?php echo getCurrentLang() == 'tr' ? 'Adınız Soyadınız' : 'Your Name Surname'; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" id="phone" name="phone" placeholder="<?php echo getCurrentLang() == 'tr' ? 'Telefon Numaranız' : 'Your Phone Number'; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="<?php echo getCurrentLang() == 'tr' ? 'E-posta Adresiniz' : 'Your Email Address'; ?>" required>
                        </div>
                        <div class="form-group">
                            <select id="experience" name="experience" required>
                                <option value=""><?php echo getCurrentLang() == 'tr' ? 'Yatırım Deneyiminiz' : 'Your Investment Experience'; ?></option>
                                <option value="beginner"><?php echo getCurrentLang() == 'tr' ? 'Yeni başlıyorum' : 'Just starting'; ?></option>
                                <option value="intermediate"><?php echo getCurrentLang() == 'tr' ? 'Orta seviye' : 'Intermediate'; ?></option>
                                <option value="advanced"><?php echo getCurrentLang() == 'tr' ? 'İleri seviye' : 'Advanced'; ?></option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn"><?php echo getCurrentLang() == 'tr' ? 'Beni Arayın' : 'Call Me'; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Include existing footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Live Support Button -->
    <div class="live-support" id="liveSupport">
        <button class="support-btn">
            <i class="fas fa-comments"></i>
            <span><?php echo getCurrentLang() == 'tr' ? 'Canlı Destek' : 'Live Support'; ?></span>
        </button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="assets/js/landing-new.js"></script>
    
    <!-- Inline JavaScript for Slider -->
    <script>
        // User menu toggle function
        function toggleUserMenu() {
            const userMenu = document.getElementById('userMenu');
            if (userMenu.style.display === 'none' || userMenu.style.display === '') {
                userMenu.style.display = 'block';
            } else {
                userMenu.style.display = 'none';
            }
        }
        
        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('button[onclick="toggleUserMenu()"]');
            if (!userButton && userMenu) {
                userMenu.style.display = 'none';
            }
        });
        
        // Manual navigation click handlers - Force fix
        document.addEventListener('DOMContentLoaded', function() {
            // Specifically handle navigation menu links
            const navMenuLinks = document.querySelectorAll('.navbar-nav .nav-link');
            console.log('Found nav menu links:', navMenuLinks.length);
            
            navMenuLinks.forEach(function(link, index) {
                console.log('Setting up click handler for nav link', index, link.textContent);
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const href = this.getAttribute('href');
                    console.log('Navigation link clicked:', href);
                    if (href && href !== '#') {
                        window.location.href = href;
                    }
                });
            });
            
            // Handle navbar brand
            const navbarBrand = document.querySelector('.navbar-brand');
            if (navbarBrand) {
                navbarBrand.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const href = this.getAttribute('href');
                    console.log('Brand clicked:', href);
                    if (href && href !== '#') {
                        window.location.href = href;
                    }
                });
            }
            
        // Initialize slider
        initSlider();
        });
        
        // Hero Slider function
        function initSlider() {
            console.log('DOM loaded, initializing slider...');
            
            const slides = document.querySelectorAll('.slide');
            const progressBar = document.getElementById('sliderProgress');
            let currentSlide = 0;
            let slideInterval;
            
            console.log('Found slides:', slides.length);
            
            if (slides.length === 0) {
                console.log('No slides found!');
                return;
            }
            
            // Function to show specific slide
            function showSlide(index) {
                console.log('Showing slide:', index);
                
                // Remove active class from all slides
                slides.forEach((slide, i) => {
                    slide.classList.remove('active');
                    console.log('Removed active from slide', i);
                });
                
                // Add active class to current slide
                slides[index].classList.add('active');
                console.log('Added active to slide', index);
                
                currentSlide = index;
                
                // Update progress bar
                if (progressBar) {
                    progressBar.style.width = '0%';
                    setTimeout(() => {
                        progressBar.style.width = '100%';
                    }, 100);
                }
            }
            
            // Auto-slide functionality
            function startAutoSlide() {
                slideInterval = setInterval(() => {
                    console.log('Auto advancing from slide', currentSlide);
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }, 5000); // 5 seconds
            }
            
            // Initialize progress bar
            if (progressBar) {
                progressBar.style.width = '0%';
                progressBar.style.transition = 'width 5s linear';
                setTimeout(() => {
                    progressBar.style.width = '100%';
                }, 100);
            }
            
            // Start auto-slide
            startAutoSlide();
            console.log('Auto-slide started');
            
            // Manual controls for testing
            window.nextSlide = function() {
                clearInterval(slideInterval);
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
                setTimeout(startAutoSlide, 1000);
            };
            
            window.prevSlide = function() {
                clearInterval(slideInterval);
                currentSlide = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
                showSlide(currentSlide);
                setTimeout(startAutoSlide, 1000);
            };
            
            // Pause on hover
            const heroSlider = document.querySelector('.hero-slider');
            if (heroSlider) {
                heroSlider.addEventListener('mouseenter', () => {
                    clearInterval(slideInterval);
                    console.log('Paused on hover');
                });
                
                heroSlider.addEventListener('mouseleave', () => {
                    startAutoSlide();
                    console.log('Resumed on leave');
                });
            }
            
            // Keyboard controls
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    window.prevSlide();
                } else if (e.key === 'ArrowRight') {
                    window.nextSlide();
                }
            });
            
            console.log('Slider initialization complete');
        });
        
        // Test function - you can call this in browser console
        window.testSlider = function() {
            console.log('Testing slider...');
            const slides = document.querySelectorAll('.slide');
            console.log('Slides found:', slides.length);
            slides.forEach((slide, i) => {
                console.log('Slide', i, 'classes:', slide.className);
            });
        };
    </script>
</body>
</html>
