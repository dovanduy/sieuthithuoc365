<header>
   <section class="header_top">
	<div class="container">
		  <div class="wrapper row">
			 <div class="fix-pad link_web">
				<div id="block-0" class="block-menu block-menu-menu_header">
				   <ul>
					  <!-- <li class="menu-381  "><a href="" title="Tư vấn giảm cân">Tư vấn giảm cân</a></li>
						 <li class="menu-380  "><a href="" title="Mẹ thông thái">Mẹ thông thái</a></li>
						 <li class="menu-379  "><a href="http://dinhduong365.vn" title="Dinh dưỡng 365">Dinh dưỡng 365</a></li> -->
				   </ul>
				</div>
				<!--end: #block-0-->            
			 </div>
			 <div class="fix-pad hotline_ col-md-4 col-sm-12 col-xs-12">
				<p class="hotline">Hotline: <span>{{ isset($information['hotline']) ? $information['hotline'] : '' }}</span> hoặc <span>{{ isset($information['so-dien-thoai']) ? $information['so-dien-thoai'] : '' }}</span></p>
			 </div>
			 <div class="fix-pad time_work col-md-8 col-sm-12 col-xs-12" style="text-align: right;">
				<p class="clock">
				   Thời gian làm việc: <span>{{ isset($information['thoi-gian-lam-viec']) ? $information['thoi-gian-lam-viec'] : '' }}</span> (tất cả các ngày trong tuần)
				   @if(\Illuminate\Support\Facades\Auth::check())
               <span class="information">
                  <a class="reginfo btn btn-primary" href="/thong-tin-ca-nhan"><i class="fa fa-user" aria-hidden="true"></i> Tài khoản</a>
                  <a class="reginfo btn btn-warning"  href="{{ route('logoutHome') }}">Thoát</a>
               </span>
               {{--<form id="logout-form" action="{{ route('logoutHome') }}" method="POST" style="display: none;">--}}
                 {{--{{ csrf_field() }}--}}
                 {{--</form>--}}
               @else
               <span class="btn-login">
                 <a class="reginfo btn btn-warning" href="/dang-ky"><i class="fa fa-key" aria-hidden="true"></i> Đăng ký</a>
                 <a href="/trang/dang-nhap" class="btn btn-primary"><i class="fa fa-user" aria-hidden="true"></i> Đăng Nhập</a>
               </span>
				   @endif
				</p>

			 </div>
		  </div>
	  </div>
   </section>
   <div class="wrapper container">
   <div class="logo_menu row">
      <div class="div_logo col-md-3 col-sm-12 col-xs-12">
         <!-- <div class="menuMB ds-none mbds-block">
            <i class="fa fa-bars" aria-hidden="true"></i>
         </div> -->
         <h1 class="logo">
            <a href="/"><img src="{{ isset($information['logo']) ? $information['logo'] : '' }}"></a></figure>
            <p class="clock_mb">Thời gian làm việc: <span> {{ isset($information['thoi-gian-lam-viec']) ? $information['thoi-gian-lam-viec'] : '' }}</span> (tất cả các ngày trong tuần)</p>
         </h1>
         <div class="cartMB ds-none mbds-block">
            <div class="cart_mb">
               <?php $countOrder = \App\Entity\Order::countOrder();?>
                  @if($countOrder <= 0)
                      <a  title=""> <i class="icon_cart"></i>
                                  <span>({{ $countOrder }})</span></a>
                  @else
                     <a href="/gio-hang">
                      <i class="icon_cart"></i>
                                  <span>({{ $countOrder }})</span>
                     </a>
               @endif
            </div>

         </div>

         <div class="login ds-none mbds-block" style="margin-top: 90px;">
             @if(\Illuminate\Support\Facades\Auth::check())
                  <a class="reginfo btn btn-primary" href="/thong-tin-ca-nhan"><i class="fa fa-user" aria-hidden="true"></i> Tài khoản</a>
                  <a class="reginfo btn btn-warning"  href="{{ route('logoutHome') }}">Thoát</a>
                  {{--<form id="logout-form" action="{{ route('logoutHome') }}" method="POST" style="display: none;">--}}
                  {{--{{ csrf_field() }}--}}
                  {{--</form>--}}
               @else
                   <a class="reginfo btn btn-warning" href="/dang-ky"><i class="fa fa-key" aria-hidden="true"></i> Đăng ký</a>
                  <a href="/trang/dang-nhap" class="btn btn-primary"><i class="fa fa-user" aria-hidden="true"></i> Đăng Nhập</a>
               @endif
         </div>
      </div>
      <div class="menu_main col-md-9 col-sm-12 col-xs-12 mbds-none">
         <div id="block-0" class="block-menu block-menu-navigation">
            <ul>
               
               @foreach (\App\Entity\Menu::showWithLocation('menu-chinh') as $Mainmenu)
                  @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)

                     <li class="menu-11 ">
                        <a href="{{ $menuelement['url'] }}" title="{{ $menuelement['title_show'] }}">{{ $menuelement['title_show'] }}</a>
                        @if (!empty($menuelement['children']))
                        <ul class="submenu submenu-11 ">
                           @foreach ($menuelement['children'] as $elementparent)
                           <li class="menu-390 "><a href="{{ $elementparent['url'] }}" title="{{ $elementparent['title_show'] }}">{{ $elementparent['title_show'] }}</a></li>
                           @endforeach
                        </ul>
                        @endif
                     </li>
                  @endforeach
               @endforeach   


             
             
            </ul>
         </div>
         <!--end: #block-0-->
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="header-mobile">
      <span class="onclick-memnu" id="toggleMenu" onclick="openNav()">
         <p class="navicon-line"></p>
         <p class="navicon-line"></p>
         <p class="navicon-line"></p>
      </span>
      <a class="menu-search-mobile" id="search-mobile"></a>
   </div>
   <!-- END: .header-mobile -->
   <div id="mySidenav" class="sidenav">
      <div class="row-item sidenav-wapper">
         <a href="javascript:void(0)" class="close-offcanvas" onclick="closeNav()"></a>
         <div id="block-0" class="block-menu block-menu-mobile">
            <ul>
               @foreach (\App\Entity\Menu::showWithLocation('menu-chinh') as $Mainmenu)
                  @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
                     <li class="menu-11 ">
                        <a href="{{ $menuelement['url'] }}" title="{{ $menuelement['title_show'] }}">{{ $menuelement['title_show'] }}</a>
                        @if (!empty($menuelement['children']))
                        <ul class="submenu submenu-11 ">
                           @foreach ($menuelement['children'] as $elementparent)
                           <li class="menu-390 "><a href="{{ $elementparent['url'] }}" title="{{ $elementparent['title_show'] }}">{{ $elementparent['title_show'] }}</a></li>
                           @endforeach
                        </ul>
                        @endif
                     </li>
                  @endforeach
               @endforeach   
            </ul>
         </div>
         <!--end: #block-0-->
         <script type="text/javascript">
            $('.block-menu-mobile > ul > li > a').click(function(){
                $(this).parent().toggleClass('selected');
            });

            $( document ).ready(function() {
               $('#toggleMenu').click(function(){
                  $('#mySidenav').show();
               })
            });

         </script>        
      </div>
   </div>
