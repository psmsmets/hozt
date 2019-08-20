<?php

namespace App\Tests\Command;

use App\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:create-user');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),

            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'email' => 'jane@doe.web',
            'mobile' => '0032412345678',
            '--roles' => 'ROLE_USER',
            '--password' => 'Cre8Test!',
            '--verified' => true,

        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('New user created', $output);

        // ...
    }
}
