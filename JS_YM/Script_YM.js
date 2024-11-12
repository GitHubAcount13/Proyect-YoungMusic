function validarFormularioMusica() {
  const nombreCancion = document.getElementById("NomMusi").value.trim();
  const archivoAudio = document.getElementById("Archivo").files.length;
  const imagenCancion = document.getElementById("ImgMusi").files.length;
  const generosSeleccionados = document.querySelectorAll(
    'input[name="Generos[]"]:checked'
  );

  // Resetea los mensajes de error
  document.getElementById("errorNomMusi").textContent = "";
  document.getElementById("errorArchivo").textContent = "";
  document.getElementById("errorImgMusi").textContent = "";
  document.getElementById("errorGeneros").textContent = "";

  let esValido = true;

  // Validar nombre de la canción
  if (!nombreCancion) {
    document.getElementById("errorNomMusi").textContent =
      "Por favor, ingresa el nombre de la canción.";
    esValido = false;
  }

  // Validar archivo de audio
  if (archivoAudio === 0) {
    document.getElementById("errorArchivo").textContent =
      "Por favor, selecciona un archivo de audio.";
    esValido = false;
  }

  // Validar imagen de la canción
  if (imagenCancion === 0) {
    document.getElementById("errorImgMusi").textContent =
      "Por favor, selecciona una imagen para la canción.";
    esValido = false;
  }

  // Validar que se haya seleccionado al menos un género
  if (generosSeleccionados.length === 0) {
    document.getElementById("errorGeneros").textContent =
      "Por favor, selecciona al menos un género musical.";
    esValido = false;
  }

  // Si todo es válido, continuar con el envío
  if (esValido) {
    canciones(); // Llama a la función de envío de la canción
  }
}

function validarFormulario() {
  const nombre = document.getElementById("NomAlbum").value.trim();
  const categoria = document.getElementById("Categoria").value;
  const fecha = document.getElementById("FechaLan").value;
  const portada = document.getElementById("ImgAlbu").files.length;
  const hoy = new Date().toISOString().split("T")[0];

  // Definir año mínimo
  const fechaMinima = "1500-01-01";
  let esValido = true;

  // Validar nombre del álbum
  if (!nombre) {
    document.getElementById("errorNombre").style.display = "block";
    esValido = false;
  } else {
    document.getElementById("errorNombre").style.display = "none";
  }

  // Validar categoría
  if (!categoria) {
    document.getElementById("errorCategoria").style.display = "block";
    esValido = false;
  } else {
    document.getElementById("errorCategoria").style.display = "none";
  }

  // Validar fecha de lanzamiento (entre 1500 y hoy)
  if (!fecha || fecha > hoy || fecha < fechaMinima) {
    document.getElementById("errorFecha").style.display = "block";
    esValido = false;
  } else {
    document.getElementById("errorFecha").style.display = "none";
  }

  // Validar portada del álbum
  if (portada === 0) {
    document.getElementById("errorPortada").style.display = "block";
    esValido = false;
  } else {
    document.getElementById("errorPortada").style.display = "none";
  }

  // Si todo es válido, enviar el formulario
  if (esValido) {
    document.getElementById("albumForm").submit();
  }
}

function validarEdad() {
  const fechaNacimiento = document.getElementById("fecha").value;
  const mensajeError = document.getElementById("mensajeError");
  const form = document.getElementById("registroArtistaForm");

  if (fechaNacimiento) {
    const hoy = new Date();
    const fechaNac = new Date(fechaNacimiento);
    const edad = hoy.getFullYear() - fechaNac.getFullYear();
    const mes = hoy.getMonth() - fechaNac.getMonth();

    // Ajuste de edad si el cumpleaños aún no ha pasado este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
      edad--;
    }

    if (edad >= 13 && edad <= 110) {
      mensajeError.style.display = "none";
      form.submit(); // Envía el formulario si la edad es válida
    } else {
      mensajeError.style.display = "block"; // Muestra el mensaje de error si la edad no es válida
    }
  } else {
    mensajeError.style.display = "block"; // Muestra el mensaje de error si la fecha de nacimiento no está ingresada
  }
}
function validarInstrumentos() {
  const checkboxes = document.querySelectorAll(
    "input[name='instrumentos[]']:checked"
  );
  const mensajeError = document.getElementById("mensajeErrorInstrumentos");

  if (checkboxes.length === 0) {
    mensajeError.style.display = "block";
  } else {
    mensajeError.style.display = "none";
    mostrarVentanaEmergente();
  }
}

