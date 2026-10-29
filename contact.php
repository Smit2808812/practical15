<?php

require_once __DIR__ . '/session_check.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!verifyCSRF($_POST['csrf_token'] ?? '')) {
$errors[] = 'Security check failed. Please refresh and try again.';
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (
$name === '' ||
!filter_var($email, FILTER_VALIDATE_EMAIL) ||
$subject === '' ||
$message === ''
) {
$errors[] = 'Please complete all fields using a valid email.';
}

if (!$errors) {
try {
$q = $pdo->prepare(
"INSERT INTO contact_messages
(name, email, subject, message, status)
VALUES (?, ?, ?, ?, 'new')"
);

$q->execute([
$name,
$email,
$subject,
$message
]);

flash('Thanks! Your message has been sent.');

header('Location: contact.php');
exit;

} catch (Throwable $e) {
$errors[] = 'Message could not be saved. Check the database setup.';
}
}
}

$pageTitle = 'Contact | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">WE’RE HERE TO HELP</span>

<h1 class="page-title">
Let’s talk.
</h1>

<p class="lead">
Have a question or suggestion? Send the campus team a message.
</p>
</div>
</section>

<section class="content">
<div class="container grid-2">

<div class="card">
<h3>Send an inquiry</h3>

<?php foreach ($errors as $e): ?>
<div class="alert alert-danger">
<?= h($e) ?>
</div>
<?php endforeach; ?>

<form method="post">
<input
type="hidden"
name="csrf_token"
value="<?= h(csrfToken()) ?>"
>

<div class="form-group">
<label>Your name</label>
<input name="name" required>
</div>

<div class="form-group">
<label>Email address</label>
<input
type="email"
name="email"
required
>
</div>

<div class="form-group">
<label>Subject</label>
<input name="subject" required>
</div>

<div class="form-group">
<label>Message</label>
<textarea
name="message"
rows="5"
required
></textarea>
</div>

<button class="btn btn-primary">
Send message ↗
</button>
</form>
</div>

<div>
<article class="card">
<div class="icon-box">⌖</div>

<h3>Campus information</h3>

<p>
<strong>CSPIT, CHARUSAT</strong><br>
CHARUSAT Campus, Changa, Anand, Gujarat, India.
</p>

<p>
Email: info@charusat.ac.in
</p>

<p>
Office hours: Monday–Saturday, 9:00 AM–4:30 PM
</p>
</article>

<article class="card" style="margin-top: 18px">
<h3>Helpful links</h3>

<p>
Need quick help? Browse the
<a href="faq.php">FAQs</a>
or review campus
<a href="notices.php">notices</a>.
</p>
</article>
</div>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
