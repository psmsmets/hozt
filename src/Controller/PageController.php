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

# entities
use App\Entity\StaticPage;
use App\Entity\BlogPost;
use App\Entity\BlogCategory;
use App\Entity\CarouselSlide;
use App\Entity\TrainingCoach;
use App\Entity\TrainingDay;
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

# forms
use App\Form\ContactFormType;
use App\Form\ClubfeestType;

class PageController extends AbstractController
{
    private $template_data = [];
    protected $requestStack;
    private $security;
    private $now;

    public function __construct(RequestStack $requestStack, Security $security)
    {
        $this->requestStack = $requestStack;
        $this->security = $security;
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
    public function static_page($slug)
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
    public function blog_post(int $id, string $slug = null)
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
     * @Route("/blog/{slug}", name="blog_category")
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
     * @Route("/trainingsuren", name="training_schedule_teams")
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
        $this->addToTemplateData( 'training_days', $this->getDoctrine()
                ->getRepository(TrainingDay::class)
                ->findAllJoinedToScheduleTeams($this->getParameter('app.defaults.scheduleNotice.days'))
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
        $this->addToTemplateData( 'training_days', $this->getDoctrine()
            ->getRepository(TrainingDay::class)
            ->findAllByTeamCategoryJoinedToSchedule($category, $this->getParameter('app.defaults.scheduleNotice.days') )
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
        if ((int)date("m")>8) {
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

        $start = strval($year).'-09-01 00:00';
        $end   = date('Y-m-d H:i', strtotime(strval($year).'-09-01 +1 year'));

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
     * @Route("/contact/faq", name="contact_faq")
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
     * @Route("/contact/formulier", name="contact_form")
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
     * @Route("/clubfeest", name="enroll_clubfeest")
     */
    public function enroll_clubfeest(Request $request, \Swift_Mailer $mailer)
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
            $data = $form->getData();

            if ( $data['adults'] == 0 and $data['children'] == 0 ) {
                $this->addFlash('warning', 'Bijna gelukt, maar je moet toch minstens iemand inschrijven.');
                return $this->redirectToRoute('enroll_clubfeest');
            }

            $enroll = new Clubfeest();
            $enroll->setAdults($data['adults']);
            $enroll->setChildren($data['children']);
            $enroll->setName($data['name']);
            $enroll->setEmail($data['email']);
            $enroll->setMessage($data['message']);

            $message = (new \Swift_Message())
                ->setSubject('Inschrijving HoZT '.$event->getTitle().' '.ucfirst($event->getFormattedPeriod()))
                ->setFrom(array($this->getParameter('app.mailer.from')=>$this->getParameter('app.mailer.name')))
                ->setTo($data['email'])
                ->setBody(
                    $this->renderView(
                        'emails/clubfeest.html.twig', [ 'enroll' => $enroll, 'event' => $event ]
                    ),
                    'text/html'
                )
            ;
            $sent = $mailer->send($message);
            $enroll->setEmailSent($sent);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enroll);
            $entityManager->flush();

            $this->addFlash('success', 'Ingeschreven! We verwachten je '.$event->getFormattedPeriod().'.');

            if ($sent) { 
                $this->addFlash('success', 'Een bevestigingsmail is verzonden naar het opgegeven e-mail adres.');
            } else {
                $this->addFlash('warning', 'Het is helaas niet gelukt de bevestigingsmail te verzenden.');
            }

            return $this->redirectToRoute('enroll_clubfeest');
        }

        $this->initTemplateData();
        $this->addToTemplateData( 'form', $form->createView() );
        $this->addToTemplateData( 'form_closure', $closure );
        $this->addToTemplateData( 'calendar_event', $event );

        return $this->render('enroll/clubfeest.html.twig', $this->template_data );
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

        return $this->render('enroll/enrolled.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijven", name="enroll_list")
     */
    public function enroll_list()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijven/{slug}", name="enroll_item")
     */
    public function enroll_item()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijven/{slug}/details", name="enroll_details")
     */
    public function enroll_details()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijven/{slug}/formulier", name="enroll_form")
     */
    public function enroll_form()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

}
