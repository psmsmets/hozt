<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

# entities
use App\Entity\TrainingTeam;
use App\Entity\TrainingTeamCategory;
use App\Entity\TrainingSchedule;
use App\Entity\TrainingException;
use App\Entity\CalendarEvent;
use App\Entity\CalendarCategory;
use App\Entity\Competition;
use App\Entity\CompetitionEnrolments;
use App\Entity\CompetitionDocument;
use App\Entity\CompetitionDocumentCategory;
use App\Entity\Tryout;
use App\Entity\Member;
use App\Entity\MemberAddress;
use App\Entity\MemberGrouping;
use App\Entity\User;
use App\Entity\UserDetails;

# repositories
use App\Repository\TryoutEnrolmentRepository;
use App\Repository\TryoutRepository;
use App\Repository\MemberRepository;
use App\Repository\MemberGroupingRepository;

# forms
use App\Form\MemberAddressForm;
use App\Form\UserDetailsForm;
use App\Form\UserNameForm;
use App\Form\UserEmailForm;
use App\Form\UserMobilephoneForm;

# managers
use App\Service\CalendarManager;
use App\Service\CompetitionManager;
use App\Service\UserManager;
use App\Service\MemberManager;
use App\Service\ScheduleManager;

class ApiController extends AbstractController
{
    protected $requestStack;
    private $security;
    private $em;
    private $now;
    private $translator;
    private $calendarManager;
    private $competitionManager;

