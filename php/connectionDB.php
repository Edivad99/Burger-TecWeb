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

    public function getPaninoById($id) {
        $checkID = mysqli_real_escape_string($this->connection, $id);

        $sql = "SELECT prodotti.*, categoria.Categoria AS 'CategoriaText'
                FROM prodotti, categoria 
                WHERE prodotti.ID = $checkID AND prodotti.Categoria = categoria.ID";
        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) != 1) {
            return null;
        }

        return mysqli_fetch_assoc($queryResult);
    }

    public function getCommentiPaninoById($id) {
        $checkID = mysqli_real_escape_string($this->connection, $id);

        $sql = "SELECT utenti.Username, commenti.*
                FROM utenti, commenti
                WHERE commenti.ID_Panino = $checkID AND commenti.ID_Utente = utenti.ID
                ORDER BY commenti.Ora_Pubblicazione DESC";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $commento = array(
                "Username" => $row["Username"],
                "ID_Username" => $row["ID_Utente"],
                "DataOraPost" => date_create_from_format('Y-m-d H:i:s', $row["Ora_Pubblicazione"]),
                "Contenuto" => $row["Contenuto"]
            );

            array_push($result, $commento);
        }

        return $result;
    }

    public function getPaniniByCategoria($categoria) {
        $checkCategoria = mysqli_real_escape_string($this->connection, $categoria);

        $sql = "SELECT ID, Nome, Img
                FROM prodotti
                WHERE Categoria = $checkCategoria";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $panino = array(
                "ID" => $row["ID"],
                "Nome" => $row["Nome"],
                "Img" => $row["Img"]
            );

            array_push($result, $panino);
        }

        return $result;
    }

    public function getCategorie() {
        $sql = "SELECT *
                FROM categoria";
        $queryResult = mysqli_query($this->connection, $sql);

        $categorie = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $categoria = array(
                "ID" => $row["ID"],
                "Categoria" => $row["Categoria"]
            );

            array_push($categorie, $categoria);
        }

        $result = array(
            "result" => $categorie,
            "IDMax" => end($categorie)["ID"]
        );

        return $result;
    }

    public function getEventi() {
        $sql = "SELECT Nome, Data_Luogo_Evento, Descrizione
                FROM eventi";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $evento = array(
                "Nome" => $row["Nome"],
                "Data_Luogo_Evento" => $row["Data_Luogo_Evento"],
                "Descrizione" => $row["Descrizione"]
            );

            array_push($result, $evento);
        }

        return $result;
    }

    public function checkUserAndPassword($username, $password) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM utenti
                WHERE UserName = '$checkUsername' AND Password = '$password'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 1) {
            $user = mysqli_fetch_assoc($queryResult);
            $isAdmin = $user["Admin"] == 1;

            return array(
                "isValid" => true,
                "isAdmin" => $isAdmin,
                "username" => $user["Username"],
                "usernameID" => $user["ID"]
            );
        }
        return array(
            "isValid" => false,
            "isAdmin" => false,
            "username" => null,
            "usernameID" => -1
        );
    }

    public function createNewUser($username, $password) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM utenti
                WHERE UserName = '$checkUsername'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 0) {
            //Non esiste nessun utente con questo username
            $sql = "INSERT INTO `utenti`(`Username`, `Password`, `Admin`) 
                    VALUES ('$checkUsername','$password', 0)";

            return (mysqli_query($this->connection, $sql) === true);
        }
        return false;
    }
}

?>