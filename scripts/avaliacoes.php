<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Script com métodos para várias coisas.
        require_once 'dados.php'; 
        $avaliacoes = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

        $mensagens_erro = [];
        $avaliacao = addslashes(strip_tags(trim($_POST['avaliacao-campo'])));

        ?>
        <script>
        $(function(){
        <?php
            // Se o usuário não estiver logado ao tentar avaliar, será mostrado um aviso de erro, se não, o aviso de erro será removido.
            if(!isset($_SESSION["id_usuario"])){ 
                $mensagens_erro["avaliacao-login"] = true;
                ?>

                $("#avaliacao-campo").addClass("is-invalid");
                if(!$("#avaliacoes-mensagem-erro-1").length){
                    $("#avaliar-div").after("<div class='text-center pt-1' id='avaliacoes-mensagem-erro-1'><span class='text-danger'>Você precisa estar logado para avaliar</span></div>");
                }
      <?php }else{ 
                unset($mensagens_erro["avaliacao-login"]);
                ?>

                $("#avaliacao-campo").removeClass("is-invalid");
                $("#avaliacoes-mensagem-erro-1").remove();
      <?php } ?>

        <?php
            // Se o campo avaliacao estiver vázio, será mostrado um aviso de erro, se não, o aviso de erro será removido.
            if(empty($avaliacao)){ 
                $mensagens_erro["avaliacao-vazio"] = true;
                ?>

                $("#avaliacao-campo").addClass("is-invalid");
                if(!$("#avaliacoes-mensagem-erro-2").length){
                    $("#avaliar-div").after("<div class='text-center pt-1' id='avaliacoes-mensagem-erro-2'><span class='text-danger'>Este campo não pode ficar vazio</span></div>");
                }
      <?php }else{ 
                unset($mensagens_erro["avaliacao-vazio"]);
                ?>

                $("#avaliacao-campo").removeClass("is-invalid");
                $("#avaliacoes-mensagem-erro-2").remove();
      <?php } ?>

        <?php
            // Se não houver erros, a mensagem será enviada.
            if(count($mensagens_erro) == 0){
                // Armazenando as avaliações do usuário no banco de dados
                $avaliacoes->GuardarAvaliacaoUsuario($avaliacao, $_SESSION["id_usuario"]);

                ?>
                // Limpando o campo avaliação.
                $("#avaliacao-campo").val("");

      <?php } ?>

        })
        </script>
<?php }
?>