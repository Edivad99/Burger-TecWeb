const maxCaratteri = 400;

function contaCaratteri() {
    let commento = document.getElementById("commento");
    let caratteriContatore = document.getElementById("caratteri");

    let lunghezza = commento.value.length;
    let caratteriRimasti = Math.max(0, maxCaratteri - lunghezza);

    caratteriContatore.innerHTML = caratteriRimasti;
    commento.value = commento.value.substring(0, Math.min(maxCaratteri, lunghezza));
}

function validaCommento() {
    let commento = document.getElementById("commento");
    let lunghezza = commento.value.trim().length;

    const messaggio = "Controlla la lunghezza del testo!";

    let result = lunghezza >= 2 && lunghezza <= maxCaratteri;
    if(!result)
        document.getElementById("erroreForm").innerText = messaggio;
    return result;
}

function validaFormEvento() {
    let errore = document.getElementById('datiNonCorretti');
    if (errore != null) {
        errore.remove();
    }
    let titolo = document.getElementById("titolo").value.trim();
    let data = document.getElementById("data").value;
    let luogo = document.getElementById("luogo").value.trim();
    let descrizione = document.getElementById("descrizione").value.trim();

    let result = true;
    if(titolo.length <= 2) {
        document.getElementById("errore_titolo").innerText = "Il titolo è troppo corto!";
        result = false;
    }
    if(!controllaData(data)) {
        document.getElementById("errore_data").innerText = "Hai inserito una data del passato!";
        result = false;
    }
    if(luogo.length <= 2) {
        document.getElementById("errore_luogo").innerText = "Il luogo è troppo corto!";
        result = false;
    }
    if(descrizione.length <= 2) {
        document.getElementById("errore_descrizione").innerText = "La descrizione è troppo corta!";
        result = false;
    }

    return result;
}

function controllaData(dataIns) {
    let data = new Date(dataIns);
    let oggi = new Date();
    oggi.setHours(0,0,0,0);

    return data >= oggi;
}

function titleChangedEvent() {
    let selectEvento = document.getElementById("title");
    let selectOrari = document.getElementById("date");
    let index = selectEvento.selectedIndex;

    let optionSelezionata = selectEvento[index];

    let testo = optionSelezionata.value;

    fetch('php/api/getDateFromEventi.php?nomeEvento=' + testo)
    .then(response => {
        if (!response.ok) {
            throw new Error('La pagina PHP non risponde');
        }
        return response.text();
    })
    .then(data => {
        //console.log("RAW Response: " + data);
        selectOrari.disabled = true;

        if(data.length > 0) {
            let dataArray = data.split("#");
            selectOrari.innerHTML = "";

            if(dataArray.length > 0) {
                selectOrari.disabled = false;

                for(let i = 0; i < dataArray.length; i++) {
                    let option = document.createElement("option");
                    option.text = dataArray[i];
                    selectOrari.add(option);
                }
            }
        }
    }).catch(error => {
        console.log(error);
        selectOrari.innerHTML = "";
        selectOrari.disabled = true;
    });
}

let offset = 5;
function addNewComment() {

    fetch('php/api/getCommenti.php?offset=' + offset)
    .then(response => {
        if (!response.ok) {
            throw new Error('La pagina PHP non risponde');
        }
        return response.json();
    })
    .then(data => {
        let listaCommenti = document.getElementById("listaCommenti");

        if(data.length == 0) {
            document.getElementById("caricaCommenti").remove();
        }


        for(let i = 0; i < data.length; i++) {
            let commento = buildCommento(data[i]);
            listaCommenti.appendChild(commento);
        }
        offset += 5;

    }).catch(error => {
        console.log(error);
    });
}

function buildCommento(data) {
    let link = document.createElement("a");
    link.href = "panino.php?ID=" + data["PaninoID"];
    link.innerText = data["Panino"];

    let usernameTag = document.createElement("h4");
    usernameTag.classList.add("commentoUser");
    usernameTag.innerText = data["Username"] + " - ";
    usernameTag.appendChild(link);

    let oraTag = document.createElement("p");
    oraTag.classList.add("commentoOra");
    oraTag.innerText = "Il " + data["DataOraPost"];

    let commentoTag = document.createElement("p");
    commentoTag.classList.add("commentoText");
    commentoTag.innerText = data["Contenuto"];

    let header = document.createElement("header");
    header.appendChild(usernameTag);
    header.appendChild(oraTag);

    let article = document.createElement("header");
    article.classList.add("commento");
    article.appendChild(header);
    article.appendChild(commentoTag);

    return article;

}
