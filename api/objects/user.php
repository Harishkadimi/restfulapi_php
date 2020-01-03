<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "api";
 
    // object properties
    public $id;
    public $username;
    public $password;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function signup(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        
    
        
       $username=htmlspecialchars(strip_tags($this->username));
                             $password=htmlspecialchars(strip_tags($this->password));
                             $created=htmlspecialchars(strip_tags($this->created));
                         
                             
                             $query = "INSERT INTO
                                         api (username,password,created)
                                     values(
                                         '$username', '$password', '$created')";
                         
                             // prepare query
                             $stmt = $this->conn->prepare($query);
                             // execute query
                             if($stmt->execute()){
                                 $this->id = $this->conn->lastInsertId();
                                 return true;
                             }
     return false;
        
    }
    // login user
    function login(){
        // select all query
        $query = "SELECT
                    `id`, `username`, `password`, `created`
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}