<?php
   $m_id = date("YmdHis");
   $row_count = count($info);
   $g_mem = "";
   $g_price = "";
   $g_time = "";
   $higher_price = "";
   if($row_count > 0){
     $higher_price = $info[0]->g_price;
   } 
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
    </head>
    <body>
        {{-- 引用 ajax_lib --}}
        <script src="{{ url('/Scripts/ajax_lib.js') }}"></script>           
        <script>
             function chk_price(){
                var mem_id = "{{ $m_id }}";
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
                        url: '{{ url('/ajax/gprice') }}',
                        data: { mem_id: mem_id, guess_price: g_price, _token: token }, //此参数非常严谨，写错一个引号都不行
                        type:"POST",
                        dataType: 'TEXT', //返回值类型 一般设置为json
                        async: false,
                        success: function(JData){
                            //alert(JData);
                            data = handleAjaxVPNMsg(JData);
                            //alert(data);
                            var jsdata = jQuery.parseJSON(data);
                            var g_sty = jsdata.guess_sty; //競標結果
                            var g_data = jsdata.cdata;    //資料
                            
                            //alert(g_data);
                            i = 0;
                            c_html = "";
                            //$.each($.parseJSON(g_data), function (idx, obj) {
                              $.each(g_data, function (idx, obj) {
                                if(i == 0){
                                    $('#higher_price').html(obj.g_price);
                                }
                                i = i + 1;
                                c_html = c_html + "<tr>";
                                c_html = c_html + "  <td>";
                                c_html = c_html + obj.mem_id;
                                c_html = c_html + "  </td>";
                                c_html = c_html + "  <td>";
                                c_html = c_html + obj.g_price;
                                c_html = c_html + "  </td>";
                                c_html = c_html + "  <td>";
                                c_html = c_html + obj.g_time;
                                c_html = c_html + "  </td>";                                                                
                                c_html = c_html + "</tr>";
                            });
                            
                            if(i > 0){
                                c_html = "<table>"
                                       + "  <tr><td>競標者</td><td>競標價格</td><td>競標時間</td></tr>"
                                       + c_html
                                       + "</table>";
                            }
                            $('#pirce_history').html(c_html);

                            if(g_sty == "Y"){
                                alert("出價成功!!");
                            }else{
                                alert("出價失敗!!!");
                            }

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
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">  
            <dl class="field">
                    <dt class="col-1">競標者</dt>
                    <dd class="col-6">
                        <label id="g_mem" name="g_mem">{{ $m_id }}</label>
                    </dd>
                </dl>               
            <dl class="field">
                <dt class="col-1">*競標價格</dt>
                <dd class="col-6">
                    <input type="text" class="form-control form-control-sm" id="guess_price" name="guess_price" value="">
                </dd>
            </dl>        
            <footer class="submit-bar clear m-t-24">
                <button id="btn_ok" name="btn_ok" onclick="chk_price();return false;" class="btn success oi" data-glyph="circle-check">出價</button>
            </footer>                        
        </form>
        <br />
        <div>
            <!--
                <dl class="field">
                    <dt class="col-1">目前時間：</dt>
                    <dd class="col-6">
                        <label id="now_time" name="now_time"></label>
                    </dd>
                </dl>
            -->
                <dl class="field">
                        <dt class="col-1">最高出價：</dt>
                        <dd class="col-6">
                        <label id="higher_price" name="higher_price">{{ $higher_price }}</label>
                        </dd>
                    </dl>
                <dl class="field">
                        <dt class="col-1">出價記錄：</dt>
                        <dd class="col-6">
                                <div id="pirce_history">
                                    <table>
                                        <tr>
                                            <td>競標者</td><td>競標價格</td><td>競標時間</td>
                                        </tr>
                                    @if($row_count > 0)
                                       @for($i = 0; $i < $row_count; $i++)
                                          <?php
                                             $g_mem = $info[$i]->mem_id;
                                             $g_price = $info[$i]->g_price;
                                             $g_time = $info[$i]->g_time;
                                          ?>
                                          <tr>
                                          <td>{{ $g_mem }}</td><td>{{ $g_price }}</td><td>{{ $g_time }}</td>
                                          </tr>
                                       @endfor
                                    @else
                                       <tr>
                                           <td colspan="3">無競標記錄</td>
                                       </tr>
                                    @endif
                                    </table>
                                </div>
                        </dd>
                </dl>                                                      
        </div>
    </body>
</html>