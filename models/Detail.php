<?php

class Detail {
    //DB connfig
    private $conn;
    private $table = 'details';

    //Detail Properties
    public $id;
    public $title;
    public $date;
    public $quality;
    public $brigade_id;
    public $notes;
    public $worker_id;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
}