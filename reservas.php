<?php
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em Breve</title>
    <link rel="icon" type="image/x-icon" href="img/mdzero.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            text-align: center;
        }

        h1 {
            color: #fff;
            font-size: clamp(2rem, 6vw, 4rem);
            font-weight: 800;
            letter-spacing: 2px;
            line-height: 1;
        }

        h2 {
            color: #8a8a8a;
            font-size: clamp(1rem, 2vw, 1.4rem);
            font-weight: 600;
            letter-spacing: 4px;
            margin-top: 64px;
            text-transform: uppercase;
        }

        .logout {
            display: inline-block;
            margin-top: 40px;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .logout:hover {
            color: #fff;
        }
        
        .btn {
            margin-top: 30px;
            padding: 14px 36px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #6a5cff, #8b5cf6);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 25px rgba(106, 92, 255, 0.35);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(106, 92, 255, 0.5);
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(106, 92, 255, 0.3);
        }

        a{
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Desbloqueie esse Módulo</h1>

        <button class="btn"><a href="modulos.php">Compre aqui</a></button>

        <h2>Módulo Zero</h2>

        <a href="mesas.php" class="logout">Voltar</a>
    </div>
</body>
</html>