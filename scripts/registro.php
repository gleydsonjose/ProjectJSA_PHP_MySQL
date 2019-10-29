<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){

    // PHPMailer
    require_once '../PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer();
    $mail->Port = '465';
    $mail->Host = 'smtp.gmail.com';
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Mailer = 'smtp';
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = 'true';
    $mail->Username = 'Conta gmail liberada para enviar email para outlook, hotmail...';
    $mail->Password = 'Senha do email gmail';
    $mail->SingleTo = 'true';
    $mail->From = 'Conta gmail liberada para enviar email para outlook, hotmail...';
    $mail->FromName = 'Seu nome ou da empresa';

    // Script com métodos para várias coisas.
    require_once 'dados.php'; 

    $registrar = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

    $mensagens_erro = [];
    $imagem_padrao = false;
    $login = addslashes(strip_tags(trim($_POST['login-registro'])));
    $email = addslashes(strip_tags(trim($_POST['email-registro'])));
    $nome = addslashes(strip_tags(trim($_POST['nome-registro'])));
    $sobrenome = addslashes(strip_tags(trim($_POST['sobrenome-registro'])));
    $senha = addslashes(strip_tags(trim($_POST['senha-registro'])));
    $repita_senha = addslashes(strip_tags(trim($_POST['repita-senha-registro'])));
    $imagem_usuario = addslashes(strip_tags(trim('imagens_usuarios/'.$_FILES['imagem-usuario']['name'])));

    ?>
    <script>
    $(function(){

    <?php
        // Se o campo login estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
        if(empty($login)){ 
            $mensagens_erro["login-vazio"] = true;
            ?>

            if(!$("#login-registro-erro-1").length){
                $("#login-registro").after("<div class='invalid-feedback' id='login-registro-erro-1'>Este campo não pode ficar vazio</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["login-vazio"]);
            ?>

            $("#login-registro-erro-1").remove();
  <?php }

        // Se o login já estiver registrado no banco de dados, será mostrado um aviso, se não, esse aviso será removido.
        if($registrar->VerificarLogin($login)){
            $mensagens_erro["login-no-bd"] = true;
            ?>

            if(!$("#login-registro-erro-2").length){
                $("#login-registro").after("<div class='invalid-feedback' id='login-registro-erro-2'>Já existe um usuário com este login</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["login-no-bd"]);
            ?>

            $("#login-registro-erro-2").remove();
  <?php }

        // Se não existir erro no login, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
        ?>
        if(!$("#login-registro-erro-1").length && !$("#login-registro-erro-2").length){
            $("#mensagem-sucesso-registro").remove();
            $("#login-registro").removeClass("is-invalid");
            $("#login-registro").addClass("is-valid");            
        }else{
            $("#mensagem-sucesso-registro").remove();
            $("#login-registro").removeClass("is-valid");
            $("#login-registro").addClass("is-invalid");
        }

    <?php
        // Se o campo email estiver vázio, será mostrado um aviso, se não, esse aviso será removido.
        if(empty($email)){ 
            $mensagens_erro["email-vazio"] = true;
            ?>

            if(!$("#email-registro-erro-1").length){
                $("#email-registro").after("<div class='invalid-feedback' id='email-registro-erro-1'>Este campo não pode ficar vazio</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["email-vazio"]);
            ?>

            $("#email-registro-erro-1").remove();
  <?php } ?>

    <?php
        // Se o email não for válido, será mostrado um aviso, se não, esse aviso será removido.
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $mensagens_erro["email-invalido"] = true;
            ?>

            if(!$("#email-registro-erro-2").length){
                $("#email-registro").after("<div class='invalid-feedback' id='email-registro-erro-2'>Este email está inválido</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["email-invalido"]);
            ?>

            $("#email-registro-erro-2").remove();
  <?php } 

        // Se não existir erro no email, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
        ?>
        if(!$("#email-registro-erro-1").length && !$("#email-registro-erro-2").length){
            $("#mensagem-sucesso-registro").remove();
            $("#email-registro").removeClass("is-invalid");
            $("#email-registro").addClass("is-valid");            
        }else{
            $("#mensagem-sucesso-registro").remove();
            $("#email-registro").removeClass("is-valid");
            $("#email-registro").addClass("is-invalid");
        }

    <?php
        // Se o campo nome estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
        if(empty($nome)){ 
            $mensagens_erro["nome-vazio"] = true;
            ?>

            $("#mensagem-sucesso-registro").remove();
            $("#nome-registro").removeClass("is-valid");
            $("#nome-registro").addClass("is-invalid");
            if(!$("#nome-registro-erro-1").length){
                $("#nome-registro").after("<div class='invalid-feedback' id='nome-registro-erro-1'>Este campo não pode ficar vazio</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["nome-vazio"]);
            ?>

            $("#mensagem-sucesso-registro").remove();
            $("#nome-registro").removeClass("is-invalid");
            $("#nome-registro").addClass("is-valid");
            $("#nome-registro-erro-1").remove();
  <?php } ?>

    <?php
        // Se o campo sobrenome estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
        if(empty($sobrenome)){ 
            $mensagens_erro["sobrenome-vazio"] = true;
            ?>

            $("#mensagem-sucesso-registro").remove();
            $("#sobrenome-registro").removeClass("is-valid");
            $("#sobrenome-registro").addClass("is-invalid");
            if(!$("#sobrenome-registro-erro-1").length){
                $("#sobrenome-registro").after("<div class='invalid-feedback' id='sobrenome-registro-erro-1'>Este campo não pode ficar vazio</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["sobrenome-vazio"]);
            ?>

            $("#mensagem-sucesso-registro").remove();
            $("#sobrenome-registro").removeClass("is-invalid");
            $("#sobrenome-registro").addClass("is-valid");
            $("#sobrenome-registro-erro-1").remove()
  <?php } ?>

    <?php
        // Se o campo senha estiver vázio, será mostrado um aviso, se não, esse aviso será removido.
        if(empty($senha)){ 
            $mensagens_erro["senha-vazio"] = true;
            ?>

            if(!$("#senha-registro-erro-1").length){
                $("#senha-registro").after("<div class='invalid-feedback' id='senha-registro-erro-1'>Este campo não pode ficar vazio</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["senha-vazio"]);
            ?>

            $("#senha-registro-erro-1").remove()
  <?php } ?>

    <?php
        // Se a senha não ter entre 8 e 30 caracteres, será mostrado um aviso, se não, esse aviso será removido.
        if(strlen($senha) < 8 || strlen($senha) > 30){
            $mensagens_erro["senha-limite-erro"] = true;
            ?>

            if(!$("#senha-registro-erro-2").length){
                $("#senha-registro").after("<div class='invalid-feedback' id='senha-registro-erro-2'>A senha deve conter entre 8 e 30 caracteres</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["senha-limite-erro"]);
            ?>

            $("#senha-registro-erro-2").remove();
  <?php } ?>

    <?php
        // Se a senha não conter pelo menos uma letra maiúscula, será mostrado um aviso, se não, esse aviso será removido.
        if(!preg_match("/[A-Z]/", $senha)){
            $mensagens_erro["senha-sem-maiuscula"] = true;
            ?>

            if(!$("#senha-registro-erro-3").length){
                $("#senha-registro").after("<div class='invalid-feedback' id='senha-registro-erro-3'>A senha precisa ter 1 letra maiúscula</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["senha-sem-maiuscula"]);
            ?>

            $("#senha-registro-erro-3").remove();
  <?php } ?>

    <?php
        // Se a senha não conter pelo menos uma letra minúscula, será mostrado um aviso, se não, esse aviso será removido.
        if(!preg_match("/[a-z]/", $senha)){
            $mensagens_erro["senha-sem-minuscula"] = true;
            ?>
            
            if(!$("#senha-registro-erro-4").length){
                $("#senha-registro").after("<div class='invalid-feedback' id='senha-registro-erro-4'>A senha precisa ter 1 letra minúscula</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["senha-sem-minuscula"]);
            ?>

            $("#senha-registro-erro-4").remove();
  <?php } ?>

    <?php
        // Se a senha não conter pelo menos um caractere especial, será mostrado um aviso, se não, esse aviso será removido.
        if(!preg_match("/\W/", $senha)){
            $mensagens_erro["senha-sem-especial"] = true;
            ?>
            
            if(!$("#senha-registro-erro-5").length){
                $("#senha-registro").after("<div class='invalid-feedback' id='senha-registro-erro-5'>A senha precisa ter 1 caractere especial</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["senha-sem-especial"]);
            ?>

            $("#senha-registro-erro-5").remove();
  <?php } ?>

    <?php
        // Se as senhas forem iguais, será mostrado um aviso, se não, esse aviso será removido.
        if(strcmp($senha, $repita_senha) != 0){
            $mensagens_erro["senha-nao-iguais"] = true;
            ?>
            
            if(!$("#senha-registro-erro-6").length){
                $("#senha-registro").after("<div class='invalid-feedback' id='senha-registro-erro-6'>As senhas não correspondem</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["senha-nao-iguais"]);
            ?>

            $("#senha-registro-erro-6").remove();
  <?php }

        // Se não existir erro na senha, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
        ?>
        if(!$("#senha-registro-erro-1").length && !$("#senha-registro-erro-2").length && !$("#senha-registro-erro-3").length && !$("#senha-registro-erro-4").length && !$("#senha-registro-erro-5").length && !$("#senha-registro-erro-6").length){
            $("#mensagem-sucesso-registro").remove();
            $("#senha-registro").removeClass("is-invalid");
            $("#senha-registro").addClass("is-valid");            
        }else{
            $("#mensagem-sucesso-registro").remove();
            $("#senha-registro").removeClass("is-valid");
            $("#senha-registro").addClass("is-invalid");
        }

    <?php
        // Se o campo repita senha estiver vázio, será mostrado um aviso, se não, esse aviso será removido.
        if(empty($repita_senha)){ 
            $mensagens_erro["repita-senha-vazio"] = true;
            ?>

            if(!$("#repita-senha-registro-erro-1").length){
                $("#repita-senha-registro").after("<div class='invalid-feedback' id='repita-senha-registro-erro-1'>Este campo não pode ficar vazio</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["repita-senha-vazio"]);
            ?>
            
            $("#repita-senha-registro-erro-1").remove()
  <?php }

        // Se o repita senha não estiver vázio e ser igual a senha, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
        ?>
        if(!$("#repita-senha-registro-erro-1").length && !$("#senha-registro-erro-6").length){
            $("#mensagem-sucesso-registro").remove();
            $("#repita-senha-registro").removeClass("is-invalid");
            $("#repita-senha-registro").addClass("is-valid");            
        }else{
            $("#mensagem-sucesso-registro").remove();
            $("#repita-senha-registro").removeClass("is-valid");
            $("#repita-senha-registro").addClass("is-invalid");
        }

    <?php
    // Se nenhuma imagem for escolhida, uma variável para avisar que a imagem será a padrão será criada.
    if(!$_FILES['imagem-usuario']['name']){
        $imagem_padrao = true;

        ?>
            $("#mensagem-sucesso-registro").remove();
            $("#imagem-usuario").removeClass("is-invalid");
            $("#imagem-usuario").removeClass("is-valid");
            $("#imagem-usuario-registro-erro-1").remove();
        <?php
    }else{

        // Se uma imagem for escolhida, tudo abaixo será executado.
        // Passando as dimensões da imagem para um array.
        // [0] = Largura da imagem.
        // [1] = Altura da imagem.
        $dimensoes_imagem = getimagesize($_FILES['imagem-usuario']['tmp_name']);
        $largura_imagem = $dimensoes_imagem[0];
        $altura_imagem = $dimensoes_imagem[1];

        // Se a imagem for menor que 75x75, será mostrado um aviso, se não, esse aviso será removido.
        if($largura_imagem < 75 && $altura_imagem < 75){ 
            $mensagens_erro["dimensao-imagem-erro"] = true;
            ?>

            if(!$("#imagem-usuario-registro-erro-1").length){
                $("#imagem-usuario").after("<div class='invalid-feedback' id='imagem-usuario-registro-erro-1'>A imagem precisa ser maior que 75x75</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["dimensao-imagem-erro"]);
            ?>
            
            $("#imagem-usuario-registro-erro-1").remove();
  <?php }

        // Passando o tipo da imagem para uma variável.
        $tipo_imagem = pathinfo($imagem_usuario, PATHINFO_EXTENSION);

        // Se o tipo da imagem não for jpg, jpeg ou png, será mostrado um aviso, se não, esse aviso será removido.
        if(!in_array($tipo_imagem, array('jpg', 'jpeg', 'png'))){ 
            $mensagens_erro["tipo-imagem-erro"] = true;
            ?>

            if(!$("#imagem-usuario-registro-erro-2").length){
                $("#imagem-usuario").after("<div class='invalid-feedback' id='imagem-usuario-registro-erro-2'>O tipo da imagem precisa ser JPG, JPEG ou PNG</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["tipo-imagem-erro"]);
            ?>
            
            $("#imagem-usuario-registro-erro-2").remove();
  <?php }

        // Se o tamanho da imagem for igual a 0 ou maior que 500kb, será mostrado um aviso, se não, esse aviso será removido.
        if($_FILES['imagem-usuario']['size'] == 0 || $_FILES['imagem-usuario']['size'] > 500000){ 
            $mensagens_erro["tamanho-imagem-erro"] = true;
            ?>

            if(!$("#imagem-usuario-registro-erro-3").length){
                $("#imagem-usuario").after("<div class='invalid-feedback' id='imagem-usuario-registro-erro-3'>O tamanho da imagem precisa estar entre 1 e 500KB</div>");
            }
  <?php }else{ 
            unset($mensagens_erro["tamanho-imagem-erro"]);
            ?>
            
            $("#imagem-usuario-registro-erro-3").remove();
  <?php }

        // Se não existir erro na imagem, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
        ?>
        if(!$("#imagem-usuario-registro-erro-1").length && !$("#imagem-usuario-registro-erro-2").length && !$("#imagem-usuario-registro-erro-3").length){
            $("#mensagem-sucesso-registro").remove();
            $("#imagem-usuario").removeClass("is-invalid");
            $("#imagem-usuario").addClass("is-valid");            
        }else{
            $("#mensagem-sucesso-registro").remove();
            $("#imagem-usuario").removeClass("is-valid");
            $("#imagem-usuario").addClass("is-invalid");
        }
<?php }

        // Se não houver erros, o usuário será registrado.
        if(count($mensagens_erro) == 0){
            // Se não houve escolha de imagem, a imagem usada será a padrão, se não, a imagem será a escolhida e ela será armazenada numa pasta.
            if($imagem_padrao){
                $registrar->Registrar($login, $email, $nome, $sobrenome, $senha, $imagem_usuario."imagem_padrao.png");
            }else{
                $registrar->Registrar($login, $email, $nome, $sobrenome, $senha, $imagem_usuario);
                copy($_FILES['imagem-usuario']['tmp_name'], "../".$imagem_usuario);
            }

            // PHPMailer
            $mail->addAddress($email);
            $mail->Subject = "Bem vindo $nome";
            $mail->Body = "Seja bem vindo ao JSA Project.";

            if(!$mail->Send()){
                echo 'Erro ao tentar enviar o email:' . $mail->ErrorInfo;
            }

            // Removendo o aviso de válido e limpando todos os campos.
            // Se não houver mensagem de sucesso, ela será criada.
            ?>
            $("#login-registro").removeClass("is-valid");
            $("#login-registro").val("");
            $("#email-registro").removeClass("is-valid");
            $("#email-registro").val("");
            $("#nome-registro").removeClass("is-valid");
            $("#nome-registro").val("");
            $("#sobrenome-registro").removeClass("is-valid");
            $("#sobrenome-registro").val("");
            $("#senha-registro").removeClass("is-valid");
            $("#senha-registro").val("");
            $("#repita-senha-registro").removeClass("is-valid");
            $("#repita-senha-registro").val("");
            $("#imagem-usuario").removeClass("is-valid");
            $("#imagem-usuario").val("");
            $("#placeholder-input-imagem-usuario").text("Escolha uma imagem");

            // Se não existir a mensagem de sucesso, ela será mostrada. Isso é para evitar repetição de mensagem.
            if(!$("#mensagem-sucesso-registro").length){
                $("#registrar").after("<div class='text-center pt-3' id='mensagem-sucesso-registro'><span class='text-success'>Registro realizado com sucesso</span></div>");
            }
            <?php
        } ?>
    })

    </script> 
<?php }
?>