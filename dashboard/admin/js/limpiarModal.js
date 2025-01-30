$(document).ready(function () {
  //Detectar cuando se cierran los modales para limpiarlos
  $(".modal").on("hidden.bs.modal", function () {
    $(".ocultar").attr("hidden", true);
    $(".campoModal").text("");
  });
});