function canciones() {
  event.preventDefault();

  const form = document.getElementById("formMusica");
  const formData = new FormData(form);

  // Mostrar mensaje de estado
  const mensajeEstado = document.getElementById("mensaje-estado");
  const iconoEstado = document.getElementById("icono-estado");
  const textoEstado = document.getElementById("texto-estado");

  // Configurar estado inicial
  mensajeEstado.style.display = "flex";
  mensajeEstado.className = "mensaje-estado subiendo";
  iconoEstado.textContent = "⟳";
  textoEstado.textContent = "Subiendo canción...";

  fetch("RF_Subida_Musica.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Cambiar a estado de éxito
        mensajeEstado.className = "mensaje-estado exito";
        iconoEstado.textContent = "✓";
        textoEstado.textContent = "¡Canción subida exitosamente!";

        // Limpiar formulario
        form.reset();
      } else {
        throw new Error(data.message);
      }
    })
    .catch((error) => {
      // Cambiar a estado de error
      mensajeEstado.className = "mensaje-estado error";
      iconoEstado.textContent = "✕";
      textoEstado.textContent = "Error al subir la canción: " + error.message;
    });
}

document.addEventListener("DOMContentLoaded", function () {
  const BotonLike = document.querySelectorAll(".Like-boton");

  BotonLike.forEach((button) => {
    button.addEventListener("click", function () {
      const musicId = this.dataset.songId;
      const isLiked = this.classList.contains("liked");
      const action = isLiked ? "remove" : "add";

      fetch("RF_Likes_YM.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `musicId=${musicId}&action=${action}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.classList.toggle("liked");
          } else {
            console.error(data.message);
          }
        })
        .catch((error) => console.error("Error:", error));
    });
  });
});

function showNotification(message, type = 'success') {
  const notification = document.getElementById('notification');
  const notificationMessage = document.getElementById('notification-message');
  
  notification.className = 'notification ' + type;
  notificationMessage.textContent = message;
  
  notification.style.display = 'block';
  setTimeout(() => {
      notification.classList.add('show');
  }, 10);

  setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => {
          notification.style.display = 'none';
      }, 300);
  }, 3000);
}

function seguirArtista() {
  const formSeguir = document.getElementById("formSeguir");
  const formData = new FormData(formSeguir);

  fetch(window.location.href, {
      method: "POST",
      body: formData,
  })
      .then((response) => response.text())
      .then((result) => {
          showNotification("Ahora sigues a este artista.");
          setTimeout(() => {
              location.reload();
          }, 1000);
      })
      .catch((error) => {
          console.error("Error:", error);
          showNotification("Ocurrió un error al intentar seguir al artista.", "error");
      });
}

function dejarDeSeguirArtista() {
  const formSeguir = document.getElementById("formSeguir");
  const formData = new FormData(formSeguir);

  fetch(window.location.href, {
      method: "POST",
      body: formData,
  })
      .then((response) => response.text())
      .then((result) => {
          showNotification("Has dejado de seguir a este artista.");
          setTimeout(() => {
              location.reload();
          }, 1000);
      })
      .catch((error) => {
          console.error("Error:", error);
          showNotification("Ocurrió un error al intentar dejar de seguir al artista.", "error");
      });
}

const albumFunctions = {
  showDeleteConfirmation: function (albumId) {
    const confirmationContainer = document.getElementById(
      "confirmationContainer"
    );
    confirmationContainer.innerHTML = `
      <div class="alert alert-warning">
        <p>¿Estás seguro de que deseas eliminar este álbum? Esta acción no se puede deshacer.</p>
        <button class="btn btn-danger" onclick="albumFunctions.confirmDelete(${albumId})">Eliminar</button>
        <button class="btn btn-secondary" onclick="albumFunctions.cancelDelete()">Cancelar</button>
      </div>
    `;
  },

  confirmDelete: function (albumId) {
    const messageContainer = document.getElementById("messageContainer");
    fetch("eliminar_album.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ albumId: albumId }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          messageContainer.innerHTML =
            "<div class='alert alert-success'>Álbum eliminado correctamente.</div>";
          setTimeout(() => {
            window.location.href = "Home_YM.php";
          }, 2000);
        } else {
          messageContainer.innerHTML =
            "<div class='alert alert-danger'>Error al eliminar el álbum: " +
            data.message +
            "</div>";
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        messageContainer.innerHTML =
          "<div class='alert alert-danger'>Error al procesar la solicitud.</div>";
      });
    // Limpia el mensaje de confirmación
    albumFunctions.cancelDelete();
  },

  cancelDelete: function () {
    document.getElementById("confirmationContainer").innerHTML = "";
  },

  init: function () {
    document.addEventListener("DOMContentLoaded", function () {
      const deleteButtons = document.querySelectorAll(".delete-album-btn");
      deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
          const albumId = this.dataset.albumId;
          albumFunctions.showDeleteConfirmation(albumId);
        });
      });
    });
  },
};

