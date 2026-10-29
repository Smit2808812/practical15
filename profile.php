<?php

require_once __DIR__ . '/session_check.php';

requireLogin();

$user = getCurrentUser();
$message = '';

if (
$_SERVER['REQUEST_METHOD'] === 'POST' &&
verifyCSRF($_POST['csrf_token'] ?? '')
) {
$name = trim($_POST['name'] ?? '');

if ($name !== '') {
try {
$q = $pdo->prepare(
'UPDATE users SET name = ? WHERE id = ?'
);

$q->execute([
$name,
$user['id']
]);

$_SESSION['name'] = $name;

flash('Profile updated successfully.');

header('Location: profile.php');
exit;

} catch (Throwable $e) {
$message = 'Could not update profile.';
}

} else {
$message = 'Name cannot be empty.';
}
}

$pageTitle = 'My profile | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">YOUR ACCOUNT</span>

<h1 class="page-title">
Profile settings
</h1>

<p class="lead">
Review your account information.
</p>
</div>
</section>

<section class="content">
<div class="container">

<div class="card form-card">

<?php if ($message): ?>
<div class="alert alert-danger">
<?= h($message) ?>
</div>
<?php endif; ?>

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
value="<?= h($user['name']) ?>"
required
>
</div>

<div class="form-group">
<label>Email address</label>

<input
value="<?= h($user['email']) ?>"
disabled
>

<small class="muted">
Email changes are not enabled in this practical.
</small>
</div>

<div class="form-group">
<label>Account role</label>

<input
value="<?= h(ucfirst($user['role'])) ?>"
disabled
>
</div>

<button class="btn btn-primary">
Save changes
</button>

</form>
</div>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
