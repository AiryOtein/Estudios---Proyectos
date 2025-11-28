// script.js - carga desde alumnos_clase.txt (fetch) con fallback file input,
// luego votación por turnos hasta 20 (o menos si hay menos alumnos).
// Candidatos = primeros 7 alumnos del fichero.

let alumnos = [];
let candidatos = [];
let votos = [];

let turno = 1;
const MAX_TURNOS = 20;

const btnCargar = document.getElementById('btnCargar');
const fileInput = document.getElementById('fileInput');
const infoAlumnos = document.getElementById('infoAlumnos');
const listaCandidatos = document.getElementById('listaCandidatos');
const zonaVoto = document.getElementById('zonaVoto');
const resultados = document.getElementById('resultados');
const estado = document.getElementById('estado');

btnCargar.addEventListener('click', () => {
  fetch('alumnos_clase.txt')
    .then(res => {
      if (!res.ok) throw new Error('No encontrado');
      return res.text();
    })
    .then(text => procesarAlumnos(text))
    .catch(err => {
      infoAlumnos.textContent = 'No se pudo cargar automáticamente; selecciona el archivo .txt manualmente.';
      fileInput.classList.remove('hidden');
      fileInput.addEventListener('change', function onFile(e) {
        const f = this.files[0];
        if (!f) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
          procesarAlumnos(ev.target.result);
        };
        reader.onerror = () => {
          infoAlumnos.textContent = 'Error leyendo el archivo seleccionado.';
        };
        reader.readAsText(f, 'UTF-8');
        fileInput.removeEventListener('change', onFile);
      }, { once: true });
    });
});

function procesarAlumnos(texto) {
  alumnos = texto.split(/\r?\n/).map(s => s.trim()).filter(s => s.length > 0);
  if (alumnos.length === 0) {
    infoAlumnos.textContent = 'El fichero está vacío o no tiene nombres válidos.';
    return;
  }
  infoAlumnos.innerHTML = `<strong>Alumnos cargados:</strong><br>${alumnos.map(a => '- ' + a).join('<br>')}`;
  candidatos = alumnos.slice(0, 7);
  votos = new Array(candidatos.length).fill(0);
  turno = 1;

  renderCandidatos();
  renderZonaVoto();
  renderEstado();
  mostrarResultados();
}

function renderCandidatos() {
  listaCandidatos.innerHTML = candidatos.map((c,i) => `<div class="cand">${i+1}. ${c}</div>`).join('');
}

function renderZonaVoto() {
  const maxEffective = Math.min(MAX_TURNOS, alumnos.length);
  if (turno > maxEffective) {
    zonaVoto.innerHTML = '<em>Votación finalizada.</em>';
    return;
  }

  let html = `<p><strong>Vota, Alumno ${turno}:</strong></p>`;
  html += candidatos.map((c,i) => `
    <label style="display:block;margin:6px 0">
      <input type="radio" name="voto" value="${i}"> ${c}
    </label>`).join('');
  html += `<button id="btnVotar">Votar</button> <button id="btnSaltar">Saltar</button>`;

  zonaVoto.innerHTML = html;

  document.getElementById('btnVotar').addEventListener('click', () => {
    const sel = document.querySelector('input[name="voto"]:checked');
    if (!sel) { alert('Selecciona un candidato o pulsa Saltar.'); return; }
    const idx = parseInt(sel.value, 10);
    votos[idx] += 1;
    turno++;
    renderEstado();
    mostrarResultados();
    if (turno > Math.min(MAX_TURNOS, alumnos.length)) {
      alert('Votación completada.');
      zonaVoto.innerHTML = '<em>Votación finalizada.</em>';
    } else renderZonaVoto();
  });

  document.getElementById('btnSaltar').addEventListener('click', () => {
      turno++;
    renderEstado();
    if (turno > Math.min(MAX_TURNOS, alumnos.length)) {
      alert('Votación completada.');
      zonaVoto.innerHTML = '<em>Votación finalizada.</em>';
    } else renderZonaVoto();
  });
}

function renderEstado() {
  const effectiveMax = Math.min(MAX_TURNOS, alumnos.length);
  estado.textContent = `Turno: ${turno <= effectiveMax ? turno : effectiveMax} / ${effectiveMax}`;
}

function mostrarResultados() {
  const total = votos.reduce((a,b) => a + b, 0);
  let html = `<strong>Resultados (votos contabilizados: ${total})</strong>`;
  if (total === 0) html += '<div class="small">Aún no hay votos.</div>';

  candidatos.forEach((c, i) => {
    const v = votos[i];
    const pct = total ? ((v / total) * 100).toFixed(1) : '0.0';
    const barW = Math.round(pct);
    html += `
      <div class="result-row">
        <div style="flex:1">${c}</div>
        <div style="width:120px;text-align:right">${v} votos</div>
      </div>
      <div style="margin:6px 0"><div class="bar" style="width:${barW}%;"></div> <span class="small">${pct}%</span></div>
    `;
  });

  resultados.innerHTML = html;
}