albumFunctions.init();

document.addEventListener("DOMContentLoaded", function () {
  const commentForm = document.getElementById("commentForm");

  // Manejar envío de comentarios
  if (commentForm) {
    commentForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const comentario = document.getElementById("comentario").value;
      const albumId = this.dataset.albumId;

      const formData = new FormData();
      formData.append("albumId", albumId);
      formData.append("comentario", comentario);

      fetch("procesar_comentario.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
          }
          return response.json();
        })
        .then((data) => {
          if (data.success) {
            location.reload();
          } else {
            alert(data.message || "Error al publicar el comentario");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Error al procesar la solicitud: " + error.message);
        });

      document.getElementById("comentario").value = "";
    });
  }

  // Manejar borrado de comentarios
  document.querySelectorAll(".delete-comment-btn").forEach((button) => {
    button.addEventListener("click", function (e) {
      if (confirm("¿Estás seguro de que deseas eliminar este comentario?")) {
        const commentId = this.dataset.commentId;
        const formData = new FormData();
        formData.append("commentId", commentId);
        formData.append("action", "delete");

        fetch("procesar_comentario.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              // Eliminar el comentario del DOM
              const commentItem = document.querySelector(
                `.comment-item[data-comment-id="${commentId}"]`
              );
              if (commentItem) {
                commentItem.remove();
              }
            } else {
              alert(data.message || "Error al eliminar el comentario");
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("Error al eliminar el comentario");
          });
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Obtener los valores de los campos de texto
  let redes = [
    document.getElementById("Red1").value,
    document.getElementById("Red2").value,
    document.getElementById("Red3").value,
    document.getElementById("Red4").value,
  ];

  // Mostrar los iconos de las redes sociales
  redes.forEach(function (link) {
    if (link !== "") {
      if (!link.startsWith("http://") && !link.startsWith("https://")) {
        link = "https://" + link;
      }

      // Convertir el enlace a minúsculas para compararlo correctamente
      let linkLowerCase = link.toLowerCase();

      // TikTok
      if (linkLowerCase.includes("tiktok.com")) {
        document.getElementById("tiktok").style.display = "inline-block";
        document.getElementById("tiktok").href = link;
      }

      // Instagram
      if (linkLowerCase.includes("instagram.com")) {
        document.getElementById("instagram").style.display = "inline-block";
        document.getElementById("instagram").href = link;
      }

      // YouTube
      if (linkLowerCase.includes("youtube.com")) {
        document.getElementById("youtube").style.display = "inline-block";
        document.getElementById("youtube").href = link;
      }

      // Spotify
      if (linkLowerCase.includes("spotify.com")) {
        document.getElementById("spotify").style.display = "inline-block";
        document.getElementById("spotify").href = link;
      }
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const audioPlayers = document.querySelectorAll(".custom-audio-player");

  // Detener otras canciones cuando se reproduce una nueva
  audioPlayers.forEach((player) => {
    player.addEventListener("play", function () {
      audioPlayers.forEach((otherPlayer) => {
        if (otherPlayer !== player && !otherPlayer.paused) {
          otherPlayer.pause();
        }
      });
    });
  });

  // Mejorar la experiencia del usuario al hacer clic en la canción
  const songItems = document.querySelectorAll(".song-item");
  songItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      // Si el clic no fue en el control de audio
      if (!e.target.closest("audio")) {
        const audio = this.querySelector("audio");
        if (audio.paused) {
          audio.play();
        } else {
          audio.pause();
        }
      }
    });
  });
});

let cancionesAgregadas = 0; // Mueve la variable aquí para que sea global

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formMusica");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    if (cancionesAgregadas >= LIMITE_CANCIONES) {
      alert("Has alcanzado el límite de canciones para este tipo de álbum");
      return;
    }

    const formData = new FormData(this);

    try {
      const response = await fetch("RF_Subida_Musica.php", {
        method: "POST",
        body: formData,
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
        alert("Canción agregada correctamente");
      } else {
        alert("Error: " + data.message);
      }
    } catch (error) {
      console.error("Error:", error);
      alert("Error al subir la canción");
    }
  });

  actualizarListaCanciones(); // Cargar canciones existentes al cargar la página
});
async function actualizarListaCanciones() {
  try {
    const response = await fetch(`obtener_canciones.php?album=${ALBUM_ID}`);
    const data = await response.json();

    const contenedor = document.getElementById("canciones-agregadas");
    contenedor.innerHTML = data.canciones
      .map(
        (cancion) => `
            <div class="cancion-item">
                <h4>${cancion.NomMusi}</h4>
                <audio controls>
                    <source src="${cancion.Archivo}" type="audio/mpeg">
                    Tu navegador no soporta el elemento de audio.
                </audio>
            </div>
        `
      )
      .join("");
  } catch (error) {
    console.error("Error:", error);
  }
}

