<?php
   $m_id = date("YmdHis"); 
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>競標頁面</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Encode+Sans+Condensed">
        <link rel="stylesheet" href="{{ url('/') }}/Content/css/vendor/open-iconic.css">
        <link rel="stylesheet" href="{{ url('/') }}/Content/css/grid.css">    
        <link rel="stylesheet" href="{{ url('/') }}/Content/css/admin.css">    
        {{-- 引用 jQuery  --}}
        {{--<script src="//code.jquery.com/jquery-latest.min.js"></script>--}}
        {{-- 引用 JQuery --}}
         <script src="{{ url('/') }}/Scripts/jquery-1.10.2.min.js"></script>    
        {{-- 引用 Bootstrap --}}
        <script src="{{ url('/') }}/Scripts/bootstrap.js"></script>  
        <script src="{{ url('/') }}/Scripts/respond.js"></script> 
        {{-- 引用 ajax_lib --}}
        <script src="{{ url('/Scripts/ajax_lib.js') }}"></script>                   
    </head>
    <body>
        <script>
             function chk_price(){
                var $mem_id = "{{ $m_id }}";
                var token = $('#_token').val();
                var g_price = "";
                var cmsg = "";

                if ($("#guess_price").val().length > 0) {
                    g_price = $("#guess_price").val();
                }else {
                    cmsg = "請輸入競標價格~~";
                }

                if(cmsg.length > 0){
                    alert(cmsg);
                }else{
                    $.ajax({                
                        url: '{{ url('/ajax/guessprice') }}',
                        data: { mem_id: mem_id, guess_price:g_price, _token: token }, //此参数非常严谨，写错一个引号都不行
                        type:"POST",
                        dataType: 'TEXT', //返回值类型 一般设置为json
                        async: false,
                        success: function(JData){
                            //alert(JData);
                            data = handleAjaxVPNMsg(JData);
                            i = 0;
                            c_html = "";
            
                            $.each($.parseJSON(data), function (idx, obj) {
                                i = i + 1;
                                c_html = c_html + "<div class=\"uploaded\">";
                                c_html = c_html + "    <button class=\"close\" id=\"btn_close_" + c_sty + "_" + i + "\" name=\"btn_close_" + c_sty + "_" + i + "\" onclick=\"del_img('" + obj.id + "','" + c_sty + "');\" >&times;</button>";
                                c_html = c_html + "    <img id=\"img_" + c_sty + "_" + i + "\" name=\"img_" + c_sty + "_" + i + "\" src=\"../Images/" + obj.img_file + "\" alt=\"\">";
                                c_html = c_html + "</div>";
                            });
            
                            $('#c_img_' + c_sty).html(c_html);
                        },
                        error:function(xhr, ajaxOptions, thrownError){ 
                            alert(xhr.status); 
                            alert(thrownError); 
                        },
                        complete: function () {
                            //alert(tbl_new_list);
                            //alert('ajax complete');
                        }
                    });
                }

                return false;
             }
        </script>
        <br />
        <form id="form1" name="form1" method="POST" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">     
            <dl class="field">
                <dt class="col-1">*競標價格</dt>
                <dd class="col-6">
                    <input type="text" class="form-control form-control-sm" id="guess_price" name="guess_price" value="">
                </dd>
            </dl>        
            <footer class="submit-bar clear m-t-24">
                <button id="btn_ok" name="btn_ok" onclick="chk_price();" class="btn success oi" data-glyph="circle-check">出價</button>
            </footer>                        
        </form>
        <br />
        <div>
                <dl class="field">
                    <dt class="col-1">目前時間：</dt>
                    <dd class="col-6">
                        <label id="now_time" name="now_time"></label>
                    </dd>
                </dl>
                <dl class="field">
                        <dt class="col-1">最高出價：</dt>
                        <dd class="col-6">
                            <label id="higher_price" name="higher_price"></label>
                        </dd>
                    </dl>
                <dl class="field">
                        <dt class="col-1">出價記錄：</dt>
                        <dd class="col-6">
                                <div id="pirce_history">

                                    </div>
                        </dd>
                </dl>                                                      
        </div>
    </body>
</html>