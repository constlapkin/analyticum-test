$(document).ready(function() {
    /**
     * Responsible for updating data, called upon success post ajax.
     *
     * @param data
     * @returns {boolean}
     */
    function updateData(data) {
        var jsonData = JSON.parse(data);
        var htmlInsert = "".concat(
            '<div id="con-', jsonData.last_id, '">',
            ' - '.repeat(parseInt(jsonData.level) + 1), jsonData.last_id, '<br>',
            ' - '.repeat(parseInt(jsonData.level) + 1), jsonData.text, '<br>',
            '<form id="form_', jsonData.last_id, '">',
            '<textarea name="text_comment" form="form_', jsonData.last_id, '"></textarea>',
            '<input name="id_comment" type="hidden" value="', jsonData.last_id, '">',
            '<input name="level_comment" type="hidden" value="', parseInt(jsonData.level) + 1, '">',
            '<button type="submit" class="formclass">Отправить</button>',
            '</form>',
            '</div>'
        );
        var id = "".concat('#con-', jsonData.parent_id);
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