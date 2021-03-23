<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        // create 10 products! Bam!
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setFirstName('fake'.$i);
            $user->setEmail(sprintf('edwin%d@hotmail.com',$i));
            $user->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $manager->persist($user);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
        }
        for ($i = 0; $i < 3; $i++) {
            $admin = new User();
            $admin->setFirstName('fake'.$i);
            $admin->setEmail(sprintf('admin%d@hotmail.com',$i));
            $admin->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);
            $admin->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
        }

        $manager->flush();
    }
}
