<?php
$skillCategories = [
    
    'SEO & Search Strategy' => [
        'icon' => 'fa-solid fa-magnifying-glass-chart',
        'overall_rating' => 5.0,
        'overall_percent' => 98,
        'tags' => ['Keyword Discovery & Silos', 'Search Intent Mapping', 'On-Page SEO', 'Technical Audits', 'Google Search Console', 'GA4 & Semrush']
    ],
    'Content & Copywriting' => [
        'icon' => 'fa-solid fa-pen-nib',
        'overall_rating' => 4.9,
        'overall_percent' => 95,
        'tags' => ['Technical Writing', 'AI Data Evaluation & QA', 'Long-Form Content', 'Conversion Copywriting', 'Trending Viral Scripts']
    ],
    'Marketing & Creative Tools' => [
        'icon' => 'fa-solid fa-sliders',
        'overall_rating' => 4.7,
        'overall_percent' => 88,
        'tags' => ['Social Media Management', 'Canva Pro & Brand Assets', 'Meta Ads Manager', 'WordPress CMS', 'Campaign Optimization']
    ],
    'Frontend & Web Engineering' => [
        'icon' => 'fa-solid fa-code',
        'overall_rating' => 4.8,
        'overall_percent' => 92,
        'tags' => ['HTML5 / Modern CSS3', 'JavaScript (ES6+)', 'React.js', 'Responsive UI & Mobile-First', 'Bootstrap & Tailwind CSS', 'UI/UX Implementation']
    ],
];

// Helper to render golden stars
function renderTileStars($rating) {
    $full = floor($rating);
    $half = ($rating - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    $output = '';

    for ($i = 0; $i < $full; $i++) {
        $output .= '<i class="fa-solid fa-star star-filled"></i>';
    }
    if ($half) {
        $output .= '<i class="fa-solid fa-star-half-stroke star-filled"></i>';
    }
    for ($i = 0; $i < $empty; $i++) {
        $output .= '<i class="fa-regular fa-star star-empty"></i>';
    }
    return $output;
}
?>

<section id="skills" class="section skills-section reveal">
    <div class="container">
        <h2 class="section-title"><i class="fa-solid fa-bolt"></i> Skills & Proficiency</h2>
        
        <div class="skills-rated-grid">
            <?php foreach ($skillCategories as $category => $data): ?>
                <div class="skill-category-card">
                    <!-- Tile Header -->
                    <div class="skill-category-header">
                        <div class="cat-icon-badge">
                            <i class="<?= $data['icon'] ?>"></i>
                        </div>
                        <div>
                            <h3><?= htmlspecialchars($category) ?></h3>
                            <!-- Overall Star Rating for the Tile -->
                            <div class="overall-rating-wrap">
                                <div class="skill-stars">
                                    <?= renderTileStars($data['overall_rating']) ?>
                                </div>
                                <span class="rating-badge"><?= number_format($data['overall_rating'], 1) ?> / 5.0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Overall Proficiency Bar -->
                    <div class="overall-meter-wrap">
                        <div class="overall-meter-label">
                            <span>Proficiency</span>
                            <strong><?= $data['overall_percent'] ?>%</strong>
                        </div>
                        <div class="skill-bar-track">
                            <div class="skill-bar-progress" style="width: <?= $data['overall_percent'] ?>%;"></div>
                        </div>
                    </div>

                    <!-- Skills Pill Cloud -->
                    <ul class="skill-tags">
                        <?php foreach ($data['tags'] as $skill): ?>
                            <li><i class="fa-solid fa-check"></i> <?= htmlspecialchars($skill) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>