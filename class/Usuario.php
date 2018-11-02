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

			$this->setData($results[0]);
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

			$this->setData($results[0]);
			
		} else {

			throw new Exception("Login e/ou senha incorretos!", 1);
			

		}
	}
public function setData($data){

	$this->setIdusuario($data['idusuario']);
	$this->setDesloguin($data['desloguin']); 
	$this->setDessenha($data['dessenha']); 
	$this->setDtcadastro(new DateTime($data['dtcadastro'])); 
}

	public function insert(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGUIN, :PASSWORD)", array(
			":LOGUIN"=>$this->getDesloguin(),
			":PASSWORD"=>$this->getDessenha()
		));

		if (count($results) > 0){
			$this->setData($results[0]);
		}
	}

	public function update($loguin, $password){

		$this->setDesloguin($loguin);
		$this->setDessenha($password);

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET desloguin = :LOGUIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
				":LOGUIN"=>$this->getDesloguin(),
				":PASSWORD"=>$this->getDessenha(),
				":ID"=>$this->getIdusuario()
		));

	}

	public function __construct($loguin = "", $password = ""){
		$this->setDesloguin($loguin);
		$this->setDessenha($password);

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