function validaFormPanino() {
    let errore = document.getElementById('datiNonCorretti');
    if (errore != null) {
        errore.remove();
    }
    let nome = document.getElementById("nome").value.trim();
    let immagineFileName = document.getElementById("immagine").value;
    let ingred = document.getElementById("ingred").value.trim();
    let descrizione = document.getElementById("descrizione").value.trim();

    let result = true;
    if(nome.length <= 2) {
        document.getElementById("errore_nome").innerText = "Il nome è troppo corto!";
        result = false;
    }
    if(!verificaImmaginePNG(immagineFileName)) {
        document.getElementById("errore_immagine").innerText = "Il file selezionato non è un'immagine PNG";
        result = false;
    }
    if(ingred.lenght <= 2) {
        document.getElementById("errore_ingredienti").innerText ="Ingredienti è troppo corta"; //Da cambiare assolutamente
        result = false;
    }
    if(descrizione.length <= 2) {
        document.getElementById("errore_descrizione").innerText = "La descrizione è troppo corta!";
        result = false;
    }

    return result;
}

function verificaImmaginePNG(immagineFileName) {
    //Controllo se l'immagine caricata è un PNG
    if(immagineFileName.length > 0) {
        let idxDot = immagineFileName.lastIndexOf(".") + 1;
        let extFile = immagineFileName.substr(idxDot, immagineFileName.length).toLowerCase();
        return extFile == "png";
    }
    return false;
}

function nameChangedBurger() {
    let selectCategoria = document.getElementById("categoriaElimina");
    let selectPanini = document.getElementById("name");
    let index = selectCategoria.selectedIndex;

    let optionSelezionata = selectCategoria[index];

    let testo = optionSelezionata.value;

    fetch('php/api/getBurgerFromCategory.php?category=' + testo)
    .then(response => {
        if (!response.ok) {
            throw new Error('La pagina PHP non risponde');
        }
        return response.text();
    })
    .then(panino => {
        //console.log("RAW Response: " + panino);
        selectPanini.disabled = true;

        if(panino.length > 0) {
            let paninoArray = panino.split("#");
            selectPanini.innerHTML = "";

            if(paninoArray.length > 0) {
                selectPanini.disabled = false;

                for(let i = 0; i < paninoArray.length; i++) {
                    let option = document.createElement("option");
                    option.text = paninoArray[i];
                    selectPanini.add(option);
                }
            }
        }
    }).catch(error => {
        console.log(error);
        selectPanini.innerHTML = "";
        selectPanini.disabled = true;
    });
}