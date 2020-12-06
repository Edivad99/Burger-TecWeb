<?php

namespace DB;

class DBAccess {

    private const HOST_DB = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DATABASE_NAME = "Burgheria";

    private $connection;

    public function openDBConnection() {
        $this->connection = mysqli_connect(DBAccess::HOST_DB,
                                           DBAccess::USERNAME,
                                           DBAccess::PASSWORD,
                                           DBAccess::DATABASE_NAME);

        //Forse bisogna sollevare un'eccezione?
        if(!$this->connection) {
            return false;
        } else {
            return true;
        }
    }

    public function closeDBConnection() {
        mysqli_close($this->connection);
    }
}

?>