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
</head>

<body>
    <div class="container_fluid">
        <nav>
            <div class="nav-wrapper #f3e5f5 purple lighten-5">
                <a href="index.php" class="brand-logo"><img src="./img/logo-clinica-lircay.png" alt="Clinica Lircay"
                        style="height:70px;"></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a class="black-text" href="index.php">Volver</a></li>
                </ul>
            </div>
        </nav>

    </div>

    <div class="container">
        <div class="row">
            <form action="" method="POST">
                <div class="auto-widget">
                    <input class="form-control autocomplete" id="search" type="text" name="product" placeholder="Ingrese patente"  />
                </div>
            </form>
        </div>
    </div>

    <!-- JQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js" integrity="sha256-6XMVI0zB8cRzfZjqKcD01PBsAy3FlDASrlC8SxCpInY=" crossorigin="anonymous"></script> -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#search").autocomplete({
            source: 'search.php',
            minLength: 0,
        });
    });
    </script>

    <!-- <script src="./js/sistema.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>

</html>