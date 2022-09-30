<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name("welcome");

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', function(){return redirect()->route("welcome");})->name("home");
Route::get('/contact', function(){return view('contact');})->name("contact");
Route::get('/impressum', function(){return view('impressum');})->name("impressum");
Route::get('/about', function(){return view('about');})->name("about");
Route::get('/datenschutz', function(){return view('privacy-policy');})->name("datenschutz");
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


Route::post('/posts/newpost', [App\Http\Controllers\PostController::class, 'newPost'])
            ->name('posts.newpost')
            ->middleware(['auth', 'isAdmin']);

Route::get('/posts/{event}', [App\Http\Controllers\PostController::class, 'getPosts'])
            ->name('events.posts');




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

Route::get('/admin/api/timeline', [App\Http\Controllers\AdminController::class, 'getTimeline'])
    ->name('admin.timeline')
    ->middleware(['auth', 'isAdmin']);

Route::get('/api/event/user/count/{event}', [App\Http\Controllers\EventController::class, 'countUsers'])
    ->name('event.user.count');

Route::get('/api/event/user/attending/{event}', [App\Http\Controllers\UserController::class, 'isAttending'])
    ->name('admin.event.user.attending')
    ->middleware('auth');







Route::get('/admin', function(){return redirect()->route('admin.dashboard');})->middleware(['auth', 'isAdmin']);
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
