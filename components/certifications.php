<section id="certifications" class="section certifications-section reveal">
    <div class="container">
        <h2 class="section-title"><i class="fa-solid fa-award"></i> Licenses & Certifications</h2>
        <div class="certifications-grid">
            <?php if (!empty($certificates)): ?>
                <?php foreach ($certificates as $cert): 
                    $titleLower = strtolower($cert['title'] ?? '');
                    $iconClass = 'fa-solid fa-award';
                    if (strpos($titleLower, 'mern') !== false || strpos($titleLower, 'react') !== false) {
                        $iconClass = 'fa-brands fa-react';
                    } elseif (strpos($titleLower, 'seo') !== false || strpos($titleLower, 'semrush') !== false) {
                        $iconClass = 'fa-solid fa-chart-pie';
                    } elseif (strpos($titleLower, 'ui/ux') !== false || strpos($titleLower, 'design') !== false) {
                        $iconClass = 'fa-solid fa-pen-ruler';
                    } elseif (strpos($titleLower, 'web') !== false || strpos($titleLower, 'front') !== false) {
                        $iconClass = 'fa-solid fa-laptop-code';
                    }
                ?>
                    <div class="cert-card interactive-card reveal">
                        <div class="cert-header">
                            <div class="cert-icon-wrapper">
                                <i class="<?= $iconClass ?>"></i>
                            </div>
                            <div class="cert-meta">
                                <h3 class="cert-title"><?= htmlspecialchars($cert['title'] ?? 'Certification Title') ?></h3>
                                <h4 class="cert-issuer"><?= htmlspecialchars($cert['issuer'] ?? '') ?></h4>
                                <span class="cert-date"><?= htmlspecialchars($cert['issue_date'] ?? '') ?></span>
                            </div>
                        </div>
                        <?php if (!empty($cert['skills_covered'])): ?>
                            <div class="cert-skills">
                                <?php foreach (explode(',', $cert['skills_covered']) as $skill): ?>
                                    <span class="cert-badge"><?= htmlspecialchars(trim($skill)) ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?= htmlspecialchars($cert['credential_url'] ?? '#contact') ?>" target="<?= (!empty($cert['credential_url']) && $cert['credential_url'] !== '#contact') ? '_blank' : '_self' ?>" rel="noopener noreferrer" class="cert-link">
                            Show Credential <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-msg">No certifications added yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>