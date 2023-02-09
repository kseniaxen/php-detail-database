<?php

class Brigade {
    //DB connfig
    private $conn;
    private $table = 'brigades';

    //Brigade Properties
    public $id;
    public $shift;
    public $notes;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Brigades
    public function read() {
        
    }
}