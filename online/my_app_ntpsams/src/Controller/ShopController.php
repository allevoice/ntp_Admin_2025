<?php

namespace App\Controller;

use App\Model\Shopmodel;
use App\Service\SquareApiService;

use ContainerCLOiOAx\getDebug_ErrorHandlerConfiguratorService;
use Square\SquareClient;
use Square\Types\CreateOrderRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;





#[Route('/{_locale}', requirements: ['_locale' => '%app.locales%'],name: 'app_shop_')]
class ShopController extends AbstractController
{
    private function getPriceText(array $itemData, array $variations): string
    {




        if (!empty($itemData['variations'])) {
            $varId = $itemData['variations'][0]['id'] ?? null;
            if ($varId && isset($variations[$varId]['price_money']['amount'])) {
                $amt = $variations[$varId]['price_money']['amount'];
                $cur = $variations[$varId]['price_money']['currency'] ?? "USD";
                return number_format($amt / 100, 2) . " $cur";
            }
        }



        return "";
    }




    #[Route('/shop', name: 'liste')]
    public function index(Request $request, SquareApiService $squareApi, SessionInterface $session): Response
    {

        // 1. Récupérer et organiser les données de l'API
        try {
            $apiData = $squareApi->getCatalog();
        } catch (\Exception $e) {
            return $this->render('error.html.twig', ['error' => $e->getMessage()]);
        }

        $objects = $apiData['objects'] ?? [];
        $categories = [];
        $images = [];
        $variations = [];
        $items = [];

        foreach ($objects as $obj) {
            $type = $obj['type'] ?? '';
            $id = $obj['id'] ?? '';
            if ($type === 'CATEGORY') {
                $categories[$id] = $obj['category_data']['name'] ?? "Sans nom";
            } elseif ($type === 'IMAGE') {
                $images[$id] = $obj['image_data']['url'] ?? null;
            } elseif ($type === 'ITEM_VARIATION') {
                $variations[$id] = $obj['item_variation_data'] ?? [];
            } elseif ($type === 'ITEM') {
                $items[] = $obj;
            }
        }

        // 2. Gestion du panier
        $selectedCat = $request->query->get('cat');
        $cart = $session->get('cart', []);

        if ($request->query->has('add')) {
            $prodId = $request->query->get('add');
            $foundItem = null;
            foreach ($items as $item) {
                if ($item['id'] === $prodId) {
                    $foundItem = $item;
                    break;
                }
            }

            if ($foundItem) {
                $variationId = $foundItem['item_data']['variations'][0]['id'] ?? null;
                if ($variationId) {
                    $name = $foundItem['item_data']['name'] ?? 'Unknown name';
                    $price = $foundItem['item_data']['variations'][0]['item_variation_data']['price_money']['amount'] / 100 ?? 0;

                    if (!isset($cart[$variationId])) {
                        $cart[$variationId] = [
                            'id' => $variationId,
                            'name' => $name,
                            'price' => $price,
                            'qty' => 0
                        ];
                    }
                    $cart[$variationId]['qty'] += 1;
                    $session->set('cart', $cart);
                }
            }
            return $this->redirectToRoute('app_shop_liste', ['cat' => $selectedCat]);
        }

        if ($request->query->has('remove')) {
            $id = $request->query->get('remove');
            unset($cart[$id]);
            $session->set('cart', $cart);
            return $this->redirectToRoute('app_shop_liste', ['cat' => $selectedCat]);
        }

      // 3. Préparer les données pour la vue Twig
        // Boucle avec une référence pour ajouter les clés 'img_url' et 'price_text'
        foreach ($items as &$item) {
            $itemData = $item['item_data'] ?? [];
            $imgIds = $itemData['image_ids'] ?? [];

            $item['img_url'] = !empty($imgIds) && isset($images[$imgIds[0]]) ? $images[$imgIds[0]] : null;
            $item['price_text'] = $this->getPriceText($itemData, $variations);
        }
        unset($item); // Important: Déréférence la variable pour éviter les effets de bord









        $categoryCounts = [];
        foreach ($items as $item) {
            $categoryId = $item['item_data']['categories'][0]['id'] ?? null;
            if ($categoryId && isset($categories[$categoryId])) {
                $categoryCounts[$categoryId] = ($categoryCounts[$categoryId] ?? 0) + 1;
            }
        }





       // dd($items);






        // 5. Rendu de la vue avec les données
        return $this->render('shop/index.html.twig', [
            'title_page' => "Shop",
            'categories' => $categories,
            'categoryCounts' => $categoryCounts,
            'items' => $items,
            'selectedCat' => $selectedCat,
            'cart' => $cart,
        ]);
    }








