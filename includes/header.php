<?php
if (!isset($pageTitle)) {
    $pageTitle = "Bala | SEO Strategist, Frontend & Digital Marketer";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="main.css?v=<?= time(); ?>">
    <script>
        const initialTheme = localStorage.getItem('portfolio-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', initialTheme);
    </script>
</head>
<body>
    <!-- Top Scroll Progress Bar -->
    <div id="scrollProgressBar" class="scroll-progress-bar"></div>

    <header class="site-header">
        <div class="container nav-container">
            <a href="index.php" class="logo">
                <i class="fa-solid fa-chart-line logo-icon"></i> Bala<span>Portfolio</span>
            </a>

           
            

            <!-- Navigation Links -->
            <nav id="navLinks" class="nav-links">
                <a href="#about"><i class="fa-regular fa-user"></i> About</a>
                <a href="#skills"><i class="fa-solid fa-bolt"></i> Skills</a>
                <a href="#experience"><i class="fa-solid fa-briefcase"></i> Experience</a>
                <a href="#education"><i class="fa-solid fa-graduation-cap"></i> Education</a>
                <a href="#certifications"><i class="fa-solid fa-award"></i> Certs</a>
                <a href="#projects"><i class="fa-solid fa-rocket"></i> Projects</a>
                <a href="#contact" class="btn-nav"><i class="fa-solid fa-paper-plane"></i> Hire Me</a>
            </nav>
             <!-- Theme Toggle -->
                <button id="themeToggle" class="theme-toggle-btn" aria-label="Toggle theme">
                    <span class="toggle-icon">☀️</span>
                </button>
            <!-- Right Controls for Mobile & Desktop -->
            <div class="nav-controls">

                <!-- Mobile Hamburger Button -->
                <button id="mobileMenuBtn" class="mobile-menu-btn" aria-label="Toggle Navigation Menu">
                    <i class="fa-solid fa-bars menu-icon"></i>
                </button>
            </div>
        </div>
    </header>

    