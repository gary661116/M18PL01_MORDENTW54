<!-- 檔案位置: resources/views/manage/aboutus_list.blade.php -->
  {{-- 設定變數 --}}
  <?php 
  //$title = '最新消息'; 
  $IsFirstPage = FALSE;
  $subnav = "aboutus";
  $subnav2 = "aboutus_list";
//------------------------------//
  $SysPath = "/manage/";
  $cFile = "aboutus_list";
  $cFile_Add = "aboutus_add";
  $cFile_Del = "aboutus_del";
  $cFile_Edit = "aboutus_edit";
  //------------------------------//
  $row_count = count($info);
  //------------------------------//
  //Page
  $page_count = 50;
  $pre_page = 0;
  $top_page = 0;
  $next_page = 0;
  $end_page = 0;
  //row
  $min_row = 0;
  $max_row = 0;
  $total_page = 0;

  $id = "";
  $c_title = "";
  $c_date = "";
  $sort = "";
  $is_index = "";
  $show = "";
  $show_class = "";
  $str_index = "";
  $index_class = "";
  $cate_id = "";
  $cate_name = "";
  $c_selected = "";
  $a_d = "";  
  $class_title = "";
  $class_date = "";
  $class_sort = "";
  $class_status = "";
  $class_index = "";
  $class_cate = "";

  $str_cate = "";

  if ($txt_a_d == ""){
      $a_d = "asc";
  }else{
      $a_d = "desc";
  }

  switch ($txt_sort)
  {
      case "c_title":
          $class_title = $a_d;
          break;
      case "c_date":
          $class_date = $a_d;
          break;
      case "sort":
          $class_sort = $a_d;
          break;
      case "is_index":
          $class_index = $a_d;
          break;
      case "status":
          $class_status = $a_d;
          break;
      case "lang_id":
          $class_lang = $a_d;
          break;
      case "cate_id":
          $class_cate = $a_d;
          break;
  }
  


  //頁數計算
  $total_page = ceil($row_count/$page_count);
  if($page > $total_page){
      $page = $total_page;
  }elseif($page < 1){
      $page = 1;
  }

  $top_page = 1;
  if($page > 1){
      $pre_page = $page - 1;
  }else{
      $pre_page = 1;
  }

  if($total_page > $page){
      $next_page = $page + 1;
  }else{
      $next_page = $total_page;
  }

  $end_page = $total_page;

  $min_row = $page_count * ($page - 1) + 1;
  if($min_row < 0){
      $min_row = 0;
  }
  $max_row = $page_count * $page;

  if($max_row > $row_count){
      $max_row = $row_count;
  }

  //------------------------------//
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

    <h3 class="title">{{$title}}</h3>

    <script>
      function del(url) {
          if (confirm("確定刪除??")) {
              location.href = url;
              //alert("你按下確定");
          }
          else {
              //alert("你按下取消");
          }
      }
  </script>    
<div class="btn-group mb-8">
  <button type="button" onclick="location.href='{{ url($SysPath . $cFile_Add) }}';" class="btn success oi" data-glyph="plus">
      新增
  </button>
