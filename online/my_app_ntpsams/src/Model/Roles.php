<?php


namespace App\Model;


class Roles extends Mainmodel
{

    protected   $table = "roles";
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
        dd('controller');
        $this->sql_queries = [
            'title' => $this->title,
            'leveld' => $this->leveld,
            'content' => $this->content,
            'statuts' => $this->statuts,
            'iduser' => $this->iduser,
        ];

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
            title varchar(250) NULL,
            leveld int(11) NULL,
            content text COLLATE latin1_general_ci  NULL,
            statuts int(11) NULL,
            iduser int(11) NULL,
            created_at datetime COLLATE latin1_general_ci NULL,
            updated_at datetime COLLATE latin1_general_ci NULL,
            deleted_at datetime COLLATE latin1_general_ci NULL,
            PRIMARY KEY (id) )
            ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");
        return true;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getLeveld()
    {
        return $this->leveld;
    }

    /**
     * @param mixed $leveld
     */
    public function setLeveld($leveld)
    {
        $this->leveld = $leveld;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getStatuts()
    {
        return $this->statuts;
    }

    /**
     * @param mixed $statuts
     */
    public function setStatuts($statuts)
    {
        $this->statuts = $statuts;
    }

    /**
     * @return mixed
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }









}
