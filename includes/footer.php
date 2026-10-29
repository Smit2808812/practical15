<footer class="footer">
<div class="container footer-grid">

<div>
<a class="brand footer-brand" href="index.php">
<span class="brand-mark">S</span>
<span>
Student<span class="brand-accent">Hub</span>
<small>CAMPUS PORTAL</small>
</span>
</a>

<p>
A smarter space for campus life, learning and opportunities.
</p>
</div>

<div>
<h3>Explore</h3>
<a href="courses.php">Courses</a>
<a href="events.php">Campus events</a>
<a href="notices.php">Notices</a>
</div>

<div>
<h3>Support</h3>
<a href="faq.php">FAQs</a>
<a href="contact.php">Contact us</a>
<a href="about.php">About Smit Campus Portal</a>
</div>

<div>
<h3>Academic details</h3>
<p>ITUE203 · Web Development Frameworks</p>
<p>CSPIT, CHARUSAT</p>
</div>

</div>

<div class="footer-bottom">
© <?= date('Y') ?> Smit Campus Portal · Practical 15
</div>
</footer>

<script src="js/main.js"></script>

<?php if (!empty($extraScript)): ?>
<script src="<?= h($extraScript) ?>"></script>
<?php endif; ?>

</body>
</html>
