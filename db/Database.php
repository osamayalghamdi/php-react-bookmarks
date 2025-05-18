<?php

class Database {
    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbConnection;

    public function __construct()
    {
        $this->dbHost = getenv('DB_HOST');
        $this->dbPort = getenv('DB_PORT');
        $this->dbName = getenv('DB_DATABASE');
        $this->dbUser = getenv('DB_USERNAME');
        $this->dbPassword = getenv('DB_PASSWORD');

        if(!$this->dbHost || !$this->dbPort || !$this->dbName || !$this->dbUser || !$this->dbPassword){
            die("Please set database credentials as environment variables.");
        }
    }

    public function connect(){
        try{
            $dsn = "pgsql:host={$this->dbHost};port={$this->dbPort};dbname={$this->dbName};";
            $this->dbConnection = new PDO($dsn, $this->dbUser, $this->dbPassword);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            die("Connection Error: " . $e->getMessage());
        }
        return $this->dbConnection;
    }
}

