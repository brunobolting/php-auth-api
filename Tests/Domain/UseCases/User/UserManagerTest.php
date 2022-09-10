<?php

declare(strict_types=1);

namespace Test\Domain\UseCases\User;

use Domain\UseCases\User\UserManager;
use Infrastructure\Repository\UserInMemoryRepository;
use PHPUnit\Framework\TestCase;

final class UserManagerTest extends TestCase
{
    public function testCreateUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository();
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $this->assertFalse($user->hasErrors());
        $this->assertNotNull($user->ID);
    }

    public function testGetUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository();
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $userFound = $manager->getUser($user->ID);
        $userNotFound = $manager->getUser('random-key');

        $this->assertNotNull($userFound);
        $this->assertNull($userNotFound);
        $this->assertEquals($user->ID, $userFound->ID);
    }

    public function testUpdateUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository();
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $user->nickname = 'anothernickname';
        $userUpdated = $manager->updateUser($user);

        $this->assertFalse($userUpdated->hasErrors());
        $this->assertEquals('anothernickname', $userUpdated->nickname);
    }

    public function testDeleteUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository();
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');

        $this->assertTrue($manager->deleteUser($user->ID));
        $this->assertNull($manager->getUser($user->ID));
    }

    public function testFindUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository();
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $user2 = $manager->createUser('test@email.com', 'anothernickname', 'mystrongpassword');

        $usersFound = $manager->findUser(['nickname' => 'anothernickname']);
        $usersNotFound = $manager->findUser(['nickname' => 'nickname']);

        $this->assertCount(1, $usersFound);
        $this->assertCount(0, $usersNotFound);
    }
}