// Cargar canciones existentes al cargar la página
document.addEventListener("DOMContentLoaded", actualizarListaCanciones);

async function ExisteCorreo(email) {
  try {
    const response = await fetch("Validar_Correo.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `email=${encodeURIComponent(email)}`,
    });
    const data = await response.json();
    return data.exists;
  } catch (error) {
    console.error("Error checking email:", error);
    return false;
  }
}

function Verificar() {
  // Prevenimos el envío inicial
  event.preventDefault();

  const form = document.getElementById("form-Registro");
  const errorContainer =
    document.querySelector(".error-container") || createErrorContainer(form);
  errorContainer.innerHTML = ""; // Limpiar mensajes de error previos

  const nombreInput = document.getElementById("nombre");
  const emailInput = document.getElementById("email");
  const passInput = document.getElementById("pass");
  const ubicacionInput = document.getElementById("Ubicación");
  const biografiaInput = document.getElementById("biografia");
  const fileInput = document.getElementById("file");

  let hasError = false;

  // Validar Nombre
  if (nombreInput.value.trim() === "" || nombreInput.value.length > 35) {
    showError(
      errorContainer,
      "nombre-error",
      "El nombre es obligatorio y no puede tener más de 35 caracteres."
    );
    hasError = true;
  }

  // Validar formato del correo electrónico
  if (!validateEmail(emailInput.value) || emailInput.value.length > 50) {
    showError(
      errorContainer,
      "email-error",
      "Ingrese un correo válido y que no supere los 50 caracteres."
    );
    hasError = true;
  }

  // Verificar si el correo ya existe
  existeCorreo(emailInput.value)
    .then((exists) => {
      if (exists) {
        showError(
          errorContainer,
          "email-exists-error",
          "El correo ya está registrado."
        );
        hasError = true;
      }
    })
    .catch((error) => {
      console.error("Error al verificar el correo:", error);
    });

  // Validar contraseña
  if (!validatePassword(passInput.value) || passInput.value.length > 30) {
    showError(
      errorContainer,
      "password-error",
      "La contraseña debe tener entre 7 y 30 caracteres, incluir una mayúscula, una letra y un número, y no debe contener caracteres especiales."
    );
    hasError = true;
  }

  // Validar ubicación
  if (ubicacionInput.value === "") {
    showError(
      errorContainer,
      "ubicacion-error",
      "Seleccione una ubicación válida."
    );
    hasError = true;
  }

  // Validar longitud de biografía
  if (biografiaInput.value.length > 100) {
    showError(
      errorContainer,
      "biografia-error",
      "La biografía no puede tener más de 100 caracteres."
    );
    hasError = true;
  }

  // Validar tamaño de archivo de imagen
  if (fileInput.files[0] && fileInput.files[0].size > 2000000) {
    showError(
      errorContainer,
      "file-error",
      "La imagen no puede superar los 2MB."
    );
    hasError = true;
  }

  // Enviar formulario si no hay errores
  if (!hasError) {
    form.submit();
  }
}

// Función para verificar si el correo ya existe
async function existeCorreo(email) {
  try {
    const response = await fetch("Validar_Correo.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `email=${encodeURIComponent(email)}`,
    });
    const data = await response.json();
    return data.exists;
  } catch (error) {
    console.error("Error al verificar el correo:", error);
    return false;
  }
}

