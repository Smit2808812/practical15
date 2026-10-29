<?php

require_once __DIR__ . '/session_check.php';

requireLogin();

if (!isAdmin()) {
http_response_code(403);
exit('Administrator access required.');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if (!verifyCSRF($_POST['csrf_token'] ?? '')) {
$errors[] = 'Security validation failed.';

} else {

$title = trim($_POST['title'] ?? '');
$date = $_POST['event_date'] ?? '';
$venue = trim($_POST['venue'] ?? '');
$category = trim($_POST['category'] ?? 'Workshop');
$description = trim($_POST['description'] ?? '');

if ($title === '' || $date === '' || $venue === '') {
$errors[] = 'Title, date and venue are required.';
}

if (!$errors) {
try {
$q = $pdo->prepare(
"INSERT INTO events
(
title,
event_date,
venue,
category,
description,
status
)
VALUES (?, ?, ?, ?, ?, 'open')"
);

$q->execute([
$title,
$date,
$venue,
$category,
$description
]);

flash('Event published successfully.');

header('Location: events_manage.php');
exit;

} catch (Throwable $e) {
$errors[] = 'Could not save event. Check the database schema.';
}
}
}
}

$events = [];

try {
$events = $pdo->query(
'SELECT id, title, event_date, venue, category, status
FROM events
ORDER BY event_date DESC'
)->fetchAll();

} catch (Throwable $e) {
}

$pageTitle = 'Manage events | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">ADMIN TOOLS</span>

<h1 class="page-title">
Event studio
</h1>

<p class="lead">
Publish new opportunities for the campus community.
</p>
</div>
</section>

<section class="content">
<div class="container grid-2">

<div class="card">
<h3>Create an event</h3>

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
<label>Event title</label>
<input name="title" required>
</div>

<div class="form-row">
<div class="form-group">
<label>Date</label>
<input
type="date"
name="event_date"
required
>
</div>

<div class="form-group">
<label>Category</label>

<select name="category">
<option>Workshop</option>
<option>Hackathon</option>
<option>Seminar</option>
<option>Cultural</option>
<option>Sports</option>
</select>
</div>
</div>

<div class="form-group">
<label>Venue</label>
<input name="venue" required>
</div>

<div class="form-group">
<label>Description</label>
<textarea
name="description"
rows="4"
></textarea>
</div>

<button class="btn btn-primary">
Publish event ↗
</button>

</form>
</div>

<div>
<h2>Published events</h2>

<?php foreach ($events as $e): ?>
<article
class="card"
style="margin-bottom: 13px"
>
<span class="event-date">
<?= h($e['event_date']) ?>
</span>

<h3 style="margin-top: 8px">
<?= h($e['title']) ?>
</h3>

<p>
<?= h($e['venue']) ?>
·
<?= h($e['category']) ?>
</p>
</article>
<?php endforeach; ?>

<?php if (!$events): ?>
<div class="card empty">
No events yet.
</div>
<?php endif; ?>
</div>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
