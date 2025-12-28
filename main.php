<?php

// 1. Require all necessary files
require_once __DIR__ .  "/src/config/Database.php";
require_once __DIR__ .  "/src/Utils/Validator.php";
require_once __DIR__ .  "/src/Models/BaseModel.php";
require_once __DIR__ .  "/src/Models/Personne.php";
require_once __DIR__ .  "/src/Models/Doctor.php";
require_once __DIR__ .  "/src/Models/Patient.php";
require_once __DIR__ .  "/src/Models/Department.php"; 

// 2. Helper function to get input from terminal
function input($prompt) {
    echo $prompt . ": ";
    return trim(fgets(STDIN));
}

try {
    $db = Database::getConnection();

    $patientModel = new Patient($db);
    $doctorModel = new Doctor($db);
    $deptModel = new Department($db);

    do {
        echo "\n=== Unity Care CLI ===\n";
        echo "1. Gérer les patients\n";
        echo "2. Gérer les médecins\n";
        echo "3. Gérer les départements\n";
        echo "4. Statistiques\n";
        echo "5. Quitter\n";
        echo "======================\n";
        
        $choice = input("Choisissez une option");

        switch ($choice) {
            case '1':
                handlePatients($patientModel);
                break;
            case '2':
                handleDoctors($doctorModel);
                break;
            case '3':
                handleDepartments($deptModel);
                break;
            case '4':
                showStatistics($patientModel, $doctorModel, $deptModel);
                break;
            case '5':
                echo "Au revoir!\n";
                exit;
            default:
                echo "Option invalide. Veuillez réessayer.\n";
        }

    } while ($choice != 5);

} catch (Exception $e) {
    echo "Erreur Critique: " . $e->getMessage();
}

// --------------------------------------------------------
// HANDLER FUNCTIONS (Now with UPDATE)
// --------------------------------------------------------

function handleDepartments(Department $deptModel) {
    echo "\n--- GESTION DES DÉPARTEMENTS ---\n";
    // Added option 3 for Modifier
    echo "1. Lister\n2. Ajouter\n3. Modifier\n4. Supprimer\n5. Retour\n";
    $opt = input("Choix");

    if ($opt == '1') {
        // LIST
        $depts = $deptModel->getAll();
        if (empty($depts)) {
            echo "Aucun département trouvé.\n";
        } else {
            $mask = "| %-4s | %-20s |\n";
            $line = "+------+----------------------+\n";
            echo $line;
            printf($mask, 'ID', 'Nom du Département');
            echo $line;
            foreach ($depts as $d) {
                printf($mask, $d->id ?? 0, $d->getName()); 
            }
            echo $line;
        }

    } elseif ($opt == '2') {
        // ADD
        $name = input("Nom du département");
        if (Validator::isNotEmtpy($name)) {
            $deptModel->create($name);
            echo "Département ajouté!\n";
        } else {
            echo "Erreur: Le nom ne peut pas être vide.\n";
        }

    } elseif ($opt == '3') {
        // UPDATE (New functionality)
        $id = input("ID du département à modifier");
        if (is_numeric($id)) {
            $name = input("Nouveau nom du département");
            if (Validator::isNotEmtpy($name)) {
                // Pass array with key matching DB column 'name'
                $deptModel->update(['name' => $name], $id);
            } else {
                echo "Erreur: Le nom est vide.\n";
            }
        } else {
            echo "ID invalide.\n";
        }

    } elseif ($opt == '4') {
        // DELETE
        $id = input("ID du département à supprimer");
        if (is_numeric($id)) {
            $deptModel->delete($id);
        } else {
            echo "ID invalide.\n";
        }
    }
}

