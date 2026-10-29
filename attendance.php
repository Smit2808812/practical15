<?php

require_once __DIR__ . '/session_check.php';

requireLogin();

$user = getCurrentUser();
$email = $user['email'];

$records = [];

try {
$q = $pdo->prepare(
'SELECT subject, attended_classes, total_classes
FROM attendance
WHERE student_email = ?
ORDER BY subject'
);

$q->execute([$email]);
$records = $q->fetchAll();

} catch (Throwable $e) {
}

$total = 0;
$attended = 0;

foreach ($records as $r) {
$total += (int) $r['total_classes'];
$attended += (int) $r['attended_classes'];
}

$pct = $total
? round($attended / $total * 100, 1)
: 0;

$pageTitle = 'Attendance | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">STAY ON TRACK</span>

<h1 class="page-title">
Attendance overview
</h1>

<p class="lead">
Your recorded attendance, subject by subject.
</p>
</div>
</section>

<section class="content">
<div class="container">

<div class="grid-3">
<div class="metric">
<strong><?= h($pct) ?>%</strong>
<span>Overall attendance</span>
</div>

<div class="metric">
<strong><?= h($attended) ?></strong>
<span>Classes attended</span>
</div>

<div class="metric">
<strong><?= h($total) ?></strong>
<span>Total classes</span>
</div>
</div>

<div class="table-wrap" style="margin-top: 24px">
<table>
<thead>
<tr>
<th>Subject</th>
<th>Attended</th>
<th>Total classes</th>
<th>Percentage</th>
</tr>
</thead>

<tbody>
<?php
foreach ($records as $r):

$p = $r['total_classes']
? round(
$r['attended_classes'] /
$r['total_classes'] * 100,
1
)
: 0;
?>

<tr>
<td>
<?= h($r['subject']) ?>
</td>

<td>
<?= h($r['attended_classes']) ?>
</td>

<td>
<?= h($r['total_classes']) ?>
</td>

<td>
<span class="badge">
<?= h($p) ?>%
</span>
</td>
</tr>

<?php endforeach; ?>

<?php if (!$records): ?>
<tr>
<td colspan="4">
No attendance records have been
added for this account yet.
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
