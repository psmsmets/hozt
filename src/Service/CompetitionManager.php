<?php

namespace App\Service;

use App\Entity\Competition;
use App\Entity\CompetitionDocument;
use App\Repository\CompetitionRepository;
use App\Repository\CompetitionDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class CompetitionManager 
{
    private $entityManager;
    private $competitionRepository;
    private $competitionDocsRepository;
    private $exitMessage;
    private $documentsBase;

    public function __construct($publicDir, $competitionDocumentsDir, EntityManagerInterface $entityManager, CompetitionRepository $competitionRepository, CompetitionDocumentRepository $competitionDocumentRepository )
    {
        $this->entityManager = $entityManager;
        $this->competitionRepository = $competitionRepository;
        $this->competitionDocumentRepository = $competitionDocumentRepository;
        $this->dir = ltrim(rtrim($publicDir, '/'), '/') .'/'. ltrim(rtrim($competitionDocumentsDir, '/'), '/');
        $this->exitMessage = null;
    }

    public function autoCleanup(): ?bool
    {
        $filesystem = new Filesystem();
        $cnt_doc = 0;
        $cnt_rem = 0;
        $docs = $this->competitionDocumentRepository->findPastCompetitionDocuments();
        $reftime = new \DateTimeImmutable('today midnight');

        foreach( $docs as $doc) {
            $cat = $doc->getCategory();
            if ( !$cat->getAutoCleanup() ) continue;

            $endTime = $doc->getCompetition()->getCalendar()->calcEndTime();
            if ($reftime->modify(sprintf("- %d days", $cat->getCleanupDelay())) <= $endTime) continue;

            $cnt_doc++;
            
            if ($file = $doc->getDocument()) {
                $fullfile = sprintf('%s/%s', $this->dir, $file);
                if ($filesystem->exists($fullfile)) {
                    $filesystem->remove($fullfile);
                    $this->entityManager->remove($doc);
                    $cnt_rem++;
                }
            } else {
                $this->entityManager->remove($doc);
                $cnt_rem++;
            }
        }
        $this->entityManager->flush();
        $this->exitMessage = sprintf('Done. Removed %d/%d documents.', $cnt_rem, $cnt_doc);
        return true;
    }

    public function getExitMessage(): ?string
    {
        return $this->exitMessage;
    }

}