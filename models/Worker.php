<?php

class Worker {
    //DB connfig
    private $conn;
    private $table = 'workers';

    //Worker Properties
    public $id;
    public $surname;
    public $name;
    public $lastname;
    public $position;
    public $salary;
    public $brigade_id = NULL;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
}