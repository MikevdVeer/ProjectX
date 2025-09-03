<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Entity\Template;
use App\Entity\Review;
use App\Form\ReviewType;

/**
 * VisitorController Class
 * 
 * Handles all visitor-facing pages including homepage, webshop, and template details.
 * This controller manages the public interface of the application.
 */
class VisitorController extends AbstractController
{
    /**
     * Homepage Route
     * 
     * Displays the main landing page of the application.
     * Route: GET /
     */
    #[Route('/', name: 'app_home')]
    public function showHomepage(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }

    /**
     * Webshop Route
     * 
     * Displays the main webshop page with all available categories.
     * Route: GET /webshop
     * 
     * @param EntityManagerInterface $entityManager - Database manager for fetching categories
     */
    #[Route('/webshop', name: 'app_webshop')]
    public function showWebshop(EntityManagerInterface $entityManager): Response
    {
        // Fetch all categories from the database
        $categories = $entityManager->getRepository(Category::class)->findAll();
        
        return $this->render('visitor/webshop.html.twig', [
            'controller_name' => 'VisitorController',
            'categories' => $categories, // Pass categories to the template
        ]);
    }

    /**
     * Category Route
     * 
     * Displays templates filtered by a specific category.
     * Route: GET /webshop/category/{category}
     * 
     * @param string $category - The category name from the URL
     * @param EntityManagerInterface $entityManager - Database manager
     */
    #[Route('/webshop/category/{category}', name: 'app_webshop_category')]
    public function showCategory(string $category, EntityManagerInterface $entityManager): Response
    {
        // Find the category entity by name
        $categoryEntity = $entityManager->getRepository(Category::class)->findOneBy(['name' => $category]);
        
        // If category doesn't exist, throw 404 error
        if (!$categoryEntity) {
            throw $this->createNotFoundException('Category not found');
        }
        
        // Get all templates associated with this category
        $templates = $categoryEntity->getTemplates();
        
        return $this->render('visitor/category.html.twig', [
            'controller_name' => 'VisitorController',
            'category' => $category,
            'templates' => $templates, // Pass templates to the template
        ]);
    }

    /**
     * Course Page Route
     * 
     * Displays the course information page.
     * Route: GET /course
     */
    #[Route('/course', name: 'app_course')]
    public function showCourses(): Response
    {
        return $this->render('visitor/course.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }

    /**
     * About Page Route
     * 
     * Displays the about page.
     * Route: GET /about
     */
    #[Route('/about', name: 'app_about')]
    public function showAbout(): Response
    {
        return $this->render('visitor/about.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }

    /**
     * Template Details Route
     * 
     * Displays detailed information about a specific template including reviews.
     * Handles both GET (display) and POST (review submission) requests.
     * Route: GET|POST /webshop/template/{id}
     * 
     * @param Request $request - HTTP request object (contains form data)
     * @param Template $template - Template entity (automatically loaded by Symfony)
     * @param EntityManagerInterface $entityManager - Database manager
     */
    #[Route('/webshop/template/{id}', name: 'app_template_details', methods: ['GET', 'POST'])]
    public function showTemplateDetails(Request $request, Template $template, EntityManagerInterface $entityManager): Response
    {
        // STEP 1: Create a new Review entity and form
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        
        // STEP 2: Handle form submission (only if it's a POST request)
        $form->handleRequest($request);

        // STEP 3: Process form if it was submitted and is valid
        if ($form->isSubmitted() && $form->isValid()) {
            
            // STEP 3a: Check if user is logged in
            if (!$this->getUser()) {
                $this->addFlash('error', 'You must be logged in to submit a review.');
                return $this->redirectToRoute('app_template_details', ['id' => $template->getId()]);
            }

            // STEP 3b: Check if user has already reviewed this template (prevent duplicates)
            $existingReview = $entityManager->getRepository(Review::class)->findOneBy([
                'user' => $this->getUser(),
                'template' => $template
            ]);

            if ($existingReview) {
                $this->addFlash('error', 'You have already submitted a review for this template.');
                return $this->redirectToRoute('app_template_details', ['id' => $template->getId()]);
            }

            // STEP 3c: Set review data
            $review->setTemplate($template); // Associate with the current template
            $review->setUser($this->getUser()); // Associate with the current user
            $review->setDate(new \DateTime()); // Set current date/time

            // STEP 3d: Save review to database
            $entityManager->persist($review); // Prepare for database insertion
            $entityManager->flush(); // Execute database operations

            // STEP 3e: Show success message and redirect
            $this->addFlash('success', 'Your review has been submitted successfully!');
            return $this->redirectToRoute('app_template_details', ['id' => $template->getId()]);
        }

        // STEP 4: Render the template with form and template data
        return $this->render('visitor/template_details.html.twig', [
            'controller_name' => 'VisitorController',
            'template' => $template, // Pass template data to view
            'reviewForm' => $form->createView(), // Pass form to view
        ]);
    }
}

