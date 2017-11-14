$(document).ready(function () {
    var omfg = '';

    $.getJSON("json/maten.php", function (obj) {
        $.each(obj, function (key, value) {
            omfg += "<option>" + value.maat + "</option>";

        });
    });

    var maxField = 10;
    var addButton1 = $('.add_button');
    var wrapper = $('.field_wrapper');
    var x = 1;

    $(addButton1).click(function () {
        var fieldHTML = '<div class="sexy"><input type="text" name="ingredient[]" value="" placeholder="ingredient naam" class="autocomplete" autocomplete="off" required pattern="\\w+\\s?\\w+\\s?\\w+" title="Voer een ingredient in, kan alleen letters bevatten, maximaal drie woorden."/><input class="inline" type="text" name="hoeveelheid[]" value="" placeholder="hoeveelheid" autocomplete="off" required required pattern="[0-9]+(\.[0-9][0-9]?)?" title="Voer een hoeveelheid in cijfers in."/> <select name="maat[]" class="inline" required><option value="">Kies een maat</option>'
        fieldHTML += omfg;
        fieldHTML += '</select> <a href="javascript:void(0);" class="remove_button" title="Remove field"> <button type="button">-</button></a></div>';

        if (x < maxField) {
            x++;
            $(wrapper).append(fieldHTML);
            $.getJSON('json/ingredienten.php', function (data) {
                var arr = $.map(data, function (el) {
                    return el
                });
                $('.autocomplete').autocomplete({
                    lookup: arr
                });
            });
        }
    });
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
});


$(document).ready(function () {
    var maxField = 10;
    var addButton2 = $('.add_button2');
    var wrapper = $('.lol2');
    var fieldHTML2 = '<div class="sexy"><input type="text" name="keukengerei[]" value="" placeholder="Benodigd keukengerei" class="autocomplete2" autocomplete="off" required pattern="\\w+\\s?\\w+\\s?\\w+" /> <a href="javascript:void(0);" class="remove_button" title="Remove field"><button type="button">-</button></a></div>'; //New input field html
    var x = 1;
    $(addButton2).click(function () {
        if (x < maxField) {
            x++;
            $(wrapper).append(fieldHTML2);

            $.getJSON('json/keukengerei.php', function (data) {
                var arrr = $.map(data, function (el) {
                    return el
                });
                $('.autocomplete2').autocomplete({
                    lookup: arrr
                });
            });
        }
    });
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
});

