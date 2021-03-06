<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        //ARTICLES
        for ($i = 0; $i < 5; $i++) {
            $product = new Article();
            $product->setNom('canard ' . $i);
            $product->setPrix(mt_rand(10, 1000));
            $product->setDescription("Un super produit !");
            $product->setCategorie("canard");
            $product->setPhoto("canard.jpg");
            $product->setNote(5);
            $product->setAvis("VRAIMENT un super produit");
            $manager->persist($product);
        }
        for ($i = 0; $i < 5; $i++) {
            $product = new Article();
            $product->setNom('espadon ' . $i);
            $product->setPrix(mt_rand(10, 1000));
            $product->setDescription("Un super produit !");
            $product->setCategorie("espadon");
            $product->setPhoto("espadon.jpg");
            $product->setNote(5);
            $product->setAvis("VRAIMENT un super produit");
            $manager->persist($product);
        }
        for ($i = 0; $i < 5; $i++) {
            $product = new Article();
            $product->setNom('jambon ' . $i);
            $product->setPrix(mt_rand(10, 1000));
            $product->setDescription("Un super produit !");
            $product->setCategorie("jambon");
            $product->setPhoto("jambon.jpg");
            $product->setNote(5);
            $product->setAvis("VRAIMENT un super produit");
            $manager->persist($product);
        }
        for ($i = 0; $i < 5; $i++) {
            $product = new Article();
            $product->setNom('girafe ' . $i);
            $product->setPrix(mt_rand(10, 1000));
            $product->setDescription("Un super produit !");
            $product->setCategorie("girafe");
            $product->setPhoto("girafe.jpg");
            $product->setNote(5);
            $product->setAvis("VRAIMENT un super produit");
            $manager->persist($product);
        }
        for ($i = 0; $i < 5; $i++) {
            $product = new Article();
            $product->setNom('sousmarin ' . $i);
            $product->setPrix(mt_rand(10, 1000));
            $product->setDescription("Un super produit !");
            $product->setCategorie("sousmarin");
            $product->setPhoto("sousmarin.jpg");
            $product->setNote(5);
            $product->setAvis("VRAIMENT un super produit");
            $manager->persist($product);
        }

        $product = new Article();
        $product->setNom('specialDelivery');
        $product->setPrix(mt_rand(10, 1000));
        $product->setDescription("Livraison spéciale !!");
        $product->setCategorie("sousmarin");
        $product->setPhoto("boom.jpg");
        $product->setNote(5);
        $product->setAvis("Ca va faire BOOM!");
        $manager->persist($product);

        //USERS

        $user = new User();
        $user->setName("User");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'user'));
        $user->setEmail("user@user.com");
        $user->setRoles([
            "ROLE_USER",
        ]);
        $manager->persist($user);

        $user = new User();
        $user->setName("Admin");
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));
        $user->setEmail("admin@admin.com");
        $user->setRoles([
            "ROLE_ADMIN"
        ]);
        $manager->persist($user);

        $manager->flush();
    }
}
