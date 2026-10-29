<?php

require_once __DIR__ . '/session_check.php';

$pageTitle = 'Courses | Smit Campus Portal';

$courses = [
[
'ITUE203',
'Web Development Frameworks',
'CSE',
3,
4,
'HTML, CSS, JavaScript, PHP and database-driven applications.'
],
[
'ITUE204',
'Computer Networks',
'CSE',
3,
4,
'Network models, addressing, routing and data communication.'
],
[
'ITUE205',
'Object Oriented Programming',
'CSE',
3,
4,
'Classes, objects, inheritance, polymorphism and exception handling.'
],
[
'ITUE206',
'Data Structures & Algorithms',
'CSE',
3,
4,
'Problem-solving techniques, data organization and algorithm analysis.'
],
[
'ITUE207',
'Professional Communication',
'Common',
3,
2,
'Communication skills for teamwork, presentations and technical work.'
],
[
'ITUE208',
'Database Fundamentals',
'CSE',
3,
3,
'Relational data, SQL queries, normalization and database design.'
]
];

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">LEARN WITH PURPOSE</span>

<h1 class="page-title">
Course catalog
</h1>

<p class="lead">
A quick overview of sample third-semester subjects.
</p>
</div>
</section>

<section class="content">
<div class="container">

<div class="grid-3">
<?php foreach ($courses as $c): ?>

<article class="card">
<span class="badge">
<?= h($c[0]) ?>
</span>

<h3 style="margin-top: 16px">
<?= h($c[1]) ?>
</h3>

<p>
<?= h($c[5]) ?>
</p>

<p>
<strong>Department:</strong>
<?= h($c[2]) ?>
<br>

<strong>Semester:</strong>
<?= h($c[3]) ?>

·

<strong>Credits:</strong>
<?= h($c[4]) ?>
</p>
</article>

<?php endforeach; ?>
</div>

<p class="muted">
Note: This is sample catalog content for the practical;
replace it with your official syllabus if required.
</p>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
