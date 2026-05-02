document.getElementById("loginForm").addEventListener("submit", function(e){

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    // Validación básica
    if(email === "" || password === ""){
        alert("Todos los campos son obligatorios");
        e.preventDefault();
        return;
    }

    // Validar formato de correo
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!regex.test(email)){
        alert("Correo inválido");
        e.preventDefault();
        return;
    }

    // Validar contraseña
    if(password.length < 6){
        alert("La contraseña debe tener al menos 6 caracteres");
        e.preventDefault();
        return;
    }
});