<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

# entities
use App\Entity\StaticPage;
use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use App\Entity\CarouselSlide;
use App\Entity\TrainingCoach;
use App\Entity\TrainingTime;
use App\Entity\TrainingTeam;
use App\Entity\TrainingTeamCategory;
use App\Entity\TrainingSchedule;
use App\Entity\TrainingException;
use App\Entity\ContactFaq;
use App\Entity\ContactForm;
use App\Entity\CalendarCategory;
use App\Entity\CalendarEvent;
use App\Entity\Competition;
use App\Entity\CompetitionState;
use App\Entity\Sponsor;
use App\Entity\SponsorCategory;
use App\Entity\Clubfeest;
use App\Entity\TryoutEnrolment;
use App\Entity\Tryout;
use App\Entity\Member;
use App\Entity\MemberAddress;
use App\Entity\MemberGrouping;

# repositories
use App\Repository\TryoutEnrolmentRepository;
use App\Repository\TryoutRepository;
use App\Repository\MemberRepository;
use App\Repository\MemberGroupingRepository;

# forms
use App\Form\ContactFormType;
use App\Form\ClubfeestType;
use App\Form\TryoutEnrolmentForm;
use App\Form\MemberAddressForm;

class PageController extends AbstractController
{
    private $template_data;
    protected $requestStack;
    private $security;
    private $now;
    private $em;
    private $translator;

    public function __construct(RequestStack $requestStack, Security $security, EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->template_data = [];
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->em = $em;
        $this->translator = $translator;
        $this->now = new \DateTime('now');
    }

    private function initTemplateData()
    {
        $this->template_data = [];
        $this->addToTemplateData( 
            'training_team_categories', 
            $this->getDoctrine()
                ->getRepository(TrainingTeamCategory::class)
                ->findAllEnabled(), 
            'base'
            );
        $this->addToTemplateData( 
            'sponsors', 
            $this->getDoctrine()
                ->getRepository(Sponsor::class)
                ->findAllActiveCoreSponsors(), 
            'base'
            );
        $this->addToTemplateData( 
            'nofteams', 
            $this->getDoctrine()
                ->getRepository(TrainingTeam::class)
                ->countEnabled(), 
            'base'
            );
        $this->addToTemplateData( 
            'nofcoaches', 
            $this->getDoctrine()
                ->getRepository(TrainingCoach::class)
                ->countEnabled(), 
            'base'
            );

        if ($exceptions = $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->findAllWithTrainingException($this->getParameter('app.defaults.scheduleNotice.days'))
        ) {
            $this->scheduleNotice('exceptions','Eén of meerdere training gaan niet door',$exceptions,'danger');
        }

        if ($persistent = $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->findAllWithPersistentTraining($this->getParameter('app.defaults.scheduleNotice.days'))
        ) {
            $this->scheduleNotice('persistent','Er zijn tijdelijk extra trainingsuren',$persistent,'warning');
        }

    }

    private function scheduleNotice(string $type, string $title, array $categories, string $alert )
    {
        switch ($type) {
            case  'exceptions':
                $data = $this->getDoctrine()->getRepository(TrainingException::class)
                    ->findAll($this->getParameter('app.defaults.scheduleNotice.days'));
                break;
            case  'persistent':
                $data = $this->getDoctrine()->getRepository(TrainingSchedule::class)
                    ->findAllPersistent($this->getParameter('app.defaults.scheduleNotice.days'));
                break;
            default:
                return;
        }
        $check = $this->serialize_notice($data);
        $hash = md5($check);

        $cookie = "scheduleNotice".ucfirst($type);
        $request = $this->requestStack->getCurrentRequest();
        $shown = $request->cookies->has($cookie) ? $request->cookies->get($cookie) : false;

        if ($shown != $hash) {
            $category_data = array();
            foreach ($categories as $cat) {
                $category_data[] = array( 
                    'name' => $cat->getName(),
                    'abbr' => $cat->getAbbr(),
                    'url' => $this->get('router')->generate('training_category', array('slug' => $cat->getSlug())),
                );
            }
            $this->get('session')->getFlashBag()->add(
                'scheduleNotice', 
                array(
                    'type' => $alert, 
                    'title' => $title,
                    'categories' => $category_data,
                    'cookie' => $cookie,
                    'md5' => $hash,
                )
            );
        }
    }

