<?php

namespace App\Command;

use App\Service\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->userManager = $userManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            ->addArgument('firstname', InputArgument::REQUIRED, 'The first name of the user.')
            ->addArgument('lastname', InputArgument::REQUIRED, 'The last or family name of the user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('mobile', InputArgument::REQUIRED, 'The mobile phone of the user.')
            ->addOption('roles', 'r', InputOption::VALUE_REQUIRED, 'The role(s) of the user, comma separated.')
            ->addOption('verified', 'i', InputOption::VALUE_OPTIONAL, 'The user verification status.', false )
            ->addOption('password', 'p', InputOption::VALUE_OPTIONAL, 'The user password (must be valid!).', null )
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);


        // create the user
        $user = $this->userManager->create(
            $firstname = $input->getArgument('firstname'),
            $lastname = $input->getArgument('lastname'),
            $email = $input->getArgument('email'),
            $mobile = $input->getArgument('mobile'),
            $roles = explode(',', $input->getOption('roles')),
            $plainpassword = $input->getOption('password'),
            $verified = $input->getOption('verified')
        );

        $output->writeln($this->userManager->getExitMessage());

        if ($user)
        {
          $output->writeln('Id         : '.$user->getId());
          $output->writeln('First name : '.$user->getFirstname());
          $output->writeln('Last name  : '.$user->getLastname());
          $output->writeln('Email      : '.$user->getEmail());
          $output->writeln('Mobile     : '.$user->getMobilePhone());
          $output->writeln('Role(s)    : '.implode(' ',$user->getRoles()));
          $output->writeln('Enabled    : '. (int) $user->isEnabled());
          $output->writeln('Verified   : '. (int) $user->isVerified());

          if ($this->userManager->isPasswordValid($input->getOption('password'))) {
            $output->writeln('You can now log in with the given credentials.');
          } else {
            $output->writeln('The given password was not valid. Reset the password manually.');
          }
          
        }

    }
}
