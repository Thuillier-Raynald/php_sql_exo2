<?php
require('pdo.php');
function debug($x)
{
    echo '<pre>';
    print_r($x);
    echo '</pre>';
}
// l'id de laura
$sql = "SELECT id_abonne FROM abonne WHERE prenom = 'Laura'";
$query = $pdo->prepare($sql);
$query->execute();
$result0 = $query->fetchAll();
//debug($result0);

// Abonné 2 à emprunté les livres à quelles dates
$sql = "SELECT date_sortie FROM emprunt WHERE id_abonne = '2'";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll();
//debug($result);

// Combien d'emprunts total
$sql = "SELECT count(*) FROM emprunt";
$query = $pdo->prepare($sql);
$query->execute();
$result1 = $query->fetchAll();
//debug($result1);

// combien de livres sortis le 2011-12-19
$sql = "SELECT count(*) FROM emprunt WHERE date_sortie = '2011-12-19'";
$query = $pdo->prepare($sql);
$query->execute();
$result2 = $query->fetchAll();
//debug($result2);

// Afficher les titres des livres non rendus
$sql = "SELECT titre FROM livre WHERE id_livre 
        IN (SELECT id_livre FROM emprunt WHERE date_rendu IS NULL)";
$query = $pdo->prepare($sql);
$query->execute();
$result3 = $query->fetchAll();
//debug($result3);

// Afficher le prénom des abonnés ayant emprunter un livre le 2011-12-19
$sql = "SELECT prenom FROM abonne WHERE id_abonne 
        IN (SELECT id_abonne FROM emprunt WHERE date_sortie = '2011-12-19')";
$query = $pdo->prepare($sql);
$query->execute();
$result4 = $query->fetchAll();
//debug($result4);

// Afficher les abonnés ayant emprunter un livre d'alphonse Daudet
$sql = "SELECT prenom FROM abonne WHERE id_abonne 
        IN (SELECT id_abonne FROM emprunt WHERE id_livre
        IN (SELECT id_livre FROM livre WHERE auteur = 'ALPHONSE DAUDET')
        )";
$query = $pdo->prepare($sql);
$query->execute();
$result5 = $query->fetchAll();
//debug($result5);

// Quels livres Chloé a emprunté ?
$sql = "SELECT titre FROM livre WHERE id_livre
        IN (SELECT id_livre FROM emprunt WHERE id_abonne
        IN (SELECT id_abonne FROM abonne WHERE prenom = 'Chloe')
        )";
$query = $pdo->prepare($sql);
$query->execute();
$result6 = $query->fetchAll();
//debug($result6);

// Quels livres Chloé n'a pas emprunté ?
$sql = "SELECT titre FROM livre WHERE id_livre
        NOT IN (SELECT id_livre FROM emprunt WHERE id_abonne
        IN (SELECT id_abonne FROM abonne WHERE prenom = 'Chloe')
        )";
$query = $pdo->prepare($sql);
$query->execute();
$result7 = $query->fetchAll();
//debug($result7);

// JOINTURES
// Afficher les sorties et entrees de "guillaume"
$sql = "SELECT ab.prenom, em.date_rendu, em.date_sortie 
        FROM abonne AS ab
        INNER JOIN emprunt AS em
        ON ab.id_abonne = em.id_abonne
        WHERE ab.prenom = 'Guillaume'
        ";
$query = $pdo->prepare($sql);
$query->execute();
$result8 = $query->fetchAll();
//debug($result8);

// Afficher les prenoms des abonnes ayant emprunter un livre le 2011-12-19
$sql = "SELECT ab.prenom, em.id_emprunt, em.date_sortie 
        FROM abonne AS ab
        INNER JOIN emprunt AS em
        ON ab.id_abonne = em.id_abonne
        WHERE em.date_sortie = '2011-12-19'
        ";
$query = $pdo->prepare($sql);
$query->execute();
$result9 = $query->fetchAll();
//debug($result9);

// Afficher le titre, date sortie et date rendu des livres écrits par Alphonse Daudet
$sql = "SELECT li.titre, em.date_sortie, em.date_rendu 
        FROM livre AS li
        INNER JOIN emprunt AS em
        ON li.id_livre = em.id_livre
        WHERE li.auteur = 'ALPHONSE DAUDET'
        ";
$query = $pdo->prepare($sql);
$query->execute();
$result10 = $query->fetchAll();
debug($result10);