</div>
<form name="form1" id="form1" action="" method="post">
    {{-- CSRF 欄位--}}
  <input type="hidden" name="_token" value="{{ csrf_token() }}">    
  <input type="hidden" id="txt_sort" name="txt_sort" value="{{ $txt_sort }}" />
  <input type="hidden" id="txt_a_d" name="txt_a_d" value="{{ $txt_a_d }}" />
  <header class="table-head form-inline">
      <label>標題</label>
      <input type="text" placeholder="請輸入關鍵字..." id="txt_title_query" name="txt_title_query">
      <label>分類</label>
      <select class="form-element" id="txt_cate" name="txt_cate">
          <option value="">全部</option>
          <?php
              $str_cate = "";
              if(count($d_cate) > 0){
                for($i = 0; $i < count($d_cate); $i++){
                    //$cate_id = $d_cate[$i]->id;
                    
                    if($d_cate[$i]->id == $txt_cate){
                      $c_selected = "selected";
                    }else{
                      $c_selected = "";
                    }
                    $str_cate .= "<option value=\"" . $d_cate[$i]->id . "\" " . $c_selected . ">" . $d_cate[$i]->cate_name . "</option>";
                }
              }
          ?>
          {!! $str_cate !!}
      </select>
      
      <label>狀態</label>
      <select id="txt_show" name="txt_show">
          <option value="">全部</option>
          <option value="Y">發佈</option>
          <option value="N">草稿</option>
      </select>
      <button class="btn sm oi" data-glyph="magnifying-glass" id="btn_query" name="btn_query" onclick="form_ok();">搜尋</button>
  </header>
  <table class="table-list table-hover table-striped">
      <colgroup>
          <col style="width: 5%">
          <col style="width: 49%">
          <col style="width: 10%">
          <col style="width: 12%">
          <col style="width: 10%">
          <col style="width: 13%">
          <col style="width: 5%">
      </colgroup>
      <tr>
          {{-- 點選排序功能 (點一下遞增, 點兩下遞減)
              <button class="th-sort-toggle"></button>
              遞增 asc
              <button class="th-sort-toggle asc"></button>
              遞減 desc
              <button class="th-sort-toggle desc"></button>
          --}}
          <th class="item-edit">修改</th>
          <th class="text-left">標題</th>
          <th>
              {{-- 點選排序功能 (點一下遞增 asc, 點兩下遞減 desc) --}}
              <button class="th-sort-toggle {{ $class_cate }}" name="btn_cate" id="btn_cate" onclick="sort('cate_id');">分類</button>
          </th>
          <th>
              {{-- 點選排序功能 (點一下遞增 asc, 點兩下遞減 desc) --}}
              <button class="th-sort-toggle {{ $class_sort }}" name="btn_sort" id="btn_sort" onclick="sort('sort');">排序</button>
          </th>
          <th>
              {{-- 點選排序功能 (點一下遞增 asc, 點兩下遞減 desc) --}}
              <button class="th-sort-toggle {{ $class_status }}" name="btn_status" id="btn_status" onclick="sort('status');">狀態</button>
          </th>
          <th class="item-edit">刪除</th>
      </tr>
      {{--
          無資料
          <tr class="bg-pale-red"><td colspan="8">查無資料!</td></tr>
      --}}
      {{-- 建議: 1頁10筆資料 --}}
      @if ($row_count > 0)
          @for ($i = $min_row - 1; $i < $max_row; $i++)
             <?php
              $id = $info[$i]->id;
              $c_title = $info[$i]->c_title;
              //$c_date = mb_substr($info[$i]->c_date,0,10);
              $c_sort = $info[$i]->sort;
              $cate_name = $info[$i]->cate_name;
              if ($info[$i]->status == "Y")
              {
                  $show = "發佈";
                  $show_class = "label-success";
              }
              else
              {
                  $show = "草稿";
                  $show_class = "";
              }
              
              ?>
                  <tr>
                      <td>
                      <button class="hover-primary oi" title="修改" data-glyph="pencil" type="button" onclick="location.href='{{ url($SysPath . $cFile_Edit . "?id=" . $id) }}';"></button>
                      </td>
                      <td class="text-left">{{ $c_title }}</td>
                      <td>{{ $cate_name }}</td>
                      <td>{{ $sort }}</td>
                      <td><span class="label {{ $show_class }}">{{ $show }}</span></td>
                      <td>
                      <button class="hover-danger oi delete-btn" title="刪除" type="button" data-glyph="trash" onclick="del('{{ url($SysPath . $cFile_Del . "?id=" . $id) }}');"></button>
                      </td>
                  </tr>
          @endfor
      @else
          <tr class="bg-pale-red">
              <td colspan="7">
                  尚無資料
              </td>
          </tr>
      @endif

  </table>

  <footer class="table-foot">
    <small class="float-r">第 {{ $min_row }} - {{ $max_row }} 筆，共 {{ $row_count }} 筆</small>
    <nav class="pager">
        <a href="{{ url($SysPath . $cFile . "?page=" . $top_page) }}" class="oi" data-glyph="media-step-backward" title="到最前頁"></a>
        <a href="{{ url($SysPath . $cFile . "?page=" . $pre_page) }}" class="oi" data-glyph="caret-left" title="上一頁"></a>
        <span>
            第
            <input type="text" class="form-control form-control-sm text-xs-center" style="width:100px" name="page" id="page" value="{{ $page }}">
            頁，共 {{ $total_page }} 頁
        </span>
        <a href="{{ url($SysPath . $cFile . "?page=" . $next_page) }}" class="oi" data-glyph="caret-right" title="下一頁"></a>
        <a href="{{ url($SysPath . $cFile . "?page=" . $end_page) }}" class="oi" data-glyph="media-step-forward" title="到最後頁"></a>
    </nav>
 </footer>  

</form>
<script>
      $('#form1').on('keyup keypress', function (e) {
          var keyCode = e.keyCode || e.which;
          if (keyCode === 13) {
              e.preventDefault();
              return false;
          }
      });
      //$('#page').on('keydown', function (e) {
      //    if (e.which == 13) {
      //        //alert('clicked');
      //        document.form1.submit();
      //    }
      //});


      function form_ok() {
          $('#form1').submit();
      }

      function sort(c_sort) {
          var pre_sort = $('#txt_sort').val();
          var pre_a_d = $('#txt_a_d').val();
          var a_d = "";
          var s_sort = "";
          var class_a_d = "";

          s_sort = c_sort;
          if (pre_sort == c_sort) {
              if (pre_a_d == "") {
                  a_d = "desc";
              }
              else {
                  a_d = "";
              }
          }
          else {
              a_d = "";
          }

          //alert("pre_sort:" + pre_sort + ";pre_a_d:" + pre_a_d + ";a_d:" + a_d + ";s_sort=" + s_sort)

          $('#txt_sort').val(s_sort);
          $('#txt_a_d').val(a_d);

          $('#form1').submit();

      }
</script>

@endsection