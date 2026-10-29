<?php

require_once __DIR__ . '/session_check.php';

if (isLoggedIn()) {
header(
'Location: ' .
(isAdmin() ? 'admin_dashboard.php' : 'student_dashboard.php')
);
exit;
}

$error = '';

if (isset($_GET['error'])) {
$error = $_GET['error'] === 'timeout'
? 'Your session expired. Please sign in again.'
: 'Please sign in to continue.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!verifyCSRF($_POST['csrf_token'] ?? '')) {
$error = 'Security check failed. Refresh the page and try again.';

} else {

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

try {
$q = $pdo->prepare(
'SELECT id, name, email, password, role, status
FROM users
WHERE email = ?
LIMIT 1'
);

$q->execute([$email]);
$u = $q->fetch();

if (
$u &&
password_verify($password, $u['password']) &&
$u['status'] === 'active'
) {
session_regenerate_id(true);

$_SESSION['user_id'] = (int) $u['id'];
$_SESSION['name'] = $u['name'];
$_SESSION['email'] = $u['email'];
$_SESSION['role'] = $u['role'];
$_SESSION['last_activity'] = time();

$q = $pdo->prepare(
'UPDATE users
SET last_login = NOW()
WHERE id = ?'
);

$q->execute([$u['id']]);

header(
'Location: ' .
($u['role'] === 'admin'
? 'admin_dashboard.php'
: 'student_dashboard.php')
);

exit;

} else {
$error = 'Email or password is incorrect, or the account is inactive.';
}

} catch (Throwable $e) {
$error = 'Unable to sign in. Confirm that the database is set up.';
}
}
}

$pageTitle = 'Sign in | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">WELCOME BACK</span>

<h1 class="page-title">
Good to see you again.
</h1>

<p class="lead">
Sign in to continue to your campus portal.
</p>
</div>
</section>

<section class="content">
<div class="container">

<div class="card form-card">

<?php if ($error): ?>
<div class="alert alert-danger">
<?= h($error) ?>
</div>
<?php endif; ?>

<form method="post">

<input
type="hidden"
name="csrf_token"
value="<?= h(csrfToken()) ?>"
>

<div class="form-group">
<label>Email address</label>

<input
type="email"
name="email"
autocomplete="username"
required
>
</div>

<div class="form-group">
<label>Password</label>

<input
type="password"
name="password"
autocomplete="current-password"
required
>
</div>

<button
class="btn btn-primary"
type="submit"
>
Sign in ↗
</button>

<p class="muted" style="margin-top: 15px">
New to Smit Campus Portal?
<a href="register.php">Create an account</a>
</p>

</form>
</div>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
