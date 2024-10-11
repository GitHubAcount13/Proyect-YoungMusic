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
  .then((response) => response.json())
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
  .then((response) => response.json())
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
  .then((response) => response.json())
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
  

  const formData = new FormData();
  formData.append("Red1", red1);
  formData.append("Red2", red2);
  formData.append("Red3", red3);
  formData.append("Red4", red4);
  formData.append("envio", true); 
  

  fetch("RF_Redes_Disc_YM.php", {
    method: "POST",
    body: formData
  })
  .then(response => {
    if (response.ok) {

      window.location.href = "Login_YM.php";
    } else {
      console.error("Error al enviar el formulario");
    }
  })
  .catch(error => {
    console.error("Error en la petición:", error);
  });
}

