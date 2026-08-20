<?php
// Extract dynamic data from the database profile query
$yearsExp        = !empty($profile['years_exp']) ? (int)$profile['years_exp'] : 2;
$articlesWritten = !empty($profile['articles_written']) ? (int)$profile['articles_written'] : 1000;
$aboutText       = !empty($profile['about_text']) ? $profile['about_text'] : 'From conducting deep keyword discovery and on-page optimization to technical indexing and social ad campaigns, I merge analytical precision with persuasive storytelling to deliver compound organic growth.';
$bioText         = !empty($profile['bio']) ? $profile['bio'] : 'Data-backed SEO specialist, frontend developer, and content strategist driving real search traffic, conversion growth, and modern web applications.';
$statusText      = !empty($profile['status_text']) ? $profile['status_text'] : 'Available for High-Impact Roles';
$resumeUrl       = !empty($profile['resume_url']) && $profile['resume_url'] !== '#' ? $profile['resume_url'] : '';
?>

<section id="about" class="section about-section reveal">
    <div class="container">
        <h2 class="section-title"><i class="fa-regular fa-user"></i> About Me</h2>
        
        <div class="about-grid">
            <!-- Left Column: Metrics Above Profile Image -->
            <div class="about-visual-column reveal-left">
                
                <!-- Stat Cards Above Profile Image -->
                <div class="about-highlights-top">
                    <div class="highlight-item interactive-card">
                        <i class="fa-solid fa-briefcase highlight-icon"></i>
                        <span class="highlight-num counter" data-target="<?= $yearsExp ?>" data-suffix="+">0</span>
                        <span class="highlight-label">Years Experience</span>
                    </div>
                    <div class="highlight-item interactive-card">
                        <i class="fa-solid fa-newspaper highlight-icon"></i>
                        <span class="highlight-num counter" data-target="<?= $articlesWritten ?>" data-suffix="+">0</span>
                        <span class="highlight-label">Articles Authored</span>
                    </div>
                </div>

                <!-- Profile Image Card -->
                <div class="about-image-wrapper">
                    <div class="about-image-card">
                        <img 
                            src="assets/profile.webp" 
                            alt="Balananda Wagle" 
                            class="about-profile-img" 
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&auto=format&fit=crop&q=80';"
                        >
                        <div class="profile-status-badge">
                            <span class="status-dot"></span>
                            <span><?= htmlspecialchars($statusText) ?></span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Descriptions & Clickable CV Button -->
            <div class="about-content reveal-right">
                <div class="about-text">
                    <p class="lead-bio">
                        <?= htmlspecialchars($bioText) ?>
                    </p>
                    <p>
                        <?= htmlspecialchars($aboutText) ?>
                    </p>

                    <!-- Clickable CV / Resume Button from Database -->
                    <?php if (!empty($resumeUrl)): ?>
                        <div class="about-cv-wrap" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
                            <a href="<?= htmlspecialchars($resumeUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn-primary">
                                <i class="fa-solid fa-file-arrow-down"></i> View / Download CV
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Strategic Capabilities -->
                <div class="about-detail-cards">
                    <div class="about-detail-item interactive-card">
                        <div class="detail-icon-wrap">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div class="detail-text-wrap">
                            <h4>Search Engine Optimization (SEO)</h4>
                            <p>Deep keyword intent research, content silos, on-page optimization, and Google Search Console indexation to secure top organic ranks.</p>
                        </div>
                    </div>

                    <div class="about-detail-item interactive-card">
                        <div class="detail-icon-wrap">
                            <i class="fa-solid fa-code"></i>
                        </div>
                        <div class="detail-text-wrap">
                            <h4>Modern Frontend Engineering</h4>
                            <p>Building high-performance, responsive web experiences with React.js, Next.js, HTML5, CSS3, and JavaScript.</p>
                        </div>
                    </div>

                    <div class="about-detail-item interactive-card">
                        <div class="detail-icon-wrap">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div class="detail-text-wrap">
                            <h4>Multi-Channel Brand Promotion</h4>
                            <p>Designing promotional graphics, writing video scripts, and managing targeted social distributions to scale conversions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>