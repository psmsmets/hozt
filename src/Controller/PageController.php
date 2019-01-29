<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
use App\Entity\ContactFaq;
use App\Entity\ContactForm;
use App\Entity\CalendarCategory;
use App\Entity\CalendarEvent;
use App\Entity\Competition;
use App\Entity\CompetitionState;

use App\Form\ContactFormType;

class PageController extends AbstractController
{
    private $template_data = [];

    private function initTemplateData()
    {
        $this->template_data = [];
        $this->addToTemplateData( 'training_team_categories', $this->get_training_team_categories(), 'base' );
    }

    private function addToTemplateData(string $key, $data, string $cat = 'page')
    {
        $this->template_data[$cat][$key] = $data;
    }

    private function get_training_team_categories()
    {
        return $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->findAllEnabled();
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $this->initTemplateData();

        $this->addToTemplateData( 'carousel', $this->getDoctrine()
                ->getRepository(CarouselSlide::class)
                ->findCarouselSlides()
            );

        $this->addToTemplateData( 'sticky_blog_post', $this->getDoctrine()
                ->getRepository(BlogPost::class)
                ->findSpecialStickyBlogPost()
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

        if (!$static) {
            throw $this->createNotFoundException(
                'Pagina niet gevonden '.$slug
            );
        }

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

        if (!$blogPost) {
            throw $this->createNotFoundException();
        }
 
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
        $this->addToTemplateData( 'blog_posts', $repository->findBlogPosts( $slug, $page )
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
                ->findAllJoinedToTeamsCoachesSchedule()
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
                ->findAllJoinedToScheduleTeams()
            );

        return $this->render('training/scheduleDays.html.twig', $this->template_data );
    }

    /**
     * @Route("/trainers", name="training_coaches")
     */
    public function training_coaches()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'coaches', $this->getDoctrine()
                ->getRepository(TrainingCoach::class)
                ->findAllJoinedToTeams()
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
    public function training_category($slug)
    {
        $category = $this->getDoctrine()
            ->getRepository(TrainingTeamCategory::class)
            ->findOneBySlugJoinedToTeamsCoaches($slug)
            ;
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $this->initTemplateData();
        $this->addToTemplateData( 'training_category', $category );
        $this->addToTemplateData( 'training_days', $this->getDoctrine()
            ->getRepository(TrainingDay::class)
            ->findAllByTeamCategoryJoinedToSchedule($category->getId())
        );
        $this->addToTemplateData( 'competitions', $this->getDoctrine()
            ->getRepository(Competition::class)
            ->findUpcomingCompetitionEventsByTeamCategory($category->getId())
        );
        $this->addToTemplateData( 'results', $this->getDoctrine()
            ->getRepository(Competition::class)
            ->findCompetitionResultsByTeamCategory($category->getId())
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
    public function calendar_list(int $year = null )
    {
        if (is_null($year) or $year < 2016 or $year > 2050 ) {
            return $this->redirectToRoute('calendar_list', ['year' => $this->getCurrentCalendarYear() ]);
        }

        $start = strval($year).'-09-01 00:00';
        $end   = date('Y-m-d H:i', strtotime(strval($year).'-09-01 +1 year'));

        $this->initTemplateData();
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
     * @Route("/kalender/{yyyy}-{yy}/{id}", name="calendar_event")
     */
    public function calendar_event()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::calendar_event');

        return $this->render('calendar/event.html.twig', $this->template_data );
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
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $message = (new \Swift_Message('HoZT.be contactformulier'))
                ->setFrom('webmaster@hozt.be')
                ->setTo($data['question']->getEmail())
                ->setReplyTo($data['email'])
                ->setBody(
                    $this->renderView(
                        'emails/contactform.html.twig', $data
                    ),
                    'text/html'
                )
            ;
            if ($data['copy'])
            {
                $message->setBcc($data['email']);
            }
            $result = $mailer->send($message);

            if ($result)
            { 
                $this->addFlash('success', 'Bericht verzonden! Dankjewel om ons te contacteren.');
            } else {
                $this->addFlash('error', 'Sorry, er ging iets verkeerd. Controleer of alle velden correct ingevuld zijn en probeer later opnieuw.');
            }
            return $this->redirectToRoute('contact_form');
        }

        $this->initTemplateData();
        $this->addToTemplateData( 'form', $form->createView() );

        return $this->render('contact/form.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijvingen", name="enroll_list")
     */
    public function enroll_list()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijvingen/{slug}", name="enroll_item")
     */
    public function enroll_item()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijvingen/{slug}/details", name="enroll_details")
     */
    public function enroll_details()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

    /**
     * @Route("/inschrijvingen/{slug}/formulier", name="enroll_form")
     */
    public function enroll_form()
    {
        $this->initTemplateData();
        $this->addToTemplateData( 'controller_name', 'PageController::enroll_list');

        return $this->render('enroll/list.html.twig', $this->template_data );
    }

}
