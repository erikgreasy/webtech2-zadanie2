<?php

require_once 'model/Standing.php';
require_once 'inc/Database.php';

class StandingController {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }


    /**
     * Display add new form
     */
    public function create() {
        $sql = $this->conn->query( "SELECT * FROM persons ORDER BY surname" );
        $persons = $sql->fetchAll( PDO::FETCH_CLASS, "Person" );

        $sql = $this->conn->query( "SELECT id, CONCAT( type, ' ', year, ' ', city  ) as name FROM olympic_games ORDER BY year" );
        $olympic_games = $sql->fetchAll( PDO::FETCH_OBJ );

        return view('standing.create.php', [
            'persons'       => $persons,
            'olympic_games' => $olympic_games,
        ]);
    }


    /**
     * Handles post on create form. Stores into db on success.
     */
    public function store() {

        $errors = [];

        if( $_POST['person'] == '' ) {
            $errors[] = 'Prosím vyberte športovca';
        }

        if( $_POST['olympic_games'] == '' ) {
            $errors[] = 'Prosím vyberte OH';
        }

        if( $_POST['standing'] == '' ) {
            $errors[] = 'Umiestnenie je povinné';
        }

        if( $_POST['standing'] < 0 ) {
            $errors[] = 'Umiestnenie musí byť väčšie alebo rovné 1';
        }

        if( $_POST['discipline'] == '' ) {
            $errors[] = 'Disciplína je povinná';
        }


        if( !empty($errors) ) {
            $sql = $this->conn->query( "SELECT * FROM persons ORDER BY surname" );
            $persons = $sql->fetchAll( PDO::FETCH_CLASS, "Person" );

            $sql = $this->conn->query( "SELECT id, CONCAT( type, ' ', year, ' ', city  ) as name FROM olympic_games ORDER BY year" );
            $olympic_games = $sql->fetchAll( PDO::FETCH_OBJ );


            return view('standing.create.php', [
                'errors'        => $errors,
                'persons'       => $persons,
                'olympic_games' => $olympic_games,
            ]);
        }
        
        $sql = $this->conn->prepare( "INSERT INTO standings(person_id, games_id, placing, discipline)
                                      VALUES( :person_id, :games_id, :placing, :discipline )" );
        $success = $sql->execute([
            'person_id'     => strip_tags( $_POST['person'] ),
            'games_id'      => strip_tags( $_POST['olympic_games'] ),
            'placing'       => strip_tags( $_POST['standing'] ),
            'discipline'    => strip_tags( $_POST['discipline'] ),
        ]);


        redirect(BASE_URL);
    }


}