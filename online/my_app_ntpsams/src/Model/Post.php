<?php


namespace App\Model;


class Post extends Mainmodel
{

    protected   $table = "posts";
    protected   $id;
    protected   $title;
    protected   $leveld;
    protected   $content;
    protected   $statuts;
    protected   $iduser;
    protected   $created_at;
    protected   $updated_at;
    protected   $deleted_at;


    protected $sql_queries;





    public function __construct()
    {
        //dd('creation de la table');
        if ($this->tableExists($this->table) == false) {
            $create = $this->tablecreate();
            if ($create == false) {
                echo 'Problem lors de l\' insertion ';
            }
        }

    }


    private function tablecreate(){
        //dd('Table');
        $this->pdoconnect()->exec("CREATE TABLE IF NOT EXISTS ".$this->table." (
            id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
            idref int(100) not null,
            idss int(100) NULL,
            idsss int(100) NULL,
            title varchar(250) NULL,
            content text COLLATE latin1_general_ci  NULL,
            leveld int(11) NULL,
            statuts int(11) NULL,
            lng int(100) NULL,
            iduser int(11) NULL,
            created_at datetime COLLATE latin1_general_ci NULL,
            updated_at datetime COLLATE latin1_general_ci NULL,
            deleted_at datetime COLLATE latin1_general_ci NULL,
            PRIMARY KEY (id) )
            ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");
        return true;
    }












}
