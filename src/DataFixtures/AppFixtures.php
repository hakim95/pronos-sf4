<?php

namespace App\DataFixtures;

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
		foreach ($this->getUserData() as [$name, $username, $password, $email, $roles]) {
			$user = new User();
			$user->setName($name);
			$user->setUsername($username);
			$user->setPassword($this->passwordEncoder->encodePassword($user, $password));
			$user->setEmail($email);
			$user->setRoles($roles);

			$manager->persist($user);
			$this->addReference($username, $user);
		}

		$manager->flush();
	}

	private function getUserData()
	{
		return [
			['Hakim', 'hak95', 'test1234', 'hakim.lahiani@digitaslbi.fr', ['ROLE_ADMIN']],
			['Kevin', 'kevin75', 're2df5', 'kevin.tutala@digitaslbi.fr', ['ROLE_USER']],
			['Nicolas', 'niconico', 'nic442', 'nicolas.thevenin@digitaslbi.fr', ['ROLE_USER']],
		];
	}
}