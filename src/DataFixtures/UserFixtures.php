<?php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

	public function load(ObjectManager $manager)
	{

		$userEnabled = new User();
        $userEnabled->setUsername('user_enabled');
        $userEnabled->setEmail('user_enabled@test.fr');
        $userEnabled->setPassword($this->passwordEncoder->encodePassword($userEnabled, 'test'));
		$manager->persist($userEnabled);

        $userDisabled = new User();
        $userDisabled->setUsername('user_disabled');
        $userDisabled->setEmail('user_disabled@test.fr');
        $userDisabled->setIsActive(false);
        $userDisabled->setPassword($this->passwordEncoder->encodePassword($userDisabled, 'test'));
		$manager->persist($userDisabled);

		$admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@test.fr');
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'test'));
        $admin->setRoles(['ROLE_ADMIN']);
		$manager->persist($admin);

		$manager->flush();
	}
}
