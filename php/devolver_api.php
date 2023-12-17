<?php 
    session_start();
    $dados = $_SESSION['dados'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../css/devolver_api.css"/>
    <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
    <link rel="icon" href="<?php echo $dados['bandeira']; ?>"/>
    <title><?php echo $dados['nome']; ?></title>
</head>
<body>
    <div class="container">
        <h1><?php echo $dados['nome_internacional'] ?></h1>
        <div class="centralizar">
            <img src="<?php echo $dados['bandeira']; ?>" alt="Bandeira do <?php echo $dados['nome'] ?>">
        </div>
        <br/>
        <span>
            <label>Nome do País: </label>
            <label><?php echo $dados['nome']; ?></label>
        </span>
        <br/>
        <span>
            <label>Nome Internacional: </label>
            <label><?php echo $dados['nome_internacional']; ?></label>
        </span>
        <br/>
        <span>
            <label>Abreviação: </label>
            <label><?php echo $dados['abreviacao']; ?></label>
        </span>
        <br/>
        <span>
            <label>Continente: </label>
            <label><?php echo $dados['continente']; ?></label>
        </span>
        <br/>
        <span>
            <label>Capital: </label>
            <label><?php echo $dados['capital']; ?></label>
        </span>
        <br/>
        <span>
            <label>Idioma: </label>
            <label><?php echo $dados['idioma']; ?></label>
        </span>
        <br/>
        <span>
            <label>Moeda: </label>
            <label><?php echo $dados['moeda'] . ' (' . $dados['simbolo_moeda'] . ') '; ?></label>
        </span>
        <br/>
        <span>
            <label>População: </label>
            <label><?php echo $dados['populacao']; ?></label>
        </span>
        <br>
        <div class="centralizar">
            <button id="submit">Procurar Outro País</button>
        </div>
    </div>
    <script src="../js/retorna_inicial.js"></script>
</body>
</html>