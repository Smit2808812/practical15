<?php
require_once __DIR__ . '/../session_check.php';

$pageTitle = $pageTitle ?? 'Smit Campus Portal | Campus Portal';
$user = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta name="description" content="Smit Campus Portal modern campus management portal">

<title><?= h($pageTitle) ?></title>

<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="announcement">
✨ Smit Prajapati · Campus Portal
<span>Learn • Connect • Grow</span>
</div>

<header class="site-header">
<div class="nav-wrap">

<a class="brand" href="index.php">
<span class="brand-mark">SP</span>

<span>
Smit <span class="brand-accent">Campus</span>
<small>BY SMIT PRAJAPATI</small>
</span>
</a>

<button
class="menu-toggle"
id="menu-toggle"
aria-label="Toggle menu"
>
☰
</button>

<nav id="main-nav">

<a
class="<?= $currentPage === 'index.php' ? 'active' : '' ?>"
href="index.php"
>
Home
</a>

<a href="about.php">About</a>
<a href="courses.php">Courses</a>
<a href="events.php">Events</a>
<a href="notices.php">Notices</a>
<a href="faq.php">FAQ</a>
<a href="contact.php">Contact</a>

<?php if ($user): ?>

<a href="<?= isAdmin() ? 'admin_dashboard.php' : 'student_dashboard.php' ?>">
Dashboard
</a>

<a href="profile.php">Profile</a>
<a class="nav-cta" href="logout.php">Logout</a>

<?php else: ?>

<a href="login.php">Login</a>
<a class="nav-cta" href="register.php">
Get started ↗
</a>

<?php endif; ?>

</nav>

</div>
</header>

<?php if (!empty($_SESSION['flash'])): ?>

<?php
$f = $_SESSION['flash'];
unset($_SESSION['flash']);
?>

<div class="container">
<div class="alert alert-<?= h($f['type']) ?>">
<?= h($f['message']) ?>
</div>
</div>

<?php endif; ?>
