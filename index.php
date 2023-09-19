<?php
  include_once('conexao.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastrar</h1>
    <?php
     if(isset($_POST['CadUsuario'])){ 
         $nome = $_POST['nome'];
         $email = $_POST['email'];  
       //faz a inserção
         $query_usuario = $conn->prepare( "INSERT INTO usuarios(nome, email) VALUES (:nome, :email)"); 
         $query_usuario->bindParam(':nome', $nome);
         $query_usuario->bindParam(':email', $email);
         $query_usuario->execute();

         if($query_usuario->rowCount() > 0){
            echo "Usuario Cadastrado com sucesso!";
            header("Location: index.php");                        
        } else{
           echo "Erro!";
         }      
     } 
    ?>
    <?php
       if(isset($_GET['delete'])){
           $id = (int)$_GET['delete'];
           $conn->exec("DELETE FROM usuarios WHERE id=$id");
           echo 'deletado com sucesso o id '.$id;
       }



    ?>
    <form name="cadusuario" method="post" action="index.php">
        <label>Nome:</label>
        <input type="text" name="nome" id="nome" placeholder="Nome Completo"><br><br>

        <label>Email:</label>
        <input type="text" name="email" id="email" placeholder="Email"><br><br>

        <input type="submit" value="Cadastrar" name="CadUsuario">
    </form>
    <h3>Usuarios</h3>  
    <?php
     $listar = $conn->prepare('SELECT * FROM usuarios');
     $listar->execute();
     $filtrar = $listar->fetchAll();

     foreach($filtrar as $exibir => $value){
        echo '<a href="?delete='.$value['id'].'">(X)</a>'.$value['nome'].' | '.$value['email'];
        echo '<hr>';   
     }

    ?>
</body>
</html>

?>