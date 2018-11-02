<?php  

class Usuario {

	private $idusuario;
	private $desloguin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario(){
		return $this->idusuario;
	}
	public function setIdusuario($value){
		$this->idusuario = $value;
	}
	public function getDesloguin(){
		return $this->desloguin;
	}
	public function setDesloguin($value){
		$this->desloguin = $value;
	}
	public function getDessenha(){
		return $this->dessenha;
	}
	public function setDessenha($value){
		$this->dessenha = $value;
	}
	public function getDtcadastro(){
		return $this->dtcadastro;
	}
	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}

	public function loadById($id){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
		":ID"=>$id
		));

		if(count($results) > 0){

			$row = $results[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDesloguin($row['desloguin']); 
			$this->setDessenha($row['dessenha']); 
			$this->setDtcadastro(new DateTime($row['dtcadastro'])); 
		}
	}

	public static function getList(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY desloguin;");
	}

	public static function search($loguin){

		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE desloguin LIKE :SEARCH ORDER BY desloguin", array(
			":SEARCH"=>"%".$loguin."%"
		));
	}

	public function loguin($loguin, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE desloguin = :LOGUIN AND dessenha = :PASSWORD", array(
		":LOGUIN"=>$loguin,
		":PASSWORD"=>$password
		));

		if(count($results) > 0){

			$row = $results[0];

			$this->setIdusuario($row['idusuario']);
			$this->setDesloguin($row['desloguin']); 
			$this->setDessenha($row['dessenha']); 
			$this->setDtcadastro(new DateTime($row['dtcadastro'])); 
		} else {

			throw new Exception("Login e/ou senha incorretos!", 1);
			

		}
	}

	public function __toString(){

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"desloguin"=>$this->getDesloguin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
		));
	}
}


?>