function modalVerProyeccion(idProyeccion, idNotificacion) {
  const url = `./controllers/trazabilidadDetalleProyeccion.php?id=${idProyeccion}`;

  fetch(url)
    .then((response) => response.json())
    .then((proyeccion) => {
      $("#verProyeccionModalLabel").text(`Proyeccion Nº ${idProyeccion}`);
      $("#modalIdProyeccion").text(idProyeccion);
      $("#modalFechaProyeccion").text(proyeccion.fecha);
      $("#modalHoraProyeccion").text(proyeccion.hora);
      $("#modalPeriodoProyeccion").text(proyeccion.observacion);
      $("#modalMontoProyeccionUsd").text(proyeccion.usd);
    })
    .catch((error) => console.error("Error:", error));

  formdata = {
    id: idNotificacion,
  };

  $.ajax({
    url: "./controllers/trazabilidadNotificacionLeida.php",
    type: "POST",
    data: formdata,
    dataType: "json",
    success: function (response) {
      verificarNotificaciones();
      const trId = `#tr${idNotificacion}`;
      $(trId).removeClass("table-info");
    },
    error: function (jqXHR, status, error) {
      console.error(jqXHR, status, error);
    },
  });
}
