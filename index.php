<?php

function connection(){
    $host = "localhost:3306";
    $user = "root";
    $pass = "rootroot";

    $bd = "Northwind";

    $connect=mysqli_connect($host, $user, $pass);

    mysqli_select_db($connect, $bd);

    return $connect;

}

$con = connection();

$sql = "SELECT NombreProducto, NombreCategoria, PrecioUnidad
FROM (
    SELECT p.ProductName AS NombreProducto, c.CategoryName AS NombreCategoria, p.UnitPrice AS PrecioUnidad, 
           (SELECT AVG(p2.UnitPrice) 
            FROM Products p2 
            WHERE p2.CategoryID = p.CategoryID) AS PrecioMedio
    FROM Products p, Categories c
    WHERE p.CategoryID = c.CategoryID
) AS ProductosConPrecioMedio
WHERE PrecioUnidad > PrecioMedio";
$query = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a datos</title>
</head>
<body>
    <div class="container">
        <h1>Lista de Productos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre de la categoria</th>
                    <th>Nombre del producto</th>
                    <th>Precio por Unidad</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_array($query)) { ?>
                <tr>
                    <td><?php echo $row['NombreCategoria']; ?></td>
                    <td><?php echo $row['NombreProducto']; ?></td>
                    <td><?php echo $row['PrecioUnidad']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>