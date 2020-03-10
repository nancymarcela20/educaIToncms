/**
 * 
 * GUÍA DE ESTILOS PROGRAMA INGENIERÍA DE SISTEMAS
 * UNIVERSIDAD FRANCISCO DE PAULA SANTANDER
 * VERSIÓN 1.0.0
 * AUTOR: GERSON LÁZARO
 * REPORTES: gersonyesidlc@ufps.edu.co
 *
 *
 * 1. VENTANAS MODALES (Alertas)
 * 2. IMAGENES MODALES (Visualizador de imagen)
 * 3. DROPDOWN
 * 4. ACORDEÓN
 * 5. PESTAÑAS
 * 6. ALERTAS
 * 7. NOTIFICACIONES
 * 8. NAVBAR RESPONSIVE
 */


/**
 * VENTANAS MODALES (Alertas)
 * Este método se encarga de abrir una ventana modal
 * @param id - id de la ventana a abrir.
 */

function openModal(id, frozen = 0) {
  let modal = document.getElementById(id);
  modal.style.display = "block";
  var close = document.getElementsByClassName("ufps-modal-close");
  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      modal.style.display = "none";
    }
  }
  if (frozen == 0) {
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  }
}

/**
 * IMAGENES MODALES (Visualizador de imagen)
 * Este método se encarga de abrir la visualización en pantalla completa de una imagen, oscureciendo el fondo.
 * @param id - id del modal que contiene la imagen.
 */

document.addEventListener('keyup', function (e) {
  if (e.keyCode == 27) {
    var close = document.getElementsByClassName("ufps-image-modal");
    for (i = 0; i < close.length; i++) {
      close[i].style.display = "none";
    }
  }
});

function openModalImage(id) {
  var modal = document.getElementById(id);
  var modalImg = modal.getElementsByClassName("ufps-image-modal-content")[0];
  var captionText = modal.getElementsByClassName("ufps-image-modal-caption")[0];
  modal.style.display = "block";
  var close = document.getElementsByClassName("ufps-image-modal-close");
  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      modal.style.display = "none";
    }
  }
}

function closeModalImages() {
    var close = document.getElementsByClassName("ufps-image-modal");
    for (i = 0; i < close.length; i++) {
      close[i].style.display = "none";
    }
}

function MyShow(id) {
  closeModalImages();
  openModalImage(id);
}

/**
 * DROPDOWN
 * Método encargado de permitir y ejecutar el despliegue y cierre de los dropdowns.
 * @param id - id del dropdown sobre a expandir.
 */
function openDropdown(id) {
  var dropdown = document.getElementById(id);
  window.onclick = function(event) {
    console.log(event);
    console.log(event.target);
    if (event.target.matches('.ufps-dropdown-btn') && event.target.parent != dropdown) {
      console.log("entra a dp");
      var dropdowns = document.getElementsByClassName("ufps-dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('ufps-dropdown-show')) {
          openDropdown.classList.remove('ufps-dropdown-show');
        }
      }
      dropdown.getElementsByClassName("ufps-dropdown-content")[0].classList.toggle("ufps-dropdown-show");

    }
    if (!event.target.matches('.ufps-dropdown-btn')) {
      var dropdowns = document.getElementsByClassName("ufps-dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('ufps-dropdown-show')) {
          openDropdown.classList.remove('ufps-dropdown-show');
        }
      }
    }
  }.bind(dropdown);
}

/**
 * ACORDEÓN
 * Método encargado de desplegar los diferentes acordeones en una web app. No es necesario pasar ningún parametro
 * Este método se ejecuta automáticamente con el evento onload y deja activos todos los acordeones existentes en la
 * página.
 */
function toggleAccordion() {
  var accordion = document.getElementsByClassName("ufps-btn-accordion");
  var i;
  for (i = 0; i < accordion.length; i++) {
    accordion[i].onclick = function() {
      this.classList.toggle("ufps-accordion-active");
      this.nextElementSibling.classList.toggle("ufps-accordion-show");
    }
  }
}

