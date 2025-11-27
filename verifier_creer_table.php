<?php
// ====================================================================
// CONFIGURATION DE LA BASE DE DONNÉES (À MODIFIER)
// ====================================================================
$host = 'localhost';
$db   = 'nom_de_votre_db'; // Assurez-vous que cette DB existe
$user = 'votre_user';
$pass = 'votre_mot_de_passe';
$charset = 'utf8mb4';
$tableName = 'contacts'; // Nom de la table à vérifier/créer

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 1. Connexion à la base de données
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ Connexion à la base de données réussie.<br>";

    // 2. Vérification de l'existence de la table
    $checkTableQuery = $pdo->prepare("SHOW TABLES LIKE ?");
    $checkTableQuery->execute([$tableName]);

    if ($checkTableQuery->rowCount() > 0) {
        // La table existe
        echo "✅ La table **`$tableName`** existe déjà. Aucune action nécessaire.<br>";

    } else {
        // La table n'existe pas, on la crée
        echo "⚠️ La table **`$tableName`** n'existe pas. Tentative de création...<br>";

        // 3. Création de la table (Utilisation du SQL de notre conversation précédente)
        $createTableSQL = "
            CREATE TABLE $tableName (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                subject VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                submitted_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        $pdo->exec($createTableSQL);

        echo "🎉 La table **`$tableName`** a été créée avec succès.<br>";
    }

} catch (\PDOException $e) {
    // Gestion des erreurs (connexion, syntaxe SQL, permissions)
    echo "❌ Échec de l'opération : " . $e->getMessage() . "<br>";
}
?>