<?php


namespace App\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\HttpFoundation\Session\Session;

class Mainmodel
{

    protected $table=null;
    protected $id;
    protected $pdo;
    protected $sql_queries;
    protected $search_term;



    protected function tableExists($table) {
        try {
            $result = $this->pdoconnect()->query("SELECT 1 FROM $table LIMIT 1");
        } catch (\Exception $e) {
            return FALSE;
        }
        return $result !== FALSE;
    }



    public function getLocaleFromSession()
    {
        $session = new Session();
        // Utilisez ->get() pour récupérer la valeur associée à la clé '_locale'
        $locale = $session->get('_locale');
        return $locale;
    }


    public function pdoconnect(){

        $host = $_ENV['MYSQL_HOST'] ?? 'localhost';
        $dbname = $_ENV['MYSQL_DBNAME'] ?? 'ntpsams_2025';
        $user = $_ENV['MYSQL_USER'] ?? 'root';
        $pwd = $_ENV['MYSQL_PWD'] ?? '';
        $utf= $_ENV['MYSQL_UTF'] ?? 'utf8';

        //dd($host,$dbname,$utf, $user,$pwd);


        if(!isset($this->pdo)){
            $this->pdo = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$utf, $user,$pwd);
            return $this->pdo;
        }else{
            return $this->pdo;
        }

    }



    public function getPaginatedItems(int $page, int $limit, string $searchTerm = NUll): array
    {
        $offset = ($page - 1) * $limit;
        $params = [];
        $whereClause = '';

        // 1. Définition de la clause WHERE pour la recherche (sans injection grâce à bindValue)
        if (!empty($searchTerm)) {
            $whereClause = " WHERE (title LIKE :search OR content LIKE :search OR created_at LIKE :search) ";
            $params[':search'] = '%' . $searchTerm . '%';
        }

        // --- 2. Requête pour le nombre total de résultats (avec filtre) ---
        $countSql = "SELECT COUNT(id) FROM {$this->table}" . $whereClause;
        $stmtCount = $this->pdoconnect()->prepare($countSql);

        // Bind le paramètre de recherche pour le COUNT
        if (!empty($searchTerm)) {
            $stmtCount->bindValue(':search', $params[':search']);
        }
        $stmtCount->execute();
        $totalResults = $stmtCount->fetchColumn();


        // --- 3. Requête pour les données de la page courante ---
        $dataSql = "SELECT * FROM {$this->table}"
            . $whereClause
            . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";

        $stmtData = $this->pdoconnect()->prepare($dataSql);

        // Bind le paramètre de recherche (si présent)
        if (!empty($searchTerm)) {
            $stmtData->bindValue(':search', $params[':search']);
        }

        // CORRECTION CRUCIALE : Indiquer explicitement que ce sont des ENTIERS
        $stmtData->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmtData->bindValue(':offset', $offset, \PDO::PARAM_INT); // 👈 C'est ici !

        $stmtData->execute();
        $items = $stmtData->fetchAll();

        // Retourne les deux ensembles de données pour le contrôleur/Twig
        return [
            'items' => $items,
            'total' => $totalResults,
        ];
    }






    public function insert() {
        // 1. Appel de la fonction pour obtenir les données brutes
        $raw_data = $this->valuesdata();

        if (empty($raw_data)) {
            error_log("Tentative d'insertion sans données. La fonction valuesdata() a retourné un tableau vide.");
            return false;
        }

        $set_placeholders = [];
        $data_to_bind = [];

        // 2. Construction de la requête SQL et du tableau de liaison (Binding)
        foreach ($raw_data as $column => $value) {
            // Construction du placeholder SQL: fullname = :fullname
            $set_placeholders[] = "$column = :$column";

            // Construction du tableau de liaison: [':fullname' => 'Alice']
            // C'est l'étape cruciale pour PDO!
            $data_to_bind[":$column"] = $value;
        }

        // 3. Construction de la requête SQL finale
        $set_clause = implode(', ', $set_placeholders);

        // Ajout de la colonne d'horodatage
        $sql = "INSERT INTO $this->table SET " . $set_clause . ", created_at = NOW()";

        // 4. Exécution de la requête préparée
        try {
            // Assurez-vous que $this->pdo est initialisé dans le constructeur!
            $stmt = $this->pdo->prepare($sql);

            // Exécution avec le tableau de liaison qui contient les deux-points (':')
            $success = $stmt->execute($data_to_bind);

            return $success;

        } catch (\PDOException $e) {
            // Gérer les erreurs (ex: violation NOT NULL)
            error_log("Erreur PDO lors de l'insertion : " . $e->getMessage());
            // Vous pouvez afficher l'erreur pour le débogage si nécessaire:
            // echo "Erreur PDO : " . $e->getMessage();
            return false;
        }
    }




    public function update(): bool {
        // 1. Appel de setValues pour obtenir les données (fullname, email, etc.)
        $raw_data = $this->valuesdata();

        // Vérification essentielle
        if (empty($raw_data) || $this->getId() === null) {
            error_log("Tentative de mise à jour sans données ou sans ID.");
            return false;
        }

        $set_placeholders = [];
        $data_to_bind = [];

        // 2. Construction de la requête SET et du tableau de liaison
        foreach ($raw_data as $column => $value) {
            // Ex: fullname = :fullname
            $set_placeholders[] = "$column = :$column";
            $data_to_bind[":$column"] = $value;
        }

        // 3. Ajout des marqueurs spécifiques à la mise à jour
        $set_clause = implode(', ', $set_placeholders);

        // Ajout de la mise à jour de l'horodatage et de la clause WHERE
        $sql = "UPDATE {$this->table} 
            SET " . $set_clause . ", updated_at = NOW() 
            WHERE id = :id";

        // 4. Ajouter l'ID à la liaison des données (très important pour la clause WHERE)
        $data_to_bind[":id"] = $this->getId();

        // 5. Exécution
        try {
            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute($data_to_bind);

            // Optionnel: vérifier si des lignes ont été affectées
            if ($success && $stmt->rowCount() === 0) {
                error_log("Mise à jour réussie mais aucune ligne affectée (ID inexistant?). ID: " . $this->getId());
            }

            return $success;

        } catch (\PDOException $e) {
            error_log("Erreur PDO lors de la mise à jour : " . $e->getMessage());
            return false;
        }
    }






    public function mail_info_send_no_attachment($mail_fullname,$mail_sender,$mail_subject,$message){
        $header_message = "Form contact Message ".$mail_fullname;

        $html_content = '
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>'.$header_message.'</title>
            </head>
            <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; background-color: #f4f4f4;">
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <table border="0" cellpadding="0" cellspacing="0" width="600" 
                            style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                <tr>
                                    <td align="center" style="padding: 30px 20px 20px 20px; background-color: #007bff; border-radius: 8px 8px 0 0;">
                                        <h1 style="color: #ffffff; margin: 0; font-size: 24px;">'.$header_message.'</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 40px 30px; color: #333333; font-size: 15px; line-height: 1.6;">
                                        <h2 style="color: #007bff; margin-top: 0;">'.$mail_subject.'</h2>
                                        <p>Message with **'.$mail_fullname.'**</p>
                                        <p>Message from the contact page of our website</p>
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%" style="border: 1px solid #eeeeee; margin: 20px 0; background-color: #f9f9f9;">
                                            
                                        
                                        <tr>
                                                <td width="30%" style="color: #555555; border-bottom: 1px solid #eeeeee;">
                                                <strong>Subject :</strong></td>
                                                <td width="70%" style="border-bottom: 1px solid #eeeeee;">'.$mail_subject.'</td>
                                            </tr> 
                                        <tr>
                                                <td width="30%" style="color: #555555; border-bottom: 1px solid #eeeeee;">
                                                <strong>Full name :</strong></td>
                                                <td width="70%" style="border-bottom: 1px solid #eeeeee;">'.$mail_fullname.'</td>
                                            </tr> 
                                        <tr>
                                                <td width="30%" style="color: #555555; border-bottom: 1px solid #eeeeee;">
                                                <strong>Mail Address :</strong></td>
                                                <td width="70%" style="border-bottom: 1px solid #eeeeee;">'.$mail_sender.'</td>
                                            </tr> 
                                        <tr>
                                                <td width="30%" style="color: #555555; border-bottom: 1px solid #eeeeee;">
                                                <strong>Message :</strong></td>
                                                <td width="70%" style="border-bottom: 1px solid #eeeeee;">'.$message.'</td>
                                            </tr> 
                                            


                                            <tr>
                                                <td style="color: #555555;"><strong>Date :</strong></td>
                                                <td>' . date('Y-m-d H:i:s') . '</td>
                                            </tr>
                                        </table>
                                        
                                    </td>
                                </tr>
                               
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>';


        $mail = new PHPMailer(true);


        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.ntpsams.com';                     //Set the SMTP server to send through Change
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contact_form@ntpsams.com';                     //SMTP Username Change
        $mail->Password   = 'S-Tgi?0r3.SJZ.4Z';                               //SMTP password Change


        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Utiliser TLS (ou ENCRYPTION_SMTPS pour le port 465)
        $mail->Port       = 587;                                    // Port TLS/STARTTLS


        // Destinataires
        $mail->setFrom('no-reply@votre-site.com', $header_message);
        $mail->addAddress('contact_form@ntpsams.com', $header_message); // Ajouter un destinataire

        // Contenu
        $mail->SMTPDebug = 0; // Définit le niveau de débogage à désactivé permet de masquer les information du serveur
        $mail->isHTML(true);                                        // Définir le format de l'e-mail à HTML
        $mail->CharSet = 'UTF-8';                                   // Gérer les accents
        $mail->Subject = $header_message;

        // Corps HTML
        $mail->Body    = $html_content;

        // Corps en Texte Brut (fallback pour les clients ne supportant pas HTML)
        $mail->AltBody = 'n\\\\'.$mail_fullname.'  n\\\\'.$mail_sender.'  n\\\\'.$mail_subject.'  n\\\\'.$message.'  n\\\\'.date('Y-m-d H:i:s').'  n\\\\';


        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }





    public function delsoft(){
        $stmt=$this->pdoconnect()->prepare("UPDATE ".$this->table." SET status_data=:statuts, deleted_at=:deleted_at WHERE id=:id_get ");
        $stmt->bindValue(':id_get',$this->getId());
        $stmt->bindValue(':statuts',NULL);
        $stmt->bindValue(':deleted_at',$this->today());
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delrestaure()
    {
        $stmt=$this->pdoconnect()->prepare("UPDATE ".$this->table." SET deleted_at=:deleted_at WHERE id=:id_get ");
        $stmt->bindValue(':id_get',$this->getId());
        $stmt->bindValue(':deleted_at',NULL);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deldefitly()
    {
        $stmt=$this->pdoconnect()->prepare("DELETE FROM ".$this->table." WHERE id=:id_get ");
        $stmt->bindValue(':id_get',$this->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }



    public function readfirstdata(){
        $stmt= $this->pdoconnect()->prepare("SELECT * FROM ".$this->table);
        $stmt->execute();
        return $stmt->fetch();
    }




    public function hashcmd($data, $action){
        //return (hash('sha224', $data));

        //$action = 'd';
        //$data = 'codeview';
        //$data = 'Z25jMzBwNFFSSjZmdm44VWM1dXYwdz09';
        //$secret_key = 'my_simple_secret_key';
        $secret_key = 'not_key_ntpsams_success';
        //$secret_iv = 'my_simple_secret_iv';
        $secret_iv = 'not_key_secret_ntpsams';


        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'c' ) {
            $output = base64_encode( openssl_encrypt( $data, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $data ), $encrypt_method, $key, 0, $iv );
        }

        return $output;

    }




    public function passwordcrypter($data){

        $output = hash_pbkdf2("sha256", $data, md5($data), '1000', 90);
        //$output = crypt($data, '$6$rounds=5000$usesomesillystringforsalt$');
        return $output;

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
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }



    /**
     * @return mixed
     */
    public function getSearchTerm()
    {
        return $this->search_term;
    }

    /**
     * @param mixed $search_term
     */
    public function setSearchTerm($search_term)
    {
        $this->search_term = $search_term;
    }






}
