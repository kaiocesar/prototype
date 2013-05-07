<?php
/**
 * @package miniframework/library/
 * @author Kaio Cesar <tecnico.kaio@gmail.com>
 */

class library_utils {
    
    public $patter = array(
        1 => ''
    );
    
    /**
     * Anti SQL Injection
     * @param type $texto
     * @return type
     */
    public static function anti_injection($texto){
       // Lista de palavras para procurar
       $check[1] = chr(34); // símbolo "
       $check[2] = chr(39); // símbolo '
       $check[3] = chr(92); // símbolo /
       $check[4] = chr(96); // símbolo `
       $check[5] = "drop table";
       $check[6] = "update";
       $check[7] = "alter table";
       $check[8] = "drop database";   
       $check[9] = "drop";
       $check[10] = "select";
       $check[11] = "delete";
       $check[12] = "insert";
       $check[13] = "alter";
       $check[14] = "destroy";
       $check[15] = "table";
       $check[16] = "database";
       $check[17] = "union";
       $check[18] = "TABLE_NAME";
       $check[19] = "1=1";
       $check[20] = 'or 1';
       $check[21] = 'exec';
       $check[22] = 'INFORMATION_SCHEMA';
       $check[23] = 'like';
       $check[24] = 'COLUMNS';
       $check[25] = 'into';
       $check[26] = 'VALUES';
       $check[27] = '--';
       $check[28] = ' ';
       $check[29] = '#';

       // Cria se as variáveis $y e $x para controle no WHILE que fará a busca e substituição
       $y = 1;
       $x = sizeof($check);
       // Faz-se o WHILE, procurando alguma das palavras especificadas acima, caso encontre alguma delas, este script substituirá por um espaço em branco " ".
       while($y <= $x){
             $target = strpos($texto,$check[$y]);
             if($target !== false){
                $texto = str_replace($check[$y], "", $texto);
             }
          $y++;
       }
       // Retorna a variável limpa sem perigos de SQL Injection
       return $texto;
    }
    
    /**
     * Normaliza o nome da Action para ser chamada pelo objeto dinamico
     * @param type $word
     * @return string $exp
     */
    public static function NormalizeAction ($word=null) {
        $exp = str_replace ("-"," ",$word);
        $exp = ucwords($exp);
        $exp = str_replace (" ","",$exp);

        return $exp;
    }
    

    /**
     *  CamelCase - Retorna a normalização do nome da Action
     *  @param string $action
     *  @return string $action // retorna o nome da action em CamelCase
     */
    public static function CamelCase($action=null) {
       $action = str_replace("-", " ", $action);
       $action = str_replace(" ", "", ucwords($action)); 
       return $action;
    }

    /**
     *  CleanArray - Retorna um array com casas "não vazias"
     *  @todo função de callback
     *  @param array $array
     *  @return
     */
    public static function CleanEmpytArray($array=null) {
        if (! empty($array)) return $array;
    }


}