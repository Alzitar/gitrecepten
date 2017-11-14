<html>

<?php require_once("head.php") ?>
<?php require_once("backend/functies.php") ?>

<body>
<div class="wrapper">
	<?php require_once("header.php") ?>


    <main>
        <h2>Registratie</h2>

        <form action="backend/registratie.php" method="post">
            <div class="form-group">
                <label for="voornaam">Voornaam:</label>
                <input type="text" name="voornaam" id="voornaam" required pattern="[A-Za-z]+" autofocus
                       title="Vul uw voornaam in (kan geen cijfers bevatten)" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="achternaam">Achternaam:</label>
                <input type="text" name="achternaam" id="achternaam" required pattern="[A-Za-z]+"
                       title="Vul uw achternaam in (kan geen cijfers bevatten)" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email adres:</label>
                <input class="forming" type="email" name="email" id="email" required
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                       title="Vul een email adres in." autocomplete="off">
            </div>
            <div class="form-group">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" name="wachtwoord" id="wachtwoord"
                       required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                       title="Moet minimaal 1 hoofdletter en 1 kleine letter en een cijfer bevatten, en op zijn minst 8 karakters lang zijn."
                       autocomplete="off">
            </div>
            <button type="submit" class="btn btn-default" name="submit">Registreren</button>
            <div class="bericht"><?php berichtBestaat(); ?></div>
        </form>

    </main>

	<?php require_once("footer.php") ?>
</div>
<script type="text/javascript">$('.bericht:empty').hide();</script>
</body>
</html>