// Función para mostrar mensajes de error sin duplicarlos
function showError(container, errorId, message) {
  let errorMessage = document.getElementById(errorId);
  if (!errorMessage) {
    errorMessage = document.createElement("p");
    errorMessage.id = errorId;
    errorMessage.classList.add("text-danger");
    container.appendChild(errorMessage);
  }
  errorMessage.textContent = message;
}

// Función para crear el contenedor de errores
function createErrorContainer(form) {
  const errorContainer = document.createElement("div");
  errorContainer.classList.add("error-container");
  form.insertAdjacentElement("beforeend", errorContainer);
  return errorContainer;
}

// Validación de formato de correo electrónico
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(String(email).toLowerCase());
}

// Validación de formato de contraseña
function validatePassword(password) {
  const re = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{7,}$/;
  return re.test(password);
}
function loginUser() {
  document
    .getElementById("submitLogin")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

      // Obtener los valores de los inputs
      const email = document.getElementById("email").value;
      const pass = document.getElementById("pass").value;

      // Crear un FormData con los datos del usuario
      const formData = new FormData();
      formData.append("email", email);
      formData.append("pass", pass);
      formData.append("envio", true);

      // Enviar los datos al PHP usando fetch
      fetch("RF_Login_YM.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json()) // Esperar la respuesta en formato JSON
        .then((data) => {
          // Verificar si el login fue exitoso
          if (data.status === "success") {
            // Redirigir según el tipo de usuario
            switch (data.tipo_usuario) {
              case "artista":
                window.location.href = "Artista_YM.php";
                break;
              case "oyente":
                window.location.href = "Usuario_YM.php";
                break;
              case "discografica":
                window.location.href = "Discografica_YM.php";
                break;
            }
          } else {
            // Mostrar el mensaje de error (incluyendo el caso de no verificado)
            const errorMessage = document.getElementById("error-message");
            errorMessage.style.display = "block";
            errorMessage.textContent = data.message;
          }
        })
        .catch((error) => {
          console.error("Error en la solicitud:", error);
        });
    });
}
function consultar_en_tiempo_real_Musica(evento) {
  const formularioBusqueda = document.getElementById("form-buscar-Musica");
  const resultadoDiv = document.getElementById("resultado_Musica");

  if (evento) {
    evento.preventDefault();
  }

  // Obtener el ultimo valor del input
  const nombre_musica = document.getElementById("Musica").value;

  //se crea un objeto para tomar los valores del formulario
  const formData = new FormData();
  formData.append("Musica", nombre_musica);
  formData.append("envio", true);

  // se le pasa al fetch el endpoint que genera la consulta de busqueda
  fetch("RF_Busqueda_musica.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      resultadoDiv.innerHTML = ""; // Limpia el contenido previo

      //si el endpoint devuelve 1...
      if (data.status === 1) {
        data.musicas.forEach((musica) => {
          // se agrega html dentro del div que contiene el mensaje de respuesta
          resultadoDiv.innerHTML += `
          <div id="resultado1" class="col-12 col-sm-6 col-md-4">
            <a class="Link" href="VerAlbum.php?id=${musica.id}">
              <img class="img-fluid img-busqueda" style="width: 70px; height: 70px;" id="item" src="${
                musica.imagen
              }" alt="">
              <h2 class='nombre-busqueda' style="color: Black; font-size: medium;" id="item"> ${musica.nombre.substring(
                0,
                13
              )}</h2>
            </a>
          </div>`;
        });
      } else {
        resultadoDiv.innerHTML = `<h2 style="color: black;">${data.mensaje}</h2>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      resultadoDiv.innerHTML = `<h2 style="color: black;">Error al buscar músicas</h2>`;
    });
}

// Agregar el event listener cuando se carga la página
document.addEventListener("DOMContentLoaded", function () {
  const formularioBusqueda = document.getElementById("form-buscar-Musica");
  if (formularioBusqueda) {
    formularioBusqueda.addEventListener(
      "submit",
      consultar_en_tiempo_real_Musica
    );
  }
});

function consultar_en_tiempo_real_Album(evento) {
  const formularioBusqueda = document.getElementById("form-buscar-Album");
  const resultadoDiv = document.getElementById("resultado_album");

  if (evento) {
    evento.preventDefault();
  }

  // Obtener el ultimo valor del input
  const nombre_album = document.getElementById("Album").value;

  //se crea un objeto para tomar los valores del formulario
  const formData = new FormData();
  formData.append("Album", nombre_album);
  formData.append("envio", true);

  // se le pasa al fetch el endpoint que genera la consulta de busqueda
  fetch("RF_Busqueda_Album.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      resultadoDiv.innerHTML = ""; // Limpia el contenido previo

      //si el endpoint devuelve 1...
      if (data.status === 1) {
        data.albums.forEach((album) => {
          // se agrega html dentro del div que contiene el mensaje de respuesta
          resultadoDiv.innerHTML += `
          <div id="resultado1" class="col-12 col-sm-6 col-md-4">
            <a class="Link" href="VerAlbum.php?id=${album.id}">
              <img class="img-fluid img-busqueda" style="width: 70px; height: 70px;" id="item" src="${
                album.imagen
              }" alt="">
              <h2 class='nombre-busqueda' style="color: Black; font-size: medium;" id="item"> ${album.nombre.substring(
                0,
                13
              )}</h2>
            </a>
          </div>`;
        });
      } else {
        resultadoDiv.innerHTML = `<h2 style="color: black;">${data.mensaje}</h2>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      resultadoDiv.innerHTML = `<h2 style="color: black;">Error al buscar álbumes</h2>`;
    });
}

