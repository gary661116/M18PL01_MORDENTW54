<?php
    //檔案位置:app/Http/Controllers/Manage/AdvController.php
    namespace App\Http\Controllers\Manage;

    use Exception;
    use App\Http\Controllers\Controller;
    use App\Http\Libs\Advertisement;
    use App\Http\Libs\Cimgs;
    //use View;

    class AdvController extends Controller {
        public function __construct(){

        }

        //廣告
        public function list(){
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

            $CAdv = new Advertisement();
            $info1 = $CAdv->cate_list("","","Y","");
            $d_cate = $info1['list'];
            $info = $CAdv->clist("",$c_sort,$txt_show,$txt_title_query,$txt_start_date,$txt_end_date,$txt_index,$txt_cate);
            //抓取廣告資料

            
            $data = [
                'title' => '廣告陳列',
                'info' => $info ,
                'd_cate' => $d_cate,
                'page' => $page ,
                'txt_title_query' => $txt_title_query,
                'txt_sort' => $txt_sort,
                'txt_a_d' => $txt_a_d,
                'txt_show' => $txt_show,                
                'txt_index' => $txt_index,
                'txt_start_date' => $txt_start_date,
                'txt_end_date' => $txt_end_date,
                'txt_cate' => $txt_cate,                 
            ];

            return view('manage.adv_list', $data);
        }

        //廣告-新增
        public function add(){
            $CAdv = new Advertisement();
            $CImg = new Cimgs();
            $info1 = $CAdv->cate_list("","","Y","");
            $d_cate = $info1['list'];    
            $d_img = $CImg->clist("","news");   
            $data = [
                'title' => '廣告',
                'action_sty' => 'add',
                'd_cate' => $d_cate,
                'd_img' => $d_img,     
            ];

            return view('manage.adv_data', $data);            
        }

        //廣告-修改
        public function edit(){
            //接收傳值
            $input = request()->all();
            $id = $input['id'];
            $CImg = new Cimgs();
            $CAdv = new Advertisement();
            $info1 = $CAdv->cate_list("","","Y","");
            $d_cate = $info1['list'];       
            $d_img = $CImg->clist($id,"news");
            $info = $CAdv->clist($id,"","","","","","","");
            $data = [
                'title' => '廣告',
                'action_sty' => 'edit',
                'info' => $info ,
                'd_cate' => $d_cate,
                'd_img' => $d_img,     
            ];

            return view('manage.adv_data', $data);    
        }

        //廣告-刪除
        public function del(){
            //接收傳值
            $input = request()->all();
            $id = $input['id'];

            $CAdv = new Advertisement();
            //刪除
            $info = $CAdv->cdel($id);
            //重新導回首頁
            return redirect('/manage/adv_list');
        }

        //廣告-儲存
        public function save(){
            //接收傳值
            $input = request()->all();
            $id = $input['id'];
            $c_title = $input['c_title'];
            $c_desc = $input['c_desc'];
            $c_date = $input['c_date'];
            $show = $input['show'];
            $hot = $input['hot'];
            $sort = $input['sort'];
            $cate_id = $input['cate_id'];
            $img_no =$input['img_no'];
            $action_sty = $input['action_sty'];
            $c_memo = "";

            $CAdv = new Advertisement();

            switch($action_sty){
                case "add":
                    $CAdv->cinsert($c_title, $c_date, $c_desc, $show, $hot, $sort, $c_memo, $cate_id, $img_no, session("signin_id"));
                    break;
                case "edit":
                    $CAdv->cupdate($id, $c_title, $c_date, $c_desc, $show, $hot, $sort, $c_memo, $cate_id, session("signin_id"));
                    break;
            }
            
            //重新導回首頁
            return redirect('/manage/adv_list');
        }

        //廣告-類別
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
            $CAdv = new Advertisement();
            
            $info1 = $CAdv->cate_list("",$c_sort,$txt_show,$txt_title_query);
            
            $info = $info1['list'];
            $csql = $info1['csql'];
            $status = $info1['status'];

            $data = [
                'title' => '廣告類別',
                'info' => $info ,
                'page' => $page ,
                'txt_title_query' => $txt_title_query,
                'txt_sort' => $txt_sort,
                'txt_a_d' => $txt_a_d,
                'csql' => $csql,
                'status' => $status,
                'txt_show' => $txt_show,
            ];

            return view('manage.adv_cate_list', $data);
        }
        
        //廣告-類別-新增
        public function cate_add(){
            $data = [
                'title' => '廣告類別-新增',
                'action_sty' => 'add' ,
            ];
            
            return view('manage.adv_cate_data', $data);
        }

        //廣告-類別-修改
        public function cate_edit(){
            //接收傳值
            $input = request()->all();
            $cate_id = $input['cate_id'];
            
            $CAdv = new Advertisement();
            $info1 = $CAdv->cate_list($cate_id,"","","");
            $info = $info1['list'];

            $data = [
                'title' => '廣告類別-修改',
                'action_sty' => 'edit' ,
                'info' => $info,
            ]; 
            
            return view('manage.adv_cate_data', $data);
        }

        //廣告-類別-儲存
        public function cate_save(){
            //接收傳值
            $input = request()->all();
            $action_sty = $input['action_sty'];
            $cate_id = $input['cate_id'];
            $cate_name = $input['cate_name'];
            $cate_desc = $input['cate_desc'];
            $show = $input['show'];
            $sort = $input['sort'];

            $CAdv = new Advertisement();

            switch($action_sty){
                case "add":
                    $CAdv->cate_insert($cate_name,$cate_desc,$show,$sort,session("signin_id"));
                    break;
                case "edit":
                    $CAdv->cate_update($cate_id,$cate_name,$cate_desc,$show,$sort,session("signin_id"));
                    break;
            }

            //重新導回首頁
            return redirect('/manage/adv_cate_list');
        }

        //廣告-類別-刪除
        public function cate_del(){
            //接收傳值
            $input = request()->all();
            $cate_id = $input['cate_id'];

            $CAdv = new Advertisement();
            //刪除
            $info1 = $CAdv->cate_del($cate_id);
            //重新導回首頁
            return redirect('/manage/adv_cate_list');
        }
               
    }
?>