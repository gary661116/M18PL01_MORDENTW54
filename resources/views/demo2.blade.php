<html>
    <head>
        <script src="//code.jquery.com/jquery-latest.min.js"></script>
    </head>
    <body>
        <script>
             function chg_url(){
            //     var c_url = "";
            //     //var chtml = "";
            //     c_url = $('#fb_url').val();
            //     //if(c_url != ""){
            //     //    chtml = "<iframe src=\"" + c_url + "\" width=\"300\" height=\"533\" style=\"border:none;overflow:hidden\" scrolling=\"no\" frameborder=\"0\" allowTransparency=\"true\" allow=\"encrypted-media\" allowFullScreen=\"true\"></iframe>";
            //     //}
                
            //     $('#fb_display').attr("data-href",c_url);
            //     $('#fb_display').load(self);
            //     alert($("#fb_display").attr("data-href"));
            //     //$('#fb_display').html(chtml);
                $('#form1').submit();
             }
        </script>
        <form id="form1" name="form1" method="POST" action="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">             
        <input type="text" id="fb_url" name="fb_url" value="{{ $fb_url }}" />
                <button id="btn_ok" name="btn_ok" onclick="chg_url();">更新</button>
        </form>
        <br />
    <iframe src="https://www.facebook.com/plugins/video.php?href={{ $fb_urla }}&width=300&show_text=false&height=533&appId" width="300" height="533" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe>      
    </body>
</html>