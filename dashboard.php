<?php
/**
* Practical 15: Central Dashboard Router
* Student: Ayush chodvadiya (25cs005) | ITUE203: Web Development Frameworks
*/
declare(strict_types=1);
require_once __DIR__ . '/session_check.php';

requireLogin();

if (isAdmin()) {
header("Location: admin_dashboard.php");
} else {
header("Location: student_dashboard.php");
}
exit;
