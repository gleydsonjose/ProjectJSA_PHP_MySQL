<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }

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
        $alterar_dados = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

        // Passando todos os dados do usuário a partir do seu id para um array.
        $info = $alterar_dados->BuscarDadosUsuarios($_SESSION['id_usuario']);

        $mensagens_erro = [];
        $imagem_usuario = addslashes(strip_tags(trim('imagens_usuarios/'.$_FILES['imagem-usuario-alterar-dados']['name'])));
        $email = addslashes(strip_tags(trim($_POST['email-alterar-dados'])));
        $nome = addslashes(strip_tags(trim($_POST['nome-alterar-dados'])));
        $sobrenome = addslashes(strip_tags(trim($_POST['sobrenome-alterar-dados'])));
        $estado = addslashes(strip_tags(trim($_POST['estado-alterar-dados'])));
        $cidade = addslashes(strip_tags(trim($_POST['cidade-alterar-dados'])));
        $telefone = addslashes(strip_tags(trim($_POST['telefone-alterar-dados'])));

        ?>
        <script>
        $(function(){
            <?php
                // Se o campo email estiver vázio, será mostrado um aviso, se não, esse aviso será removido.
                if(empty($email)){ 
                    $mensagens_erro["email-vazio"] = true;
                    ?>

                    if(!$("#email-alterar-dados-erro-1").length){
                        $("#email-alterar-dados").after("<div class='invalid-feedback' id='email-alterar-dados-erro-1'>Este campo não pode ficar vazio</div>");
                    }
          <?php }else{ 
                    unset($mensagens_erro["email-vazio"]);
                    ?>

                    $("#email-alterar-dados-erro-1").remove();
          <?php } ?>

            <?php
                // Se o email não for válido, será mostrado um aviso, se não, esse aviso será removido.
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $mensagens_erro["email-invalido"] = true;
                    ?>

                    if(!$("#email-alterar-dados-erro-2").length){
                        $("#email-alterar-dados").after("<div class='invalid-feedback' id='email-alterar-dados-erro-2'>Este email está inválido</div>");
                    }
          <?php }else{ 
                    unset($mensagens_erro["email-invalido"]);
                    ?>

                    $("#email-alterar-dados-erro-2").remove();
          <?php } ?>

            <?php
                // Se existir um usuário com este email, será mostrado um aviso, se não(se o email for o mesmo do usuário ou diferente), esse aviso será removido.
                if(!$alterar_dados->VerificarEmail($_SESSION["id_usuario"], $email)){
                    $mensagens_erro["verificacao-email"] = true;
                    ?>

                    if(!$("#email-alterar-dados-erro-3").length){
                        $("#email-alterar-dados").after("<div class='invalid-feedback' id='email-alterar-dados-erro-3'>Já existe um usuário com este email</div>");
                    }
          <?php }else{ 
                    unset($mensagens_erro["verificacao-email"]);
                    ?>

                    $("#email-alterar-dados-erro-3").remove();
          <?php }

                // Se não existir erro no email, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
                ?>

                if(!$("#email-alterar-dados-erro-1").length && !$("#email-alterar-dados-erro-2").length && !$("#email-alterar-dados-erro-3").length){
                    $("#mensagem-sucesso-registro").remove();
                    $("#email-alterar-dados").removeClass("is-invalid");
                    $("#email-alterar-dados").addClass("is-valid");            
                }else{
                    $("#mensagem-sucesso-registro").remove();
                    $("#email-alterar-dados").removeClass("is-valid");
                    $("#email-alterar-dados").addClass("is-invalid");
                }

            <?php
                // Se nenhuma imagem for escolhida, uma variável para avisar que nenhuma imagem será passada será criada.
                if(!$_FILES['imagem-usuario-alterar-dados']['name']){
                    $imagem_nao_escolhida = true;

                    ?>
                        $("#mensagem-sucesso-alterar-dados").remove();
                        $("#imagem-usuario-alterar-dados").removeClass("is-invalid");
                        $("#imagem-usuario-alterar-dados").removeClass("is-valid");
                        $("#imagem-usuario-alterar-dados-erro-1").remove();
                    <?php
                }else{
                    // Se uma imagem for escolhida, tudo abaixo será executado.
                    // Passando as dimensões da imagem para um array.
                    // [0] = Largura da imagem.
                    // [1] = Altura da imagem.
                    $dimensoes_imagem = getimagesize($_FILES['imagem-usuario-alterar-dados']['tmp_name']);
                    $largura_imagem = $dimensoes_imagem[0];
                    $altura_imagem = $dimensoes_imagem[1];

                    // Se a imagem for menor que 75x75, será mostrado um aviso, se não, esse aviso será removido.
                    if($largura_imagem < 75 && $altura_imagem < 75){ 
                        $mensagens_erro["dimensao-imagem-erro"] = true;
                        ?>

                        if(!$("#imagem-usuario-alterar-dados-erro-1").length){
                            $("#imagem-usuario-alterar-dados").after("<div class='invalid-feedback' id='imagem-usuario-alterar-dados-erro-1'>A imagem precisa ser maior que 75x75</div>");
                        }
              <?php }else{ 
                        unset($mensagens_erro["dimensao-imagem-erro"]);
                        ?>
                        
                        $("#imagem-usuario-alterar-dados-erro-1").remove();
              <?php }

                    // Passando o tipo da imagem para uma variável.
                    $tipo_imagem = pathinfo($imagem_usuario, PATHINFO_EXTENSION);

                    // Se o tipo da imagem não for jpg, jpeg ou png, será mostrado um aviso, se não, esse aviso será removido.
                    if(!in_array($tipo_imagem, array('jpg', 'jpeg', 'png'))){ 
                        $mensagens_erro["tipo-imagem-erro"] = true;
                        ?>

                        if(!$("#imagem-usuario-alterar-dados-erro-2").length){
                            $("#imagem-usuario-alterar-dados").after("<div class='invalid-feedback' id='imagem-usuario-alterar-dados-erro-2'>O tipo da imagem precisa ser JPG, JPEG ou PNG</div>");
                        }
              <?php }else{ 
                        unset($mensagens_erro["tipo-imagem-erro"]);
                        ?>
                        
                        $("#imagem-usuario-alterar-dados-erro-2").remove();
              <?php }

                    // Se o tamanho da imagem for igual a 0 ou maior que 500kb, será mostrado um aviso, se não, esse aviso será removido.
                    if($_FILES['imagem-usuario-alterar-dados']['size'] == 0 || $_FILES['imagem-usuario-alterar-dados']['size'] > 500000){ 
                        $mensagens_erro["tamanho-imagem-erro"] = true;
                        ?>

                        if(!$("#imagem-usuario-alterar-dados-erro-3").length){
                            $("#imagem-usuario-alterar-dados").after("<div class='invalid-feedback' id='imagem-usuario-alterar-dados-erro-3'>O tamanho da imagem precisa estar entre 1 e 500KB</div>");
                        }
              <?php }else{ 
                        unset($mensagens_erro["tamanho-imagem-erro"]);
                        ?>
                        
                        $("#imagem-usuario-alterar-dados-erro-3").remove();
              <?php }

                    // Se não existir erro na imagem, será mostrado um aviso de sucesso, se não, será mostrado um aviso de erro.
                    ?>
                    if(!$("#imagem-usuario-alterar-dados-erro-1").length && !$("#imagem-usuario-alterar-dados-erro-2").length && !$("#imagem-usuario-alterar-dados-erro-3").length){
                        $("#mensagem-sucesso-alterar-dados").remove();
                        $("#imagem-usuario-alterar-dados").removeClass("is-invalid");
                        $("#imagem-usuario-alterar-dados").addClass("is-valid");            
                    }else{
                        $("#mensagem-sucesso-alterar-dados").remove();
                        $("#imagem-usuario-alterar-dados").removeClass("is-valid");
                        $("#imagem-usuario-alterar-dados").addClass("is-invalid");
                    }
          <?php } ?>

            <?php
                // Se o campo nome estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
                if(empty($nome)){ 
                    $mensagens_erro["nome-vazio"] = true;
                    ?>

                    $("#mensagem-sucesso-alterar-dados").remove();
                    $("#nome-alterar-dados").removeClass("is-valid");
                    $("#nome-alterar-dados").addClass("is-invalid");
                    if(!$("#nome-alterar-dados-erro-1").length){
                        $("#nome-alterar-dados").after("<div class='invalid-feedback' id='nome-alterar-dados-erro-1'>Este campo não pode ficar vazio</div>");
                    }
          <?php }else{ 
                    unset($mensagens_erro["nome-vazio"]);
                    ?>

                    $("#mensagem-sucesso-alterar-dados").remove();
                    $("#nome-alterar-dados").removeClass("is-invalid");
                    $("#nome-alterar-dados").addClass("is-valid");
                    $("#nome-alterar-dados-erro-1").remove();
          <?php } ?>

            <?php
                // Se o campo sobrenome estiver vázio, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
                if(empty($sobrenome)){ 
                    $mensagens_erro["sobrenome-vazio"] = true;
                    ?>

                    $("#mensagem-sucesso-alterar-dados").remove();
                    $("#sobrenome-alterar-dados").removeClass("is-valid");
                    $("#sobrenome-alterar-dados").addClass("is-invalid");
                    if(!$("#sobrenome-alterar-dados-erro-1").length){
                        $("#sobrenome-alterar-dados").after("<div class='invalid-feedback' id='sobrenome-alterar-dados-erro-1'>Este campo não pode ficar vazio</div>");
                    }
          <?php }else{ 
                    unset($mensagens_erro["sobrenome-vazio"]);
                    ?>

                    $("#mensagem-sucesso-alterar-dados").remove();
                    $("#sobrenome-alterar-dados").removeClass("is-invalid");
                    $("#sobrenome-alterar-dados").addClass("is-valid");
                    $("#sobrenome-alterar-dados-erro-1").remove()
          <?php } ?>

            <?php
                // Se o campo não tiver números digitados, será mostrado um aviso de erro, se não, vai ser mostrado um aviso de sucesso.
                if(preg_match("/[^0-9]/", $telefone)){ 
                    $mensagens_erro["telefone-sem-numeros"] = true;
                    ?>

                    $("#mensagem-sucesso-alterar-dados").remove();
                    $("#telefone-alterar-dados").removeClass("is-valid");
                    $("#telefone-alterar-dados").addClass("is-invalid");
                    if(!$("#telefone-alterar-dados-erro-1").length){
                        $("#telefone-alterar-dados").after("<div class='invalid-feedback' id='telefone-alterar-dados-erro-1'>Digite apenas números no campo Telefone</div>");
                    }
          <?php }else{ 
                    unset($mensagens_erro["telefone-sem-numeros"]);
                    ?>

                    $("#mensagem-sucesso-alterar-dados").remove();
                    $("#telefone-alterar-dados").removeClass("is-invalid");

              <?php // Se o campo telefone não estiver vazio, será mostrado o aviso de válido
                    if(!empty($telefone)){ ?>
                        $("#telefone-alterar-dados").addClass("is-valid");
              <?php } ?>

                    $("#telefone-alterar-dados-erro-1").remove()
          <?php } ?>

            <?php
                // Se não houver erros, os dados do usuário serão alterados.
                if(count($mensagens_erro) == 0){
                    // Se o telefone do campo Telefone for vazio, a variável telefone vai receber 0.
                    if($telefone == ""){
                        $telefone = 0;
                    }

                    // Se não houve escolha de imagem, a imagem que será enviada é a mesma do banco de dados, se não, será enviada a imagem escolhida e essa imagem será armazenada numa pasta, já a imagem antiga será apagada dessa pasta.
                    // OBS: Se a imagem antiga for a padrão, ela não será apagada.
                    if(isset($imagem_nao_escolhida) && $imagem_nao_escolhida == true){
                        $alterar_dados->AlterarDados($_SESSION["id_usuario"], $email, $nome, $sobrenome, $info["imagem_perfil"], $cidade, $estado, $telefone);
                    }else{
                        $alterar_dados->AlterarDados($_SESSION["id_usuario"], $email, $nome, $sobrenome, $imagem_usuario, $cidade, $estado, $telefone);

                        if(strpos($info["imagem_perfil"], "imagens_usuarios/imagem_padrao.png") === false){
                            unlink("../".$info["imagem_perfil"]);
                        }
                        
                        copy($_FILES['imagem-usuario-alterar-dados']['tmp_name'], "../".$imagem_usuario);
                    }

                    // PHPMailer
                    $mail->addAddress($email);
                    $mail->Subject = "Dados alterados";
                    $mail->Body = " $nome, seus dados foram alterados com sucesso";

                    if(!$mail->Send()){
                        echo 'Erro ao tentar enviar o email:' . $mail->ErrorInfo;
                    }

                    // Chamando o método de busca de dados novamente pelo motivo de que os dados foram alterados, então o array info está com os dados anteriores armazenados, com essa nova chamada, os novos substituirão os antigos e assim será mostrado os novos dados nos campos e textos.
                    $info = $alterar_dados->BuscarDadosUsuarios($_SESSION['id_usuario']);

                    // Removendo o aviso de válido.
                    // Se não houver mensagem de sucesso, ela será criada.
                    ?>
                    $("#email-alterar-dados").removeClass("is-valid");
                    $("#imagem-usuario-alterar-dados").removeClass("is-valid");
                    $("#nome-alterar-dados").removeClass("is-valid");
                    $("#sobrenome-alterar-dados").removeClass("is-valid");
                    $("#telefone-alterar-dados").removeClass("is-valid");
                    $("#placeholder-input-alterar-dados-imagem-usuario").text("Escolha uma imagem");

                    // A imagem do usuário no menu vai receber o diretório da imagem e o nome do usuário no menu será mostrado, a imagem do usuário na modal alterar dados vai receber o diretório da imagem e todas as outras informações e campos serão preenchidos com os dados do usuário.
                    // As imagens do usuário na área avaliações serão atualizadas também.
                    $("#imagem-perfil-menu").prop("src", "<?= $info["imagem_perfil"] ?>" + "?<?= time() ?>");
                    $(".imagem-perfil-avaliacao<?= $info["id"] ?>").prop("src", "<?= $info["imagem_perfil"] ?>" + "?<?= time() ?>");
                    $("#imagem-usuario-avaliar").prop("src", "<?= $info["imagem_perfil"] ?>" + "?<?= time() ?>");
                    $("#nome-usuario-menu").text("<?= $info["nome"] ?>");
                    
                    $("#id-usuario-alterar-dados").text("<?= $info["id"] ?>");
                    $("#nome-usuario-alterar-dados").text("<?= $info["nome"] ?>" + " " + "<?= $info["sobrenome"] ?>");
                    $("#imagem-perfil-alterar-dados").prop("src", "<?= $info["imagem_perfil"] ?>" + "?<?= time() ?>");
                    $("#email-alterar-dados").val("<?= $info["email"] ?>");
                    $("#nome-alterar-dados").val("<?= $info["nome"] ?>");
                    $("#sobrenome-alterar-dados").val("<?= $info["sobrenome"] ?>");
                    $("#cidade-alterar-dados").val("<?= $info["cidade"] ?>");

                    // Se o telefone do usuário no banco de dados for diferente de 0, será mostrado esse telefone, se não, o campo vai ficar vázio.
                    if(<?= $info["telefone"] ?> != 0){
                        $("#telefone-alterar-dados").val("<?= $info["telefone"] ?>");
                    }else{
                        $("#telefone-alterar-dados").val("");
                    }

                    // Se o estado do usuário no banco de dados estiver vazio, o option padrão do select vai ter o valor 0 e o texto "Escolha seu estado",  se não, o valor e o texto vai receber o estado do usuário no banco de dados.
                    if("<?= $info["estado"] ?>" == ""){
                        $("#estado-padrao").prop("value", "0");
                        $("#estado-padrao").text("Escolha seu estado");
                    }else{
                        $("#estado-padrao").prop("value", "<?= $info["estado"] ?>");
                        $("#estado-padrao").text("<?= $info["estado"] ?>");
                    }

                    // Pegando o arquivo json, colocando na ordem reversa e colocando cada estado em um option.
                    // OBS: Se o estado do usuário no banco de dados for igual o estado na lista, esse estado não será mostrado para não ter repetição.
                    // Pegando o arquivo json com todos os estados e colocando na ordem reversa, e assim passando cada estado em um option.
                    // Como a ordem do envio dos dados é reverso, a numeração mostrada de cada estado acaba sendo também, com isso será criada uma variável que vai receber o total de estados.
                    $.getJSON('scripts/estados.json', function(json_estados){
                        var estado_numeracao = json_estados.length;

                        $.each(json_estados.reverse(), function(chave, estado){
                            if(estado.nome == "<?= $info["estado"] ?>"){
                                return true;
                            }

                            // Como já existe um preenchimento do select que é feito a partir de quando a modal alterar dados é aberta, com esse if todos os options antigos serão apagados, para no próximo if ser preenchido novamente.
                            // Isso é para evitar a repetição do estado escolhido antes do click no botão alterar dados.
                            if($("#estado"+estado_numeracao+"-lista").length){
                                $("#estado"+estado_numeracao+"-lista").remove();
                            }

                            // Esse if é apenas para não repetir as options se o evento escolhido(clicar no botão alterar) for executado outras vezes.
                            if(!$("#estado"+estado_numeracao+"-lista").length){
                                $("#estado-padrao").after("<option value='"+estado.nome+"' id='estado"+estado_numeracao+"-lista'>"+estado.nome+"</option>");
                            }
                            
                            estado_numeracao--;
                        });
                    });

                    // Se não existir a mensagem de sucesso, ela será mostrada. Isso é para evitar repetição de mensagem.
                    if(!$("#mensagem-sucesso-alterar-dados").length){
                        $("#alterar").after("<div class='text-center pt-3' id='mensagem-sucesso-alterar-dados'><span class='text-success'>Dados alterados  com sucesso</span></div>");
                    }
          <?php } ?>
        })
        </script>
        <?php
    }
?>