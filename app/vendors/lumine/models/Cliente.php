<?php
#### START AUTOCODE
/**
 *
 * @LumineEntity(package="models")
 * @LumineTable(name="cliente")
 */
class Cliente extends Lumine_Base {
	/**
     * Coluna id
     * @LumineId
     * @LumineColumn(name="id", column="id", type="int", length=11, options={notnull=true ,autoincrement=true})
     */ 
    public $id;

    /**
     * Coluna nome
     * @LumineColumn(name="nome", column="nome", type="varchar", length=120)
     */ 
    public $nome;

    /**
     * Coluna email
     * @LumineColumn(name="email", column="email", type="varchar", length=120)
     */ 
    public $email;

    /**
     * Coluna status
     * @LumineColumn(name="status", column="status", type="char", length=1)
     */ 
    public $status;

    /**
     * Coluna createAt
     * @LumineColumn(name="createAt", column="create_at", type="datetime", length= NULL)
     */ 
    public $createAt;
	
	
	
	#### END AUTOCODE
}

