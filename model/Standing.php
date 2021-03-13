<?php

class Standing {
    
    private $id;
    private $person_id;
    private $games_id;
    private $placing;
    private $discipline;

    public function getId() {
        return $this->id;
    }


    /**
     * Get the value of placing
     */ 
    public function getPlacing()
    {
        return $this->placing;
    }
}