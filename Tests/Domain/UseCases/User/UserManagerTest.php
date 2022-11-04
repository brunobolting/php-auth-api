<?php

declare(strict_types=1);

namespace Test\Domain\UseCases\User;

use Domain\UseCases\User\UserManager;
use Infrastructure\Repository\UserInMemoryRepository;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

final class UserManagerTest extends TestCase
{
    private \PDO $pdo;

    public function setUp(): void
    {
        $pdo = new \PDO('sqlite::memory:', null, null, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]);
        $rootPath = '../../../..';
        $configArray = require("$rootPath/phinx.php");
        $configArray['paths']['migrations'] = "$rootPath/database/migrations";
        $configArray['paths']['seeds'] = "$rootPath/database/seeds";
        $configArray['environments']['test'] = [
            'adapter'    => 'sqlite',
            'connection' => $pdo
        ];
        $config = new Config($configArray);
        $manager = new Manager($config, new StringInput(' '), new NullOutput());
        $manager->migrate('test');
        $manager->seed('test');
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->pdo = $pdo;
    }

    public function testCreateUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository($this->pdo);
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $this->assertFalse($user->hasErrors());
        $this->assertNotNull($user->getID());
    }

    public function testGetUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository($this->pdo);
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $userFound = $manager->getUser($user->getID());
        $userNotFound = $manager->getUser('random-key');

        $this->assertNotNull($userFound);
        $this->assertNull($userNotFound);
        $this->assertEquals($user->getID(), $userFound->getID());
    }

    public function testUpdateUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository($this->pdo);
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $user->setNickname('anothernickname');
        $userUpdated = $manager->updateUser($user);

        $this->assertFalse($userUpdated->hasErrors());
        $this->assertEquals('anothernickname', $userUpdated->getNickname());
    }

    public function testDeleteUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository($this->pdo);
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');

        $this->assertTrue($manager->deleteUser($user->getID()));
        $this->assertNull($manager->getUser($user->getID()));
    }

    public function testFindUserShouldBeWork()
    {
        $repo = new UserInMemoryRepository($this->pdo);
        $manager = new UserManager($repo);

        $user = $manager->createUser('test@email.com', 'brunobolting', 'mystrongpassword');
        $user2 = $manager->createUser('test2@email.com', 'anothernickname', 'mystrongpassword');

        $usersFound = $manager->findUser(['nickname' => 'anothernickname', 'email' => 'test2@email.com']);
        $usersNotFound = $manager->findUser(['nickname' => 'nickname']);

        $this->assertCount(1, $usersFound);
        $this->assertCount(0, $usersNotFound);
    }
}
