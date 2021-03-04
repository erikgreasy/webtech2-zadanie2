<?php

require_once 'model/Person.php';

require_once 'inc/Database.php';

class PersonController {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function index() {
        $sql = $this->conn->query( 'SELECT * FROM PERSONS' );
        $sql->setFetchMode(PDO::FETCH_CLASS, 'Person');
        $persons = $sql->fetchAll();

        return $persons;
    }
}