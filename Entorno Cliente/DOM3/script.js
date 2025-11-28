document.addEventListener('DOMContentLoaded', iniciar);

function iniciar() {
  const todosH2 = document.getElementsByTagName('h2');
  for (let i = 0; i < todosH2.length; i++) {
    todosH2[i].addEventListener('click', recorrerAdelante);
    todosH2[i].addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        recorrerAdelante.call(this, e);
      }
    });
  }
}
/*
Extra que no pide el enunciado: 
La función mostrarSoloEstaLista(ul) hace que solo una lista de provincias
 esté visible a la vez. Si la lista clicada ya está abierta,
 la cierra y actualiza los atributos de accesibilidad
 (aria-hidden y aria-expanded). Si no estaba abierta, abre esa lista
 y cierra las demás. También actualiza los H2 relacionados para que los
 lectores de pantalla sepan qué sección está expandida.
*/
function mostrarSoloEstaLista(ul) {
  const todasListas = document.querySelectorAll('.provincias');
  const yaAbierta = ul.classList.contains('open');

  if (yaAbierta) {
    ul.classList.remove('open');
    ul.setAttribute('aria-hidden', 'true');
    actualizarAriaExpanded(ul, false);
    return;
  }
  todasListas.forEach(list => {
    if (list === ul) {
      list.classList.add('open');
      list.setAttribute('aria-hidden', 'false');
    } else {
      list.classList.remove('open');
      list.setAttribute('aria-hidden', 'true');
    }
  });

  actualizarAriaExpanded(ul, true);
}

function actualizarAriaExpanded(ul, expandidoParaUl) {
  const todosH2 = document.getElementsByTagName('h2');
  for (let i = 0; i < todosH2.length; i++) {
    const h2 = todosH2[i];
    const siguiente = h2.nextElementSibling;
    if (siguiente === ul && expandidoParaUl) {
      h2.setAttribute('aria-expanded', 'true');
    } else {
      h2.setAttribute('aria-expanded', 'false');
    }
  }
}

function recorrerAdelante(event) {
  const h2 = event.currentTarget || this;
  const ul = h2.nextElementSibling;
  if (ul && ul.classList.contains('provincias')) {
    mostrarSoloEstaLista(ul);
  }

  let texto = 'Elegiste: ' + h2.textContent;
  const padre = h2.parentElement;
  texto += ', situada en el ' + padre.id + '.';

  const hermano = h2.nextElementSibling;
  if (hermano && hermano.tagName.toLowerCase() === 'ul') {
    const numeroProvincias = hermano.children.length;
    texto += ' Número de provincias: ' + numeroProvincias;
    texto = recorrerHijos(hermano, texto);
  } else {
    texto += ' (No se ha encontrado la lista de provincias asociada)';
  }

  document.getElementById('resultado').textContent = texto;
}

function recorrerHijos(ulElemento, texto) {
  let hijo = ulElemento.firstElementChild;
  texto += '\n ';
  while (hijo !== null) {
    texto += '\n - ' + hijo.textContent;
    hijo = hijo.nextElementSibling;
  }
  return texto;
}
