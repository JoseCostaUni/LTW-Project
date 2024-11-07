<?php
class DB{
    private $dbh;
    function get_database_connection (){
        
        if($this->dbh == Null){
            try{
            $this->dbh = new PDO('sqlite:../database/database.db');
            $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo "failed to open database:", $e->getMessage();
        }
    }
    return $this->dbh;

    }
}
?>