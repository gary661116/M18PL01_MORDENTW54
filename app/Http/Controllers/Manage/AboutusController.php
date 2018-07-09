<?php
    //檔案位置:app/Http/Controllers/Manage/AboutusController.php
    namespace App\Http\Controllers\Manage;

    use Exception;
    use App\Http\Controllers\Controller;
    use App\Http\Libs\Aboutus;
    use App\Http\Libs\Cimgs;
    //use View;

    class AboutusController extends Controller {
        public function __construct(){

        }

        //關於我們
        public function c_list(){
            //接收傳值
            $input = request()->all();
            //變數設定
            $cmsg= "";
            $txt_title_query = "";
            $page = 1;
            $txt_sort = "";
            $txt_a_d = "";
            $txt_start_date = "";
            $txt_end_date = "";
            $txt_show = "";
            $txt_index = "";
            $txt_cate = "";
            $c_sort = "";

            //排序設定
            if (strlen(trim($txt_sort)) > 0)
            {
                $c_sort .= "a1." + $txt_sort;
            }

            if (strlen(trim($txt_a_d)) > 0)
            {
                $c_sort = $c_sort + " " + $txt_a_d;
            }

            $CAboutus = new Aboutus();
            $info1 = $CAboutus->cate_list("","","Y","");
            $d_cate = $info1['list'];
            $info = $CAboutus->clist("",$c_sort,$txt_show,$txt_title_query,$txt_cate);
            //抓取最新消息資料

            
            $data = [
                'title' => '關於我們',
                'info' => $info ,
                'd_cate' => $d_cate,
                'page' => $page ,
                'txt_title_query' => $txt_title_query,
                'txt_sort' => $txt_sort,
                'txt_a_d' => $txt_a_d,
                'txt_show' => $txt_show,                
                'txt_cate' => $txt_cate,                 
            ];

            return view('manage.aboutus_list', $data);
        }

        //關於我們-新增
        public function c_add(){
            $CAboutus = new Aboutus();
            $CImg = new Cimgs();
            $info1 = $CAboutus->cate_list("","","Y","");
            $d_cate = $info1['list'];    
            $d_img = $CImg->clist("","aboutus");   
            $data = [
                'title' => '關於我們',
                'action_sty' => 'add',
                'd_cate' => $d_cate,
                'd_img' => $d_img,     
            ];

            return view('manage.aboutus_data', $data);            
        }

        //關於我們-修改
        public function c_edit(){
            //接收傳值
            $input = request()->all();
            $id = $input['id'];
            $CImg = new Cimgs();
            $CAboutus = new Aboutus();
            $info1 = $CAboutus->cate_list("","","Y","");
            $d_cate = $info1['list'];       
            $d_img = $CImg->clist($id,"");
            $info = $CAboutus->clist($id,"","","","","","","");
            $data = [
                'title' => '關於我們',
                'action_sty' => 'edit',
                'info' => $info ,
                'd_cate' => $d_cate,
                'd_img' => $d_img,     
            ];

            return view('manage.aboutus_data', $data);    
        }

        //關於我們-刪除
        public function c_del(){
            //接收傳值
            $input = request()->all();
            $id = $input['id'];

            $CAboutus = new Aboutus();
            //刪除
            $info = $CAboutus->cdel($id);
            //重新導回首頁
            return redirect('/manage/aboutus_list');
        }

        //關於我們-儲存
        public function c_save(){
            //接收傳值
            $input = request()->all();
            $id = $input['id'];
            $c_title = $input['c_title'];
            $c_desc = $input['c_desc'];
            $show = $input['show'];
            $sort = $input['sort'];
            $cate_id = $input['cate_id'];
            $img_no =$input['img_no'];
            $action_sty = $input['action_sty'];
            
            $CAboutus = new Aboutus();

            switch($action_sty){
                case "add":
                    $CAboutus->cinsert($c_title, $c_desc, $show, $sort, $cate_id, $img_no, session("signin_id"));
                    break;
                case "edit":
                    $CAboutus->cupdate($id, $c_title, $c_desc, $show, $sort, $cate_id, session("signin_id"));
                    break;
            }
            
            //重新導回首頁
            return redirect('/manage/aboutus_list');
        }

        //關於我們-類別
        public function cate_list(){
            //接收傳值
            $input = request()->all();
            //變數設定
            $cmsg= "";
            $c_sort = "";
            $page = 1;
            $txt_title_query = "";
            $txt_sort = "";
            $txt_a_d = "";
            $txt_show = "";

            if(!empty($input)){
                $txt_title_query = $input['txt_title_query'];
                $txt_sort = $input['txt_sort'];
                $txt_a_d = $input['txt_a_d'];
                $txt_show = $input['txt_show'];
            }


            //排序設定
            if (strlen(trim($txt_sort)) > 0)
            {
                $c_sort .= "a1." + $txt_sort;
            }
            if (strlen(trim($txt_a_d)) > 0)
            {
                $c_sort = $c_sort + " " + $txt_a_d;
            }
            $C_Cate = new Aboutus();
            
            $info1 = $CAboutus->cate_list("",$c_sort,$txt_show,$txt_title_query);
            
            $info = $info1['list'];
            $csql = $info1['csql'];
            $status = $info1['status'];

            $data = [
                'title' => '關於我們類別',
                'info' => $info ,
                'page' => $page ,
                'txt_title_query' => $txt_title_query,
                'txt_sort' => $txt_sort,
                'txt_a_d' => $txt_a_d,
                'csql' => $csql,
                'status' => $status,
                'txt_show' => $txt_show,
            ];

            return view('manage.aboutus_cate_list', $data);
        }
        
        //關於我們-類別-新增
        public function cate_add(){
            $data = [
                'title' => '關於我們類別-新增',
                'action_sty' => 'add' ,
            ];
            
            return view('manage.aboutus_cate_data', $data);
        }

        //關於我們-類別-修改
        public function cate_edit(){
            //接收傳值
            $input = request()->all();
            $cate_id = $input['cate_id'];
            
            $C_Cate = new Aboutus();
            $info1 = $C_Cate->cate_list($cate_id,"","","");
            $info = $info1['list'];

            $data = [
                'title' => '關於我們類別-修改',
                'action_sty' => 'edit' ,
                'info' => $info,
            ]; 
            
            return view('manage.aboutus_cate_data', $data);
        }

        //關於我們-類別-儲存
        public function cate_save(){
            //接收傳值
            $input = request()->all();
            $action_sty = $input['action_sty'];
            $cate_id = $input['cate_id'];
            $cate_name = $input['cate_name'];
            $cate_desc = $input['cate_desc'];
            $show = $input['show'];
            $sort = $input['sort'];

            $C_Cate = new Aboutus();

            switch($action_sty){
                case "add":
                    $C_Cate->cate_insert($cate_name,$cate_desc,$show,$sort,session("signin_id"));
                    break;
                case "edit":
                    $C_Cate->cate_update($cate_id,$cate_name,$cate_desc,$show,$sort,session("signin_id"));
                    break;
            }

            //重新導回首頁
            return redirect('/manage/aboutus_cate_list');
        }

        //關於我們-類別-刪除
        public function cate_del(){
            //接收傳值
            $input = request()->all();
            $cate_id = $input['cate_id'];

            $C_Cate = new Aboutus();
            //刪除
            $info1 = $C_Cate->cate_del($cate_id);
            //重新導回首頁
            return redirect('/manage/aboutus_cate_list');
        }
          
    }
?>