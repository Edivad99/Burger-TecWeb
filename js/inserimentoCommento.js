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