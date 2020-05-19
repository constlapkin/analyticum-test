$(document).ready(function() {
    /**
     * Responsible for updating data, called upon success post ajax.
     *
     * @param data
     * @returns {boolean}
     */
    function updateData(data) {
        var arData = data.split(' ');
        var htmlInsert = "".concat(
            '<div id="con-', arData[3], '">',
            ' - '.repeat(parseInt(arData[2]) + 1), arData[3], '<br>',
            ' - '.repeat(parseInt(arData[2]) + 1), arData[1], '<br>',
            '<form id="form_', arData[3], '">',
            '<textarea name="text_comment" form="form_', arData[3], '"></textarea>',
            '<input name="id_comment" type="hidden" value="', arData[3], '">',
            '<input name="level_comment" type="hidden" value="', parseInt(arData[2]) + 1, '">',
            '<button type="submit" class="formclass">Отправить</button>',
            '</form>',
            '</div>'
        );
        var id = "".concat('#con-', arData[0]);
        if (id == "#con-0") {
            $('body').append(htmlInsert);
        }
        $(id).after(htmlInsert);
        return true;
    }

    /**
     * Setting event listener for objects that have not even been created. For forms to be submitted by ajax.
     */
    document.addEventListener("submit", function(e) {
        e.preventDefault();
        var form = $(e.target).closest('form');
        $.ajax({
            type: 'post',
            url: 'addcomment.php',
            async: false,
            data: form.serialize(),
            success: function(data) {
                updateData(data);
                return true;
            }
        });
        form.find('textarea').val('');
        return false;
    });
});