document.addEventListener('DOMContentLoaded', function() {
  // Obtener los valores de los campos de texto
  let redes = [
    document.getElementById('Red1').value,
    document.getElementById('Red2').value,
    document.getElementById('Red3').value,
    document.getElementById('Red4').value
  ];

  // Mostrar los iconos de las redes sociales
  redes.forEach(function(link) {
    if (link !== '') {
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
    }
  });
});



document.addEventListener('DOMContentLoaded', function() {
  const audioPlayers = document.querySelectorAll('.custom-audio-player');
  
  // Detener otras canciones cuando se reproduce una nueva
  audioPlayers.forEach(player => {
      player.addEventListener('play', function() {
          audioPlayers.forEach(otherPlayer => {
              if (otherPlayer !== player && !otherPlayer.paused) {
                  otherPlayer.pause();
              }
          });
      });
  });

  // Mejorar la experiencia del usuario al hacer clic en la canción
  const songItems = document.querySelectorAll('.song-item');
  songItems.forEach(item => {
      item.addEventListener('click', function(e) {
          // Si el clic no fue en el control de audio
          if (!e.target.closest('audio')) {
              const audio = this.querySelector('audio');
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

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formMusica');

    form.addEventListener('submit', async function(e) {
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
    });

    actualizarListaCanciones(); // Cargar canciones existentes al cargar la página
});
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

function VerificarDatos(){
  const form = document.querySelector('form');
  const nombreInput = document.getElementById('nombre');
  const emailInput = document.getElementById('email');
  const passInput = document.getElementById('pass');
  const ubicacionInput = document.getElementById('Ubicación');
  const biografiaInput = document.getElementById('biografia');
  const fileInput = document.getElementById('file');

  // Crear el contenedor de errores solo si no existe
  let errorContainer = document.querySelector('.error-container');
  if (!errorContainer) {
    errorContainer = document.createElement('div');
    errorContainer.classList.add('error-container');
    form.insertAdjacentElement('beforeend', errorContainer);
  }

  // Eliminar el evento submit anterior si existe
  const oldListener = form.onsubmit;
  form.onsubmit = null;

  // Agregar el nuevo evento submit
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
      showError('La contraseña debe tener al menos 7 caracteres y máximo 30, incluyendo una mayúscula, una letra y un número, no debe contener caracteres especiales.');
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
// Llamar a la función una sola vez al cargar la página
document.addEventListener('DOMContentLoaded', VerificarDatos);


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
          // se agrega html dentro del div que contiene el mensaje de respuesta
          resultadoDiv.innerHTML += `
              <div id="resultado1" class="col-12 col-sm-6 col-md-4">
                  <a class="Link" href="Ver_artista_YM.php?correo=${user.correo}">
                      <img class="img-fluid img-busqueda" style="width: 70px; height: 70px;" id="item" src="${user.perfil}" alt="">
                      <h2 class='nombre-busqueda' style="color: Black; font-size: medium;" id="item"> ${user.nombre}</h2>
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

class MusicCarousel {
  constructor() {
      this.container = document.querySelector('.carousel-container');
      this.track = this.container.querySelector('.carousel-track');
      this.slides = this.container.querySelectorAll('.carousel-slide');
      this.prevBtn = this.container.querySelector('.carousel-arrow.prev');
      this.nextBtn = this.container.querySelector('.carousel-arrow.next');
      this.dotsContainer = this.container.querySelector('.carousel-dots');
      
      this.slideWidth = 300;
      this.currentIndex = 0;
      this.slidesPerView = this.calculateSlidesPerView();
      this.maxIndex = Math.max(0, this.slides.length - this.slidesPerView);
      
      this.isMouseDown = false;
      this.startX = 0;
      this.scrollLeft = 0;
      this.init();this.currentAudio = null;
      this.currentPlayButton = null;
    }
    
    init() {
      this.createDots();
      this.addEventListeners();
      this.updateButtons();
      this.initializeLikeButtons();
      this.initializeAudioPlayers(); // método para inicializar el audio
    }
  
  calculateSlidesPerView() {
      const containerWidth = this.container.offsetWidth;
      return Math.floor(containerWidth / this.slideWidth);
  }
  
  createDots() {
      for (let i = 0; i <= this.maxIndex; i++) {
          const dot = document.createElement('div');
          dot.classList.add('dot');
          if (i === 0) dot.classList.add('active');
          dot.addEventListener('click', () => this.goToSlide(i));
          this.dotsContainer.appendChild(dot);
      }
  }
  
  addEventListeners() {
      // Botones de navegación
      this.prevBtn?.addEventListener('click', () => this.prev());
      this.nextBtn?.addEventListener('click', () => this.next());
      
      // Eventos de mouse para drag
      this.track.addEventListener('mousedown', (e) => this.startDragging(e));
      this.track.addEventListener('mousemove', (e) => this.drag(e));
      this.track.addEventListener('mouseup', () => this.stopDragging());
      this.track.addEventListener('mouseleave', () => this.stopDragging());
      
      // Eventos táctiles
      this.track.addEventListener('touchstart', (e) => this.startDragging(e));
      this.track.addEventListener('touchmove', (e) => this.drag(e));
      this.track.addEventListener('touchend', () => this.stopDragging());
      
      // Resize observer
      new ResizeObserver(() => {
          this.slidesPerView = this.calculateSlidesPerView();
          this.maxIndex = Math.max(0, this.slides.length - this.slidesPerView);
          this.updateButtons();
      }).observe(this.container);
  }
  
  startDragging(e) {
      this.isMouseDown = true;
      this.startX = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
      this.scrollLeft = this.track.scrollLeft;
  }
  
  drag(e) {
      if (!this.isMouseDown) return;
      e.preventDefault();
      const x = e.type.includes('mouse') ? e.pageX : e.touches[0].pageX;
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
          behavior: 'smooth'
      });
      
      this.updateDots();
      this.updateButtons();
  }
  
  updateDots() {
      const dots = this.dotsContainer.querySelectorAll('.dot');
      dots.forEach((dot, index) => {
          dot.classList.toggle('active', index === this.currentIndex);
      });
  }
  
  updateButtons() {
      if (this.prevBtn) {
          this.prevBtn.disabled = this.currentIndex === 0;
          this.prevBtn.style.opacity = this.currentIndex === 0 ? '0.5' : '1';
      }
      
      if (this.nextBtn) {
          this.nextBtn.disabled = this.currentIndex === this.maxIndex;
          this.nextBtn.style.opacity = this.currentIndex === this.maxIndex ? '0.5' : '1';
      }
  }
  
  initializeLikeButtons() {
    const likeButtons = this.container.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        // Obtener el ID de la música del slide padre
        const musicId = button.closest('.carousel-slide').dataset.musicId;
        
        button.addEventListener('click', async () => {
            const icon = button.querySelector('i');
            const isLiked = icon.classList.contains('bi-heart-fill');
            
            try {
                // Crear FormData para enviar
                const formData = new FormData();
                formData.append('musicId', musicId);
                formData.append('action', isLiked ? 'remove' : 'add');
                
                // Realizar petición AJAX
                const response = await fetch('RF_Likes_YM.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Alternar clases de icono
                    icon.classList.toggle('bi-heart');
                    icon.classList.toggle('bi-heart-fill');
                    button.classList.toggle('active');
                } else {
                    console.error('Error:', data.message);
                    alert('Error al procesar el like');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            }
        });
    });
}
  
  initializePlayButtons() {
      const playButtons = this.container.querySelectorAll('.play-btn');
      playButtons.forEach(button => {
          button.addEventListener('click', () => {
              const icon = button.querySelector('i');
              const isPlaying = icon.classList.contains('bi-pause-fill');
              
              // Pausar todos los demás
              playButtons.forEach(btn => {
                  btn.querySelector('i').classList.replace('bi-pause-fill', 'bi-play-fill');
              });
              
              // Cambiar el estado del botón actual
              if (!isPlaying) {
                  icon.classList.replace('bi-play-fill', 'bi-pause-fill');
              }
          });
      });
  }
  initializeAudioPlayers() {
    const playButtons = this.container.querySelectorAll('.play-btn');
    
    playButtons.forEach(button => {
      button.addEventListener('click', () => {
        const musicId = button.dataset.musicId;
        const audio = document.getElementById(`audio-${musicId}`);
        const icon = button.querySelector('i');
        
        // Si hay un audio reproduciéndose y no es el mismo que se clickeó
        if (this.currentAudio && this.currentAudio !== audio) {
          this.stopCurrentAudio();
        }
        
        // Alternar entre reproducir y pausar
        if (audio.paused) {
          audio.play().then(() => {
            icon.classList.remove('bi-play-fill');
            icon.classList.add('bi-pause-fill');
            this.currentAudio = audio;
            this.currentPlayButton = button;
          }).catch(error => {
            console.error('Error al reproducir el audio:', error);
          });
        } else {
          this.pauseCurrentAudio();
        }
      });

      // Manejar el fin de la reproducción
      const audio = document.getElementById(`audio-${button.dataset.musicId}`);
      audio.addEventListener('ended', () => {
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
      const icon = button.querySelector('i');
      icon.classList.remove('bi-pause-fill');
      icon.classList.add('bi-play-fill');
    }
  }

  // Modificar el método updateCarousel para detener la reproducción al cambiar de slide
  updateCarousel() {
    const offset = this.currentIndex * this.slideWidth;
    this.track.scrollTo({
      left: offset,
      behavior: 'smooth'
    });
    
    // Detener la reproducción actual al cambiar de slide
    this.stopCurrentAudio();
    
    this.updateDots();
    this.updateButtons();
  }
}

// Inicializar el carrusel cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  const carousel = new MusicCarousel();
});