<?php

require_once 'model/Person.php';
require_once 'model/Standing.php';
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
        $query = "SELECT persons.id, CONCAT(persons.surname, ' ',persons.name) as name, olympic_games.year, olympic_games.city, olympic_games.type, standings.placing, standings.discipline 
        FROM persons 
        LEFT JOIN standings ON persons.id = standings.person_id
        LEFT JOIN olympic_games ON olympic_games.id = standings.games_id";

        if( isset( $_GET['orderby'] ) && $_GET['orderby'] != '' ) {
            
                
            $orderby = $_GET['orderby'];
    
            switch($orderby) {
                case 'surname':
                    $query .= ' ORDER BY persons.surname';
                    if( isset( $_GET['ordersurname'] ) && ( $_GET['ordersurname'] == 'ASC' || $_GET['ordersurname'] == 'DESC' ) ) {
                        $query .= ' ' . $_GET['ordersurname'];
                    }
                    break;
                case 'year':
                    $query .= ' ORDER BY olympic_games.year IS NULL, olympic_games.year';
                    if( isset( $_GET['orderyear'] ) && ( $_GET['orderyear'] == 'ASC' || $_GET['orderyear'] == 'DESC' ) ) {
                        $query .= ' ' . $_GET['orderyear'];
                    }
                    break;
                default:
                    $query .= ' ORDER BY persons.id';
                    break;
            }
            
            if( isset( $_GET['type_order'] ) && $_GET['type_order'] == 'type' ) {
                $query .= ', olympic_games.type';
            }

        } else {
            if( isset( $_GET['type_order'] ) ) {
                $query .= ' ORDER BY olympic_games.type IS NULL, olympic_games.type ASC';
            }
        }
    
        
        $sql = $this->conn->query( $query );
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $persons = $sql->fetchAll();

        $query = "SELECT persons.id, CONCAT(persons.surname, ' ',persons.name) as name, COUNT(persons.id) as win_count
        FROM persons 
        LEFT JOIN standings ON persons.id = standings.person_id
        LEFT JOIN olympic_games ON olympic_games.id = standings.games_id
        WHERE standings.placing = 1
        GROUP BY persons.id
        ORDER BY win_count DESC, name ASC
        LIMIT 10";
        $sql = $this->conn->query( $query );
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $top_ten = $sql->fetchAll();

        return view( 'person.index.php', [
            'persons'   => $persons,
            'top_ten'   => $top_ten,
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

        // VALIDATION
        $errors = [];

        // NAME
        if( $_POST['name'] == '' ) {
            $errors[] = 'Meno je povinná položka';
        }

        // SURNAME
        if( $_POST['surname'] == '' ) {
            $errors[] = 'Priezvisko je povinná položka';
        }

        // BIRTH DAY
        if( $_POST['birth_day'] == '' ) {
            $errors[] = 'Dátum narodenia je povinná položka';
        } else if( ! strtotime( $_POST['birth_day'] ) ) {
            $errors[] = 'Zlý formát dátumu';
        } else if( strtotime($_POST['birth_day']) > time() ) {
            $errors[] = 'Dátum narodenia nemôže byť v budúcnosti';
        }

        // BIRTH PLACE
        if( $_POST['birth_place'] == '' ) {
            $errors[] = 'Miesto narodenia je povinná položka';
        }

        // BIRTH COUNTRY
        if( $_POST['birth_country'] == '' ) {
            $errors[] = 'Krajina narodenia je povinná položka';
        }

        // DEATH DAY
        if( strtotime($_POST['death_day']) && strtotime($_POST['death_day']) < strtotime($_POST['birth_day']) ) {
            $errors[] = 'Dátum úmrtia nemôže byť skôr ako dátum narodenia';
        } else if( strtotime($_POST['death_day']) > time() ) {
            $errors[] = 'Dátum úmrtia nemôže byť v budúcnosti';
        }

        $sql = $this->conn->prepare( 'SELECT * FROM persons WHERE id = :id' );
        $sql->execute([
            'id'    => $id,
        ]);
        $person = $sql->fetch(PDO::FETCH_OBJ);

        if( !empty($errors) ) {
            return view('person.edit.php', [
                'errors'    => $errors,
                'person'    => $person, 
            ]);
        }

        $insert_query = "UPDATE persons
                         SET name = :name, 
                             surname = :surname,
                             birth_day = :birth_day,
                             birth_place = :birth_place,
                             birth_country = :birth_country,
                             death_day = :death_day,
                             death_place = :death_place,
                             death_country = :death_country
                         WHERE id = :id";

        // DB INSERT
        $sql = $this->conn->prepare( $insert_query );
        $success = $sql->execute([
            'name'              => strip_tags( $_POST['name'] ),
            'surname'           => strip_tags( $_POST['surname'] ),
            'birth_day'         => strip_tags( date('d.m.Y', strtotime($_POST['birth_day']) ) ),
            'birth_place'       => strip_tags( $_POST['birth_place'] ),
            'birth_country'     => strip_tags( $_POST['birth_country'] ),
            'death_day'         => strtotime($_POST['death_day']) ? strip_tags( date('d.m.Y', strtotime($_POST['death_day']) ) ) : null,
            'death_place'       => isset($_POST['death_place']) ? strip_tags( $_POST['death_place'] ) : null,
            'death_country'     => isset($_POST['death_country']) ? strip_tags( $_POST['death_country'] ) : null,
            'id'                => $id
        ]);

        // REDIRECT TO UPDATED PERSON
        $GLOBALS['msg']->success('Športovec úspešne upravený');
        redirect( BASE_URL . '/persons/' . $id );
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

        // VALIDATION
        $errors = [];

        // NAME
        if( $_POST['name'] == '' ) {
            $errors[] = 'Meno je povinná položka';
        }

        // SURNAME
        if( $_POST['surname'] == '' ) {
            $errors[] = 'Priezvisko je povinná položka';
        }

        // BIRTH DAY
        if( $_POST['birth_day'] == '' ) {
            $errors[] = 'Dátum narodenia je povinná položka';
        } else if( ! strtotime( $_POST['birth_day'] ) ) {
            $errors[] = 'Zlý formát dátumu';
        } else if( strtotime($_POST['birth_day']) > time() ) {
            $errors[] = 'Dátum narodenia nemôže byť v budúcnosti';
        }

        // BIRTH PLACE
        if( $_POST['birth_place'] == '' ) {
            $errors[] = 'Miesto narodenia je povinná položka';
        }

        // BIRTH COUNTRY
        if( $_POST['birth_country'] == '' ) {
            $errors[] = 'Krajina narodenia je povinná položka';
        }

        // DEATH DAY
        if( strtotime($_POST['death_day']) && strtotime($_POST['death_day']) < strtotime($_POST['birth_day']) ) {
            $errors[] = 'Dátum úmrtia nemôže byť skôr ako dátum narodenia';
        } else if( strtotime($_POST['death_day']) > time() ) {
            $errors[] = 'Dátum úmrtia nemôže byť v budúcnosti';
        }

        // VALIDATION NOT SUCCESSFUL
        if( !empty($errors) ) {
            return view('person.create.php', [
                'errors'    => $errors
            ]);
        }

        // Check if user already in DB, if so, return error
        $exists_query = "SELECT id FROM persons WHERE name = :person_name AND surname = :surname";
        $sql = $this->conn->prepare( $exists_query );
        $sql->execute([
            'person_name'      => $_POST['name'],
            'surname'   => $_POST['surname']
        ]);
        
        if( $sql->rowCount() ) {
            $errors[] = 'Zadaný športovec už v databáze existuje';
            return view('person.create.php', [
                'errors'    => $errors
            ]);
        }


        // EVERYTHING'S GOOD, LET's PUT THAT SON OF A SNITCH TO DB
        $query = "INSERT INTO persons (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) 
                VALUES (:name, :surname, :birth_day, :birth_place, :birth_country, :death_day, :death_place, :death_country)";
        $sql = $this->conn->prepare( $query );
        $result = $sql->execute( [
            'name'          => strip_tags( $_POST['name'] ),
            'surname'       => strip_tags( $_POST['surname'] ),
            'birth_day'     => strip_tags( date('d.m.Y', strtotime($_POST['birth_day']) ) ),
            'birth_place'   => strip_tags( $_POST['birth_place'] ),
            'birth_country' => strip_tags( $_POST['birth_country'] ),
            'death_day'     => strtotime($_POST['death_day']) ? strip_tags( date('d.m.Y', strtotime($_POST['death_day']) ) ) : null,
            'death_place'   => strip_tags( $_POST['death_place'] ),
            'death_country' => strip_tags( $_POST['death_country'] ),

        ] );

        $GLOBALS['msg']->success('Športovec úspešne pridaný');
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
        
        $GLOBALS['msg']->success('Športovec úspešne vymazaný');
        redirect(BASE_URL);
    }


    /**
     * Displays detail of single person.
     */
    public function show($id) {

        // GET PERSON
        $sth = $this->conn->prepare("SELECT * FROM persons WHERE id = :id");
        $sth->execute( [
            'id'    => $id
        ] );
        $person = $sth->fetchAll(PDO::FETCH_CLASS, "Person")[0];

        // GET HIS STANDINGS
        $sql = $this->conn->prepare( "SELECT standings.placing, standings.discipline, og.year, og.city, og.type FROM standings
                                      LEFT JOIN olympic_games as og ON og.id = standings.games_id
                                      WHERE person_id = :person_id" );
        $sql->execute([
            'person_id' => $id
        ]);
        $standings = $sql->fetchAll( PDO::FETCH_OBJ );

        return view( 'person.php', [
            'person'    => $person,
            'standings' => $standings,
        ] );
    }
}