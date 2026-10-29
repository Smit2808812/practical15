<?php
require_once __DIR__ . '/session_check.php';

requireLogin();

if (!isAdmin()) {
http_response_code(403);

flash('Admin access is required.', 'danger');

header('Location: student_dashboard.php');
exit;
}

$counts = [];

foreach (
[
'students' => 'students',
'events' => 'events',
'registrations' => 'registrations',
'inquiries' => 'contact_messages'
] as $label => $table
) {
try {
$counts[$label] = (int) $pdo
->query("SELECT COUNT(*) FROM `$table`")
->fetchColumn();
} catch (Throwable $e) {
$counts[$label] = 0;
}
}

$pageTitle = 'Admin dashboard | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>

<section class="page-hero">
<div class="container">

<span class="eyebrow">ADMINISTRATION</span>

<h1 class="page-title">
Campus control center.
</h1>

<p class="lead">
Manage student records, publish events and review incoming messages.
</p>

</div>
</section>

<section class="content">
<div class="container">

<div class="grid-3">

<?php
foreach (
[
'students' => 'Students',
'events' => 'Events',
'registrations' => 'Registrations',
'inquiries' => 'Inquiries'
] as $key => $label
):
?>

<div class="metric">

<strong>
<?= h($counts[$key] ?? 0) ?>
</strong>

<span>
<?= h($label) ?>
</span>

</div>

<?php endforeach; ?>

</div>

<div class="grid-3" style="margin-top: 25px;">

<a class="card" href="students_manage.php">

<div class="icon-box">♙</div>

<h3>Manage students</h3>

<p>
Review student records and account status.
</p>

</a>

<a class="card" href="events_manage.php">

<div class="icon-box">✦</div>

<h3>Manage events</h3>

<p>
Create and update campus event listings.
</p>

</a>

<a class="card" href="export_csv.php">

<div class="icon-box">⇩</div>

<h3>Export student CSV</h3>

<p>
Download student records for reporting.
</p>

</a>

</div>

</div>
</section>

</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
