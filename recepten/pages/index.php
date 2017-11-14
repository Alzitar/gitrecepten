<html>

<?php require_once("head.php") ?>
<?php require_once("backend/functies.php") ?>

<body>
<div class="wrapper">
	<?php require_once("header.php") ?>
    <main>
        <h2>Recepten</h2>
		<?php
		getRecepten();
		?>
        <div class="bericht" id="bericht"><?php berichtBestaat(); ?></div>
    </main>
	<?php require_once("footer.php") ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.receptVerwijderButton').click(function (e) {
            e.preventDefault();
            if (confirm("Weet je zeker dat je dit recept wil verwijderen?")) {
                $(this).parent('div').remove();
                var clickBtnValue = $(this).val();
                var ajaxurl = 'backend/receptverwijder.php',
                    data = {'action': clickBtnValue};
                $.post(ajaxurl, data);
                document.getElementById("bericht").innerHTML = 'Het recept is verwijderd'
                $('.bericht').show();
            }
            return false;
        });
    });
</script>
<script type="text/javascript">$('.bericht:empty').hide();</script>
</body>
</html>