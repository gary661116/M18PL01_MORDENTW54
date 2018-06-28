<?php
   //檔案位置 app/Http/Libs/user.php
   namespace App\Http\Libs;

   use DB;

   class User {
       //資料呈列
       public function clist($id = "", $sort = "", $status = "", $signin_id = "") {
            $csql = "";
            $input_chk = "";

            $csql = "select "
                . "  * "
                . "from "
                . "  usr "
                . "where "
                . "  status <> 'D' ";
            
            if(!empty($id)){
                $csql .= "and id = :id";
                $input['id'] = $id;
                $input_chk = "Y";
            }

            if(!empty($sign_id)){
                $csql .= "and signin_id = :signin_id ";
                $input['sign_id'] = $sign_id;
                $input_chk = "Y";
            }

            if(!empty($status)){
                $csql .= "and status = :status ";
                $input['status'] = $status;
                $input_chk = "Y";
            }

            $csql .= "order by ";
            if(empty($sort)){
            $csql .= "  id "; 
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
   }
?>