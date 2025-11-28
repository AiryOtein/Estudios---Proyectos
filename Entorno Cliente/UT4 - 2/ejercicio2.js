document.getElementById("fichero").addEventListener("change", (event) => {
  const archivo = event.target.files[0]; // Guardamos el fichero elegido
  const salida = document.getElementById("salida");

  if (!archivo) return; // Si no se seleccionó nada, salimos
    const lector = new FileReader(); // Creamos un objeto lector de archivos

  lector.onload = function(e) {
    let contenido = e.target.result; // Guardamos todo el texto del archivo

    // Creamos un array vacío
    let datos = new Array();

    // Dividimos el contenido por líneas, usando '\n' como separador
    datos = contenido.split('\n');

    // Mostramos el contenido del array por pantalla
    salida.textContent = "Contenido del fichero cargado en array:\n\n";
    salida.textContent += datos.join("\n");
  };

  // Leemos el archivo como texto plano
  lector.readAsText(archivo);
});
