<?php

require_once __DIR__ . '/session_check.php';

requireLogin();

if (!isAdmin()) {
http_response_code(403);
exit('Administrator access required.');
}

header('Content-Type: text/csv; charset=utf-8');

header(
'Content-Disposition: attachment; filename="smit-campus-students.csv"'
);

$out = fopen('php://output', 'w');

fputcsv($out, [
'Student ID',
'Name',
'Email',
'Course',
'Semester',
'Status'
]);

try {
$q = $pdo->query(
'SELECT student_id, name, email, course, semester, status
FROM students
ORDER BY name'
);

while ($r = $q->fetch(PDO::FETCH_NUM)) {
fputcsv($out, $r);
}

} catch (Throwable $e) {
}

fclose($out);

exit;
