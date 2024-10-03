<?php
$servername = "localhost";
$username = "root";
$senha = "";
$dbname = "usuarios";

$conn = new mysqli($servername, $username, $senha, $dbname);


$conn->query("create table if not exists `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(50) NOT NULL UNIQUE,
    `senha` VARCHAR(20) NOT NULL)");

$conn->query("insert ignore into `usuarios` (nome, senha) VALUES 
    ('Carlisson', '40028922'),
    ('Alcides', 'Maya'),
    ('Sei', 'La')");

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $user = $_POST['nome'];
    $pass = $_POST['senha'];

    $sql = "select * from `usuarios` WHERE `nome` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        if ($pass === $row['senha']) 
        {
            if ($row['nome'] == "Carlisson") {
                echo "<script>alert('Ganhei nota ? :/');</script>";
            }
            echo "LOGADO!";
        } 
        else 
        {
            echo "Senha incorreta!";
        }
    } 
    else 
    {
        echo "Usuario nao encontrado!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE HTML>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G1 - Alcides Maya | WEB II</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url('fundo.jpg'); /* Adicione o caminho da sua imagem */
            height: 100%;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: left;
        }

        .cor{
            color:darkblue;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 1px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        h3 {
            color: black;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="nome">Usuário:</label>
        <input type="text" name="nome" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
    <h3 class="cor">Usuario 1: Carlisson Senha: 40028922</h3>
    <h3 class="cor">Usuario 2: Alcides Senha: Maya</h3>
    <h3 class="cor">Usuario 3: Sei Senha: La</h3>
</body>
</html>
