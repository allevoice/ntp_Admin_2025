<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;




class Mainclass
{


    protected $table;
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


    public function pdoconnect(){

        $host = $_ENV['MYSQL_HOST'] ?? 'localhost';
        $dbname = $_ENV['MYSQL_DBNAME'] ?? 'ntpsams_2025';
        $user = $_ENV['MYSQL_USER'] ?? 'root';
        $pwd = $_ENV['MYSQL_PWD'] ?? '';
        $utf= $_ENV['MYSQL_UTF'] ?? 'utf8';

        if(!isset($this->pdo)){
            $this->pdo = new \PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$utf, $user,$pwd);
            return $this->pdo;
        }else{
            return $this->pdo;
        }

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
        $header_message = "Form contact Message";

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
            $mail->Username   = 'rodney@dev23ntp.ntpsams.com';                     //SMTP Username Change
            $mail->Password   = '%irFVkNEqHKZa-nL';                               //SMTP password Change


            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Utiliser TLS (ou ENCRYPTION_SMTPS pour le port 465)
            $mail->Port       = 587;                                    // Port TLS/STARTTLS


            // Destinataires
            $mail->setFrom('no-reply@votre-site.com', $header_message);
            $mail->addAddress('rodney@dev23ntp.ntpsams.com', $header_message); // Ajouter un destinataire

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







}