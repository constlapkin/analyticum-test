<?php
require_once 'src/Comments/DB.php';

/**
 * With the POST method, it connects to the database, adds a comment and returns the necessary data.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_comment']) && isset($_POST['text_comment'])) {

        $dbConnection = new Comments\DB();
        if(!$dbConnection->insertComment($_POST['text_comment'], $_POST['id_comment'])) {
            echo 'error';
            die();
        }
        $new_id = $dbConnection->getLastId();

        $arData = [
            'parent_id' => $_POST['id_comment'],
            'text' => $_POST['text_comment'],
            'level' => $_POST['level_comment'],
            'last_id' => $new_id,
        ];

        echo json_encode($arData);
    }
}