    private function serialize_notice($data)
    {
        $str = '';
        foreach ($data as $dat) {
           $tmp = array(
              'id' => $dat->getId(),
              'createdAt' => $dat->getCreatedAt()->getTimestamp(),
              'updatedAt' => $dat->getUpdatedAt()->getTimestamp(),
           );
           $str .= implode(',', array_map(
               function ($v, $k) { return sprintf("%s=%s", $k, $v); },
                   $tmp,
                   array_keys($tmp)
               )) . ";";
        }
        unset($tmp);
        return $str;
    }

    private function email_flash(bool $sent)
    {
        // twig content??
        if ($sent) { 
            $this->addFlash('success', 'Een bevestigingsmail is verzonden naar het opgegeven e-mail adres.');
        } else {
            $this->addFlash('warning', 'Het is helaas niet gelukt de bevestigingsmail te verzenden.');
        }
    }

    private function addToTemplateData(string $key, $data, string $cat = 'page')
    {
        $this->template_data[$cat][$key] = $data;
    }

    private function pageReturnCookie(string $cookie, Request $request): ?\DateTime
    {
        $lastvisit = null;

        if ($request->cookies->has($cookie)) {
            $lastvisit = new\DateTime;
            $lastvisit->setTimestamp($request->cookies->get($cookie));
        }

        $now = time();

        $response = new Response();
        $response->headers->setCookie(Cookie::create($cookie, $now, (2 * 365 * 24 * 60 * 60) + $now ));
        $response->send();

        return $lastvisit;
    }

    private function pageVisitedCookie(string $cookie, Request $request): bool
    {
        $visited = $request->cookies->has($cookie);

        if (!$visited) {
            $response = new Response();
            $response->headers->setCookie(Cookie::create($cookie, 1, (2 * 365 * 24 * 60 * 60) + $now ));
            $response->send();
        }

        return $visited;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $this->initTemplateData();

        $this->addToTemplateData( 'carousel', $this->getDoctrine()
                ->getRepository(CarouselSlide::class)
                ->findCarouselSlides($this->security->isGranted('ROLE_ADMIN'))
            );

        $this->addToTemplateData( 'pinned_blog_post', $this->getDoctrine()
                ->getRepository(BlogPost::class)
                ->findSpecialPinnedBlogPost()
            );

        $this->addToTemplateData( 'special_blog_posts', $this->getDoctrine()
                ->getRepository(BlogPost::class)
                ->findSpecialBlogPosts($limit = BlogPost::NUMBER_OF_ITEMS_HOMEPAGE)
            );

        return $this->render('page/public.html.twig', $this->template_data);
    }

    /**
     * @Route("/{slug}", name="static_page")
     */
    public function static_page($slug) // page
    {
        $static = $this->getDoctrine()
            ->getRepository(StaticPage::class)
            ->findBySlug($slug);

        if (!$static) throw $this->createNotFoundException();
        if (!$static->getEnabled()) $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->initTemplateData();
        $this->addToTemplateData('static',$static);

        return $this->render('page/static.html.twig', $this->template_data );
    }

    /**
     * @Route("/blog/{id}/{slug}", name="blog_post")
     */
    public function blog_post(int $id, string $slug = null) // article
    {
        $blogPost = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->findBlogPost($id);

        if (!$blogPost) throw $this->createNotFoundException();
        if ($blogPost->getPublishAt()>$this->now or !$blogPost->getEnabled()) $this->denyAccessUnlessGranted('ROLE_ADMIN');
 
        if (is_null($slug) or $slug != $blogPost->getSlug())
        {
            return $this->redirectToRoute('blog_post', ['id' => $id, 'slug' => $blogPost->getSlug() ]);
        }

        $this->initTemplateData();
        $this->addToTemplateData( 'blog_post', $blogPost );

        return $this->render('page/post.html.twig', $this->template_data );
    }

