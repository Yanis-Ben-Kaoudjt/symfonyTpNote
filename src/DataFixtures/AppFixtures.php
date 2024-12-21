<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Matiere;
use App\Entity\Chapitre;
use App\Entity\Exercice;
use App\Entity\Commentaire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Création de l'utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('Doe');
        $admin->setPrenom('John');
        $hashedPasswordAdmin = $this->encoder->hashPassword($admin, 'adminpassword');
        $admin->setPassword($hashedPasswordAdmin);
        $manager->persist($admin);

        // Création de l'utilisateur user
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setNom('Doe');
        $user->setPrenom('Jane');
        $hashedPasswordUser = $this->encoder->hashPassword($user, 'userpassword');
        $user->setPassword($hashedPasswordUser);
        $manager->persist($user);

        // Création de l'utilisateur bannedUser
        $bannedUser = new User();
        $bannedUser->setEmail('banned@example.com');
        $bannedUser->setRoles(['ROLE_USER']);
        $bannedUser->setNom('Doe');
        $bannedUser->setPrenom('Jim');
        $hashedPassword = $this->encoder->hashPassword($bannedUser, 'bannedpassword');
        $bannedUser->setPassword($hashedPassword);
        $bannedUser->setBanned(true);
        $manager->persist($bannedUser);

        // Création des matières
        $matiere1 = new Matiere();
        $matiere1->setNom('Mathématiques');
        $matiere1->setDescription('Les bases des mathématiques');
        $manager->persist($matiere1);

        $matiere2 = new Matiere();
        $matiere2->setNom('Français');
        $matiere2->setDescription('Les bases du français');
        $manager->persist($matiere2);

        // Création des chapitres
        $chapitre1 = new Chapitre();
        $chapitre1->setTitre('Les nombres');
        $chapitre1->setContenu('Les nombres entiers, les nombres décimaux, les fractions');
        $chapitre1->setMatiere($matiere1);
        $manager->persist($chapitre1);

        $chapitre2 = new Chapitre();
        $chapitre2->setTitre('Les équations');
        $chapitre2->setContenu('Résolution d\'équations simples');
        $chapitre2->setMatiere($matiere1);
        $manager->persist($chapitre2);

        // Création des exercices
        $exercice1 = new Exercice();
        $exercice1->setTitre('Addition');
        $exercice1->setConsigne('Additionner des nombres entiers');
        $exercice1->setChapitre($chapitre1);
        $manager->persist($exercice1);

        $exercice2 = new Exercice();
        $exercice2->setTitre('Résolution d\'équations simples');
        $exercice2->setConsigne('Résoudre les équations du type x + 3 = 5');
        $exercice2->setChapitre($chapitre2);
        $manager->persist($exercice2);

        // Création des commentaires
        $commentaire1 = new Commentaire();
        $commentaire1->setContenu('Cet exercice est très bien');
        $commentaire1->setDateCreation(new \DateTime());
        $commentaire1->setExercice($exercice1);
        $manager->persist($commentaire1);

        $commentaire2 = new Commentaire();
        $commentaire2->setContenu('Cet exercice est trop nul');
        $commentaire2->setDateCreation(new \DateTime());
        $commentaire2->setExercice($exercice2);
        $manager->persist($commentaire2);

        $manager->flush();
    }
}
