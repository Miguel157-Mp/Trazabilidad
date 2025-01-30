function modalVerConglomerado(idConglomerado, idNotificacion) {
  const url = `./controllers/trazabilidadDetalleConglomerado.php?id=${idConglomerado}`;

  fetch(url)
    .then((response) => response.json())
    .then((conglomerado) => {
      $("#verConglomeradoModalLabel").text(
        `Conglomerado Nº ${idConglomerado} - ${conglomerado.estatus}`
      );
      $("#modalIdConglomerado").text(idConglomerado);
      $("#modalFechaConglomerado").text(conglomerado.fecha);
      $("#modalHoraConglomerado").text(conglomerado.hora);
      $("#modalSupervisorConglomerado").text(conglomerado.supervisor);
      $("#modalTiendaConglomerado").text(conglomerado.tienda);
      $("#modalPeriodoConglomerado").text(conglomerado.observacion);
      $("#modalMontoConglomeradoBs").text(conglomerado.bs);
      $("#modalMontoConglomeradoUsd").text(conglomerado.usd);
      $("#modalMontoConglomeradoEur").text(conglomerado.eur);

      if (
        Conglomerado.estatus == "Confirmado por Director" ||
        conglomerado.estatus == "Confirmado por Tesoreria"
      ) {
        $("#modalEntregadoAConglomerado").text(conglomerado.entregado);
        $("#spanEntregado").removeAttr("hidden");
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
