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
}