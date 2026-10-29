<?php

require_once __DIR__ . '/session_check.php';

$pageTitle = 'FAQs | Smit Campus Portal';

$faqs = [
[
'How do I create an account?',
'Open Register, enter your details and choose a password with at least eight characters.'
],
[
'I cannot sign in. What should I do?',
'Check your email and password. If the issue continues, contact the portal administrator.'
],
[
'How can I register for an event?',
'Sign in using a student account, open Events and select Register on an open event.'
],
[
'Where can I check my attendance?',
'Sign in and open Attendance from the navigation menu. Records appear after they have been added for your account.'
],
[
'Can I access Smit Campus Portal on my phone?',
'Yes. The interface adjusts to mobile, tablet and desktop screen sizes.'
]
];

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">HELP CENTER</span>

<h1 class="page-title">
Questions? We’ve got answers.
</h1>

<p class="lead">
A few quick answers to common Smit Campus Portal questions.
</p>
</div>
</section>

<section class="content">
<div class="container" style="max-width: 850px">

<?php foreach ($faqs as $i => $f): ?>

<div class="faq-item">
<button
class="faq-question"
type="button"
>
<?= h($f[0]) ?>

<span>＋</span>
</button>

<div class="faq-answer">
<?= h($f[1]) ?>
</div>
</div>

<?php endforeach; ?>

</div>
</section>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
