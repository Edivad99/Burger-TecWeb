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

    /*
    =================================
            Pagina Panino
    =================================
    */

    public function getPaninoById($id) {
        $checkID = mysqli_real_escape_string($this->connection, $id);

        $sql = "SELECT Prodotti.*, Categoria.Categoria AS 'CategoriaText'
                FROM Prodotti, Categoria
                WHERE Prodotti.ID = $checkID AND Prodotti.Categoria = Categoria.ID";
        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) != 1) {
            return null;
        }

        return mysqli_fetch_assoc($queryResult);
    }

    /* PANINO > Commenti */

    public function getCommentiPaninoById($id, $limit, $offset) {
        $checkID = mysqli_real_escape_string($this->connection, $id);

        $sql = "SELECT Utenti.Username, Commenti.*, DATE_FORMAT(Ora_Pubblicazione, '%H:%i:%s %d/%m/%Y') AS Ora_Post
                FROM Utenti, Commenti
                WHERE Commenti.ID_Panino = $checkID AND Commenti.ID_Utente = Utenti.ID
                ORDER BY Commenti.Ora_Pubblicazione DESC
                LIMIT $offset, $limit";

        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $commento = array(
                "Username" => $row["Username"],
                "DataOraPost" => $row["Ora_Post"],
                "Contenuto" => $row["Contenuto"]
            );

            array_push($result, $commento);
        }

        return $result;
    }

    public function getCommentiPaninoByIdJSON($id, $limit, $offset) {

        $result = $this->getCommentiPaninoById($id, $limit, $offset);
        return json_encode($result);
    }

    public function addCommentToPanino($IDPanino, $IDUtente, $OraPubblicazione, $Contenuto) {
        $checKOra = mysqli_real_escape_string($this->connection, $OraPubblicazione);
        $checKContenuto = mysqli_real_escape_string($this->connection, $Contenuto);

        $sql = "INSERT INTO Commenti (ID_Panino, ID_Utente, Ora_Pubblicazione, Contenuto) 
                VALUES ($IDPanino, $IDUtente, '$checKOra', '$checKContenuto')";

        return (mysqli_query($this->connection, $sql) === true);
    }

    /* PANINO > Voto */

    public function getVotiPaninoById($id) {
        $checkID = mysqli_real_escape_string($this->connection, $id);

        $sql = "SELECT ID_Utente, Username, Voto
                FROM Voti, Utenti
                WHERE Voti.ID_Utente = Utenti.ID AND Voti.ID_Panino = $checkID";
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

    /*
    =================================
            Pagina Menu
    =================================
    */

    public function getPaniniByCategoria($categoria) {
        $checkCategoria = mysqli_real_escape_string($this->connection, $categoria);

        $sql = "SELECT ID, Nome, Img
                FROM Prodotti
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
                FROM Categoria";
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

    /*
    =================================
            Pagina Eventi
    =================================
    */

    public function getEventi() {
        $sql = "SELECT Nome, DAYNAME(Data_Evento) Giorno, DATE_FORMAT(Data_Evento,'%d/%m/%Y %H:%i') AS Data_ev, Luogo_Evento, Descrizione
                FROM Eventi
                WHERE Data_Evento >= CURRENT_DATE
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

    /*
    =================================
            Pagina Login
    =================================
    */

    public function checkUserAndPassword($username, $password) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM Utenti
                WHERE BINARY UserName = '$checkUsername' AND BINARY Password = '$password'";

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

    public function checkUserIsAdmin($username) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM Utenti
                WHERE BINARY UserName = '$checkUsername'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 1) {
            $user = mysqli_fetch_assoc($queryResult);
            return ($user["Admin"] == 1);
        }
        return false;
    }

    public function createNewUser($username, $password) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "SELECT *
                FROM Utenti
                WHERE BINARY UserName = '$checkUsername'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 0) {
            //Non esiste nessun utente con questo username
            $sql = "INSERT INTO Utenti (Username, Password, Admin) 
                    VALUES ('$checkUsername','$password', 0)";

            return (mysqli_query($this->connection, $sql) === true);
        }
        return false;
    }

    public function changePassword($username, $vPassword, $nPassword) {
        $checkUsername = mysqli_real_escape_string($this->connection, $username);
        $sql = "UPDATE Utenti
                SET Password = '$nPassword'
                WHERE BINARY Username = '$checkUsername' AND BINARY Password = '$vPassword'";

        return (mysqli_query($this->connection, $sql) === true);
    }

    /*
    =================================
            Pagina Gestione Commenti
    =================================
    */

    public function getCommenti($user, $limit, $offset) {
        $extraFilter = "";
        if(!$this->checkUserIsAdmin($user)) {
            $checkUsername = mysqli_real_escape_string($this->connection, $user);
            $extraFilter = " AND Utenti.Username = '$checkUsername'";
        }

        $sql = "SELECT Utenti.Username, DATE_FORMAT(Ora_Pubblicazione, '%H:%i:%s %d/%m/%Y') AS DataOraPost, Contenuto, Prodotti.Nome AS Panino, Prodotti.ID AS PaninoID, Commenti.ID AS CommentoID
                FROM Utenti, Commenti, Prodotti
                WHERE Commenti.ID_Utente = Utenti.ID AND Commenti.ID_Panino = Prodotti.ID $extraFilter
                ORDER BY Commenti.Ora_Pubblicazione DESC
                LIMIT $offset, $limit";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $commento = array(
                "Username" => $row["Username"],
                "DataOraPost" => $row["DataOraPost"],
                "Contenuto" => $row["Contenuto"],
                "CommentoID" => $row["CommentoID"],
                "PaninoID" => $row["PaninoID"],
                "Panino" => $row["Panino"]
            );

            array_push($result, $commento);
        }

        return $result;
    }

    public function getCommentiJSON($user, $limit, $offset) {

        $result = $this->getCommenti($user, $limit, $offset);
        return json_encode($result);
    }

    public function deleteComment($idCommento, $idUtente) {
        $extraFilter = "";
        if($idUtente != -1) { //Utente normale
            $extraFilter = " AND ID_Utente = $idUtente";
        }

        $sql = "DELETE
                FROM Commenti
                WHERE ID = $idCommento $extraFilter";

        return (mysqli_query($this->connection, $sql) === true) && (mysqli_affected_rows($this->connection) == 1);
    }

    public function getCommentoById($idCommento) {
        $checkIDCommento = mysqli_real_escape_string($this->connection, $idCommento);
        $sql = "SELECT Commenti.ID, Commenti.ID_Panino, Username, Contenuto
                FROM Commenti, Utenti
                WHERE Commenti.ID = $checkIDCommento AND Id_Utente = Utenti.ID";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 1) {
            $commento = mysqli_fetch_assoc($queryResult);
            return array(
                "ID" => $commento["ID"],
                "ID_Panino" => $commento["ID_Panino"],
                "Username" => $commento["Username"],
                "Contenuto" => $commento["Contenuto"]
            );
        }
        return null;
    }

    public function updateCommentoById($idCommento, $testo) {
        $checkIDCommento = mysqli_real_escape_string($this->connection, $idCommento);
        $checkTesto= mysqli_real_escape_string($this->connection, $testo);

        $sql = "UPDATE Commenti
                SET Contenuto = '$checkTesto'
                WHERE Commenti.ID = $checkIDCommento";

        return (mysqli_query($this->connection, $sql) === true);
    }

    /*
    =================================
            Pagina Gestione Eventi
    =================================
    */

    public function createNewEvent($new_title, $data, $place, $description) {
        $checkTitle = mysqli_real_escape_string($this->connection, $new_title);
        $checkDate = mysqli_real_escape_string($this->connection, $data);
        $checkPlace = mysqli_real_escape_string($this->connection, $place);
        $checkDescription = mysqli_real_escape_string($this->connection, $description);
        $onlyDate = date("Y-m-d", strtotime($checkDate));
        $sql = "SELECT *
                FROM Eventi
                WHERE Nome = '$checkTitle' AND Data_Evento between '$onlyDate' and '$onlyDate 23:59:59'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 0) {
            $sql = "INSERT INTO Eventi (Nome, Data_Evento, Luogo_Evento, Descrizione)
                    VALUES ('$checkTitle', '$checkDate', '$checkPlace', '$checkDescription')";

            return (mysqli_query($this->connection, $sql) === true);
        }

        return false;
    }

    public function deleteEvent($title, $data) {
        $checkTitle = mysqli_real_escape_string($this->connection, $title);
        $checkDate = mysqli_real_escape_string($this->connection, $data);
        $sql = "SELECT *
                FROM Eventi
                WHERE Nome = '$checkTitle' AND Data_Evento between '$checkDate' and '$checkDate 23:59:59'";

        $queryResult = mysqli_query($this->connection, $sql);
        
        if(mysqli_num_rows($queryResult) == 1) {
            $sql = "DELETE
                    FROM Eventi
                    WHERE Nome = '$checkTitle' AND Data_Evento between '$checkDate' and '$checkDate 23:59:59'";

            return (mysqli_query($this->connection, $sql) === true);
        }

        return false;
    }

    public function getEventiDaCancellare() {
        $sql = "SELECT DISTINCT(Nome)
                FROM Eventi
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

    /* VENGONO MOSTRATE LE DATE PER SCEGLIERE L'EVENTO PRECISO CHE SI VUOLE ELIMINARE */
    public function getDateFromEvento($nomeEvento) {
        $checkNomeEvento = mysqli_real_escape_string($this->connection, $nomeEvento);
        $sql = "SELECT Data_Evento
                FROM Eventi
                WHERE Nome = '$checkNomeEvento'";
        $queryResult = mysqli_query($this->connection, $sql);

        $result = array();

        while($row = mysqli_fetch_assoc($queryResult)) {
            $opzione = array(
                "Data" => date("d-m-Y", strtotime($row["Data_Evento"]))
            );

            array_push($result, $opzione);
        }
        return $result;
    }

    /*
    =================================
            Pagina Gestione Panini
    =================================
    */

    public function createNewPanino($new_name, $image, $category, $ingredients, $description) {
        $checkName = mysqli_real_escape_string($this->connection, $new_name);
        $checkCategory = mysqli_real_escape_string($this->connection, $category);
        $checkIngredients = mysqli_real_escape_string($this->connection, $ingredients);
        $checkDescription = mysqli_real_escape_string($this->connection, $description);
        $sql = "SELECT *
                FROM Prodotti
                WHERE Nome = '$checkName'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 0) {
            $sql = "INSERT INTO Prodotti (Nome, Img, Categoria, Ingredienti, Descrizione)
                    VALUES ('$checkName', '$image', '$checkCategory', '$checkIngredients', '$checkDescription')";

            return (mysqli_query($this->connection, $sql) === true);
        }

        return false;
    }

    public function deletePanino($name) {
        $checkName = mysqli_real_escape_string($this->connection, $name);
        $sql = "SELECT Img
                FROM Prodotti
                WHERE Nome = '$checkName'";

        $queryResult = mysqli_query($this->connection, $sql);

        if(mysqli_num_rows($queryResult) == 1) {

            $img = mysqli_fetch_assoc($queryResult)["Img"];
            $sql = "DELETE
                    FROM Prodotti
                    WHERE Nome = '$checkName'";

            if(mysqli_query($this->connection, $sql) === true) {
                return $img;//Ritorno il percorso dell'immagine per cancellarla
            }
        }

        return false;
    }

    public function getBurgerFromCategory($category) {
        $checkCategory = mysqli_real_escape_string($this->connection, $category);
        $sql = "SELECT DISTINCT(Nome)
                FROM Prodotti
                WHERE Categoria = '$checkCategory'
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

}

?>