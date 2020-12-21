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

function titleChangedEvent() {
    let selectEvento = document.getElementById("title");
    let selectOrari = document.getElementById("date");
    let index = selectEvento.selectedIndex;
    
    let optionSelezionata = selectEvento[index];

    let testo = optionSelezionata.value;
    //console.log(index);

    fetch('php/api/getDateFromEventi.php?nomeEvento=' + testo)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        //console.log("RAW Response: " + data);

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
            } else {
                selectOrari.disabled = true;
            }
        } else {
            selectOrari.disabled = true;
        }
    }).catch(error => {
        console.log(error);
        selectOrari.innerHTML = "";
        selectOrari.disabled = true;
    });
}
