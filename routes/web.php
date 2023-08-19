<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Sponsor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // get all active Sponsors
    $sponsors = Sponsor::where('active', true)->get();
    return view('welcome', compact('sponsors'));
})->name("welcome");

Route::get('/l/{slug}', [App\Http\Controllers\LocationController::class, 'show'])->name('location.show');
Route::post('/l/create', [App\Http\Controllers\LocationController::class, 'store'])->name('location.store')
    ->middleware(['auth', 'isAdmin']);
Route::post('/l/{slug}/update', [App\Http\Controllers\LocationController::class, 'update'])->name('location.update')
    ->middleware(['auth', 'isAdmin']);
Route::delete('/l/{slug}', [App\Http\Controllers\LocationController::class, 'destroy'])->name('location.destroy')
    ->middleware(['auth', 'isAdmin']);


Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', function () {
    return redirect()->route("welcome");
})->name("home");
Route::get('/contact', function () {
    return view('contact', ['title' => 'Kontakt']);
})->name("contact");
Route::get('/impressum', function () {
    return view('impressum', ['title' => 'Impressum']);
})->name("impressum");
Route::get('/about', function () {
    return view('about', ['title' => 'Über uns']);
})->name("about");
Route::get('/datenschutz', function () {
    return view('privacy-policy', ['title' => 'Datenschutz']);
})->name("datenschutz");
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapXmlController::class, 'index'])->name("sitemap");

Route::get('/events', [App\Http\Controllers\EventController::class, 'index'])
    ->name('events.index');
Route::get('/events/archive', [App\Http\Controllers\EventController::class, 'archive'])
    ->name('events.archive');
Route::get('/events/me', [App\Http\Controllers\EventController::class, 'myevents'])
    ->name('events.myevents')
    ->middleware('auth');

Route::get('/events/{id}', [App\Http\Controllers\EventController::class, 'show'])
    ->name('events.show');
Route::get('/api/event/user/count/{event}', [App\Http\Controllers\EventController::class, 'countUsers'])
    ->name('event.user.count');


Route::post('/posts/newpost', [App\Http\Controllers\PostController::class, 'newPost'])
    ->name('posts.newpost')
    ->middleware(['auth', 'isAdmin']);

Route::get('/posts/{event}', [App\Http\Controllers\PostController::class, 'getPosts'])
    ->name('events.posts');

Route::get('/api/posts/{event}', [App\Http\Controllers\PostController::class, 'getPosts'])
    ->name('admin.posts.show');

Route::post('/admin/api/posts/newpost', [App\Http\Controllers\PostController::class, 'newPost'])
    ->name('admin.posts.newpost')
    ->middleware(['auth', 'isAdmin']);

Route::post('/admin/api/posts/update', [App\Http\Controllers\PostController::class, 'updatePost'])
    ->name('admin.posts.update')
    ->middleware(['auth', 'isAdmin']);

Route::delete('/admin/api/posts/delete/{post}', [App\Http\Controllers\PostController::class, 'deletePost'])
    ->name('admin.posts.delete')
    ->middleware(['auth', 'isAdmin']);

Route::get('/api/registrations/verify/{token}', [App\Http\Controllers\RegistrationController::class, 'verify'])
    ->name('admin.registrations.verify');




Route::get('/user/data/show', [App\Http\Controllers\UserController::class, 'showdata'])
    ->name('userdata.showdata')
    ->middleware('auth');
// Route::get('/user/data/delete', [App\Http\Controllers\UserController::class, 'deletedataShow'])
//             ->name('userdata.deletedata')
//             ->middleware('auth');
// Route::post('/user/data/delete', [App\Http\Controllers\UserController::class, 'deletedata'])
//             ->name('userdata.delete')
//             ->middleware('auth');


Route::get('/api/user/isauthenticated', [App\Http\Controllers\UserController::class, 'isAuthenticated'])
    ->name('api.user.isauthenticated');

Route::post('/api/user/attend/{event}', [App\Http\Controllers\UserController::class, 'attendEvent'])
    ->name('events.attendShow')
    ->middleware('auth');
