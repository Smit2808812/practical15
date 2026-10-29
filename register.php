<?php

require_once __DIR__ . '/session_check.php';

if (isLoggedIn()) {
header('Location: student_dashboard.php');
exit;
}

$errors = [];
$name = '';
$email = '';
$studentId = '';
$course = 'Computer Science';
$semester = '3';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!verifyCSRF($_POST['csrf_token'] ?? '')) {
$errors[] = 'Security check failed. Refresh and try again.';
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$studentId = trim($_POST['student_id'] ?? '');
$course = trim($_POST['course'] ?? 'Computer Science');
$semester = trim($_POST['semester'] ?? '3');
$password = $_POST['password'] ?? '';

if (
$name === '' ||
!filter_var($email, FILTER_VALIDATE_EMAIL) ||
strlen($password) < 8
) {
$errors[] = 'Enter a name, valid email and password of at least 8 characters.';
}

if (!$errors) {
try {
$pdo->beginTransaction();

$q = $pdo->prepare(
'SELECT id FROM users WHERE email = ?'
);

$q->execute([$email]);

if ($q->fetch()) {
throw new RuntimeException(
'An account with this email already exists.'
);
}

$q = $pdo->prepare(
"INSERT INTO users(name, email, password, role, status)
VALUES(?, ?, ?, 'student', 'active')"
);

$q->execute([
$name,
$email,
password_hash($password, PASSWORD_DEFAULT)
]);

$uid = (int) $pdo->lastInsertId();

$q = $pdo->prepare(
"INSERT INTO students(
user_id,
student_id,
name,
email,
course,
semester,
status
)
VALUES(?, ?, ?, ?, ?, ?, 'active')"
);

$q->execute([
$uid,
$studentId ?: null,
$name,
$email,
$course,
(int) $semester
]);

$pdo->commit();

flash('Account created. You can now sign in.');

header('Location: login.php');
exit;

} catch (Throwable $e) {

if ($pdo->inTransaction()) {
$pdo->rollBack();
}

$errors[] = $e instanceof RuntimeException
? $e->getMessage()
: 'Registration could not be completed. Check the database schema.';
}
}
}

$pageTitle = 'Create account | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">YOUR NEXT CHAPTER</span>

<h1 class="page-title">
Create your account
</h1>

<p class="lead">
Join the campus community in a couple of steps.
</p>
</div>
</section>

<section class="content">
<div class="container">
<div class="card form-card">

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
<label>Full name</label>

<input
name="name"
value="<?= h($name) ?>"
required
>
</div>

<div class="form-group">
<label>Email address</label>

<input
type="email"
name="email"
value="<?= h($email) ?>"
required
>
</div>

<div class="form-group">
<label>Student ID (optional)</label>

<input
name="student_id"
value="<?= h($studentId) ?>"
>
</div>

<div class="form-row">
<div class="form-group">
<label>Course</label>

<input
name="course"
value="<?= h($course) ?>"
required
>
</div>

<div class="form-group">
<label>Semester</label>

<select name="semester">
<?php for ($i = 1; $i <= 8; $i++): ?>
<option
value="<?= $i ?>"
<?= (string) $i === $semester ? 'selected' : '' ?>
>
<?= $i ?>
</option>
<?php endfor; ?>
</select>
</div>
</div>

<div class="form-group">
<label>Password (minimum 8 characters)</label>

<input
type="password"
name="password"
minlength="8"
required
>
</div>

<button class="btn btn-primary" type="submit">
Create account ↗
</button>

<p class="muted" style="margin-top: 15px">
Already registered?
<a href="login.php">Sign in</a>
</p>

</form>
</div>
</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
