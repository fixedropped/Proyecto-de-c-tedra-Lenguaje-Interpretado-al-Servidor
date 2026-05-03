// LOGIN - Validación del lado del cliente
document.getElementById("loginForm").addEventListener("submit", function(e){

    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if(email === "" || password === ""){
        alert("❌ Completa todos los campos para iniciar sesión");
        e.preventDefault();
        return;
    }

    // Validar formato de email con expresión regular
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(email)){
        alert("❌ El formato del correo no es válido");
        e.preventDefault();
        return;
    }
});

// REGISTRO - Validación del lado del cliente
let registroForm = document.getElementById("registroForm");
if(registroForm){
    registroForm.addEventListener("submit", function(e){

        let inputs = this.querySelectorAll("input");
        let nombre = inputs[0].value.trim();
        let email = inputs[1].value.trim();
        let password = inputs[2].value.trim();

        // Validar campos vacíos
        if(nombre === "" || email === "" || password === ""){
            alert("❌ Completa todos los campos del registro");
            e.preventDefault();
            return;
        }

        // Validar longitud de contraseña
        if(password.length < 6){
            alert("❌ La contraseña debe tener al menos 6 caracteres");
            e.preventDefault();
            return;
        }

        // Validar formato de email
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(email)){
            alert("❌ El formato del correo no es válido");
            e.preventDefault();
            return;
        }

        // Validar nombre (solo letras y espacios)
        let nombreRegex = /^[a-zA-ZáéíóúñÑÁÉÍÓÚ\s]{2,100}$/;
        if(!nombreRegex.test(nombre)){
            alert("❌ El nombre solo puede contener letras y espacios");
            e.preventDefault();
            return;
        }

        // Validar teléfono si se ingresó
        let telefono = inputs[3].value.trim();
        if(telefono !== ""){
            let telefonoRegex = /^[0-9\-\(\)\/\+]{8,15}$/;
            if(!telefonoRegex.test(telefono)){
                alert("❌ El teléfono debe tener entre 8 y 15 dígitos");
                e.preventDefault();
                return;
            }
        }
    });
}