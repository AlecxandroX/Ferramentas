<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Centralizada</title>

    <!-- Link do Bootstrap 5.0.1 via cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">

    <!-- CSS Bootstrap 5 -->
    <link rel="stylesheet" href="css/app.css">
    
    
    <style>
        body {
            overflow-y: hidden;
           
        }

        main {
            display: block;
            justify-content: center;
            align-items: center;
            max-height: 100vh;
            width: 10px;
            overflow: hidden;
        }

        .caixa {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        

    </style>
</head>
<body>
        <main>
            <div class="caixa">
                <div class="row ">
                    <div class="col">
                        <h1 class="text-danger text-center">OPS!</h1>

                        <div class="col d-flex justify-content-center">
                            <h2 class="text-danger text-center">Você não pode acessar as páginas sem antes fazer login</h2>
                         </div>

                         <div class="col d-flex justify-content-center">
                            <a href="index.php"><button class="btn btn-danger mt-3" type="button">Fazer login aqui</button></a>
                         </div>
                    </div>
                </div>

            </div>
        </main>
</body>
</html>
