function modalVerRecibo(idRecibo, idNotificacion) {
  const url = `./controllers/trazabilidadDetalleRecibo.php?id=${idRecibo}`;

  fetch(url)
    .then((response) => response.json())
    .then((recibo) => {
      $("#verReciboModalLabel").text(
        `Recibo Nº ${idRecibo} - ${recibo.estatus}`
      );
      $("#modalIdRecibo").text(idRecibo);
      $("#modalFechaRecibo").text(recibo.fecha);
      $("#modalHoraRecibo").text(recibo.hora);
      $("#modalSupervisorRecibo").text(recibo.supervisor);
      $("#modalTiendaRecibo").text(recibo.tienda);
      $("#modalPeriodoRecibo").text(recibo.periodo);
      $("#modalMontoBs").text(recibo.bs);
      $("#modalMontoUsd").text(recibo.usd);
      $("#modalMontoEur").text(recibo.eur);

      if (
        recibo.estatus != "Enviado a Supervisor" &&
        recibo.estatus != "Confirmado por Supervisor"
      ) {
        $("#modalEntregadoARecibo").text(recibo.entregado);
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
