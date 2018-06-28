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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','HomeController@indexPage');
//Route::get('/sign-in','UserAuthController@signInPage');

Route::group(['prefix' => 'manage'],function(){
    Route::get('/','Manage\ManageController@indexPage');
    //最新消息
    Route::any('/news_list','Manage\NewsController@news_list');
    Route::get('/news_edit','Manage\NewsController@news_edit');
    Route::get('/news_add','Manage\NewsController@news_add');
    Route::post('/news_save','Manage\NewsController@news_save');
    Route::get('/news_del','Manage\NewsController@news_del');

    //最新消息-類別
    Route::any('/news_cate_list','Manage\NewsController@news_cate_list');
    Route::get('/news_cate_edit','Manage\NewsController@news_cate_edit');
    Route::get('/news_cate_add','Manage\NewsController@news_cate_add');
    Route::post('/news_cate_save','Manage\NewsController@news_cate_save');
    Route::get('/news_cate_del','Manage\NewsController@news_cate_del');

    //專案
    Route::any('/proj_list','Manage\ProjectController@proj_list');
    Route::get('/proj_edit','Manage\ProjectController@proj_edit');
    Route::get('/proj_add','Manage\ProjectController@proj_add');
    Route::post('/proj_save','Manage\ProjectController@proj_save');
    Route::get('/proj_del','Manage\ProjectController@proj_del');

    //專案-類別
    Route::any('/proj_cate_list','Manage\ProjectController@proj_cate_list');
    Route::get('/proj_cate_edit','Manage\ProjectController@proj_cate_edit');
    Route::get('/proj_cate_add','Manage\ProjectController@proj_cate_add');
    Route::post('/proj_cate_save','Manage\ProjectController@proj_cate_save');
    Route::get('/proj_cate_del','Manage\ProjectsController@proj_cate_del'); 
    
    //廣告
    Route::any('/adv_list','Manage\AdvController@adv_list');
    Route::get('/adv_edit','Manage\AdvController@adv_edit');
    Route::get('/adv_add','Manage\AdvController@adv_add');
    Route::post('/adv_save','Manage\AdvController@adv_save');
    Route::get('/adv_del','Manage\AdvController@adv_del');

    //廣告-類別
    Route::any('/adv_cate_list','Manage\AdvController@adv_cate_list');
    Route::get('/adv_cate_edit','Manage\AdvController@adv_cate_edit');
    Route::get('/adv_cate_add','Manage\AdvController@adv_cate_add');
    Route::post('/adv_cate_save','Manage\AdvController@adv_cate_save');
    Route::get('/adv_cate_del','Manage\AdvController@adv_cate_del'); 
});

Route::group(['prefix' => 'usr'],function(){
    //--------------------------------------------------------//
    //登入
    Route::get('/sign-in','UserAuthController@signInPage');
    Route::post('/sign-in','UserAuthController@signInProcess');
    //--------------------------------------------------------//
    //登出
    Route::get('/sign-out','UserAuthController@signOut');
    //--------------------------------------------------------//
    // Facebook 登入
    Route::get('/facebook-sign-in', 'UserAuthController@facebookSignInProcess');
    // Facebook 登入重新導向授權資料處理
    Route::get('/facebook-sign-in-callback', 'UserAuthController@facebookSignInCallbackProcess'); 
    //--------------------------------------------------------//
    //註冊
    Route::get('/sign-up', 'UserAuthController@signUpPage');
    Route::post('/sign-up', 'UserAuthController@signUpProcess');
    //--------------------------------------------------------//
});

//Ajax
Route::group(['prefix' => 'ajax'],function(){
    //圖片
    Route::post('/img_upload','AjaxController@Img_Upload');
    Route::post('/img_del','AjaxController@Img_Del');
    Route::post('/upload_image','AjaxController@uploadImage')->name('ckupload');;
    //Route::controller('/pic_upload','AjaxController@UploadPicture'); 
});

Route::get('ckeditor-demo',function(){
    return view('ckeditor.index');
});
// //驗證碼
// Route::get('captcha/test','CaptchaController@index');
// Route::get('captcha/mews','CaptchaController@mews');