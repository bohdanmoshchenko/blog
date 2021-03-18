<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setEmail('1@gmail.com');
        $password = $this->encoder->encodePassword($user1, '1');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_ADMIN']);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('2@gmail.com');
        $password = $this->encoder->encodePassword($user2, '2');
        $user2->setPassword($password);
        $user2->setRoles(['ROLE_ADMIN']);
        $manager->persist($user2);

        $category1 = new Category();
        $category1->setName('category1');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('category2');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('category3');
        $manager->persist($category3);

        $post1 = new Post();
        $post1->setTitle('What is Lorem Ipsum?');
        $post1->setBody('Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
            Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.');
        $post1->setCategories(new ArrayCollection([$category1, $category2]));
        $post1->setAuthor($user1);
        $manager->persist($post1);

        $post2 = new Post();
        $post2->setTitle('Why do we use it?');
        $post2->setBody('It is a long established fact that a reader will be distracted by the readable 
            content of a page when looking at its layout. The point of using.');
        $post2->setCategories(new ArrayCollection([$category2, $category3]));
        $post2->setAuthor($user2);
        $manager->persist($post2);

        $manager->flush();
    }
}
