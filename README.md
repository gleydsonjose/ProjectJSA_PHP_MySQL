# ProjectJSA_PHP_MySQL
ProjectJSA foi criado usando HTML5, CSS3, Jquery, AJAX, Bootstrap 4, PHP e MySQL.

Instruções para o site funcionar corretamente:

	Faça as seguintes alterações nos arquivos abaixo:
		* Apenas altere o que está entre aspas.
		* As alterações é para uso do banco de dados e funcionamento do PHPMailer.

       'index.php':
		Linha 9: $dados = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

	Scripts da pasta 'scripts':
		'registro.php':
			Linha 15: $mail->Username = 'Conta gmail liberada para enviar email para outlook, hotmail...';
			Linha 16: $mail->Password = 'Senha do email gmail';
			Linha 18: $mail->From = 'Conta gmail liberada para enviar email para outlook, hotmail...';
			Linha 19: $mail->FromName = 'Seu nome ou da empresa';
			Linha 24: $registrar = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'nova-avaliacao-pagina.php':
			Linha 9: $nova_avaliacao_pagina = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'newsletter.php':
			Linha 10: $newsletter = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'mostrar-dados-usuario.php':
			Linha 9: $dados = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'mostrar-avisos-avaliacoes.php':
			Linha 4: $mostrar_avisos = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'mostrar-avaliacoes.php':
			Linha 9: $mostrar_avaliacoes = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'login.php':
			Linha 11: $metodo_login = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'fale-conosco.php':
			Linha 15: $mail->Username = 'Conta gmail liberada para enviar email para outlook, hotmail...';
			Linha 16: $mail->Password = 'Senha do email gmail';
			Linha 18: $mail->From = 'Conta gmail liberada para enviar email para outlook, hotmail...';
			Linha 19: $mail->FromName = 'Seu nome ou da empresa';
			Linha 24: $faleconosco = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");
			Linha 148: $mail->addAddress('Um email que vai receber as mensagens, pode ser qualquer um');

		'deletar-avaliacao.php':
			Linha 10: $deletar_avaliacoes = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'avaliacoes.php':
			Linha 10: $avaliacoes = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");

		'alterar-dados':
			Linha 19: $mail->Username = 'Conta gmail liberada para enviar email para outlook, hotmail...';
			Linha 20: $mail->Password = 'Senha do email gmail';
			Linha 22: $mail->From = 'Conta gmail liberada para enviar email para outlook, hotmail...';
			Linha 23: $mail->FromName = 'Seu nome ou da empresa';
			Linha 27: $alterar_dados = new Dados("nome do banco de dados", "host", "nome de usuario", "senha");
