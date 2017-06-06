<?php

namespace AdminBundle\DataFixtures\ORM;

use CommonBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.ru');
        $admin->setRoles(['ROLE_ADMIN']);
        $plainPassword = 'admin';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($admin, $plainPassword);
        $admin->setPassword($encoded);

        $manager->persist($admin);
        $this->setReference('admin', $admin);

        $user = new User();
        $user->setUsername('user');
        $user->setEmail('user@user.ru');
        $user->setRoles(['ROLE_USER']);
        $plainPassword = 'user';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);

        $manager->persist($user);
        $this->setReference('user', $user);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        return $this->container = $container;
    }
}