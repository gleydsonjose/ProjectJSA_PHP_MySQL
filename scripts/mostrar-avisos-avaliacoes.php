<?php
    // Script com métodos para várias coisas.
    require_once 'dados.php';
    $mostrar_avisos = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

    // Pegando a quantidade de avaliações no banco de dados.
    $quantidade_avaliacoes = count($mostrar_avisos->BuscarAvaliacoes()); 

    echo $quantidade_avaliacoes;
?>