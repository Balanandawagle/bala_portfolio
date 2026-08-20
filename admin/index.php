<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
require_once __DIR__ . '/../config/db.php';

// Safe Count Fetching
function getCount($pdo, $table) {
    try {
        return (int)$pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

$totalProjects = getCount($pdo, 'projects');
$totalExperience = getCount($pdo, 'experience');
$totalEducation = getCount($pdo, 'education');
$totalCerts = getCount($pdo, 'certificates');
$totalMessages = getCount($pdo, 'contact_messages');

$profile = [];
try {
    $stmt = $pdo->query("SELECT * FROM profile WHERE id=1 LIMIT 1");
    $profile = $stmt->fetch() ?: [];
} catch (PDOException $e) {}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Bala CMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../main.css?v=<?= time(); ?>">
    <style>
        .admin-layout { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
        .admin-sidebar { background: var(--surface-solid); border-right: 1px solid var(--border-subtle); padding: 2rem 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; position: sticky; top: 0; height: 100vh; }
        .admin-content { padding: 2.5rem; overflow-y: auto; }
        .sidebar-btn { display: flex; align-items: center; gap: 0.75rem; padding: 0.8rem 1rem; border-radius: var(--radius-md); color: var(--text-muted); text-decoration: none; font-weight: 700; font-size: 0.92rem; transition: var(--transition-fast); border: none; background: transparent; width: 100%; text-align: left; cursor: pointer; }
        .sidebar-btn.active, .sidebar-btn:hover { background: var(--badge-bg); color: var(--text-hero); }
        .admin-grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem; }
        .stat-card { background: var(--grad-card); border: 1px solid var(--border-subtle); padding: 1.5rem; border-radius: var(--radius-lg); text-align: center; box-shadow: var(--shadow-soft); }
        .stat-card strong { font-size: 2.2rem; font-weight: 800; background: var(--grad-fire); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .admin-table { width: 100%; border-collapse: collapse; background: var(--surface-glass); border-radius: var(--radius-lg); overflow: hidden; margin-top: 1.25rem; box-shadow: var(--shadow-soft); }
        .admin-table th, .admin-table td { padding: 1rem 1.25rem; text-align: left; border-bottom: 1px solid var(--border-subtle); font-size: 0.9rem; }
        .admin-table th { background: var(--surface-solid); font-weight: 800; color: var(--text-hero); }
        .btn-action-sm { padding: 0.4rem 0.8rem; border-radius: var(--radius-pill); font-size: 0.82rem; font-weight: 700; cursor: pointer; border: 1px solid var(--border-subtle); background: var(--surface-solid); color: var(--text-main); transition: 0.2s; margin-right: 0.35rem; }
        .btn-action-sm:hover { background: var(--accent-pink); color: #fff; border-color: transparent; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; padding: 1.5rem; }
        .modal.active { display: flex; }
        .modal-box { background: var(--surface-solid); border: 1px solid var(--border-highlight); border-radius: var(--radius-xl); padding: 2.5rem; width: 100%; max-width: 580px; box-shadow: var(--shadow-glow); max-height: 90vh; overflow-y: auto; }
        .tab-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        @media(max-width: 900px) { .admin-layout { grid-template-columns: 1fr; } .admin-sidebar { height: auto; position: static; } }
    </style>
</head>
<body>
<div class="admin-layout">
    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
        <div style="margin-bottom: 1.5rem; padding-left: 0.5rem;">
            <a href="../index.php" target="_blank" class="logo"><i class="fa-solid fa-chart-line"></i> Bala<span>CMS</span></a>
        </div>
        <button class="sidebar-btn active" onclick="showTab('dashboard', this)"><i class="fa-solid fa-gauge"></i> Dashboard</button>
        <button class="sidebar-btn" onclick="showTab('projects', this)"><i class="fa-solid fa-rocket"></i> Projects (<span id="statProjCount"><?= $totalProjects ?></span>)</button>
        <button class="sidebar-btn" onclick="showTab('experience', this)"><i class="fa-solid fa-briefcase"></i> Experience (<span id="statExpCount"><?= $totalExperience ?></span>)</button>
        <button class="sidebar-btn" onclick="showTab('education', this)"><i class="fa-solid fa-graduation-cap"></i> Education (<span id="statEduCount"><?= $totalEducation ?></span>)</button>
        <button class="sidebar-btn" onclick="showTab('certificates', this)"><i class="fa-solid fa-award"></i> Certificates (<span id="statCertCount"><?= $totalCerts ?></span>)</button>
        <button class="sidebar-btn" onclick="showTab('profile', this)"><i class="fa-solid fa-user-pen"></i> Profile & Bio</button>
        <button class="sidebar-btn" onclick="showTab('messages', this)"><i class="fa-solid fa-envelope"></i> Messages (<?= $totalMessages ?>)</button>
        <div style="margin-top: auto;">
            <a href="logout.php" class="sidebar-btn" style="color: var(--accent-pink);"><i class="fa-solid fa-power-off"></i> Logout</a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-content">
        <!-- 1. Dashboard Tab -->
        <section id="tab-dashboard" class="tab-pane">
            <h2 class="section-title"><i class="fa-solid fa-gauge"></i> CMS Overview</h2>
            <div class="admin-grid-stats">
                <div class="stat-card"><strong><?= $totalProjects ?></strong><p>Projects</p></div>
                <div class="stat-card"><strong><?= $totalExperience ?></strong><p>Experiences</p></div>
                <div class="stat-card"><strong><?= $totalEducation ?></strong><p>Education Entries</p></div>
                <div class="stat-card"><strong><?= $totalCerts ?></strong><p>Certifications</p></div>
                <div class="stat-card"><strong><?= $totalMessages ?></strong><p>Messages / Leads</p></div>
            </div>
            <a href="../index.php" target="_blank" class="btn-primary"><i class="fa-solid fa-arrow-up-right-from-square"></i> Open Live Website</a>
        </section>

        <!-- 2. Projects Tab -->
        <section id="tab-projects" class="tab-pane" style="display:none;">
            <div class="tab-header">
                <h2 class="section-title" style="margin-bottom:0;"><i class="fa-solid fa-rocket"></i> Projects</h2>
                <button class="btn-primary" onclick="openProjectModal()"><i class="fa-solid fa-plus"></i> Add Project</button>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Thumbnail</th>
                        <th>Title</th>
                        <th>Tech Stack</th>
                        <th>Live URL</th>
                        <th style="width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="projectsTableBody"><tr><td colspan="5">Loading projects...</td></tr></tbody>
            </table>
        </section>

        <!-- 3. Experience Tab -->
        <section id="tab-experience" class="tab-pane" style="display:none;">
            <div class="tab-header">
                <h2 class="section-title" style="margin-bottom:0;"><i class="fa-solid fa-briefcase"></i> Experience</h2>
                <button class="btn-primary" onclick="openExperienceModal()"><i class="fa-solid fa-plus"></i> Add Experience</button>
            </div>
            <table class="admin-table">
                <thead><tr><th>Role Title</th><th>Company</th><th>Timeline</th><th>Location</th><th>Actions</th></tr></thead>
                <tbody id="experienceTableBody"><tr><td colspan="5">Loading experience...</td></tr></tbody>
            </table>
        </section>

        <!-- 4. Education Tab -->
        <section id="tab-education" class="tab-pane" style="display:none;">
            <div class="tab-header">
                <h2 class="section-title" style="margin-bottom:0;"><i class="fa-solid fa-graduation-cap"></i> Education</h2>
                <button class="btn-primary" onclick="openEducationModal()"><i class="fa-solid fa-plus"></i> Add Education</button>
            </div>
            <table class="admin-table">
                <thead><tr><th>Degree</th><th>Institution</th><th>GPA / Grade</th><th>Timeline</th><th>Actions</th></tr></thead>
                <tbody id="educationTableBody"><tr><td colspan="5">Loading education...</td></tr></tbody>
            </table>
        </section>

        <!-- 5. Certificates Tab -->
        <section id="tab-certificates" class="tab-pane" style="display:none;">
            <div class="tab-header">
                <h2 class="section-title" style="margin-bottom:0;"><i class="fa-solid fa-award"></i> Certificates</h2>
                <button class="btn-primary" onclick="openCertificateModal()"><i class="fa-solid fa-plus"></i> Add Certificate</button>
            </div>
            <table class="admin-table">
                <thead><tr><th>Certificate Title</th><th>Issuer</th><th>Issued Date</th><th>Credential Link</th><th>Actions</th></tr></thead>
                <tbody id="certificatesTableBody"><tr><td colspan="5">Loading certificates...</td></tr></tbody>
            </table>
        </section>

        <!-- 6. Profile & Bio Tab with CV/Resume Upload -->
        <section id="tab-profile" class="tab-pane" style="display:none;">
            <h2 class="section-title"><i class="fa-solid fa-user-pen"></i> Profile & Bio Settings</h2>
            <form id="profileForm" class="comment-form" style="max-width:750px;" enctype="multipart/form-data">
                <input type="hidden" name="existing_resume" id="admin_existing_resume" value="<?= htmlspecialchars($profile['resume_url'] ?? '') ?>">

                <!-- CV / Resume File Upload Field -->
                <div class="form-group" style="background: var(--surface-solid); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-highlight); margin-bottom: 1.5rem;">
                    <label style="font-size: 0.95rem; color: var(--text-hero); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-file-pdf" style="color: var(--accent-pink);"></i> CV / Resume File
                    </label>
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                        <div style="flex: 1; min-width: 240px;">
                            <input type="file" name="resume_file" id="admin_resume_file" accept=".pdf,.doc,.docx" style="font-size: 0.88rem;">
                            <small style="color: var(--text-muted); display: block; margin-top: 0.35rem;">Upload CV document (PDF, DOCX, DOC)</small>
                        </div>
                        <div id="currentCVDisplay">
                            <?php if (!empty($profile['resume_url']) && $profile['resume_url'] !== '#'): ?>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <a href="../<?= htmlspecialchars($profile['resume_url']) ?>" target="_blank" class="btn-outline" style="font-size: 0.82rem; padding: 0.35rem 0.8rem;">
                                        <i class="fa-solid fa-eye"></i> View Current CV
                                    </a>
                                    <button type="button" class="btn-action-sm" onclick="removeCV()" style="color: var(--accent-pink); border-color: rgba(236,72,153,0.3);">
                                        <i class="fa-solid fa-trash"></i> Remove
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($profile['name'] ?? 'Balananda') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Tagline</label>
                        <input type="text" name="tagline" value="<?= htmlspecialchars($profile['tagline'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Hero Headline</label>
                    <input type="text" name="hero_title" value="<?= htmlspecialchars($profile['hero_title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Bio Summary (Lead paragraph)</label>
                    <textarea name="bio" rows="2"><?= htmlspecialchars($profile['bio'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>About Me — Detailed Description</label>
                    <textarea name="about_text" rows="3"><?= htmlspecialchars($profile['about_text'] ?? '') ?></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Years of Experience</label>
                        <input type="number" name="years_exp" value="<?= htmlspecialchars($profile['years_exp'] ?? 2) ?>">
                    </div>
                    <div class="form-group">
                        <label>Articles Written</label>
                        <input type="number" name="articles_written" value="<?= htmlspecialchars($profile['articles_written'] ?? 600) ?>">
                    </div>
                </div>
                <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Save Profile & CV</button>
            </form>
        </section>

        <!-- 7. Messages Tab -->
        <section id="tab-messages" class="tab-pane" style="display:none;">
            <h2 class="section-title"><i class="fa-solid fa-envelope"></i> Contact Messages</h2>
            <table class="admin-table">
                <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Action</th></tr></thead>
                <tbody id="messagesTableBody"><tr><td colspan="5">Loading messages...</td></tr></tbody>
            </table>
        </section>
    </main>
</div>

<!-- ==========================================
     MODALS FOR CRUD ACTIONS
========================================== -->

<div id="projectModal" class="modal">
    <div class="modal-box">
        <h3 id="projectModalTitle" style="margin-bottom: 1.5rem; font-size: 1.4rem;">Add Project</h3>
        <form id="projectForm" enctype="multipart/form-data">
            <input type="hidden" name="id" id="proj_id">
            <input type="hidden" name="existing_image" id="proj_existing_image">

            <div class="form-group">
                <label><i class="fa-solid fa-image"></i> Project Cover Image</label>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
                    <img id="proj_img_preview" src="" alt="Preview" style="display: none; width: 90px; height: 60px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); background: var(--surface-solid);">
                    <div style="flex: 1;">
                        <input type="file" name="project_image" id="proj_file_input" accept="image/*" onchange="previewSelectedImage(event)">
                        <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Upload any image (JPG, PNG, WebP, GIF)</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Project Title *</label>
                <input type="text" name="title" id="proj_title" required>
            </div>
            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" id="proj_desc" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Tech Stack (comma separated)</label>
                <input type="text" name="tech_stack" id="proj_tech" placeholder="React.js, Next.js, Bootstrap">
            </div>
            <div class="form-group">
                <label>Project Link / GitHub URL</label>
                <input type="text" name="project_url" id="proj_url" placeholder="https://...">
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-primary" style="flex: 1;"><i class="fa-solid fa-check"></i> Save Project</button>
                <button type="button" class="btn-outline" onclick="closeModal('projectModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Experience Modal -->
<div id="experienceModal" class="modal">
    <div class="modal-box">
        <h3 id="experienceModalTitle" style="margin-bottom:1.5rem; font-size:1.4rem;">Add Experience</h3>
        <form id="experienceForm">
            <input type="hidden" name="id" id="exp_id">
            <div class="form-group">
                <label>Job Title / Role *</label>
                <input type="text" name="role_title" id="exp_role" required>
            </div>
            <div class="form-group">
                <label>Company Name *</label>
                <input type="text" name="company" id="exp_company" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Employment Type</label>
                    <input type="text" name="employment_type" id="exp_type" placeholder="Full-time / Freelance">
                </div>
                <div class="form-group">
                    <label>Timeline *</label>
                    <input type="text" name="timeline" id="exp_timeline" placeholder="Jun 2024 - Present" required>
                </div>
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" id="exp_location" placeholder="Kathmandu · On-site / Remote">
            </div>
            <div class="form-group">
                <label>Skills Used (comma separated)</label>
                <input type="text" name="skills_used" id="exp_skills" placeholder="SEO, Technical Writing, Meta Ads">
            </div>
            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn-primary" style="flex:1;"><i class="fa-solid fa-check"></i> Save Experience</button>
                <button type="button" class="btn-outline" onclick="closeModal('experienceModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Education Modal -->
<div id="educationModal" class="modal">
    <div class="modal-box">
        <h3 id="educationModalTitle" style="margin-bottom:1.5rem; font-size:1.4rem;">Add Education</h3>
        <form id="educationForm">
            <input type="hidden" name="id" id="edu_id">
            <div class="form-group">
                <label>Degree / Course *</label>
                <input type="text" name="degree" id="edu_degree" required>
            </div>
            <div class="form-group">
                <label>Institution / University *</label>
                <input type="text" name="institution" id="edu_inst" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>GPA / Grade *</label>
                    <input type="text" name="gpa" id="edu_gpa" placeholder="3.72 / 4.0" required>
                </div>
                <div class="form-group">
                    <label>Timeline *</label>
                    <input type="text" name="timeline" id="edu_timeline" placeholder="2021 – 2026" required>
                </div>
            </div>
            <div class="form-group">
                <label>Key Skills Covered (comma separated)</label>
                <input type="text" name="skills_covered" id="edu_skills" placeholder="Web Development, Database Management">
            </div>
            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn-primary" style="flex:1;"><i class="fa-solid fa-check"></i> Save Education</button>
                <button type="button" class="btn-outline" onclick="closeModal('educationModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- 4. Certificate Modal -->
<div id="certificateModal" class="modal">
    <div class="modal-box">
        <h3 id="certificateModalTitle" style="margin-bottom:1.5rem; font-size:1.4rem;">Add Certificate</h3>
        <form id="certificateForm">
            <input type="hidden" name="id" id="cert_id">
            <div class="form-group">
                <label>Certificate Name *</label>
                <input type="text" name="title" id="cert_title" required>
            </div>
            <div class="form-group">
                <label>Issuing Organization *</label>
                <input type="text" name="issuer" id="cert_issuer" required>
            </div>
            <div class="form-group">
                <label>Issue Date *</label>
                <input type="text" name="issue_date" id="cert_date" placeholder="Dec 2024 · Expired Mar 2025" required>
            </div>
            <div class="form-group">
                <label>Credential Link (Google Drive / PDF / Verification URL)</label>
                <input type="text" name="credential_url" id="cert_url" placeholder="https://...">
            </div>
            <div class="form-group">
                <label>Skills (comma separated)</label>
                <input type="text" name="skills_covered" id="cert_skills" placeholder="React.js, Node.js, SEO">
            </div>
            <div style="display:flex; gap:1rem; margin-top:1.5rem;">
                <button type="submit" class="btn-primary" style="flex:1;"><i class="fa-solid fa-check"></i> Save Certificate</button>
                <button type="button" class="btn-outline" onclick="closeModal('certificateModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
// --- UI Navigation ---
function showTab(tabId, btn) {
    document.querySelectorAll('.tab-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.sidebar-btn').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tabId).style.display = 'block';
    btn.classList.add('active');

    if (tabId === 'projects') loadProjects();
    if (tabId === 'experience') loadExperience();
    if (tabId === 'education') loadEducation();
    if (tabId === 'certificates') loadCertificates();
    if (tabId === 'messages') loadMessages();
}

function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }

// ==========================================
// 1. Projects Handler
// ==========================================
async function loadProjects() {
    const res = await fetch('../api/index.php?action=projects');
    const json = await res.json();
    const tbody = document.getElementById('projectsTableBody');
    tbody.innerHTML = '';
    if (!json.data || json.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No projects found. Click Add Project above!</td></tr>';
        return;
    }
    json.data.forEach(p => {
        const imgSrc = p.image_path ? `../${p.image_path}` : '../assets/finance.jpg';
        tbody.innerHTML += `
            <tr>
                <td>
                    <img src="${imgSrc}" alt="${p.title}" style="width: 55px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-subtle);">
                </td>
                <td><strong>${p.title}</strong></td>
                <td><small>${p.tech_stack || ''}</small></td>
                <td><a href="${p.project_url}" target="_blank" style="color:var(--accent-pink);">${p.project_url}</a></td>
                <td>
                    <button class="btn-action-sm" onclick='editProject(${JSON.stringify(p)})'><i class="fa-solid fa-pen"></i></button>
                    <button class="btn-action-sm" onclick="deleteItem('projects', ${p.id})"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>`;
    });
}

function openProjectModal() {
    document.getElementById('projectForm').reset();
    document.getElementById('proj_id').value = '';
    document.getElementById('proj_existing_image').value = '';
    
    const fileInput = document.getElementById('proj_file_input');
    if (fileInput) fileInput.value = '';
    
    const preview = document.getElementById('proj_img_preview');
    preview.src = '';
    preview.style.display = 'none';

    document.getElementById('projectModalTitle').innerText = 'Add Project';
    openModal('projectModal');
}

function editProject(p) {
    document.getElementById('projectForm').reset();
    document.getElementById('proj_id').value = p.id;
    document.getElementById('proj_title').value = p.title || '';
    document.getElementById('proj_desc').value = p.description || '';
    document.getElementById('proj_tech').value = p.tech_stack || '';
    document.getElementById('proj_url').value = p.project_url || '';
    
    document.getElementById('proj_existing_image').value = p.image_path || '';
    
    const preview = document.getElementById('proj_img_preview');
    if (p.image_path) {
        preview.src = `../${p.image_path}`;
        preview.style.display = 'block';
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }

    document.getElementById('projectModalTitle').innerText = 'Edit Project';
    openModal('projectModal');
}

function previewSelectedImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('proj_img_preview');
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}

document.getElementById('projectForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch('../api/index.php?action=projects', { method: 'POST', body: new FormData(e.target) });
    const json = await res.json();
    alert(json.message);
    closeModal('projectModal');
    loadProjects();
});

// ==========================================
// 2. Experience Handler
// ==========================================
async function loadExperience() {
    const res = await fetch('../api/index.php?action=experience');
    const json = await res.json();
    const tbody = document.getElementById('experienceTableBody');
    tbody.innerHTML = '';
    if (!json.data || json.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No experience entries found.</td></tr>';
        return;
    }
    json.data.forEach(exp => {
        tbody.innerHTML += `
            <tr>
                <td><strong>${exp.role_title}</strong></td>
                <td>${exp.company}</td>
                <td>${exp.timeline}</td>
                <td>${exp.location}</td>
                <td>
                    <button class="btn-action-sm" onclick='editExperience(${JSON.stringify(exp)})'><i class="fa-solid fa-pen"></i></button>
                    <button class="btn-action-sm" onclick="deleteItem('experience', ${exp.id})"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>`;
    });
}

function openExperienceModal() {
    document.getElementById('experienceForm').reset();
    document.getElementById('exp_id').value = '';
    document.getElementById('experienceModalTitle').innerText = 'Add Experience';
    openModal('experienceModal');
}

function editExperience(exp) {
    document.getElementById('exp_id').value = exp.id;
    document.getElementById('exp_role').value = exp.role_title;
    document.getElementById('exp_company').value = exp.company;
    document.getElementById('exp_type').value = exp.employment_type;
    document.getElementById('exp_timeline').value = exp.timeline;
    document.getElementById('exp_location').value = exp.location;
    document.getElementById('exp_skills').value = exp.skills_used;
    document.getElementById('experienceModalTitle').innerText = 'Edit Experience';
    openModal('experienceModal');
}

document.getElementById('experienceForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch('../api/index.php?action=experience', { method: 'POST', body: new FormData(e.target) });
    const json = await res.json();
    alert(json.message);
    closeModal('experienceModal');
    loadExperience();
});

// ==========================================
// 3. Education Handler
// ==========================================
async function loadEducation() {
    const res = await fetch('../api/index.php?action=education');
    const json = await res.json();
    const tbody = document.getElementById('educationTableBody');
    tbody.innerHTML = '';
    if (!json.data || json.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No education entries found.</td></tr>';
        return;
    }
    json.data.forEach(edu => {
        tbody.innerHTML += `
            <tr>
                <td><strong>${edu.degree}</strong></td>
                <td>${edu.institution}</td>
                <td>${edu.gpa}</td>
                <td>${edu.timeline}</td>
                <td>
                    <button class="btn-action-sm" onclick='editEducation(${JSON.stringify(edu)})'><i class="fa-solid fa-pen"></i></button>
                    <button class="btn-action-sm" onclick="deleteItem('education', ${edu.id})"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>`;
    });
}

function openEducationModal() {
    document.getElementById('educationForm').reset();
    document.getElementById('edu_id').value = '';
    document.getElementById('educationModalTitle').innerText = 'Add Education';
    openModal('educationModal');
}

function editEducation(edu) {
    document.getElementById('edu_id').value = edu.id;
    document.getElementById('edu_degree').value = edu.degree;
    document.getElementById('edu_inst').value = edu.institution;
    document.getElementById('edu_gpa').value = edu.gpa;
    document.getElementById('edu_timeline').value = edu.timeline;
    document.getElementById('edu_skills').value = edu.skills_covered;
    document.getElementById('educationModalTitle').innerText = 'Edit Education';
    openModal('educationModal');
}

document.getElementById('educationForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch('../api/index.php?action=education', { method: 'POST', body: new FormData(e.target) });
    const json = await res.json();
    alert(json.message);
    closeModal('educationModal');
    loadEducation();
});

