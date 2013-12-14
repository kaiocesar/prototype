<?php 
/**
 * Model Usuario
 * @author Kaio Cesar
 * @package ChatOnline
 * @version 1.0
 */

class default_models_usuario extends library_Model {


	public function verify() {
			$nick = $_POST['nick'];
	
	if(substr_count($nick,' ') == strlen($nick)){
		$erro = 'Apelido não pode conter somente espaços em branco.';
	}else{
		//evitando problemas com javascript ',"",(,),|
		$nick = str_replace('"',' ',$nick);
		$nick = str_replace(';','',$nick);
		$nick = str_replace('(','',$nick);
		$nick = str_replace(')','',$nick);
		$nick = str_replace("'"," ",$nick);
		$nick = str_replace('|','',$nick);
		$nick = sql_inject($nick);
		
		$sql = new Mysql;
		//deleta usuarios sem atividade
		$sql->Consulta("DELETE FROM $tabela_usu WHERE tempo < $tempovida");
		//deleta mensagens antigas
		$sql->Consulta("DELETE FROM $tabela_msg  WHERE tempo < $tempovida"); 
		
		//total de usuários online
		$totalonline  = $sql->Totalreg("SELECT COUNT(*) FROM $tabela_usu");
		if($totalonline == 0){
			include('deletarimg.php');
		}
				
		//verificando se ja tem este nick
		$total  = $sql->Totalreg("SELECT COUNT(*) FROM $tabela_usu WHERE nick='$nick'");			
		if($total > 0){
			$erro = 'Este apelido ja está em uso.';
			
	}


}
