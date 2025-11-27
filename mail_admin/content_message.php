
<?php
// Ajoutez plus d'éléments (au moins 15-20) pour tester correctement la pagination
$mails = [
    [
        'sender' => 'Support Technique',
        'subject' => 'Problème de connexion après la mise à jour.',
        'preview' => 'Nous avons identifié un bug critique sur le module d\'authentification...',
        'time' => '10:30 AM',
        'is_read' => false,
        'id' => 1
    ],
    [
        'sender' => 'Marketing & Co',
        'subject' => 'Nouvelle offre spéciale pour le Black Friday.',
        'preview' => 'Salut ! Nous préparons notre plus grande vente de l\'année et voulions...',
        'time' => 'Hier',
        'is_read' => true,
        'id' => 2
    ],
    [
        'sender' => 'Comptabilité',
        'subject' => 'Facture en retard [URGENT].',
        'preview' => 'Veuillez procéder au règlement de la facture A409 avant la fin du mois.',
        'time' => '11:00 AM',
        'is_read' => false,
        'id' => 3
    ],
    [
        'sender' => 'Support Technique',
        'subject' => 'Demande d\'assistance #1234.',
        'preview' => 'J\'ai un souci avec l\'export des données en format CSV.',
        'time' => '14:45 PM',
        'is_read' => true,
        'id' => 4
    ],
    [
        'sender' => 'Projets',
        'subject' => 'Mise à jour du calendrier de déploiement.',
        'preview' => 'Le jalon 3 est reporté à la semaine prochaine en raison d\'un blocage sur le serveur.',
        'time' => '15:15 PM',
        'is_read' => false,
        'id' => 5
    ],
    [
        'sender' => 'Marketing & Co',
        'subject' => 'Statistiques de la campagne d\'emails.',
        'preview' => 'Le taux d\'ouverture a atteint 45%, ce qui est un excellent résultat !',
        'time' => '16:00 PM',
        'is_read' => false,
        'id' => 6
    ],
    [
        'sender' => 'Ressources Humaines',
        'subject' => 'Rappel : Entretien annuel d\'évaluation.',
        'preview' => 'N\'oubliez pas de remplir votre grille d\'auto-évaluation avant mercredi.',
        'time' => 'Mardi',
        'is_read' => false,
        'id' => 7
    ],
    [
        'sender' => 'Client XYZ',
        'subject' => 'Demande de fonctionnalité',
        'preview' => 'Serait-il possible d\'ajouter un filtre par date de création dans l\'interface ?',
        'time' => 'Lundi',
        'is_read' => false,
        'id' => 8
    ],
    // Ajoutez plus de mails ici pour que la pagination fonctionne (simulez des IDs 9 à 20)
    // ...
];

// Répétition des données pour atteindre plus de 10 éléments
for ($i = 9; $i <= 20; $i++) {
    $mails[] = [
        'sender' => 'Test ' . ($i % 3 == 0 ? 'Bug' : 'Info'),
        'subject' => 'Mail de test N°' . $i,
        'preview' => 'Contenu générique pour la pagination.',
        'time' => 'Hier ' . $i . ':00',
        'is_read' => ($i % 4 == 0),
        'id' => $i
    ];
}

// Assumons que $url est la base de votre application
//$url = "/";

// -----------------------------------------------------------
// 2. LOGIQUE DE FILTRAGE
// -----------------------------------------------------------

$search_term = $_GET['search_term'] ?? '';
$search_term = trim($search_term);

$filtered_mails = $mails;

if (!empty($search_term)) {
    $term_lower = strtolower($search_term);

    $filtered_mails = array_filter($mails, function($mail) use ($term_lower) {
        $content = strtolower($mail['sender'] . ' ' . $mail['subject'] . ' ' . $mail['preview']);
        // Vérifie si le terme est trouvé
        return str_contains($content, $term_lower);
    });
}
// IMPORTANT : Réinitialiser les clés numériques après le filtre
$filtered_mails = array_values($filtered_mails);


// -----------------------------------------------------------
// 3. LOGIQUE DE PAGINATION
// -----------------------------------------------------------

