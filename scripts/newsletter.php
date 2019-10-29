<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Script com métodos para várias coisas.
        require_once 'dados.php'; 
        $newsletter = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

        $mensagens_erro = [];
        $email = addslashes(strip_tags(trim($_POST['newsletter_email'])));

        ?>
        <script>
        $(function(){
        <?php
            // Se o campo email estiver vázio, será mostrado um aviso, se não, esse aviso será removido.
            if(empty($email)){ 
                $mensagens_erro["email-vazio"] = true;
                ?>

                if(!$("#email-newsletter-erro-1").length){
                    $("#inscrever-se").after("<div class='text-center pt-2' id='email-newsletter-erro-1'><span class='text-danger'>Este campo não pode ficar vázio</span></div>");
                }
      <?php }else{ 
                unset($mensagens_erro["email-vazio"]);
                ?>

                $("#email-newsletter-erro-1").remove();
      <?php } ?>

        <?php
            // Se o email não for válido, será mostrado um aviso, se não, esse aviso será removido.
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $mensagens_erro["email-invalido"] = true;
                ?>

                if(!$("#email-newsletter-erro-2").length){
                    $("#inscrever-se").after("<div class='text-center pt-2' id='email-newsletter-erro-2'><span class='text-danger'>Este email está inválido</span></div>");
                }
        <?php }else{ 
                unset($mensagens_erro["email-invalido"]);
                ?>

                $("#email-newsletter-erro-2").remove();
        <?php }

                // Se não existir erro no email, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
                ?>

                if(!$("#email-newsletter-erro-1").length && !$("#email-newsletter-erro-2").length){
                    $("#mensagem-sucesso-newsletter").remove();
                    $("#newsletter-email").removeClass("is-invalid");       
                }else{
                    $("#mensagem-sucesso-newsletter").remove();
                    $("#newsletter-email").addClass("is-invalid");
                }

        <?php
            // Se não houver erros, a mensagem será enviada.
            if(count($mensagens_erro) == 0){
                // Guardando os emails de newsletter no banco de dados.
                $newsletter->Newsletter($email);

                ?>
                // Se não existir a mensagem de sucesso, ela será mostrada. Isso é para evitar repetição de mensagem.
                if(!$("#mensagem-sucesso-newsletter").length){
                    $("#inscrever-se").after("<div class='text-center pt-3' id='mensagem-sucesso-newsletter'><span class='text-success'>Obrigado por ser inscrever-se.</span></div>");

                    // Removendo a mensagem de sucesso depois de 3 segundos.
                    function remover_mensagem_sucesso(){
                        $("#mensagem-sucesso-newsletter").fadeOut("slow", function(){
                            $(this).remove();
                        })
                    }
                    setTimeout(remover_mensagem_sucesso, 3000);
                }

                // Limpando o campo email da newsletter.
                $("#newsletter-email").val("");

      <?php } ?>

        })
        </script>
<?php }
?>