function verMas(id){

    let fila = document.getElementById("mensaje-" + id);

    if(fila.style.display === "table-row"){
        fila.style.display = "none";
    } else {
        fila.style.display = "table-row";
    }
}