    #[Route('/product/{id}', name: 'product_details')]
    public function details(string $id, SquareApiService $squareApi): Response
    {
        // 1. Appel à l'API pour un objet de catalogue spécifique
        try {
            $response = $squareApi->retrieveCatalogObject_details($id, ['include_related_objects' => true]);
            $productData = $response['object'] ?? null;
            $relatedObjects = $response['related_objects'] ?? [];

            // Vérifier si le produit est valide
            if (!$productData || ($productData['type'] !== 'ITEM')) {
                throw new \Exception("Product not found or invalid.");
            }

        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_shop');
        }






        // 2. Organiser les données (images, variations, catégories)
        $images = [];
        $variations = [];
        $categories = [];

        foreach ($relatedObjects as $obj) {
            if ($obj['type'] === 'IMAGE') {
                $images[$obj['id']] = $obj['image_data']['url'] ?? null;
            } elseif ($obj['type'] === 'ITEM_VARIATION') {
                $variations[$obj['id']] = $obj['item_variation_data'] ?? [];
            } elseif ($obj['type'] === 'CATEGORY') {
                $categories[$obj['id']] = $obj['category_data']['name'] ?? "Empty name";
            }
        }

        // 3. Préparer les images pour la vue
        $productImageIds = $productData['item_data']['image_ids'] ?? [];
        $allProductImages = [];
        $mainImageUrl = 'https://via.placeholder.com/600x400?text=Image+non+disponible'; // URL d'image par défaut

        if (!empty($productImageIds)) {
            // L'image principale est la première de la liste
            $mainImageId = $productImageIds[0];
            if (isset($images[$mainImageId])) {
                $mainImageUrl = $images[$mainImageId];
            }

            // Récupérer toutes les URLs pour la galerie
            foreach ($productImageIds as $imgId) {
                if (isset($images[$imgId])) {
                    $allProductImages[] = $images[$imgId];
                }
            }
        }


        // Cas 2 : Si le tableau de variations est vide, le peupler avec les variations intégrées
        if (empty($variations) && isset($productData['item_data']['variations'])) {
            foreach ($productData['item_data']['variations'] as $embeddedVariation) {
                $variations[$embeddedVariation['id']] = $embeddedVariation['item_variation_data'];
            }
        }


        // 4. Préparer les autres données pour la vue
        $priceText = $this->getPriceText($productData['item_data'], $variations);


        // Récupérer la description et la stocker dans une nouvelle variable
        $descriptionHtml = $productData['item_data']['description_html'] ?? null;





        // 5. Rendre la vue avec toutes les données préparées
        return $this->render('shop/details.html.twig', [
            'title_page' =>"Shop detail",
            'product' => $productData,
            'mainImageUrl' => $mainImageUrl,
            'allProductImages' => $allProductImages,
            'priceText' => $priceText,
            'categories' => $categories,
            'descriptionHtml' => $descriptionHtml, // Nouvelle variable
        ]);
    }



    #[Route('/card', name: 'card_liste')]
    private function getCart(SessionInterface $session): array
    {
        // Retourne le tableau 'cart' de la session, ou un tableau vide s'il n'existe pas.
        return $session->get('cart', []);
    }


    private function calculateTotals(array $cartItems): array
    {
        $totalPrice = 0;
        $totalItems = 0;

        foreach ($cartItems as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $totalPrice += $subtotal;
            $totalItems += $item['qty'];
        }

        return [
            'total_price' => $totalPrice,
            'total_items' => $totalItems,
        ];
    }



// --------------------------------------------------------------------------



    #[Route('/card', name: 'card_liste')]
    public function panier(SessionInterface $session): Response
    {
        $cart = $this->getCart($session);
        $totals = $this->calculateTotals($cart);
        $squareCurrency = $this->getParameter('app.square_currency');
        return $this->render('shop/panier.html.twig', [
            'title_page' =>"Shop detail",
            'cart_items' => $cart,
            'total_price' => $totals['total_price'],
            'currency' => $squareCurrency,
        ]);
    }


    #[Route('/card/del/{id}', name: 'card_del')]
    public function removeCartItem(string $id, SessionInterface $session): Response
    {
        $cart = $this->getCart($session);

        // 1. Suppression de l'article
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);

