<?php

require_once __DIR__ . '/session_check.php';

$pageTitle = 'Notices | Smit Campus Portal';

$notices = [
[
'Academic update',
'Check your course portal regularly for updated academic schedules and deadlines.',
'Academic'
],
[
'Campus opportunities',
'Keep an eye on the events page for workshops, talks and student activities.',
'Events'
],
[
'Account safety',
'Use a strong password and sign out when using a shared computer.',
'Important'
]
];

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">CAMPUS BULLETIN</span>

<h1 class="page-title">
Notices & updates
</h1>

<p class="lead">
Useful reminders to help you stay in the know.
</p>
</div>
</section>

<section class="content">
<div class="container grid-3">

<?php foreach ($notices as $n): ?>

<article class="card">
<span class="badge">
<?= h($n[2]) ?>
</span>

<h3 style="margin-top: 15px">
<?= h($n[0]) ?>
</h3>

<p>
<?= h($n[1]) ?>
</p>
</article>

<?php endforeach; ?>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
