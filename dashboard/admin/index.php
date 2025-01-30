<?php
include("../cabecerasBootstap.php");
//include("../db/conexionProfit.php");
?>
<!-- Site Properties -->
<title>Suscripcion vidapets</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Titan+One&display=swap" rel="stylesheet">
<style>
  .letra {
    font-family: 'Titan One', cursive;
  }

 
  

</style>
<head>

</head>

<body>

  <div class="container">
    <!-- Content here -->
    <div class="row">
      <div class="col-sm">
        <div id="exitos"></div>
        <div id="errors"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <div id="exito2"></div>
        <div id="error2"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <form class="row g-3 form-club" id="formclub" novalidate style="padding: 20px 0px 20px 0px;">

          <div class="col-sm">

          <div class="mb-3">
    <label for="tipomascota" class="form-label letra">Datos personales</label>
    <div class="form-floating">
        <input type="text" class="form-control" placeholder="Nombre completo" id="nombreCompleto" required name="nombreCompleto" autocomplete="off" pattern="^[a-zA-Z\s]+$" title="Por favor, ingrese solo letras sin acentos y espacios">
        <label for="nombreCompleto">Nombre completo</label>
    </div>

    <script>
    document.getElementById("nombreCompleto").addEventListener("input", function(event) {
        var inputValue = event.target.value;
        var cleanedValue = removeAccents(inputValue);
        if (cleanedValue !== inputValue) {
            event.target.value = cleanedValue;
        }
    });

    function removeAccents(input) {
        return input.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }
</script>
   



            <div class="mb-3">
              <div class="form-floating">
                <input type="email" class="form-control" placeholder="Correo" id="correo" required name="correo" autocomplete="off">
                <label for="correo">Correo</label>
              </div>
            </div>
            <div class="mb-3">
              <label for="servadd" class="form-label">Nacionalidad</label>
              <input class="form-check-input" type="radio" name="nacionalidad" value="V" id="nacionalidadV">
              <label class="form-check-label" for="nacionalidadV">
                V
              </label>
              <input class="form-check-input" type="radio" name="nacionalidad" value="E" id="nacionalidadE">
              <label class="form-check-label" for="nacionalidadE">
                E
              </label>
              <input class="form-check-input" type="radio" name="nacionalidad" value="J" id="nacionalidadJ">
              <label class="form-check-label" for="nacionalidadJ">
                J
              </label>
            </div>



            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="C.I" required maxlength="8" minlength="5" name="ci" id="ci" autocomplete="off">
                <label for="ci">C.I</label>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="Teléfono" required name="tlf" id="tlf" autocomplete="off">
                <label for="tlf">Teléfono</label>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-floating">
                <textarea autocomplete="off" class="form-control" placeholder="Direccion" id="direccion" name="direccion" required></textarea>
                <label for="direccion">Dirección</label>
              </div>
            </div>
            <div class="mb-3">

              <div class="form-floating"><!--Aqui esta el UNIPERSONAL-->
              <input type="text" class="form-control" placeholder="Teléfono" required name="tiporegistro" id="tiporegistro" autocomplete="off" value="Unipersonal" readonly>
                <!--select class="form-select" id="tiporegistro" aria-label="Floating label select example"  disabled>

                  <option value="Unipersonal" selected>Unipersonal</option>
                  <option value="Caraca - Las Mercedes">Caraca - Las Mercedes</option>
                  <option value="Caraca - Bello Monte">Caraca - Bello Monte</option>
                  <option value="Caraca - Santa Eduvigis">Caraca - Santa Eduvigis</option>
                  <option value="Caraca - La Mansión">Caraca - La Mansión</option>
                  <option value="Caraca - C.C Valle Arriba">Caraca - C.C Valle Arriba"</option>
                  <option value="Caraca - La Trinidad">Caraca - La Trinidad</option>
                  <option value="Maracay - C.C Locatel">Maracay - C.C Locatel</option>
                  <option value="Maracay - C.C Unicentro">Maracay - C.C Unicentro</option>
                  <option value="Valencia - LA Granja">Valencia - LA Granja</option>
                  <option value="Valencia - El Viñedo">Valencia - El Viñedo</option>
                  <option value="Barquisimeto - C.C Las Trinitarias">Barquisimeto - C.C Las Trinitarias</option>
                  <option value="Barquisimeto - Nueva Segovia">Barquisimeto - Nueva Segovia</option>
                </select-->
                <label for="registro" class="form-label">Registro</label>
              </div>




            </div>
          </div>

          <!-- mascota n1-->
          <div class="col-sm mascota1">
            <div class="mb-3">
              <label for="" class="form-label letra">Datos de la mascota</label>

              <div class="form-floating">
                <select class="form-select" id="tipomascota" aria-label="Floating label select example" required onchange="cambiar()">
                  <option value="">--</option>
                  <option value="gato">Gato</option>
                  <option value="perro">Perro</option>
                </select>
                <div class="valid-feedback">
                  <img src="<?php echo $path; ?>svgs/solid/paw.svg" width="16" alt="">
                </div>
                <div id="tipomascotaHelp" class="form-text"></div>
                <label for="tipomascota">Seleccione si es gato o perro</label>
              </div>

            </div>
            <!-- perro -->
            <div class="mb-3 perro" style="display:none;">
              <label for="razaperro" class="form-label">Raza perro</label>
              <input class="form-control" list="listaRazaPerro" id="razaperro" name="razaperro" placeholder="Escriba para buscar..." required disabled>
              <datalist id="listaRazaPerro">
                <option value="AFGANO">
                <option value="AIREDALE TERRIER">
                <option value="AIREDALE TERRIER">
                <option value="AKITA AMERICANO">
                <option value="ALASKA MALAMUTE">
                <option value="AMERICAN BULLY">
                <option value="AMERICAN PITBULL TERRIER">
                <option value="AMERICAN STAFFORDSHIRE TERRIER">
                <option value="BASSET HOUND">
                <option value="BEAGLE">
                <option value="BEAGLE HARRIER">
                <option value="BERNEDOODLE">
                <option value="BICHÓN">
                <option value="BICHON FRISE">
                <option value="BICHÓN FRISÉ MINI">
                <option value="BICHON HABANERO">
                <option value="BICHON MALTES">
                <option value="BOBTAIL">
                <option value="BODEGUERO ANDALUZ">
                <option value="BORDER COLLIE">
                <option value="BOSTON TERRIER">
                <option value="BOXER">
                <option value="BOYERO BERNES SUIZO">
                <option value="BOYERO DE BERNA">
                <option value="BRACO">
                <option value="BRACO ALEMAN">
                <option value="BULL TERRIER">
                <option value="BULLDOG">
                <option value="BULLDOG FRANCES">
                <option value="BULLDOG INGLES">
                <option value="CACRI">
                <option value="CAIRN TERRIER">
                <option value="CANE CORSO">
                <option value="CANICHE">
                <option value="CAVALIER KING">
                <option value="CAZADOR">
                <option value="CHIHUAHUA">
                <option value="CHIWEENIE">
                <option value="CHOW CHOW">
                <option value="COCKAPOO">
                <option value="COCKER">
                <option value="COCKER SPANIEL">
                <option value="COLLIE">
                <option value="CORGI">
                <option value="COTON DE TULEA">
                <option value="CRIKA">
                <option value="DACHSHUND">
                <option value="DALMATA">
                <option value="DOBERMAN">
                <option value="DOBERMAN ENANO">
                <option value="DOBERMAN PINSCHER">
                <option value="DOGO ARGENTINO">
                <option value="DOGO DE BURDEOS">
                <option value="FILA">
                <option value="FILA BRASILEIRO">
                <option value="FLAT RETRIEVER">
                <option value="FOX TERRIER">
                <option value="GALGO">
                <option value="GANADERO AUSTRALIANO">
                <option value="GOBERIAN">
                <option value="GOLDEN RETRIEVER">
                <option value="GOLDEN TOY">
                <option value="GOLDENDOODLE">
                <option value="GOS VALENCIANO">
                <option value="GRAN DANÉS">
                <option value="GRIFON DE BRUSELLA">
                <option value="HIGHLAND TERRIER">
                <option value="HUSKY">
                <option value="JACK RUSSELL">
                <option value="KAKRI">
                <option value="KAPOO">
                <option value="LABRADOR">
                <option value="LHASA APSO">
                <option value="LOBO">
                <option value="LOBO MALIBU">
                <option value="LOBO SIBERIANO">
                <option value="LURCHER">
                <option value="MALTÉS">
                <option value="MALTIPOO">
                <option value="MASTÍN NAPOLITANO">
                <option value="MESTIZO">
                <option value="MINI DÓBERMAN">
                <option value="MINI PINCHER">
                <option value="MINI TOY">
                <option value="MINI YORKSHIRE TERRIER">
                <option value="MORKIE">
                <option value="MUCUCHÍES">
                <option value="PARSON RUSSELL">
                <option value="PASTOR">
                <option value="PASTOR ALEMÁN">
                <option value="PASTOR AUSTRALIANO">
                <option value="PASTOR BELGA">
                <option value="PASTOR BLANCO">
                <option value="PASTOR CATALAN">
                <option value="PASTOR GORBEA">
                <option value="PASTOR HOLANDÉS">
                <option value="PASTOR LAPON">
                <option value="PASTOR OVEJERO INGLES">
                <option value="PEQUINES">
                <option value="PERRO DE AGUA PORTUGUÉS">
                <option value="PERRO DE CAROLINA">
                <option value="PINSCHER">
                <option value="PINSCHER MINI">
                <option value="PINY POO">
                <option value="PITBULL">
                <option value="PITSKY">
                <option value="POINTER INGLÉS">
                <option value="POMCHI">
                <option value="POMERANIA">
                <option value="POMSKY">
                <option value="PONDECO ANDALUZ">
                <option value="POOCHON">
                <option value="POODLE">
                <option value="POODLE MINI TOY">
                <option value="PUG CARLINO">
                <option value="PUMSKY">
                <option value="RAT TERRIER">
                <option value="RETRIEVER">
                <option value="RETRIEVER DE NUEVA ESCOCIA">
                <option value="RETRIVER PELO LISO">
                <option value="RODESIANO">
                <option value="ROTTSKY">
                <option value="ROTTWEILER">
                <option value="ROUGH COLLIE">
                <option value="ROUGH TERRIER">
                <option value="SABUESO">
                <option value="SABUESO AZUL">
                <option value="SAMOYEDO">
                <option value="SAN BERNARDO">
                <option value="SANOYODO">
                <option value="SCHIPPERKI">
                <option value="SCOTTISH TERRIER">
                <option value="SEDER IRLANDÉS">
                <option value="SHAR PEI">
                <option value="SHELTIE">
                <option value="SHIBA INU">
                <option value="SHIH POO">
                <option value="SHIH TZU">
                <option value="SHORKSHIELD">
                <option value="SILKY TERRIER">
                <option value="SILKY TERRIER AUSTRALIANO">
                <option value="SMOOTH COLLIE">
                <option value="SNHAUZER">
                <option value="SPANIEL TIBETANO">
                <option value="SPITZ ALEMÁN">
                <option value="SPRINGER SPANIEL INGLÉS">
                <option value="STAFFORDSHIRE">
                <option value="STAFFORDSHIRE BULL TERRIER">
                <option value="STAFFY">">
                <option value="STANFORDSHIRE TERRIER STAFY">
                <option value="TERRIER">
                <option value="VELGA MARINOU">
                <option value="WEIMARANER">
                <option value="WEST HIGHLAND WHITE TERRIER">
                <option value="WESTIE">
                <option value="XOLOITZCUINTLE">
                <option value="YORKSHIRE">
              </datalist>
            </div>
            <!-- gato -->
            <div class="mb-3 gato" style="display:none;">
              <label for="razagato" class="form-label">Raza gato</label>
              <input class="form-control" list="listaRazaGato" id="razagato" name="razagato" placeholder="Escriba para buscar..." required disabled>
              <datalist id="listaRazaGato">
                <option value="American Short Hair">
                <option value="American Wirehair">
                <option value="Americano pelo corto">
                <option value="Americano pelo largo">
                <option value="Angora">
                <option value="Atigrado">
                <option value="Basadita">
                <option value="Bengalí">
                <option value="Bicolor blanco y negro">
                <option value="Bicolor Europea">
                <option value="Blanco pelo largo">
                <option value="Bobtail">
                <option value="Bobtail americano">
                <option value="Bobtail Japonés">
                <option value="Bombay">
                <option value="Bosque de noruega">
                <option value="Británico bicolor">
                <option value="Burmilla">
                <option value="Cálico">
                <option value="Californiano">
                <option value="Carey">
                <option value="Cartujo">
                <option value="Cazador">
                <option value="Chartreux">
                <option value="Ciames">
                <option value="Doméstico">
                <option value="Domestico pelo corto">
                <option value="Egipcia-Angora">
                <option value="Esmoquin">
                <option value="Europeo">
                <option value="Exotic">
                <option value="Felina bicolor">
                <option value="Feliz catu">
                <option value="Gato común europeo">
                <option value="Ginger">
                <option value="Gris">
                <option value="Himalayo">
                <option value="Javanés máscara amarilla">
                <option value="Khao manee">
                <option value="Maine coon">
                <option value="Mau egipcio">
                <option value="Moggie">
                <option value="Mombay">
                <option value="Naranja">
                <option value="Negrito Criollo">
                <option value="Pelo corto">
                <option value="Pelo Corto Europeo">
                <option value="Pelo largo">
                <option value="Persa">
                <option value="Persa Cara de Muñeca">
                <option value="Persa clasico">
                <option value="Persa extremo">
                <option value="Persa Himalayo">
                <option value="Persa mezclada ">
                <option value="Rayado">
                <option value="Ruso azul">
                <option value="Ruso">
                <option value="Serengeti">
                <option value="Scottish Fold">
                <option value="Siames">
                <option value="Siberiano">
                <option value="Silvestre">
                <option value="Smoking">
                <option value="Soleil">
                <option value="Somalie">
                <option value="Tabby">
                <option value="Tabby 2 colores">
                <option value="Tabby Americano">
                <option value="Tabby Gris">
                <option value="Tabby naranja">
                <option value="Tabit point">
                <option value="tabitricolor">
                <option value="Texudo">
                <option value="Tricolor">
                <option value="Tuxedo">
                <option value="Van Turco">
                <option value="Xoloitzcuintle">
              </datalist>
            </div>

            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="Nombre mascota" id="nombreMascota" required name="nombreMascota" autocomplete="off">
                <label for="nombreMascota">Nombre mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-floating datepicker">
                <input type="date" class="form-control" placeholder="Fecha nacimiento mascota" id="fechaMascota" name="fechaMascota" required autocomplete="off">
                <label for="fechaMascota">Fecha nacimiento de la mascota</label>
              </div>
            </div>



            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="ejmplo 3 años 2 meses" id="edadMascota" name="edadMascota" required autocomplete="off">
                <label for="edadMascota">Edad mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <label for="servadd" class="form-label">Sexo</label>
              <input class="form-check-input" type="radio" name="sexoMascota" id="sexoMascotaM" value="macho">
              <label class="form-check-label" for="sexoMascotaM">
                Macho
              </label>
              <input class="form-check-input" type="radio" name="sexoMascota" id="sexoMascotaH" value="hembra">
              <label class="form-check-label" for="sexoMascotaH">
                Hembra
              </label>
            </div>
            <div class="mb-3 b1">
              <label for="servadd" class="form-label">Quieres agregar otra mascota?</label>
              <figcaption class="blockquote-footer">
                <cite title="Source Title">Puede registrar un máximo de 3 mascotas</cite>
              </figcaption>
              <input type="button" class="btn btn-info" value="Agregar otra mascota" onclick="mostrarMascota2()">
            </div>
          </div>

          <!-- mascota n2-->
          <div class="col-sm mascota2">
            <div class="mb-3">
              <label for="" class="form-label letra">Datos de la 2da mascota</label>

              <div class="form-floating">
                <select class="form-select" id="tipomascota2" aria-label="Floating label select example" required onchange="cambiar2()" disabled>
                  <option value="">--</option>
                  <option value="gato">Gato</option>
                  <option value="perro">Perro</option>
                </select>
                <div class="valid-feedback">
                  <img src="<?php echo $path; ?>svgs/solid/paw.svg" width="16" alt="">
                </div>
                <div id="tipomascotaHelp" class="form-text"></div>
                <label for="tipomascota2">Seleccione si es gato o perro</label>
              </div>

            </div>
            <!-- perro -->
            <div class="mb-3 perro2" style="display:none;">
              <label for="razaperro2" class="form-label">Raza perro</label>
              <input class="form-control" list="listaRazaPerro2" id="razaperro2" name="razaperro2" placeholder="Escriba para buscar..." required disabled>
              <datalist id="listaRazaPerro2">
                <option value="Mestizo">
                <option value="Labrador retriever">
                <option value="Bulldog francés">
                <option value="Golden retriever">
                <option value="Pastor alemán">
                <option value="Caniche">
                <option value="Bulldog">
                <option value="Beagle">
                <option value="Rottweiler">
                <option value="Braco alemán de pelo corto">
                <option value="Dachshund">
              </datalist>
            </div>
            <!-- gato -->
            <div class="mb-3 gato2" style="display:none;">
              <label for="razagato2" class="form-label">Raza gato</label>
              <input class="form-control" list="listaRazaGato2" id="razagato2" name="razagato2" placeholder="Escriba para buscar..." required disabled>
              <datalist id="listaRazaGato2">
                <option value="Mestizo">
                <option value="Persa">
                <option value="Azul ruso">
                <option value="Siamés">
                <option value="Angora turco">
                <option value="Siberiano">
                <option value="Maine Coon">
                <option value="Bengalí">
              </datalist>
            </div>


            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="Nombre mascota" id="nombreMascota2" required name="nombreMascota2" autocomplete="off" disabled>
                <label for="nombreMascota2">Nombre mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-floating datepicker">
                <input type="date" class="form-control" placeholder="Fecha nacimiento mascota" id="fechaMascota2" name="fechaMascota2" required autocomplete="off" disabled>
                <label for="fechaMascota2">Fecha nacimiento de la mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="ejmplo 3 años 2 meses" id="edadMascota2" name="edadMascota2" required autocomplete="off" disabled>
                <label for="edadMascota2">Edad mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <label for="servadd" class="form-label">Sexo</label>
              <input class="form-check-input" type="radio" name="sexoMascota2" disabled id="sexoMascotaM2" value="macho">
              <label class="form-check-label" for="sexoMascotaM2">
                Macho
              </label>
              <input class="form-check-input" type="radio" name="sexoMascota2" disabled id="sexoMascotaH2" value="hembra">
              <label class="form-check-label" for="sexoMascotaH2">
                Hembra
              </label>
            </div>

            <div class="mb-3 b2">
              <label for="servadd" class="form-label">Quieres agregar otra mascota?</label>
              <figcaption class="blockquote-footer">
                <cite title="Source Title">Puede registrar un máximo de 3 mascotas</cite>
              </figcaption>
              <input type="button" class="btn btn-info" value="Agregar otra mascota" onclick="mostrarMascota3()">
            </div>
          </div>

          <!-- mascota n3-->
          <div class="col-sm mascota3">
            <div class="mb-3">
              <label for="" class="form-label letra">Datos de la 3era mascota</label>

              <div class="form-floating">
                <select class="form-select" id="tipomascota3" aria-label="Floating label select example" required onchange="cambiar3()" disabled>
                  <option value="">--</option>
                  <option value="gato">Gato</option>
                  <option value="perro">Perro</option>
                </select>
                <div class="valid-feedback">
                  <img src="<?php echo $path; ?>svgs/solid/paw.svg" width="16" alt="">
                </div>
                <div id="tipomascotaHelp" class="form-text"></div>
                <label for="tipomascota">Seleccione si es gato o perro</label>
              </div>

            </div>
            <!-- perro -->
            <div class="mb-3 perro3" style="display:none;">
              <label for="razaperro3" class="form-label">Raza perro</label>
              <input class="form-control" list="listaRazaPerro3" id="razaperro3" name="razaperro3" placeholder="Escriba para buscar..." required disabled>
              <datalist id="listaRazaPerro3">
                <option value="Mestizo">
                <option value="Labrador retriever">
                <option value="Bulldog francés">
                <option value="Golden retriever">
                <option value="Pastor alemán">
                <option value="Caniche">
                <option value="Bulldog">
                <option value="Beagle">
                <option value="Rottweiler">
                <option value="Braco alemán de pelo corto">
                <option value="Dachshund">
              </datalist>
            </div>
            <!-- gato -->
            <div class="mb-3 gato3" style="display:none;">
              <label for="razagato3" class="form-label">Raza gato</label>
              <input class="form-control" list="listaRazaGato3" id="razagato3" name="razagato3" placeholder="Escriba para buscar..." required disabled>
              <datalist id="listaRazaGato3">
                <option value="Mestizo">
                <option value="Persa">
                <option value="Azul ruso">
                <option value="Siamés">
                <option value="Angora turco">
                <option value="Siberiano">
                <option value="Maine Coon">
                <option value="Bengalí">
              </datalist>
            </div>

            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="Nombre mascota" id="nombreMascota3" required name="nombreMascota3" autocomplete="off" disabled>
                <label for="nombreMascota3">Nombre mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <div class="form-floating datepicker">
                <input type="date" class="form-control" placeholder="Fecha nacimiento mascota" id="fechaMascota3" name="fechaMascota3" required autocomplete="off" disabled>
                <label for="fechaMascota3">Fecha nacimiento de la mascota</label>
              </div>
            </div>



            <div class="mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" placeholder="ejmplo 3 años 2 meses" id="edadMascota3" name="edadMascota3" required autocomplete="off" disabled>
                <label for="edadMascota3">Edad mascota</label>
              </div>
            </div>

            <div class="mb-3">
              <label for="servadd" class="form-label">Sexo</label>
              <input class="form-check-input" type="radio" name="sexoMascota3" disabled id="sexoMascotaM3" value="macho">
              <label class="form-check-label" for="sexoMascotaM3">
                Macho
              </label>
              <input class="form-check-input" type="radio" name="sexoMascota3" disabled id="sexoMascotaH3" value="hembra">
              <label class="form-check-label" for="sexoMascotaH3">
                Hembra
              </label>
            </div>
          </div>


          <div class="mb-3">
            <div class="form-floating datepicker">
              <input type="text" class="form-control" placeholder="Cantidad de mascotas a registrar" id="cantmas" name="cantmas" required autocomplete="off" value="1" readonly>
              <label for="fechaMascota">Total de mascotas a registrar</label>
            </div>
          </div>

          <button onclick="validar()" type="submit" class="btn btn-primary">Registrar</button>

          <input type="text" class="form-control" placeholder="Url tarjeta club" id="urltext" name="urltext" autocomplete="off" value="" readonly>
        </form>
      </div>
    </div>
    <div class="row" id="fotoexito" style="display: none;">
      <div class="col-sm" style="text-align: center;">
        <label for="" class="form-label letra">Felicidades, ya eres miembro del club. Verifique su correo en donde encontrará su tarjeta con beneficios.</label><br>
        <h6>Si no visualiza el correo en su bandeja por favor verifique la carpeta de Spam.</h6>
        <br>
        <img src="https://vidapetsoficial.com/wp-content/uploads/2023/06/vida-1.png">
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <div id="exito"></div>
        <div id="error"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm">
        <div id="exito2"></div>
        <div id="error2"></div>
      </div>
    </div>
  </div>
  </div>
  <script type="text/javascript">
 

    $(document).ready(function() {

      // $(".mascota1").css("display","none");
      $(".mascota2").css("display", "none");
      $(".mascota3").css("display", "none");


    });

    function mostrarMascota2() {

      $(".mascota2").slideDown(1000).css("display", "block");
      $(".b1").slideUp(1000).css("display", "none");
      $("#cantmas").val(2);

      $("#tipomascota2").removeAttr("disabled");
      $("#nombreMascota2").removeAttr("disabled");
      $("#fechaMascota2").removeAttr("disabled");
      $("#edadMascota2").removeAttr("disabled");
      $("[name='sexoMascota2']").removeAttr("disabled");

    }

    function mostrarMascota3() {

      $(".mascota3").slideDown(1000).css("display", "block");
      $(".b2").slideUp(1000).css("display", "none");
      $("#cantmas").val(3);

      $("#tipomascota3").removeAttr("disabled");
      $("#nombreMascota3").removeAttr("disabled");
      $("#fechaMascota3").removeAttr("disabled");
      $("#edadMascota3").removeAttr("disabled");
      $("[name='sexoMascota3']").removeAttr("disabled");
    }

    function cambiar() {

      var tipo = $("#tipomascota").val();
      if (tipo == "gato") {

        $(".perro").slideUp(1000).css("display", "none");
        $(".gato").slideDown(1000).css("display", "block");
        $("#razagato").removeAttr("disabled");
        $("#razaperro").attr("disabled");


      } else if (tipo == "perro") {

        $(".gato").slideUp(1000).css("display", "none");
        $(".perro").slideDown(1000).css("display", "block");
        $("#razagato").attr("disabled");
        $("#razaperro").removeAttr("disabled");
      } else {

        $(".gato").slideUp(1000).css("display", "none");
        $(".perro").slideUp(1000).css("display", "none");
        $("#razagato").attr("disabled");
        $("#razaperro").attr("disabled");
      }

    }

    function cambiar2() {

      var tipo = $("#tipomascota2").val();
      if (tipo == "gato") {

        $(".perro2").slideUp(1000).css("display", "none");
        $(".gato2").slideDown(1000).css("display", "block");
        $("#razagato2").removeAttr("disabled");
        $("#razaperro2").attr("disabled");


      } else if (tipo == "perro") {

        $(".gato2").slideUp(1000).css("display", "none");
        $(".perro2").slideDown(1000).css("display", "block");
        $("#razagato2").attr("disabled");
        $("#razaperro2").removeAttr("disabled");
      } else {

        $(".gato2").slideUp(1000).css("display", "none");
        $(".perro2").slideUp(1000).css("display", "none");
        $("#razagato2").attr("disabled");
        $("#razaperro2").attr("disabled");
      }

    }

    function cambiar3() {

      var tipo = $("#tipomascota3").val();
      if (tipo == "gato") {

        $(".perro3").slideUp(1000).css("display", "none");
        $(".gato3").slideDown(1000).css("display", "block");
        $("#razagato3").removeAttr("disabled");
        $("#razaperro3").attr("disabled");


      } else if (tipo == "perro") {

        $(".gato3").slideUp(1000).css("display", "none");
        $(".perro3").slideDown(1000).css("display", "block");
        $("#razagato3").attr("disabled");
        $("#razaperro3").removeAttr("disabled");
      } else {

        $(".gato3").slideUp(1000).css("display", "none");
        $(".perro3").slideUp(1000).css("display", "none");
        $("#razagato3").attr("disabled");
        $("#razaperro3").attr("disabled");
      }

    }

    function validar() {

      var cantmas = $("#cantmas").val();

      //alert("validar cant: " + cantmas);
      /* if (cantmas == 2) {
         $("#tipomascota2").removeAttr("disabled");
         var tipomascota2 = $("#tipomascota2").val();
         if (tipomascota2 == 'perro') {
           $("#razaperro2").removeAttr("disabled");
           $("#razagato2").attr("disabled");
         } else if (tipomascota2 == 'gato') {
           $("#razagato2").removeAttr("disabled");
           $("#razaperro2").attr("disabled");
         }
         $("#nombreMascota2").removeAttr("disabled");
         $("#fechaMascota2").removeAttr("disabled");
         $("#edadMascota2").removeAttr("disabled");
         $("[name='sexoMascota2']").removeAttr("disabled");
       }
       if (cantmas == 3) {
         $("#tipomascota3").removeAttr("disabled");
         var tipomascota3 = $("#tipomascota3").val();
         if (tipomascota3 == 'perro') {
           $("#razaperro3").removeAttr("disabled");
           $("#razagato3").attr("disabled");
         } else if (tipomascota3 == 'gato') {
           $("#razagato3").removeAttr("disabled");
           $("#razaperro3").attr("disabled");
         }
         $("#razaperro3").removeAttr("disabled");
         $("#razagato3").removeAttr("disabled");
         $("#nombreMascota3").removeAttr("disabled");
         $("#fechaMascota3").removeAttr("disabled");
         $("#edadMascota3").removeAttr("disabled");
         $("[name='sexoMascota3']").removeAttr("disabled");
       }*/
      //return false;


      $("#exito").html("");
      $("#error").html("");
      $("#exitos").html("");
      $("#errors").html("");
      const forms = document.querySelectorAll('.form-club')
      Array.from(forms).forEach(form => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false);

      Array.from(forms).forEach(form => {
        if (form.checkValidity()) {
          guardarClub();
        }
        form.classList.add('was-validated')
      }, false);

    }

    function guardarClub() {

      var cantmas = $("#cantmas").val();
      //alert("guardarClub cant: " + cantmas);

      //dueño
      var nombreCompleto = $("#nombreCompleto").val();
      var correo = $("#correo").val();
      var nacionalidad = $("[name='nacionalidad']").val();
      var ci = $("#ci").val();
      var tlf = $("#tlf").val();
      var direccion = $("#direccion").val();
      var tiporegistro = $("#tiporegistro").val();
      //primera mascota
      if (cantmas == 1) {
        var tipomascota = $("#tipomascota").val();

        var nombreMascota = $("#nombreMascota").val();
        var fechaMascota = $("#fechaMascota").val();
        var edadMascota = $("#edadMascota").val();
        var sexoMascota = $("[name='sexoMascota']").val();

        if (tipomascota == 'perro') {
          var raza = $("#razaperro").val();
        } else if (tipomascota == 'gato') {
          var raza = $("#razagato").val();
        }

        var data = {
          "tipomascota": tipomascota,
          "raza": raza,
          "nombreMascota": nombreMascota,
          "fechaMascota": fechaMascota,
          "edadMascota": edadMascota,
          "sexoMascota": sexoMascota,
        }
        var myStringdata = JSON.stringify(data);
      }
      //segunda mascota
      if (cantmas == 2) {

        var tipomascota = $("#tipomascota").val();
        if (tipomascota == 'perro') {
          var raza = $("#razaperro").val();
        } else if (tipomascota == 'gato') {
          var raza = $("#razagato").val();
        }
        var nombreMascota = $("#nombreMascota").val();
        var fechaMascota = $("#fechaMascota").val();
        var edadMascota = $("#edadMascota").val();
        var sexoMascota = $("[name='sexoMascota']").val();

        var tipomascota2 = $("#tipomascota2").val();
        if (tipomascota2 == 'perro') {
          var raza2 = $("#razaperro2").val();
        } else if (tipomascota2 == 'gato') {
          var raza2 = $("#razagato2").val();
        }
        var nombreMascota2 = $("#nombreMascota2").val();
        var fechaMascota2 = $("#fechaMascota2").val();
        var edadMascota2 = $("#edadMascota2").val();
        var sexoMascota2 = $("[name='sexoMascota2']").val();
        var data = {
          "tipomascota": tipomascota,
          "raza": raza,
          "nombreMascota": nombreMascota,
          "fechaMascota": fechaMascota,
          "edadMascota": edadMascota,
          "sexoMascota": sexoMascota,
          "tipomascota2": tipomascota2,
          "raza2": raza2,
          "nombreMascota2": nombreMascota2,
          "fechaMascota2": fechaMascota2,
          "edadMascota2": edadMascota2,
          "sexoMascota2": sexoMascota2
        }
        var myStringdata = JSON.stringify(data);
      }
      //tercera mascota
      if (cantmas == 3) {
        var tipomascota = $("#tipomascota").val();
        if (tipomascota == 'perro') {
          var raza = $("#razaperro").val();
        } else if (tipomascota == 'gato') {
          var raza = $("#razagato").val();
        }
        var nombreMascota = $("#nombreMascota").val();
        var fechaMascota = $("#fechaMascota").val();
        var edadMascota = $("#edadMascota").val();
        var sexoMascota = $("[name='sexoMascota']").val();

        var tipomascota2 = $("#tipomascota2").val();
        if (tipomascota2 == 'perro') {
          var raza2 = $("#razaperro2").val();
        } else if (tipomascota2 == 'gato') {
          var raza2 = $("#razagato2").val();
        }
        var nombreMascota2 = $("#nombreMascota2").val();
        var fechaMascota2 = $("#fechaMascota2").val();
        var edadMascota2 = $("#edadMascota2").val();
        var sexoMascota2 = $("[name='sexoMascota2']").val();

        var tipomascota3 = $("#tipomascota3").val();
        if (tipomascota3 == 'perro') {
          var raza3 = $("#razaperro3").val();
        } else if (tipomascota3 == 'gato') {
          var raza3 = $("#razagato3").val();
        }
        var nombreMascota3 = $("#nombreMascota3").val();
        var fechaMascota3 = $("#fechaMascota3").val();
        var edadMascota3 = $("#edadMascota3").val();
        var sexoMascota3 = $("[name='sexoMascota3']").val();

        var data = {
          "tipomascota": tipomascota,
          "raza": raza,
          "nombreMascota": nombreMascota,
          "fechaMascota": fechaMascota,
          "edadMascota": edadMascota,
          "sexoMascota": sexoMascota,
          "tipomascota2": tipomascota2,
          "raza2": raza2,
          "nombreMascota2": nombreMascota2,
          "fechaMascota2": fechaMascota2,
          "edadMascota2": edadMascota2,
          "sexoMascota2": sexoMascota2,
          "tipomascota3": tipomascota3,
          "raza3": raza3,
          "nombreMascota3": nombreMascota3,
          "fechaMascota3": fechaMascota3,
          "edadMascota3": edadMascota3,
          "sexoMascota3": sexoMascota3
        }
        var myStringdata = JSON.stringify(data);
      }

      //alert("pre envio");

      $("#exitos").focus();
      event.preventDefault(); // Añade esto para prevenir el default

      $("#exito").html("");
      $("#error").html("");
      $("#exitos").html("");
      $("#errors").html("");
      $("#exito").html(' <div class="alert alert-primary" role="alert"><div class="bd-callout bd-callout-info"><strong>Validando! </strong>Por favor espere...</div></div>');
      $("#exitos").html(' <div class="alert alert-primary" role="alert"><div class="bd-callout bd-callout-info"><strong>Validando! </strong>Por favor espere...</div></div>');
      //recibo las variables

      ///busco las mascota
      $.ajax({
        // la URL para la petición
        url: 'saveClub.php',

        // la información a enviar
        // (también es posible utilizar una cadena de datos)
        data: {
          cantmas: cantmas,
          nombreCompleto: nombreCompleto,
          correo: correo,
          nacionalidad: nacionalidad,
          ci: ci,
          tlf: tlf,
          direccion: direccion,
          tiporegistro: tiporegistro,
          data: myStringdata
        },

        // especifica si será una petición POST o GET
        type: 'POST',

        // el tipo de información que se espera de respuesta
        dataType: 'json',


        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(response) {
          //alert("success");

          if (response.estatus == 1) {
            $("#exito").html("");
            $("#error").html("");
            $("#exitos").html("");
            $("#errors").html("");
            // $("#exito").html("<div class='alert alert-success' role='alert'>" + response.mjs + " </div>");

            // envioTarjeta(myStringdata, correo, nombreCompleto, cantmas);
            generarTarjeta(myStringdata, nacionalidad, nombreCompleto, cantmas, ci, correo);



            //envioTarjeta(myStringdata, correo, nombreCompleto, cantmas,urltext);

            //alert("exito todo");
            //$("#exitos").html("<div class='alert alert-success' role='alert'>" + response.mjs + " </div>");
            //alert("exito cant: " + response.cantmass);

            //$("#exito").html("<div class='alert alert-primary' role='alert'><div class='bd-callout bd-callout-info'><strong>Calculo: </strong>" + mjs + "<br>Ref " + costoFinal + " <br> " + costoBs + " Bs. <br>Tasa BCV " + response.tasaDolar + "</div></div>");

          } else {
            $("#exito").html("");
            $("#error").html("");
            $("#exitos").html("");
            $("#errors").html("");

            $("#error").html('<div class="alert alert-primary" role="alert"><div class="header"> ' + response.mjs + '</div><p>...</p></div>');
            $("#errors").html('<div class="alert alert-primary" role="alert"><div class="header"> ' + response.mjs + '</div><p>...</p></div>');
          }
        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {},
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {
          //alert('Petición realizada');
        }
      });
    }

    function generarTarjeta(datos, nacionalidad, nombreCompleto, cantmas, ci, correo) {

      //alert("entro envioTarjeta");

      $("#exito2").html("");
      $("#error2").html("");
      $("#exito2").html(' <div class="alert alert-primary" role="alert"><div class="bd-callout bd-callout-info"><strong>Validando! </strong>Por favor espere...</div></div>');
      //recibo las variables

      ///busco las mascota
      $.ajax({
        // la URL para la petición
        url: 'tarjeta-club.php',

        // la información a enviar
        // (también es posible utilizar una cadena de datos)
        data: {
          cantmas: cantmas,
          nombreCompleto: nombreCompleto,
          nacionalidad: nacionalidad,
          ci: ci,
          data: datos
        },

        // especifica si será una petición POST o GET
        type: 'POST',

        // el tipo de información que se espera de respuesta
        dataType: 'json',


        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(response) {
          //alert("success");

          if (response.estatus == 1) {

            $("#exito2").html("");
            $("#error2").html("");
            //$("#exito2").html("<div class='alert alert-success' role='alert'>" + response.mjs + " </div>"); 
            $("#fotoexito").css("display", "block");
            $("#formclub").css("display", "none");
            //alert("url: " + response.url);
            var urltar = response.url;


            //alert("generar tarjeta url 1: " + urltar);
            $("#exito2").html("");
            $("#error2").html("");
            $("#exito2").html(' <div class="alert alert-primary" role="alert"><div class="bd-callout bd-callout-info"><strong>Validando! </strong>Por favor espere...</div></div>');
            //recibo las variables

            ///busco las mascota
            $.ajax({
              // la URL para la petición
              url: 'https://vidapetsoficial.com/dashboard/admin/correo/enviarTarjeta.php',

              // la información a enviar
              // (también es posible utilizar una cadena de datos)
              data: {
                cantmas: cantmas,
                nombreCompleto: nombreCompleto,
                correo: correo,
                ci: ci,
                urltar: urltar,
                data: datos
              },

              // especifica si será una petición POST o GET
              type: 'POST',

              // el tipo de información que se espera de respuesta
              dataType: 'json',


              // código a ejecutar si la petición es satisfactoria;
              // la respuesta es pasada como argumento a la función
              success: function(response) {
                //alert("success");

                if (response.estatus == 1) {

                  $("#exito2").html("");
                  $("#error2").html("");
                  //$("#exito2").html("<div class='alert alert-success' role='alert'>" + response.mjs + " </div>"); 
                  $("#fotoexito").css("display", "block");
                  $("#formclub").css("display", "none");
                  //alert("exito envio correo");

                  //$("#exito").html("<div class='alert alert-primary' role='alert'><div class='bd-callout bd-callout-info'><strong>Calculo: </strong>" + mjs + "<br>Ref " + costoFinal + " <br> " + costoBs + " Bs. <br>Tasa BCV " + response.tasaDolar + "</div></div>");

                } else {
                  $("#exito2").html("");
                  $("#error2").html("");

                  $("#error2").html('<div class="alert alert-primary" role="alert"><div class="header"> ' + response.mjs + '</div><p>...</p></div>');
                }
              },
              // código a ejecutar si la petición falla;
              // son pasados como argumentos a la función
              // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
              // de la petición y un texto con la descripción del error que haya dado el servidor
              error: function(jqXHR, status, error) {},
              // código a ejecutar sin importar si la petición falló o no
              complete: function(jqXHR, status) {
                //alert('Petición realizada');
              }
            });

            //return response.url;
            //$("#exito").html("<div class='alert alert-primary' role='alert'><div class='bd-callout bd-callout-info'><strong>Calculo: </strong>" + mjs + "<br>Ref " + costoFinal + " <br> " + costoBs + " Bs. <br>Tasa BCV " + response.tasaDolar + "</div></div>");

          } else {
            $("#exito2").html("");
            $("#error2").html("");

            $("#error2").html('<div class="alert alert-primary" role="alert"><div class="header"> ' + response.mjs + '</div><p>...</p></div>');
          }
        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {},
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {
          //alert('Petición realizada');
        }
      });
    }

    function envioTarjeta(myStringdata, correo, nombreCompleto, cantmas) {

      //alert("entro envioTarjeta url: " + urltarjeta);

      $("#exito2").html("");
      $("#error2").html("");
      $("#exito2").html(' <div class="alert alert-primary" role="alert"><div class="bd-callout bd-callout-info"><strong>Validando! </strong>Por favor espere...</div></div>');
      //recibo las variables

      ///busco las mascota
      $.ajax({
        // la URL para la petición
        url: 'https://vidapetsoficial.com/dashboard/admin/correo/enviarTarjeta.php',

        // la información a enviar
        // (también es posible utilizar una cadena de datos)
        data: {
          cantmas: cantmas,
          nombreCompleto: nombreCompleto,
          correo: correo,
          data: myStringdata
        },

        // especifica si será una petición POST o GET
        type: 'POST',

        // el tipo de información que se espera de respuesta
        dataType: 'json',


        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(response) {
          //alert("success");

          if (response.estatus == 1) {

            $("#exito2").html("");
            $("#error2").html("");
            //$("#exito2").html("<div class='alert alert-success' role='alert'>" + response.mjs + " </div>"); 
            $("#fotoexito").css("display", "block");
            $("#formclub").css("display", "none");
            //alert("exito envio correo");

            //$("#exito").html("<div class='alert alert-primary' role='alert'><div class='bd-callout bd-callout-info'><strong>Calculo: </strong>" + mjs + "<br>Ref " + costoFinal + " <br> " + costoBs + " Bs. <br>Tasa BCV " + response.tasaDolar + "</div></div>");

          } else {
            $("#exito2").html("");
            $("#error2").html("");

            $("#error2").html('<div class="alert alert-primary" role="alert"><div class="header"> ' + response.mjs + '</div><p>...</p></div>');
          }
        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {},
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {
          //alert('Petición realizada');
        }
      });
    }



  </script>

</body>

</html>