$elements_per_page = 10;
$total_mails = count($filtered_mails);
$total_pages = ceil($total_mails / $elements_per_page);
$total_pages = max(1, $total_pages); // Assure qu'il y a au moins 1 page si la liste est vide

$current_page = intval($_GET['page'] ?? 1);
$current_page = max(1, min($current_page, $total_pages)); // Assure que la page est dans les limites [1, total_pages]

// Calculer l'index de début
$start_index = ($current_page - 1) * $elements_per_page;

// Appliquer la pagination (récupérer seulement les éléments de la page actuelle)
$mails_to_display = array_slice($filtered_mails, $start_index, $elements_per_page);

// Préparer les paramètres GET pour les liens de pagination
// On conserve le terme de recherche dans tous les liens
$query_params = http_build_query(['search_term' => $search_term]);
$base_pagination_url = 'index.php?' . $query_params . '&page=';

?>






<form method="GET" action="index.php" class="d-flex mb-4">
        <input type="hidden" name="page" value="<?= $current_page ?>">
        <input type="text"
               name="search_term"
               class="form-control me-2"
               placeholder="Searach data..."
               value="<?= htmlspecialchars($search_term); ?>">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        <?php if (!empty($search_term)): ?>
            <a href="index.php" class="btn btn-secondary ms-2">Réinitialiser</a>
        <?php endif; ?>
    </form>



<div class="list-group list-group-flush border rounded shadow-sm">

    <?php
    if (empty($mails_to_display)): ?>
        <div class="alert alert-info text-center m-0 py-4">
            <?php if (!empty($search_term)): ?>
                Aucun résultat trouvé pour la recherche "<?= htmlspecialchars($search_term); ?>".
            <?php else: ?>
                Votre boîte de réception est vide.
            <?php endif; ?>
        </div>
    <?php
    endif;

    // Boucle sur les MAILS DE LA PAGE ACTUELLE
    foreach ($mails_to_display as $mail):
        // Définir les classes d'affichage
        $text_class = $mail['is_read'] ? 'text-secondary' : 'text-dark';
        $is_strong = $mail['is_read'] ? '' : '<strong>';
        $end_strong = $mail['is_read'] ? '' : '</strong>';
        $read_link = $url . 'mail_admin/index_read.php?id=' . $mail['id'];
    ?>

        <a href="<?= htmlspecialchars($read_link) ?>" class="list-group-item list-group-item-action py-3">
            <div class="d-flex w-100 justify-content-between">
                <div class="form-check me-3 d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" value="<?= $mail['id'] ?>" id="mailCheck_<?= $mail['id'] ?>">
                    <label class="form-check-label ms-3" for="mailCheck_<?= $mail['id'] ?>">
                        <span class="<?= $text_class ?>"><?= $is_strong . htmlspecialchars($mail['sender']) . $end_strong ?></span>
                    </label>
                </div>
                <small class="text-muted text-end"><?= $mail['time'] ?></small>
            </div>

            <p class="mb-1 ps-4 <?= $text_class ?>">
                <?= $is_strong ?>
                Sujet : <?= htmlspecialchars($mail['subject']) ?>
                <?= $end_strong ?>
            </p>

            <small class="text-muted d-block ps-4 text-truncate">
                <?= htmlspecialchars($mail['preview']) ?>
            </small>
        </a>

    <?php endforeach; ?>

    </div>

    <?php if ($total_pages > 1): ?>

    <nav class="mt-4">
      <ul class="pagination justify-content-center">

        <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
          <a class="page-link" href="<?= htmlspecialchars($base_pagination_url . ($current_page - 1)) ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>

          <?php
            // Afficher seulement les pages proches
            if ($i >= $current_page - 2 && $i <= $current_page + 2):
          ?>

          <li class="page-item <?= ($i == $current_page) ? 'active' : '' ?>">
            <a class="page-link" href="<?= htmlspecialchars($base_pagination_url . $i) ?>">
              <?= $i ?>
            </a>
          </li>

          <?php endif; ?>
        <?php endfor; ?>

        <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
          <a class="page-link" href="<?= htmlspecialchars($base_pagination_url . ($current_page + 1)) ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>

      </ul>
    </nav>

    <?php endif; ?>
