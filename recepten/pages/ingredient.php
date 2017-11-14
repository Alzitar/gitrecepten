<html>

<?php require_once("head.php") ?>

<body>
<div class="wrapper">
	<?php require_once("header.php") ?>
    <main>
        <h2>Ingredient komt voor in:</h2>
		<?php
		require_once("backend/functies.php");
		getIngredient()
		?>
    </main>
	<?php require_once("footer.php") ?>
</div>
</body>
</html>

