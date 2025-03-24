<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin Controller
 *
 * This controller now serves as a facade that delegates to the appropriate
 * domain-specific controllers in the Admin namespace.
 */
class AdminController extends Controller
{
    private DashboardController $dashboardController;

    private UserController $userController;

    private EventController $eventController;

    private SponsorController $sponsorController;

    private LocationController $locationController;

    private AnalyticsController $analyticsController;

    public function __construct(
        DashboardController $dashboardController,
        UserController $userController,
        EventController $eventController,
        SponsorController $sponsorController,
        LocationController $locationController,
        AnalyticsController $analyticsController
    ) {
        $this->dashboardController = $dashboardController;
        $this->userController = $userController;
        $this->eventController = $eventController;
        $this->sponsorController = $sponsorController;
        $this->locationController = $locationController;
        $this->analyticsController = $analyticsController;
    }

    /**
     * Loads the admin dashboard
     */
    public function dashboard(): View
    {
        return $this->dashboardController->dashboard();
    }

    /**
     * Api call to get all users
     * returns all users in paginated json format
     */
    public function showUsers(): JsonResponse
    {
        return $this->userController->showUsers();
    }

    /**
     * Api call to get one single user
     * returns the user in json format
     */
    public function showUser(int $id): JsonResponse
    {
        return $this->userController->showUser($id);
    }

    /**
     * Api call to get all events
     * returns all events in paginated json format
     */
    public function showEvents(): JsonResponse
    {
        return $this->eventController->showEvents();
    }

    /**
     * Api call to get one single event
     * returns the event in json format
     */
    public function getEvent(int $id): JsonResponse
    {
        return $this->eventController->getEvent($id);
    }

    /**
     * Api call to get all posts of one single event
     * returns all posts of one single event in json format
     */
    public function getPosts($id): JsonResponse
    {
        return $this->eventController->getPosts($id);
    }

    /**
     * Api call to get all Events that a single user is attending
     * returns all events in json format
     */
    public function showUserEvents(int $id): JsonResponse
    {
        return $this->userController->showUserEvents($id);
    }

    /**
     * Api call to create a new event
     * returns the new event in json format
     */
    public function storeEvent(Request $request)
    {
        return $this->eventController->storeEvent($request);
    }

    /**
     * Api call to update an event
     * returns the updated event in json format
     *
     * @param  int  $id
     */
    public function updateEvent(Request $request, int $event)
    {
        return $this->eventController->updateEvent($request, $event);
    }

    /**
     * Api call to delete an event
     * returns the deleted event in json format
     */
    public function deleteEvent($id): JsonResponse
    {
        return $this->eventController->deleteEvent($id);
    }

    /**
     * @deprecated
     *
     * Api call to close an Event
     * returns the closed event in json format
     */
    public function closeEvent(int $id): RedirectResponse
    {
        return $this->eventController->closeEvent($id);
    }

    /**
     * @deprecated
     *
     * Api call to open an Event
     * returns the opened event in json format
     */
    public function openEvent(int $id): RedirectResponse
    {
        return $this->eventController->openEvent($id);
    }

    /**
     * @deprecated
     * Api call to create pdf
     */
    public function createPdf()
    {
        return $this->userController->createPdf();
    }

    /**
     * Api call to get timeline
     * returns the timeline in cursor paginated json format
     */
    public function getTimeline()
    {
        return $this->analyticsController->getTimeline();
    }

    /**
     * Api call to get most views per page
     * Over ga4 api
     */
    public function ga4_mostViewsByPage(): JsonResponse
    {
        return $this->analyticsController->ga4_mostViewsByPage();
    }

    /**
     * Api call to get views growth of views
     * between the date ranges 14 days ago and 7 days ago
     * and 7 days ago and today
     */
    public function ga4_lastWeekThisWeek(): JsonResponse
    {
        return $this->analyticsController->ga4_lastWeekThisWeek();
    }

    /**
     * Gets all sponsors
     *
     * @return \Illuminate\Http\Response list of sponsors
     */
    public function getAllSponsors(): JsonResponse
    {
        return $this->sponsorController->getAllSponsors();
    }

    /**
     * Creates a new sponsor
     *
     * @return \Illuminate\Http\Response the created sponsor
     */
    public function createSponsor(Request $request)
    {
        return $this->sponsorController->createSponsor($request);
    }

    /**
     * Updates a sponsor
     *
     * @return \Illuminate\Http\Response the updated sponsor
     */
    public function editSponsor(Request $request, int $sponsor)
    {
        return $this->sponsorController->editSponsor($request, $sponsor);
    }

    /**
     * Deletes a sponsor
     *
     * @return \Illuminate\Http\Response the deleted sponsor
     */
    public function deleteSponsor(int $sponsor): JsonResponse
    {
        return $this->sponsorController->deleteSponsor($sponsor);
    }

    /**
     * Returns all locations
     */
    public function getLocations(): JsonResponse
    {
        return $this->locationController->getLocations();
    }

    /**
     * Get location with given slug
     */
    public function getLocation(string $slug): JsonResponse
    {
        return $this->locationController->getLocation($slug);
    }
}
