@extends('site.layout.site')

@section('type_meta', 'website')
@section('title', !empty($post->meta_title) ? $post->meta_title : $post->title) 
@section('meta_description', !empty($post->meta_description) ? $post->meta_description : $post->description) @section('keywords', $post->meta_keyword ) @section('meta_image', asset($post->image) ) 
@section('meta_url', route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug]) )
@section('meta_image', asset($post->image) ? $post->image : '' )
@section('meta_url', route('post', ['cate_slug' =>  $category->slug, 'post_slug' => $post->slug]) )

@section('content')

<section class="pdbottom20 bgwhite">
<div class="container">
    <div class="wrapper wrapper-news-detail row">

        <div class="breadcrumbs">
            <div class="wrapper col-xs-12">
                <ul>
                    <li class="breadcrumb-item">
                        <a class="home" href="/">Trang chủ</a>
                    </li>
        
                    <li class="breadcrumb-item">
                        <a itemprop="url" title="Làm đẹp và sức khỏe"><span itemprop="title">{{ isset($post['title']) ? $post['title'] : '' }}</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <!--end: .breadcrumbs-->

        <div id="news-detail" class="col-xs-12">
            <h1 class="news-title">{{ isset($post['title']) ? $post['title'] : '' }}</h1>
            <div class="news-date">
                <span class="date">{{ isset($post['updated_at']) ? $post['updated_at'] : '' }}</span>
               
            </div>
            <div class="sumary_new">
                {!! isset($post['content']) ? $post['content'] : 'Đang cật nhập thông tin' !!}

            </div>
            @if(!empty($post['tags']))
                <div class="tags">
                    <p class="timkiem_dathang">Gợi ý tìm kiếm:</p>

                    @foreach(explode(',', $post['tags']) as $tag)
                        <a href="/tags?tags={{ $tag }}" title="{{ $tag }}"><span class="tag">{{ $tag }},</span></a>
                    @endforeach

                </div>
            @endif
            <br>
            <div class="col-12" style="margin: 15px">
   <div id="fb-root"></div>
   <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.1';
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
   </script>
   <div class="fb-like" data-href="{{ route('post', ['cate_slug' => $category->slug, 'post_slug' => $post->slug]) }}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
</div>
            <div class="function mb30">
                @include('general.sub_comments', ['post_id' => $post->post_id] )
            </div>
            <!--end: #news-detail-->

             <div>
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
                    @foreach(\App\Entity\Post::categoryShow($urls[2],15) as $post)
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
                <!--end: .list-thumb-->
            </div>

            <div class="other-news">
            </div>

            <input id="category_id" type="hidden" value="1468" />

            <div class="clearfix"></div>

        </div>
</div>
</section>



@endsection