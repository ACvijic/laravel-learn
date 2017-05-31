<?php

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


// USERS ROUTES START
Route::get('/', 'IndexController@index');

Route::any('/users/login', 'UsersController@login')->name('login');

Route::get('/users/welcome', 'UsersController@welcome')->name('users-welcome');

Route::any('/users/create', 'UsersController@create')->name('users-create');

Route::get('/users/logout', 'UsersController@logout')->name('logout');

Route::get('/users', 'UsersController@index')->name('users-list');

Route::any('/users/edit/{user}', 'UsersController@edit')->name('users-edit');

Route::get('/users/delete/{user}', 'UsersController@delete')->name('users-delete');

Route::any('/users/change-password/{user}', 'UsersController@changePassword')->name('users-change-password');

Route::any('/users/password-recovery', 'UsersController@passwordRecovery')->name('users-password-recovery');

Route::any('/users/password-reset/{token}', 'UsersController@passwordReset')->name('users-password-reset');
// USERS ROUTES END


// PAGES ROUTES START
Route::any('/pages/create', 'PagesController@create')->name('pages-create');

Route::get('/pages', 'PagesController@index')->name('pages-list');

Route::any('/pages/edit/{page}', 'PagesController@edit')->name('pages-edit');

Route::get('/pages/delete/{page}', 'PagesController@delete')->name('pages-delete');

Route::get('/pages/delete-image/{page}', 'PagesController@deleteImage')->name('pages-delete-image');

Route::get('/pages/change-status/{page}', 'PagesController@changeStatus')->name('pages-change-status');
// PAGES ROUTES END


// MENUS ROUTES START
Route::any('/menus/create', 'MenusController@create')->name('menus-create');

Route::get('/menus/{menu?}', 'MenusController@index')->name('menus-list');

Route::post('/menus/reorder', 'MenusController@reorder')->name('menus-reorder');

Route::any('/menus/edit/{menu}', 'MenusController@edit')->name('menus-edit');

Route::get('/menus/change-status/{menu}', 'MenusController@changeStatus')->name('menus-change-status');

Route::get('/menus/delete/{menu}', 'MenusController@delete')->name('menus-delete');







// MENUS ROUTES END


// PRODUCT CATEGORIES ROUTES START
Route::any('/product/categories/create', 'ProductCategoriesController@create')->name('product-categories-create');

Route::any('/product/categories/index', 'ProductCategoriesController@index')->name('product-categories-list');

Route::any('/product/categories/edit/{category}', 'ProductCategoriesController@edit')->name('product-categories-edit');

Route::get('/product/categories/delete/{category}', 'ProductCategoriesController@delete')->name('product-categories-delete');

Route::get('/product/categories/delete-image/{category}', 'ProductCategoriesController@deleteImage')->name('product-categories-delete-image');

Route::get('/product/categories/change-status/{category}', 'ProductCategoriesController@changeStatus')->name('product-categories-change-status');
// PRODUCT CATEGORIES ROUTES END


// PRODUCTS ROUTES START
Route::any('/products/create', 'ProductsController@create')->name('products-create');

Route::any('/products', 'ProductsController@index')->name('products-list');

Route::any('/products/edit/{product}', 'ProductsController@edit')->name('products-edit');

Route::any('/products/delete/{product}', 'ProductsController@delete')->name('products-delete');

Route::any('/products/delete-image/{product}', 'ProductsController@deleteImage')->name('products-delete-image');

Route::any('/products/change-status/{product}', 'ProductsController@changeStatus')->name('products-change-status');
// PRODUCTS ROUTES END


// COMMENT ROUTES START
Route::any('/comments/{comment?}', 'CommentsController@index')->name('comments-list');
// COMMENT ROUTES END


// NEWS ROUTES START
Route::any('news/dataTable', 'NewsController@dataTable')->name('news-dataTable');

Route::any('/news/create/', 'NewsController@create')->name('news-create');

Route::any('/news/edit/{article}/{lang}', 'NewsController@edit')->name('news-edit');

Route::any('/news/delete/{article}/{lang}', 'NewsController@delete')->name('news-delete');

Route::any('/news/change-status/{article}/{lang}', 'NewsController@changeStatus')->name('news-change-status');

Route::any('/news/delete-image/{article}/{lang}', 'NewsController@deleteImage')->name('news-delete-image');

Route::any('/news/list/{lang}', 'NewsController@index')->name('news-list');
// NEWS ROUTES END

// POSTS ROUTES START
Route::get('/posts', 'PostsController@index')->name('posts-list');

Route::any('/posts/dataTable', 'PostsController@dataTable');

Route::any('/posts/change-status', 'PostsController@changeStatus')->name('posts-change-status');
// POSTS ROUTES END

// FRONTEND ROUTES START
Route::get('/news/list', 'OpenController@news');

Route::get('/page/{page}/{slug}', 'OpenController@page');

Route::get('/category/{category}/{slug}', 'OpenController@category');

Route::get('/product/{product}/{slug}', 'OpenController@product');

Route::post('/product/{product}/{slug}', 'CommentsController@create');

Route::post('/contact-form', 'OpenController@contactForm')->name('contact-form');
// FRONTEND ROUTES END


// FILEMANAGER ROUTES START
Route::get('/filemanager/popup', 'FileManagerController@popUp');

Route::any('/filemanager/connector', 'FileManagerController@connector');
// FILEMANAGER ROUTES END


// TEST ROUTES START
Route::any('/test/form', 'TestController@form');
// TEST ROUTES END