    /**
     * @Route("/blog/{slug}", name="blog_category") // article_category
     */
    public function blog_category(string $slug = null)
    {
        if (!is_null($slug)) {

            $blogCategory = $this->getDoctrine()
                ->getRepository(BlogCategory::class)
                ->findOneBy(
                    ['slug' => $slug, 'enabled' => true ]
                );

            if (!$blogCategory) {
                throw $this->createNotFoundException();
            }

        } else {

            $blogCategory = null;

        }

        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $request = Request::createFromGlobals();

        $page = (int) $request->query->get('pagina', 1);
        $last_page = $repository->getBlogPostPages( $slug );

        $page = $page < 1 ? 1 : $page;
        $page = $page > $last_page ? $last_page : $page;

        $this->initTemplateData();
        $this->addToTemplateData( 'blog_category', $blogCategory );
        $this->addToTemplateData( 
                'blog_posts', 
                $repository->findBlogPosts( $blogCategory, $page, $this->security->isGranted('ROLE_ADMIN') )
            );
        $this->addToTemplateData( 'pagination', 
            ['current' => $page, 'last' => $last_page, 'isfirst' => $page==1, 'islast'=> $page==$last_page]
        );

        return $this->render('page/blog.html.twig', $this->template_data );
    }

    /**
     * @Route("/trainingsuren", name="training_schedule")
     */
    public function training_schedule()
    {
        return $this->redirectToRoute('training_schedule_days');
    }

