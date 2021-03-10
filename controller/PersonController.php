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
        $query = "SELECT persons.id, CONCAT(persons.name, ' ',persons.surname) as name, olympic_games.year, olympic_games.city, olympic_games.type, standings.discipline 
        FROM persons 
        LEFT JOIN standings ON persons.id = standings.person_id
        LEFT JOIN olympic_games ON olympic_games.id = standings.games_id";

        if( isset( $_GET['orderby'] ) && $_GET['orderby'] != '' ) {
            $orderby = $_GET['orderby'];
    
            switch($orderby) {
                case 'surname':
                    $query .= ' ORDER BY persons.surname';
                    break;
                case 'year':
                    $query .= ' ORDER BY olympic_games.year';
                    break;
                default:
                    $query .= ' ORDER BY persons.id';
                    break;
            }
    
            if( isset( $_GET['type_order'] ) ) {
                $query .= ', olympic_games.type';
            }

        } else {
            if( isset( $_GET['type_order'] ) ) {
                $query .= ' ORDER BY olympic_games.type';
            }
        }
    
        
        $sql = $this->conn->query( $query );
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $persons = $sql->fetchAll();

        return view( 'person.index.php', [
            'persons'   => $persons
        ] );
    }

    public function edit($id) {
        $sql = $this->conn->prepare( 'SELECT * FROM persons WHERE id = :id' );
        $sql->execute([
            'id'    => $id,
        ]);
        $person = $sql->fetch(PDO::FETCH_OBJ);

        return view( 'person.edit.php', [
            'person'    => $person
        ] );

    }

    public function show($id) {
        $sth = $this->conn->prepare("SELECT * FROM persons WHERE id = :id");
        $sth->execute( [
            'id'    => $id
        ] );
        $person = $sth->fetchAll(PDO::FETCH_CLASS, "Person")[0];

        return view( 'person.php', [
            'person'    => $person,
        ] );
    }
}