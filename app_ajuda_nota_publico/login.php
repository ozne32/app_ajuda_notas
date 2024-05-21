<html>
    <head>
        <!-- bootstrap link -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <title>Log-in</title>
    </head>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Ajuda Notas</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.php" class="nav-link ">Sign-in</a></li>
                <li class="nav-item"><a href="#" class="nav-link active">Login</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <div class="corpo-registro">
            <div class="card"><!-- começo do card -->
                <div class="card-header">Login:</div>
                <div class="card-body"> <!--começo do card-body-->
                    <form action="tarefa_controller.php?acao=verificar" method="post">
                        <label for="nome">Nome:</label>
                        <input name="nome-login" type="text" class="form-control" placeholder="Exemplo:Jamilton Damasceno">
                        <label for="email">Email:</label>
                        <input name ='email-login' class="form-control" type="text" placeholder="exemplo:nome@gmail.com">
                        <label for="senha">Senha:</label>
                        <input type="password" name ='senha-login' class="form-control">
                        <?if(isset($_GET['erro']) && $_GET['erro']=='dados_errados'){?>
                            <p class="text-danger">senha, email ou nome estão incorretos</p>
                        <?}?>
                        <button type="submit" class="btn btn-dark mt-3">Login</button>
                    </form>
                </div><!--final do card-body-->
            </div><!--final do card-->
        </div>
    </main>
</html>