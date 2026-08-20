<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

function jsonResponse($status, $message, $data = null) {
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit;
}

function requireAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        http_response_code(401);
        jsonResponse('error', 'Unauthorized. Please login again.');
    }
}

try {
    switch ($action) {
        // ==========================================
        // 1. PROJECTS CRUD
        // ==========================================
        case 'projects':
            if ($method === 'GET') {
                $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
                jsonResponse('success', 'Projects retrieved', $stmt->fetchAll());
            } elseif ($method === 'POST') {
                requireAuth();
                $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
                $title = trim($_POST['title'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $tech_stack = trim($_POST['tech_stack'] ?? '');
                $project_url = trim($_POST['project_url'] ?? '#');
                $image_path = trim($_POST['existing_image'] ?? '');

                if (empty($title)) jsonResponse('error', 'Project title is required.');

                // Process newly uploaded image if present
                if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
                    $fileTmp = $_FILES['project_image']['tmp_name'];
                    $fileName = $_FILES['project_image']['name'];
                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (in_array($ext, $allowed)) {
                        $uploadDir = __DIR__ . '/../assets/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        // Generate clean unique filename for new upload
                        $newFileName = 'proj_' . time() . '_' . rand(100, 999) . '.' . $ext;
                        $dest = $uploadDir . $newFileName;

                        if (move_uploaded_file($fileTmp, $dest)) {
                            $image_path = 'assets/' . $newFileName;
                        }
                    }
                }

                if ($id) {
                    $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, tech_stack=?, project_url=?, image_path=? WHERE id=?");
                    $stmt->execute([$title, $description, $tech_stack, $project_url, $image_path, $id]);
                    jsonResponse('success', 'Project updated successfully!');
                } else {
                    $stmt = $pdo->prepare("INSERT INTO projects (title, description, tech_stack, project_url, image_path) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $tech_stack, $project_url, $image_path]);
                    jsonResponse('success', 'Project created successfully!');
                }
            } elseif ($method === 'DELETE') {
                requireAuth();
                $id = (int)($_GET['id'] ?? 0);
                $pdo->prepare("DELETE FROM projects WHERE id=?")->execute([$id]);
                jsonResponse('success', 'Project deleted successfully!');
            }
            break;

            // ==========================================
        // 5. PROFILE & CV SETTINGS
        // ==========================================
        case 'profile':
            if ($method === 'GET') {
                $stmt = $pdo->query("SELECT * FROM profile WHERE id = 1 LIMIT 1");
                $data = $stmt->fetch();
                jsonResponse('success', 'Profile retrieved', $data ?: []);
            } elseif ($method === 'POST') {
                requireAuth();
                $name = trim($_POST['name'] ?? 'Balananda');
                $tagline = trim($_POST['tagline'] ?? '');
                $hero_title = trim($_POST['hero_title'] ?? '');
                $bio = trim($_POST['bio'] ?? '');
                $about_text = trim($_POST['about_text'] ?? '');
                $years_exp = (int)($_POST['years_exp'] ?? 2);
                $articles_written = (int)($_POST['articles_written'] ?? 600);
                $resume_url = trim($_POST['existing_resume'] ?? '');

                // Handle CV / Resume File Upload
                if (isset($_FILES['resume_file']) && $_FILES['resume_file']['error'] === UPLOAD_ERR_OK) {
                    $fileTmp = $_FILES['resume_file']['tmp_name'];
                    $fileName = $_FILES['resume_file']['name'];
                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    $allowed = ['pdf', 'doc', 'docx'];
                    if (in_array($ext, $allowed)) {
                        $uploadDir = __DIR__ . '/../assets/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $newFileName = 'resume_' . time() . '_' . rand(100, 999) . '.' . $ext;
                        $dest = $uploadDir . $newFileName;

                        if (move_uploaded_file($fileTmp, $dest)) {
                            $resume_url = 'assets/' . $newFileName;
                        }
                    } else {
                        jsonResponse('error', 'Invalid file type. Please upload a PDF, DOC, or DOCX.');
                    }
                }

                // Upsert Profile row
                $stmt = $pdo->prepare("
                    INSERT INTO profile (id, name, tagline, hero_title, bio, about_text, years_exp, articles_written, resume_url) 
                    VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?) 
                    ON DUPLICATE KEY UPDATE 
                        name = VALUES(name), 
                        tagline = VALUES(tagline), 
                        hero_title = VALUES(hero_title), 
                        bio = VALUES(bio), 
                        about_text = VALUES(about_text), 
                        years_exp = VALUES(years_exp), 
                        articles_written = VALUES(articles_written),
                        resume_url = VALUES(resume_url)
                ");
                $stmt->execute([$name, $tagline, $hero_title, $bio, $about_text, $years_exp, $articles_written, $resume_url]);
                jsonResponse('success', 'Profile & CV updated successfully!');
            }
            break;

        // ==========================================
        // 2. EXPERIENCE CRUD
        // ==========================================
        case 'experience':
            if ($method === 'GET') {
                $stmt = $pdo->query("SELECT * FROM experience ORDER BY id DESC");
                jsonResponse('success', 'Experience retrieved', $stmt->fetchAll());
            } elseif ($method === 'POST') {
                requireAuth();
                $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
                $role_title = trim($_POST['role_title'] ?? '');
                $company = trim($_POST['company'] ?? '');
                $employment_type = trim($_POST['employment_type'] ?? 'Full-time');
                $timeline = trim($_POST['timeline'] ?? '');
                $location = trim($_POST['location'] ?? 'Remote');
                $skills_used = trim($_POST['skills_used'] ?? '');

                if (empty($role_title) || empty($company)) {
                    jsonResponse('error', 'Job Role and Company name are required.');
                }

                if ($id) {
                    $stmt = $pdo->prepare("UPDATE experience SET role_title=?, company=?, employment_type=?, timeline=?, location=?, skills_used=? WHERE id=?");
                    $stmt->execute([$role_title, $company, $employment_type, $timeline, $location, $skills_used, $id]);
                    jsonResponse('success', 'Experience updated successfully!');
                } else {
                    $stmt = $pdo->prepare("INSERT INTO experience (role_title, company, employment_type, timeline, location, skills_used) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$role_title, $company, $employment_type, $timeline, $location, $skills_used]);
                    jsonResponse('success', 'Experience added successfully!');
                }
            } elseif ($method === 'DELETE') {
                requireAuth();
                $id = (int)($_GET['id'] ?? 0);
                $pdo->prepare("DELETE FROM experience WHERE id=?")->execute([$id]);
                jsonResponse('success', 'Experience deleted successfully!');
            }
            break;

        // ==========================================
        // 3. EDUCATION CRUD
        // ==========================================
        case 'education':
            if ($method === 'GET') {
                $stmt = $pdo->query("SELECT * FROM education ORDER BY id DESC");
                jsonResponse('success', 'Education retrieved', $stmt->fetchAll());
            } elseif ($method === 'POST') {
                requireAuth();
                $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
                $degree = trim($_POST['degree'] ?? '');
                $institution = trim($_POST['institution'] ?? '');
                $gpa = trim($_POST['gpa'] ?? '');
                $timeline = trim($_POST['timeline'] ?? '');
                $skills_covered = trim($_POST['skills_covered'] ?? '');

                if (empty($degree) || empty($institution)) {
                    jsonResponse('error', 'Degree and Institution are required.');
                }

                if ($id) {
                    $stmt = $pdo->prepare("UPDATE education SET degree=?, institution=?, gpa=?, timeline=?, skills_covered=? WHERE id=?");
                    $stmt->execute([$degree, $institution, $gpa, $timeline, $skills_covered, $id]);
                    jsonResponse('success', 'Education entry updated successfully!');
                } else {
                    $stmt = $pdo->prepare("INSERT INTO education (degree, institution, gpa, timeline, skills_covered) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$degree, $institution, $gpa, $timeline, $skills_covered]);
                    jsonResponse('success', 'Education entry added successfully!');
                }
            } elseif ($method === 'DELETE') {
                requireAuth();
                $id = (int)($_GET['id'] ?? 0);
                $pdo->prepare("DELETE FROM education WHERE id=?")->execute([$id]);
                jsonResponse('success', 'Education entry deleted successfully!');
            }
            break;

        // ==========================================
        // 4. CERTIFICATES CRUD
        // ==========================================
        case 'certificates':
            if ($method === 'GET') {
                $stmt = $pdo->query("SELECT * FROM certificates ORDER BY id DESC");
                jsonResponse('success', 'Certificates retrieved', $stmt->fetchAll());
            } elseif ($method === 'POST') {
                requireAuth();
                $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
                $title = trim($_POST['title'] ?? '');
                $issuer = trim($_POST['issuer'] ?? '');
                $issue_date = trim($_POST['issue_date'] ?? '');
                $credential_url = trim($_POST['credential_url'] ?? '#');
                $skills_covered = trim($_POST['skills_covered'] ?? '');

                if (empty($title) || empty($issuer)) {
                    jsonResponse('error', 'Certificate Title and Issuer are required.');
                }

                if ($id) {
                    $stmt = $pdo->prepare("UPDATE certificates SET title=?, issuer=?, issue_date=?, credential_url=?, skills_covered=? WHERE id=?");
                    $stmt->execute([$title, $issuer, $issue_date, $credential_url, $skills_covered, $id]);
                    jsonResponse('success', 'Certificate updated successfully!');
                } else {
                    $stmt = $pdo->prepare("INSERT INTO certificates (title, issuer, issue_date, credential_url, skills_covered) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $issuer, $issue_date, $credential_url, $skills_covered]);
                    jsonResponse('success', 'Certificate added successfully!');
                }
            } elseif ($method === 'DELETE') {
                requireAuth();
                $id = (int)($_GET['id'] ?? 0);
                $pdo->prepare("DELETE FROM certificates WHERE id=?")->execute([$id]);
                jsonResponse('success', 'Certificate deleted successfully!');
            }
            break;

        // ==========================================
        // PROJECTS CRUD (WITH IMAGE SUPPORT)
        // ==========================================
        case 'projects':
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
        jsonResponse('success', 'Projects retrieved', $stmt->fetchAll());
    } elseif ($method === 'POST') {
        requireAuth();
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $tech_stack = trim($_POST['tech_stack'] ?? '');
        $project_url = trim($_POST['project_url'] ?? '#');
        $image_path = trim($_POST['existing_image'] ?? '');

        if (empty($title)) jsonResponse('error', 'Project title is required.');

        // If the user uploaded a new image, save it
        if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['project_image']['tmp_name'];
            $fileName = $_FILES['project_image']['name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (in_array($ext, $allowed)) {
                $uploadDir = __DIR__ . '/../assets/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $uniqueName = 'project_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $dest = $uploadDir . $uniqueName;
                
                if (move_uploaded_file($fileTmp, $dest)) {
                    $image_path = 'assets/' . $uniqueName;
                }
            } else {
                jsonResponse('error', 'Invalid image format. Allowed: JPG, JPEG, PNG, WebP, GIF.');
            }
        }

        if ($id) {
            $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, tech_stack=?, project_url=?, image_path=? WHERE id=?");
            $stmt->execute([$title, $description, $tech_stack, $project_url, $image_path, $id]);
            jsonResponse('success', 'Project updated successfully!');
        } else {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, tech_stack, project_url, image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $tech_stack, $project_url, $image_path]);
            jsonResponse('success', 'Project added successfully!');
        }
    } elseif ($method === 'DELETE') {
        requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $pdo->prepare("DELETE FROM projects WHERE id=?")->execute([$id]);
        jsonResponse('success', 'Project deleted successfully!');
    }
    break;

        // ==========================================
        // 6. MESSAGES
        // ==========================================
        case 'messages':
            requireAuth();
            if ($method === 'GET') {
                $stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY id DESC");
                jsonResponse('success', 'Messages retrieved', $stmt->fetchAll());
            } elseif ($method === 'DELETE') {
                $id = (int)($_GET['id'] ?? 0);
                $pdo->prepare("DELETE FROM contact_messages WHERE id=?")->execute([$id]);
                jsonResponse('success', 'Message deleted successfully!');
            }
            break;

        default:
            jsonResponse('error', 'Invalid API Action');
    }
} catch (PDOException $e) {
    jsonResponse('error', 'Database operation failed: ' . $e->getMessage());
}