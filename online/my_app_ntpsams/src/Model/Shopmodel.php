<?php


namespace App\Model;


class Shopmodel extends Mainmodel
{

    protected $table="cardpanier";
    private $datacommande;
    private $payment_id;



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



    public function moncash_taxt(){
        return '200';
    }

    public function devis_htg(){
        return '140';
    }



    private function tablecreate(){
        //dd('Table');
        $this->pdoconnect()->exec("CREATE TABLE IF NOT EXISTS ".$this->table." (
            id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
            payment_id VARCHAR(255) NOT NULL UNIQUE,
            payment_method VARCHAR(100) NULL,
            tax_rate VARCHAR(100) NULL,
            client_info_json text COLLATE latin1_general_ci  NULL,
            articles_json text COLLATE latin1_general_ci  NULL,
            date_creation datetime COLLATE latin1_general_ci NULL,
            updated_at datetime COLLATE latin1_general_ci NULL,
            deleted_at datetime COLLATE latin1_general_ci NULL,
            PRIMARY KEY (id) )
            ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;");
        return true;
    }






    public function successreader(){
        $stmt = $this->pdoconnect()->prepare("SELECT * FROM ".$this->table." WHERE payment_id = :payment_id");
        $stmt->execute([':payment_id' => $this->payment_id]);
        return $stmt->fetch();
    }




    public function readAll(){
        $stmt = $this->pdoconnect()->prepare("SELECT * FROM ".$this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }




    public function insertshop(): bool
    {
        $data = $this->datacommande;
        // Utilisation de la construction dynamique (plus fiable si $data change)
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO ".$this->table."  ({$columns}) VALUES ({$placeholders})";
        try {
            $stmt = $this->pdoconnect()->prepare($sql);
            return $stmt->execute($data);
        } catch (\PDOException $e) {
            error_log("SQL INSERT Error: " . $e->getMessage());
            return false;
        }

    }

    /**
     * @return mixed
     */
    public function getDatacommande()
    {
        return $this->datacommande;
    }

    /**
     * @param mixed $datacommande
     */
    public function setDatacommande($datacommande)
    {
        $this->datacommande = $datacommande;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * @param mixed $payment_id
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }









}
