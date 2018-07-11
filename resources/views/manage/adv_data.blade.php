<!-- 檔案位置: resources/views/manage/faq_data.blade.php -->
  {{-- 設定變數 --}}
  <?php 
  //$title = '最新消息'; 
  $IsFirstPage = FALSE;
  $subnav = "adv";
  $subnav2 = "adv_list";
//------------------------------//
  $SysPath = "/manage/";
  $cFile = "adv_list";
  $cFile_Add = "adv_add";
  $cFile_Del = "adv_del";
  $cFile_Edit = "adv_edit";
  $cFile_Save = "adv_save";
  //------------------------------//
  $FileSize = "4";  //上傳檔案大小
  $img_kind = "adv";
  //------------------------------//
  $id = "";
  $c_title = "";
  $c_desc = "";
  $c_memo = "";
  $c_url = "";
  $sort = "";
  $action_name = "";
  $status = "";
  $c_front_status_Y = "";
  $c_front_status_N = "";
  $is_inside = "";
  $c_inside_Y = "";
  $c_inside_N = "";
  
  $img_no = "";
  $img_path = "/images/";
  $small_img = "";
  $big_img = "";
  $img_id = "";
  $cate_id = "";
  $cate_selected = "";

  //給值
 // $img_no = date("YmdHisu"); 
 $img_no = date("YmdHis"); 
 //Ex.201806201650(如有多「u」時，多豪秒，ex.654321)，約12~16位置 

if($action_sty == "add"){
    $action_name ="新增";
    $id = "";
    $c_title = "";
    $c_desc = "";
    $c_url = "";
    $c_memo = "";
    $status = "N";
    $c_front_status_N = "checked";
    $c_front_status_Y = "";
    $is_inside = "N";
    $c_inside_status_N = "checked";
    $c_inside_status_Y = "";    
    $cate_id = "";
    $sort = "0";
}

if($action_sty == "edit"){
    $action_name ="修改";
    $id = $info[0]->id;
    $c_title = $info[0]->c_title;
    $c_desc = $info[0]->c_desc;
    $c_url = $info[0]->c_url;
    $c_memo = $info[0]->c_memo;
    $status = $info[0]->status;
    if($status == "Y"){
        $c_front_status_Y = "checked";
        $c_front_status_N = "";
    }else{
        $c_front_status_N = "checked";
        $c_front_status_Y = "";         
    }
    
    $is_inside = $info[0]->is_inside;
    if($is_inside == "Y"){
        $c_inside_status_Y = "checked";
        $c_inside_status_N = "";
    }else{
        $c_inside_status_N = "checked";
        $c_inside_status_Y = "";
    }

    $cate_id = $info[0]->cate_id;
    $sort = $info[0]->sort;
}
?>
{{-- 指定繼承 layout.manage 母模版 --}}
@extends('layouts.manage')

{{-- 傳送資料到母模版，並指定變數為title --}}
@section('title' , $title)

