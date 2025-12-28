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
        // Clear screen (optional)
        // system('clear'); 
        
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
// FUNCTIONS
// --------------------------------------------------------

function handleDepartments(Department $deptModel) {
    echo "\n--- GESTION DES DÉPARTEMENTS ---\n";
    echo "1. Lister\n2. Ajouter\n3. Supprimer\n4. Retour\n";
    $opt = input("Choix");

    if ($opt == '1') {
        // LIST
        $depts = $deptModel->getAll();

        if (empty($depts)) {
            echo "Aucun département trouvé.\n";
        } else {
            // Define format: ID (4 chars) | Name (20 chars)
            $mask = "| %-4s | %-20s |\n";
            $line = "+------+----------------------+\n";

            echo $line;
            printf($mask, 'ID', 'Nom du Département');
            echo $line;
            
            foreach ($depts as $d) {
                // Assuming Department has getName() or public property $name
                printf($mask, $d->id ?? 0, $d->getName()); 
            }
            echo $line;
        }

    } elseif ($opt == '2') {
        $name = input("Nom du département");
        if (Validator::isNotEmtpy($name)) {
            $deptModel->create($name);
            echo "Département ajouté!\n";
        } else {
            echo "Erreur: Le nom ne peut pas être vide.\n";
        }

    } elseif ($opt == '3') {
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
    echo "1. Lister\n2. Ajouter\n3. Retour\n";
    $opt = input("Choix");

    if ($opt == '1') {
        $docs = $docModel->getAll();

        if (empty($docs)) {
            echo "Aucun médecin trouvé.\n";
        } else {
            // Layout: ID | First Name | Last Name | Speciality
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
        $data = [
            'first_name' => input("Prénom"),
            'last_name'  => input("Nom"),
            'email'      => input("Email"),
            'phone'      => input("Téléphone"),
            'speciality' => input("Spécialité"),
            'department_id' => input("ID Département")
        ];

        // Basic Validation
        if (Validator::validateEmail($data['email']) && Validator::validatePhone($data['phone'])) {
            $docModel->insert($data); 
            echo "Médecin ajouté!\n";
        } else {
            echo "Données invalides (Email ou Téléphone incorrect).\n";
        }
    }
}

function handlePatients(Patient $patModel) {
    echo "\n--- GESTION DES PATIENTS ---\n";
    echo "1. Lister\n2. Ajouter\n3. Retour\n";
    $opt = input("Choix");

    if ($opt == '1') {
        $pats = $patModel->getAll(); 
        
        if (empty($pats)) {
            echo "Aucun patient trouvé.\n";
        } else {
            // Layout: ID | First Name | Last Name | Phone
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
    }
}

function showStatistics($patModel, $docModel, $deptModel) {
    echo "\n--- STATISTIQUES ---\n";
    // We can also format this nicely
    echo "+--------------------+-------+\n";
    echo "| Catégorie          | Total |\n";
    echo "+--------------------+-------+\n";
    printf("| %-18s | %-5s |\n", "Patients", count($patModel->getAll()));
    printf("| %-18s | %-5s |\n", "Médecins", count($docModel->getAll()));
    printf("| %-18s | %-5s |\n", "Départements", count($deptModel->getAll()));
    echo "+--------------------+-------+\n";
}