// Agregar el event listener cuando se carga la página
document.addEventListener("DOMContentLoaded", function () {
  const formularioBusqueda = document.getElementById("form-buscar-Album");
  if (formularioBusqueda) {
    formularioBusqueda.addEventListener(
      "submit",
      consultar_en_tiempo_real_Album
    );
  }
});

function consultar_en_tiempo_real(evento) {
  const formularioBusqueda = document.getElementById("form-buscar-usuario");
  const resultadoDiv = document.getElementById("resultado");

  formularioBusqueda.addEventListener("submit", consultar_en_tiempo_real);
  // Evita que se recargue la página
  evento.preventDefault();

  // Obtener el ultimo valor del input
  const nombre_usuario = document.getElementById("usuario").value;

  //se crea un objeto para tomar los valores del formulario
  const formData = new FormData();
  formData.append("usuario", nombre_usuario);
  formData.append("envio", true);

  // se le pasa al fetch el endpoint que genera la consulta de busqueda
  fetch("RF_Busqueda.php", {
    method: "POST",
    body: formData,
  })
    //se toma la respuesta y se devuelve en formato json
    .then((response) => response.json())
    //la variable data se usa para recorrer el array asociativo del endpoint...
    .then((data) => {
      resultadoDiv.innerHTML = ""; // Limpia el contenido previo

      //si el enpoint devuelve 1...
      if (data.status === 1) {
        data.usuarios.forEach((user) => {
          resultadoDiv.innerHTML += `
            <div id="resultado1" class="col-12 col-sm-6 col-md-4">
              <a class="Link" href="Ver_artista_YM.php?correo=${user.correo}">
                <img class="img-fluid img-busqueda" style="width: 70px; height: 70px;" id="item" src="${
                  user.perfil
                }" alt="">
                <h2 class='nombre-busqueda' style="color: Black; font-size: medium;" id="item"> ${user.nombre.substring(
                  0,
                  13
                )}</h2>
              </a>
            </div>`;
        });
      } else {
        resultadoDiv.innerHTML = `<h2 style="color: black;">${data.mensaje}</h2>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
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
const urlI = "JSON/instrumentos.json";

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
function verificarSeleccion() {
  // Selecciona todos los checkboxes de géneros
  const checkboxes = document.querySelectorAll('input[name="generos[]"]');
  let seleccionado = false;

  // Verifica si al menos uno está seleccionado
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      seleccionado = true;
    }
  });

  // Selecciona el elemento <p> para mostrar el mensaje de error
  const mensajeError = document.getElementById("mensajeError");

  // Si hay al menos un género seleccionado, muestra la ventana emergente y oculta el mensaje de error
  if (seleccionado) {
    mensajeError.style.display = "none";
    mostrarVentanaEmergente();
  } else {
    // Muestra el mensaje de error si no se selecciona ningún género
    mensajeError.style.display = "block";
  }
}

function mostrarVentanaEmergente() {
  document.getElementById("ventanaEmergente").style.display = "block";
}

function cerrarVentanaEmergente() {
  document.getElementById("ventanaEmergente").style.display = "none";
}

function enviarFormulario(destino) {
  document.getElementById("destinoFinal").value = destino;
  document.getElementById("formGeneros").submit();
}

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
    body: formDataRed,
  })
    .then((Resupuesta) => {
      if (Resupuesta.ok) {
        window.location.href = "Login_YM.php";
      } else {
        console.error("Error al enviar el formulario");
      }
    })
    .catch((error) => {
      console.error("Error en la petición:", error);
    });
}

class MusicCarousel {
  constructor(container) {
    this.container = container;
    this.track = container.querySelector(".carousel-track");
    this.slides = container.querySelectorAll(".carousel-slide");
    this.prevBtn = container.querySelector(".carousel-arrow.prev");
    this.nextBtn = container.querySelector(".carousel-arrow.next");
    this.dotsContainer = container.querySelector(".carousel-dots");

    // Configuración inicial
    this.slideWidth = 300;
    this.currentIndex = 0;
    this.slidesPerView = this.calculateSlidesPerView();
    this.maxIndex = Math.max(0, this.slides.length - this.slidesPerView);

    // Estado del carrusel
    this.isMouseDown = false;
    this.startX = 0;
    this.scrollLeft = 0;

    // Estado del audio
    this.currentAudio = null;
    this.currentPlayButton = null;

    this.init();
  }

  init() {
    this.createDots();
    this.addEventListeners();
    this.updateButtons();
    this.initializeLikeButtons();
    this.initializeAudioPlayers();
  }
  calculateSlidesPerView() {
    const containerWidth = this.container.offsetWidth;
    return Math.floor(containerWidth / this.slideWidth);
  }

  createDots() {
    for (let i = 0; i <= this.maxIndex; i++) {
      const dot = document.createElement("div");
      dot.classList.add("dot");
      if (i === 0) dot.classList.add("active");
      dot.addEventListener("click", () => this.goToSlide(i));
      this.dotsContainer.appendChild(dot);
    }
  }

  addEventListeners() {
    // Botones de navegación
    this.prevBtn?.addEventListener("click", () => this.prev());
    this.nextBtn?.addEventListener("click", () => this.next());

    // Eventos de mouse para drag
    this.track.addEventListener("mousedown", (e) => this.startDragging(e));
    this.track.addEventListener("mousemove", (e) => this.drag(e));
    this.track.addEventListener("mouseup", () => this.stopDragging());
    this.track.addEventListener("mouseleave", () => this.stopDragging());

    // Eventos táctiles
    this.track.addEventListener("touchstart", (e) => this.startDragging(e));
    this.track.addEventListener("touchmove", (e) => this.drag(e));
    this.track.addEventListener("touchend", () => this.stopDragging());

    // Resize observer
    new ResizeObserver(() => {
      this.slidesPerView = this.calculateSlidesPerView();
      this.maxIndex = Math.max(0, this.slides.length - this.slidesPerView);
      this.updateButtons();
    }).observe(this.container);
  }

  startDragging(e) {
    this.isMouseDown = true;
    this.startX = e.type.includes("mouse") ? e.pageX : e.touches[0].pageX;
    this.scrollLeft = this.track.scrollLeft;
  }

  drag(e) {
    if (!this.isMouseDown) return;
    e.preventDefault();
    const x = e.type.includes("mouse") ? e.pageX : e.touches[0].pageX;
    const distance = (x - this.startX) * 2;
    this.track.scrollLeft = this.scrollLeft - distance;
  }

  stopDragging() {
    this.isMouseDown = false;
  }

  prev() {
    if (this.currentIndex > 0) {
      this.currentIndex--;
      this.updateCarousel();
    }
  }

  next() {
    if (this.currentIndex < this.maxIndex) {
      this.currentIndex++;
      this.updateCarousel();
    }
  }

  goToSlide(index) {
    this.currentIndex = index;
    this.updateCarousel();
  }

  updateCarousel() {
    const offset = this.currentIndex * this.slideWidth;
    this.track.scrollTo({
      left: offset,
      behavior: "smooth",
    });

    this.updateDots();
    this.updateButtons();
  }

  updateDots() {
    const dots = this.dotsContainer.querySelectorAll(".dot");
    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === this.currentIndex);
    });
  }

  updateButtons() {
    if (this.prevBtn) {
      this.prevBtn.disabled = this.currentIndex === 0;
      this.prevBtn.style.opacity = this.currentIndex === 0 ? "0.5" : "1";
    }

    if (this.nextBtn) {
      this.nextBtn.disabled = this.currentIndex === this.maxIndex;
      this.nextBtn.style.opacity =
        this.currentIndex === this.maxIndex ? "0.5" : "1";
    }
  }

  initializeLikeButtons() {
    const likeButtons = this.container.querySelectorAll(".like-btn");

    likeButtons.forEach((button) => {
      // Obtener el ID de la música del slide padre
      const musicId = button.closest(".carousel-slide").dataset.musicId;

      button.addEventListener("click", async () => {
        const icon = button.querySelector("i");
        const isLiked = icon.classList.contains("bi-heart-fill");

        try {
          // Crear FormData para enviar
          const formData = new FormData();
          formData.append("musicId", musicId);
          formData.append("action", isLiked ? "remove" : "add");

          // Realizar petición AJAX
          const response = await fetch("RF_Likes_YM.php", {
            method: "POST",
            body: formData,
          });

          const data = await response.json();

          if (data.success) {
            // Alternar clases de icono
            icon.classList.toggle("bi-heart");
            icon.classList.toggle("bi-heart-fill");
            button.classList.toggle("active");
          } else {
            console.error("Error:", data.message);
            alert("Error al procesar el like");
          }
        } catch (error) {
          console.error("Error:", error);
          alert("Error al procesar la solicitud");
        }
      });
    });
  }

  initializePlayButtons() {
    const playButtons = this.container.querySelectorAll(".play-btn");
    playButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const icon = button.querySelector("i");
        const isPlaying = icon.classList.contains("bi-pause-fill");

        // Pausar todos los demás
        playButtons.forEach((btn) => {
          btn
            .querySelector("i")
            .classList.replace("bi-pause-fill", "bi-play-fill");
        });

        // Cambiar el estado del botón actual
        if (!isPlaying) {
          icon.classList.replace("bi-play-fill", "bi-pause-fill");
        }
      });
    });
  }
  initializeAudioPlayers() {
    const playButtons = this.container.querySelectorAll(".play-btn");

    playButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const musicId = button.dataset.musicId;
        const audio = document.getElementById(`audio-${musicId}`);
        const icon = button.querySelector("i");

        // Si hay un audio reproduciéndose y no es el mismo que se clickeó
        if (this.currentAudio && this.currentAudio !== audio) {
          this.stopCurrentAudio();
        }

        // Alternar entre reproducir y pausar
        if (audio.paused) {
          audio
            .play()
            .then(() => {
              icon.classList.remove("bi-play-fill");
              icon.classList.add("bi-pause-fill");
              this.currentAudio = audio;
              this.currentPlayButton = button;
            })
            .catch((error) => {
              console.error("Error al reproducir el audio:", error);
            });
        } else {
          this.pauseCurrentAudio();
        }
      });

      // Manejar el fin de la reproducción
      const audio = document.getElementById(`audio-${button.dataset.musicId}`);
      audio.addEventListener("ended", () => {
        this.resetPlayButton(this.currentPlayButton);
        this.currentAudio = null;
        this.currentPlayButton = null;
      });
    });
  }

  stopCurrentAudio() {
    if (this.currentAudio) {
      this.currentAudio.pause();
      this.currentAudio.currentTime = 0;
      this.resetPlayButton(this.currentPlayButton);
    }
  }

  pauseCurrentAudio() {
    if (this.currentAudio) {
      this.currentAudio.pause();
      this.resetPlayButton(this.currentPlayButton);
      this.currentAudio = null;
      this.currentPlayButton = null;
    }
  }

  resetPlayButton(button) {
    if (button) {
      const icon = button.querySelector("i");
      icon.classList.remove("bi-pause-fill");
      icon.classList.add("bi-play-fill");
    }
  }

  // Modificar el método updateCarousel para detener la reproducción al cambiar de slide
  updateCarousel() {
    const offset = this.currentIndex * this.slideWidth;
    this.track.scrollTo({
      left: offset,
      behavior: "smooth",
    });

    // Detener la reproducción actual al cambiar de slide
    this.stopCurrentAudio();

    this.updateDots();
    this.updateButtons();
  }
}

// Inicializar todos los carruseles cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  // Obtener todos los contenedores de carrusel
  const carouselContainers = document.querySelectorAll(".carousel-container");

  // Crear una instancia de MusicCarousel para cada contenedor
  carouselContainers.forEach((container) => {
    new MusicCarousel(container);
  });
});
