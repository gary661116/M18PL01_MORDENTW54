 {{-- 宣告繼承的主 layout --}}
 @extends('layouts.manage')
 
  {{-- 設定變數 --}}
 <?php 
       $title = "後台管理系統"; 
       $IsFirstPage = TRUE;
       $BodyClass = "Login";
 ?>
 
 {{-- Google reCaptcha 驗證工具 --}}
 <script src='https://www.google.com/recaptcha/api.js'></script>
 
 <script type="text/javascript">
    function form_ok() {
        form1.submit();
    }

    $(function () {
        $("#valiCode").bind("click", function () {
            this.src = "";
            this.src = "{{ url('/GetValidateCode')}}?time=" + (new Date()).getTime();
        });
    });
</script>

<h1 class="logo">
    {{-- Logo --}}
    資訊管理系統<small class="text-muted m-l-8">Web Manager</small>
</h1>
{{--<h6 class="font-sp text-primary">PITC &copy; 2017</h6>--}}

{{-- 錯誤訊息模板元件 --}}
@include('components.validationErrorMessage')

<form class="text-left" name="form1" id="form1" action="{{ url('/usr/sign-in') }}" method="post">
    {{-- CSRF 欄位--}}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">     
    <header class="title font-sp">System Login</header>

    <main>
        <label>帳號 Username</label>
        <input type="text" class="form-element" placeholder="帳號" name="account" id="account" value=""  required>
        <label>密碼 Password</label>
        <input type="password" class="form-element" name="pwd" id="pwd" value="" required>
        <label>驗證碼 Code</label>
        <div class="fields clearfix">
            <div class="md-12">
                {{-- Google reCaptcha 驗證工具 --}}
                {{--<div class="g-recaptcha" data-sitekey="6LcePAATAAAAAGPRWgx90814DTjgt5sXnNbV5WaW"></div> --}}
                {{--<img id="valiCode" style="cursor: pointer;height:30px;" src="{{ url('/GetValidateCode')}}" alt="驗証碼" />--}}
                <img src="{{ url('captcha/mews') }}" onclick="this.src='{{ url('captcha/mews') }}?r='+Math.random();" alt="驗証碼">                        
            </div>
            <div class="md-12">
                <input type="text" class="form-element" name="ValidCode" id="ValidCode" value=""  required>
            </div>
        </div>
            
            
            
    </main>

    <footer class="action-bar text-center">
        <button type="button" class="btn info" onclick="form_ok();">登入 LOGIN</button>
    </footer>

    {{-- CSRF 欄位--}}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">    
</form>

<script>
    //禁止按下enter
    $('#form1').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>