Route::get('/api/event/user/attending/{event}', [App\Http\Controllers\UserController::class, 'isAttending'])
    ->name('admin.event.user.attending')
    ->middleware('auth');


Route::get('/api/sponsors/event/{event}', [App\Http\Controllers\SponsorController::class, 'getSponsors'])
    ->name('api.sponsor.get');
Route::get('/api/sponsors', [App\Http\Controllers\SponsorController::class, 'getActiveSponsors'])
    ->name('api.sponsor.getActive');
Route::get('/api/sponsor/{sponsor}', [App\Http\Controllers\SponsorController::class, 'getSponsor'])
    ->name('api.sponsor.getOne');



Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'isAdmin']);
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/users', [App\Http\Controllers\AdminController::class, 'showUsers'])
    ->name('admin.users')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'showUser'])
    ->name('admin.users.show')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/users/toPdf', [App\Http\Controllers\AdminController::class, 'createPdf'])
    ->name('admin.users.toPdf')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/events', [App\Http\Controllers\AdminController::class, 'showEvents'])
    ->name('admin.events')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/events/{user}', [App\Http\Controllers\AdminController::class, 'showUserEvents'])
    ->name('admin.user.events.show')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/event/{event}', [App\Http\Controllers\AdminController::class, 'getEvent'])
    ->name('admin.events.show')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/events/create', [App\Http\Controllers\AdminController::class, 'createEvent'])
    ->name('admin.events.create')
    ->middleware(['auth', 'isAdmin']);
Route::post('/admin/api/events/create', [App\Http\Controllers\AdminController::class, 'storeEvent'])
    ->name('admin.events.store')
    ->middleware(['auth', 'isAdmin']);
Route::post('/admin/events/update/{id}', [App\Http\Controllers\AdminController::class, 'updateEvent'])
    ->name('admin.events.update')
    ->middleware(['auth', 'isAdmin']);
Route::delete('/admin/events/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteEvent'])
    ->name('admin.events.delete')
    ->middleware(['auth', 'isAdmin']);
Route::post('/admin/events/close/{id}', [App\Http\Controllers\AdminController::class, 'closeEvent'])
    ->name('admin.events.close')
    ->middleware(['auth', 'isAdmin']);
Route::post('/admin/events/open/{id}', [App\Http\Controllers\AdminController::class, 'openEvent'])
    ->name('admin.events.open')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/timeline', [App\Http\Controllers\AdminController::class, 'getTimeline'])
    ->name('admin.timeline')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/locations', [App\Http\Controllers\AdminController::class, 'getLocations'])
    ->name('admin.locations')
    ->middleware(['auth', 'isAdmin']);
Route::get('/admin/api/locations/{slug}', [App\Http\Controllers\AdminController::class, 'getLocation'])
    ->name('admin.locations.show')
    ->middleware(['auth', 'isAdmin']);






// Analytics
// mvbp ( most views by page)
Route::get('/admin/api/analytics/mvbp', [App\Http\Controllers\AdminController::class, 'ga4_mostViewsByPage'])
    ->name('admin.analytics.mvbp')
    ->middleware(['auth', 'isAdmin']);
// lwtw (last week this week)
Route::get('/admin/api/analytics/lwtw', [App\Http\Controllers\AdminController::class, 'ga4_lastWeekThisWeek'])
    ->name('admin.analytics.lwtw')
    ->middleware(['auth', 'isAdmin']);

Route::get('/admin/api/sponsors', [App\Http\Controllers\AdminController::class, 'getAllSponsors'])
    ->name('admin.sponsors')
    ->middleware(['auth', 'isAdmin']);
Route::post('/admin/api/sponsors/create', [App\Http\Controllers\AdminController::class, 'createSponsor'])
    ->name('admin.sponsors.create')
    ->middleware(['auth', 'isAdmin']);
Route::post('/admin/api/sponsors/update/{id}', [App\Http\Controllers\AdminController::class, 'editSponsor'])
    ->name('admin.sponsors.update')
    ->middleware(['auth', 'isAdmin']);
Route::delete('/admin/api/sponsors/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteSponsor'])
    ->name('admin.sponsors.delete')
    ->middleware(['auth', 'isAdmin']);
