<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em Breve</title>

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
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 800;
            letter-spacing: 2px;
            line-height: 1;
        }

        h2 {
            color: #8a8a8a;
            font-size: clamp(1rem, 2vw, 1.4rem);
            font-weight: 600;
            letter-spacing: 4px;
            margin-top: 12px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Em Breve</h1>
        <h2>Módulo Zero</h2>

        <a href="login.php?logout=1" class="logout">Sair</a>
    </div>
</body>
</html>