const fecha = document.getElementById("fecha");
const password = document.querySelector("#password");
const telefono = document.getElementById("telefono");
const web = document.querySelector("#web");
const energia = document.getElementById("energia");

const resultado = document.getElementById("resultado");

document.getElementById("botonMostrar").addEventListener("click", mostrarDatos);

function mostrarDatos() {
    let texto = "";

    texto += "Fecha de nacimiento: " + fecha.value + "\n";
    texto += "Contraseña: " + password.value + "\n";
    texto += "Teléfono: " + telefono.value + "\n";
    texto += "Web personal: " + web.value + "\n";
    texto += "Nivel de energía: " + energia.value + "\n";

    resultado.textContent = texto;
}
