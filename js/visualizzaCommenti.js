let offset = 5;
function showMoreComments(user) {
    const limit = 5;

    fetch('php/api/getCommenti.php?user=' + user + '&offset=' + offset)
    .then(response => {
        if (!response.ok) {
            throw new Error('La pagina PHP non risponde');
        }
        return response.json();
    })
    .then(data => {
        let listaCommenti = document.getElementById("listaCommenti");

        if(data.length < limit) {
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

    let elimina = document.createElement("a");
    elimina.classList.add("elimina");
    elimina.href = "php/eliminaCommento.php?ID=" + data["CommentoID"];
    elimina.innerText = "Elimina";

    let commentoTag = document.createElement("p");
    commentoTag.classList.add("commentoText");
    commentoTag.innerText = data["Contenuto"];

    let header = document.createElement("header");
    header.appendChild(usernameTag);
    header.appendChild(elimina);
    header.appendChild(oraTag);

    let article = document.createElement("header");
    article.classList.add("commento");
    article.appendChild(header);
    article.appendChild(commentoTag);

    return article;

}
