<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use \Symfony\Component\HttpFoundation\Request as Request;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    /**
     * Admin default route
     */
    Route::get('/admin', 'Admin\AdminBaseController@index');

    /**
     * Category router
     */
    Route::get('/admin/category', 'Admin\CategoryController@index');

    Route::get('/admin/category/create', 'Admin\CategoryController@create');
    Route::post('/admin/category/create', 'Admin\CategoryController@store');

    Route::get('/admin/category/update/{id}', 'Admin\CategoryController@update');
    Route::post('/admin/category/update/{id}', 'Admin\CategoryController@store');

    Route::get('/admin/category/delete/{id}', 'Admin\CategoryController@destroy');
    Route::get('/admin/category/preview', 'Admin\CategoryController@preview');

    /**
     * Product router
     */
    Route::get('/admin/product', 'Admin\ProductController@index');

    Route::get('/admin/product/create', 'Admin\ProductController@create');
    Route::post('/admin/product/create', 'Admin\ProductController@store');

    Route::get('/admin/product/update/{id}', 'Admin\ProductController@update');
    Route::post('/admin/product/update/{id}', 'Admin\ProductController@store');

    Route::get('/admin/product/upload/', 'Admin\ProductController@upload');
    Route::post('/admin/product/upload/', 'Admin\ProductController@upload');
    Route::get('/admin/product/delete/{id}', 'Admin\ProductController@destroy');


    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        $blogs = \App\Blog::orderBy('created_at', 'asc')->get();

        return view('blogs.list', [
            'blogs' => $blogs
        ]);
    });

    Route::get('/blog', function(Request $request) {
        return view('blogs.create');
    });

    /**
     * Add New Task
     */
    Route::post('/blog', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'content' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $blog = new \App\Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->content = $request->content;
        $blog->save();

        return redirect('/');
    });

    /**
     * Delete Task
     */
    Route::delete('/blog/{blog}', function (\App\Blog $task) {
        //
    });
});
