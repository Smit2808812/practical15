<?php

require_once __DIR__ . '/session_check.php';

requireLogin();

if (isAdmin()) {
header('Location: admin_dashboard.php');
exit;
}

$user = getCurrentUser();
$student = null;
$regs = [];
$attPct = 0;

$q = $pdo->prepare(
'SELECT * FROM students WHERE email = ? LIMIT 1'
);

$q->execute([$user['email']]);
$student = $q->fetch();

$q = $pdo->prepare(
'SELECT
r.id AS reg_id,
r.status AS reg_status,
e.title,
e.event_date,
e.venue
FROM registrations r
JOIN events e ON e.id = r.event_id
WHERE r.student_email = ?
ORDER BY e.event_date'
);

$q->execute([$user['email']]);
$regs = $q->fetchAll();

$q = $pdo->prepare(
'SELECT
SUM(attended_classes) a,
SUM(total_classes) t
FROM attendance
WHERE student_email = ?'
);

$q->execute([$user['email']]);
$a = $q->fetch();

if (($a['t'] ?? 0) > 0) {
$attPct = round($a['a'] / $a['t'] * 100, 1);
}

$pageTitle = 'My dashboard | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">STUDENT SPACE</span>

<h1 class="page-title">
Welcome back, <?= h($user['name']) ?>.
</h1>

<p class="lead">
Here’s your campus activity at a glance.
</p>
</div>
</section>

<section class="content">
<div class="container">

<div class="grid-3">
<div class="metric">
<strong><?= count($regs) ?></strong>
<span>Event registrations</span>
</div>

<div class="metric">
<strong><?= h($attPct) ?>%</strong>
<span>Attendance recorded</span>
</div>

<div class="metric">
<strong><?= h($student['course'] ?? 'CSE') ?></strong>
<span>Course</span>
</div>
</div>

<div class="section-head" style="margin-top: 30px">
<div>
<h2>Your event registrations</h2>
<p class="muted">
Events you have signed up for.
</p>
</div>

<a class="btn btn-primary" href="events.php">
Explore events
</a>
</div>

<div class="table-wrap">
<table>
<thead>
<tr>
<th>Event</th>
<th>Date</th>
<th>Venue</th>
<th>Status</th>
</tr>
</thead>

<tbody>
<?php foreach ($regs as $r): ?>
<tr>
<td><?= h($r['title']) ?></td>
<td><?= h($r['event_date']) ?></td>
<td><?= h($r['venue']) ?></td>
<td>
<span class="badge">
<?= h($r['reg_status']) ?>
</span>
</td>
</tr>
<?php endforeach; ?>

<?php if (!$regs): ?>
<tr>
<td colspan="4">
No registrations yet.
<a href="events.php">
Explore campus events
</a>.
</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