</header>



<div class="header_bottom ">
   <div class="container">
   <div class="wrapper row ">
      <div class="menu_cat_prd cat_mn clearfix col-md-3 col-sm-6 col-xs-12"">
         <p class="danhmuc">Danh mục sản phẩm</p>
         <!-- block-menu-banner block-menu-banner-default clearfix -->
         <div id="block-0" class="block-menu-banner block-menu-banner-default clearfix" style="" style="position:relative;">
            <div class="bmb-menu">
               <ul>
                   @foreach (\App\Entity\Menu::showWithLocation('side-left-menu') as $Mainmenu)
               @foreach (\App\Entity\MenuElement::showMenuPageArray($Mainmenu->slug) as $id=>$menuelement)
                  <?php $urlscate = explode('/', $menuelement['url']); ?> 
                 
                  <?php $cateTour = \App\Entity\Category::getDetailCategory($urlscate[2]); ?>
                   @if (!empty($cateTour))
                  <li style="background-image: url('{{  isset( $cateTour['icon-toi-mau']) ? $cateTour['icon-toi-mau'] : '#71bf44' }}')" >
                     <a class="a_parent" href="{{ $menuelement['url'] }}" title="{{ $menuelement['title_show'] }}">
                     {{ $menuelement['title_show'] }} 
                       </a>
                     @if (!empty($menuelement['children']))
                     <div id="box-sub-18" class="box-sub">
                        <ul>
                           @foreach ($menuelement['children'] as $elementparent)
                           <li>
                              <a href="{{ $elementparent['url'] }}" title="{{ $elementparent['title_show'] }}">{{ $elementparent['title_show'] }}</a>
                           </li>
                            @endforeach
                        </ul>
                     </div>
                     @endif
                  </li>
                  @endif
               @endforeach
            @endforeach 
               </ul>
            </div>
            <!--end: .bbm-menu-->
         </div>
         <!--end: .block-products-->        
      </div>
      <div class="menu_cat_prd box_search clearfix col-md-7 col-sm-6 col-xs-12">
         <div class="search-top cf row">
            <form action="{{ route('search_product') }}" name="search_form" id="search_form" action="index_submit" method="get" onsubmit="javascript: submit_form_search();
               return false;" accept-charset="utf-8" class="col-xs-12 mbds-none">
               <input type="text" class="fl keyword" name="word" id="txt-search" value="{{ (!empty($_GET['word'])) ? $_GET['word'] : '' }}" placeholder="Nhập từ khóa tìm kiếm" />
               <input type="submit" class="fa fa-search" id="bt-search" value=" " >              
            </form>

            <div class="ds-none mbds-block col-xs-12 searchMB">
               <form action="{{ route('search_product') }}" name="search_form" id="search_form" action="index_submit" method="get" onsubmit="javascript: submit_form_search_mb();
               return false;" accept-charset="utf-8">
                  <input type="text" class="fl keyword" name="word" id="txt-searchMB" value="{{ (!empty($_GET['word'])) ? $_GET['word'] : '' }}" placeholder="Nhập từ khóa tìm kiếm" />
                  <input type="submit" id="bt-search" value=" " >
               </form>
            </div>
         </div>
      </div>
      <div class="div_cart clearfix col-md-2">
         <div class="cart">
            <i class="icon_cart"></i>
            <p class="text_giohang">Giỏ hàng</p>


            <?php $countOrder = \App\Entity\Order::countOrder();?>
                     @if($countOrder <= 0)
                         <a title="">(0) - Sản phẩm</a>
                     @else
                        <a href="/gio-hang">
                        ({{ $countOrder }}) -Sản phẩm
                        </a>

                     @endif

          
            <a href="javascript:void(0)" title="" class="icon-mb"><img src="assets/images/shop-cart.png" alt=""><span>0</span></a>
            <script>
               $('.cart a').click(function (event) {
                   var c = 0;
                   if (c == 0) {
                       $('.mask,#shop-cart-alert').fadeIn();
                   }
               });
               $('#shop-cart-alert .close,#shop-cart-alert a,.mask,.popup_cart .close,#TB_window .box-popup .bp-title a').click(function () {
                   $('#shop-cart-alert,.mask,#TB_window').fadeOut();
                   $('.popup_cart,.mask,#TB_window').fadeOut();
                   $('.popup_cart .content,#TB_window .bp-content').text('');
               });
            </script>
         </div>
      </div>
   </div>
   </div>


</div>

 





