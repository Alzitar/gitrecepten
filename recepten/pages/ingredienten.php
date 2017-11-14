<html>

<?php require_once("head.php") ?>

<body>
<div class="wrapper">
	<?php require_once("header.php") ?>
    <main>
        <h2>Ingrediënten</h2>
		<?php
		require_once("backend/functies.php");
		getIngredienten()
		?>
    </main>
	<?php require_once("footer.php") ?>
</div>
</body>
</html>

