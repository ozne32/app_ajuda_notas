<?php
session_start();
if($_SESSION['codigo'] != 'autorizado'){
    header('location:index.php?erro=acesso');
}
if(isset($_GET['materia'])){
    $materia = $_GET['materia'];
}else{
    $materia ='Física';
}
$id = $_SESSION['id'];
?>

<html>
    <head>
        <!-- bootstrap link -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <meta charset="utf-8">
        <title>Colocar notas</title>

    </head>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Ajuda Notas</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="planejamento.php?id=<?=$id?>" class="nav-link ">Ver planejamento</a></li>
                <li class="nav-item"><a href="#" class="nav-link active">Colocar notas</a></li>
                <li class="nav-item"><a class="nav-link" href="encerrar_sessao.php">Encerrar sessão</a></li>
            </ul>
        </nav>
    </header>
    <body>
        <div class="container">
            <?if($materia != null){?>
            <form action="materia_controller.php?acao=adicionar&materia=<?=$materia?>&id=<?=$_GET['id']?>" method='post'>
                <div class="row mb-3 mt-3">
                    <?if(!isset($_GET['simulado'])){?>
                        <select class="form-control"  name="simulado">
                            <option value="0">--selecione o simulado--</option>
                            <option value="1">Enem</option>
                            <option value="2">Fuvest</option>
                            <option value="3">Unicamp</option>
                            <option value="4">Unesp</option>
                        </select>
                        <!-- <p class="col-md-4 font-weight-bold">Digite qual simulado quer inserir as notas:</p> -->
                        <!-- <input class="col-md-8" type="text" name = 'simulado' placeholder="Exemplo:ENEM, Fuvest"> -->
                    <?}?>
                    <?if(isset($_GET['simulado'])){?>
                        <?$nome_simulado = null;
                        switch($_GET['simulado']){
                            case 1: $nome_simulado = 'ENEM';break;
                            case 2: $nome_simulado = 'Fuvest';break;
                            case 3: $nome_simulado = 'Unicamp';break;
                            case 4: $nome_simulado = 'Unesp';break;
                        }
                            ?>
                        <input class="form-control" type="text" readonly="true" value="<?=$nome_simulado?>">
                        <input hidden="true" class="col-md-8" type="text" name ='simulado' readonly="true" value="<?=$_GET['simulado']?>" placeholder="Exemplo:ENEM, Fuvest">
                    <?}?>
                </div>
                <div class="row justify-content-around">
                    <p class="col-md-2 font-weight-bold"><?=$materia?>:</p>
                    <input type="number" class="form-control col-md-4 mr-auto" name="acertos" placeholder="acertos:">
                    <input type="number" class="form-control col-md-4 mr-auto" name="erros" placeholder="erros:">
                </div>
                <?if(isset($_GET['erro']) && $_GET['erro'] == 'falhaRegistro'){?>
                    <p class="text-danger">falha ao registrar a matéria</p>
                <?}?>
                <?if(isset($_GET['sucesso']) && $_GET['sucesso'] == 'sucessoRegistro'){?>
                    <p class="text-success">Conseguimos registrar a matéria</p>
                <?}?>
                <button class="btn btn-success" type="submit">Adicionar</button>
            </form>
            <?}?>
            <?if(isset($_GET['simulado'])){?>
            <table class="table table-striped mt-5">
                <thead>
                    <th class="col-md-3">Simulado</th>
                    <th class="col-md-3">matéria</th>
                    <th class="col-md-3">acertos</th>
                    <th class="col-md-3">erros</th>
                </thead>
                <tbody>
                    <?
                    require_once '../../app_ajuda_notas/conexao.php';
                    $conexao = new Conexao;
                    $query = 'SELECT 
                    m.nome_materia, u.nome, um.acertos, um.erros, s.nome_simulado
                    from tb_user_materia as um 
                    inner join
                    tb_usuario as u on um.id_usuario = u.id_usuario
                    inner join 
                    tb_simulados as s on s.id_simulado= um.id_simulado
                    inner JOIN
                    tb_materias as m on m.id_materia = um.id_materia   
                    where u.id_usuario = ? and s.id_simulado = ?
                    ';
                    $smtm = $conexao->conectar()->prepare($query);
                    $smtm->bindValue(1,$_GET['id']);
                    $smtm->bindValue(2,$_GET['simulado']);
                    $smtm->execute();
                    $arquivos = $smtm->fetchAll(PDO::FETCH_OBJ);
                    foreach($arquivos as $valor){?>
                    <tr>
                        <td><?=$valor->nome_simulado?> </td>
                        <td><?=$valor->nome_materia?></td>
                        <td><?=$valor->acertos?></td>
                        <td><?=$valor->erros?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
            <?}?>
        </div>
    </body>
</html>