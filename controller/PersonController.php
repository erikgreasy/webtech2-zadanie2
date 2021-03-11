<?php

require_once 'model/Person.php';
require_once 'inc/Database.php';

class PersonController {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    /**
     * Displays all persons with their olympic standings
     */
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


    /**
     * Displays edit form for person with $id
     */
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


    /**
     * Handles person update, updates in DB
     */
    public function update($id) {
        die('update');
    }


    /**
     * Show create new person form
     */
    public function create() {
        return view('person.create.php');
    }


    /**
     * Handles post on create form. Stores into db on success.
     */
    public function store() {
        $errors = [];

        if( $_POST['name'] == '' ) {
            $errors[] = 'Meno je povinná položka';
        }

        if( $_POST['surname'] == '' ) {
            $errors[] = 'Priezvisko je povinná položka';
        }

        if( $_POST['birth_day'] == '' ) {
            $errors[] = 'Dátum narodenia je povinná položka';
        }

        if( $_POST['birth_place'] == '' ) {
            $errors[] = 'Miesto narodenia je povinná položka';
        }

        if( $_POST['birth_country'] == '' ) {
            $errors[] = 'Krajina narodenia je povinná položka';
        }

        if( !empty($errors) ) {
            return view('person.create.php', [
                'errors'    => $errors
            ]);
        }
        // TODO - add death values
        // TODO - check if not exist
        $query = "INSERT INTO persons (name, surname, birth_day, birth_place, birth_country) 
                VALUES (:name, :surname, :birth_day, :birth_place, :birth_country)";
        $sql = $this->conn->prepare( $query );
        $result = $sql->execute( [
            'name'  => $_POST['name'],
            'surname'   => $_POST['surname'],
            'birth_day' => $_POST['birth_day'],
            'birth_place'   => $_POST['birth_place'],
            'birth_country' => $_POST['birth_country']
        ] );

        redirect(BASE_URL);
    }


    /**
     * Search for person with id and deletes on success.
     */
    public function delete($id) {

        $sql = $this->conn->prepare( 'DELETE FROM persons WHERE id = :id' );
        $sql->execute( [
            'id' => $id
        ] );
        
        
        $count = $sql->rowCount();

        redirect(BASE_URL);
    }


    /**
     * Displays detail of single person.
     */
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