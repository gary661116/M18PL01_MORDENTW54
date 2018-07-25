<?php
    //檔案位置:app/Http/Controllers/HomeController.php
    namespace App\Http\Controllers;

    use Exception;
    use App\Http\Controllers\Controller;

    use DB;

    class HomeController extends Controller {
        public function __construct(){

        }  
              
        //首頁
        public function indexPage(){
            return view('welcome');
        }

        //首頁
        public function demo(){
            //接收傳值
            $input = request()->all();     
            $fb_url = "";       
            if(!empty($input)){
                $fb_url = $input['fb_url'];
            }  
            
            $data = [
                'title' => '關於我們',
                'fb_url' => $fb_url ,          
            ];

            return view('demo', $data);
        }        

        //首頁
        public function demo2(){
            //接收傳值
            $input = request()->all();     
            $fb_url = ""; 
            $fb_urla = "";      
            if(!empty($input)){
                $fb_url = $input['fb_url'];
            }  
            
            $fb_urla = str_replace("/","%2F",str_replace(":","%3A",$fb_url));
            $data = [
                'title' => '關於我們',
                'fb_url' => $fb_url ,
                'fb_urla' => $fb_urla ,          
            ];

            return view('demo2', $data);
        }  
        
        //首頁
        public function guessprice  (){

            $csql = "select * from guessprice order by g_time desc";
            $list1 = DB::select($csql);
            $data = [
                'title' => '競價畫面',        
                'info' => $list1,
            ];

            return view('guessprice', $data);
        }          
    }
?>