/**
 * PESTAÑAS
 * Método encargado de desplegar el contenido asociado a una pestaña. Debe dispararse al hacer clic en cualquiera de las pestañas 
 * @param evt - Evento que dispara el cambio
 * @param idTab - id del contenido que se desplegará al hacer clic
 * @param idContainer - id del contenedor de las pestañas
 */
function openTab(evt, idTab, idContainer) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementById(idContainer).getElementsByClassName("ufps-tab-content");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementById(idContainer).getElementsByClassName("ufps-tab-links");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" ufps-tab-active", "");
  }
  document.getElementById(idTab).style.display = "block";
  evt.currentTarget.className += " ufps-tab-active";
/*  document.getElementById("browseweek").style.display = "block";*/
}

function closeTab(evt, idContainer) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementById(idContainer).getElementsByClassName("ufps-tab-content");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementById(idContainer).getElementsByClassName("ufps-tab-links");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" ufps-tab-active", "");
  }
  evt.currentTarget.className += " ufps-tab-active";
/*  document.getElementById("browseweek").style.display = "none";*/
}

function TurnOff (evt, idContainer) {
  evt.currentTarget.className = evt.currentTarget.className.replace(" ufps-tab-active", "");
/*  document.getElementById("browseweek").style.display = "none";*/
}

function filtreEvento (evt, idEvento, accion, param1 = '', param2 = '') {
  var i, btnLight, btnLightActive;
  btnLight = document.getElementById(idEvento).getElementsByClassName("ufps-btn");
  for (i = 0; i < btnLight.length; i++) {
    btnLight[i].className = btnLight[i].className.replace(" ufps-btn-light-active", " ufps-btn-light");
  }
  evt.currentTarget.className = evt.currentTarget.className.replace(" ufps-btn-light"," ufps-btn-light-active");

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("informacionContent").innerHTML =
      this.responseText;
    }
  };
  if (idEvento == 'galerias') {
    xhttp.open("GET", "index.php?modulo=galerias&idtipog="+accion+"&ajax=galerias", true);
  } else {
    if (idEvento == 'eventos') {
      xhttp.open("GET", "index.php?modulo=principal&idtipoi="+accion+"&ajax=informaciones", true);
    } else {
      if (idEvento == 'calendarios') {
        xhttp.open("GET", "index.php?modulo=calendarios&idtipoc="+accion+"&anno="+param1+"&mes="+param2+"&ajax=calendarios", true);
      }
    }
  }
  xhttp.send();
}

function TogglePopUp(evt, idEvento) {
  var divEvents;
  divEvents = document.getElementById(idEvento);
  if (divEvents.style.opacity) {
    if (divEvents.style.opacity == 0) {
      jQuery("#"+idEvento).fadeTo(300, 0.95, function() {
      });
    } else {
      jQuery("#"+idEvento).fadeTo(300, 0, function() {
      });
    }
  } else {
    jQuery("#"+idEvento).fadeTo(300, 0.95, function() {
    });
  }
}

function WeekDirection(actual, direccion, parametro) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("proximasContent").innerHTML =
      this.responseText;
      toggleAccordion();
    }
  };
  xhttp.open("GET", "index.php?modulo=proximas&semana="+(actual+direccion)+"&posicion="+parametro+"&ajax=proximas", true);
  xhttp.send();
}

function MonthDirection(actual, direccion, tipoc, anno) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("informacionContent").innerHTML =
      this.responseText;
      toggleAccordion();
    }
  };
  xhttp.open("GET", "index.php?modulo=calendarios&idtipoc="+tipoc+"&anno="+anno+"&mes="+(actual+direccion)+"&ajax=calendarios", true);
  xhttp.send();
}

