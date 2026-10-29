<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
session_set_cookie_params([
'httponly' => true,
'secure' => !empty($_SERVER['HTTPS']),
'samesite' => 'Lax'
]);

session_start();
}

require_once __DIR__ . '/db.php';

if (
isset($_SESSION['last_activity']) &&
time() - (int) $_SESSION['last_activity'] > 900
) {
$_SESSION = [];

session_destroy();

header('Location: login.php?error=timeout');
exit;
}

if (isset($_SESSION['user_id'])) {
$_SESSION['last_activity'] = time();
}

function isLoggedIn(): bool
{
return isset($_SESSION['user_id']);
}

function isAdmin(): bool
{
return ($_SESSION['role'] ?? '') === 'admin';
}

function getCurrentUser(): ?array
{
if (!isLoggedIn()) {
return null;
}

return [
'id' => $_SESSION['user_id'],
'name' => $_SESSION['name'],
'email' => $_SESSION['email'],
'role' => $_SESSION['role']
];
}

function requireLogin(): void
{
if (!isLoggedIn()) {
header('Location: login.php?error=unauthorized');
exit;
}
}

function csrfToken(): string
{
if (empty($_SESSION['csrf'])) {
$_SESSION['csrf'] = bin2hex(random_bytes(32));
}

return $_SESSION['csrf'];
}

function verifyCSRF(string $token): bool
{
return isset($_SESSION['csrf']) &&
hash_equals($_SESSION['csrf'], $token);
}

function h(mixed $value): string
{
return htmlspecialchars(
(string) $value,
ENT_QUOTES,
'UTF-8'
);
}

function flash(string $message, string $type = 'success'): void
{
$_SESSION['flash'] = [
'message' => $message,
'type' => $type
];
}
