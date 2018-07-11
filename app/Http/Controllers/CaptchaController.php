<?php
    //檔案位置:app/Http/Controllers/CaptchaController.php
    namespace App\Http\Controllers;

    use Exception;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Mews\Captcha\Captcha;
    use Session;

    class CaptchaController extends Controller {
        public function __construct(){

        }
        
        //測試頁面
        public function index() {
            // $mews = Captcha::src('inverse');, compact('mews')
            return view('captcha.index');
        }

        //創建驗證碼
        public function mews() {
            //風格：default, flat, mini, inverse 代表四種風格的驗證碼!可以針對不同風格進度配置，直接在Config/captcha.php中修改配置項
            return Captcha::create('flat');
        }
    
    }
?>