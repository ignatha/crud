<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

class Model
{
    public $con;

    public function con()
    {
        $this->con = new Connect;
        return $this->con;
    }
}