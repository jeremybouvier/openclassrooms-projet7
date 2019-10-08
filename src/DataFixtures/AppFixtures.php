<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AppFixtures extends Fixture
{

    /**
     * @var array
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }

     /**
     * Modèle de construction de données en base de donnée
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $manager->flush();
        $this->loadCustomers($manager);
        $this->loadProducts($manager);
        $manager->flush();
    }

    public function loadUsers($manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setPassword('pass'.$i);
            $user->setCompany('company of user'.$i);
            $user->setAddress('address of user'.$i);
            $user->setZipCode(20290+$i);
            $user->setCity('city of user'.$i);
            $user->setPhone('00.00.00.00.0'.$i);

            $manager->persist($user);
        }
    }

    public function loadCustomers($manager)
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            for ($j = 0; $j < 50; $j++) {
                $customer = new Customer();
                $customer->setFirstName('customer'.$j);
                $customer->setLastName('customerLast'.$j);
                $customer->setAddress('address of customer'.$j);
                $customer->setZipCode(20290+$j);
                $customer->setCity('city of customer'.$j);
                $customer->setEmail('customer'.$j.'@gmail.com');
                $user->addCustomer($customer);
            }
            $manager->persist($user);
        }
    }
    
    public function loadProducts($manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $this->setProducts($manager, $i, 'Apple', 900);
            $this->setProducts($manager, $i, 'Samsung', 890);
        }
    }

    private function setProducts($manager, $i, $brand = 'brand', $basePrice = 900)
    {
        $product = new Product();
        $product->setName('product'.$i);
        $product->setBrand($brand);
        $product->setDescription('description'.$i);
        $product->setprice($basePrice+($i*10));
        $picture = new Picture();
        $picture->setPath("/path/image/product".$i.".jpg");
        $product->addPicture($picture);
        $manager->persist($product);
    }
}
