<?php
    //檔案位置:app/Http/Controllers/HomeController.php
    namespace App\Http\Controllers;

    use Exception;
    use App\Http\Controllers\Controller;

    class HomeController extends Controller {
        public function __construct(){

        }  
              
        //首頁
        public function indexPage(){
            return view('welcome');
        }
    }
?>