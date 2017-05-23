<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 24/04/17
 * Time: 13:21
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    /** @var Container  */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $plainPassword = 'azerty';
        $encoder = $this->container->get('security.password_encoder');

        $user = new User();
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setUsername('laurent');
        $user->setEmail('2binfree@gmail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($encoded);
        $manager->persist($user);

        $user = new User();
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setUsername('admin');
        $user->setEmail('laurent@revealers.co');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($encoded);
        $manager->persist($user);

        $manager->flush();

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}