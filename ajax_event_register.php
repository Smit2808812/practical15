<?php

require_once __DIR__ . '/session_check.php';

header('Content-Type: application/json; charset=utf-8');

function jsonResponse(
bool $success,
string $message,
int $status = 200
): void {
http_response_code($status);

echo json_encode([
'success' => $success,
'message' => $message
]);

exit;
}

/* Validate request method */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
jsonResponse(false, 'Invalid request method.', 405);
}

/* Check login status */

if (!isLoggedIn()) {
jsonResponse(false, 'Please log in before registering.', 401);
}

/* Only students can register */

if (isAdmin()) {
jsonResponse(
false,
'Student accounts are required to register for events.',
403
);
}

/* Verify CSRF token */

if (!verifyCSRF($_POST['csrf_token'] ?? '')) {
jsonResponse(
false,
'Security token expired. Refresh the page and try again.',
403
);
}

/* Validate event ID */

$eventId = filter_input(
INPUT_POST,
'event_id',
FILTER_VALIDATE_INT
);

if (!$eventId || $eventId < 1) {
jsonResponse(false, 'Please select a valid event.', 422);
}

try {

/* Check whether the event exists */

$q = $pdo->prepare(
'SELECT id, title, status
FROM events
WHERE id = ?
LIMIT 1'
);

$q->execute([$eventId]);

$event = $q->fetch();

if (!$event) {
jsonResponse(false, 'Event not found.', 404);
}

/* Check event registration status */

if ($event['status'] !== 'open') {
jsonResponse(
false,
'This event is not open for registration.',
409
);
}

/* Prevent duplicate registrations */

$q = $pdo->prepare(
'SELECT id
FROM registrations
WHERE event_id = ? AND student_email = ?
LIMIT 1'
);

$q->execute([
$eventId,
$_SESSION['email']
]);

if ($q->fetch()) {
jsonResponse(
false,
'You are already registered for this event.',
409
);
}

/* Insert registration into the database */

$q = $pdo->prepare(
"INSERT INTO registrations
(
event_id,
student_id,
student_name,
student_email,
status
)
VALUES (?, ?, ?, ?, 'registered')"
);

$q->execute([
$eventId,
$_SESSION['user_id'],
$_SESSION['name'],
$_SESSION['email']
]);

/* Return success response */

jsonResponse(
true,
'Registration successful! See you at the event.'
);

} catch (PDOException $e) {

error_log(
'Event registration error: ' . $e->getMessage()
);

if ($e->getCode() === '23000') {
jsonResponse(
false,
'You are already registered for this event.',
409
);
}

jsonResponse(
false,
'Unable to register. Please check the database setup.',
500
);

} catch (Throwable $e) {

error_log(
'Event registration error: ' . $e->getMessage()
);

jsonResponse(
false,
'Something went wrong. Please try again.',
500
);

}
