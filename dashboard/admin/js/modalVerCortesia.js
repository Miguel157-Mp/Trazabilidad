function modalVerCortesia(idCortesia, idNotificacion) {
  const url = `./controllers/trazabilidadDetalleCortesia.php?id=${idCortesia}`;

  fetch(url)
    .then((response) => response.json())
    .then((cortesia) => {
      $("#verCortesiaModalLabel").text(
        `Cortesía Nº ${idCortesia} - ${cortesia.estatus}`
      );
      $("#modalId").text(idCortesia);
      $("#modalFecha").text(cortesia.fecha);
      $("#modalHora").text(cortesia.hora);
      $("#modalDirector").text(cortesia.director);
      $("#modalSupervisor").text(cortesia.supervisor);
      $("#modalTienda").text(cortesia.tienda);
      $("#modalBeneficiario").text(cortesia.beneficiario);
      $("#modalProductosAsignados").text(cortesia.productosAsignados);
      if (cortesia.estatus == "Procesado" || cortesia.estatus == "Autorizado") {
        $("#modalProductosEntregados").text(cortesia.productosEntregados);
        $("#modalNotaEntrega").text(cortesia.notaEntrega);
        $("#spanProcesado").removeAttr("hidden");
      }
      if (cortesia.estatus == "Autorizado") {
        $("#modalTipoAprobacion").text(cortesia.tipoAprobacion);
        $("#modalObservacion").text(cortesia.observacion);
        $("#spanAutorizado").removeAttr("hidden");
      }
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