function handleDoctors(Doctor $docModel) {
    echo "\n--- GESTION DES MÉDECINS ---\n";
    echo "1. Lister\n2. Ajouter\n3. Modifier\n4. Retour\n";
    $opt = input("Choix");

    if ($opt == '1') {
        // LIST
        $docs = $docModel->getAll();
        if (empty($docs)) {
            echo "Aucun médecin trouvé.\n";
        } else {
            $mask = "| %-4s | %-12s | %-12s | %-15s |\n";
            $line = "+------+--------------+--------------+-----------------+\n";
            echo $line;
            printf($mask, 'ID', 'Prénom', 'Nom', 'Spécialité');
            echo $line;
            foreach($docs as $d) { 
                printf($mask, 
                    $d->id ?? 0, 
                    $d->getFirstName(), 
                    $d->getLastName(), 
                    $d->getSpecialization() ?? 'N/A'
                ); 
            }
            echo $line;
        }

    } elseif ($opt == '2') {
        // ADD
        $data = [
            'first_name' => input("Prénom"),
            'last_name'  => input("Nom"),
            'email'      => input("Email"),
            'phone'      => input("Téléphone"),
            'specialization' => input("Spécialité"), // Key must match DB column
            'dept_id' => input("ID Département")     // Key must match DB column
        ];

        if (Validator::validateEmail($data['email']) && Validator::validatePhone($data['phone'])) {
            $docModel->insert($data); 
            echo "Médecin ajouté!\n";
        } else {
            echo "Données invalides.\n";
        }

    } elseif ($opt == '3') {
        // UPDATE (New functionality)
        $id = input("ID du médecin à modifier");
        
        if (is_numeric($id)) {
            echo "Entrez les nouvelles informations:\n";
            // For simplicity in CLI, we ask for all fields again
            $data = [
                'first_name' => input("Prénom"),
                'last_name'  => input("Nom"),
                'email'      => input("Email"),
                'phone'      => input("Téléphone"),
                'specialization' => input("Spécialité"),
                'dept_id' => input("ID Département")
            ];

            if (Validator::validateEmail($data['email']) && Validator::validatePhone($data['phone'])) {
                $docModel->update($data, $id);
                // BaseModel prints "update successfully.."
            } else {
                echo "Données invalides.\n";
            }
        } else {
            echo "ID invalide.\n";
        }
    }
}

function handlePatients(Patient $patModel) {
    echo "\n--- GESTION DES PATIENTS ---\n";
    echo "1. Lister\n2. Ajouter\n3. Modifier\n4. Retour\n";
    $opt = input("Choix");

    if ($opt == '1') {
        // LIST
        $pats = $patModel->getAll(); 
        if (empty($pats)) {
            echo "Aucun patient trouvé.\n";
        } else {
            $mask = "| %-4s | %-12s | %-12s | %-15s |\n";
            $line = "+------+--------------+--------------+-----------------+\n";
            echo $line;
            printf($mask, 'ID', 'Prénom', 'Nom', 'Téléphone');
            echo $line;
            foreach($pats as $p) { 
                printf($mask, 
                    $p->id ?? 0, 
                    $p->getFirstName(), 
                    $p->getLastName(), 
                    $p->getPhone() ?? 'N/A'
                );
            }
            echo $line;
        }

    } elseif ($opt == '2') {
        // ADD
        $data = [
            'first_name' => input("Prénom"),
            'last_name'  => input("Nom"),
            'email'      => input("Email"),
            'phone'      => input("Téléphone"),
            'birth_date' => input("Date de naissance (YYYY-MM-DD)"),
            'address'    => input("Adresse")
        ];
        
        if(Validator::isValidDate($data['birth_date'])) {
            $patModel->register($data);
            echo "Patient enregistré!\n";
        } else {
            echo "Format de date invalide.\n";
        }

    } elseif ($opt == '3') {
        // UPDATE (New functionality)
        $id = input("ID du patient à modifier");
        
        if (is_numeric($id)) {
            echo "Entrez les nouvelles informations:\n";
            $data = [
                'first_name' => input("Prénom"),
                'last_name'  => input("Nom"),
                'email'      => input("Email"),
                'phone'      => input("Téléphone"),
                'birth_date' => input("Date de naissance (YYYY-MM-DD)"),
                'address'    => input("Adresse")
            ];

            if(Validator::isValidDate($data['birth_date']) && Validator::validateEmail($data['email'])) {
                $patModel->update($data, $id);
                // BaseModel prints "update successfully.."
            } else {
                echo "Données invalides (Date ou Email).\n";
            }
        } else {
            echo "ID invalide.\n";
        }
    }
}

function showStatistics($patModel, $docModel, $deptModel) {
    echo "\n--- STATISTIQUES ---\n";
    echo "+--------------------+-------+\n";
    echo "| Catégorie          | Total |\n";
    echo "+--------------------+-------+\n";
    printf("| %-18s | %-5s |\n", "Patients", count($patModel->getAll()));
    printf("| %-18s | %-5s |\n", "Médecins", count($docModel->getAll()));
    printf("| %-18s | %-5s |\n", "Départements", count($deptModel->getAll()));
    echo "+--------------------+-------+\n";
}