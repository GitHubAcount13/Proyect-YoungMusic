
function canciones(){
let cancionesAgregadas = 0;

document.getElementById('formMusica').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (cancionesAgregadas >= LIMITE_CANCIONES) {
        alert('Has alcanzado el límite de canciones para este tipo de álbum');
        return;
    }

    const formData = new FormData(this);

    try {
        const response = await fetch('RF_Subida_Musica.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            cancionesAgregadas++;
            actualizarListaCanciones();
            
            if (cancionesAgregadas >= LIMITE_CANCIONES) {
                document.querySelector('button[type="submit"]').disabled = true;
            }

            // Limpiar el formulario
            this.reset();
            alert('Canción agregada correctamente');
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al subir la canción');
    }
});}

async function actualizarListaCanciones() {
    try {
        const response = await fetch(`obtener_canciones.php?album=${ALBUM_ID}`);
        const data = await response.json();
        
        const contenedor = document.getElementById('canciones-agregadas');
        contenedor.innerHTML = data.canciones.map(cancion => `
            <div class="cancion-item">
                <h4>${cancion.NomMusi}</h4>
                <audio controls>
                    <source src="${cancion.Archivo}" type="audio/mpeg">
                    Tu navegador no soporta el elemento de audio.
                </audio>
            </div>
        `).join('');
    } catch (error) {
        console.error('Error:', error);
    }
}

// Cargar canciones existentes al cargar la página
document.addEventListener('DOMContentLoaded', actualizarListaCanciones);


function VerficarDatos(){
  const form = document.querySelector('form');
  const nombreInput = document.getElementById('nombre');
  const emailInput = document.getElementById('email');
  const passInput = document.getElementById('pass');
  const ubicacionInput = document.getElementById('Ubicación');
  const biografiaInput = document.getElementById('biografia');
  const fileInput = document.getElementById('file');

  const errorContainer = document.createElement('div');
  errorContainer.classList.add('error-container');
  form.insertAdjacentElement('beforeend', errorContainer);

  form.addEventListener('submit', function (event) {
      errorContainer.innerHTML = ''; // Limpiar errores previos
      let hasError = false;

      // Validar Nombre
      if (nombreInput.value.trim() === '' || nombreInput.value.length > 35) {
          showError('El nombre es obligatorio y no puede tener más de 35 caracteres.');
          hasError = true;
      }

      // Validar Email
      if (!validateEmail(emailInput.value) || emailInput.value.length > 50) {
          showError('Ingrese un correo válido y que no supere los 50 caracteres.');
          hasError = true;
      }

      // Validar Contraseña
      if (!validatePassword(passInput.value) || passInput.value.length > 30) {
          showError('La contraseña debe tener al menos 7 caracteres y maximo 30, incluyendo una mayúscula, una letra y un número.');
          hasError = true;
      }

      // Validar Ubicación
      if (ubicacionInput.value === '') {
          showError('Seleccione una ubicación válida.');
          hasError = true;
      }

      // Validar Biografía
      if (biografiaInput.value.length > 100) {
          showError('La biografía no puede tener más de 100 caracteres.');
          hasError = true;
      }

      // Validar archivo de imagen
      if (fileInput.files[0] && fileInput.files[0].size > 2000000) {
          showError('La imagen no puede superar los 2MB.');
          hasError = true;
      }

      // Evitar el envío si hay errores
      if (hasError) {
          event.preventDefault();
      }
  });

  // Función para mostrar errores
  function showError(message) {
      const errorMessage = document.createElement('p');
      errorMessage.classList.add('text-danger');
      errorMessage.textContent = message;
      errorContainer.appendChild(errorMessage);
  }

  // Validar formato de email
  function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(String(email).toLowerCase());
  }

  // Validar contraseña (mínimo 7 caracteres, una mayúscula, una letra y un número)
  function validatePassword(password) {
      const re = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{7,}$/;
      return re.test(password);
  }
}


