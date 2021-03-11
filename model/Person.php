<?php

class Person {
    
    private $id;
    private $name;
    private $surname;
    private $birth_day;
    private $birth_place;
    private $birth_country;
    private $death_day;
    private $death_place;
    private $death_country;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getFullName() {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * Get the value of birth_day
     */ 
    public function getBirthDay()
    {
        return $this->birth_day;
    }

   

    

    /**
     * Get the value of birth_place
     */ 
    public function getBirthPlace()
    {
        return $this->birth_place;
    }

    /**
     * Get the value of birth_country
     */ 
    public function getBirthCountry()
    {
        return $this->birth_country;
    }


     /**
     * Get the value of death_country
     */ 
    public function getDeathCountry()
    {
        return $this->death_country;
    }

    /**
     * Get the value of death_place
     */ 
    public function getDeathPlace()
    {
        return $this->death_place;
    }

    /**
     * Get the value of death_day
     */ 
    public function getDeathDay()
    {
        return $this->death_day;
    }
}