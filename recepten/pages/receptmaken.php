<?php
require_once("backend/functies.php");
sessionCheck();
?>

<html>
<?php require_once("head.php") ?>
<body>
<div class="wrapper">

	<?php require_once("header.php") ?>
    <main>
        <h2>Nieuw recept toevoegen</h2>
        <form action="backend/receptmakenbackend.php" method="post" onsubmit="return validate();" autocomplete="off">
            <label for="receptNaam">Recept naam:</label>
            <input type="text" name="receptNaam" id="receptNaam" class="controleerBestaan" required
                   pattern="\w+\s?\w+\s?\w+">
            <label for="receptOmschrijving">Recept omschrijving:</label>
            <input type="text" name="receptOmschrijving" id="receptOmschrijving" required>
            <label for="receptInstructies">Recept Instructies:</label>
            <textarea name="receptInstructies" id="receptInstructies" cols="40" rows="5" required></textarea>
            <div class="field_wrapper">
                <div>
                    <p>Ingrediënten:</p>
                    <a href="javascript:void(0);" class="add_button" title="Add field">
                        <button type="button">+</button>
                    </a>
                </div>
            </div>

            <div class="lol2">
                <div>
                    <p>Keukengerei:</p>
                    <a href="javascript:void(0);" class="add_button2" title="Add field">
                        <button type="button">+</button>
                    </a>
                </div>
            </div>
            <br>
            <br>
            <input type="submit" value="Submit">
        </form>
        <div class="bericht" id="bericht"><?php berichtBestaat(); ?></div>
    </main>
	<?php require_once("footer.php") ?>
</div>
<script type="text/javascript" src="backend/js/my.js"></script>
<script type="text/javascript" src="backend/js/jquery.autocomplete.min.js"></script>
<script>$('.bericht:empty').hide();</script>
<script type="text/javascript">
    function validate() {
        if ($('.sexy').length) {
            return true;
        } else {
            document.getElementById("bericht").innerHTML = 'Foutmelding: Een recept moet minimaal één ingredient hebben.'
            return false;
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
    });

</script>

</body>
</html>