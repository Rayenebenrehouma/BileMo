<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Phone;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $roles[] = 'ROLE_USER';

        // === Products ===
        $phone = new Phone();
        $phone->setModel('Galaxy Note 9')
            ->setBrand('Samsung')
            ->setColor('Black')
            ->setPrice(599.99)
            ->setDescription('Le Samsung Galaxy Note 9 est le dernier-né de la gamme Note du géant coréen. C’est, aujourd’hui, l’une des solutions les plus complètes et les plus abouties sous Android.')
        ;
        $manager->persist($phone);

        $phone = new Phone();
        $phone->setModel('Pixel 3')
            ->setBrand('Google')
            ->setColor('White')
            ->setPrice(699.99)
            ->setDescription('Vous ne jurez que par Android Stock? Ne cherchez pas plus loin, c’est le Google Pixel 3 qu’il vous faut. Ce smartphone associe à la perfection la partie matérielle avec la partie logicielle. Premièrement, il possède un design assez unique avec un dos en verre dépoli garantissant une meilleure tenue du smartphone. C’est sobre et ça fonctionne très bien. Il n’est pas très grand avec son écran OLED de 5,5 pouces et ravira les personnes à la recherche d’un appareil un peu passe-partout.')
        ;
        $manager->persist($phone);

        $phone = new Phone();
        $phone->setModel('P20 Pro')
            ->setBrand('Huawei')
            ->setColor('Pink')
            ->setPrice(449.99)
            ->setDescription('Le Huawei P20 Pro est un très beau smartphone. Lorsqu’on le retourne, on découvre un dos en verre du plus bel effet pouvant servir occasionnellement de miroir au besoin (oui, oui). L’écran OLED de 6,1 pouces est très équilibré et possède une grande luminosité ainsi que des noirs très profonds. Un vrai plaisir à regarder au quotidien.')
        ;
        $manager->persist($phone);

        /*
        // === Customer ===
        $customer = new Customer();
        $customer->setEmail('Orange-client@outlook.fr');
        $customer->setPassword($this->hasher->hashPassword($customer, 'test'));
        $customer->setOrganization('Orange');
        $customer->setRoles((array)$roles);
        $this->addReference('Orange', $customer);
        $manager->persist($customer);
        */
        $customer = new Customer();
        $customer->setEmail('SFR-client@outlook.fr');
        $customer->setPassword($this->hasher->hashPassword($customer, 'test'));
        $customer->setOrganization('SFR');
        $customer->setRoles((array)$roles);
        $this->addReference('SFR', $customer);

        $manager->persist($customer);
        /*
        $customer = new Customer();
        $customer->setEmail('Bouygues-client@outlook.fr');
        $customer->setPassword($this->hasher->hashPassword($customer, 'test'));
        $customer->setOrganization('Bouygues');
        $customer->setRoles((array)$roles);
        $this->addReference('Bouygues', $customer);
        $manager->persist($customer);


        //Add 10 user for SFR
        for ($i=0; $i < 10; $i++)
        {
            $user = new User();
            $customer = $this->getReference('SFR');
            $user->setFirstname('Jean-Charles-'.$i)
                ->setLastName("Dubois")
                ->setEmail('Jean-Charles@test.com')
                ->setSlug('')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setCustomer($customer)
            ;
            $manager->persist($user);
        }
        /*
                $user = new User();
                $client = $this->getReference('Orange');
                $user->setUsername('admin-'.$i.$client->getOrganization())
                    ->setEmail('admin-'.$i.$client->getOrganization().'@test.com')
                    ->setPassword($this->hasher->hashPassword($user, 'test'))
                    ->setClient($client)
                    ->setRoles(array($roles));
                ;
                $manager->persist($user);

                $user = new User();
                $client = $this->getReference('SFR');
                $user->setUsername('admin-'.$i.$client->getOrganization())
                    ->setEmail('admin-'.$i.$client->getOrganization().'@test.com')
                    ->setPassword($this->hasher->hashPassword($user, 'test'))
                    ->setClient($client)
                    ->setRoles(array($roles));
                ;
                $manager->persist($user);
        */
        $manager->flush();
    }
}
