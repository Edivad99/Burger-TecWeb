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
            mysqli_query($this->connection, "SET lc_time_names = 'it_IT'");
            return true;
        }
    }

    public function closeDBConnection() {
        if($this->connection)
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

    public function addCommentToPanino($IDPanino, $IDUtente, $OraPubblicazione, $Contenuto)
    {
        $checKOra = mysqli_real_escape_string($this->connection, $OraPubblicazione);
        $checKContenuto = mysqli_real_escape_string($this->connection, $Contenuto);

        $sql = "INSERT INTO commenti (ID_Panino, ID_Utente, Ora_Pubblicazione, Contenuto) 
                VALUES ($IDPanino, $IDUtente, '$checKOra', '$checKContenuto')";

        return (mysqli_query($this->connection, $sql) === true);
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

    public function getVotiPaninoById($id) {
        $checkID = mysqli_real_escape_string($this->connection, $id);

        $sql = "SELECT ID_Utente, Username, Voto
                FROM voti,utenti
                WHERE voti.ID_Utente = utenti.ID AND voti.ID_Panino = $checkID";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $commento = array(
                "Username" => $row["Username"],
                "ID_Username" => $row["ID_Utente"],
                "Voto" => $row["Voto"]
            );
            array_push($result, $commento);
        }

        return $result;
    }

    public function setVotoPaninoById($idPanino, $idUtente, $voto) {
        $sql = "INSERT INTO Voti (ID_Panino, ID_Utente, Voto)
                VALUES ($idPanino, $idUtente, $voto)";

        return (mysqli_query($this->connection, $sql) === true);
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

    public function getCommenti($limit, $offset) {
        $sql = "SELECT utenti.Username, DATE_FORMAT(Ora_Pubblicazione, '%Y-%m-%d %H:%i:%s') AS DataOraPost, Contenuto
                FROM utenti, commenti
                WHERE commenti.ID_Utente = utenti.ID
                ORDER BY commenti.Ora_Pubblicazione DESC
                LIMIT $offset, $limit";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $commento = array(
                "Username" => $row["Username"],
                "DataOraPost" => $row["DataOraPost"],
                "Contenuto" => $row["Contenuto"]
            );

            array_push($result, $commento);
        }

        return $result;
    }

    public function getCommentiJSON($limit, $offset) {

        $result = $this->getCommenti($limit, $offset);
        return json_encode($result);
    }

    public function getEventi() {
        $sql = "SELECT Nome, DAYNAME(Data_Evento) Giorno, DATE_FORMAT(Data_Evento,'%d/%m/%Y') AS Data_ev, Luogo_Evento, Descrizione
                FROM eventi
                WHERE Data_Evento > CURRENT_DATE
                ORDER BY Data_Evento";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $evento = array(
                "Nome" => $row["Nome"],
                "Giorno" => $row["Giorno"],
                "Data_ev" => $row["Data_ev"],
                "Luogo_Evento" => $row["Luogo_Evento"],
                "Descrizione" => $row["Descrizione"]
            );

            array_push($result, $evento);
        }

        return $result;
    }

    public function getOpzioni() {
        $sql = "SELECT DISTINCT(Nome)
                FROM eventi
                ORDER BY Nome";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $opzione = array(
                "Nome" => $row["Nome"]
            );

            array_push($result, $opzione);
        }

        return $result;
    }

    public function getDateFromEvento($nomeEvento) {
        $checkNomeEvento = mysqli_real_escape_string($this->connection, $nomeEvento);
        $sql = "SELECT Data_Evento
                FROM eventi
                WHERE Nome = '$checkNomeEvento'";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $opzione = array(
                "Data" => $row["Data_Evento"]
            );

            array_push($result, $opzione);
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
            $sql = "INSERT INTO utenti (Username, Password, Admin) 
                    VALUES ('$checkUsername','$password', 0)";

            return (mysqli_query($this->connection, $sql) === true);
        }
        return false;
    }

    public function createNewEvent($new_title, $data, $place, $description) {
        $checkTitle = mysqli_real_escape_string($this->connection, $new_title);
        $checkDate = mysqli_real_escape_string($this->connection, $data);
        $checkPlace = mysqli_real_escape_string($this->connection, $place);
        $checkDescription = mysqli_real_escape_string($this->connection, $description);
        $sql = "SELECT *
                FROM eventi
                WHERE Nome = '$checkTitle' AND Data_Evento = '$checkDate'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 0) {
            $sql = "INSERT INTO `eventi`(`Nome`, `Data_Evento`, `Luogo_Evento`, `Descrizione`)
                    VALUES ('$checkTitle', '$checkDate', '$checkPlace', '$checkDescription')";

            return (mysqli_query($this->connection, $sql) === true);
        }

        return false;
    }

    public function deleteEvent($title, $data) {
        $checkTitle = mysqli_real_escape_string($this->connection, $title);
        $checkDate = mysqli_real_escape_string($this->connection, $data);
        $sql = "SELECT *
                FROM eventi
                WHERE Nome = '$checkTitle' AND Data_Evento = '$checkDate'";

        $queryResult = mysqli_query($this->connection, $sql);
        
        if(mysqli_num_rows($queryResult) == 1) {
            $sql = "DELETE
                    FROM eventi
                    WHERE Nome = '$checkTitle' AND Data_Evento = '$checkDate'";

            return (mysqli_query($this->connection, $sql) === true);
        }

        return false;
    }

}

?>