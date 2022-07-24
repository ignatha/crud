<?php

class Connect
{
    public function db()
    {
        $host = "localhost";
        $dbname = "shopee";
        $username = "root";
        $password = "";
        $result = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);

        return $result;
    }

}
