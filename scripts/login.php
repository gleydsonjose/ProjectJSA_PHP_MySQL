<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Se não houver uma sessão iniciada, será iniciada uma nova
        if(!isset($_SESSION)){
            session_start();
        }

        // Script com métodos para várias coisas.
        require_once 'dados.php'; 

        $metodo_login = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

        $mensagens_erro = [];
        $login = addslashes(strip_tags(trim($_POST['login'])));
        $senha = addslashes(strip_tags(trim($_POST['senha'])));

        ?>
        <script>
        $(function(){

        <?php
            // Se o campo login estiver vázio, será mostrado um aviso de erro, se não, esse aviso de erro será removido.
            if(empty($login)){ 
                $mensagens_erro["login-vazio"] = true;
                ?>

                $("#login").addClass("is-invalid");
                if(!$("#login-erro-1").length){
                    $("#login").after("<div class='invalid-feedback' id='login-erro-1'>Este campo não pode ficar vazio</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["login-vazio"]);
                ?>

                $("#login").removeClass("is-invalid");
                $("#login-erro-1").remove();
    <?php } ?>

        <?php
            // Se o campo senha estiver vázio, será mostrado um aviso de erro, se não, esse aviso de erro será removido.
            if(empty($senha)){ 
                $mensagens_erro["senha-vazio"] = true;
                ?>

                $("#senha").addClass("is-invalid");
                if(!$("#senha-erro-1").length){
                    $("#senha").after("<div class='invalid-feedback' id='senha-erro-1'>Este campo não pode ficar vazio</div>");
                }
      <?php }else{ 
                unset($mensagens_erro["senha-vazio"]);
                ?>

                $("#senha").removeClass("is-invalid");
                $("#senha-erro-1").remove();
    <?php } ?>

        <?php
        // Se não houver erros, tudo abaixo será executado.
        if(count($mensagens_erro) == 0){
            // Se não existir um login com o login e senha recebido, será mostrado um aviso de erro, senão, esse aviso será removido e a página será atualizada junto com o login efetuado.
            if(!$metodo_login->Login($login, $senha)){ ?>
                if(!$("#login-senha-erro-1").length){
                    $("#entrar").after("<div class='text-center pt-3' id='login-senha-erro-1'><span class='text-danger'>Login ou Senha está incorreto(a)</span></div>");
                }
    <?php }else{ ?>
            location.reload();
            $("#login-senha-erro-1").remove();
    <?php }
        } ?>

        })
        </script> 
<?php }
?>