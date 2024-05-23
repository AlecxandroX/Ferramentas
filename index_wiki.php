<?php
include 'conexao.php';
include 'protect.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIKI-NOC</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #333;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .content-container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 20px;
        }

        h1 {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            margin: 0;
            font-size: 36px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin: 10px 0;
        }

        .topic-container {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .topic-container {
                margin: 10px;
                padding: 10px;
            }
        }

        .centered-image {
            text-align: center;
            margin: 20px 0;
        }

        .centered-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .topic-button {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin: 10px auto;
            max-width: 80%;
        }

        .topic-button:hover {
            background-color: #0056b3;
        }

        #user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        #user-info svg {
            margin-right: 10px;
        }

        .sair {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sair:hover {
            background-color: #c82333;
        }

        footer {
            margin-top: 20px;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-container">
            <div class="centered-image">
                <img src="https://static.wixstatic.com/media/43a85e_98aea136474940fc9c336a4c2a78c677~mv2.png/v1/fit/w_2500,h_1330,al_c/43a85e_98aea136474940fc9c336a4c2a78c677~mv2.png" alt="Imagem Centralizada" />
            </div>
            <div id="user-info">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                    <!-- Seu código SVG -->
                </svg>
                <h6 id="greeting">OLÁ,</h6><br>
                <h6 id="username"></h6>
            </div>

            <h1>WIKI-NOC</h1>

            <?php
            $server = 'ws4.altcloud.net.br';
            $usuario = 'ggnet_nocsz';
            $senha = 'ae7$6bPiLz/gp#iF';
            $base = 'ggnet_nocsz';

            $mysqli = new mysqli($server, $usuario, $senha, $base);

            if ($mysqli->connect_error) {
                die('Erro na conexão com o banco de dados: ' . $mysqli->connect_error);
            }

            if (!empty($_GET['topic'])) {
                $topic = $_GET['topic'];

                $sql = "SELECT filename, pdf_name FROM pdf_files WHERE topic = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("s", $topic);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<h2>Tópico: $topic</h2>";
                    echo "<ul>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><a class='topic-button' href='uploads/" . $row['pdf_name'] . "' target='_blank'>" . $row['filename'] . "</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "Nenhum PDF encontrado para este tópico.";
                }

                $stmt->close();
            } else {
                $sql = "SELECT DISTINCT topic FROM pdf_files";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo "<ul>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<li><a class='topic-button' href='?topic=" . urlencode($row['topic']) . "'>" . $row['topic'] . "</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "Nenhum tópico encontrado no banco de dados.";
                }
            }

            $mysqli->close();
            ?>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var greetingElement = document.getElementById("greeting");
                    var usernameElement = document.getElementById("username");
                    var greetingText = "Olá, ";
                    var usernameText = "<?php echo $_SESSION['usuario']; ?>";
                    greetingElement.classList.add("active");
                    usernameElement.classList.add("active");

                    function typeText(element, text, index) {
                        if (index <= text.length) {
                            element.textContent = text.slice(0, index);
                            setTimeout(function () {
                                typeText(element, text, index + 1);
                            }, 100);
                        }
                    }

                    typeText(greetingElement, greetingText, 0);
                    setTimeout(function () {
                        typeText(usernameElement, usernameText, 0);
                    }, greetingText.length * 100);
                });
            </script>
            <script>
                function changeBackgroundColor() {
                    const colors = ["#f4f4f4", "#eaeaea", "#d4d4d4", "#c0c0c0", "#b6b6b6"];
                    let currentIndex = 0;

                    function updateColor() {
                        document.body.style.backgroundColor = colors[currentIndex];
                        currentIndex = (currentIndex + 1) % colors.length;
                    }

                    setInterval(updateColor, 5000);
                }

                changeBackgroundColor();
            </script>

            <a href="logout.php" class="sair">Sair</a>
            <footer>
                <p>&copy; 2023 Desenvolvido por <a href="#">Alecx Xavier</a>.</p>
            </footer>
        </div>
    </div>
</body>

</html>
