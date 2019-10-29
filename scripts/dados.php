<?php
    // Pegando a data e hora de São Paulo
    date_default_timezone_set('America/Sao_Paulo');
    
    Class Dados{
        // Conexão do banco de dados.
        public function __construct($bdnome, $host, $usuario, $senha){
            try{
                $this->pdo = new PDO("mysql:dbname=".$bdnome.";charset=utf8;host=".$host, $usuario, $senha);
            }catch(PDOException $e){
                echo "Erro com PDO: ".$e->getMessage();
            }catch(Exception $e){
                echo "Erro: ".$e->getMessage();
            }
        }

        // Verificando se existe um usuário com o login recebido.
        public function VerificarLogin($login){
            $sql = $this->pdo->prepare("SELECT id FROM usuarios WHERE login = :l");
            $sql->bindValue(':l', $login, PDO::PARAM_STR);
            $sql->execute();
            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        // Com o id e email recebido, será verificado se existe um usuário com esses dados, se sim, será retornado true, se não, será verificado se existe um usuário com o email recebido, se sim, será retornado false, se não, retornará true.
        public function VerificarEmail($id, $email){
            $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id AND email = :e");
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            $sql->bindValue(':e', $email, PDO::PARAM_STR);
            $sql->execute();
            if($sql->rowCount() == 1){
                return true;
            }else{
                $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :e");
                $sql->bindValue(':e', $email, PDO::PARAM_STR);
                $sql->execute();
                if($sql->rowCount() != 0){
                    return false;
                }else{
                    return true;
                }
            }
        }

        // Alterando os dados do usuário a partir do seu id.
        public function AlterarDados($id, $email, $nome, $sobrenome, $imagem_usuario, $cidade, $estado, $telefone){
            $sql = $this->pdo->prepare('UPDATE usuarios SET email = :e, nome = :n, sobrenome = :sn, imagem_perfil = :i, cidade = :ci, estado = :es, telefone = :t WHERE id = :id');
            $sql->bindValue(':id', $id, PDO::PARAM_INT);
            $sql->bindValue(':e', $email, PDO::PARAM_STR);
            $sql->bindValue(':n', $nome, PDO::PARAM_STR);
            $sql->bindValue(':sn', $sobrenome, PDO::PARAM_STR);
            $sql->bindValue(':i', $imagem_usuario, PDO::PARAM_STR);
            $sql->bindValue(':ci', $cidade, PDO::PARAM_STR);
            $sql->bindValue(':es', $estado, PDO::PARAM_STR);
            $sql->bindValue(':t', $telefone, PDO::PARAM_STR);
            $sql->execute();
        }

        // Método para registrar o usuário.
        public function Registrar($login, $email, $nome, $sobrenome, $senha, $imagem_usuario){
            $sql = $this->pdo->prepare("INSERT INTO usuarios (login, email, nome, sobrenome, senha, imagem_perfil, cidade, estado, telefone, dataderegistro) VALUES (:l, :e, :n, :sn, :s, :i, '', '', '0', :ddr)");
            $sql->bindValue(':l', $login, PDO::PARAM_STR);
            $sql->bindValue(':e', $email, PDO::PARAM_STR);
            $sql->bindValue(':n', ucfirst($nome), PDO::PARAM_STR);
            $sql->bindValue(':sn', ucfirst($sobrenome), PDO::PARAM_STR);
            $sql->bindValue(':s', password_hash($senha, PASSWORD_ARGON2I, ['cost' => 12]), PDO::PARAM_STR);
            $sql->bindValue(':i', $imagem_usuario, PDO::PARAM_STR);
            $sql->bindValue(':ddr', date('Y-m-d H:i:s'));
            $sql->execute();
            return true;
        }

        // Buscando a senha do usuário no bd a partir do login recebido, se a senha recebida for igual a senha no bd, a senha recebida do bd será usada na próxima etapa, se não, a senha usada será a recebida pela modal login.
        // Logo após a verificação, será analisado se existe no bd um usuário com o login recebido e a senha verificada, se sim, será criada uma sessão com o id do usuário e será retornado true, se não, false será retornado.
        public function Login($login, $senha_login){
            $sql = $this->pdo->prepare("SELECT senha FROM usuarios WHERE login = :l");
            $sql->bindValue(':l', $login);
            $sql->execute();
            $senha_bd = $sql->fetch();
            if(password_verify($senha_login, $senha_bd['senha'])){
                $senha_resultado = $senha_bd['senha'];
            }else{
                $senha_resultado = $senha_login;
            }

            $sql = $this->pdo->prepare('SELECT * FROM usuarios WHERE login = :l AND senha = :s');
            $sql->bindValue(':l', $login);
            $sql->bindValue(':s', $senha_resultado);
            $sql->execute();
            if($sql->rowCount() > 0){
                $dados = $sql->fetch();
                $_SESSION['id_usuario'] = $dados['id'];
                return true;
            }else{
                return false;
            }
        }

        // Buscando dados do usuário pelo id recebido.
		public function BuscarDadosUsuarios($id){
			$sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
			$sql->bindValue(":id", $id, PDO::PARAM_INT);
			$sql->execute();
			return $sql->fetch();
        }

        // Armazenando as avaliações do usuário no banco de dados
        public function GuardarAvaliacaoUsuario($avaliacao, $id_usuario){
            $sql = $this->pdo->prepare("INSERT INTO avaliacoes (avaliacao, data, pk_id_usuario) VALUES (:a, :d, :piu)");
            $sql->bindValue(":a", $avaliacao, PDO::PARAM_STR);
            $sql->bindValue("d", date("Y-m-d H:i:s"));
            $sql->bindValue(":piu", $id_usuario, PDO::PARAM_INT);
            $sql->execute();
        }

        // Buscando as avaliações dos usuários com a data de envio, com a imagem de perfil, nome e estado do usuário.
        public function BuscarAvaliacoes(){
            $sql = $this->pdo->prepare("SELECT * ,(SELECT imagem_perfil FROM usuarios WHERE id = pk_id_usuario) AS imagem_usuario, (SELECT nome FROM usuarios WHERE id = pk_id_usuario) AS nome_usuario, (SELECT estado FROM usuarios WHERE id = pk_id_usuario) AS estado_usuario FROM avaliacoes ORDER BY id DESC");
            $sql->execute();
            return $sql->fetchAll();
        }

        // Método para deletar a avaliação do usuário a partir do id da avaliação e do usuário
        public function DeletarAvaliacaoUsuario($id_avaliacao, $id_usuario){
            $sql = $this->pdo->prepare("DELETE FROM avaliacoes WHERE id = :id AND pk_id_usuario = :piu");
            $sql->bindValue(":id", $id_avaliacao, PDO::PARAM_INT);
            $sql->bindValue(":piu", $id_usuario, PDO::PARAM_INT);
            $sql->execute();
        }

        // Método para guardar a newsletter no banco de dados
        public function Newsletter($email){
            $sql = $this->pdo->prepare("INSERT INTO newsletter (email) VALUES (:e)");
            $sql->bindValue(":e", $email, PDO::PARAM_STR);
            $sql->execute();
        }
    }
?>