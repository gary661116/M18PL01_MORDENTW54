<?php
   //檔案位置 app/Http/Libs/Images.php
   namespace App\Http\Libs;

   use DB;

   class Images{
       //-----------------------------------------------------------------------------------------------------------------//
       //基本資料
       //-----------------------------------------------------------------------------------------------------------------//
       //資料呈現
       public function clist($img_no = "", $img_sty = "", $img_kind = "", $img_id = ""){
        $cimg_no = explode(',',$img_no);
        $cimg_id = explode(',',$img_id);
        $csql = "select *, Replace(img_file,:oriFileNameReplace,'') as img_ori_name from img where status = 'Y' ";

        $input['oriFileNameReplace'] = $img_kind . "_" . $img_no . "_" . $img_sty . "_";
        $input_chk = "";

        if(strlen(trim($img_no)) > 0 && $img_no != "ALL"){
            $input_chk = "Y";
            $csql .= " and img_no in (";
            
            for($i = 0; $i < count($cimg_no); $i++){
                if($i > 0){
                    $csql .= ",";
                }
                $csql .= ":img_no" . $i;
                $input['img_no' . $i] = $cimg_no[$i];
            }

            $csql .= " ) ";
        }

        if(strlen(trim($img_id)) > 0){
            $input_chk = "Y";
            $csql .= " and id in (";
            
            for($i = 0; $i < count($cimg_id); $i++){
                if($i > 0){
                    $csql .= ",";
                }
                $csql .= ":img_id" . $i;
                $input['img_id' . $i] = $cimg_id[$i];
            }

            $csql .= " ) ";            
        }

        if(strlen(trim($img_sty)) > 0){
            $input_chk = "Y";
            $csql .= " and img_sty = :img_sty ";
            $input['img_sty'] = $img_sty; 
        }

        if(strlen(trim($img_kind)) > 0){
            $input_chk = "Y";
            $csql .= " and img_kind = :img_kind ";
            $input['img_kind'] = $img_kind; 
        }

        $csql .= "order by "
               . "   sort desc, img_file desc "; //順序:1."排序"降冪排序 2."檔名"升冪排序

        if($input_chk == "Y"){
            $list = DB::select($csql,$input);
        }else{
            $list = DB::select($csql);
        }

        return $list;
    }

    public function cinsert($img_no = "", $img_file = "", $img_sty = "", $img_kind = "", $img_desc = "", $is_index = "N"){
        $csql = "insert into img(img_no, img_file, img_sty,img_kind,img_desc,is_index) "
              . "values(:img_no ,:img_file ,:img_sty, :img_kind, :img_desc, :is_index)";
        $input['img_no'] = $img_no;
        $input['img_file'] = $img_file;
        $input['img_sty'] = $img_sty;
        $input['img_kind'] = $img_kind;
        $input['img_desc'] = $img_desc;
        $input['is_index'] = $is_index;

        $list = DB::select($csql,$input);
    }

    public function cupdate($img_id = "", $img_no = "", $img_file = "", $img_sty = "", $img_kind = "", $img_desc = "", $is_index = "", $img_sort = 0){
          $csql = "";
          $c_update = "";
          if(strlen(trim($img_no)) > 0){
              if(strlen(trim($c_update)) > 0){
                  $c_update .= ",";
              }
              $c_update .= "img_no = :img_no";
              $input['img_no'] = $img_no;
          }

          if(strlen(trim($img_file)) > 0){
            if(strlen(trim($c_update)) > 0){
                $c_update .= ",";
            }
            $c_update .= "img_file = :img_file";
            $input['img_file'] = $img_file;
        }

        if(strlen(trim($img_sty)) > 0){
            if(strlen(trim($c_update)) > 0){
                $c_update .= ",";
            }
            $c_update .= "img_sty = :img_sty";
            $input['img_sty'] = $img_sty;
        } 

        if(strlen(trim($img_kind)) > 0){
            if(strlen(trim($c_update)) > 0){
                $c_update .= ",";
            }
            $c_update .= "img_kind = :img_kind";
            $input['img_kind'] = $img_kind;
        }        

        if(strlen(trim($img_desc)) > 0){
            if(strlen(trim($c_update)) > 0){
                $c_update .= ",";
            }
            $c_update .= "img_desc = :img_desc";
            $input['img_desc'] = $img_file;
        }

        if($img_sort > 0){
            if(strlen(trim($c_update)) > 0){
                $c_update .= ",";
            }
            $c_update .= "img_sort = :img_sort";
            $input['img_sort'] = $img_kind;
        }        

        if(strlen(trim($c_update)) > 0){
            $csql = "update img set " . $c_update . " where id = :img_id ";
            $input['img_id'] = $img_id;
        }

        DB::select($csql,$input);
    }

    public function cdel($img_id = ""){
       $csql = "delete from img where id = :img_id";
       $input['img_id'] = $img_id;

       DB::select($csql,$input);
    }

       //-----------------------------------------------------------------------------------------------------------------//
   }
?>