    /**
     * @Route("/trainingsuren/per-groep", name="training_schedule_teams")
     */
    public function training_schedule_teams()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'training_categories', $this->getDoctrine()
                ->getRepository(TrainingTeamCategory::class)
                ->findAllJoinedToTeamsCoachesSchedule($this->getParameter('app.defaults.scheduleNotice.days'))
            );
        $this->addToTemplateData( 'training_persistent', $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->countPersistent($this->getParameter('app.defaults.scheduleNotice.days'))
        );
        return $this->render('training/scheduleTeams.html.twig', $this->template_data );
    }

    /**
     * @Route("/trainingsuren/per-dag", name="training_schedule_days")
     */
    public function training_schedule_days()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'training_schedule',  $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllJoinedToTeam($this->getParameter('app.defaults.scheduleNotice.days') )
        );
        $this->addToTemplateData( 'training_persistent', $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->countPersistent($this->getParameter('app.defaults.scheduleNotice.days'))
        );

        return $this->render('training/scheduleDays.html.twig', $this->template_data );
    }

    /**
     * @Route("/trainers", name="training_coaches")
     */
    public function training_coaches()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'head_coaches', $this->getDoctrine()
                ->getRepository(TrainingCoach::class)
                ->findAllJoinedToTeams($head=true)
            );
        $this->addToTemplateData( 'coaches', $this->getDoctrine()
                ->getRepository(TrainingCoach::class)
                ->findAllJoinedToTeams($head=false)
            );

        return $this->render('training/coaches.html.twig', $this->template_data );
    }

    /**
     * @Route("/aanbod", name="training_categories")
     */
    public function training_categories()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'training_categories', $this->getDoctrine()
                ->getRepository(TrainingTeamCategory::class)
                ->findAllJoinedToTeamsCoaches()
            );

        return $this->render('training/categories.html.twig', $this->template_data );
    }

    /**
     * @Route("/aanbod/{slug}", name="training_category")
     */
    public function training_category($slug, Request $request)
    {
        $category = $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->findOneBySlug($slug)
            ;
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $this->initTemplateData();
        $this->addToTemplateData( 'lastvisit',
            $this->pageReturnCookie('training_category', $request)
        );
        $this->addToTemplateData( 'training_category', $category );
        $this->addToTemplateData( 'training_schedule',  $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllByTeamCategory($category, $this->getParameter('app.defaults.scheduleNotice.days') )
        );
        $this->addToTemplateData( 'training_team_persistent', $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->countPersistentByTeamCategory($category, $this->getParameter('app.defaults.scheduleNotice.days') )
        );
        $this->addToTemplateData( 'training_team_exceptions', $this->getDoctrine()
            ->getRepository(TrainingException::class)
            ->findAllByTeamCategory($category, $this->getParameter('app.defaults.scheduleNotice.days') ) 
        );
        $this->addToTemplateData( 'competitions', $this->getDoctrine()
            ->getRepository(Competition::class)
            ->findUpcomingCompetitionEventsByTeamCategory($category)
        );
        $this->addToTemplateData( 'results', $this->getDoctrine()
            ->getRepository(Competition::class)
            ->findCompetitionResultsByTeamCategory($category)
        );

        return $this->render('training/category.html.twig', $this->template_data );
    }

    /**
     * @Route("/kalender", name="calendar")
     */
    public function calendar()
    {
        return $this->redirectToRoute('calendar_list', ['year' => $this->getCurrentCalendarYear() ]);
    }

    private function getCurrentCalendarYear(): ?int
    {
        if ($this->now > (new \DateTime('first day of august'))->modify('+ 14 days')) {
            return (int) date('Y');
        } else {
            return (int) date('Y', strtotime(date('Y').' -1 year'));
        }
    }

    /**
     * @Route("/kalender/{year}", name="calendar_list")
     */
    public function calendar_list(int $year = null, Request $request)
    {
        if (is_null($year) or $year < 2016 or $year > 2050 ) {
            return $this->redirectToRoute('calendar_list', ['year' => $this->getCurrentCalendarYear() ]);
        }

        $start = strval($year).'-08-15 00:00';
        $end   = date('Y-m-d H:i', strtotime(strval($year).'-08-15 +1 year'));

        $this->initTemplateData();
        $this->addToTemplateData( 'lastvisit',
            $this->pageReturnCookie('calendar_list', $request)
        );
        $this->addToTemplateData( 'calendar_categories', $this->getDoctrine()
            ->getRepository(CalendarCategory::class)
            ->findAllEnabled()
        );
        $this->addToTemplateData( 'calendar_events', $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findCalendarEvents($start,$end)
        );
        $this->addToTemplateData( 'calendar_period', ['start'=>new \DateTime($start),'end'=>new \DateTime($end)]);

        return $this->render('calendar/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/kalender/{uuid}", name="calendar_event")
     */
    public function calendar_event (string $uuid, Request $request)
    {
        $event = $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findCalendarEvent($uuid)
            ;
        if (!$event) {
            throw $this->createNotFoundException();
            //return $this->redirectToRoute('calendar_list', ['year' => $this->getCurrentCalendarYear() ]);
        }

        $lastvisit = $this->pageReturnCookie('calendar_event_'.$uuid, $request);

        $this->initTemplateData();
        $this->addToTemplateData( 'calendar_event', $event);
        $this->addToTemplateData( 'calendar_posts', $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->findCalenderEventBlogPosts($uuid)
        );

        return $this->render('calendar/event.html.twig', $this->template_data );
    }

    /**
     * @Route("/sponsors", name="sponsors")
     */
    public function sponsors()
    {
        $this->initTemplateData();
        $this->addToTemplateData('sponsor_categories',
            $this->getDoctrine()
                ->getRepository(SponsorCategory::class)
                ->findAllActiveSponsors()
        );

        return $this->render('contact/sponsors.html.twig', $this->template_data );
    }

    /**
     * @Route("/faq", name="contact_faq")
     */
    public function contact_faq()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'faqs', $this->getDoctrine()
                ->getRepository(ContactFaq::class)
                ->findAllEnabled()
            );

        return $this->render('contact/faq.html.twig', $this->template_data );
    }

    /**
     * @Route("/contact", name="contact_form")
     */
    public function contact_form(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $message = (new \Swift_Message('HoZT.be contactformulier'))
                ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
                ->setTo($data['question']->getEmail())
                ->setReplyTo($data['email'])
                ->setBody(
                    $this->renderView(
                        'emails/contactform.html.twig', $data
                    ),
                    'text/html'
                )
            ;
            if ($data['copy']) $message->setBcc($data['email']);

            $result = $mailer->send($message);

            if ($result) { 
                $this->addFlash('success', 'Bericht verzonden! Dankjewel om ons te contacteren.');
            } else {
                $this->addFlash('danger', 'Sorry, er ging iets verkeerd. Controleer of alle velden correct ingevuld zijn en probeer later opnieuw.');
            }

            return $this->redirectToRoute('contact_form');

        }

        $this->initTemplateData();
        $this->addToTemplateData( 'form', $form->createView() );

        return $this->render('contact/form.html.twig', $this->template_data );
    }

    /**
     * @Route("/clubfeest", name="enrol_clubfeest")
     */
    public function enrol_clubfeest(Request $request, \Swift_Mailer $mailer)
    {
        $closure = new \DateTime('2019/03/01 12:00');
        $now = new \DateTime('now');
        $event = $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findCalendarEvent('2f4827db819cc670')
            ;

        $form = $this->createForm(ClubfeestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $now <= $closure) {

            $enrol = $form->getData();

            if ( $enrol->getAdults() == 0 and $enrol->getChildren() == 0 ) {
                $this->addFlash('warning', 'Bijna gelukt, maar je moet toch minstens iemand inschrijven.');
                return $this->redirectToRoute('enrol_clubfeest');
            }

            $message = (new \Swift_Message())
                ->setSubject('Inschrijving HoZT '.$event->getTitle().' '.ucfirst($event->getFormattedPeriod()))
                ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
                ->setTo($enrol->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/clubfeest.html.twig', [ 'enrol' => $enrol, 'event' => $event ]
                    ),
                    'text/html'
                )
            ;
            $sent = $mailer->send($message);
            $enrol->setEmailSent($sent);

            $this->em->persist($enrol);
            $this->em->flush();

            $this->addFlash('success', 'Ingeschreven! We verwachten je '.$event->getFormattedPeriod().'.');

            $this->email_flash($sent);

            return $this->redirectToRoute('enrol_clubfeest');
        }

        $this->initTemplateData();
        $this->addToTemplateData( 'form', $form->createView() );
        $this->addToTemplateData( 'form_closure', $closure );
        $this->addToTemplateData( 'calendar_event', $event );

        return $this->render('enrol/clubfeest.html.twig', $this->template_data );
    }

    /**
     * @Route("/clubfeest/ingeschreven", name="enrolled_clubfeest")
     */
    public function enrolled_clubfeest()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $closure = new \DateTime('2019/03/01 12:00');
        $event = $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findCalendarEvent('2f4827db819cc670')
            ;

        $this->initTemplateData();
        $this->addToTemplateData( 'enrolled',
            $this->getDoctrine()
                ->getRepository(Clubfeest::class)
                ->findAll()
        );
        $this->addToTemplateData( 'form_closure', $closure );
        $this->addToTemplateData( 'calendar_event', $event );

        return $this->render('enrol/enrolled.html.twig', $this->template_data );
    }

    /**
     * @Route("/testmoment/ingeschreven", name="enrolled_tryout")
     */
    public function enrolled_tryout( TryoutRepository $tryoutRep )
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $this->initTemplateData();
        $this->addToTemplateData( 'tryouts', $tryoutRep->findTryouts(21) );

        return $this->render('tryout/enrolled.html.twig', $this->template_data );
    }

    /**
     * @Route("/testmoment", name="enrol_tryout")
     */
    public function enrol_tryout( TryoutRepository $tryoutRep, TryoutEnrolmentRepository $enrolRep, 
         Request $request, \Swift_Mailer $mailer )
    {
        $this->initTemplateData();

        $this->addToTemplateData( 
            'disabled_teams', 
            $this->getDoctrine()->getRepository(TrainingTeam::class)->countDisabled()
        );

        if ($request->query->get('inschrijving', null))
        {

            if ($enrol = $enrolRep->findEnrolment($request->query->get('inschrijving', null)))
            {
                if ( $enrol->getWithdrawn() )
                {
                    $this->addFlash('warning', 'Je hebt je inschrijving voor het testmoment geannuleerd op ' .
                        $enrol->getWithdrawnAt()->format('Y-m-d H:i:s') . '.'
                    );      
                    return $this->redirectToRoute('enrol_tryout');
                }
                elseif ( $request->query->get('withdraw', false) == true and
                     $request->query->get('token', null) == $enrol->getTryout()->getUuid()
                   )
                {
                    if ( $this->now > $enrol->getTryout()->getEnrolUntil() )
                    {
                        $this->addFlash('danger', 'Je bent te laat om je inschrijving nog te annuleren.');      
                        return $this->redirectToRoute('enrol_tryout');
                    }
                    $enrol->setWithdrawn(true);
                    $enrol->getTryout()->nofEnrolmentsSubtractOne();
                    $enrolRep->flush();

                    $message = (new \Swift_Message())
                        ->setSubject('Annulering HoZT testmoment')
                        ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
                        ->setTo($enrol->getEmail())
                        ->setBody(
                            $this->renderView(
                                'emails/tryout_withdraw.html.twig', [ 'enrol' => $enrol ]
                            ),
                            'text/html'
                        )
                    ;
                    $mailer->send($message);

                    $this->addFlash('success', 'Je hebt je inschrijving voor het testmoment geannuleerd.');
                
                    return $this->redirectToRoute('enrol_tryout');
                }

                $this->addToTemplateData( 'enrolment', $enrol );

                return $this->render('tryout/enrolment.html.twig', $this->template_data );
            }

        }

        $tryouts = $tryoutRep->findTryouts();
        $this->addToTemplateData( 'tryouts', $tryouts );

        if (sizeof($tryouts)==0) return $this->render('tryout/waitinglist.html.twig', $this->template_data );

        $active_tryouts = $tryoutRep->countActiveTryouts();
        if ($active_tryouts==0) return $this->render('tryout/form.html.twig', $this->template_data );

        $form = $this->createForm(TryoutEnrolmentForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $enrol = $form->getData();

            if ( $this->now > $enrol->getTryout()->getEnrolUntil() )
            {
                $this->addFlash('danger', 'Je bent te laat om je in te schrijven voor de testmoment.');      
                return $this->redirectToRoute('enrol_tryout');
            }

            $message = (new \Swift_Message())
                ->setSubject('Inschrijving HoZT testmoment')
                ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
                ->setTo($enrol->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/tryout_enrol.html.twig', [ 'enrol' => $enrol ]
                    ),
                    'text/html'
                )
            ;
            $sent = $mailer->send($message);
            $enrol->setEmailSent($sent);
            $enrol->getTryout()->nofEnrolmentsAddOne();

            $this->em->persist($enrol);
            $this->em->flush();

            $this->email_flash($sent);

            return $this->redirectToRoute('enrol_tryout', array('inschrijving'=>$enrol->getUuid()));
        }

        $this->addToTemplateData( 'form', $form->createView() );

        return $this->render('tryout/form.html.twig', $this->template_data );
    }

    /**
     * @Route("/bestuur", name="membergrouping_board")
     */
