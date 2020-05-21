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
     * @var \PDO
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
        $charset = "utf8";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $this->connection = new \PDO($dsn, $user, $password, $opt);
    }

    /**
     * Fetch comments sorted by parent_id. An array is associated.
     *
     * @return bool|mixed
     */
    public function getAllComments()
    {
        $query = "SELECT * FROM comments ORDER BY parent_id DESC";
        if ($result = $this->connection->query($query)) {
            $data = $result->fetchAll();
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
        $new_id = array(200);
        $query = "SELECT MAX(id) FROM comments";
        if($result = $this->connection->query($query)) {
            $new_id = $result->fetch(\PDO::FETCH_NUM);
        }
        return $new_id[0];
    }

    /**
     * @param $text
     * @param $id
     * @return bool
     */
    public function insertComment($text, $id)
    {
        $q = $this->connection->prepare("INSERT INTO comments (text, parent_id) VALUES (:text, :id)");
        $text = htmlentities($text);
        $q->execute(array('text' => $text, 'id' => $id));
        return true;
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
        $connection->query("CREATE DATABASE " . $db);
        $connection->query("USE ". $db);
        $query = "CREATE TABLE comments (" .
            "id INT NOT NULL AUTO_INCREMENT ," .
            "text TEXT NOT NULL," .
            "parent_id INT NOT NULL DEFAULT 0," .
            "PRIMARY KEY (id))";
        $connection->query($query);
        return true;
    }

}