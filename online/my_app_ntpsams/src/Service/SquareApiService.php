<?php

namespace App\Service;

use Square\Legacy\Models\Money;
use Square\Legacy\SquareClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SquareApiService
{
    private HttpClientInterface $client;
    private  $accessToken;
    private  $useSandbox;

    public function __construct(ParameterBagInterface $params)
    {
        $this->accessToken = $params->get('app.square_access_token');
        $this->useSandbox = $params->get('app.square_use_sandbox');


        $baseUrl = $this->useSandbox
            ? "https://connect.squareupsandbox.com/v2/"
            : "https://connect.squareup.com/v2/";

        $this->client = HttpClient::createForBaseUri($baseUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Square-Version' => '2024-04-18', // Bonne pratique d'inclure la version
            ],
        ]);
    }

    public function getCatalog(): array
    {
        try {
            $response = $this->client->request('GET', 'catalog/list', [
                'query' => [
                    'types' => 'ITEM,ITEM_VARIATION,IMAGE,CATEGORY,TAX'
                ]
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode >= 400) {
                // Gérer les erreurs de l'API avec une exception
                throw new \Exception("API ERROR (HTTP $statusCode) : " . $response->getContent(false));
            }

            return $response->toArray();
        } catch (\Exception $e) {
            // Loguer l'erreur ou la gérer autrement
            // Par simplicité ici, on la renvoie
            throw $e;
        }
    }



    public function retrieveCatalogObject(string $objectId, array $options = []): array
    {
        try {
            $response = $this->client->request('GET', 'catalog/list', [
                'query' => [
                    'types' => 'TAX'
                ]
            ]);


            $statusCode = $response->getStatusCode();


            if ($statusCode >= 400) {
                throw new \Exception("API ERROR (HTTP $statusCode) : " . $response->getContent(false));
            }

            return $response->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }


    public function retrieveCatalogObject_details(string $objectId, array $options = []): array
    {
        try {
            $response = $this->client->request('GET', "catalog/object/$objectId", [
                'query' => $options
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode >= 400) {
                throw new \Exception("API ERROR (HTTP $statusCode) : " . $response->getContent(false));
            }

            return $response->toArray();
        } catch (\Exception $e) {
            throw $e;
        }
    }




    public function getTaxRateByTaxId(string $taxId): float
    {

        if (empty($taxId)) {
            return 0.0;
        }


        //travailler code trabvailler
        $catalogObjectResponse = $this->retrieveCatalogObject($taxId);
        foreach ($catalogObjectResponse['objects'] as $key){
            $percentageString= $key['tax_data']['percentage'];
            return floatval($percentageString) / 100;
        }



        /*try {
            // Appelle la route catalog/object/{id} qui retourne {'object': {...}}
           $catalogObjectResponse = $this->retrieveCatalogObject($taxId);

            // ⚠️ La cible est $catalogObjectResponse['object']
            $taxObject = $catalogObjectResponse['objects'] ?? null;

            if ($taxObject
                && $taxObject['type'] === 'TAX'
                && isset($taxObject['tax_data']['percentage']))
            {
                $percentageString = $taxObject['tax_data']['percentage'];

                // L'API renvoie "7.0". floatval("7.0") = 7.0. / 100 = 0.07.
                return floatval($percentageString) / 100;
            }

            return 0.0;

        } catch (\Exception $e) {
            // Gère le 404/Erreur API en retournant 0.0
            error_log("Square Tax API Error for ID '{$taxId}': " . $e->getMessage());
            return 0.0;
        }*/

    }



    public function getFullCatalogForCalculation(): array
    {
        try {
            // Utilise la route catalog/list pour récupérer les données nécessaires en une seule fois
            $response = $this->client->request('GET', 'catalog/list', [
                'query' => [
                    'types' => 'ITEM,ITEM_VARIATION,TAX' // Types dont vous avez besoin
                ]
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode >= 400) {
                $content = $response->getContent(false);
                $errorDetails = json_decode($content, true)['errors'][0]['detail'] ?? 'Detail not specified';

                throw new \Exception("API ERROR (HTTP $statusCode) in the catalog: " . $errorDetails);
            }

            return $response->toArray();

        } catch (\Exception $e) {
            // Journalisez l'erreur
            throw $e;
        }
    }



    /**
     * Sends the payment request to Square's Payments API using HttpClient.
     * * @param string $nonce Token de carte (source_id) généré par le frontend Square.
     * @param int $amountCents Montant total TTC en centimes.
     * @param string $currency Devise (ex: 'EUR').
     * @param string $locationId ID de l'emplacement Square pour le paiement.
     * @param array $customerData Détails du client (email, adresse).
     * @return array Résultat du paiement : ['success' => bool, 'payment_id' => string|null, 'error' => string|null]
     */
    public function createPayment(
        string $nonce,
        int $amountCents,
        string $currency,
        string $locationId,
        array $customerData
    ): array
    {
        // Construction du corps de la requête (payload)
        $body = [
            // Clé d'idempotence pour prévenir les doubles paiements
            "idempotency_key" => uniqid(),
            "source_id" => $nonce,
            "location_id" => $locationId,

            "amount_money" => [
                "amount" => $amountCents,
                "currency" => $currency
            ],

            "autocomplete" => true,
            "buyer_email_address" => $customerData['customer_email'] ?? null,

            "billing_address"     => [
                "address_line_1" => $customer_address ?? null,
                "country"        => $customer_country ?? null
            ],

            "shipping_address"    => [
                "address_line_1" => $customer_address ?? null,
                "country"        => $customer_country ?? null
            ],

            "note" => "Order processed to API." ?? null,
        ];



        // Ajout des adresses si les données sont présentes
        if (!empty($customerData['customer_address'])) {
            $address = [
                "address_line_1" => $customerData['customer_address'],
                "country" => $customerData['customer_country'] ?? 'US' // Utilisez un défaut si non fourni
            ];
            $body["billing_address"] = $address;
            $body["shipping_address"] = $address;
        }

        try {
            $response = $this->client->request('POST', 'payments', [
                // HttpClient sérialise automatiquement le tableau $body en JSON
                'json' => $body
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = $response->toArray(false);

            if ($statusCode >= 400 || !isset($responseData['payment'])) {
                // Le paiement a échoué (carte refusée, données invalides, etc.)
                $errorDetails = $responseData['errors'][0]['detail'] ?? 'Unspecified API Error.';

                // Loguer l'erreur pour le débogage serveur
                error_log("System Payment failed (HTTP $statusCode): " . $errorDetails);

                return ['success' => false, 'error' => $errorDetails];
            }

            // Paiement réussi
            return ['success' => true, 'payment_id' => $responseData['payment']['id']];

        } catch (\Exception $e) {
            // Erreur de connexion ou autre exception imprévue
            error_log("Payment Request Exception: " . $e->getMessage());
            return ['success' => false, 'error' => 'Payment Service Connection Error.'];
        }
    }

}
