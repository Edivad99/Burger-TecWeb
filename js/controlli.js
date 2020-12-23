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
