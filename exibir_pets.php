<?php
include_once("./services/conexao.php");

$cachorros_sql = "SELECT * FROM cachorros";
$cachorros_result = mysqli_query($conn, $cachorros_sql);

$gatos_sql = "SELECT * FROM gatos";
$gatos_result = mysqli_query($conn, $gatos_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição de Pets Registrados</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

    <h1>Pets Registrados</h1>

    <div class="pet-list">
        <h2>Cachorros</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Pelagem</th>
                    <th>Porte</th>
                    <th>Sexo</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($cachorros_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['idade']); ?></td>
                        <td><?php echo htmlspecialchars($row['pelagem']); ?></td>
                        <td><?php echo htmlspecialchars($row['porte']); ?></td>
                        <td><?php echo htmlspecialchars($row['sexo']); ?></td>
                        <td><img src="./uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto do pet" width="100"></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Gatos</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Pelagem</th>
                    <th>Porte</th>
                    <th>Sexo</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($gatos_result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['idade']); ?></td>
                        <td><?php echo htmlspecialchars($row['pelagem']); ?></td>
                        <td><?php echo htmlspecialchars($row['porte']); ?></td>
                        <td><?php echo htmlspecialchars($row['sexo']); ?></td>
                        <td><img src="./uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto do pet" width="100"></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
mysqli_close($conn);
?>
