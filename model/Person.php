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

    // public function __construct( $name, $surname ) {
    //     $this->name = $name;
    //     $this->surname = $surname;
    //     // $this->birth_day = $birth_day;
    //     // $this->birth_place = $birth_place;
    //     // $this->birth_country = $birth_country;
    //     // $this->death_day = $death_day;
    //     // $this->death_place = $death_place;
    //     // $this->death_country = $death_country;
    // }

    // public function jsonSerialize()
    // {
    // 	return get_object_vars($this);
    // }
}