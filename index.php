<?php
    require_once 'ClassePessoa.php';
    $pessoa = new ClassePessoa("u820427911_luciano", "185.201.11.44", "u820427911_luciano", "]oD1qmpp=");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Tema opcional -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Última versão JavaScript compilada e minificada -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD Pessoa</title>
</head>
<body>
    
<?php
if (isset($_POST['nome'])) {
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);

    if (!empty($nome) && !empty($telefone) && !empty($email)) {
        if(!$pessoa->cadastrarPessoa($nome, $telefone, $email))
        {
            echo 'Email já existe no sistema';
        }     
    }
    else {
        echo 'Preencha todos os campos';
    }
}
?>

<?php
if ($_GET['id_up']) {
    $id_update = addslashes($_GET['id_up']);
    $res = $pessoa->buscarDadosPessoa($id_update);
}

?>
<section class="esquerda">
    <form action="" method="post">
        <h1>Cadastrar pessoa</h1>
    <div class="form-group">
    <label for="id_name">Nome:</label>
    <input type="text" name="nome" id="id_name" class="form-control" value = "<?php if(isset($res)) {
        echo $res['nome'];
    }?>">
</div>
<div class="form-group">
    <label for="id_telefone">Telefone:</label>
    <input type="text" name="telefone" id="id_telefone" class="form-control" value = "<?php if(isset($res)) {
        echo $res['telefone'];
    }?>">
</div>
<div class="form-group">
    <label for="id_email">Email:</label>
    <input type="text" name="email" id="id_email" class="form-control" value = "<?php if(isset($res)) {
        echo $res['email'];
    }?>">
</div>
<div class="form-group">
    <div class="form-group mt-3">
        <input class="btn btn-success" type="submit" value="<?php if(isset($res)) {
            echo "Actualizar";
        }else {
            echo "Cadastrar";
        }
        
        ?>">
        Cadastar</button>
    </div>
</div>
</section>
<section class="direita">

<table class="table table-dark">
    <tr id="titulo">
        <td>Nome</td>
        <td>Telefone</td>
        <td colspan="2">E-mail</td>
    </tr>
    <?php
        echo '<tr>';
        $dados = $pessoa->buscarDados();
        if(count($dados) > 0){
            for ($i=0; $i < count($dados); $i++) { 
                foreach ($dados[$i] as $key => $value) {
                    if ($key != "id") {
                        echo "<td>".$value."</td>";
                        
                    }
                }
                ?>
                <td>
                    <a href="index.php?id_up=<?php echo $dados[$i]['id']?>" class="btn btn-success">Editar</a> 
                    <a href="index.php?id=<?php echo $dados[$i]['id']?>" class="btn btn-danger">Excluir</a>
                </td>
                <?php
                echo '</tr>';

            }
    
        
    
        }else {
            
            echo 'Ainda não há pessoas cadastradas';
        }
    ?>    
    
</table>
</section>
</body>
</html>


<?php
if (isset($_GET['id'])) {
    $id_pessoa = addslashes($_GET['id']);
    $pessoa->excluirPessoa($id_pessoa);
    header('location: index.php');
}
?>