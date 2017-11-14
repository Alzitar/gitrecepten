<html>
<?php require_once("backend/functies.php") ?>
<?php require_once("head.php") ?>
<?php sessionCheckLogin(); ?>

<body>
<div class="wrapper">
	<?php require_once("header.php") ?>
    <main>
        <h2>Login:</h2>

        <form action="?page=login_uitkomst" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required autofocus autocomplete="off">
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord:</label>
                <input type="password" name="wachtwoord" id="wachtwoord" required
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-default" name="submit">Login</button>
        </form>
        <div class="bericht"><?php berichtBestaat(); ?></div>
    </main>
	<?php require_once("footer.php") ?>
</div>
<script>$('.bericht:empty').hide();</script>
</body>
</html>