<script>
<?php
    // Imagem usuário da modal alterar dados.
    // Se nenhuma imagem for escolhida, o placeholder do input file imagem será alterado para o texto padrão, se não, será alterado para o nome da imagem e seu tipo.
    if(!$_FILES['imagem-usuario-alterar-dados']['name']){
        ?>
            $("#placeholder-input-alterar-dados-imagem-usuario").text("Escolha uma imagem");
        <?php
    }else{
        ?>
            $("#placeholder-input-alterar-dados-imagem-usuario").text("<?= $_FILES["imagem-usuario-alterar-dados"]["name"] ?>");
        <?php
    }
?>
</script>