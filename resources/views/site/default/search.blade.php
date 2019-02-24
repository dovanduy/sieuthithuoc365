@extends('site.layout.site')
@section('title', isset($category->title) ? $category->title : '')
@section('meta_description',  isset($category->description) ? $category->description : '' )
@section('keywords', '')
@section('content')
<script>
   $(document).ready(function(){          
          $('.sidebar>ul.submenu-mb>li').click(function(){
           if($(this).hasClass('active')) {
               $(this).find('ul').slideUp();
               $(this).find('i.fa-angle-down').css('transform','rotate(360deg)');
               $(this).find('i.fa-angle-down').css('transition','all 1s ease');
               $(this).removeClass('active');
                $(this).addClass('color');
           }
           else
           {
              $(this).find('ul').slideDown();
              $(this).addClass('active');
              // $(this).find('i').addClass('fa-rotate-180');
              $(this).find('i.fa-angle-down').css('transform','rotate(180deg)');
              $(this).find('i.fa-angle-down').css('transition','all 1s ease');
           }
         });
   });
</script>
<section class="main-ctn">
	<div class="container">
   <div class="wrapper wrapper-product-category ">
      <div class="breadcrumbs">
         <div class="wrapper container">
            <ul class="breadcrumbUrl">
               <li class="breadcrumb-item">
                  <span class="home">Từ khóa tìm kiếm của bạn là: {{ isset($_GET['word']) ? $_GET['word'] : ''}}</span>
               </li>
               
            </ul>
         </div>
      </div>
      <!--end: .breadcrumbs-->
      <section id="content" class="product-category-content">
         <div id="block-89" class="block-categories block-categories-default" style="margin-bottom:20px;">
            <!--end: .block-heading-->
            <div class="block-content clearfix">

               <div class="list_cat_child col-md-3 col-sm-5 col-xs-12">
                  <aside id="aside">
                     <div id="block-113" class="block-catsmenu block-catsmenu-products">
                        <div class="sidebar-heading-f">
                           Lọc sản phẩm
                           <i class="show_mb"></i>
                        </div>
                        <div class="span3-cotent sidebar-content">
                           <div class="sidebar span3-cotent sidebar-content" >
                              <ul class="submenu-mb color-border cats">
                                 @foreach (\App\Entity\Menu::showWithLocation('menu-cate-tab-index') as $Mainmenu)
                                    @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
                                 <li class="item menu-1 has-child">
                                    <a href="{{ $menuelement['url'] }}" class="current" title="{{ $menuelement['title_show'] }}">
                                    {{ $menuelement['title_show'] }}
                                    </a>
                                    <i class="fa fa-angle-down show-hidden" aria-hidden="true"></i>
                                     @if (!empty($menuelement['children']))
                                      <ul class="submenu-mb1">
                                       @foreach ($menuelement['children'] as $elemenparent)
                                         
                                             <li><a href="{{ $elemenparent['url']}}" title=" {{ $elemenparent['title_show']}} "><i class="fa fa-caret-right" aria-hidden="true"></i> {{ $elemenparent['title_show']}} </a></li>
                                             
                                          
                                      @endforeach
                                     </ul>
                                   @endif
                                    
                                 </li>
                                  @endforeach
                               @endforeach
                                 
                              </ul>
                           </div>
                        </div>
                        <!--end: .span3-cotent-->
                     </div>
                     <!--end: .block-catsmenu-->
                     <!--end: #block-87-->            
                  </aside>
                  @foreach(\App\Entity\FilterGroup::showFilterGroup() as $id => $filterGroup)
                  <div class="filter">
                     <div class="filter-title">{{ $filterGroup->group_name }}</div>
                     <ul tabindex="0" style="overflow: hidden; outline: none;">
                        @foreach(\App\Entity\Filter::showFilter($filterGroup->group_filter_id) as $id => $filter)
                        <li class="check"> <a data-value="{{ $filter->name_filter }}" onClick="return checkFilter(this);"> <i class="fa fa-caret-right" aria-hidden="true"></i>{{ $filter->name_filter }}</a></li>
                        @endforeach
                     </ul>
                  </div>
                  @endforeach
                  <form action="/cua-hang/san-pham" method="get" id="filterProduct">
            
                    </form>
                    <script>
                       function checkFilter(e) {
                          var valFilter = $(e).attr('data-value');
                          $('#filterProduct').append('<input type="hidden" value="' + valFilter + '" name="filter[]">')
                          $('#filterProduct').submit();

                          return true;
                       }
                    </script>
                  @if(!empty($category['image']))
                  <div  id="banner-103" class="item">
                     <a rel="nofollow" href="http://nhathuoc365.vn/nano-fucoidan-extract-granule-ho-tro-dieu-tri-ung-thu-pd580" title="{{ $category['title'] }}">
                     <img alt="Khuyến mại lớn Nano Fucoidan" src="{{ $category['image'] }}">
                     </a>
                  </div>
                  @endif
               </div>

               <div class="list-item clearfix col-md-9 col-sm-7 col-xs-12">
                  <div class="row">
                    
                
                  @if($products->isEmpty() )
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 cateItem noPadding">
                      <p>Không có sản phẩm phù hợp</p>
                  </div>
                  @else

                  @foreach ($products as $id => $product)
                  @include('site.partials.itempr')
                  @endforeach
                  @endif

                  <!--end: .product-item-->  
                  <p>
                  <div class='web-pagination Page'>
                     @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ $products->links() }}
                      @endif
                  </div>
                
                  </p>
                    </div>

               </div>
                

            </div>
            <!--end: .block-content-->
         </div>
		 </div>
      </section>
   </div>
</section>
@endsection