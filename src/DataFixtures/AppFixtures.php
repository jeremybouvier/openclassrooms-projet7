<?php

namespace App\DataFixtures;


use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AppFixtures extends Fixture
{
    /**
     * @var array
     */
    private $users;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

     /**
     * Modèle de construction de données en base de donnée
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadCustomers($manager);
        $this->loadProducts($manager);
        $manager->flush();
    }

    public function loadUsers($manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLoginName('user'.$i);
            $user->setPassword('pass'.$i);
            $user->setCompany('company of user'.$i);
            $user->setAddress('address of user'.$i);
            $user->setZipCode(20290+$i);
            $user->setCity('city of user'.$i);
            $user->setPhone('00.00.00.00.0'.$i);
            $this->users[] = $user;
            $manager->persist($user);
        }
    }

    public function loadCustomers($manager)
    {
        foreach ($this->users as $user) {
            for ($i = 0; $i < 10; $i++) {
                $customer = new Customer();
                $customer->setFirstName('customer'.$i);
                $customer->setLastName('customerLast'.$i);
                $customer->setAddress('address of customer'.$i);
                $customer->setZipCode(20290+$i);
                $customer->setCity('city of customer'.$i);
                $customer->setEmail('customer'.$i.'@gmail.com');
                $customer->setUser($user);
                $manager->persist($customer);
            }
        }
    }

    public function loadProducts($manager)
    {
        for ($i = 0; $i < 10; $i++)  {
            $product = new Product();
            $product->setName('product'.$i);
            $product->setBrand('Apple');
            $product->setDescription('description'.$i);
            $product->setprice(990+$i);
            $manager->persist($product);
        }

        for ($i = 0; $i < 10; $i++)  {
            $product = new Product();
            $product->setName('product'.$i);
            $product->setBrand('Samsung');
            $product->setDescription('description'.$i);
            $product->setprice(890+$i);
            $manager->persist($product);
        }


    }
}
