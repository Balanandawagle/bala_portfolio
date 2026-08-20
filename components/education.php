<section id="education" class="section education-section reveal">
    <div class="container">
        <h2 class="section-title"><i class="fa-solid fa-graduation-cap"></i> Education</h2>
        <div class="education-grid">
            <?php if (!empty($educations)): ?>
                <?php foreach ($educations as $index => $edu): 
                    $degreeLower = strtolower($edu['degree'] ?? '');
                    $iconClass = (strpos($degreeLower, 'school') !== false || strpos($degreeLower, '+2') !== false) 
                        ? 'fa-solid fa-school' 
                        : 'fa-solid fa-user-graduate';
                    $animationClass = ($index % 2 === 0) ? 'reveal-left' : 'reveal-right';
                ?>
                    <div class="education-card interactive-card <?= $animationClass ?>">
                        <div class="edu-icon-badge">
                            <i class="<?= $iconClass ?>"></i>
                        </div>
                        <div class="edu-details">
                            <div class="edu-top">
                                <h3 class="edu-degree"><?= htmlspecialchars($edu['degree'] ?? 'Degree Title') ?></h3>
                                <?php if (!empty($edu['gpa'])): ?>
                                    <div class="edu-gpa-badge">
                                        <i class="fa-solid fa-award"></i>
                                        <span>GPA <strong><?= htmlspecialchars($edu['gpa']) ?></strong></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4 class="edu-institution"><?= htmlspecialchars($edu['institution'] ?? '') ?></h4>
                            <p class="edu-timeline"><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($edu['timeline'] ?? '') ?></p>
                            <?php if (!empty($edu['skills_covered'])): ?>
                                <div class="edu-skills">
                                    <?php foreach (explode(',', $edu['skills_covered']) as $skill): ?>
                                        <span><?= htmlspecialchars(trim($skill)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">No education entries added yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>