<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <script src="js/ajax.js"></script>
    <title>Тестовое задание - Analyticum</title>
</head>
<body>
<?php
require_once 'src/Comments/DB.php';
require_once 'src/Comments/Wrapper.php';

$dbConnection = new Comments\DB();
?>
Your comment:
<form id="form_0">
    <textarea name="text_comment" form="form_0"></textarea>
    <input name="id_comment" type="hidden" value="0">
    <input name="level_comment" type="hidden" value="0">
    <button type="submit" class="formclass" type="button">Отправить</button>
</form>

<?
if ($data = $dbConnection->getAllComments()) {
    $comments = Comments\Wrapper::tree($data);
    Comments\Wrapper::printComment($comments);
}

?>
</body>
</html>



