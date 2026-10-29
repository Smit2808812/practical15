<?php

require_once __DIR__ . '/session_check.php';

$pageTitle = 'Smit Campus Portal | Your Campus, Connected';

include __DIR__ . '/includes/header.php';
?>

<main>

<section class="hero">
<div class="container hero-grid">

<div>
<span class="eyebrow">
✦ YOUR CAMPUS, CONNECTED
</span>

<h1>
Make campus life <span>count.</span>
</h1>

<p class="lead">
One simple place to discover courses, join exciting
campus events, keep track of attendance and stay in the loop.
</p>

<div class="actions">
<a class="btn btn-primary" href="events.php">
Explore events ↗
</a>

<a class="btn btn-outline" href="courses.php">
Browse courses
</a>
</div>

<div class="metric-row">
<div class="metric">
<strong>01</strong>
<span>Campus hub</span>
</div>

<div class="metric">
<strong>24/7</strong>
<span>Access online</span>
</div>

<div class="metric">
<strong>∞</strong>
<span>Ways to grow</span>
</div>
</div>
</div>

<div class="hero-art">
<div class="art-label">
SMIT PRAJAPATI / CAMPUS LIFE
</div>

<div class="art-number">
Hello,<br>
future.
</div>

<div class="art-card">
<span>YOUR NEXT CHAPTER</span>

<strong>
Learn something. Meet someone. Build something.
</strong>

<small>
Everything starts with showing up.
</small>
</div>
</div>

</div>
</section>

<section class="section">
<div class="container">

<div class="section-head">
<div>
<span class="eyebrow">BUILT FOR STUDENTS</span>

<h2>
Everything in one place.
</h2>

<p class="muted">
Less searching, more doing. Your everyday campus essentials.
</p>
</div>
</div>

<div class="grid-3">

<a class="card" href="courses.php">
<div class="icon-box">▤</div>

<h3>Academic courses</h3>

<p>
Explore subjects, course details and academic information.
</p>

<b>View course catalog ↗</b>
</a>

<a class="card" href="events.php">
<div class="icon-box">✦</div>

<h3>Events & activities</h3>

<p>
Discover workshops, coding sessions, talks and campus events.
</p>

<b>Find your next event ↗</b>
</a>

<a class="card" href="attendance.php">
<div class="icon-box">◷</div>

<h3>Attendance tracking</h3>

<p>
Check attendance records and keep your semester on track.
</p>

<b>Check attendance ↗</b>
</a>

<a class="card" href="notices.php">
<div class="icon-box">⌁</div>

<h3>Campus notices</h3>

<p>
Keep up with important announcements and updates.
</p>

<b>Read notices ↗</b>
</a>

<a class="card" href="faq.php">
<div class="icon-box">?</div>

<h3>Quick answers</h3>

<p>
Find helpful answers to common portal questions.
</p>

<b>Browse FAQs ↗</b>
</a>

<a class="card" href="contact.php">
<div class="icon-box">✉</div>

<h3>Support desk</h3>

<p>
Send a question or share feedback with the campus team.
</p>

<b>Get in touch ↗</b>
</a>

</div>
</div>
</section>

</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
