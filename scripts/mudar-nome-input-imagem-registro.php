<script>
<?php
    // Imagem usuário da modal registro.
    // Se nenhuma imagem for escolhida, o placeholder do input file imagem será alterado para o texto padrão, se não, será alterado para o nome da imagem e seu tipo.
    if(!$_FILES['imagem-usuario']['name']){
        ?>
            $("#placeholder-input-imagem-usuario").text("Escolha uma imagem");
        <?php
    }else{
        ?>
            $("#placeholder-input-imagem-usuario").text("<?= $_FILES["imagem-usuario"]["name"] ?>");
        <?php
    }
?>
</script>