    public function __construct(RequestStack $requestStack, Security $security, EntityManagerInterface $em, TranslatorInterface $translator, CalendarManager $calendarManager, CompetitionManager $competitionManager )
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->em = $em;
        $this->now = new \DateTime('now');
        $this->translator = $translator;
        $this->calendarManager = $calendarManager;
        $this->competitionManager = $competitionManager;
    }

    /**
     * @Route("/api/session/timeout", name="api_session_timeout")
     */
    public function api_session_timeout()
    {
        $user = $this->security->getUser();

        return $this->json(array(
            'success' => !is_null($user), 
            'elapsed' => (new \DateTime())->getTimestamp() - $this->security->getUser()->getLastActiveAt()->getTimestamp() 
        ));
    }

    /**
     * @Route("/api/session/keep-alive", name="api_session_keepalive")
     */
    public function api_session_keepalive()
    {
        return $this->json(['success' => true]);
    }

    /**
     * @Route("/api/trainingsuren", name="api_training_schedule")
     */
    public function api_training_schedule(Request $request, ScheduleManager $scheduleManager, CalendarManager $calendarManager)
    {
        $year = (int) $request->query->get('year', null);
        $week = (int) $request->query->get('week', null);

        $startOfWeek = $calendarManager->startOfWeek($year, $week);

        $teams = $request->query->get('teams', null);
        $teams = (is_null($teams) or trim($teams) === '') ? null : explode( ',', strtoupper($teams) );

        $anonymous = (bool) $request->query->get('anonymous', null);

        // init teams if user is logged in and has swimming members

        return $this->json([
            'success' => true,
            'teams' => $teams,
            'html' => $this->render('training/schedule_week.html.twig', [
                    'startOfWeek' => $startOfWeek,
                    'weekSchedule' => $scheduleManager->weekSchedule($startOfWeek, $teams, $anonymous ? null : $this->security->getUser()),
                ])->getContent(),
            ]);
    }

    /**
     * @Route("/api/training/vandaag", name="api_training_today")
     */
    public function api_training_today()
    {
        $refdate = (new \DateTime('today midnight'));

        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllOnDate($refdate)
            ;

        $exceptions = $this->getDoctrine()
            ->getRepository(TrainingException::class)
            ->findAllOnDate($refdate)
            ;

        $data = $this->serialize_training_schedule($schedule, $exceptions, $refdate);

        if (!$data) {
            return $this->json(array('result'=>false,'error'=>'Er is vandaag geen training.'));
        } else {
            return $this->json(array('result'=>true,'data'=>$data));
        }

    }

    /**
     * @Route("/api/training/morgen", name="api_training_tomorrow")
     */
    public function api_training_tomorrow()
    {
        $refdate = (new \DateTime('today midnight'))->modify('+1 day');

        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllOnDate($refdate)
            ;

        $exceptions = $this->getDoctrine()
            ->getRepository(TrainingException::class)
            ->findAllOnDate($refdate)
            ;

        $data = $this->serialize_training_schedule($schedule, $exceptions, $refdate);

        if (!$data) {
            return $this->json(array('result'=>false,'error'=>'Er is morgen geen training.'));
        } else {
            return $this->json(array('result'=>true,'data'=>$data));
        }

    }

    private function serialize_training_schedule(array $schedule, array $exceptions, \DateTimeInterface $refdate): array
    {
        $data = array();

        foreach ($schedule as $training) {

            $teams = $training->getTeams();

            $exceptions = $training->getActiveExceptions($refdate);

            if (count($exceptions)>0) {

                $teams = $teams->filter(
                    function(TrainingTeam $team) use ($exceptions) {
                        $teamsExs = $team->getExceptions();
                        foreach ($exceptions as $ex) {
                            if ($teamsExs->contains($ex)) return false;
                        }
                        return true;
                    }
                );

            }

            $teams = $teams->filter(
                function(TrainingTeam $team) use ($refdate, $exceptions, $schedule) {
                    return count($team->getActiveExceptions($refdate, true)) == 0; // keep if no exceptions
                }
            );

            if (count($teams)>0) {
                $teamData = [];
                foreach ( $teams as $team ) {
                    $teamData[] = array ('abbr' => $team->getAbbr(), 'name' => $team->getName() );
                }
                $data[] = array( 
                    'time' => strval($training->getTime()),
                    'comment' => $training->getComment(), 
                    'teams' => $teamData,
                );
            }

        }
        return $data;
    }

    /**
     * @Route("/api/training/{team_abbr}", name="api_training_team")
     */
    public function api_training_team($team_abbr)
    {
        $team = $this->getDoctrine()
            ->getRepository(TrainingTeam::class)
            ->findOneBy(
                ['enabled' => true, 'abbr' => $team_abbr  ]
            );

        if (!$team) return $this->json(
            array( 
                'result' => false,
                'error' => 'Zwemgroep '.strtoupper($team_abbr).' niet gevonden.' 
            )
        );

        $training = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findTrainingScheduleByTeam($team->getId());

        if (!$training)
        {
            return $this->json(array('result'=>false,'error'=>'Geen trainingen gevonden.'));
        }

        $tmp = array(); // todo: make serializer!

        foreach ($training as $t)
        {
            $key = strval($t->getDay());
            $val = array( "time" => strval($t->getTime()), "comment" => $t->getComment());
            if (!isset($tmp[$key])) {
                $tmp[$key] = array();
            }
            $tmp[$key][] = $val;
        }
        return $this->json(array('result'=>true,'data'=>$tmp));

    }

    /**
     * @Route("/api/kalender/aanstaande/{count}", name="api_calender_events")
     */
    public function api_calender_events(int $limit=7)
    {
        $events = $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findUpcomingCalendarEvents($limit)
            ;
        if (!$events) {
            return $this->json(array( 'result' => true, 'data' => [] ));
        }

        $data = array();
        foreach ( $events as $event ) {
           $data[] = array(
                   'title' => ucfirst($event->getTitle()),
                   'day' => $event->getStartTime()->format('d'),
                   'month' => strftime("%b", $event->getStartTime()->getTimestamp()),
                   'formattedPeriod' => $event->getFormattedPeriod(),
                   'location' => ucfirst($event->getLocation()),
                   'class' => 'cal-'.strval($event->getCategory()->getSequence()),
                   'cancelled' => $event->getCancelled(),
                   'uuid' => $event->getUuid(),
                   'url' => $this->get('router')->generate('calendar_event', array('uuid' => $event->getUuid())),
               );
        }
        return $this->json(array( 'result' => true, 'data' => $data ));
    }

    /**
     * @Route("/api/documenten/wedstrijden/aanstaande/{slug}/{limit}", name="api_documents_competition_upcoming")
     */
    public function api_documents_competition_upcoming(string $slug, int $limit=5)
    {
        $docs = $this->getDoctrine()
            ->getRepository(CompetitionDocument::class)
            ->findUpcomingCompetitionDocuments($slug,$limit)
            ;

        if (!$docs) return $this->json(array('result'=>false,'error'=>"Geen documenten gevonden."));

        $data = array();
        $base = $this->getParameter('app.path.doc.competition');
        foreach ( $docs as $doc ) {
           $event = $doc->getCompetition()->getCalendar();
           $data[] = array(
                   'title' => (is_null($doc->getDescription())) ? $event->getTitle() : $event->getTitle() . " - " . $doc->getDescription(),
                   'date' => $event->getStartTime()->format('Y-m-d'),
                   'datestr' =>  strftime("%e %b", $event->getStartTime()->getTimestamp()),
                   'location' => $event->getLocation(),
                   'doc' => (is_null($doc->getDocument())) ? $doc->getUrl() : $base.'/'.$doc->getDocument(),
               );
        }
        return $this->json(array( 
                'result' => true, 
                'category' => $doc->getCategory()->getTitle(), 
                'type' => 'upcoming', 
                'data' => $data,
            ));
    }

    /**
     * @Route("/api/documenten/wedstrijden/laatste/{slug}/{limit}", name="api_documents_competition_latest")
     */
    public function api_documents_competition_latest(string $slug, int $limit=5)
    {
        $events = $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findCalendarEventByByLatestCompetitionDocuments($slug,$limit)
            ;
        if (!$events) return $this->json(array('result'=>false,'error'=>"Geen documenten gevonden."));

        $data = array();
        foreach ( $events as $e ) {
            $event = $e[0];
            $data[] = array(
                    'title' => $event->getTitle(),
                    'date' => $event->getStartTime()->format('Y-m-d'),
                    'datestr' =>  strftime("%e %b", $event->getStartTime()->getTimestamp()),
                    'location' => $event->getLocation(),
                    'url' => $this->generateUrl('calendar_event',['uuid'=>$event->getUuid()]),
                );
        }
        return $this->json(array( 
                'result' => true, 
                'category' => $slug, 
                'type' => 'latest', 
                'data' => $data,
            ));
    }

    /**
     * @Route("/api/ingeschreven/testmoment/{uuid}", name="api_enrolled_tryout")
     */
    public function api_enrolled_tryout(string $uuid, TryoutEnrolmentRepository $TryoutEnrolRep)
    {
        if (!$this->isGranted('ROLE_ADMIN')) return $this->json(array('content' => false));
        
        if ($enrols = $TryoutEnrolRep->findEnrolments($uuid)) {   
            return $this->json( $this->render(
                    'tryout/enrolleddata.html.twig', 
                    ['enrolments' => $enrols, 'uuid' => $uuid ]
                ));
        } else {
            return $this->json(array('content' => false));
        }
    }

    /**
     * @Route("/api/herinnering/testmoment/{uuid}", name="api_reminder_tryout")
     */
    public function api_reminder_tryout(string $uuid, TryoutRepository $TryoutRep, \Swift_Mailer $mailer )
    {
        if (!$this->isGranted('ROLE_ADMIN')) return $this->json(array(
                'success' => false, 
                'message' => 'Je bent niet gemachtigd', 
            ));
        
        if ($tryout = $TryoutRep->findTryout($uuid)) {

          if ($tryout->getReminderSent()) return $this->json(array(
                  'success' => false, 
                  'message' => 'Herinneringen zijn alreeds verzonden', 
                  'reminderSent' => $tryout->getReminderSent(), 
                  'reminderSentAt' => $tryout->getReminderSentAt())
              );

          foreach( $tryout->getEnrolments() as $enrol ) {

            $message = (new \Swift_Message())
                ->setSubject('Herinnering HoZT testmoment')
                ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
                ->setTo($enrol->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/tryout_reminder.html.twig', [ 'enrol' => $enrol ]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
          }

          $tryout->setReminderSent(true);
          $this->em->persist($tryout);
          $this->em->flush();

          return $this->json(array(
                  'success' => true, 
                  'message' => 'Herinneringen verzonden', 
                  'reminderSent' => $tryout->getReminderSent(), 
                  'reminderSentAt' => $tryout->getReminderSentAt(),
              ));

        } else {

          return $this->json(array(
                  'success' => false, 
                  'message' => 'Ongeldige tryout uuid', 
              ));

        }
    }

    /**
     * @Route("/api/private/membership/preferences", name="api_membership_preferences")
     */
    public function api_membership_preferences(Request $request, UserPasswordEncoderInterface $encoder, MemberManager $memberManager)
    {
        if ($request->query->get('format', null) !== 'json') return $this->json(['success' => false]);

        $tabs = ['members','address','notifications','user'];
        $tab = (string) $request->query->get('tab', null);
        if (!in_array($tab,$tabs)) $tab = $tabs[0];

        $action = $request->query->get('action', null);
        $edit = $action == 'edit';
        $new = $action == 'new';

        if ($action == 'load')
        {
            return $this->json([
                'success' => true,
                'html' => $this->render(sprintf('membership/preferences_%s.html.twig', $tab), ['tab' => $tab])->getContent(),
            ]);
        }
        if (!($edit or $new)) return $this->json([ 'success' => false, 'html' => null ]);

        $forms = ['member_address_form','user_details_form','user_name_form','user_email_form','user_mobilephone_form'];
        $formName = (string) $request->query->get('form', null);
        if (!in_array($formName,$forms)) return $this->json(['success' => false]);

        $form = null;
        $formSuccess = false;

        $user = $this->security->getUser();
        $id = (int) $request->query->get('id', null);

        if ( $tab == 'address' )
        {
            $address = $new ? new MemberAddress($user) : $user->getMemberAddress($id);

            if (!$address instanceof MemberAddress) return $this->json(['success' => false]);

            $form = $this->createForm(MemberAddressForm::class, $address);
            $form->handleRequest($request);

            if ($formSuccess = ($form->isSubmitted() && $form->isValid()))
            {
                if ($new) {
                    $address = $form->getData();
                    $address->setUser($this->security->getUser());
                    $this->em->persist($address);
                }
                $memberManager->setAddress($address);
                $memberManager->removeOrphantAddresses($user);
            }
        }
        elseif ( $tab == 'notifications' )
        {
            $details = $user->getDetails();
            $form = $this->createForm(UserDetailsForm::class);

            $form->handleRequest($request);

            if ($formSuccess = ($form->isSubmitted() && $form->isValid()))
            {
                $formData = $form->getData();

                $details->setSecondaryEmail($formData['secondaryEmail']);
                $details->setNotificationDays($formData['notificationDays']);
                $details->setReminderOffset($formData['reminderOffset']);
            } else {
                $form->get('secondaryEmail')->setData($details->getSecondaryEmail());
                $form->get('notificationDays')->setData($details->getNotificationDays());
                $form->get('reminderOffset')->setData($details->getReminderOffset());
            }
        }
        elseif ( $tab == 'user' )
        {
            switch ($formName) {
                case "user_name_form":
                    $form = $this->createForm(UserNameForm::class);
                    break;
                case "user_email_form":
                    $form = $this->createForm(UserEmailForm::class);
                    break;
                case "user_mobilephone_form":
                    $form = $this->createForm(UserMobilephoneForm::class);
                    break;
                default:
                    return $this->json(['success' => false]);
            }
            $form->handleRequest($request);

            if ( $formSuccess = ($form->isSubmitted() && $form->isValid()) )
            {
                $formData = $form->getData();

                if (!$encoder->isPasswordValid($user, $formData['plainPassword']))
                {
                    return $this->json([
                        'success' => false,
                        'message' => $this->translator->trans('password.wrong'),
                    ]);
                }
                switch ($formName) {
                    case "user_name_form":
                        $user->setFirstname($formData['firstname']);
                        $user->setLastname($formData['lastname']);
                        break;
                    case "user_email_form":
                        if ( $form['currentEmail']->getData() === $user->getEmail() ) $user->setEmail($form['newEmail']->getData());
                        break;
                    case "user_mobilephone_form":
                        if ( $form['currentMobilephone']->getData() === $user->getMobilephone() ) 
                            $user->setMobilephone($form['newMobilephone']->getData());
                        break;
                }
            } else {
                if ($formName == 'user_name_form') {
                    $form->get('firstname')->setData($user->getFirstname());
                    $form->get('lastname')->setData($user->getLastname());
                }
            }
        }
        if ($form) {
            if ($formSuccess) {
                $this->em->flush();
                return $this->json([
                    'success' => true,
                    'message' => $this->translator->trans(sprintf('preferences.%s.%s.success', $tab, $action )),
                    'redirect' => $user->getEmailChanged() ? '/logout' : null,
                ]);
            }
            return $this->json([
                'success' => true,
                'html' => $this->render('membership/preferences_form.html.twig', [
                    'tab' => $tab,
                    'formName' => $formName,
                    'action' => $action,
                    'url' => $this->generateUrl('api_membership_preferences',
                           [ 'tab' => $tab, 'form' => $formName, 'format' => 'json', 'action' => $action, 'id' => $id ]),
                    'form' => $form->createView(),
                ])->getContent(),
            ]);
        }
        return $this->json([ 'success' => false, 'html' => null ]); // catch
    }

    /**
     * @Route("/api/private/membership/competitions", name="api_membership_competitions")
     */
    public function api_membership_competitions(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $json = $request->query->get('format', null) == 'json';
        $action = $request->query->get('action', null);

        $load = $action == 'load';
        $edit = $action == 'edit';

        if ($json and $load)
        {
            $enrolments = $this->competitionManager->getUserEnrolments( 
                $this->security->getUser(), 
                $this->calendarManager->getPeriodStart(), 
                $this->calendarManager->getPeriodEnd()
            );
            $data = array();
            foreach ($enrolments as $enrolment) {
                if ($enrolment->isEnabled()) {
                    $data[] = array(
                        'member' => $enrolment->getMember()->getId(),
                        'enrolment' => $enrolment->getId(),
                        'competitionpart' => $enrolment->getCompetitionPart()->getId(),
                        'enrolled' => $enrolment->getEnrolled(),
                        'enrolledAt' => $enrolment->getEnrolledAt(),
                        'new' => is_null($enrolment->getEnrolledAt()),
                        'editable' => $enrolment->getCompetitionPart()->getCompetition()->getEnrolBefore() > $this->now,
                    );
                }
            }
            return $this->json([ 'success' => true, 'data' => $data ]);
        }
        elseif ($json and $edit)
        {
            $competitionpart = (int) $request->query->get('competitionpart', null);
            $member = (int) $request->query->get('member', null);
            $enrolled = $request->query->get('enrolled', null);

            if (!is_null($enrolled) and $competitionpart > 0 and $member > 0) {
                return $this->json([
                    'success' => $this->competitionManager->toggleCompetition(
                        $this->security->getUser(), $competitionpart, $member, (bool) $enrolled
                    )
                ]); 
            }
        }
        return $this->json([ 'success' => false ]); //catch
    }

    /**
     * @Route("/api/private/sportadmin/competition/{id}", name="api_sportadmin_competition")
     */
    public function api_sportadmin_competition(int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $enrolments = $this->competitionManager->getCompetitionEnrolments($id);

        $data = array();
        foreach ($enrolments as $enrolment) {
            if ($enrolment->isEnabled()) {
                $data[] = array(
                    'member' => $enrolment->getMember()->getId(),
                    'enrolment' => $enrolment->getId(),
                    'competitionpart' => $enrolment->getCompetitionPart()->getId(),
                    'enrolled' => $enrolment->getEnrolled(),
                    'enrolledAt' => $enrolment->getEnrolledAt(),
                    'new' => is_null($enrolment->getEnrolledAt()),
                    'enabled' => $enrolment->isEnabled(),
                );
            }
        }
        return $this->json([ 'success' => true, 'data' => $data ]);
    }

}
