<?php
    // Se não houver uma sessão iniciada, será iniciada uma nova
    if(!isset($_SESSION)){
        session_start();
    }
    
    // Script com métodos para várias coisas.
    require_once 'dados.php';
    $dados = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

    // Verificando se a sessão usuário existe, se sim, será retornado os dados do usuário para o ajax.
    if(isset($_SESSION['id_usuario'])){
        $info = $dados->BuscarDadosUsuarios($_SESSION['id_usuario']);
        $data = new DateTime($info['dataderegistro']);
        $horario = $data->format("H:i:s")." de ".$data->format("d/m/Y");

        // Quantidade de avaliações no banco de dados.
        $qtd_avaliacoes = count($dados->BuscarAvaliacoes());

        echo json_encode(["id" => $info["id"], "nome" => $info["nome"], "sobrenome" => $info["sobrenome"], "dataderegistro" => $horario, "imagem_perfil" => $info["imagem_perfil"], "email" => $info["email"], "estado" => $info["estado"], "cidade" => $info["cidade"], "telefone" => $info["telefone"], "qtd_avaliacoes" => $qtd_avaliacoes]);
    }
?>