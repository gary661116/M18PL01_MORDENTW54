<?php
    //檔案位置:app/Http/Controllers/AjaxController.php
    namespace App\Http\Controllers;

    use Exception;
    use App\Http\Controllers\Controller;
    use App\Http\Libs\Cimgs;
    use App\Http\Libs\News;
    use App\Http\Libs\User;
    use DB;

    class AjaxController extends Controller {
        public function Img_Upload(){
            // 重组数组，子函数
            function reArrayFiles( $file_post ) {
    
                $file_ary = array();
                $file_count = count($file_post['name']);
                $file_keys = array_keys($file_post);
        
                for ($i=0; $i<$file_count; $i++) {
                    foreach ($file_keys as $key) {
                        $file_ary[$i][$key] = $file_post[$key][$i];
                    }
                }
        
                return $file_ary;
            }

            //參數設定
            $Cimg = new Cimgs();
            //接收傳值
            $input = request()->all();
            $img_no = $input['img_no'];
            $img_cate = $input['img_cate'];
            $img_sty = $input['img_sty'];
            if($img_sty == "S"){
               $img_id = "";
            }else{
               $img_id = $input['img_id'];
            }

            
            $FilePath = "images/"; //public 資料夾下建images
            //$destinationPath = 'storage/uploads/'; //public 文件夹下面建 storage/uploads 文件夹
            $filename = "";
            $imgFiles = $_FILES['pic_' . $img_sty];
            $pre_filename = "";


            //$img_Files =request()->file()
            //$imgFiles = $_FILES['filesToUpload']; // 与前端页面中的 input name=“filesToUpload[]” 相对应
            if(!empty($imgFiles)){
                $img_file = reArrayFiles($imgFiles);
                for($i = 0; $i < count($img_file); $i++){
                      //檔名
                      $savedFile = $img_cate . "_" . $img_no . "_" . $img_sty . "_" . $img_file[$i]['name'];
                      $filename = $FilePath . $savedFile;
                      //存檔
                      move_uploaded_file($img_file[$i]['tmp_name'],  $filename);
                      //抓取資料
                      $chk_file = $Cimg->clist($img_no,$img_sty,$img_cate);
                      $chk_sty = "add";
                       if($img_sty == "S"){
                           if(count($chk_file) > 0){
                               $pre_filename = $FilePath . $chk_file[0]->img_file;
                               $img_id = $chk_file[0]->id;
                               $chk_sty = "edit";
                           }
                       }

                      switch($chk_sty){
                          case "add": //寫入資料庫
                             $Cimg->cinsert($img_no, $savedFile, $img_sty, $img_cate);

                             break;
                          case "edit": //更新資料庫
                             $Cimg->cupdate($img_id, $img_no, $savedFile, $img_sty, $img_cate);
                             //刪除原本所存之圖片
                             if(strlen(trim($pre_filename)) > 0){
                                //判斷檔案存不存在
                                if(\File::exists(trim($pre_filename))){
                                    unlink($pre_filename);//刪除圖片
                                }
                             }
                             break;
                      }

                }
            }

            //抓取資料
            $list = $Cimg->clist($img_no, $img_sty, $img_cate);

            return json_encode($list);
        }

        public function Img_Del(){
            //接收傳值
            $input = request()->all();
            $img_id = $input['img_id'];
            $img_no = $input['img_no'];
            $img_cate = $input['img_cate'];
            $img_sty = $input['img_sty'];            
            $CImg = new Cimgs();
            $list = $CImg->cdel($img_id);

            //抓取資料
            $list = $CImg->clist($img_no, $img_sty, $img_cate);

            return json_encode($list);
        }

        public function uploadImage() {
            $input = request()->all();
            $CKEditor = $input['CKEditor'];
            $funcNum  = $input['CKEditorFuncNum'];
            $message  = $url = '';
            $FilePath = "images/article/"; //public 資料夾下建images       
            $imgFiles = $_FILES['upload'];
            $savedFile = "";
            if(!empty($imgFiles)){
                $savedFile = $imgFiles['name'];
                $temp_file = $imgFiles['tmp_name'];
                $filename = $FilePath . $savedFile;
                //存檔
                move_uploaded_file($temp_file,  $filename);
                $url = url($filename);

                $message = "savedFile:" . $savedFile . ";temp_name:" . $temp_file ;
                
            } else {
                $message = "No file uploaded";
            }

            return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
        }

        public function guessprice(){
            
            $input = request()->all();
            //mem_id: mem_id, guess_price:g_price
            $mem_id = $input['mem_id'];
            $guess_price = $input['guess_price'];
            $guess_sty = "";
            $higher_price = "";
            /*
            //1、抓取拍賣的最近一次價格及時間
            $csql = "select * from guessprice order by g_time desc";
            $list = DB::select($csql);
            if (count($list) > 0) {
                $higher_price = $list[0]->g_price;
                if($guess_price > $higher_price){
                     $guess_sty = "Y";
                }else{
                     $guess_sty = "N";
                }
            }else{
                $guess_sty = "Y";
            }

            if($guess_sty == "Y"){
                $csql = "insert into guessprice(mem_id,g_price,g_time) values(:mem_id,:g_price,now())";
                $input['mem_id'] = $mem_id;
                $input['g_price'] = $guess_price;

                $list = DB::select($csql,$input);
            }

            $csql = "select * from guessprice order by g_time desc";
            $list1 = DB::select($csql);
            $data['guess_sty'] = $guess_sty;
            $data['cdata'] = $list1;
            return json_encode($data);
            */
            return "12345";
            
        }
    }
?>