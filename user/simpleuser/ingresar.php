<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>
    <div class="container_fluid col s12 m4 l8">
        <nav>
            <div class="nav-wrapper #f3e5f5 purple lighten-5">
                <a href="#" class="brand-logo"><img src="./img/logo-clinica-lircay.png" alt="Clinica Lircay" style="height:70px;"></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a class="black-text" href="index.php">Volver</a></li>
                </ul>
            </div>
        </nav>

    </div>

    <div class="container_fluid">
        <div class="row">
            <div class="col s6">
                <div class="row">
                    <div class="input-field col s3">
                        <input type="text" id="autocomplete-input" class="autocomplete">
                        <label for="autocomplete-input"><i class="fa-solid fa-message"></i> Autocomplete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.autocomplete');
        var instances = M.Autocomplete.init(elems);
        M.AutoInit();
    });
    </script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>

</html>