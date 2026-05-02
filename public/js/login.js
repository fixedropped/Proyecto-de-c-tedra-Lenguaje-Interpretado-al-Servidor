// LOGIN
document.getElementById("loginForm").addEventListener("submit", function(e){

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if(email === "" || password === ""){
        alert("Completa todos los campos");
        e.preventDefault();
    }
});

// REGISTRO
document.getElementById("registroForm").addEventListener("submit", function(e){

    let inputs = this.querySelectorAll("input");

    for(let input of inputs){
        if(input.value.trim() === ""){
            alert("Completa todos los campos del registro");
            e.preventDefault();
            return;
        }
    }

    if(inputs[2].value.length < 3){
        alert("La contraseña es muy corta");
        e.preventDefault();
    }
});