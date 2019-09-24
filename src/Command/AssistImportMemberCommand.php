<?php

namespace App\Command;

use App\Service\CompetitionManager;
use App\Service\MemberManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

class AssistImportMemberCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:assist:import-member';
    private $memberManager;
    private $competitionManager;
    private $em;

    public function __construct(MemberManager $memberManager, CompetitionManager $competitionManager, EntityManagerInterface $em)
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->memberManager = $memberManager;
        $this->competitionManager = $competitionManager;
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Import a member from Assist.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command imports a member given an escaped csv memberlist of Assist.
A new member is created only if it does not yet exist (given the memberId).

Dates are formatted dd/mm/yyyy (format d/m/Y).

CSV lines are processed by php fgetcsv with default parameters (comma separated: \",\", '\"' , '\"').
No escaping is required converting the .xls to .csv.

"
            )

            ->addArgument('csv_file', InputArgument::REQUIRED, 'An escaped csv memberlist by Assists')
            ->addOption('skip', 's', InputOption::VALUE_OPTIONAL, 'Number of header lines to skip.', 1 )
            ->addOption('test', 't', InputOption::VALUE_NONE, 'Test without persisting members.' )
            ->addOption('debug', 'd', InputOption::VALUE_NONE, 'Print feedback.' )
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Assist Member Import',
            '====================',
            '',
        ]);

        $cnt = -abs( (int) $input->getOption('skip') );
        $new = 0;
        $upd = 0;

        $persist = ! $input->getOption('test');
        $debug = $input->getOption('debug');

        // Open the file for reading
        if ( ($h = fopen($input->getArgument('csv_file'), "r")) !== false ) 
        {
            // Convert each line into the local $data variable
            while ( ($data = fgetcsv($h, 0, ",", '"' , '"')) !== false ) 
            {
                $cnt++;
                if ($cnt <= 0 ) continue;

                if ($debug) $output->writeln(print_r($data));

                // extract and convert?
                $memberId = (int) $data[0];
                $since = \DateTime::createFromFormat('d/m/Y',$data[1]);
                $firstname = $data[2];
                $lastname = $data[3];
                $street = $data[5];
                $zip = $data[6];
                $town = $data[7];
                $nation = strtoupper(substr($data[9],0,3)) === 'NED' ? 'NL' : 'BE'; // Netherlands otherwise Belgium
                $email = $data[14];
                $birthdate = \DateTime::createFromFormat('d/m/Y',$data[17]);
                $gender = strtoupper(substr($data[19],0,1)) === 'M' ? 'M' : 'F';
                $registrationId = $data[31];

                if ($memberId === 0) continue;

                if ($member = $this->memberManager->findMemberById($memberId))
                {
                    $output->write(sprintf('%s %s exists with id:%d and memberId: %d.',
                        $member->getFirstname(),
                        $member->getLastname(),
                        $member->getId(),
                        $member->getMemberId()
                    ));
                    if ($member->getRegistrationId() !== $registrationId ) {
                        $upd++;
                        $member->setRegistrationId();
                        $this->competitionManager->verifyMemberEnrolments($member);
                        $output->write(sprintf(' registrationId updated to %s.', $registrationId));
                    }
                    $output->writeln('');

                } else {

                    $new++;

                    $address = $this->memberManager->createAddress($street, $zip, $town, $nation);

                    $member = $this->memberManager->createMember(
                        $memberId, $firstname, $lastname, $gender, $birthdate, $registrationId, $since, $address
                    );

                    if ($persist)
                    { 
                        $this->em->persist($address);
                        $this->em->persist($member);

                        $this->em->flush();
                    }

                    $output->writeln(sprintf('%s %s created with id:%d and memberId: %d.',
                        $member->getFirstname(),
                        $member->getLastname(),
                        $member->getId(),
                        $member->getMemberId()
                    ));

                }

            }

            // Close the file
            fclose($h);
        }

        $output->writeln('');
        $output->writeln(sprintf('%d members found from assist of which %d imported and %d updated.', $cnt, $new, $upd));

    }
}