// ==========================================
// 4. Certificates Handler
// ==========================================
async function loadCertificates() {
    const res = await fetch('../api/index.php?action=certificates');
    const json = await res.json();
    const tbody = document.getElementById('certificatesTableBody');
    tbody.innerHTML = '';
    if (!json.data || json.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No certificates found.</td></tr>';
        return;
    }
    json.data.forEach(c => {
        tbody.innerHTML += `
            <tr>
                <td><strong>${c.title}</strong></td>
                <td>${c.issuer}</td>
                <td>${c.issue_date}</td>
                <td><a href="${c.credential_url}" target="_blank" style="color:var(--accent-pink);">View</a></td>
                <td>
                    <button class="btn-action-sm" onclick='editCertificate(${JSON.stringify(c)})'><i class="fa-solid fa-pen"></i></button>
                    <button class="btn-action-sm" onclick="deleteItem('certificates', ${c.id})"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>`;
    });
}

function openCertificateModal() {
    document.getElementById('certificateForm').reset();
    document.getElementById('cert_id').value = '';
    document.getElementById('certificateModalTitle').innerText = 'Add Certificate';
    openModal('certificateModal');
}

function editCertificate(c) {
    document.getElementById('cert_id').value = c.id;
    document.getElementById('cert_title').value = c.title;
    document.getElementById('cert_issuer').value = c.issuer;
    document.getElementById('cert_date').value = c.issue_date;
    document.getElementById('cert_url').value = c.credential_url;
    document.getElementById('cert_skills').value = c.skills_covered;
    document.getElementById('certificateModalTitle').innerText = 'Edit Certificate';
    openModal('certificateModal');
}

