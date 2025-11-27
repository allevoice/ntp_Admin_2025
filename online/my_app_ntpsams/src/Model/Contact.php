<?php


namespace App\Model;


class Contact extends Mainmodel
{


    protected   $table = "contact_template";
    protected   $id;
    protected   $fullname;
    protected   $email;
    protected   $subject;



    protected   $leveld;
    protected   $content;
    protected   $statuts;
    protected   $iduser;
    protected   $created_at;
    protected   $updated_at;
    protected   $deleted_at;



    public function valuesdata(){
        return [
            'fullname' => $this->fullname, // OK si NULL
            'email' => $this->email,       // 🛑 DOIT être une chaîne non-NULL
            'content' => $this->content,   // OK si NULL
            'subject' => $this->subject
        ];
    }


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
            fullname varchar(250) NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            content text COLLATE latin1_general_ci  NULL,
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
