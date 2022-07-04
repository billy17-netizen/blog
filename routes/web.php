<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\BlogCategoryController;
use App\Http\Controllers\Home\BlogController;
use App\Http\Controllers\Home\FooterController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\Home\HomeSliderController;
use \App\Http\Controllers\Home\PortfolioController;
use \App\Http\Controllers\Home\ContactController;
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

//Route::get('/', static function () {
//    return view('frontend.index');
//});

//Home routes
Route::controller(Controller::class)->group(static function() {
    Route::get('/', 'homeMain')->name('home');
});

//Admin All routes
Route::controller(AdminController::class)->middleware('auth')->group(function() {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'profile')->name('admin.profile');
    Route::get('/edit/profile', 'editProfile')->name('edit.profile');
    Route::post('/store/profile', 'storeProfile')->name('store.profile');

    Route::get('/change/password', 'changePassword')->name('change.password');
    Route::post('/update/password', 'updatePassword')->name('update.password');
});

//HomeSlide All routes
Route::controller(HomeSliderController::class)->group(static function() {
    Route::get('/home/slide', 'homeSlider')->name('home.slide');
    Route::post('/update/slider', 'updateSlider')->name('update.slider');
    Route::get('/update/slider', 'updateSlider')->name('about.page');
});

//About Page All routes
Route::controller(AboutController::class)->group(static function() {
    Route::get('/about/page', 'aboutPage')->name('about.page');
    Route::post('/update/about', 'updateAbout')->name('update.about');
    Route::get('/about', 'homeAbout')->name('home.about');
    Route::get('/about/multi/image', 'aboutMultiImage')->name('about.multi.image');
    Route::post('/store/multi/image', 'storeMultiImage')->name('store.multi.image');
    Route::get('/all/multi/image', 'allMultiImage')->name('all.multi.image');

    Route::get('/edit/multi/image/{id}', 'editMultiImage')->name('edit.multi.image');
    Route::post('/update/multi/image', 'updateMultiImage')->name('update.multi.image');
    Route::get('/delete/multi/image/{id}', 'deleteMultiImage')->name('delete.multi.image');

});

//Portfolio All routes
Route::controller(PortfolioController::class)->group(static function() {
    Route::get('/portfolio', 'homePortfolio')->name('home.portfolio');
    Route::get('/all/portfolio', 'allPortfolio')->name('all.portfolio');
    Route::get('/add/portfolio', 'addPortfolio')->name('add.portfolio');
    Route::post('/store/portfolio', 'storePortfolio')->name('store.portfolio');
    Route::get('/edit/portfolio/{id}', 'editPortfolio')->name('edit.portfolio');
    Route::post('/update/portfolio', 'updatePortfolio')->name('update.portfolio');
    Route::get('/delete/portfolio/{id}', 'deletePortfolio')->name('delete.portfolio');
    Route::get('/portfolio/details/{id}', 'portfolioDetails')->name('portfolio.details');

});

//BlogCategory All routes
Route::controller(BlogCategoryController::class)->group(static function() {
    Route::get('/all/blog/category', 'allBlogCategory')->name('all.blog.category');
    Route::get('/add/blog/category', 'addBlogCategory')->name('add.blog.category');
    Route::post('/store/blog/category', 'storeBlogCategory')->name('store.blog.category');
    Route::get('/edit/blog/category/{id}', 'editBlogCategory')->name('edit.blog.category');
    Route::post('/update/blog/category', 'updateBlogCategory')->name('update.blog.category');
    Route::get('/delete/blog/category/{id}', 'deleteBlogCategory')->name('delete.blog.category');
});

//Blog All routes
Route::controller(BlogController::class)->group(static function() {
    Route::get('/all/blog', 'allBLog')->name('all.blog');
    Route::get('/add/blog', 'addBLog')->name('add.blog');
    Route::post('/store/blog', 'storeBLog')->name('store.blog');
    Route::get('/edit/blog/{id}', 'editBLog')->name('edit.blog');
    Route::post('/update/blog', 'updateBLog')->name('update.blog');
    Route::get('/delete/blog/{id}', 'deleteBLog')->name('delete.blog');
    Route::get('/blog/details/{id}', 'blogDetails')->name('blog.details');
    Route::get('/category/blog/{id}', 'categoryBlog')->name('category.blog');

    Route::get('/blog', 'homeBlog')->name('home.blog');
});

//Footer All routes
Route::controller(FooterController::class)->group(static function() {
    Route::get('/footer/setup', 'footerSetup')->name('footer.setup');
    Route::post('/update/footer', 'updateFooter')->name('update.footer');
});

//Contact All routes
Route::controller(ContactController::class)->group(static function() {
    Route::get('/contact', 'Contact')->name('contact.me');
    Route::post('/store/message', 'storeMessage')->name('store.message');
    Route::get('/contact/message', 'contactMessage')->name('contact.message');
    Route::get('/delete/message/{id}', 'deleteMessage')->name('delete.message');
});

Route::get('/dashboard', static function () {
    return view('admin.index');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';