document.getElementById('certificateForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch('../api/index.php?action=certificates', { method: 'POST', body: new FormData(e.target) });
    const json = await res.json();
    alert(json.message);
    closeModal('certificateModal');
    loadCertificates();
});

// ==========================================
// 5. Generic Delete & Profile Save
// ==========================================
async function deleteItem(resource, id) {
    if (!confirm('Are you sure you want to delete this item?')) return;
    const res = await fetch(`../api/index.php?action=${resource}&id=${id}`, { method: 'DELETE' });
    const json = await res.json();
    alert(json.message);
    if (resource === 'projects') loadProjects();
    if (resource === 'experience') loadExperience();
    if (resource === 'education') loadEducation();
    if (resource === 'certificates') loadCertificates();
    if (resource === 'messages') loadMessages();
}

function removeCV() {
    if (confirm('Are you sure you want to remove the current CV?')) {
        document.getElementById('admin_existing_resume').value = '';
        document.getElementById('currentCVDisplay').innerHTML = '<span style="font-size:0.85rem; color:var(--text-muted);">CV removed. Click Save Profile to apply.</span>';
    }
}

document.getElementById('profileForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const res = await fetch('../api/index.php?action=profile', { 
        method: 'POST', 
        body: formData 
    });
    const json = await res.json();
    alert(json.message);
});

async function loadMessages() {
    const res = await fetch('../api/index.php?action=messages');
    const json = await res.json();
    const tbody = document.getElementById('messagesTableBody');
    tbody.innerHTML = '';
    if (!json.data || json.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5">No messages received yet.</td></tr>';
        return;
    }
    json.data.forEach(m => {
        tbody.innerHTML += `
            <tr>
                <td>${m.name}</td>
                <td>${m.email}</td>
                <td>${m.subject}</td>
                <td><small>${m.message}</small></td>
                <td><button class="btn-action-sm" onclick="deleteItem('messages', ${m.id})"><i class="fa-solid fa-trash"></i></button></td>
            </tr>`;
    });
}
</script>
</body>
</html>