{{-- 傳送資料到母模版，並指定變數為 content --}}
@section('content')
    <ul class="breadcrumb">
      <li>{{ $title }}</li>
    </ul>

    <h3 class="title">{{ $title }} <small class="oi" data-glyph="tags">編輯</small></h3>
    {{-- 引用 ajaxfileupload --}}    
    <script src="{{ url('/Scripts/ajaxfileupload.js') }}"></script>
    {{-- 引用 ajax_lib --}}
    <script src="{{ url('/Scripts/ajax_lib.js') }}"></script>
    {{-- 引用ckeditor.js --}}
    <script src="{{ url('/ckeditor/ckeditor.js') }}"></script>
    
    <script>
      function form_ok() {
          var sshow = "";
          var shot = "";
          var cmsg = "";
          var c_title = "";
          c_title = $("#c_title").val();
          
          if(c_title == "")
          {
              if (cmsg != "")
              {
                  cmsg += "\n";
              }
              cmsg += "請輸入標題";
          }
    
          if (cmsg != "")
          {
              alert(cmsg);
          }
          else
          {
              form1.submit();
          }
          //alert("show:" + $("#show").val() + ";hot:" + $("#hot").val());
  
      }
  
      function del_img(img_id,c_sty)
      {
          var cimg_no = "";
          var c_cate = "{{ $img_kind }}";
          var token = $('#_token').val();

          if ($("#id").val().length > 0) {
              cimg_no = $("#id").val();
          }else {
              cimg_no = "{{ $img_no }}";
          }
  

          $.ajax({                
              url: '{{ url('/ajax/img_del') }}',
              data: { img_id: img_id, img_sty:c_sty, img_no: cimg_no, img_cate: c_cate, _token: token }, //此参数非常严谨，写错一个引号都不行
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
          return false;
      }
  
      function upload(c_sty)
      {
  
          if ($("#pic_" + c_sty).val().length > 0) {
              //ajaxFileUpload('pic_small','small_img');
              //ajaxFileUpload(c_sty);
  
              var f_size = 0;
              var max_size = 0;
  
              max_size = {{ $FileSize }} * 1024 * 1024;
              //檢查檔案大小(KB;MB = KB/1024);
              f_size = findSize("pic_" + c_sty);
              var cmsg = "上傳圖片的大小不能超過 {{ $FileSize }} M!!!";
              if(f_size > max_size)
              {
                  alert(cmsg);
                  return false;
              }
              else
              {
                  //ajaxFileUpload('pic_small','small_img');
                  //ajaxFileUpload(c_sty,c_cate);
                  ajaxFileUpload(c_sty);
              }
          }
          else {
              alert("請選擇圖片");
          }
      }
  
      function ajaxFileUpload(c_sty) {
          var cimg_no = "";
          var c_img = "pic_" + c_sty;
          var c_cate = "{{ $img_kind }}";
          var cimg_sty = "";
          var cimg_id = "";
          var token = $('#_token').val();
  
          if ($("#id").val().length > 0) {
              cimg_no = $("#id").val();
          }else {
              cimg_no = "{{ $img_no  }}";
          }
  
          //alert(c_img);
          var chtml = "";
          var i = 0;
          $.ajaxFileUpload
          (
              {
                  url: '{{ url('/ajax/img_upload') }}', //用于文件上传的服务器端请求地址
                  type: 'post',
                  data: { img_no: cimg_no, img_sty: c_sty, img_cate: c_cate, _token: token }, //此参数非常严谨，写错一个引号都不行
                  secureuri: false, //一般设置为false
                  //fileElementId: 'file1', //文件上传空间的id属性  <input type="file" id="file" name="file" />
                  fileElementId: c_img, //文件上传空间的id属性  <input type="file" id="file" name="file" />
                  //dataType: 'HTML', //返回值类型 一般设置为json
                  dataType: 'JSON', //返回值类型 一般设置为json
                  success: function (JData, status)  //服务器成功响应处理函数
                  {
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
                  error: function (data, status, e)//服务器响应失败处理函数
                  {
                      alert(e);
                  }
              }
          )
          return false;
      }
  
      //獲得檔案大小
      function findSize(field_id)
      {
          var byteSize = $("#" + field_id)[0].files[0].size;
          //return ( Math.ceil(byteSize / 1024) ); // Size returned in KB.
  
          return ( Math.ceil(byteSize) ); // Size returned in B.
      }
  </script>  
  
  <form class="form-list" action="{{ url($SysPath . $cFile_Save)}}" name="form1" id="form1" method="post" enctype="multipart/form-data">
    {{-- CSRF 欄位--}}
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">     
    <input type="hidden" name="action_sty" id="action_sty" value="{{ $action_sty }}" />
    <input type="hidden" name="id" id="id" value="{{ $id }}" />
    <input type="hidden" name="img_no" id="img_no" value="{{ $img_no }}" />

    <dl class="field">
        <dt class="col-1"><sup title="必填">*</sup> 分類</dt>
        <dd class="col-6" id="spanDD">
            @if (count($d_cate) > 0)
                @for ( $i = 0; $i < count($d_cate); $i++)
                  <?php
                     if($action_sty == "add" && $d_cate[$i]->id == 1){
                         $cate_selected = "checked";
                     }elseif ($d_cate[$i]->id == $cate_id) {
                        $cate_selected = "checked";
                     }else{
                        $cate_selected = ""; 
                     }
                  ?>
                    <span name="cateSpan">
                    <input type="radio" class="radio" name="cate_id" id="{{ $d_cate[$i]->id }}" value="{{ $d_cate[$i]->id }}" {{ $cate_selected }}>
                        <label for="{{ $d_cate[$i]->id }}"></label>
                        {{ $d_cate[$i]->cate_name }}
                    </span>
                @endfor
            @endif
        </dd>
    </dl>

    <dl class="field">
        <dt class="col-1"><sup title="必填">*</sup> 標題</dt>
        <dd class="col-6">
            <input type="text" class="form-element" required id="c_title" name="c_title" value="{{ $c_title }}">
        </dd>
    </dl>

    <dl class="field">
        <dt class="col-1"><sup title="必填">*</sup> 網址</dt>
        <dd class="col-6">
            <input type="text" class="form-element" required id="c_url" name="c_url" value="{{ $c_url }}">
        </dd>
    </dl>

    <dl class="field">
        <dt class="col-1"><sup title="必填">*</sup> 狀態</dt>
        <dd class="col-6">
            <input type="radio" class="radio" name="show" id="showY" value="Y" {{ $c_front_status_Y }} >
            <label for="showY"></label>
            發佈
            <input type="radio" class="radio" name="show" id="showN" value="N" {{ $c_front_status_N }} >
            <label for="showN"></label>
            草稿
        </dd>
    </dl>

    <dl class="field">
        <dt class="col-1"><sup title="必填">*</sup> 類別</dt>
        <dd class="col-3">
            <input type="radio" class="radio" name="hot" id="hotY" value="Y" {{ $c_inside_status_Y }} >
            <label for="hotY"></label>
            站內
            <input type="radio" class="radio" name="hot" id="hotN" value="N" {{ $c_inside_status_N }} >
            <label for="hotN"></label>
            站外
        </dd>
    </dl>

    <dl class="field">
        <dt class="col-1"><sup title="必填">*</sup> 排序</dt>
        <dd class="col-3">
            {{-- <input type="text" class="form-element" value="0" required> --}}
            <input type="number" min="0" class="form-element" id="sort" name="sort" value="{{ $sort }}" required>
        </dd>
        <dd class="col-5">
            <small class="text-secondary">數字愈大愈前面 (若排序數字相同，則依日期新→舊排序)</small>
        </dd>
    </dl>

    <dl class="field">
        <dt class="col-1">代表圖</dt>
        <dd class="col-6">
            <div class="input-file">
                {{-- 瀏覽&上傳檔案 --}}
                <input type="file" name="pic_S[]" id="pic_S" accept="image/*" class="form-control form-control-sm">
                <button type="button" name="btn_small_pic" onclick="upload('S');" class="btn btn-sm btn-success oi m-t-small" data-glyph="data-transfer-upload">
                    上傳
                </button>
            </div>
            <small class="block text-secondary">可上傳 1 張圖片，建議尺寸 800*510px，建議檔案大小不超過 4MB，檔名請勿包含中文或特殊字元如 空白 % # + - ? * &amp; $ 等</small>
            {{-- 照片縮圖(上傳圖片後顯示) --}}
            <div id="c_img_S" name="c_img_S">
                @for ($s = 0; $s < count($d_img); $s++)
                {
                    <?php
                    $small_img = $img_path . $d_img[$s]->img_file;
                    $img_id = $d_img[$s]->id;
                    ?>
                    <div class="uploaded">
                        <button class="close" id="btn_close_s_{{ $s }}" name="btn_close_s_{{ $s }}" onclick="del_img('{{ $img_id }}','S');">&times;</button>
                        <img id="img_S_{{ $s }}" name="img_S_{{ $s }}" src="{{ $small_img }}" alt="">
                    </div>
                @endfor

            </div>
        </dd>
    </dl>

    <hr class="my-16">

    <fieldset class="m-t-24">
        <legend class="underline">[ 內容 ]</legend>
        <div class="alert-warning mb-16">
            <strong>編輯器注意事項:</strong><br>
            從 WORD 複製文字時，請使用下方的 <img src="{{ url('/Content/images/icon-word.jpg') }}" /> 圖示來貼上 WORD 文字，避免跑版<br />
            編輯器上傳圖片或新增表格等時，請勿設定寬度及高度(將數字刪除) ，以免行動裝置顯示時會跑版。<br />
            檔案尺寸寬度超過 1600 或 高度超過1200 的圖片會被壓縮(PNG透明背景會變成不透明)
        </div>

        {{-- 編輯器(含圖片上傳功能) --}}
        <textarea class="ckeditor" rows="18" placeholder="請輸入最新消息內容" name="c_desc" id="c_desc">{{ $c_desc }}</textarea>
        {{--加入圖片上傳頁籤，放在頁面底下，放在頁面head區的話，會抓不到myText DOM --}}

        <script>
                CKEDITOR.replace( 'c_desc', {
                    filebrowserUploadUrl: '{{ route('ckupload',['_token' => csrf_token() ]) }}'
                });
        </script>             
    </fieldset>

    <footer class="submit-bar clear mt-24">
        <button type="button" class="btn success oi" data-glyph="circle-check" onclick="form_ok();" name="btn_ok" id="btn_ok" >
            確認儲存
        </button>
      <button type="button" class="btn warning oi" data-glyph="x" onclick="location.href='{{ url($SysPath . $cFile) }}';" id="btn_back" name="btn_back" >
            取消，回列表
        </button>
    </footer>
  </form>  
@endsection

