<?php

require_once __DIR__ . '/session_check.php';

$pageTitle = 'Campus Events | Smit Campus Portal';

$events = [];

try {
$query = $pdo->query(
"SELECT * FROM events ORDER BY event_date ASC"
);

$events = $query->fetchAll();

} catch (Throwable $e) {
error_log(
'Events query failed: ' . $e->getMessage()
);
}

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">FIND YOUR PEOPLE</span>

<h1 class="page-title">
Campus events
</h1>

<p class="lead">
Workshops, meetups and experiences worth showing up for.
</p>
</div>
</section>

<section class="content">
<div class="container">
<div class="grid-3">

<?php foreach ($events as $event): ?>

<article class="card">

<span class="event-date">
<?= h(date(
'd M Y',
strtotime($event['event_date'])
)) ?>
</span>

<h3 style="margin-top: 12px">
<?= h($event['title']) ?>
</h3>

<p>
<?= h(
$event['description']
?? 'Join this campus activity and learn something new.'
) ?>
</p>

<p>
📍
<?= h($event['venue'] ?? 'Campus') ?>

<br>

<span class="badge">
<?= h($event['category'] ?? 'Campus') ?>
</span>
</p>

<?php if (isLoggedIn() && !isAdmin()): ?>

<form
method="post"
action="ajax_event_register.php"
class="ajax-register-form"
>
<input
type="hidden"
name="csrf_token"
value="<?= h(csrfToken()) ?>"
>

<input
type="hidden"
name="event_id"
value="<?= h($event['id']) ?>"
>

<button
class="btn btn-primary"
type="submit"
>
Register ↗
</button>

<p
class="ajax-message"
role="status"
aria-live="polite"
></p>
</form>

<?php elseif (!isLoggedIn()): ?>

<a
class="btn btn-outline"
href="login.php"
>
Login to register
</a>

<?php endif; ?>

</article>

<?php endforeach; ?>

<?php if (!$events): ?>

<div class="card empty">
<h3>No events published yet</h3>

<p>
Campus events will appear here after the
administrator adds them.
</p>
</div>

<?php endif; ?>

</div>
</div>
</section>
</main>

<script src="js/events_ajax.js" defer></script>

<?php
include __DIR__ . '/includes/footer.php';
?>
