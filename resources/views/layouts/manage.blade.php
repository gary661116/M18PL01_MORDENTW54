{{-- resources/views/layouts/manage.blade.php --}}
<?php
   $mainName = "資訊管理系統";
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$mainName}}-@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Encode+Sans+Condensed">
    <link rel="stylesheet" href="{{ url('/') }}/Content/css/vendor/open-iconic.css">
    <link rel="stylesheet" href="{{ url('/') }}/Content/css/grid.css">    
    
    @if($IsFirstPage == TRUE)
       <link rel="stylesheet" href="{{ url('/') }}/Content/css/login.css">
    @else
       <link rel="stylesheet" href="{{ url('/') }}/Content/css/admin.css">    
    @endif
    {{-- 引用 jQuery  --}}
    {{--<script src="//code.jquery.com/jquery-latest.min.js"></script>--}}
    {{-- 引用 JQuery --}}
     <script src="{{ url('/') }}/Scripts/jquery-1.10.2.min.js"></script>     
</head>
<body>
    <div class="wrapper">
	{{-- Head Start--}}
    @if($IsFirstPage == FALSE)
        @if(Session::get('is_login') == "Y")
            <header id="header">
                <h1 class="site-title">
                    
                    <a href="{{ url('/manage') }}" title="回管理系統首頁" tabindex="-1">
                        <font color="white">{{ $mainName }}</font>
                    </a>
                </h1>            

                <nav class="navbar">
                <span class="nav-link">登入身份: {{ Session::get('signin_id') }}({{ Session::get('usr_name')}})</span>
                    <a href="{{ url('/') }}" class="nav-link oi home" data-glyph="home">
                        回首頁
                    </a>
                    <a href="{{ url('/usr/sign-out') }}" class="nav-link oi logout" data-glyph="power-standby">
                        登出
                    </a>
                </nav>
            </header>
	    @else
            <script Lang="text/Javascript">location.href = "{{ url('/usr/sign-in') }}";</script>
	    @endif
	@endif  
    {{-- Head End  --}}	
    {{-- Main Start --}}
        <main id="main">
            @if($IsFirstPage == TRUE)
                @yield('content')          
            @else
                <div id="content" class="font-md">
                    @yield('Breadcrumb')
                    @yield('content')
                </div>             
				{{-- Menu Start --}}
				@include('layouts.manage_menu')
				{{-- Menu End --}}                           
            @endif
        </main>   
    {{-- Main End --}}
    </div>
    {{-- Foot Start --}}
    @if($IsFirstPage == TRUE)
        <footer id="footer" class="text-muted">
            <div class="copyright font-sp">Powered By <a class="hover-info" href="http://www.morden.tw" target="new">MordenTw</a></div>
            <small>本網站適用 Chrome, firefox, IE10.0+, 最佳瀏覽解析度為 1280*800 以上</small>        
        </footer>      
    @endif
    {{-- Foot End   --}}    
    @if($IsFirstPage == FALSE)
        <script>
            // 左選單縮放特效
            var $collapse = $('.collapse-toggle');
            var fall = '.collapse-content';

            $collapse.click(function (e) {
                $(this).addClass('active').next(fall).slideToggle();
                $(this).siblings().removeClass('active').next(fall).slideUp();
                // event.preventDefault();
            });
        </script>    
    @endif
</body>
</html>