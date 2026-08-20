<?php
$feedbackMessage = '';
$feedbackType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'Website Comment');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $subject, $message]);
                $feedbackMessage = "Thanks for leaving a comment, $name! Your message has been saved.";
                $feedbackType = "success";
            } catch (PDOException $e) {
                $feedbackMessage = "Database error: Could not save your message. Please try again.";
                $feedbackType = "error";
            }
        } else {
            $feedbackMessage = "Please enter a valid email address.";
            $feedbackType = "error";
        }
    } else {
        $feedbackMessage = "Please fill in all required fields.";
        $feedbackType = "error";
    }
}
?>

<section id="contact" class="section contact-section reveal">
    <div class="container">
        <div class="contact-box">
            <div class="contact-icon-bubble">
                <i class="fa-solid fa-comments"></i>
            </div>
            
            <h2 class="section-title">Leave a Comment & Connect</h2>
            <p class="contact-subtitle">
                Have a question, feedback, or a project in mind? Drop a message below or connect with me directly!
            </p>

            <!-- Direct Quick Connect Buttons -->
            <div class="contact-actions">
                <a href="https://www.linkedin.com/in/balanandawagle" target="_blank" rel="noopener noreferrer" class="btn-outline linkedin-btn">
                    <i class="fa-brands fa-linkedin"></i> Connect on LinkedIn
                </a>
                <a href="mailto:wagleom@gmail.com" class="btn-primary gmail-btn">
                    <i class="fa-solid fa-envelope"></i> Send Email Directly
                </a>
            </div>

            <!-- Form Feedback Alert -->
            <?php if (!empty($feedbackMessage)): ?>
                <div class="form-alert <?= $feedbackType === 'success' ? 'alert-success' : 'alert-error' ?>">
                    <i class="<?= $feedbackType === 'success' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-exclamation' ?>"></i>
                    <?= htmlspecialchars($feedbackMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Leave a Comment / Message Form -->
            <form action="#contact" method="POST" class="comment-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name"><i class="fa-regular fa-user"></i> Your Name *</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="fa-regular fa-envelope"></i> Your Email *</label>
                        <input type="email" id="email" name="email" placeholder="john@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subject"><i class="fa-solid fa-tag"></i> Subject (Optional)</label>
                    <input type="text" id="subject" name="subject" placeholder="SEO Collaboration / General Feedback">
                </div>

                <div class="form-group">
                    <label for="message"><i class="fa-regular fa-message"></i> Your Comment / Message *</label>
                    <textarea id="message" name="message" rows="4" placeholder="Write your thoughts, feedback, or inquiry here..." required></textarea>
                </div>

                <button type="submit" name="submit_comment" class="btn-primary submit-btn">
                    <i class="fa-solid fa-paper-plane"></i> Post Comment / Message
                </button>
            </form>
        </div>
    </div>
</section>