<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

 // 認證路由  
Route::group(['prefix' => 'auth'], function () {  
   // 登入路由  
 Route::get('login', ['as' => 'auth.login', 'uses' => 'MyAuthController@getLogin']);  
 Route::post('login', ['as' => 'auth.login', 'uses' => 'MyAuthController@postLogin']);  
   // 登出路由  
 Route::get('logout', ['as' => 'auth.logout', 'uses' => 'MyAuthController@getLogout']);  
   // 註冊路由  
   // Route::get('register', ['as' => 'auth.register', 'uses' => 'AuthController@getRegister']);  
   // Route::post('register', ['as' => 'auth.register', 'uses' => 'AuthController@postRegister']);  
   // 驗證信箱路由   
   // Route::get('verify/{id}/{code}', ['as' => 'auth.verify', 'uses' => 'AuthController@getConfirm']);   
});  

  // 首頁路由  
Route::group(['prefix' => '', 'namespace' => 'Web', 'middleware' => 'auth'], function () {  
     // Route::group(['middleware' => 'superadmin'], function (){  
     //     Route::get('system_manage', ['as' => 'admin.system_manage', 'uses' => 'HomeController@index']);   
     // });  

     //首頁
    Route::get('/', ['as' => 'web.index', 'uses' => 'HomeController@index']);   

    Route::get('/index',['as' => 'web.index', 'uses' => 'HomeController@index']);

    Route::get('/profile',['as' => 'profile.index' ,'uses' => 'HomeController@profileIndex']);

    Route::post('/profile/Edit',['as' => 'profile.edit' ,'uses' => 'HomeController@profileEdit']);

    //Service
    Route::get('/getUserImg',['as' => 'web.getUserImg','uses' => 'HomeController@getUserimg']);

    ///
    /// 管理權限路由
    ///
    Route::group(['middleware' => 'ManageAccess'],function(){
        //管理頁面首頁
        Route::get('/Manage/Index',['as' => 'manage.index','uses' => 'ManageController@index']);

        //帳號管理
        Route::get('/Manage/Account',['as' => 'manage.account','uses' => 'ManageController@accountIndex']);

        Route::get('/Manage/AccountAdd',['as' => 'manage.accountAdd','uses' => 'ManageController@accountAddView']);

        Route::post('/Manage/AccountAdd',['as' => 'manage.accountAdd','uses' => 'ManageController@accountDoAdd']);

        Route::get('/Manage/AccountEdit/{id}',['as' => 'manage.accountEdit','uses' => 'ManageController@accountEditView']);

        Route::post('/Manage/AccountEdit',['as' => 'manage.accountEdit','uses' => 'ManageController@accountDoEdit']);

        Route::get('/Manage/AccountDel',['as' => 'manage.accountDel','uses' => 'ManageController@accountDoDel']);


        //分類管理
        Route::get('/Manage/Categories',['as' => 'manage.categories','uses' => 'ManageController@CategoriesIndex']);

        Route::get('/Manage/CategoriesAdd/{parent_id?}',['as' => 'manage.categoriesAdd','uses' => 'ManageController@CategoriesAddView']);

        Route::post('/Manage/CategoriesAdd',['as' => 'manage.categoriesAdd','uses' => 'ManageController@CategoriesDoAdd']);

        Route::get('/Manage/CategoriesEdit/{id}',['as' => 'manage.categoriesEdit','uses' => 'ManageController@CategoriesEditView']);

        Route::post('/Manage/CategoriesEdit',['as' => 'manage.categoriesEdit','uses' => 'ManageController@CategoriesDoEdit']);

        Route::get('/Manage/CategoriesDel',['as' => 'manage.categoriesDel','uses' => 'ManageController@CategoriesDoDel']);


        //分類權限管理
        Route::get('/Manage/CategoriesAuth/{uid}',['as' => 'manage.categoriesAuth','uses' => 'ManageController@CategoriesAuthIndex']);

        Route::get('/Manage/CategoriesAuthAdd/{uid}',['as' => 'manage.categoriesAuthAdd','uses' => 'ManageController@CategoriesAuthAddView']);

        Route::post('/Manage/CategoriesAuthAdd',['as' => 'manage.categoriesAuthAdd','uses' => 'ManageController@CategoriesAuthDoAdd']);

        Route::get('/Manage/CategoriesAuthDel',['as' => 'manage.categoriesAuthDel','uses' => 'ManageController@CategoriesAuthDoDel']);    
    });

     //紀錄看板
Route::get('/Record/Index/{id?}',['as' => 'record.index','uses' => 'RecordController@Index']);
Route::get('/Record/show/{id}',['as' => 'record.show','uses' => 'RecordController@show']);
Route::get('/Record/Create/{id}',['as' => 'record.create', 'uses' => 'RecordController@Create']);
Route::post('/Record/Create',['as' => 'record.create' , 'uses' => 'RecordController@CreateDoAdd']);
Route::get('/Record/Edit/{id}',['as' => 'record.edit', 'uses' => 'RecordController@edit']);
Route::post('/Record/Edit',['as' => 'record.edit' , 'uses' => 'RecordController@Doedit']);
Route::get('/Record/Del',['as' => 'record.del' , 'uses' => 'RecordController@DoDel']);

    //討論區
Route::get('/Posts/Index/{id?}',['as' => 'posts.index','uses' => 'PostsController@Index']);
Route::get('/Posts/show/{id}',['as' => 'posts.show','uses' => 'PostsController@show']);
Route::get('/Posts/Create/{id}',['as' => 'posts.create', 'uses' => 'PostsController@Create']);
Route::post('/Posts/Create',['as' => 'posts.create' , 'uses' => 'PostsController@CreateDoAdd']);
Route::get('/Posts/Edit/{id}',['as' => 'posts.edit', 'uses' => 'PostsController@edit']);
Route::post('/Posts/Edit',['as' => 'posts.edit' , 'uses' => 'PostsController@Doedit']);
Route::get('/Posts/Del',['as' => 'posts.del' , 'uses' => 'PostsController@DoDel']);

Route::get('/Posts/reply/Add/{id}',['as' => 'posts.reply.add','uses' => 'PostsController@ReplyAdd']);
Route::post('/Posts/reply/Add',['as' => 'posts.reply.add' , 'uses' => 'PostsController@ReplyDoAdd']);
Route::get('/Posts/reply/Edit/{id}',['as' => 'posts.reply.edit' , 'uses' => 'PostsController@ReplyEdit']);
Route::post('/Posts/reply/Edit',['as' => 'posts.reply.edit' , 'uses' => 'PostsController@ReplyDoedit']);
Route::get('/Posts/reply/Del',['as' => 'posts.reply.del' , 'uses' => 'PostsController@ReplyDel']);

}); 