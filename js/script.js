$(function(){

    // Deixando o menu fixo a partir de um certo ponto do scroll da página.
    $(window).scroll(function(){
        if($(this).scrollTop() >= $('.menu-principal').offset().top){
            $('.menu-principal').addClass('fixed-top');
            $('body').css('padding-top','70px');
        }

        if($(this).scrollTop() < $('.logotipo').outerHeight()){
            $('.menu-principal').removeClass('fixed-top');
            $('body').css('padding-top','0px');
        }
    })

    // Enviando dados do usuário para um script que vai verificar cada um dos dados antes de alterar os dados no banco de dados.
    $("#alterar").click(function(){
        $.ajax({
            url: "scripts/alterar-dados.php",
            type: "post",
            data: new FormData($("#alterar-dados-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            },
            beforeSend: function(){
                $('#carregamento-dados-alterar-dados').removeClass('d-none');
            },
            complete: function(){
                $('#carregamento-dados-alterar-dados').addClass('d-none');
            },
        })
    })

    // Quando o modal alterar dados for fechado, a mensagem de sucesso do alterar dados será removida.
    $("#alterar-dados-modal").on("hidden.bs.modal", function(){
        $("#mensagem-sucesso-alterar-dados").remove();
    })

    // Enviando dados recebidos pela página login para um script que vai realizar algumas verificações antes de realizar o login.
    $("#entrar").click(function(){
        $.ajax({
            url: "scripts/login.php",
            type: "post",
            data: new FormData($("#login-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            },
            beforeSend: function(){
                $('#carregamento-dados-login').removeClass('d-none');
            },
            complete: function(){
                $('#carregamento-dados-login').addClass('d-none');
            },
        })
    })

    // Enviando dados do usuário para um script que vai verificar cada um dos dados antes de realizar o registro.
    $("#registrar").click(function(){
        $.ajax({
            url: "scripts/registro.php",
            type: "post",
            data: new FormData($("#registro-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            },
            beforeSend: function(){
                $('#carregamento-dados-registro').removeClass('d-none');
            },
            complete: function(){
                $('#carregamento-dados-registro').addClass('d-none');
            },
        })
    })

    // Apenas mudando o placeholder do input file imagem na modal registro.
    $("#imagem-usuario").change(function(){
        $.ajax({
            url: "scripts/mudar-nome-input-imagem-registro.php",
            type: "post",
            data: new FormData($("#registro-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            }
        })
    })

    // Apenas mudando o placeholder do input file imagem na modal alterar dados.
    $("#imagem-usuario-alterar-dados").change(function(){
        $.ajax({
            url: "scripts/mudar-nome-input-imagem-alterardados.php",
            type: "post",
            data: new FormData($("#alterar-dados-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            }
        })
    })

    // Quando o modal registro for fechado, a mensagem de sucesso do registro será removida.
    $("#registro-modal").on("hidden.bs.modal", function(){
        $("#mensagem-sucesso-registro").remove();
    })

    // Enviando dados do usuário para um script que vai verificar cada um dos dados antes de enviar a mensagem.
    $("#enviar").click(function(){
        $.ajax({
            url: "scripts/fale-conosco.php",
            type: "post",
            data: new FormData($("#fale-conosco-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            },
            beforeSend: function(){
                $('#carregamento-dados-fale-conosco').removeClass('d-none');
            },
            complete: function(){
                $('#carregamento-dados-fale-conosco').addClass('d-none');
            },
        })
    })

    // Quando o modal fale conosco for fechado, a mensagem de sucesso do envio da mensagem será removida.
    $("#fale-conosco-modal").on("hidden.bs.modal", function(){
        $("#mensagem-sucesso-fale-conosco").remove();
    })

    $("#avaliar").click(function(){
        // Enviando a avaliação do usuário para um script que vai verificar a avaliação antes de enviar para o banco de dados.
        $.ajax({
            url: "scripts/avaliacoes.php",
            type: "post",
            data: new FormData($("#avaliacao-form")[0]),
            contentType: false,
            processData: false,
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            },
            beforeSend: function(){
                $('#carregamento-dados-avaliacoes').removeClass('d-none');
            },
            complete: function(){
                $('#carregamento-dados-avaliacoes').addClass('d-none');
            },
        })

        // Passando o data-value de cada avaliacao do usuario para um array, para ser enviado para um script.
        var id_avaliacoes = [];
        $(".avaliacao-usuario").each(function(){
            let id = parseInt($(this).attr("data-value"));
            id_avaliacoes.push(id);
        })

        $.ajax({
            url: "scripts/nova-avaliacao-pagina.php",
            type: "post",
            data: {id_avaliacoes:id_avaliacoes},
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

                // Limpando o campo avaliação;
                $("#avaliacao-campo").val("");
            }
        })
    })

    // Quando a página for aberta, as avaliações com a image, nome, estado e a data de envio serão mostradas.
    $(window).ready(function(){
        $.ajax({
            url: "scripts/mostrar-avaliacoes.php",
            type: "get",
            success: function(resposta){
                $("#avaliacoes-titulo").after(resposta);
            }
        })

        $.ajax({
            url: "scripts/mostrar-avisos-avaliacoes.php",
            type: "get",
            success: function(quantidade_avaliacoes){
                // Se a quantidade de avaliações for maior que zero, será mostrado o titulo 'Avaliações', se não, será mostrado um aviso de que não existe avaliações.
                if(quantidade_avaliacoes != 0){
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

    // Quando o botão inscrever-se for clicado, o email digitado no campo será verificado, se for aceito ele será enviado para o banco de dados.
    $("#inscrever-se").click(function(){
        var newsletter_email = $("#newsletter-email").val();

        $.ajax({
            url: "scripts/newsletter.php",
            type: "post",
            data: {newsletter_email:newsletter_email},
            success: function(resposta){
                $("#retorno-ajax-js").html(resposta);
            }
        })
    })

    $(window).scroll(function(){

        // oT = Distância do elemento para o topo da página.
        // wS = Posição atual da barra de rolagem(window).
        // scroll_final = é o final da rolagem.

        var oT_topo_pagina = $('#topo-pagina').offset().top;
        var oT_servicos_section = $('#servicos_section').offset().top;
        var oT_avaliacoes_section = $('#avaliacoes_section').offset().top;
        var scroll_final = $(document).height() - $(window).height();
        wS = $(this).scrollTop();

        // Realizando a troca de classe 'ativo' e 'btn-nav' entre os menus de acordo com a posição do scroll.
        if(wS > (oT_topo_pagina - 70) && wS < oT_servicos_section){
            $('#menu-nav a').eq(0).addClass('ativo');
            $('#menu-nav a').eq(0).removeClass('btn-nav');
        }else{
            $('#menu-nav a').eq(0).removeClass('ativo');
            $('#menu-nav a').eq(0).addClass('btn-nav');
        }

        if(wS > oT_servicos_section && wS < oT_avaliacoes_section){
            $('#menu-nav a').eq(1).addClass('ativo');
            $('#menu-nav a').eq(1).removeClass('btn-nav');
        }else{
            $('#menu-nav a').eq(1).removeClass('ativo');
            $('#menu-nav a').eq(1).addClass('btn-nav');
        }

        if(wS > oT_avaliacoes_section && wS != scroll_final){
            $('#menu-nav a').eq(2).addClass('ativo');
            $('#menu-nav a').eq(2).removeClass('btn-nav');
        }else{
            $('#menu-nav a').eq(2).removeClass('ativo');
            $('#menu-nav a').eq(2).addClass('btn-nav');
        }

        if(wS == scroll_final){
            $('#menu-nav a').eq(3).addClass('ativo');
            $('#menu-nav a').eq(3).removeClass('btn-nav');
        }else{
            $('#menu-nav a').eq(3).removeClass('ativo');
            $('#menu-nav a').eq(3).addClass('btn-nav');
        }
    })

    // Quando for clicado em cada botão escolhido, a rolagem será movida até a área escolhida.
    $('#menu-nav a').eq(0).click(function(){
        $('html, body').animate({
            scrollTop: ($('#topo-pagina').offset().top - 70)
        }, 900)
    })

    $('#menu-nav a').eq(1).click(function(){
        $('html, body').animate({
            scrollTop: ($('#servicos_section').offset().top + 1)
        }, 900)
    })

    $('#menu-nav a').eq(2).click(function(){
        $('html, body').animate({
            scrollTop: ($('#avaliacoes_section').offset().top + 1)
        }, 900)
    })

    $('#menu-nav a').eq(3).click(function(){
        $('html, body').animate({
            scrollTop: ($(document).height() - $(window).height())
        }, 900)
    })
})