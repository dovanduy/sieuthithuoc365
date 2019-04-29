@extends('site.layout.site')

@section('title', isset($information['meta_title']) ? $information['meta_title'] : '')
@section('meta_description', isset($information['meta_description']) ? $information['meta_description'] : '')
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')

@section('content')
   @include('site.partials.slider')
   <style type="text/css">
   .block-menu-banner
{
   display: block;
}

      @media (max-width: 768px)
      {
          .block-menu-banner
{
   display: none;
}
      }

   </style>
   <section class="main-ctn">
	<div class="container">
      <div class="wrapper">
         <section id="content">
            <!-- KHUYEN MAI DAC BIET -->
             <!-- @include('site.partials.khuyenmai') -->
             <div class="clearfix"></div>
            <div id="block-60" class="block-banner block-banner-default mbds-block " style="float:none;">
               <div class="row">
                  <div class="col-md-4 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                     @foreach(\App\Entity\SubPost::showSubPost('banner-san-pham', 5) as $id => $item)   
                        @if($item['vi-tri'] == 1)
                           <div id="banner-90" class="item w100">
                              <a rel="nofollow" href="{{ isset($item['link-san-pham'])  ? $item['link-san-pham'] : '#'}}" title="{{ isset($item['title']) ? $item['title'] : ''}}">
                              <img alt="{{ isset($item['title']) ? $item['title'] : ''}}" src="{{ isset($item['image']) ? $item['image']  : ''}}" class="w100">
                              </a>   
                           </div>
                        @endif
                     @endforeach

                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                     <div class="row">
                        @foreach(\App\Entity\SubPost::showSubPost('banner-san-pham', 5) as $id => $item)   
                        @if($item['vi-tri'] == 2)   
                        <div id="banner-91" class=" col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 10px">
                           <div class="CropImg CropImg70 CropImgw100">
                              <div class="thumbs">
                                 <a rel="nofollow" href="{{ isset($item['link-san-pham'])  ? $item['link-san-pham'] : '#'}}" title="{{ isset($item['title']) ? $item['title'] : ''}}">
                              <img alt="{{ isset($item['title']) ? $item['title'] : ''}}" src="{{ isset($item['image']) ? $item['image']  : ''}}">
                              </a>
                              </div>
                           </div>
                        </div>
                         @endif
                     @endforeach

                     </div>
                  </div>
                  
               </div>
            </div>
 <div class="clearfix"></div>

            @foreach (\App\Entity\Menu::showWithLocation('menu-cate-tab-index') as $Mainmenu)
               @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
               <div class="block-categories block-categories-default bgwhite" >
                  <?php $urlscate = explode('/', $menuelement['url']); ?> 
                  <?php $cateTour = \App\Entity\Category::getDetailCategory($urlscate[2]); ?>
    
                  <div class="block-heading row" style="border:2px solid {{  isset( $cateTour['backgruod-title']) ? $cateTour['backgruod-title'] : '#54a8d2' }} ">

                     <div class="heading col-md-3 col-sm-3 col-xs-12" style="background: {{  isset( $cateTour['backgruod-title']) ? $cateTour['backgruod-title'] : '#54a8d2' }} ">
                        <span class="icon_cat" style="background: {{  isset( $cateTour['backgruod-icon']) ? $cateTour['backgruod-icon'] : '#0073ad' }} "><img class="img_cat" src="{{  isset( $cateTour['icon-danh-muc']) ? $cateTour['icon-danh-muc'] : '#54a8d2' }}"></span>
                        <i class="icon_title" style="background:{{  isset( $cateTour['backgruod-icon']) ? $cateTour['backgruod-icon'] : '#0073ad' }}"></i>
                        <a  style="background: {{  isset( $cateTour['backgruod-title']) ? $cateTour['backgruod-title'] : '#54a8d2' }} " href="{{ $menuelement['url'] }}" title="{{ $menuelement['title_show'] }}" style="color: #fff">{{ $menuelement['title_show'] }}</a>
                     </div>
                  </div>
				 

                  <!--end: .block-heading-->
                  <div class="block-content row">
                     <div class="list_cat_child col-md-3 col-sm-3 col-xs-12">
                        <div class="child_cat">
                           @if (!empty($menuelement['children']))
                              @foreach ($menuelement['children'] as $elemenparent)
                                 <a class="item_child" href="{{ $elemenparent['url']}}" title="{{ $elemenparent['title_show']}}" >
                                 {{ $elemenparent['title_show']}}  
                                 </a>
                             @endforeach
                          @endif
                           
                        </div>
                        <div class="banner_cat mbds-none">
							 <a href="{{ $menuelement['url'] }}" title=""><img src="{{ $menuelement['image'] }}" alt=""></a>
                        </div>
                     </div>
                     <div class="list-item clearfix col-md-9 col-sm-9 col-xs-12 pdtop10">
                        <div class="clearfix">  
                      
                        <?php $urls = explode('/', $menuelement['url']) ?>
                        @foreach (\App\Entity\Product::showProduct($urls[2],8) as $id => $product)
                           @include('site.partials.itempr')
                        @endforeach
                       </div>
                     <!--end: .product-item-->                   
                       
                     </div>
                  </div>
                  <!--end: .block-content-->
               </div>
               @endforeach
            @endforeach
           

            <!--end: .block-categories-->
            <div class="help_home clearfix">
               <div class="foot_banner">
                  <div class="banner_img col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <div class="gioithieu row">
                       
                        @foreach(\App\Entity\SubPost::showSubPost('sologan', 3) as $id => $sologan)
                        <div class=" col_box col-md-4 col-sm-4 col-xs-4 item">
							<a href="{{ $sologan['link-slogan'] }}">
							   <img src="{{ $sologan['image'] }}" alt="">
							   <h3 class="title_1">{{ $sologan['title'] }}</h3>
							   <p>{{ $sologan['description'] }}</p>
						   </a>
                        </div>
                        @endforeach
                        
                        
                     </div>
                  </div>
               </div>
            </div>
            <!-- .share-face-->
             @foreach (\App\Entity\Menu::showWithLocation('show-category-new') as $Mainmenu)
               @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
                     <?php $urlscate = explode('/', $menuelement['url']); ?>
                     <?php $cateTour = \App\Entity\Category::getDetailCategory($urlscate[2]); ?>
             <style>
                 .block-news-succes_story_ct #story_heading{{$id}} >a:before {
                     border-left-color: {{ $cateTour['backgruod-icon'] }};
                     background: {{ $cateTour['backgruod-icon'] }} url(../images/icon_title.png) no-repeat 10px;
                 }
                 .block-news-succes_story_ct #story_heading{{$id}} {
                     background: {{ $cateTour['backgruod-title'] }};
                 }
                 .block-news-succes_story_ct #story_heading{{$id}} >a:after {
                     border-left-color: {{ $cateTour['backgruod-title'] }};
                 }
             </style>
            <div class="block-news block-news-succes_story_ct clearfix" style="float:none;margin-bottom:15px;">
               <div class="block-news-heading story_heading clearfix" id="story_heading{{$id}}">
                  <a class="selected" title="{{ $menuelement['title_show'] }}" href="{{ $menuelement['url'] }}">{{ $menuelement['title_show'] }}</a>
                   <i class="icon_title" style="background:{{  isset( $cateTour['backgruod-icon']) ? $cateTour['backgruod-icon'] : '#0073ad' }}"></i>
               </div>
               <!--end: .block-news-title-->
               <div class="block-news-content clearfix">
                  <div class="owl-carousel-story  owl-theme">
                    <?php $urls = explode('/', $menuelement['url']) ?>
                    @foreach(\App\Entity\Post::categoryShow($urls[2],10) as $post)
                        @php $category = \App\Entity\Category::getDetailCategory($urls[2]); @endphp
                         @include('site.partials.itemnew')
                    @endforeach
                  </div>
               </div>
               <!--end: .list-->
            </div>
             @endforeach
            @endforeach
            <!--end: .block-news-content-->
			<script>
				//Đồng bộ chiều cao các div
				$(function() {
				  $('.item .inf_').matchHeight();
				});
            </script>
            <!--end: .block-news-content-->
         </section>
         <!--end: #content-->
      </div>
	  </div>
   </section>
   <div class="banner_left">
   </div>
   <div class="banner_right">
   </div>
   
   <!--@foreach (\App\Entity\Menu::showWithLocation('menu-cate-tab-index') as $Mainmenu)
   @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
      <?php //$urls = explode('/', $menuelement['url']) ?>

      @foreach (\App\Entity\Product::showProduct($urls[2],8) as $id => $product)
         @include('site.partials.modal')
      @endforeach         
   @endforeach
	@endforeach--> 
@endsection


<!--END  MODAL -->