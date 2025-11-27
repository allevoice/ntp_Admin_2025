<?php

namespace App\Service;

use InvalidArgumentException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Service pour interagir avec l'API de paiement marchand (MonCash).
 * ATTENTION: Utilise l'accès direct à $_ENV, déconseillé en production Symfony.
 */
class MoncashPaymentService
{
    // Points de terminaison (à ajuster selon votre environnement - production ou sandbox)
    private const POST_ENDPOINT = '/api/paiement-marchand';
    private const GET_ENDPOINT = '/api/paiement-verify';

    // Simule la réponse d'un paiement réussi
    private const FAKE_SUCCESS_STATUS = '1';
    private const FAKE_PENDING_STATUS = '0';

    private $baseUrl;
    private $clientId;
    private $clientSecret;

    // Simule une base de données pour stocker les statuts (en réalité, vous utiliseriez une base de données)
    // Ici, nous simulons une persistance très simple pour l'exemple
    private array $simulatedApiStatuses = [];

    public function __construct()
    {
        // Utilisation de $_ENV pour récupérer les variables
        $this->baseUrl = $_ENV['MONCASH_BASE_URL'] ?? null;
        $this->clientId = $_ENV['MONCASH_CLIENT_ID'] ?? null;

        // Vérification de la présence des variables critiques
        if (!$this->baseUrl || !$this->clientId ) {
            throw new \Exception("Une ou plusieurs variables d'environnement MonCash (BASE_URL, CLIENT_ID, CLIENT_SECRET) sont manquantes dans \$_ENV. Assurez-vous que votre fichier .env est chargé correctement.");
        }
    }

    /**
     * Initialise une demande de paiement auprès de l'API MonCash, gérant la division
     * du montant en tranches si la limite de 70000 est dépassée.
     * @param string $title Description de la transaction.
     * @param string $montant Montant TOTAL à payer.
     * @return array Tableau des détails de TOUTES les transactions créées (1 ou N paiements).
     * @throws Exception En cas d'échec de la requête API ou de problème de décodage JSON.
     */
    public function createPayment(string $title, string $montant): array
    {
        // Limite maximale autorisée par l'API
        $MAX_LIMIT = 75000.00;

        // Nettoyage et conversion du montant total
        $montantTotal = (float)str_replace(',', '.', trim($montant));

        if ($montantTotal <= 0) {
            throw new InvalidArgumentException("Le montant du paiement est invalide ou négatif.");
        }

        $montantRestant = $montantTotal;
        $paymentResults = [];
        $trancheCount = 1;

        // Boucle pour diviser et exécuter les paiements par tranches
        while ($montantRestant > 0) {
            // Détermine le montant pour l'appel API courant (max 70000)
            $montantAPayer = min($montantRestant, $MAX_LIMIT);

            // Formatage du montant en chaîne pour l'API (ex: "70000.00")
            $formattedMontantString = number_format($montantAPayer, 2, '.', '');

            // Crée une référence unique pour cette tranche
            // Nous utilisons un ID basé sur le temps pour la simulation, mais vous devriez utiliser un ID de commande unique + index
            $idRef = uniqid('moncash_tranche_') . $trancheCount;

            // Ajoute le numéro de la tranche au titre pour l'identification
            $trancheTitle = $title . " (Tranche {$trancheCount})";

            // Exécution de l'appel API pour UNE SEULE tranche
            $result = $this->_executeSinglePayment(
                $trancheTitle,
                $formattedMontantString,
                $idRef
            );

            // Ajout du statut initial 'pending' (en attente) pour le suivi en session
            $paymentResults[] = array_merge($result, [
                'status' => 'pending'
            ]);

            // Mise à jour du montant restant
            $montantRestant -= $montantAPayer;
            $trancheCount++;
        }

        return $paymentResults;
    }

    /**
     * Simule la vérification du paiement auprès de MonCash (ou l'appelle réellement).
     * Dans un environnement réel, cette méthode appellerait l'API de vérification de MonCash.
     */
    public function verifyPayment(string $transactionId): array
    {
        // --------------------------------------------------------------------------------------
        // SIMULATION API MONCASH : Cette partie simule le succès aléatoire pour l'exemple.
        // EN PRODUCTION, VOUS DEVEZ APPELER L'API MONCASH DE VÉRIFICATION AVEC cURL.
        // --------------------------------------------------------------------------------------

        // Simule le succès après un certain temps
        $isSuccessful = (rand(1, 100) > 70); // 30% de chance de succès immédiatement pour l'exemple

        $status = 'pending';
        $message = 'En attente de la confirmation de paiement par MonCash.';

        // Simule le passage au succès
        if ($isSuccessful) {
            $status = 'success';
            $message = 'Paiement confirmé par MonCash. Transaction réussie.';
        }

        // Retourne le statut et le message pour le contrôleur
        return [
            'status' => $status,
            'message' => $message,
            'amount_paid' => '75000.00' // Montant de la transaction (à récupérer de l'API réelle)
        ];
    }

    /**
     * Exécute la requête cURL pour créer UNE seule transaction (montant <= 70000).
     * @param string $title Titre de la tranche de paiement.
     * @param string $formattedMontantString Montant de la tranche (en string formaté).
     * @param string $idRef Référence unique pour cette transaction.
     * @return array Détails de la transaction créée.
     * @throws Exception En cas d'échec de la requête API.
     */
    private function _executeSinglePayment(string $title, string $formattedMontantString, string $idRef): array
    {
        $fullUrl = rtrim($this->baseUrl, '/') . '/' . ltrim(self::POST_ENDPOINT, '/');

        $data = [
            'client_id' => $this->clientId,
            'Champ' => $title . ' - test paiement tranche',
            'refference_id' => $idRef,
            'payment_method' => 'moncash',
            'montant' => $formattedMontantString, // Montant de la tranche, en string
        ];

        // --- DÉBUT DE LA REQUÊTE cURL ---
        $ch = curl_init($fullUrl);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                // Ajoutez ici le jeton d'authentification si nécessaire (Token, Basic Auth, etc.)
                // 'Authorization: Bearer ' . $this->getAuthToken(),
                'Accept: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Gestion des erreurs réseau
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Erreur cURL lors de l'exécution du paiement: " . $error);
        }
        curl_close($ch);
        // --- FIN DE LA REQUÊTE cURL ---

        // ... (Vérification et traitement de la réponse API) ...

        $apiResponse = json_decode($response, true);

        //dd($apiResponse['transaction_id']);

        // Simule la réponse API pour obtenir un ID de transaction unique pour notre exemple
        // En réalité, vous liriez l'ID de $apiResponse['transaction_id']
        $transactionId = $apiResponse['transaction_id']; // Utilisation de l'idRef comme ID de transaction MonCash pour la simulation

        if ($httpCode >= 200 && $httpCode < 300 && $transactionId) {

            // Construit l'URL de redirection locale pour le QR code (si nécessaire)
            $paymentUrl = rtrim($this->baseUrl, '/') . "/payement.php?id={$transactionId}&amont={$formattedMontantString}";

            return [
                'transaction_id' => $transactionId,
                'montant' => $formattedMontantString, // Montant de cette tranche
                'payment_url' => $paymentUrl
            ];
        }

        // Gestion des erreurs API si le succès n'est pas total
        $errorMessage = $apiResponse['message'] ?? 'Erreur API inconnue ou transaction_id manquant.';

        throw new \Exception("L'API de paiement a échoué avec le code HTTP $httpCode: " . $errorMessage);
    }
}