/*
    public function membergrouping_board( MemberGroupingRepository $MemberGroupingRep )
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'board', $MemberGroupingRep->getGroupingById($this->getParameter('app.memberGrouping.board')) );

        return $this->render('membergrouping/board.html.twig', $this->template_data );
    }
*/

    /**
     * @Route("/mijn-account", name="membership")
     */
    public function membership()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::my_membership');

        return $this->render('membership/overview.html.twig', $this->template_data );
    }

    /**
     * @Route("/mijn-account/inschrijvingen", name="membership_enrolments")
     */
    public function membership_enrolments()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::my_membership');

        return $this->render('membership/enrolments.html.twig', $this->template_data );
    }

    /**
     * @Route("/mijn-account/instellingen", name="membership_preferences")
     */
    public function membership_preferences(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Je hebt geen toegang om deze pagina te bekijken!');

        $tabs = ['members','address','notifications','account'];
        $tab = (string) $request->query->get('tab', null);
        if (!in_array($tab,$tabs)) $tab = $tabs[0];

        $json = $request->query->get('format', null) == 'json';
        $action = $request->query->get('action', null);
        $remove = $action == 'remove';
        $edit = $action == 'edit';
        $new = $action == 'new';
        $form = null;

        if ($json && $action == 'load' )
        {
            return $this->json([
                'success' => true,
                'html' => $this->render(sprintf('membership/preferences_%s.html.twig', $tab), ['tab' => $tab])->getContent(),
            ]);
        }
        elseif ($json && ($edit or $new or $remove))
        {
            $id = (int) $request->query->get('id', null);
            $user = $this->security->getUser();

            if ( $tab == 'address' )
            {
                $address = $new ? new MemberAddress($user) : $user->getMemberAddress($id);

                if (!$address instanceof MemberAddress) return $this->json(['success' => false]);

                if ($remove)
                {
                    if (empty($address->getMembers())) {
                        $this->remove($address);
                        $this->em->flush();
                        return $this->json([
                            'success' => true,
                            'message' => $this->translator->trans(sprintf('preferences.address.%s.success', $action )),
                        ]);
                    } else {
                        return $this->json([
                            'success' => false,
                            'message' => $this->translator->trans(sprintf('preferences.address.%s.inuse', $action )),
                        ]);
                    }
                }
                else
                {
                    $form = $this->createForm(MemberAddressForm::class, $address);
                    $form->handleRequest($request);

                    if ($form->isSubmitted() && $form->isValid())
                    {
                        if ($new)
                        {
                            $address = $form->getData();
                            $address->setUser($this->security->getUser());
                            $this->em->persist($address);
                        }
                        $this->em->flush();
                        return $this->json([
                            'success' => true,
                            'message' => $this->translator->trans(sprintf('preferences.address.%s.success', $action )),
                        ]);
                    }
                }

            }

            if ($form) {
                return $this->json([
                    'success' => true,
                    'html' => $this->render('membership/preferences_form.html.twig', [
                        'tab' => $tab,
                        'action' => $action,
                        'url' => $this->generateUrl('membership_preferences',
                               [ 'tab' => $tab, 'format' => 'json', 'action' => $action, 'id' => $id ]),
                        'form' => $form->createView(),
                    ])->getContent(),
                ]);
            } else {
                return $this->json([ 'success' => false, 'html' => null ]);
            }

        }
        $this->initTemplateData();
        $this->addToTemplateData( 'tabs', $tabs);
        $this->addToTemplateData( 'tab', $tab);

        return $this->render(sprintf('membership/preferences.html.twig'), $this->template_data );
    }


    /**
     * @Route("/inschrijven", name="enrol_list")
     */
/*
    public function enrol_list()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enrol_list');

        return $this->render('enrol/list.html.twig', $this->template_data );
    }
*/

    /**
     * @Route("/inschrijven/{slug}", name="enrol_item")
     */
/*
    public function enrol_item()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enrol_list');

        return $this->render('enrol/list.html.twig', $this->template_data );
    }
*/

    /**
     * @Route("/inschrijven/{slug}/details", name="enrol_details")
     */
/*
    public function enrol_details()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enrol_list');

        return $this->render('enrol/list.html.twig', $this->template_data );
    }
*/

    /**
     * @Route("/inschrijven/{slug}/formulier", name="enrol_form")
     */
/*
    public function enrol_form()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enrol_list');

        return $this->render('enrol/list.html.twig', $this->template_data );
    }
*/

}
