<?php

namespace Comments;

/**
 * This class is responsible for all interactions with the database.
 *
 * @package Comments
 * @author Constantine M. Lapkin <constlapkin@gmail.com>
 */
class DB
{
    /**
     * @var \mysqli
     */
    protected $connection;

    /**
     * DB constructor.
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
     */
    public function __construct($host="localhost", $user="root", $password="", $db="analyticum")
    {
        $this->connection = new \mysqli($host, $user, $password, $db);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    /**
     * Fetch comments sorted by parent_id. An array is associated.
     *
     * @return bool|mixed
     */
    public function getAllComments()
    {
        $query = "SELECT * FROM comments ORDER BY parent_id ASC";
        if ($result = $this->connection->query($query)) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $result->close();
            return $data;
        }
        else {
            return false;
        }
    }

    /**
     * Fetch last existing id.
     *
     * @return bool|mixed
     */
    public function getLastId()
    {
        $new_id = false;
        $query = "SELECT MAX(id) FROM comments";
        if($result = $this->connection->query($query)) {
            $new_id = $result->fetch_row();
            $result->close();
        }
        return $new_id;
    }

    /**
     * @param $text
     * @param $id
     * @return bool
     */
    public function insertComment($text, $id)
    {
        $query = "INSERT INTO comments (text, parent_id) " .
            "VALUES ('" . $text . "', " . $id . ")";
        if ($this->connection->real_query($query) !== TRUE) {
            exit();
        }
        return true;
    }

    public function closeConnection()
    {
        if ($this->connection->close()) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
     * @return bool
     */
    public static function initDB($host="localhost", $user="root", $password="", $db="analyticum")
    {
        $connection = new \mysqli($host, $user, $password);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        $query = "CREATE DATABASE ". $db;
        if(!($result = $connection->query($query))){
            return false;
        }
        $connection->select_db($db);
        $query = "CREATE TABLE comments (" .
                                    "id INT NOT NULL AUTO_INCREMENT ," .
                                    "text TEXT NOT NULL," .
                                    "parent_id INT NOT NULL DEFAULT 0," .
                                    "PRIMARY KEY (id))";
        $result = $connection->query($query);
        return true;
    }

}