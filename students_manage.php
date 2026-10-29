<?php

require_once __DIR__ . '/session_check.php';

requireLogin();

if (!isAdmin()) {
http_response_code(403);
exit('Administrator access required.');
}

if (
$_SERVER['REQUEST_METHOD'] === 'POST' &&
verifyCSRF($_POST['csrf_token'] ?? '')
) {
$id = (int) ($_POST['id'] ?? 0);

$status = ($_POST['status'] ?? 'active') === 'inactive'
? 'inactive'
: 'active';

try {
$q = $pdo->prepare(
'UPDATE students SET status = ? WHERE id = ?'
);

$q->execute([$status, $id]);

flash('Student status updated.');

} catch (Throwable $e) {
flash('Could not update student.', 'danger');
}

header('Location: students_manage.php');
exit;
}

$rows = [];

try {
$rows = $pdo->query(
'SELECT
id,
student_id,
name,
email,
course,
semester,
status
FROM students
ORDER BY name'
)->fetchAll();

} catch (Throwable $e) {
}

$pageTitle = 'Manage students | Smit Campus Portal';

include __DIR__ . '/includes/header.php';
?>

<main>
<section class="page-hero">
<div class="container">
<span class="eyebrow">ADMIN TOOLS</span>

<h1 class="page-title">
Student records
</h1>

<p class="lead">
Review student profile details and activate or deactivate records.
</p>
</div>
</section>

<section class="content">
<div class="container">

<div class="table-wrap">
<table>
<thead>
<tr>
<th>Student ID</th>
<th>Name</th>
<th>Email</th>
<th>Course</th>
<th>Semester</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php foreach ($rows as $r): ?>
<tr>
<td><?= h($r['student_id']) ?></td>
<td><?= h($r['name']) ?></td>
<td><?= h($r['email']) ?></td>
<td><?= h($r['course']) ?></td>
<td><?= h($r['semester']) ?></td>
<td><?= h($r['status']) ?></td>

<td>
<form method="post">
<input
type="hidden"
name="csrf_token"
value="<?= h(csrfToken()) ?>"
>

<input
type="hidden"
name="id"
value="<?= h($r['id']) ?>"
>

<input
type="hidden"
name="status"
value="<?= $r['status'] === 'active' ? 'inactive' : 'active' ?>"
>

<button
class="btn btn-outline"
type="submit"
>
<?= $r['status'] === 'active' ? 'Deactivate' : 'Activate' ?>
</button>
</form>
</td>
</tr>
<?php endforeach; ?>

<?php if (!$rows): ?>
<tr>
<td colspan="7">
No student records available.
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
