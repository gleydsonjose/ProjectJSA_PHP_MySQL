<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }
    
    // Script com métodos para várias coisas.
    require_once 'scripts/dados.php';
    $dados = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='content-type' content='text/html;charset=utf-8'/>
    <meta name='author' content='Gleydson José'>
    <meta name='robots' content='index, follow'>
    <meta name='description' content='This site is only a project test'>
    <meta name='keywords' content='ProjectJSA, JSA'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <link rel='icon' href='imagens/favicon.png?<?= time() ?>'>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
    <link href="https://fonts.googleapis.com/css?family=Ropa+Sans&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css' integrity='sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay' crossorigin='anonymous'>
    <link rel='stylesheet' href='css/estilo.css?<?= time() ?>'>
    <title>Project JSA</title>
</head>
<body>
    <!-- HEADER -->
    <div class='container-fluid' id="topo-pagina">
        <div class='row'>
            <div class="col-12 px-0">
                <nav class='navbar navbar-expand-lg navbar-dark bg-preto shadow py-1 menu-principal'>
                    <a class='navbar-brand ml-2 logotipo' href='index.php'>
                        <img src="imagens/logo.png?<?= time() ?>" alt="Logotipo" style="height: 55px;">
                    </a>

                    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#menu-nav'>
                        <i class="fas fa-bars" style="margin-top: 1px;"></i>
                    </button>

                    <div class='collapse navbar-collapse menu-mobile' id='menu-nav'>
                       <ul class='navbar-nav mt-1 mt-lg-0'>
                            <a class='nav-link text-lg-center ativo'>
                                <i class='fas fa-home text-success d-none d-lg-block mt-lg-1'></i>
                                <li class='nav-item mt-lg-1 mx-lg-2'>Inicio</li>
                            </a>

                            <a class='nav-link text-lg-center btn-nav'>
                                <i class="fas fa-toolbox text-success d-none d-lg-block mt-lg-1"></i>
                                <li class='nav-item mt-lg-1 mx-lg-2'>Serviços</li>
                            </a>

                            <a class='nav-link text-lg-center btn-nav'>
                                <i class='fas fa-thumbs-up text-success d-none d-lg-block mt-lg-1'></i>
                                <li class='nav-item mt-lg-1 mx-lg-2'>Avaliações</li>
                            </a>

                            <a class='nav-link text-lg-center btn-nav'>
                                <i class="fas fa-envelope-open-text text-success d-none d-lg-block mt-lg-1"></i>
                                <li class='nav-item mt-lg-1 mx-lg-2'>Newsletter</li>
                            </a>
                        </ul>

                        <ul class="navbar-nav ml-auto menu-usuario py-2">
                        <?php // Verificando se não tem ninguém logado
                            if(!isset($_SESSION['id_usuario'])){ ?>
                            <div class="align-self-center">
                                <button type="button" class="btn btn-outline-light mr-1" data-toggle='modal' data-target='#login-modal'>Entrar</button>
                            </div>

                            <div class="align-self-center mr-lg-3">
                                <button type="button" class="btn btn-verde" data-toggle='modal' data-target='#registro-modal' id="registro-btn">Registrar-se</button>
                            </div>
                        <?php // Se tem alguém logado, será mostrado a sua imagem de perfil, nome e um menu dropdown.
                            }else{ ?>
                            <div class='row w-100-mobile d-flex justify-content-center'>
                                <img src="imagens_usuarios/imagem_padrao.png" alt="Imagem do perfil do usuário" class='img-fluid rounded-circle border-verde' style='width: 45px; height: 45px;' id="imagem-perfil-menu">

                                <li class='text-light ml-2 name-user align-self-center' style="cursor: default;" id="nome-usuario-menu"></li>

                                <a class='nav-link dropdown-toggle btn-dropdown' data-toggle='dropdown' style="margin-top: 5px;"></a>

                                <li class='nav-item dropdown ml-1 mr-lg-4 mt-1 align-self-center w-100-mobile'>
                                    
                                    <div class='dropdown-menu dropdown-menu-right mt-2'>
                                        <a class='dropdown-item dropdown-item-menu-principal' data-toggle='modal' data-target='#alterar-dados-modal'>Alterar dados</a>
                                        <a class='dropdown-item dropdown-item-menu-principal' href='scripts/sair.php'>Sair</a>
                                    </div>
                                </li>
                            </div>
                      <?php } ?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        
        <div class='row'>
            <div class="banner-principal-div">
                <img alt='Banner site' src='imagens/banner-principal.png?<?= time() ?>' class='img-fluid shadow'/>

                <div class="banner-informacoes w-100" style="position: absolute;">
                    <div class="titulo-banner">
                        <h2 class="text-light" style="text-shadow: 2px 2px 4px #000000;">SERVIÇOS EM AR CONDICIONADO</h2>
                        <h5 class="text-success" style="text-shadow: 2px 2px 4px #000000;">AQUI VOCÊ VAI ENCONTRAR A SOLUÇÃO PARA O SEU PROBLEMA</h5>
                    </div>

                    <div class="atendimento">
                        <p class='text-light' style="text-shadow: 2px 2px 4px #000000;">Atendimento ao cliente:<br>Celular: (00) 0000-0000<br>Email: jsa@outlook.com</p>

                        <div>
                            <button type='button' class='btn btn-verde' data-toggle='modal' data-target='#fale-conosco-modal'>Fale conosco</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- // HEADER -->
    
    <?php 
    // Se existir uma sessão de login, essa modal será mostrada.
    if(isset($_SESSION['id_usuario'])){ ?>
    <!-- ALTERAR DADOS MODAL -->
    <div class='modal fade' id='alterar-dados-modal' tabindex='-1' role='dialog' aria-labelledby='alterar-dados-modal' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header modal-head'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>

                <div class='modal-body pb-0 pt-0'>
                    <h5 class="pb-2 px-2">Informações do usuário</h5>

                    <div class="row px-3 pb-3 border-bottom">
                        <img src="" alt="Imagem do perfil do usuário" class='img-fluid rounded-circle border-verde align-self-center ml-1' style='width: 60px; height: 60px;' id="imagem-perfil-alterar-dados">

                        <div class="ml-3">
                            <span class="text-dark">ID: </span><span class="text-muted" id="id-usuario-alterar-dados">69</span><br>
                            <span class="text-dark">Nome: </span><span class="text-muted" id="nome-usuario-alterar-dados">Gleydson josé</span><br>
                            <span class="text-dark">Data registro: </span><span class="text-muted" id="data-registro-usuario-alterar-dados">25/10/2019</span>
                        </div>
                    </div>

                    <form method='POST' autocomplete='off' role='form' enctype='multipart/form-data' id="alterar-dados-form" class="px-2 pt-3">
                        <h5 class="pb-3">Dados alteráveis</h5>

                        <div class="form-group">
                            <label for="imagem-usuario-alterar-dados"><i class="fas fa-image pr-2"></i>Imagem de perfil <span class="text-muted">(Opcional)</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imagem-usuario-alterar-dados" id="imagem-usuario-alterar-dados" accept="image/*">
                                <label class="custom-file-label" for="imagem-usuario-alterar-dados" id="placeholder-input-alterar-dados-imagem-usuario">Escolha uma imagem</label>
                            </div>                        
                        </div>

                        <div class='form-group'>
                            <label for='email-alterar-dados'><i class="fas fa-envelope pr-2"></i>Email</label>
                            <input type='text' class='form-control' maxlength='70' name='email-alterar-dados' id='email-alterar-dados' placeholder='Digite seu email aqui *'>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nome-alterar-dados"><i class="fas fa-user pr-2"></i>Nome</label>
                                <input type="text" class="form-control" name="nome-alterar-dados" id="nome-alterar-dados" placeholder="Digite seu nome aqui *" maxlength="40">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sobrenome-alterar-dados"><i class="far fa-user pr-2"></i>Sobrenome</label>
                                <input type="text" class="form-control" name="sobrenome-alterar-dados" id="sobrenome-alterar-dados" placeholder="Digite seu sobrenome aqui *" maxlength="40">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="estado-alterar-dados"><i class="fas fa-flag pr-2"></i>Estado</label>

                                <select class="form-control" name="estado-alterar-dados" id="estado-alterar-dados">
                                    <option value="0" id="estado-padrao" selected>Escolha o seu estado</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="cidade-alterar-dados"><i class="fas fa-city pr-2"></i>Cidade</label>
                                <input type="text" class="form-control" name="cidade-alterar-dados" id="cidade-alterar-dados" placeholder="Digite o nome da sua cidade" maxlength="100">
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='telefone-alterar-dados'><i class="fas fa-phone pr-2"></i>Telefone</label>
                            <input type='email' class='form-control' maxlength='20' name='telefone-alterar-dados' id='telefone-alterar-dados' placeholder='ex: 021900001010'>
                        </div>

                        <div class='form-group text-center'>
                            <button type='button' class='btn btn-verde mt-3' id="alterar">Alterar dados</button>
                        </div>

                        <div class="row">
                            <img src="imagens/ajax-loader.gif" alt="GIF de carregamento" id="carregamento-dados-alterar-dados" class="pb-3 mx-auto d-none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- // ALTERAR DADOS -->
    <?php } ?>

    <!-- LOGIN MODAL -->
    <div class='modal fade' id='login-modal' tabindex='-1' role='dialog' aria-labelledby='login-modal' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-login modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header modal-head'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>

                <div class='modal-body pb-0 px-4'>
                    <form method='POST' autocomplete='off' role='form' id="login-form">
                        <div class='form-group'>
                            <label for='login'><i class="fas fa-user pr-2"></i>Login</label>
                            <input type='text' class='form-control' maxlength='40' name='login' id='login' placeholder='Digite seu login aqui *'>
                        </div>

                        <div class='form-group'>
                            <label for='senha'><i class="fas fa-lock pr-2"></i>Senha</label>
                            <input type='password' class='form-control' maxlength='30' name='senha' id='senha' placeholder='Digite sua senha aqui *'>
                        </div>

                        <div class='form-group text-center'>
                            <button type='button' class='btn btn-verde mt-3' id="entrar">Fazer login</button>
                        </div>

                        <div class="row">
                            <img src="imagens/ajax-loader.gif" alt="GIF de carregamento" id="carregamento-dados-login" class="pb-3 mx-auto d-none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- // LOGIN MODAL -->

    <!-- REGISTRO MODAL -->
    <div class='modal fade' id='registro-modal' tabindex='-1' role='dialog' aria-labelledby='registro-modal' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header modal-head'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body pb-0 px-4'>
                    <form method='POST' autocomplete='off' role='form' enctype='multipart/form-data' id="registro-form">
                        <div class='form-group'>
                            <label for='login-registro'><i class="fas fa-user pr-2"></i>Login</label>
                            <input type='text' class='form-control' maxlength='40' name='login-registro' id='login-registro' placeholder='Digite seu login aqui *'>
                        </div>

                        <div class='form-group'>
                            <label for='email-registro'><i class="fas fa-envelope pr-2"></i>Email</label>
                            <input type='email' class='form-control' maxlength='70' name='email-registro' id='email-registro' placeholder='Digite seu email aqui *'>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nome-registro"><i class="fas fa-user pr-2"></i>Nome</label>
                                <input type="text" class="form-control" name="nome-registro" id="nome-registro" placeholder="Digite seu nome aqui *" maxlength="40">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sobrenome-registro"><i class="far fa-user pr-2"></i>Sobrenome</label>
                                <input type="text" class="form-control" name="sobrenome-registro" id="sobrenome-registro" placeholder="Digite seu sobrenome aqui *" maxlength="40">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="senha-registro"><i class="fas fa-lock pr-2"></i>Senha</label>
                                <input type="password" class="form-control" name="senha-registro" id="senha-registro" placeholder="Digite sua senha aqui *" maxlength="30">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="repita-senha-registro"><i class="fas fa-key pr-2"></i>Repita senha</label>
                                <input type="password" class="form-control" name="repita-senha-registro" id="repita-senha-registro" placeholder="Digite sua senha novamente *" maxlength="30">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="imagem-usuario"><i class="fas fa-image pr-2"></i>Imagem de perfil <span class="text-muted">(Opcional)</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="imagem-usuario" id="imagem-usuario" accept="image/*">
                                <label class="custom-file-label" for="imagem-usuario" id="placeholder-input-imagem-usuario">Escolha uma imagem</label>
                            </div>                        
                        </div>

                        <div class='form-group text-center'>
                            <button type='button' class='btn btn-verde mt-3' id="registrar">Registrar</button>
                        </div>

                        <div class="row">
                            <img src="imagens/ajax-loader.gif" alt="GIF de carregamento" id="carregamento-dados-registro" class="pb-3 mx-auto d-none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- // REGISTRO MODAL -->

    <!-- FALE CONOSCO MODAL -->
    <div class='modal fade' id='fale-conosco-modal' tabindex='-1' role='dialog' aria-labelledby='contact-us-modal' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title px-2'>Envie-nos uma mensagem por e-mail</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body pb-0 px-4'>
                    <form method='POST' autocomplete='off' role='form' id="fale-conosco-form">
                        <div class='form-group'>
                            <label for='nome-fale-conosco'><i class="fas fa-user pr-2"></i>Nome</label>
                            <input type='text' class='form-control' maxlength='70' name='nome-fale-conosco' id='nome-fale-conosco' placeholder='Digite seu nome aqui *'>
                        </div>

                        <div class='form-group'>
                            <label for='email-fale-conosco'><i class="fas fa-envelope pr-2"></i>Email</label>
                            <input type='email' class='form-control' maxlength='70' name='email-fale-conosco' id='email-fale-conosco' placeholder='Digite seu email aqui *'>
                        </div>

                        <div class='form-group'>
                            <label for='assunto-fale-conosco'><i class="fas fa-pen pr-2"></i>Assunto</label>
                            <input type='text' class='form-control' maxlength='70' name='assunto-fale-conosco' id='assunto-fale-conosco' placeholder='Digite o assunto da mensagem aqui *'>
                        </div>

                        <div class='form-group'>
                            <label for='mensagem-fale-conosco'><i class="fas fa-file-alt pr-2"></i>Mensagem</label>
                            <textarea name='mensagem-fale-conosco' id='mensagem-fale-conosco' class='form-control' maxlength='400' rows='4' cols='60' placeholder='Digite sua mensagem aqui *'></textarea>
                        </div>

                        <div class='form-group text-center'>
                            <button type='button' class='btn btn-verde mt-3' id="enviar">Enviar</button>
                        </div>

                        <div class="row">
                            <img src="imagens/ajax-loader.gif" alt="GIF de carregamento" id="carregamento-dados-fale-conosco" class="pb-3 mx-auto d-none">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- // FALE CONOSCO MODAL -->

    <!-- SERVIÇOS -->
    <div class='container-fluid bg-light mb-5 pt-3' id="servicos_section">
        <div class='row text-center'>
            <div class='col-12 py-5 px-0'>
                <div class='mt-5'>
                    <h1 class='font-weight-normal py-1 bg-preto text-success' style='font-size: 35px;'>Serviços</h1>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class="card col-12-servicos col-lg-4-servicos col-lg-4-instalacao text-center mt-3 py-3">
                <img class="card-img-top align-self-center rounded-circle shadow-sm mt-4" src="imagens/installation.png?<?= time() ?>" alt="Icone instalação">

                <div class="card-body">
                    <h3 class="card-title mt-4 text-success">Instalação</h3>
                    <p class="card-text lead text-muted mt-3">Realizamos a instalação do seu ar condicionado de maneira rápida e eficaz.</p>
                </div>
            </div>

            <div class="card col-12-servicos col-lg-4-servicos col-lg-4-limpeza text-center mt-3 py-3">
                <img class="card-img-top align-self-center rounded-circle shadow-sm mt-4" src="imagens/cleaning.png?<?= time() ?>" alt="Icone limpeza">

                <div class="card-body">
                    <h3 class="card-title mt-4 text-success">Limpeza</h3>
                    <p class="card-text lead text-muted mt-3">O seu ar condicionado está com dificuldade de funcionar? Faremos uma limpeza nele.</p>
                </div>
            </div>

            <div class="card col-12-servicos col-lg-4-servicos col-lg-4-manutencao text-center mt-3 py-3">
                <img class="card-img-top align-self-center rounded-circle shadow-sm mt-4" src="imagens/maintenance.png?<?= time() ?>" alt="Icone manutenção">

                <div class="card-body">
                    <h3 class="card-title mt-4 text-success">Manutenção</h3>
                    <p class="card-text lead text-muted mt-3">Precisa de uma manutenção no seu ar condicionado? Iremos resolver o seu problema.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- // SERVIÇOS -->

    <div class="pb-5" id="avaliacoes_section"></div>

    <!-- AVALIAÇÕES -->
    <div class="container-fluid bg-preto pt-3 pb-5">
        <div class="row text-center">
            <div class="col-12 py-5 px-0">
                <h1 class='font-weight-normal text-success' style='font-size: 35px;'>Avaliações dos clientes</h1>
            </div>
        </div>

        <div class="row mt-4 mb-3">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center">
                    <div class="border border-secondary rounded pt-4 pb-2 px-4 body-avaliacoes">
                        <div class="d-flex flex-row">
                            <h5 class='font-weight-normal text-light pb-2'>Deixe sua avaliação</h5>
                        </div>

                        <div class="d-flex flex-row">
                            <form method='POST' autocomplete='off' role='form' id="avaliacao-form">
                                <div class="d-flex flex-row">
                                    <img src="imagens_usuarios/imagem_padrao.png" alt="Imagem do usuário" class='img-fluid rounded-circle border-verde mr-3' style='width: 60px; height: 60px;' id="imagem-usuario-avaliar">

                                    <div class='form-group'>
                                        <textarea name='avaliacao-campo' id='avaliacao-campo' class='form-control' maxlength='400' rows='4' cols='60' placeholder='Digite sua avaliação aqui'></textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-column align-items-end" id="avaliar-div">
                                    <div class='form-group text-center'>
                                        <button type='button' class='btn btn-verde btn-sm mt-1' id="avaliar">Avaliar</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <img src="imagens/ajax-loader.gif" alt="GIF de carregamento" id="carregamento-dados-avaliacoes" class="mx-auto d-none">
                                </div>
                            </form>
                        </div>

                        <div class="flex-row mt-5 d-none" id="avaliacoes-titulo">
                            <h5 class='font-weight-normal text-light pb-3'>Avaliações</h5>
                        </div>

                        <div class="flex-row justify-content-center mt-4 d-none" id="sem-avaliacoes-aviso">
                            <h5 class="text-light">Ainda não há avaliações por aqui!</h5>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
    <!-- // AVALIAÇÕES -->

    <!-- NEWSLETTER -->
    <div class='container-fluid bg-light py-4 shadow'>
        <div class='row pt-5'>
            <div class='col-12'>
                <h3 class='text-center text-success pb-2'>Inscreva-se agora!</h3>
                <p class='text-center text-dark lead pb-3'>Assine nossa newsletter para se manter atualizado <br>sobre novas informações e valores de nossos serviços.</p>
            </div>
        </div>

        <div class='row d-flex justify-content-center'>
            <div class='col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4 text-center mb-5 pb-1'>
                <form method='POST' autocomplete='off' role='form'>
                    <div class='form-group text-left'>                   
                        <label for='newsletter-email' class='text-dark'>Email</label>
                        <input type='email' class='form-control' maxlength='70' name='newsletter-email' id='newsletter-email' placeholder='Digite o seu email aqui *'/>
                    </div>

                    <button type='button' class='btn btn-verde mt-2' id="inscrever-se">Inscrever-se</button>
                </form>
            </div>
        </div>
    </div>
    <!-- // NEWSLETTER -->

    <!-- FOOTER -->
    <div class='container-fluid bg-preto pt-5'>
        <div class='row'>
            <div class='col-6 pl-3 pl-lg-5 pb-4'>
                <h2 class='lead pb-1 text-light'>Atendimento ao cliente</h2>
                <p class='text-light'>Celular: (00) 0000-0000<br>Email: jsa@outlook.com</p>
            </div>

            <div class='col-6 text-right pr-3 pr-lg-5 pb-4'>
                <h2 class='lead pb-2 text-light'>Siga nossas redes sociais</h2>
                <a href="https://www.facebook.com/" target="_blank" class='text-success mr-2'><i class='fab fa-facebook-square' style='font-size: 25px;'></i></a>
                <a href="https://twitter.com/" target="_blank" class='text-success mr-2'><i class='fab fa-twitter-square' style='font-size: 25px;'></i></a>
                <a href="https://www.linkedin.com/" target="_blank" class='text-success mr-2'><i class='fab fa-linkedin' style='font-size: 25px;'></i></a>
                <a href="https://www.instagram.com/" target="_blank" class='text-success'><i class='fab fa-instagram' style='font-size: 25px;'></i></a>
            </div>
        </div>

        <div class='row'>
            <div class='col-12 d-flex align-items-end justify-content-center'>
                <p class='text-center text-light pb-1'>Copyright © Project JSA 2019. Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
    <!-- // FOOTER -->

    <div id="retorno-ajax-js"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>

    <?php 
    // Se existir uma sessão de login, esse script será mostrado.
    if(isset($_SESSION['id_usuario'])){ ?>
    <script>
        $(function(){
            // Quando a página for aberta, a imagem do usuário vai receber o diretório da imagem e o nome do usuário será mostrado, isso será feito via AJAX.
            // As imagens do usuário na área avaliações serão atualizadas também.
            $(window).ready(function(){
                $.ajax({
                    url: "scripts/mostrar-dados-usuario.php",
                    type: "get",
                    success: function(resposta){
                        var dados = jQuery.parseJSON(resposta);
                        $("#imagem-perfil-menu").prop("src", dados["imagem_perfil"] + "?<?= time() ?>");
                        $(".imagem-perfil-avaliacao"+dados["id"]).prop("src", dados["imagem_perfil"] + "?<?= time() ?>");
                        $("#imagem-usuario-avaliar").prop("src", dados["imagem_perfil"] + "?<?= time() ?>");
                        $("#nome-usuario-menu").text(dados["nome"]);

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
            })

            // Quando o modal alterar dados for aberto, a imagem do usuário no menu vai receber o diretório da imagem e o nome do usuário no menu será mostrado, a imagem do usuário na modal vai receber o diretório da imagem e todas as outras informações e campos serão preenchidos com os dados do usuário. Tudo isso via AJAX.
            $("#alterar-dados-modal").on("show.bs.modal", function(){
                $.ajax({
                    url: "scripts/mostrar-dados-usuario.php",
                    type: "get",
                    success: function(resposta){
                        var dados = jQuery.parseJSON(resposta);
                        $("#imagem-perfil-menu").prop("src", dados["imagem_perfil"] + "?<?= time() ?>");
                        $("#nome-usuario-menu").text(dados["nome"]);

                        $("#id-usuario-alterar-dados").text(dados["id"]);
                        $("#nome-usuario-alterar-dados").text(dados["nome"] + " " + dados["sobrenome"]);
                        $("#data-registro-usuario-alterar-dados").text(dados["dataderegistro"]);
                        $("#imagem-perfil-alterar-dados").prop("src", dados["imagem_perfil"] + "?<?= time() ?>");
                        $("#email-alterar-dados").val(dados["email"]);
                        $("#nome-alterar-dados").val(dados["nome"]);
                        $("#sobrenome-alterar-dados").val(dados["sobrenome"]);
                        $("#cidade-alterar-dados").val(dados["cidade"]);

                        // Se o telefone do usuário no banco de dados for diferente de 0, será mostrado esse telefone, se não, o campo vai ficar vázio.
                        if(dados["telefone"] != 0){
                            $("#telefone-alterar-dados").val(dados["telefone"]);
                        }else{
                            $("#telefone-alterar-dados").val("");
                        }

                        // Se o estado do usuário no banco de dados estiver vazio, o option padrão do select vai ter o valor 0 e o texto "Escolha seu estado",  se não, o valor e o texto vai receber o estado do usuário no banco de dados.
                        if(dados["estado"] == ""){
                            $("#estado-padrao").prop("value", "0");
                            $("#estado-padrao").text("Escolha seu estado");
                        }else{
                            $("#estado-padrao").prop("value", dados["estado"]);
                            $("#estado-padrao").text(dados["estado"]);
                        }

                        // Pegando o arquivo json, colocando na ordem reversa e colocando cada estado em um option.
                        // OBS: Se o estado do usuário no banco de dados for igual o estado na lista, esse estado não será mostrado para não ter repetição.
                        // Pegando o arquivo json com todos os estados e colocando na ordem reversa, e assim passando cada estado em um option.
                        // Como a ordem do envio dos dados é reverso, a numeração mostrada de cada estado acaba sendo também, com isso será criada uma variável que vai receber o total de estados.
                        $.getJSON('scripts/estados.json', function(json_estados){
                            var estado_numeracao = json_estados.length;

                            $.each(json_estados.reverse(), function (chave, estado){
                                if(estado.nome == dados["estado"]){
                                    return true;
                                }

                                // Como já existe um preenchimento do select que é feito a partir de quando o botão alterar dados é clicado, com esse if todos os options antigos serão apagados, para no próximo if ser preenchido novamente.
                                // Isso é para evitar a repetição do estado escolhido antes de abrir o modal alterar dados.
                                if($("#estado"+estado_numeracao+"-lista").length){
                                    $("#estado"+estado_numeracao+"-lista").remove();
                                }

                                // Esse if é apenas para não repetir as options se o evento escolhido(abrir a modal) for executado outras vezes.
                                if(!$("#estado"+estado_numeracao+"-lista").length){
                                    $("#estado-padrao").after("<option value='"+estado.nome+"' id='estado"+estado_numeracao+"-lista'>"+estado.nome+"</option>");
                                }

                                estado_numeracao--;
                            });
                        });
                    }
                })
            })
        })
    </script>
    <?php } ?>
    <script src='js/script.js?<?= time() ?>'></script>
</body>
</html>