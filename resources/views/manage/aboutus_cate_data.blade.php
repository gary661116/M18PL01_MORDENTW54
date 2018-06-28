<!-- 檔案位置: resources/views/manage/aboutus_cate_data.blade.php -->
  {{-- 設定變數 --}}
  <?php 
  //$title = '最新消息'; 
  $IsFirstPage = FALSE;
  $subnav = "aboutus";
  $subnav2 = "aboutus_cate";
  //------------------------------//
  $SysPath = "/manage/";
  $cFile = "aboutus_cate_data";
  $cFile_Add = "aboutus_cate_add";
  $cFile_Del = "aboutus_cate_del";
  $cFile_Edit = "aboutus_cate_edit";
  $cFile_Save = "aboutus_cate_save";
  $cFile_List = "aboutus_cate_list";
  
  //
  $cate_id = "";
  $cate_name = "";
  $cate_desc = "";
  $cate_pic = "";
  $cate_pic_id = "";
  $sort = "";
  $action_name = "";
  $c_sataus = "";
  $c_front_status = "";

  $img_no = "";
  $img_path = "/Images/";
  $small_img = "";
  $big_img = "";
  $img_id = "";

  //給值
  //$img_no = date("YmdHisu");  //Ex.201806201650(如有多「u」時，多豪秒，ex.654321)，約12~16位置 
  $img_no = date("YmdHis");  //Ex.201806201650(如有多「u」時，多豪秒，ex.654321)，約12~16位置 
  //------------------------------//
  if($action_sty == "add"){
     $action_name = "新增";
     $cate_id = "";
     $cate_name = "";
     $cate_desc = "";
     $c_status = "Y";
     $c_front_status = "checked";
     $sort = "0";     
  }elseif($action_sty == "edit"){
     $action_name = "修改";
     $cate_id = $info[0]->id;
     $cate_name = $info[0]->cate_name;
     $cate_desc = $info[0]->cate_desc;
     $c_status = $info[0]->status;
     $sort = $info[0]->sort;
     switch($c_status)
     {
         case "Y":
           $c_front_status = "checked";
           break;
         case "N":
           $c_front_status = "";
           break;
     }
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

    <script>
      function form_ok() {
          //檢查資料
          var sshow = "";
          var shot = "";
          var cmsg = "";
          var cate_name = "";
          cate_name = $("#cate_name").val();
          if (cate_name == "") {
              cmsg = "請輸入類別名稱";
          }
  
          if ($("#cshow").prop("checked")) {
              $("#show").val("Y");
              sshow = "Y";
          }
          else
          {
              $("#show").val("N");
              sshow = "N";
          }
  
  
          //alert("show:" + $("#show").val() + ";hot:" + $("#hot").val());
          if (cmsg != "")
          {
              alert(cmsg);
          }
          else
          {
              form1.submit();
          }
      }
    </script>
    <form class="form-list" action="{{ url($SysPath . $cFile_Save) }}" name="form1" id="form1" method="post" enctype="multipart/form-data">
      {{-- CSRF 欄位--}}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">     
      <input type="hidden" name="action_sty" id="action_sty" value="{{ $action_sty }}" />
      <input type="hidden" name="cate_id" id="cate_id" value="{{ $cate_id }}" />
      <input type="hidden" name="img_no" id="img_no" value="{{ $img_no }}" />
      <input type="hidden" name="show" id="show" value="" />
      <input type="hidden" name="hot" id="hot" value="" />

      @if ($action_sty == "add")
          <input type="hidden" name="sort" id="sort" value="" />
      @endif

      <dl class="field">
          <dt class="col-1">*類別名稱</dt>
          <dd class="col-6">
              <input type="text" class="form-control form-control-sm" required id="cate_name" name="cate_name" value="{{ $cate_name }}">
          </dd>
      </dl>
      <dl class="field">
          <dt class="col-1">類別描述</dt>
          <dd class="col-6">
              <input type="text" class="form-control form-control-sm" required id="cate_desc" name="cate_desc" value="{{ $cate_desc }}">
          </dd>
      </dl>

      @if ($action_sty == "edit")
          <dl class="field">
              <dt class="col-1">排序</dt>
              <dd class="col-6">
                  <input type="number" min="0" class="inline" id="sort" name="sort" value="{{ $sort }}">
                  <small>數字愈小愈前面</small>
              </dd>
          </dl>
      @endif

      <dl class="field">
          <dt class="col-1">顯示</dt>
          <dd class="col-6">
              <label class="switch">
                  <input type="checkbox" name="cshow" id="cshow" {{ $c_front_status }}>
                  <div class="slider round"></div>
              </label>
          </dd>
      </dl>
      <footer class="submit-bar clear m-t-24">
          <button type="button" name="btn_ok" onclick="form_ok();" class="btn success oi" data-glyph="circle-check">
              確認儲存
          </button>
        <button type="button" id="btn_back" name="btn_back" onclick="location.href='{{ url($SysPath . $cFile_List) }} '" class="btn warning oi" data-glyph="circle-x">
              回列表
          </button>
      </footer>
    </form>    
@endsection