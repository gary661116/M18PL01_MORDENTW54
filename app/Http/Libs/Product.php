<?php
   //檔案位置 app/Http/Libs/Product.php
   namespace App\Http\Libs;

   use DB;

   class Product{
   //類別屬性
       //------------------------------------------------------------------------------------------------------------------//
       private $cates_dbf_name = "prod_cate_s";
       private $cateb_dbf_name = "prod_cate_b";
       private $dbf_name = "prod";
       private $img_kind = "prod";
       //-----------------------------------------------------------------------------------------------------------------//
       //類別
       //-----------------------------------------------------------------------------------------------------------------//
       //大類_呈現
       public function cateb_list($cate_id = "", $sort = "", $status = "", $title_query = ""){
            $array_title_query = explode(',',$title_query);
            $array_cate_id = explode(',',$cate_id);
            $csql = "";
            $input_chk = "";

            $csql = "select "
                  . "  a1.* "
                  . "from "
                  . "  " . $this->cateb_dbf_name . " a1 "
                  . "where "
                  . "  a1.status <> 'D' ";
              
            if(!empty($cate_id)){
                //$csql .= "and a1.id = :id";
                $csql .= "and a1.id in (";
                for($i = 0 ; $i < count($array_cate_id); $i++){
                    if($i > 0){
                        $csql .= ",";
                    }
                    $csql .= ":cate_id" . $i;

                    $input['cate_id' . $i] = $array_cate_id[$i];
                }
                $csql .= ")";
                //$input['id'] = $id;
                $input_chk = "Y";
            }            

            if(!empty($title_query)){
                //$csql .= "and a1.id = :id";
                $csql .= "and (";
                for($i = 0 ; $i < count($array_title_query); $i++){
                    if($i > 0){
                        $csql .= " or ";
                    }
                    $csql .= "a1.cate_name like :cate_name" . $i;

                    $input['cate_name' . $i] = "%" . $array_title_query[$i] . "%";
                }
                $csql .= ")";
                //$input['id'] = $id;
                $input_chk = "Y";
            }  
            
            if(strlen(trim($status)) > 0){
                $csql .= "and a1.status = :status ";
                $input['status'] = $status;
                $input_chk = "Y";
            }

            $csql .= "order by ";
            if(empty($sort)){
            $csql .= "  a1.id "; 
            }else{
            $csql .= "  " . $sort . " ";
            }

            if($input_chk == "Y"){
                $list = DB::select($csql,$input);
            }else{
                $list = DB::select($csql);
            }
            
            $rtn['list'] = $list;
            $rtn['csql'] = $csql;
            $rtn['status'] = $status;

            return $rtn;
       }

       //新增
       public function cateb_insert($cate_name = "",$cate_desc = "", $show = "", $sort = "", $bd_id = "System"){
           if($sort == ""){
               $sort = "0";
           }
            $csql = "insert into " . $this->cateb_dbf_name . "(cate_name, cate_desc, sort, status, bd_id, bd_dt) "
                  . "values(:cate_name, :cate_desc, :sort, :show, :bd_id, now())";

            $input['cate_name'] = $cate_name;
            $input['cate_desc'] = $cate_desc;
            $input['show'] = $show;
            $input['sort'] = $sort;
            $input['bd_id'] = $bd_id; 
            
            $list = DB::select($csql,$input);            
       }

       //更新
       public function cateb_update($cate_id = "", $cate_name = "", $cate_desc = "", $show = "", $sort = "",$upd_id = "System"){
            $csql = "update "
                  . "  " . $this->cateb_dbf_name . " "
                  . "set "
                  . "  cate_name = :cate_name "
                  . ", cate_desc = :cate_desc "
                  . ", status = :show "
                  . ", sort = :sort "
                  . ", upd_id = :upd_id "
                  . ", upd_dt = now() "
                  . "where "
                  . "  id = :cate_id ";
            
            $input['cate_id'] = $cate_id;
            $input['cate_name'] = $cate_name;
            $input['cate_desc'] = $cate_desc;
            $input['show'] = $show;
            $input['sort'] = $sort;
            $input['upd_id'] = $upd_id;

            $list = DB::select($csql,$input);
       }

       //刪除
       public function cateb_del($cate_id){
            //刪除消息圖片
            //刪除消息資料
            //刪除消息類別資料
            $csql = "delete from "
                  . "  " . $this->cateb_dbf_name . " "
                  . "where "
                  . "  id = :cate_id ";
            
            $input['cate_id'] = $cate_id;

            //DB::statement('drop table users');
            
            $list = DB::select($csql,$input);
       }

        //小類_呈現
        public function cates_list($cate_id = "", $sort = "", $status = "", $title_query = "",$cateb_id = ""){
            $array_title_query = explode(',',$title_query);
            $array_cate_id = explode(',',$cate_id);
            $array_cateb_id = explode(',',$cateb_id);
            $csql = "";
            $input_chk = "";

            $csql = "select "
                . "  a1.* "
                . "from "
                . "  " . $this->cates_dbf_name . " a1 "
                . "where "
                . "  a1.status <> 'D' ";
            
            if(!empty($cate_id)){
                //$csql .= "and a1.id = :id";
                $csql .= "and a1.id in (";
                for($i = 0 ; $i < count($array_cate_id); $i++){
                    if($i > 0){
                        $csql .= ",";
                    }
                    $csql .= ":cate_id" . $i;

                    $input['cate_id' . $i] = $array_cate_id[$i];
                }
                $csql .= ")";
                //$input['id'] = $id;
                $input_chk = "Y";
            }            

            if(!empty($cateb_id)){
                //$csql .= "and a1.id = :id";
                $csql .= "and a1.cate_id in (";
                for($i = 0 ; $i < count($array_cateb_id); $i++){
                    if($i > 0){
                        $csql .= ",";
                    }
                    $csql .= ":cateb_id" . $i;

                    $input['cateb_id' . $i] = $array_cateb_id[$i];
                }
                $csql .= ")";
                //$input['id'] = $id;
                $input_chk = "Y";
            }      

            if(!empty($title_query)){
                //$csql .= "and a1.id = :id";
                $csql .= "and (";
                for($i = 0 ; $i < count($array_title_query); $i++){
                    if($i > 0){
                        $csql .= " or ";
                    }
                    $csql .= "a1.cate_name like :cate_name" . $i;

                    $input['cate_name' . $i] = "%" . $array_title_query[$i] . "%";
                }
                $csql .= ")";
                //$input['id'] = $id;
                $input_chk = "Y";
            }  
            
            if(strlen(trim($status)) > 0){
                $csql .= "and a1.status = :status ";
                $input['status'] = $status;
                $input_chk = "Y";
            }

            $csql .= "order by ";
            if(empty($sort)){
            $csql .= "  a1.id "; 
            }else{
            $csql .= "  " . $sort . " ";
            }

            if($input_chk == "Y"){
                $list = DB::select($csql,$input);
            }else{
                $list = DB::select($csql);
            }
            
            $rtn['list'] = $list;
            $rtn['csql'] = $csql;
            $rtn['status'] = $status;

            return $rtn;
    }

    //新增
    public function cates_insert($cate_name = "",$cate_desc = "", $show = "", $sort = "", $bd_id = "System",$cateb_id = ""){
        if($sort == ""){
            $sort = "0";
        }

        if(empty($cateb_id)){
            $cateb_id = "0";
        }

            $csql = "insert into " . $this->cateb_dbf_name . "(cate_name, cate_desc, sort, status, bd_id, bd_dt,cate_id) "
                . "values(:cate_name, :cate_desc, :sort, :show, :bd_id, now(), :cateb_id)";

            $input['cateb_id'] = $cateb_id;    
            $input['cate_name'] = $cate_name;
            $input['cate_desc'] = $cate_desc;
            $input['show'] = $show;
            $input['sort'] = $sort;
            $input['bd_id'] = $bd_id; 
            
            $list = DB::select($csql,$input);            
    }

    //更新
    public function cates_update($cate_id = "", $cate_name = "", $cate_desc = "", $show = "", $sort = "",$upd_id = "System", $cateb_id = ""){
            if(empty($cateb_id)){
               $cateb_id = "";
            }

            $csql = "update "
                . "  " . $this->cates_dbf_name . " "
                . "set "
                . "   cate_id = :cateb_id "
                . ",  cate_name = :cate_name "
                . ", cate_desc = :cate_desc "
                . ", status = :show "
                . ", sort = :sort "
                . ", upd_id = :upd_id "
                . ", upd_dt = now() "
                . "where "
                . "  id = :cate_id ";
            
            $input['cateb_id'] = $cateb_id;
            $input['cate_id'] = $cate_id;
            $input['cate_name'] = $cate_name;
            $input['cate_desc'] = $cate_desc;
            $input['show'] = $show;
            $input['sort'] = $sort;
            $input['upd_id'] = $upd_id;

            $list = DB::select($csql,$input);
    }

    //刪除
    public function cates_del($cate_id){
            //刪除消息圖片
            //刪除消息資料
            //刪除消息類別資料
            $csql = "delete from "
                . "  " . $this->cates_dbf_name . " "
                . "where "
                . "  id = :cate_id ";
            
            $input['cate_id'] = $cate_id;

            //DB::statement('drop table users');
            
            $list = DB::select($csql,$input);
    } 
    
       //-----------------------------------------------------------------------------------------------------------------//
       //基本資料
       //-----------------------------------------------------------------------------------------------------------------//
       //資料呈現
       public function clist($id = "", $sort = "", $status = "", $title_query = "", $cateb_id = "", $cates_id = ""){
        $csql = "";
        $input_chk = "";

        $array_id = explode(',',$id);
        $array_title_query = explode(',',$title_query);
        $array_cateb_id = explode(',', $cateb_id);
        $array_cates_id = explode(',', $cates_id);

        $csql = "select "
              . "   a1.*, a2.cate_name as cate_b_name "
              . " , a3.cate_name as cate_s_name "
              . "from "
              . "  " . $this->dbf_name . " a1 "
              . "left join " . $this->cateb_dbf_name . " a2 on a1.cate_b_id = a2.id "
              . "left join " . $this->cates_dbf_name . " a3 on a1.cate_s_id = a3.id "
              . "where "
              . "  a1.status <> 'D' ";
        
        if(!empty($id)){
            //$csql .= "and a1.id = :id";
            $csql .= "and a1.id in (";
            for($i = 0 ; $i < count($array_id); $i++){
                if($i > 0){
                    $csql .= ",";
                }
                $csql .= ":id" . $i;

                $input['id' . $i] = $array_id[$i];
            }
            $csql .= ")";
            //$input['id'] = $id;
            $input_chk = "Y";
        }

        if(!empty($cateb_id)){
            //$csql .= "and a1.id = :id";
            $csql .= "and a1.cate_b_id in (";
            for($i = 0 ; $i < count($array_cateb_id); $i++){
                if($i > 0){
                    $csql .= ",";
                }
                $csql .= ":cateb_id" . $i;

                $input['cateb_id' . $i] = $array_cateb_id[$i];
            }
            $csql .= ")";
            //$input['id'] = $id;
            $input_chk = "Y";
        }            

        if(!empty($cates_id)){
            //$csql .= "and a1.id = :id";
            $csql .= "and a1.cate_s_id in (";
            for($i = 0 ; $i < count($array_cates_id); $i++){
                if($i > 0){
                    $csql .= ",";
                }
                $csql .= ":cates_id" . $i;

                $input['cates_id' . $i] = $array_cates_id[$i];
            }
            $csql .= ")";
            //$input['id'] = $id;
            $input_chk = "Y";
        }   

        if(!empty($title_query)){
            //$csql .= "and a1.id = :id";
            $csql .= "and (";
            for($i = 0 ; $i < count($array_title_query); $i++){
                if($i > 0){
                    $csql .= " or ";
                }
                $csql .= "c_title like :c_title" . $i;

                $input['c_title' . $i] = "%" . $array_title_query[$i] . "%";
            }
            $csql .= ")";
            //$input['id'] = $id;
            $input_chk = "Y";
        } 

        // if(!empty($start_date)){
        //     $csql .= "and a1.c_date >= :start_date ";
        //     $input['start_date'] = $start_date;
        //     $input_chk = "Y";
        // }

        // if(!empty($end_date)){
        //     $csql .= "and a1.c_date <= :end_date ";
        //     $input['end_date'] = $end_date;
        //     $input_chk = "Y";
        // }

        // if(!empty($is_index)){
        //     $csql .= "and a1.is_index >= :is_index ";
        //     $input['is_index'] = $is_index;
        //     $input_chk = "Y";
        // }

        if(!empty($status)){
            $csql .= "and a1.status = :status ";
            $input['status'] = $status;
            $input_chk = "Y";
        }

        $csql .= "order by ";
        if(empty($sort)){
        $csql .= "  a1.id "; 
        }else{
        $csql .= "  " . $sort . " ";
        }

        if($input_chk == "Y"){
            $list = DB::select($csql,$input);
        }else{
            $list = DB::select($csql);
        }

        return $list;           
   }

   //新增
   public function cinsert($c_no = "", $c_title = "", $c_name = "", $c_desc = "", $c_memo = "", $show = "", $sort = "", $cateb_id = "", $cates_id = "", $img_no = "", $bd_id = "System"){
       if($sort == ""){
           $sort = "0";
       }

       if(empty($cateb_id)){

       }else{
           
       }

       $csql = "insert into " . $this->dbf_name . "(cate_id, c_title, c_date, c_desc, c_memo, is_index, sort, status, bd_id, bd_dt) "
             . "values(:cate_id, :c_title, :c_date, :c_desc, :c_memo, :is_index, :sort, :show, :bd_id, now())";
        
        $input['cate_id'] = $cate_id;
        $input['c_title'] = $c_title;
        $input['c_date'] = $c_date;
        $input['c_desc'] = $c_desc;
        $input['c_memo'] = $c_memo;
        $input['show'] = $show;
        $input['is_index'] = $is_index;
        $input['sort'] = $sort;
        $input['bd_id'] = $bd_id; 
        
        $list = DB::select($csql,$input);
        
        //抓取序號
        $csql = "select "
              . "  * " 
              . "from " 
              . " " . $this->dbf_name . " " 
              . "where "
              . "    cate_id = :cate_id "
              . "and c_title = :c_title "
              . "and c_date = :c_date "
              . "and c_desc = :c_desc "
              . "and c_memo = :c_memo "
              . "and status = :show "
              . "and is_index = :is_index "
              . "and sort = :sort "
              . "and bd_id = :bd_id ";

        $list = DB::select($csql,$input);
        
        if(count($list) > 0){
            $input1['id'] = $list[0]->id;
            $input1['img_no'] = $img_no;
            //更換圖檔的暫存號為新消息序號
            $csql = "update img set img_no = :id where img_kind='" . $this->img_kind . "' and img_no = :img_no ";
            
            $list1 = DB::select($csql,$input1);
        }

   }

   //更新
   public function cupdate($id = "", $c_title = "", $c_date = "", $c_desc = "", $show = "", $is_index = "", $sort = "", $c_memo = "", $cate_id = "", $upd_id = "System"){
         $csql = "update " 
               . "  " . $this->dbf_name . " " 
               . "set "
               . "  c_title = :c_title "
               . ", c_date = :c_date "
               . ", c_desc = :c_desc "
               . ", c_memo = :c_memo "
               . ", status = :show "
               . ", is_index = :is_index "
               . ", sort = :sort "
               . ", cate_id = :cate_id "
               . ", upd_id = :upd_id "
               . ", upd_dt = now() "
               . "where "
               . "  id = :id ";


        $input['id'] = $id;
        $input['cate_id'] = $cate_id;
        $input['c_title'] = $c_title;
        $input['c_date'] = $c_date;
        $input['c_desc'] = $c_desc;
        $input['c_memo'] = $c_memo;
        $input['show'] = $show;
        $input['is_index'] = $is_index;
        $input['sort'] = $sort;
        $input['upd_id'] = $upd_id;      
        
        $list = DB::select($csql,$input);
               
   }

   //刪除
   public function cdel($id = ""){
       $input['id'] = $id;
       //刪除圖片
       $csql = "delete from img where img_no = :id and img_kind='" . $this->img_kind . "' ";
       $info = DB::select($csql,$input);

       //刪除資料
       $csql = "delete from " . $this->dbf_name . " where id = :id ";
       $info1 = DB::select($csql,$input);
       
   }

   //-----------------------------------------------------------------------------------------------------------------//
    
   }
?>