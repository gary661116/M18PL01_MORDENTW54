<?php
    //檔案位直 app/Http/Controllers/UserAuthController.php
    namespace App\Http\Controllers;

    use Exception;
    use Session;
    use App\Http\Controllers\Controller;
    use App\Http\Libs\User;
    use Mews\Captcha\Facades\Captcha;

    class UserAuthController extends Controller {
        public function __construct(){

        }
                
        //登入
        public function signInPage(){

            $data = [
                'title' => '登入'
            ];

            return view('usr.signIn', $data);
        }

        public function signInProcess(){
            $cmsg= "";
            $input = request()->all();
            $signin_id = $input['account'];
            $signin_pwd = $input['pwd'];
            $ValidCode = $input['ValidCode'];
            
            //檢查驗證碼
            if(empty($ValidCode)){
                //$cmsg = "請輸入驗證碼";
                $error_message['validcode'] = "請輸入驗證碼";
            }else{
                if(Captcha::check($ValidCode) == false){
                    $error_message['validcode'] = "驗證碼錯誤" . ";ValidCode:" . $ValidCode;
                }

                $Cuser = new User();

                $data = $Cuser->clist("","","",$signin_id);
        
                if(empty($data)){
                    $error_message['msg'] = "無此人員，請重新輸入";
                }else{
                    //return $data;
                    //比對密碼是否正確
                    if($signin_pwd == $data[0]->signin_pwd){
                        Session::put('is_login', 'Y');
                        Session::put('signin_id', $data[0]->signin_id);
                        Session::put('usr_name', $data[0]->usr_name);
                        Session::put('usr_type', $data[0]->usr_type);
                    }else{
                        $error_message['msg'] = "密碼錯誤，請重新輸入，或請聯絡系統管理人員";
                    }
                }                
             }

    
            if($cmsg != ""){
                $error_message['msg'] = $cmsg;            
            }   
            
            if(empty($error_message) == false AND count($error_message) > 0){
                return redirect('/usr/sign-in')
                ->withErrors($error_message)
                ->withInput();
            }else{
                // 重新導向到原先使用者造訪頁面，沒有嘗試造訪頁則重新導向回首頁
                return redirect()->intended('/manage');
            }
        }

        //登出
        public function signOut(){
            //清除Session
            Session::flush();

            //重新導回首頁
            return redirect('/');
        }
    }
?>