function ShowEntries(evt, columna, dia, fecha, tipoc) {
  var DivEntries = document.getElementById("calendarentries");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      DivEntries.innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "controladores/leefecha.php?fecha="+fecha+"&tipoc="+tipoc, true);
  xhttp.send();
  DivEntries.style.top = (evt.pageY+20)+"px";
  if (columna < 2) {
    DivEntries.style.left = (evt.pageX)+"px";
  } else {
    if (columna < 5) {
      DivEntries.style.left = (evt.pageX-120)+"px";
    } else {
      DivEntries.style.left = (evt.pageX-250)+"px";
    }
  }
  DivEntries.style.display = "block";
}

function HideEntries() {
  var DivEntries = document.getElementById("calendarentries");
  DivEntries.style.display = "none";
}

function ShowModal(evt, Nombremodal, fecha, tipoc) {
  var DivEntries = document.getElementById("modalentries");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      DivEntries.innerHTML =
      this.responseText;
      openModal(Nombremodal);
    }
  };
  xhttp.open("GET", "controladores/leefecha.php?fecha="+fecha+"&tipoc="+tipoc, true);
  xhttp.send();
}

function ToggleIcon(img, replacement) {
  var Icon = document.getElementById(img);
  Icon.src = replacement;
}

function logOut() {
  document.forms['logout'].submit();
}

function changeMe() {
  openModal('modalchangepass');
}

function isValidDate(dateString) {
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  if(!dateString.match(regEx))
    return false;  // Invalid format
  var d;
  if(!((d = new Date(dateString))|0))
    return false; // Invalid date (or this could be epoch)
  return d.toISOString().slice(0,10) == dateString;
}

function isValidEmilio(emilio) {
  return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(emilio);
}

/**
 * ALERTAS
 * Añade funcionalidad al botón cerrar de las alertas. 
 * Este método se carga en el evento onload, y queda en espera por el cierre
 * @param event - Evento que dispara el cierre.
 */
function closeAlertListener(event) {
  var alerts = document.getElementsByClassName("ufps-close-alert-btn");
  var i = 0;
  for (i = 0; i < alerts.length; i++) {
    alerts[i].onclick = function(event) {
      event.target.parentElement.style.display = 'none';
    }
  }
}

/**
 * NOTIFICACIONES
 * Muestra una notificación en la parte inferior central de la pantalla.
 * @param text - Texto de la notificación
 * @param time - Tiempo que durará la alerta desplegada (en milisegundos)
 */
function notification(text, time) {
  console.log("notificacion");
  var notification = document.createElement('div');
  notification.className = 'ufps-notification';
  notification.innerHTML = text;
  document.getElementsByTagName('body')[0].appendChild(notification);

  notification.className += " ufps-notification-show";

  setTimeout(function() {
    notification.className = notification.className.replace(" ufps-notification-show", "");
    console.log("quita clase");
  }, time);

}

/**
 * NAVBAR RESPONSIVE
 * En dispositivos moviles y tabletas, los botones del menú se ocultan y solo se muestra un botón para desplegarlos.
 * Este método añade funcionalidad a dicho botón, permitiendo su despliegue y cierre.
 * @param id - Id del navbar
 */
function toggleMenu(id) {
  var navbar = document.getElementById(id);
  navbar.getElementsByClassName("ufps-btn-menu")[0].classList.toggle("ufps-change");
  var left = navbar.getElementsByClassName("ufps-navbar-left")[0];
  var right = navbar.getElementsByClassName("ufps-navbar-right")[0];
  if (left.style.display != "block") {
    left.style.display = "block";
    right.style.display = "none";

    setTimeout(function() {
      left.style.opacity = "1";
      right.style.opacity = "0";
    }, 100);
  } else {
    left.style.opacity = "0";
    right.style.opacity = "1";
    setTimeout(function() {
      left.style.display = "none";
      right.style.display = "block";
    }, 210);
  }

}

/**
 * Métodos que se ejecutan al inicializarse el documento html.
 */
window.onload = function() {
  toggleAccordion();
  closeAlertListener();
}
