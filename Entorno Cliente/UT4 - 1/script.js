document.getElementById("btnEj1").addEventListener("click", () => {
  let salida = document.getElementById("salidaEj1");
  salida.textContent = ""; // limpiar salida

  // 1. Crear array
  let elementos = ["Sol", "Luna", "Tierra", "Marte", "Venus", "Júpiter", "Saturno", "Urano", "Neptuno", "Plutón"];

  // 2. Mostrar todos los elementos
  salida.textContent += "Contenido inicial del array:\n" + elementos.join("\n") + "\n\n";

  // 3. Añadir un dato más mediante [longitud]
  elementos[elementos.length] = "Galaxia";

  // 4. Añadir dos datos más con un solo método
  elementos.push("Asteroide", "Cometa");

  // 5. Añadir un dato al principio
  elementos.unshift("Universo");

  // 6. Localizar un cierto dato
  let buscado = "Marte";
  let posicion = elementos.indexOf(buscado);
  salida.textContent += `Posición de "${buscado}": ${posicion}\n\n`;

  // 7. Eliminar los últimos tres datos
  elementos.splice(-3);

  // 8. Crear subarray (posición 4 a 8)
  let array_recortado = elementos.slice(4, 9);

  // 9. Crear nuevo array con datos en mayúsculas
  let elementos_MYCLS = elementos.map(e => e.toUpperCase());

  // Mostrar resultados
  salida.textContent += "Array final:\n" + elementos.join("\n") + "\n\n";
  salida.textContent += "Array recortado (4 a 8):\n" + array_recortado.join("\n") + "\n\n";
  salida.textContent += "Array en MAYÚSCULAS:\n" + elementos_MYCLS.join("\n") + "\n";
});
