let alumnos = [];
let candidatos = [];
let turno = 1;
const MAX_VOTOS = 20;


class Alumno {
  constructor(nombre) {
    this.nombre = nombre;
    this.votos = 0;
  }

  votar() {
    this.votos++;
  }
}

const btnCargar = document.getElementById("btnCargar");
const infoAlumnos = document.getElementById("infoAlumnos");
const listaCandidatos = document.getElementById("listaCandidatos");
const zonaVoto = document.getElementById("zonaVoto");
const resultados = document.getElementById("resultados");
const estado = document.getElementById("estado");

btnCargar.addEventListener("click", () => {
  const nombres = ["Paula", "Valentín", "Al", "Yoe", "Jose", "Kilian", "Astartea"];
  alumnos = nombres.map(n => new Alumno(n));
  candidatos = [...alumnos];

  infoAlumnos.textContent = "Alumnos cargados correctamente.";
  mostrarCandidatos();
  renderVotacion();
  actualizarEstado();
});

function mostrarCandidatos() {
  listaCandidatos.innerHTML = candidatos
    .map(c => `<div class="candidato">• ${c.nombre}</div>`)
    .join("");
}

function renderVotacion() {
  if (turno > MAX_VOTOS) {
    zonaVoto.innerHTML = "<em>Votación finalizada.</em>";
    return;
  }

  let html = `<p><strong>Vota, alumno ${turno}:</strong></p>`;
  candidatos.forEach((c, i) => {
    html += `<label><input type="radio" name="voto" value="${i}"> ${c.nombre}</label><br>`;
  });
  html += `<button onclick="registrarVoto()">Votar</button>`;

  zonaVoto.innerHTML = html;
}

function registrarVoto() {
  const sel = document.querySelector('input[name="voto"]:checked');
  if (!sel) {
    alert("Selecciona un candidato antes de votar.");
    return;
  }

  const elegido = candidatos[parseInt(sel.value)];
  elegido.votar(); 

  turno++;
  actualizarEstado();
  mostrarResultados();

  if (turno > MAX_VOTOS) {
    alert("Fin de la votación. ¡Gracias por participar!");
    zonaVoto.innerHTML = "<em>Votación finalizada.</em>";
  } else {
    renderVotacion();
  }
}

function mostrarResultados() {
  const totalVotos = candidatos.reduce((acc, c) => acc + c.votos, 0);

  let html = "";
  candidatos.forEach(c => {
    const porcentaje = totalVotos ? ((c.votos / totalVotos) * 100).toFixed(1) : 0;
    html += `<div class="resultado-linea">${c.nombre}: ${c.votos} votos (${porcentaje}%)</div>`;
  });

  resultados.innerHTML = html;
}
function actualizarEstado() {
  estado.textContent = `Turno: ${turno <= MAX_VOTOS ? turno : MAX_VOTOS} / ${MAX_VOTOS}`;
}
