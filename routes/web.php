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
    Route::any('/news_list','Manage\NewsController@list');
    Route::get('/news_edit','Manage\NewsController@edit');
    Route::get('/news_add','Manage\NewsController@add');
    Route::post('/news_save','Manage\NewsController@save');
    Route::get('/news_del','Manage\NewsController@del');

    //最新消息-類別
    Route::any('/news_cate_list','Manage\NewsController@cate_list');
    Route::get('/news_cate_edit','Manage\NewsController@cate_edit');
    Route::get('/news_cate_add','Manage\NewsController@cate_add');
    Route::post('/news_cate_save','Manage\NewsController@cate_save');
    Route::get('/news_cate_del','Manage\NewsController@cate_del');

    //專案
    Route::any('/proj_list','Manage\ProjectController@list');
    Route::get('/proj_edit','Manage\ProjectController@edit');
    Route::get('/proj_add','Manage\ProjectController@add');
    Route::post('/proj_save','Manage\ProjectController@save');
    Route::get('/proj_del','Manage\ProjectController@del');

    //專案-類別
    Route::any('/proj_cate_list','Manage\ProjectController@cate_list');
    Route::get('/proj_cate_edit','Manage\ProjectController@cate_edit');
    Route::get('/proj_cate_add','Manage\ProjectController@cate_add');
    Route::post('/proj_cate_save','Manage\ProjectController@cate_save');
    Route::get('/proj_cate_del','Manage\ProjectsController@cate_del'); 
    
    //廣告
    Route::any('/adv_list','Manage\AdvController@list');
    Route::get('/adv_edit','Manage\AdvController@edit');
    Route::get('/adv_add','Manage\AdvController@add');
    Route::post('/adv_save','Manage\AdvController@save');
    Route::get('/adv_del','Manage\AdvController@del');

    //廣告-類別
    Route::any('/adv_cate_list','Manage\AdvController@cate_list');
    Route::get('/adv_cate_edit','Manage\AdvController@cate_edit');
    Route::get('/adv_cate_add','Manage\AdvController@cate_add');
    Route::post('/adv_cate_save','Manage\AdvController@cate_save');
    Route::get('/adv_cate_del','Manage\AdvController@cate_del'); 

    //FAQ
    Route::any('/faq_list','Manage\FaqController@list');
    Route::get('/faq_edit','Manage\FaqController@edit');
    Route::get('/faq_add','Manage\FaqController@add');
    Route::post('/faq_save','Manage\FaqController@save');
    Route::get('/faq_del','Manage\FaqController@del');

    //FAQ-類別
    Route::any('/faq_cate_list','Manage\FaqController@cate_list');
    Route::get('/faq_cate_edit','Manage\FaqController@cate_edit');
    Route::get('/faq_cate_add','Manage\FaqController@cate_add');
    Route::post('/faq_cate_save','Manage\FaqController@cate_save');
    Route::get('/faq_cate_del','Manage\FaqController@cate_del');
    
    //關於我們
    Route::any('/aboutus_list','Manage\AboutusController@list');
    Route::get('/aboutus_edit','Manage\AboutusController@edit');
    Route::get('/aboutus_add','Manage\AboutusController@add');
    Route::post('/aboutus_save','Manage\AboutusController@save');
    Route::get('/aboutus_del','Manage\AboutusController@del');

    //關於我們-類別
    Route::any('/aboutus_cate_list','Manage\AboutusController@cate_list');
    Route::get('/aboutus_cate_edit','Manage\AboutusController@cate_edit');
    Route::get('/aboutus_cate_add','Manage\AboutusController@cate_add');
    Route::post('/aboutus_cate_save','Manage\AboutusController@cate_save');
    Route::get('/aboutus_cate_del','Manage\AboutusController@cate_del');     
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