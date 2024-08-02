<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Event;
use App\Entity\Partner;
use App\Entity\Tag;
use App\Entity\Truck;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {

        
        // CATEGORY
        $catList =[];
        $categoryList =['Tacos', 'Sushi', 'Burger', 'Cocktails', 'Desserts', 'Goûter', 'Healthy', 'Vegan'];
        for ($i=1; $i <= 8; $i++) { 
            $category = (new Category)
            ->setName($categoryList[$i - 1]);
            $manager->persist($category);
            $catList[] = $category;
        }
        
        // TAG
        $tagList = [];
        $tagNames = ['Sans gluten', 'Faible en calories', 'Sucré', 'Epicé', 'Sans lactose', 'Très gourmand', 'Sans alcool', 'Alcoolisé'];
        for ($i=1; $i <= 8; $i++) { 
            $tag = (new Tag)
            ->setName($tagNames[$i -1]);
            $manager->persist($tag);
            $tagList[] = $tag;
        }
        
        // USER ADMIN
        $userList = [];
        $admin = new User();
        $admin->setEmail('admin@oclock.fr');
        $password = 'admin';
        $admin->setRoles(["ROLE_ADMIN"]);
        $hashedPassword = $this->hasher->hashPassword($admin, $password);
        $admin->setPassword($hashedPassword);
        $admin->setFirstname('Laurent');
        $admin->setLastname('Matheu');
        $manager->persist($admin);
       
        
        // USER 
        $user1 = new User();
        $user1->setEmail('user1@oclock.fr');
        $password = 'user';
        $user1->setRoles(["ROLE_USER"]);
        $hashedPassword = $this->hasher->hashPassword($user1, $password);
        $user1->setPassword($hashedPassword);
        $user1->setFirstname('Marine');
        $user1->setLastname('Montaru');
        $manager->persist($user1);
        $userList[] = $user1;

        // USER 
        $user2 = new User();
        $user2->setEmail('user2@oclock.fr');
        $password = 'user';
        $user2->setRoles(["ROLE_USER"]);
        $hashedPassword = $this->hasher->hashPassword($user2, $password);
        $user2->setPassword($hashedPassword);
        $user2->setFirstname('Thomas');
        $user2->setLastname('Iannicca');
        $manager->persist($user2);
        $userList[] = $user2;
        
        
        // TRUCK
        $truckList = [];
        for ($i=1; $i <= 10; $i++) { 

            $truck = new Truck;
            $truck->setName("truck numero $i")
            ->setPictureName('assets/images/events.jpg')
            ->setPresentation("Superbe truck bien décoré numéro $i")
            ->setLocation(mt_rand(1, 25))
            ->setStatus('pending')
            ->setChefName("Michel Robuchon num $i")
            ->setChefPictureName('assets/images/events.jpg')
            ->setChefDescription('Top chef forcément')
            ->setUser($userList[array_rand($userList)]);
            for ($j=0; $j <= mt_rand(0,1) ; $j++) { 
                $truck->addCategory($catList[array_rand($catList)]);
            }
            $manager->persist($truck);
            $truckList[] = $truck;
        } 
        // DISH
        $typeList = ['Entrée', 'Plat', 'Dessert', 'Cocktails', 'Boisson'];
        $dishList = [];
        for ($i=1; $i <= 50; $i++) { 
            $dish = (new Dish)
            ->setName("dish numero $i")
            ->setPictureName('assets/images/events.jpg')
            ->setDescription("Superbe plat bien présenté numéro $i")
            ->setPrice(mt_rand(5, 25))
            ->setMenuOrder($i)
            ->setType($typeList[array_rand($typeList)])
            ->setTruck($truckList[array_rand($truckList)]);
            for ($j=0; $j < mt_rand(0,2) ; $j++) { 
                $dish->addTag($tagList[array_rand($tagList)]);
            }
            $manager->persist($dish);
            $dishList[] = $dish;
        }   
        // EVENT
        for ($i = 1; $i <= 6; $i++) {
            $event = (new Event)
                ->setTitle("évènement $i")
                ->setPictureName('assets/images/events.jpg')
                ->setContent("Voici ce qu'il va se passer dans cet evenement bla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla blabla bla bla bla")
                ->setOpenedAt(new DateTimeImmutable('12-12-2024'))
                ->setClosedAt(new DateTimeImmutable('13-12-2024'))
                ->setLocation("à l'emplacement numéro $i");
                $manager->persist($event);
            } 
        
        // PARTNER
         for ($i=1; $i <= 10; $i++) { 
         $partner = (new Partner)
             ->setName("Partenaire $i")
             ->setLogoName('assets/images/events.jpg');
             $manager->persist($partner);
         }
        
        
        $manager->flush();
    }
}
