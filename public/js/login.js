document.getElementById("loginForm").addEventListener("submit", function(e){

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if(email === "" || password === ""){
        alert("Todos los campos son obligatorios");
        e.preventDefault();
        return;
    }

    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!regex.test(email)){
        alert("Correo inválido");
        e.preventDefault();
        return;
    }

    if(password.length < 3){
        alert("Contraseña muy corta");
        e.preventDefault();
        return;
    }

    // 🔍 DETECCIÓN VISUAL (solo consola)
    if(email.includes("admin")){
        console.log("Intento de acceso como ADMIN");
    } else {
        console.log("Intento de acceso como USUARIO");
    }

});