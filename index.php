<?php
$pageTitle = "Bala | SEO Strategist, Frontend & Digital Marketer";
require_once 'config/db.php';

// Initialize defaults
$profile = [];
$projects = [];
$experiences = [];
$educations = [];
$certificates = [];

// 1. Fetch Profile
try {
    $stmt = $pdo->query("SELECT * FROM profile WHERE id = 1 LIMIT 1");
    $profile = $stmt->fetch() ?: [];
} catch (PDOException $e) {
    $profile = [];
}

// 2. Fetch Projects (With Auto-Fallback)
try {
    // Tries fetching with visibility filter first
    $stmt = $pdo->query("SELECT * FROM projects WHERE is_visible = 1 ORDER BY display_order ASC, id DESC");
    $projects = $stmt->fetchAll() ?: [];
} catch (PDOException $e) {
    try {
        // Fallback: standard query if is_visible column is not in your table
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
        $projects = $stmt->fetchAll() ?: [];
    } catch (PDOException $e2) {
        $projects = [];
    }
}

// 3. Fetch Experience Roles
try {
    $stmt = $pdo->query("SELECT * FROM experience ORDER BY id DESC");
    $experiences = $stmt->fetchAll() ?: [];
} catch (PDOException $e) {
    $experiences = [];
}

// 4. Fetch Education Entries
try {
    $stmt = $pdo->query("SELECT * FROM education ORDER BY id DESC");
    $educations = $stmt->fetchAll() ?: [];
} catch (PDOException $e) {
    $educations = [];
}

// 5. Fetch Certifications
try {
    $stmt = $pdo->query("SELECT * FROM certificates ORDER BY id DESC");
    $certificates = $stmt->fetchAll() ?: [];
} catch (PDOException $e) {
    $certificates = [];
}

include 'includes/header.php';
?>

<main>
    <?php include 'components/hero.php'; ?>
    <?php include 'components/about.php'; ?>
    <?php include 'components/skills.php'; ?>
    <?php include 'components/experience.php'; ?>
    <?php include 'components/education.php'; ?>
    <?php include 'components/certifications.php'; ?>
    
    <!-- Projects Section -->
    <section id="projects" class="section projects-section reveal">
        <div class="container">
            <h2 class="section-title"><i class="fa-solid fa-rocket"></i> Featured Projects & Case Studies</h2>
            <div class="grid-projects">
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <?php include 'components/project-card.php'; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-msg">No projects available in the database.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'components/contact.php'; ?>
</main>

<?php include 'includes/footer.php'; ?>