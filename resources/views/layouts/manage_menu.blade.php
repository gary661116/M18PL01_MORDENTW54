{{-- resources/views/layouts/manage_menu.blade.php --}}
<aside id="sidebar">
    <h6 class="oi" data-glyph="menu">功能選單 MENU</h6>
    <header class='collapse-toggle oi @if($subnav == "adv" ) active  @endif' data-glyph="cog">廣告管理</header>
    <nav class='collapse-content @if($subnav == "adv" ) in  @endif'>
        <a href="{{ url('/') }}/manage/adv_cate_list" class='@if($subnav2 == "adv_cate" ) active  @endif'>廣告類別</a>
        <a href="{{ url('/') }}/manage/adv_list" class='@if($subnav2 == "adv_list" ) active  @endif'>廣告清單</a>
    </nav>
    <header class='collapse-toggle oi @if($subnav == "news" ) active  @endif' data-glyph="cog">最新消息</header>
    <nav class='collapse-content @if($subnav == "news" ) in  @endif'>
        <a href="{{ url('/') }}/manage/news_cate_list" class='@if($subnav2 == "news_cate" ) active  @endif'>消息類別</a>
        <a href="{{ url('/') }}/manage/news_list" class='@if($subnav2 == "news_list" ) active  @endif'>消息清單</a>
    </nav>
    <header class='collapse-toggle oi @if($subnav == "proj" ) active  @endif' data-glyph="cog">成交案例</header>
    <nav class='collapse-content @if($subnav == "proj" ) in  @endif'>
        <a href="{{ url('/') }}/manage/proj_cate_list" class='@if($subnav2 == "proj_cate" ) active  @endif'>案例類別</a>
        <a href="{{ url('/') }}/manage/proj_list" class='@if($subnav2 == "proj_list" ) active  @endif'>案例清單</a>
    </nav>   
    <header class='collapse-toggle oi @if($subnav == "Prod" ) active  @endif' data-glyph="cog">產品管理</header>
    <nav class='collapse-content @if($subnav == "Prod" ) in  @endif'>
         <a href="{{ url('/') }}/manage/prod_cateb_list" class='@if($subnav2 == "Prod_CateB_List" ) active  @endif'>產品大類</a>
         <a href="{{ url('/') }}/manage/prod_cates_list" class='@if($subnav2 == "Prod_CateS_List" ) active  @endif'>產品小類</a>
         <a href="{{ url('/') }}/manage/prod_list" class='@if($subnav2 == "Prod_List" ) active  @endif'>產品明細</a>
    </nav>
    <a href="{{ url('/') }}/manage/faq_list" class='collapse-toggle oi @if($subnav == "Faq" ) active  @endif' data-glyph="flag">FAQ</a>
    <header class='collapse-toggle oi @if($subnav == "Partner" ) active  @endif' data-glyph="cog">合作夥伴</header>
    <nav class='collapse-content @if($subnav == "Partner" ) in  @endif'>
        <a href="{{ url('/') }}/manage/partner_cate_list" class='@if($subnav2 == "Partner_Cate_List" ) active  @endif'>合作夥伴-類別</a>
        <a href="{{ url('/') }}/manage/partner_list" class='@if($subnav2 == "Partner_List" ) active  @endif'>合作夥伴</a>
    </nav>
    <a href="{{ url('/') }}/manage/foot_list" class='collapse-toggle oi @if($subnav == "Foot" ) active  @endif' data-glyph="flag">Foot</a>
    <header class='collapse-toggle oi @if($subnav == "Sys" ) active  @endif' data-glyph="cog">系統設定</header>
    <nav class='collapse-content @if($subnav == "Sys" ) in  @endif'>
        <a href="{{ url('/') }}/manage/changePW" class='@if($subnav2 == "ChangPW" ) active  @endif'>變更密碼</a>
    </nav>
</aside>