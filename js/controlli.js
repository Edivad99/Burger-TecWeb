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
    let titolo = document.getElementById("new_title").value.trim();
    let data = document.getElementById("new_data").value;
    let luogo = document.getElementById("place").value.trim();
    let descrizione = document.getElementById("description").value.trim();

    let result = true;
    if(titolo.length <= 2) {
        console.log("titolo errore");
        result = false;
    }
    if(!controllaData(data)) {
        console.log("data errore");
        result = false;
    }
    if(luogo.length <= 2) {
        console.log("luogo errore");
        result = false;
    }
    if(descrizione.length <= 2) {
        console.log("descrizione errore");
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
