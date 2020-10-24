<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\uploadController;

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
});

Auth::routes();   // To make  Auth::middleware available. We still need to use  $this->middleware('auth'); in 
				  // __construct() of the corresponding controller, e.g. HomeController and ProductController
/*				  
 NOTE: To make a middleware applicable to all controller, specifiy this in 
      C:\xampp\htdocs\laravel\laravel_auth\app\Http\Kernel.php's 
		protected $middleware = []
	To apply a middleware on selected group, e.g. web.php or api.php, include it 
	in the corresponding protected $middlewareGroups[] in kernel.php 
*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.post');

// for products table CURD 
//Route::resource('products', ProductController::class);   // error ProductController not found
//Route::get('/products', [App\Http\Controllers\ProductController::class,'index'])->name('products');  // works
Route::resource('products', App\Http\Controllers\ProductController::class);  // works

// name parameter is required 
Route::get('/users/{name}', function($name='test'){
		return 'Hi ' . $name;
});



// Requirements: name parameter is required and it can contain only alpha characters
// i.e. http://127.0.0.1:8000/users/Raja works but http://127.0.0.1:8000/users/Raja56 fails with 404 error
Route::get('/books/{name}', function($name='test'){
		return 'Hi ' . $name;
});

// Similarly: we can specify a condition that id contains numeric values. 
Route::get('/phones/{id}', function($id){
		return 'Hi ' . $id;
})->where ('id','[0-9]+');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');



// For Http (ClientController testing)
Route::get('/posts',[ClientController::class,'getAllPosts'])->name('posts.getAllPosts');
/*
// name parameter is optional 
Route::get('/posts/{name?}', function($name='test'){
	return 'Hi ' . $name;
});
*/
// get specific post 
Route::get('/posts/{id}',[ClientController::class,'getPostById'])->name('posts.getPostById');

// Create a new post using the post method
// As this is a similation using jason placehoder, we are using get. In real-life, when 
// the form is submitted from a page, this will be a post route
Route::get('/posts/add-post',[ClientController::class,'addPost'])->name('posts.addPost');

// Update a post 
Route::get('/posts/{id}/update',[ClientController::class,'updatePostById'])->name('posts.updatePostById');

// delete post. 
Route::get('/posts/{id}/delete',[ClientController::class,'deletePost'])->name('posts.deletePost');

// Upload a file 
Route::get('/upload',[uploadController::class,'uploadForm'])->name('upload-form');
Route::post('/upload',[uploadController::class,'uploadFile'])->name('upload.upload-file');
// Display files uploaded by the user 
Route::get('/user-files',[uploadController::class,'userFiles'])->name('user-files');
// Delete a file
Route::delete('/user-files/{id}/delete',[uploadController::class,'deleteFile'])->name('user-files.deleteFile');