            $this->addFlash('success', 'Item removed from cart.');
        }

        // 2. Redirection vers la page d'affichage du panier
        return $this->redirectToRoute('app_shop_card_liste');
    }




    #[Route('/card/update', name: 'card_update')]
    public function updateCart(Request $request, SessionInterface $session): Response
    {
        $cart = $this->getCart($session);

        // 1. Récupération des données POST brutes (toutes les données de l'envoi du formulaire)
        $postData = $request->request->all();

        // 2. Accéder à la clé 'qty' dans le tableau POST, en s'assurant qu'elle est un tableau vide si elle n'existe pas.
        // Cela évite l'erreur de "non-scalar value".
        $qtyData = $postData['qty'] ?? [];

        $updated = false;

        // Boucle sur les quantités soumises
        foreach ($qtyData as $id => $qty) {
            $qty = (int) $qty;

            if (isset($cart[$id])) {
                if ($qty > 0) {
                    // Mettre à jour la quantité
                    $cart[$id]['qty'] = $qty;
                    $updated = true;
                } else {
                    // Supprimer si la quantité est 0 ou moins
                    unset($cart[$id]);
                    $updated = true;
                }
            }
        }

        // Mettre à jour la session
        $session->set('cart', $cart);

        // Ajouter un message flash
        if ($updated) {
            $this->addFlash('success', 'Your cart has been updated.');
        } else {
            $this->addFlash('warning', 'No relevant changes made.');
        }

        // Rediriger vers la page du panier
        return $this->redirectToRoute('app_shop_card_liste');
    }




    private function calculateTotals_check(array $cartItems, string $currency): array
    {
        $subTotal = 0; // Prix total hors-taxe
        foreach ($cartItems as $item) {
            $subTotal += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
        }

        // Le montant final est égal au sous-total ici.
        // Square gérera l'ajout de la taxe plus tard.
        $totalPrice = $subTotal;

        return [
            'sub_total' => $subTotal,
            'tax_amount' => 0.00, // On met 0 ou on omet, mais on garde total_price = sub_total
            'total_price' => $totalPrice,
            'currency' => $currency,
        ];


    }


    #[Route('/card/checkout', name: 'checkout')]
    public function checkout(Request $request,SessionInterface $session, SquareApiService $squareApiService): Response {
        // 1. Récupération des paramètres
        $squareCurrency = $this->getParameter('app.square_currency');
        $squareApplicationId = $this->getParameter('app.square_application_id');
        $squareLocationId = $this->getParameter('app.square_location_id');
        $squareTaxId = $this->getParameter('app.square_tax_id'); // L'ID de taxe configuré

        $cartItems = $session->get('cart', []);

        if (empty($cartItems)) {
            $this->addFlash('warning', 'Your cart is empty. Add items to check out.');
            return $this->redirectToRoute('app_shop_liste');
        }

        // 2. Calcul du sous-total (HT)
        $subtotalPrice = 0;
        foreach ($cartItems as $prod) {
            $subtotalPrice += ($prod['price'] ?? 0) * ($prod['qty'] ?? 0);
        }



        // 3. Récupération du taux de taxe via le service SquareApiService
        $taxRate = $squareApiService->getTaxRateByTaxId($squareTaxId);

        // 4. Calcul du montant final (TTC)
        $taxAmount = round($subtotalPrice * $taxRate, 2); // Arrondi à 2 décimales
        $totalPrice = $subtotalPrice + $taxAmount;

        // 5. Consolidation des totaux pour le template
        $totals = [
            'sub_total' => $subtotalPrice,
            'tax_amount' => $taxAmount,
            'total_price' => $totalPrice,
            'currency' => $squareCurrency,
        ];

        return $this->render('shop/checkout.html.twig', [
            'title_page' => 'Checkout',
            'cart_items' => $cartItems,
            'current' => $squareCurrency,
            'tax_value' => $taxRate,
            'totals' => $totals,
            'square_app_id' => $squareApplicationId,
            'square_location_id' => $squareLocationId,
        ]);
    }



    #[Route('/process-payment', name: 'payment_process', methods: ['POST'])]
    public function processSquarePayment(Request $request,SessionInterface $session,SquareApiService $squareApiService,Shopmodel $shompmodel
    ): JsonResponse
    {
        // 1. Récupération des données d'entrée et de la configuration
        $data = json_decode($request->getContent(), true);
        $nonce = $data['nonce'] ?? null;
        $customerInfo = $data['customer'] ?? [];
        $cartItems = $data['cart'] ?? [];

        if (!$nonce || empty($cartItems)) {
            return new JsonResponse(['success' => false, 'error' => 'Token or cart invalid.'], 400);
        }

        $squareCurrency = $this->getParameter('app.square_currency');
        $squareLocationId = $this->getParameter('app.square_location_id');

        // --- 2. Récupération du catalogue et calcul des totaux (Logique de sécurité) ---
        try {
            $catalogData = $squareApiService->getFullCatalogForCalculation();
        } catch (\Exception $e) {
            // Gérer l'échec de l'API Catalogue
            return new JsonResponse(['success' => false, 'error' => 'Error during catalog verification. Code: ' . $e->getMessage()], 500);
        }

        // Organisation des données du catalogue (comme dans l'ancien script)
        $variationDetails = [];
        $itemDetails = [];
        $taxDetails = [];
        foreach ($catalogData['objects'] ?? [] as $obj) {
            if ($obj['type'] === 'ITEM_VARIATION') {
                $variationDetails[$obj['id']] = $obj['item_variation_data'];
            } elseif ($obj['type'] === 'ITEM') {
                $itemDetails[$obj['id']] = $obj['item_data'];
            } elseif ($obj['type'] === 'TAX') {
                $taxDetails[$obj['id']] = $obj['tax_data'];
            }
        }

        $subtotalPriceCents = 0;
        $taxAmountCents = 0;
        $itemsToSave = [];

        // Calcul des totaux en centimes
        foreach ($cartItems as $item) {
            $variationId = $item['id'];
            $itemQty = $item['qty'];
            $variation = $variationDetails[$variationId] ?? null;

            if (!$variation) {
                // Gérer un article non trouvé dans le catalogue Square (sécurité)
                return new JsonResponse(['success' => false, 'error' => 'Cart item not found in System catalog.'], 400);
            }

            $itemPriceCents = $variation['price_money']['amount'] ?? 0;
            $subtotalPriceCents += $itemPriceCents * $itemQty;

            $itemParentId = $variation['item_id'] ?? null;
            $itemTaxIds = $itemDetails[$itemParentId]['tax_ids'] ?? [];
            $appliedTaxes = [];

            // Calcul de la taxe par article (comme dans l'ancien script)
            foreach ($itemTaxIds as $taxId) {
                if (isset($taxDetails[$taxId])) {
                    $taxRate = floatval($taxDetails[$taxId]['percentage']) / 100;
                    $taxCentsForItem = (int) round($itemPriceCents * $taxRate);
                    $taxAmountCents += $taxCentsForItem * $itemQty;

                    $appliedTaxes[] = [
                        'name' => $taxDetails[$taxId]['name'],
                        'rate' => $taxRate,
                        'amount_cents' => $taxCentsForItem
                    ];
                }
            }

            $itemsToSave[] = [
                'name' => $itemDetails[$itemParentId]['name'] ?? 'Unknown item',
                'qty' => $itemQty,
                'price_cents' => $itemPriceCents,
                'taxes' => $appliedTaxes
            ];
        }

        $totalPriceCents = $subtotalPriceCents + $taxAmountCents;
        $finalTaxRate = ($subtotalPriceCents > 0) ? $taxAmountCents / $subtotalPriceCents : 0.0;

        // --- 3. Exécution du paiement via SquareApiService ---
        $paymentResult = $squareApiService->createPayment(
            $nonce,
            $totalPriceCents,
            $squareCurrency,
            $squareLocationId,
            $customerInfo
        );

        if (!$paymentResult['success']) {
            return new JsonResponse(['success' => false, 'error' => $paymentResult['error']], 400);
        }

        $paymentId = $paymentResult['payment_id'];
        $redirectUrl = $this->generateUrl('app_shop_confirmation', ['payment_id' => $paymentId]);



        // --- 4. Sauvegarde de la commande et nettoyage ---
        try {

            //insertion dans la base de donneee
            $dataToInsert = [
                'payment_id' => $paymentId,
                'client_info' => json_encode($customerInfo),
                'articles' => json_encode($itemsToSave),
                'date_creation' => (new \DateTime())->format('Y-m-d H:i:s'),
                'payment_method' => 'square',
                'tax_rate' => $finalTaxRate
            ];
            $shompmodel->setDatacommande($dataToInsert);
            $shompmodel->insertshop();


            // Si la sauvegarde réussit, vider le panier
            $session->remove('cart');

            return new JsonResponse(['success' => true, 'payment_id' => $paymentId, 'redirect_url' => $redirectUrl]);

        } catch (\Exception $e) {
            // Le paiement a réussi, mais la sauvegarde a échoué.
            error_log("DB Error for payment #{$paymentId}: " . $e->getMessage());
            return new JsonResponse([
                'success' => true,
                'payment_id' => $paymentId,
                'warning' => 'Payment successful but order saving failed.',
                'redirect_url' => $redirectUrl // Rediriger quand même pour ne pas bloquer l'utilisateur
            ]);
        }
    }



    #[Route('/confirmation/{payment_id}', name: 'confirmation', methods: ['GET'])]
    public function orderConfirmation(string $payment_id, Shopmodel $shompmodel): Response
    {
        // 1. Fetch the order details from the database using the payment ID
        try {
            //Récupération des données (une seule ligne attendue)
            $shompmodel->setPaymentId($payment_id);
            $order = $shompmodel->successreader();
        } catch (\Exception $e) {
            // Log the error and handle the case where the order isn't found
            throw $this->createNotFoundException('Order not found or database error.');
        }





        $order['client_info'] = json_decode($order['client_info'], true);
        $order['articles'] = json_decode($order['articles'], true);
        $currence_form = $order['client_info']['current_key'];




// 2. Render the confirmation template
        return $this->render('shop/confirmation.html.twig', [
            'title_page' => 'Success',
            'order' => $order, // <--- YOUR PRIMARY VARIABLE
            'payment_id' => $payment_id,
            'currence_form' => $currence_form,

            // 💡 Add the required transaction_details key for the Twig template if needed
            // The Twig error suggests you are using code intended for the invoice page here.
            'transaction_details' => [
                'payment_id' => $payment_id,
                'tax_rate' => $order['tax_rate'],
                // Add any other keys the confirmation template might use
            ]
        ]);

    }


    #[Route('/invoice/{paymentId}', name: 'invoice', methods: ['GET'])]
    public function generateInvoice(string $paymentId, Shopmodel $shompmodel): Response
    {
        try {

            $shompmodel->setPaymentId($paymentId);
            $transactionRow = $shompmodel->successreader();

        } catch (\Exception $e) {
            error_log("Database error fetching invoice: " . $e->getMessage());
            throw new NotFoundHttpException("Database error while retrieving the invoice");
        }

        if (!$transactionRow) {
            throw new NotFoundHttpException("Invoice not found for payment ID: " . $paymentId);
        }

        // 2. Décodage des données JSON (utilisant les clés réelles de la BDD : client_info, articles)
        $clientInfo = json_decode($transactionRow['client_info'], true);
        $articles = json_decode($transactionRow['articles'], true);


        $currencyCode = $clientInfo['current_key'] ?? 'USD'; // Utiliser 'EUR' comme valeur par défaut sécurisée



        // 3. Structure des données pour le template Twig
        $invoiceData = [
            'order_details' => [
                'client_info' => $clientInfo,
                'items' => $articles,
            ],
            'transaction_details' => [
                'created_at' => $transactionRow['date_creation'],
                'status' => 'COMPLETED',
                'payment_method' => $transactionRow['payment_method'],
                'payment_id' => $transactionRow['payment_id'],
                'tax_rate' => (float)$transactionRow['tax_rate'] // Assurer que c'est un float pour les calculs
            ],
            'payment_id' => $paymentId, // Utile pour le titre
            'currency' => $currencyCode,
        ];

        // 4. Rendu du template
        return $this->render('shop/invoice.html.twig',$invoiceData);

    }


    #[Route('/shop/liste', name: 'liste_invoice')]
    public function listInvoices(Shopmodel $shopmodel): Response
    {

        $data = $shopmodel->readAll();

        // Rendu du template Twig
        return $this->render('admin/shop/invoices_list.html.twig', [
            'invoices' => $data,
        ]);
    }



    #[Route('/shop/booking/{id}', name: 'redirect_link_extern')]
    public function booking_link(string $id,Request $request): Response
    {
		
		// 1. Définir l'URL de base de Square
        $base_url = 'https://book.squareup.com/appointments/7jwdcckk8siagh/location/LGJ2PB5YW3M0K/services/'.$id;
		return $this->redirect($base_url);
    }



}
