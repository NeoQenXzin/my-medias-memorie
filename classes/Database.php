<?php

class Database
{
    private $host = 'unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
    private $dbname = 'bibliotheque';
    private $username = 'root';
    private $password = '';
    private $connexion;

    public function __construct()
    {
        try {
            $this->connexion = new PDO("mysql:{$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "vous etes connecté";
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connexion;
    }
}
