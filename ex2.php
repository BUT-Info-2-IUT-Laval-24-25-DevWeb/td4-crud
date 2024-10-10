<?php

    $file = 'users.json';

    // Fonction pour lire un fichier JSON existant
    function getUsers($file) {
        if (file_exists($file)) {
            $jsonData = file_get_contents($file);
            return json_decode($jsonData, true) ?? []; // Décode en tableau associatif ?? Et si le fichier est null, on retourne un tableau vide
        } else {
            return []; //Si le fichier n'existe pas, on retourne un tableau vide
        }
    }

    // Fonction pour ajouter un nouvel utilisateur
    function createUser($file, $user_data) {
        $users = getUsers($file); // Lecture du fichier JSON existant
        $users[] = $user_data; // Ajout du nouvel utilisateur au tableau
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT)); // Sauvegarde des utilisateurs dans le fichier JSON
    }



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

        // Nouvelle entrée utilisateur
        $new_user = [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'mdp' => $mdp
        ];
        createUser($file, $new_user);
        echo "Inscription réussie ! <br><br>";
    }
    else {
        echo "Formulaire d'inscription non soumi <br><br>";
    }


    // Affichage de la liste des utilisateurs inscrits
   
    $users = getUsers($file);

    if (!empty($users)) {
        echo "<h2>Liste des utilisateurs inscrits :</h2>";
        echo "<table border='1'>
                <thead>
                        <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>";
        
        // Affichage des utilisateurs dans un tableau HTML
        foreach ($users as $user) {
            if (isset($user['nom'], $user['prenom'], $user['email'])){
                echo "<tbody>
                        <tr>
                            <td>" . htmlspecialchars($user['nom']) . "</td>
                            <td>" . htmlspecialchars($user['prenom']) . "</td>
                            <td>" . htmlspecialchars($user['email']) . "</td>
                        </tr>
                    </tbody>";
            }
        }
        echo "</table>";

    } else {
        echo "Aucun utilisateur inscrit pour le moment.";
    }

?>