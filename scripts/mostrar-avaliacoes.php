<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }

    // Script com métodos para várias coisas.
    require_once 'dados.php';
    $mostrar_avaliacoes = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

    // Mostrando todas as avaliações e retornado para o ajax mostrar na página.
    $avaliacao_dados = $mostrar_avaliacoes->BuscarAvaliacoes(); 
    foreach($avaliacao_dados as $ad){ 
        // Formatando a data recebida do banco de dados
        $data = new DateTime($ad["data"]);
        $horario = $data->format("d/m/Y")." - ".$data->format("H:i:s");
        ?>

        <div class="avaliacao-usuario pb-3" data-value="<?= $ad['id'] ?>">
            <div class="d-flex flex-row">
                <img src="<?= $ad['imagem_usuario'] ?>" alt="Imagem do usuário" class='img-fluid rounded-circle border-verde mr-3 imagem-perfil-avaliacao<?= $ad['pk_id_usuario'] ?>' style='width: 60px; height: 60px;'>

                <div class="d-flex flex-column">
                    <div class="d-flex flex-row">
                        <p class="mb-2">
                            <span class="text-success pr-2"><?= $ad["nome_usuario"] ?></span>
                      <?php // Se o estado for diferente de vazio, ele será mostrado.
                            if(!empty($ad["estado_usuario"])){ ?>
                            <span class="pr-2" style="color: #c3c3c3;"><?= $ad["estado_usuario"] ?></span>
                      <?php } ?>
                            <span class="pr-2" style="color: #c3c3c3;"><?= $horario ?></span>
                        </p>

                        <?php
                        // O botão de excluir só vai aparecer nas avaliações do usuário logado.
                        if(isset($_SESSION["id_usuario"])){
                            if($ad["pk_id_usuario"] == $_SESSION["id_usuario"]){ ?>
                            <div>
                                <i class="fas fa-window-close" id="excluir-avaliacao" data-toggle='modal' data-target="#remover-avaliacao-modal-usuario<?= $ad['id'] ?>"></i>
                            </div>
                    <?php }
                        } ?>
                    </div>

                    <div class="d-flex flex-row">
                        <p class="text-light text-justify mb-0"><?= $ad["avaliacao"] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="avaliacao-usuario-modal-e-ajax" data-value="<?= $ad['id'] ?>">
            <!-- REMOVER AVALIAÇÃO -->
            <div class='modal fade' id="remover-avaliacao-modal-usuario<?= $ad['id'] ?>" tabindex='-1' role='dialog' aria-label="remover-avaliacao-modal-usuario<?= $ad['id'] ?>" aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered'>
                    <div class='modal-content'>
                        <div class='modal-body'>
                            <div class='row d-flex justify-content-end mr-1'>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>

                            <div class='row d-flex justify-content-center mt-4 mb-3'>
                                <p class='text-preto'>Você tem certeza que quer remover sua avaliação?</p>
                            </div>

                            <form method="POST" class='row d-flex justify-content-center mb-2'>
                                <button type="button" class='btn btn-verde py-1 mr-2' style='width: 60px;' id="deletar_avaliacao<?= $ad['id'] ?>_usuario" value="<?= $ad['id'] ?>">Sim</button>

                                <button type='button' class='btn btn-danger py-1 ml-2' data-dismiss='modal' style='width: 60px;'>Não</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- // REMOVER AVALIAÇÃO -->

            <script>
                $(function(){
                    // Enviando o id da avaliação para um script que vai deletar essa avaliação.
                    $("#deletar_avaliacao<?= $ad['id'] ?>_usuario").click(function(){
                        // Fechando a modal de pergunta antes de deletar uma avaliação
                        $("#remover-avaliacao-modal-usuario<?= $ad['id'] ?>").modal("hide");

                        var id_avaliacao = $("#deletar_avaliacao<?= $ad['id'] ?>_usuario").val();

                        $.ajax({
                            url: "scripts/deletar-avaliacao.php",
                            type: "post",
                            data: {id_avaliacao:id_avaliacao},
                            success: function(resposta){
                                $("#avaliacoes-titulo").after(resposta);

                                $.ajax({
                                    url: "scripts/mostrar-dados-usuario.php",
                                    type: "get",
                                    success: function(resposta){
                                        var dados = jQuery.parseJSON(resposta);

                                        // Se a quantidade de avaliações for maior que zero, será mostrado o titulo 'Avaliações', se não, será mostrado um aviso de que não existe avaliações.
                                        if(dados["qtd_avaliacoes"] != 0){
                                            $("#avaliacoes-titulo").removeClass("d-none");
                                            $("#avaliacoes-titulo").addClass("d-flex");
                                            $("#sem-avaliacoes-aviso").removeClass("d-flex");
                                            $("#sem-avaliacoes-aviso").addClass("d-none");
                                        }else{
                                            $("#sem-avaliacoes-aviso").removeClass("d-none");
                                            $("#sem-avaliacoes-aviso").addClass("d-flex");
                                            $("#avaliacoes-titulo").removeClass("d-flex");
                                            $("#avaliacoes-titulo").addClass("d-none");
                                        }
                                    }
                                })
                            }
                        })
                    })
                })
            </script>
        </div>
    <?php
    }
?>