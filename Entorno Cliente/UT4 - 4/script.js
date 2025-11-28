let productos = [];

// referencias DOM
const fileInput = document.getElementById('fileInput');
const mensaje = document.getElementById('mensaje');
const selectProducto = document.getElementById('selectProducto');
const precioBox = document.getElementById('precio');

// listener para archivo
fileInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  if (!file) return;
   if (!file.type && !file.name.endsWith('.txt') && file.type !== 'text/plain') {
    mensaje.textContent = 'Por favor selecciona un archivo .txt.';
    return;
  }

  const reader = new FileReader();
  reader.onload = function(ev) {
    const text = ev.target.result;
    procesarTextoProductos(text);
  };
  reader.onerror = function() {
    mensaje.textContent = 'Error leyendo el archivo.';
  };
  reader.readAsText(file, 'UTF-8');
});

function procesarTextoProductos(texto) {
  productos = [];
  const lineas = texto.split(/\r?\n/);
  for (let raw of lineas) {
    const linea = raw.trim();
    if (linea === '') continue;
    const partes = linea.split(';');
    if (partes.length < 2) continue;
    const nombre = partes[0].trim();
    const precioStr = partes[1].trim().replace(',', '.');
    const precioNum = parseFloat(precioStr);
    if (!nombre || isNaN(precioNum)) continue;
    productos.push({ name: nombre, price: precioNum });
  }

  if (productos.length === 0) {
    mensaje.textContent = 'No se encontraron productos válidos en el fichero.';
    selectProducto.disabled = true;
    selectProducto.innerHTML = '<option value="">— fichero sin productos —</option>';
    precioBox.textContent = 'Precio: —';
    return;
  }
  rellenarSelect();
  mensaje.innerHTML = `<strong>${productos.length}</strong> producto(s) cargado(s).`;
}
function rellenarSelect() {
  selectProducto.innerHTML = '<option value="">-- Elige un producto --</option>';
  productos.forEach((p, i) => {
    const opt = document.createElement('option');
    opt.value = i;
    opt.textContent = p.name;
    selectProducto.appendChild(opt);
  });
  selectProducto.disabled = false;
  precioBox.textContent = 'Precio: —';
}
selectProducto.addEventListener('change', (e) => {
  const idx = e.target.value;
  if (idx === '') {
    precioBox.textContent = 'Precio: —';
    return;
  }
  const prod = productos[parseInt(idx, 10)];
  if (!prod) {
    precioBox.textContent = 'Precio: —';
    return;
  }
  precioBox.textContent = `Precio: ${prod.price.toFixed(2)} €`;
});
