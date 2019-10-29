<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Script com métodos para várias coisas.
        require_once 'dados.php'; 
        $deletar_avaliacoes = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

        // Deletando avaliação do usuário pelo id da avaliação e do usuário
        $deletar_avaliacoes->DeletarAvaliacaoUsuario($_POST["id_avaliacao"], $_SESSION["id_usuario"]);
        
        // Logo após a avaliação ser deletada, todas avaliações e outras informações serão colocadas em um array.
        $avaliacao_dados = $deletar_avaliacoes->BuscarAvaliacoes(); 

        ?>
        <script>
            $(function(){
                var id_avaliacoes = [];
                <?php
                    // Colocando todos ids de avaliações do banco de dados em um array, lembrando que uma avaliação foi deletada no código anterior.
                    foreach($avaliacao_dados as $ad){ ?>
                        id_avaliacoes.push(<?= $ad["id"]?>);
                <?php }
                ?>

                // Pegando todas avaliações que estão na página e realizando uma ação por cada uma, uma variável será criada para guardar o resultado retornado pelo atributo 'data-value' de cada avaliação, esse resultado vai ser convertido de string para int.
                // Agora será verificado se a avaliação da página existe no banco de dados, se ela não existe, simplesmente vai ser apagada da página.
                // Essa verificação é feita com o indexOf, que vai pegar o id retornado e vai verificar se ele existe no array criado anteriormente com ids do banco de dados.
                $(".avaliacao-usuario").each(function(){
                    let id = parseInt($(this).attr("data-value"));
                    if(id_avaliacoes.indexOf(id) === -1){
                        $(this).remove();
                    }
                })

                // Aqui vai fazer o mesmo que o pequeno script acima, só que para o modal e o script ajax da avaliação.
                // A ação aqui só vai ser realizada quando todo CSS da modal for fechada.
                $("#remover-avaliacao-modal-usuario<?= $_POST["id_avaliacao"] ?>").on('hidden.bs.modal', function () {
                    $(".avaliacao-usuario-modal-e-ajax").each(function(){
                        let id = parseInt($(this).attr("data-value"));
                        if(id_avaliacoes.indexOf(id) === -1){
                            $(this).remove();
                        }
                    })
                })

                // Deletando todo esse script da página depois de feito suas ações.
                $(".body-avaliacoes").find("script").eq(0).remove();
            })
        </script>
    <?php
    }
?>