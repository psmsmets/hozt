<?php

namespace App\Command;

use App\Service\CalendarManager;
use App\Service\CompetitionManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CronCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:cron';
    private $calendarManager;

    public function __construct(CalendarManager $calendarManager, CompetitionManager $competitionManager)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->calendarManager = $calendarManager;
        $this->competitionManager = $competitionManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Run the cleanup and notification tasks for cron scheduling .')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command executes the cron scheduled cleanup and notification tasks.')
            //->addOption('password', 'p', InputOption::VALUE_OPTIONAL, 'The user password (must be valid!).', null )
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Cron tasklist',
            '============',
            '',
        ]);

        // Archive old calendar items  
        $output->write('Archive past calendar items... ');
        $success = $this->calendarManager->autoArchive();
        $output->writeln($this->calendarManager->getExitMessage());

        // Cleanup competition documents  
        $output->write('Cleanup competition documents... ');
        $success = $this->competitionManager->autoCleanup();
        $output->writeln($this->competitionManager->getExitMessage());


        // Tryout reminders

        // Competition notifications 

    }
}
