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
    
        $faleconosco = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");
    
        $mensagens_erro = [];
        $nome = addslashes(strip_tags(trim($_POST['nome-fale-conosco'])));
        $email = addslashes(strip_tags(trim($_POST['email-fale-conosco'])));
        $assunto = addslashes(strip_tags(trim($_POST['assunto-fale-conosco'])));
        $mensagem = addslashes(strip_tags(trim($_POST['mensagem-fale-conosco'])));
    
        ?>
        <script>
        $(function(){
        <?php
            // Se o campo nome estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
            if(empty($nome)){
                $mensagens_erro["nome-vazio"] = true;
                ?>

                $("#mensagem-sucesso-fale-conosco").remove();
                $("#nome-fale-conosco").removeClass("is-valid");
                $("#nome-fale-conosco").addClass("is-invalid");
                if(!$("#nome-fale-conosco-erro-1").length){
                    $("#nome-fale-conosco").after("<div class='invalid-feedback' id='nome-fale-conosco-erro-1'>Este campo não pode ficar vazio</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["nome-vazio"]);
                ?>

                $("#mensagem-sucesso-fale-conosco").remove();
                $("#nome-fale-conosco").removeClass("is-invalid");
                $("#nome-fale-conosco").addClass("is-valid");
                $("#nome-fale-conosco-erro-1").remove();
      <?php } ?>

      <?php
            // Se o campo email estiver vázio, será mostrado um aviso, se não, esse aviso será removido.
            if(empty($email)){ 
                $mensagens_erro["email-vazio"] = true;
                ?>

                if(!$("#email-fale-conosco-erro-1").length){
                    $("#email-fale-conosco").after("<div class='invalid-feedback' id='email-fale-conosco-erro-1'>Este campo não pode ficar vazio</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["email-vazio"]);
                ?>

                $("#email-fale-conosco-erro-1").remove();
      <?php } ?>

    <?php
            // Se o email não for válido, será mostrado um aviso, se não, esse aviso será removido.
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $mensagens_erro["email-invalido"] = true;
                ?>

                if(!$("#email-fale-conosco-erro-2").length){
                    $("#email-fale-conosco").after("<div class='invalid-feedback' id='email-fale-conosco-erro-2'>Este email está inválido</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["email-invalido"]);
                ?>

                $("#email-fale-conosco-erro-2").remove();
      <?php } 

            // Se não existir erro no email, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
            ?>
            if(!$("#email-fale-conosco-erro-1").length && !$("#email-fale-conosco-erro-2").length){
                $("#mensagem-sucesso-fale-conosco").remove();
                $("#email-fale-conosco").removeClass("is-invalid");
                $("#email-fale-conosco").addClass("is-valid");            
            }else{
                $("#mensagem-sucesso-fale-conosco").remove();
                $("#email-fale-conosco").removeClass("is-valid");
                $("#email-fale-conosco").addClass("is-invalid");
            }

        <?php
            // Se o campo assunto estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
            if(empty($assunto)){
                $mensagens_erro["assunto-vazio"] = true;
                ?>

                $("#mensagem-sucesso-fale-conosco").remove();
                $("#assunto-fale-conosco").removeClass("is-valid");
                $("#assunto-fale-conosco").addClass("is-invalid");
                if(!$("#assunto-fale-conosco-erro-1").length){
                    $("#assunto-fale-conosco").after("<div class='invalid-feedback' id='assunto-fale-conosco-erro-1'>Este campo não pode ficar vazio</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["assunto-vazio"]);
                ?>

                $("#mensagem-sucesso-fale-conosco").remove();
                $("#assunto-fale-conosco").removeClass("is-invalid");
                $("#assunto-fale-conosco").addClass("is-valid");
                $("#assunto-fale-conosco-erro-1").remove();
      <?php } ?>

        <?php
            // Se o campo mensagem estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
            if(empty($mensagem)){
                $mensagens_erro["mensagem-vazio"] = true;
                ?>

                $("#mensagem-sucesso-fale-conosco").remove();
                $("#mensagem-fale-conosco").removeClass("is-valid");
                $("#mensagem-fale-conosco").addClass("is-invalid");
                if(!$("#mensagem-fale-conosco-erro-1").length){
                    $("#mensagem-fale-conosco").after("<div class='invalid-feedback' id='mensagem-fale-conosco-erro-1'>Este campo não pode ficar vazio</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["mensagem-vazio"]);
                ?>

                $("#mensagem-sucesso-fale-conosco").remove();
                $("#mensagem-fale-conosco").removeClass("is-invalid");
                $("#mensagem-fale-conosco").addClass("is-valid");
                $("#mensagem-fale-conosco-erro-1").remove();
      <?php }

            // Se não houver erros, a mensagem será enviada.
            if(count($mensagens_erro) == 0){
                // PHPMailer
                $mail->addAddress('Um email que vai receber as mensagens, pode ser qualquer um');
                $mail->Subject = "$assunto";
                $mail->Body = "<h4>Nome:</h4> <p>$nome</p>
                <h4>Email:</h4> <p>$email</p>
                <h4>Mensagem:</h4>
                <p>$mensagem</p>";

                if(!$mail->Send()){
                    echo 'Erro ao tentar enviar o email:' . $mail->ErrorInfo;
                }

                // Removendo o aviso de válido e limpando todos os campos.
                // Se não houver mensagem de sucesso, ela será criada.
                ?>
                $("#nome-fale-conosco").removeClass("is-valid");
                $("#nome-fale-conosco").val("");
                $("#email-fale-conosco").removeClass("is-valid");
                $("#email-fale-conosco").val("");
                $("#assunto-fale-conosco").removeClass("is-valid");
                $("#assunto-fale-conosco").val("");
                $("#mensagem-fale-conosco").removeClass("is-valid");
                $("#mensagem-fale-conosco").val("");

                // Se não existir a mensagem de sucesso, ela será mostrada. Isso é para evitar repetição de mensagem.
                if(!$("#mensagem-sucesso-fale-conosco").length){
                    $("#enviar").after("<div class='text-center pt-3' id='mensagem-sucesso-fale-conosco'><span class='text-success'>Mensagem enviada com sucesso</span></div>");
                }
      <?php } ?>
        })
        </script>
<?php }
?>