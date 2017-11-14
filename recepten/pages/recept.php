<html>

<?php require_once("head.php") ?>

<body>
<div class="wrapper">
	<?php require_once("header.php") ?>
    <main>
		<?php
		require_once("backend/functies.php");
		getRecept();
		?>
    </main>
	<?php require_once("footer.php") ?>
</div>
</body>
</html>


