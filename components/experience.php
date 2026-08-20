<section id="experience" class="section experience-section reveal">
    <div class="container">
        <h2 class="section-title"><i class="fa-solid fa-briefcase"></i> Professional Experience</h2>
        <div class="timeline">
            <?php if (!empty($experiences)): ?>
                <?php foreach ($experiences as $index => $exp): 
                    $roleLower = strtolower($exp['role_title'] ?? '');
                    $iconClass = 'fa-solid fa-briefcase';
                    if (strpos($roleLower, 'ai') !== false || strpos($roleLower, 'trainer') !== false) {
                        $iconClass = 'fa-solid fa-briefcase';
                    } elseif (strpos($roleLower, 'content') !== false || strpos($roleLower, 'social') !== false) {
                        $iconClass = 'fa-solid fa-bullhorn';
                    } elseif (strpos($roleLower, 'writer') !== false || strpos($roleLower, 'author') !== false) {
                        $iconClass = 'fa-solid fa-pen-fancy';
                    }
                    $animationClass = ($index % 2 === 0) ? 'reveal-left' : 'reveal-right';
                ?>
                    <div class="timeline-item <?= $animationClass ?>">
                        <div class="timeline-dot"><i class="<?= $iconClass ?>"></i></div>
                        <div class="timeline-card interactive-card">
                            <div class="timeline-header">
                                <div>
                                    <h3 class="role-title"><?= htmlspecialchars($exp['role_title'] ?? 'Role Title') ?></h3>
                                    <h4 class="company-name"><?= htmlspecialchars($exp['company'] ?? '') ?><?php if (!empty($exp['employment_type'])): ?> · <span><?= htmlspecialchars($exp['employment_type']) ?></span><?php endif; ?></h4>
                                </div>
                                <?php if (!empty($exp['timeline'])): ?>
                                    <span class="timeline-badge"><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($exp['timeline']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($exp['location'])): ?>
                                <p class="location-text"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($exp['location']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($exp['skills_used'])): ?>
                                <div class="timeline-tags">
                                    <?php foreach (explode(',', $exp['skills_used']) as $skill): ?>
                                        <span><?= htmlspecialchars(trim($skill)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">No experience recorded yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>