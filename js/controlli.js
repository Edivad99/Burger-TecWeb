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