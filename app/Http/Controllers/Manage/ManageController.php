<?php
    //檔案位置:app/Http/Controllers/Manage/ManageController.php
    namespace App\Http\Controllers\Manage;

    use Exception;
    use App\Http\Controllers\Controller;
    use App\Http\Libs\News;
    use App\Http\Libs\Images;
    //use View;

    class ManageController extends Controller {
        public function __construct(){

        }
                
        //首頁
        public function indexPage(){
            $data = [
                'title' => '管理首頁',
            ];

            //if (View::exists('manage.index')) {
            //    return "Y";
            //}else{
            //    return "N";
            //}
            return view('manage.index', $data);
        }
    }
?>