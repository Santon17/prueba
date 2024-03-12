<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provincias</title>
</head>
<body>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required>
        <br>
        <label for="provincia">Provincia:</label>
        <select name="provincia" id="provincia">
            <option value="">Seleccione una provincia</option>
            <?php foreach ($provincias as $id => $nombre) { ?>
                <option value="<?php echo $id; ?>"><?php echo $nombre; ?></option>
            <?php } ?>
        </select>
        <br>
        <input type="submit" value="Añadir">
    </form>
    <?php
        
        $provincias = array();
        $fichero = fopen("provincias.csv", "r")
        if ($fichero!= false) {
            while (($data = fgetcsv($fichero, 1000, ",")) !== false) {
                $provincias[$data[0]] = $data[1];
            }
            fclose($fichero);
        }

        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $id_provincia = $_POST["provincia"];

            $error = "";
            if (empty($nombre) || empty($apellido)) {
                $error = "Debe ingresar un nombre y un apellido.";
            } elseif (!array_key_exists($id_provincia, $provincias)) {
                $error = "Debe seleccionar una provincia válida.";
            }

            // Si hay un error, mostrar el mensaje de error
            if (!empty($error)) {
                echo "<p>$error</p>";
            } else {
                // Si los valores son correctos, agregar el usuario al archivo csv de usuarios
                $usuario = "$nombre;$apellido;$id_provincia";
                file_put_contents("usuarios.csv", $usuario . PHP_EOL, FILE_APPEND);
                echo "<p>Usuario agregado correctamente.</p>";
            }
    }
    ?>
</body>
</html>
