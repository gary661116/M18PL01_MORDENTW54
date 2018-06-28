<!-- 檔案位置: resources/views/manage/index.blade.php -->
  {{-- 設定變數 --}}
  <?php 
  //$title = '最新消息'; 
  $IsFirstPage = FALSE;
  $subnav = "";
  $subnav2 = "";
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

    <p>您好，歡迎使用本系統！請點選左方的功能選單進行操作，謝謝。</p>
@endsection