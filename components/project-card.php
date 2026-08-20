<?php
$url = $project['project_url'] ?? '#';
$title = $project['title'] ?? 'Project Title';
$projectImage = !empty($project['image_path']) ? $project['image_path'] : '';

$isGithub = (strpos($url, 'github.com') !== false);
$isInstagram = (strpos($url, 'instagram.com') !== false);
$isCelebWiki = (strpos($url, 'celebwikicorner.com') !== false);

if ($isGithub) {
    $badgeIcon = '<i class="fa-brands fa-github"></i>';
    $badgeText = 'GitHub Repo';
    $actionText = 'View Source Code <i class="fa-brands fa-github"></i>';
} elseif ($isInstagram) {
    $badgeIcon = '<i class="fa-brands fa-instagram"></i>';
    $badgeText = 'Brand Marketing';
    $actionText = 'Explore Campaign <i class="fa-brands fa-instagram"></i>';
} elseif ($isCelebWiki) {
    $badgeIcon = '<i class="fa-solid fa-newspaper"></i>';
    $badgeText = 'SEO Network';
    $actionText = 'Visit Website <i class="fa-solid fa-arrow-up-right-from-square"></i>';
} else {
    $badgeIcon = '<i class="fa-solid fa-globe"></i>';
    $badgeText = 'Live Deployment';
    $actionText = 'Visit Live Website <i class="fa-solid fa-arrow-up-right-from-square"></i>';
}
?>

<article class="project-card interactive-card">
    <?php if (!empty($projectImage)): ?>
        <div class="project-card-image-wrap">
            <img src="<?= htmlspecialchars($projectImage) ?>" alt="<?= htmlspecialchars($title) ?>" class="project-card-img" loading="lazy">
            <span class="project-type-badge-floating">
                <?= $badgeIcon ?> <?= $badgeText ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="card-content">
        <div class="project-card-header">
            <span class="project-date-badge"><i class="fa-regular fa-calendar"></i> Feb 2025</span>
        </div>

        <h3 class="project-title"><?= htmlspecialchars($title) ?></h3>
        <p class="project-desc"><?= htmlspecialchars($project['description'] ?? '') ?></p>
        
        <?php if (!empty($project['tech_stack'])): ?>
            <div class="tech-stack">
                <?php foreach (explode(',', $project['tech_stack']) as $tech): ?>
                    <span class="tech-badge"><i class="fa-solid fa-check"></i> <?= htmlspecialchars(trim($tech)) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($isCelebWiki): ?>
            <div class="project-social-channels">
                <span class="channels-label">Promoted on:</span>
                <div class="channel-icons">
                    <a href="https://www.instagram.com/celebwikicorner_/" target="_blank" rel="noopener noreferrer" title="Instagram" class="channel-icon-btn"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100071957656275" target="_blank" rel="noopener noreferrer" title="Facebook" class="channel-icon-btn"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://www.youtube.com/@CelebwikiCorner" target="_blank" rel="noopener noreferrer" title="YouTube" class="channel-icon-btn"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="project-card-footer">
        <a href="<?= htmlspecialchars($url) ?>" class="card-link" target="_blank" rel="noopener noreferrer">
            <?= $actionText ?>
        </a>
    </div>
</article>