document.addEventListener('DOMContentLoaded', function() {
  redes.forEach(function(link) {

      if (!link.startsWith('http://') && !link.startsWith('https://')) {
          link = 'https://' + link; 
      }

      // Convertir el enlace a minúsculas para compararlo correctamente
      let linkLowerCase = link.toLowerCase();

      // TikTok
      if (linkLowerCase.includes("tiktok.com")) {
          document.getElementById('tiktok').style.display = 'inline-block';
          document.getElementById('tiktok').href = link;
      }

      // Instagram
      if (linkLowerCase.includes("instagram.com")) {
          document.getElementById('instagram').style.display = 'inline-block';
          document.getElementById('instagram').href = link;
      }

      // YouTube
      if (linkLowerCase.includes("youtube.com")) {
          document.getElementById('youtube').style.display = 'inline-block';
          document.getElementById('youtube').href = link;
      }

      // Spotify
      if (linkLowerCase.includes("spotify.com")) {
          document.getElementById('spotify').style.display = 'inline-block';
          document.getElementById('spotify').href = link;
      }
  });
});


function loginUser() {

  document.getElementById('submitLogin').addEventListener('click', function(event) {
    event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

    // Obtener los valores de los inputs
    const email = document.getElementById('email').value;
    const pass = document.getElementById('pass').value;

    // Crear un FormData con los datos del usuario 
    const formData = new FormData();
    formData.append('email', email);
    formData.append('pass', pass);
    formData.append('envio', true);

    // Enviar los datos al PHP usando fetch
    fetch('RF_Login_YM.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Esperar la respuesta en formato JSON
    .then(data => {
        // Verificar si el login fue exitoso
        if (data.status === 'success') {
            // Redirigir según el tipo de usuario
            switch(data.tipo_usuario) {
                case 'artista':
                    window.location.href = 'Artista_YM.php';
                    break;
                case 'oyente':
                    window.location.href = 'Usuario_YM.php';
                    break;
                case 'discografica':
                    window.location.href = 'Discografica_YM.php';
                    break;
            }
        } else {
            // Mostrar el mensaje de error (incluyendo el caso de no verificado)
            const errorMessage = document.getElementById('error-message');
            errorMessage.style.display = 'block';
            errorMessage.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
    });
  });
}




function consultar_en_tiempo_real(evento) {
    
  const formularioBusqueda = document.getElementById("form-buscar-usuario");
const resultadoDiv = document.getElementById('resultado');

formularioBusqueda.addEventListener("submit", consultar_en_tiempo_real);
  // Evita que se recargue la página
  evento.preventDefault();

  // Obtener el ultimo valor del input
  const nombre_usuario = document.getElementById("usuario").value;

  //se crea un objeto para tomar los valores del formulario
  const formData = new FormData();
  formData.append('usuario', nombre_usuario);
  formData.append('envio', true);

  // se le pasa al fetch el endpoint que genera la consulta de busqueda
  fetch('RF_Busqueda.php', {
      method: 'POST',
      body: formData
  })

  //se toma la respuesta y se devuelve en formato json
  .then(response => response.json())
  //la variable data se usa para recorrer el array asociativo del endpoint...
  .then(data => {
      
      resultadoDiv.innerHTML = ''; // Limpia el contenido previo

      //si el enpoint devuelve 1...
      if (data.status === 1) {
          data.usuarios.forEach(user => {
              // se agrega html dentro del div que contiene el mensaje de respuesta
              resultadoDiv.innerHTML += `<div id="resultado1"><img class="img-fluid img-busqueda" style="width: 70px; height: 70px; border-radius: 50%;" id="item"src="${user.perfil}" alt=""> <hr> <h2 class='nombre-busqueda' style="color: Black; font-size: medium;" id="item"> ${user.nombre}</h2><hr></div> <hr>`;
          });
      } else {
          resultadoDiv.innerHTML = `<h2 style="color: black;">${data.mensaje}</h2>`;
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}

function previewImage(event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("preview");
    output.src = reader.result;
    output.style.display = "block";
  };
  reader.readAsDataURL(event.target.files[0]);
}

const url = "JSON/countries.json";
const urlG = "JSON/generos.json";
const urlI = "JSON/instrumentos.json"

fetch(urlI)
  .then((Resupuesta) => Resupuesta.json())
  .then((data) => {
    const select = document.getElementById("Instumento");
    data.instrumentos.forEach((instrumento) => {
      const option = document.createElement("option");
      option.value = instrumento;
      option.textContent = instrumento;
      select.appendChild(option);
    });
  })
  .catch((error) => console.error("Error al cargar los géneros:", error));

fetch(urlG)
  .then((Resupuesta) => Resupuesta.json())
  .then((data) => {
    const select = document.getElementById("preferencias");
    data.generos.forEach((genero) => {
      const option = document.createElement("option");
      option.value = genero;
      option.textContent = genero;
      select.appendChild(option);
    });
  })
  .catch((error) => console.error("Error al cargar los géneros:", error));

fetch(url)
  .then((Resupuesta) => Resupuesta.json())
  .then((data) => {
    const select = document.getElementById("Ubicación");
    data.countries.forEach((country) => {
      const option = document.createElement("option");
      option.value = country.name;
      option.textContent = country.es_name;
      select.appendChild(option);
    });
  })
  .catch((error) => console.error("Error al cargar los países:", error));

function mostrarEditarPerfil() {
  
  document.getElementById("editarPerfil").style.display = "block";
  document.getElementById("eliminarPerfil").style.display = "none";
}

function mostrarEliminarPerfil() {
  document.getElementById("eliminarPerfil").style.display = "block";
  document.getElementById("editarPerfil").style.display = "none";
}

function confirmarContrasena(accion) {
  let mensaje =
    accion === "editar"
      ? "¿Está seguro de que desea guardar los cambios?"
      : "¿Está seguro de que desea eliminar su perfil?";
  return confirm(mensaje);
}

document.getElementById("toggleSidebar").addEventListener("click", function () {
  const sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("collapsed");

  const arrow = document.querySelector("#toggleSidebar .arrow");
  arrow.innerHTML = sidebar.classList.contains("collapsed") ? ">" : "<";
});

function mostrarVentanaEmergente() {

  document.getElementById("ventanaEmergente").style.display = "block";
}

function cerrarVentanaEmergente() {

  document.getElementById("ventanaEmergente").style.display = "none";
}

function enviarFormulario(destino) {

  document.getElementById("destinoFinal").value = destino;


  document.getElementById("ventanaEmergente").style.display = "none";
  document.getElementById("formGeneros").submit();
}

function enviarFormularioIns() {


  document.getElementById("ventanaEmergente").style.display = "none";
  document.getElementById("forminstrumentos").submit();
}



function mostrarVentanaEmergente() {
  document.getElementById("ventanaEmergente").style.display = "block";
}


function enviarFormularioRed() {

  document.getElementById("ventanaEmergente").style.display = "none";
  
  
  const red1 = document.getElementById("Red1").value;
  const red2 = document.getElementById("Red2").value;
  const red3 = document.getElementById("Red3").value;
  const red4 = document.getElementById("Red4").value;
  

  const formDataRed = new FormData();
  formDataRed.append("Red1", red1);
  formDataRed.append("Red2", red2);
  formDataRed.append("Red3", red3);
  formDataRed.append("Red4", red4);
  formDataRed.append("envio", true); 
  

  fetch("RF_Redes_Disc_YM.php", {
    method: "POST",
    body: formDataRed
  })
  .then(Resupuesta => {
    if (Resupuesta.ok) {

      window.location.href = "Login_YM.php";
    } else {
      console.error("Error al enviar el formulario");
    }
  })
  .catch(error => {
    console.error("Error en la petición:", error);
  });
}

function scrollRight() {
  document.getElementById('carousel').scrollBy({ 
      left: 265, 
      behavior: 'smooth' 
  });
}

