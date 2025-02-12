function validaFormEvento() {
    let errore = document.getElementById('datiNonCorretti');
    if (errore != null) {
        errore.remove();
    }
    let titolo = document.getElementById("titolo").value.trim();
    let data = document.getElementById("data-ora").value;
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

                let emptyOption = document.createElement("option");
                emptyOption.value = "";
                emptyOption.text = "Scegli una data";
                emptyOption.setAttribute("disabled", "");
                emptyOption.setAttribute("selected", "");
                selectOrari.add(emptyOption);

                for(let i = 0; i < dataArray.length; i++) {
                    let option = document.createElement("option");
                    option.value = dataArray[i];
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