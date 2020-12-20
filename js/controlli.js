function contaCaratteri() {
    const maxCaratteri = 500;

    let commento = document.getElementById("commento");
    let caratteriContatore = document.getElementById("caratteri");

    let lunghezza = commento.value.length;
    let caratteriRimasti = Math.max(0, maxCaratteri - lunghezza);

    caratteriContatore.innerHTML = caratteriRimasti;
    commento.value = commento.value.substring(0, Math.min(maxCaratteri, lunghezza));
};