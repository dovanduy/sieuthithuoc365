@extends('site.layout.site')
@section('title', 'Tags')
@section('meta_description',   isset($information['meta_description']) ? $information['meta_description'] : '' )
@section('keywords', isset($information['meta_keyword']) ? $information['meta_keyword'] : '')
@section('content')
    <style type="text/css">
        ul.clearfix
        {
            list-style: none;
        }
        ul.breadcrumbUrl
        {
            padding: 0 20px;
        }
        .block-catsmenu ul {
            margin: 0;
            padding: 7px 0 7px 15px;
            border: 1px solid #ccc;
        }
        .filter {
            padding-bottom: 10px;
            padding-right: 0;
            margin-bottom: 20px;
            margin:30px 0;
            clear: both;
            border-bottom: 1px solid #f2f2f2;
        }
        .block-catsmenu {
            margin-bottom: 40px;
        }
        .filter .filter-title {
            text-transform: uppercase;
            font-size: 15px;
            color: #111;
            line-height: 40px;
            padding-left: 15px;
            border-left: 2px solid #0073ad;
            border-top: 1px solid #f2f2f2;
            border-bottom: 1px solid #f2f2f2;
        }
        .filter ul {
            margin: 0;
            padding: 0;
            padding-left: 15px;
            padding-top: 10px;
            list-style: none;
        }
        .filter ul li a
        {
            color: #333;
            font-size: 14px;
            padding:0 10px;
            text-align: left;
            display: block;
        }
        .filter ul li a i
        {
            padding-right:5px;
        }
        .filter ul li a:hover
        {
            text-decoration: none;
            color:#0073ad;
        }
        .filter ul li a:hover i
        {
            padding-left: 15px;
        }
        .filter ul li.check {
            background: url(../nhathuoc365/images/check.png) left center no-repeat;
        }

        .block-catsmenu ul.submenu-mb1 {
            border: none;
        }
        .block-catsmenu ul a
        {
            font-size: 15px;
        }
        .block-catsmenu ul.submenu-mb1 li i
        {
            padding-right: 5px;
        }
        .Page .pagination>.active>a, .Page .pagination>.active>span, .Page .pagination>.active>a:hover, .Page .pagination>.active>span:hover, .Page .pagination>.active>a:focus, .Page .pagination>.active>span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #0073ad;
            border-color: #0073ad;
        }
        .block-categories-default .block-content .list-item {
            padding-top: 10px;
            padding-bottom: 22px;
        }
        .cart_view
        {
            display: none !important;
        }
    </style>
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
    <!--  <link rel="stylesheet" type="text/css" media="screen" href="nhathuoc365/modules/product/assets/css/responsive-product.css" /> -->
    <link rel="stylesheet" type="text/css" media="screen" href="nhathuoc365/blocks/catsmenu/assets/css/default.css" />
    <section class="main-ctn">
        <div class="container">
            <div class="wrapper wrapper-product-category ">
                <div class="breadcrumbs">
                    <div class="wrapper container">
                        <ul class="breadcrumbUrl">
                            <li class="breadcrumb-item">
                                <span class="home">Từ khóa: {{ isset($_GET['tags']) ? $_GET['tags'] : '' }}</span>
                            </li>

                        </ul>
                    </div>
                </div>
                <!--end: .breadcrumbs-->
                <section id="content" class="product-category-content container">
                    <div id="block-89" class="block-categories block-categories-default container" style="margin-bottom:20px;">
                        <!--end: .block-heading-->
                        <div class="block-content clearfix row">

                            <div class="list-item clearfix col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                @if($products->isEmpty() )
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 cateItem noPadding">
                                            <p>Không có sản phẩm phù hợp</p>
                                        </div>
                                @else
                                    @foreach ($products as $id => $product)
                                        @include('site.partials.itempr', ['product' => $product])
                                    @endforeach
                                    <div class='web-pagination Page'>
                                        {{ $products->links() }}
                                    </div>
                                @endif

                                <!--end: .product-item-->
                                </div>

                            </div>


                        </div>
                        <!--end: .block-content-->
                    </div>
                    <!-- <div class='web-pagination'>
                       <div><a title='first_page' class='disable' href='san-pham' title='First page' >< </a><font title='Page 1' class='current pageLink'>1</font><a rel='nofollow' class='pageLink' title='Page 2' href='san-pham/trang-2' title='2' >2</a><a rel='nofollow' class='pageLink' title='Page 3' href='san-pham/trang-3' title='3' >3</a><a rel='nofollow' class='pageLink' title='Page 4' href='san-pham/trang-4' title='4' >4</a> <b class='pageLink'>...</b> <a title='Last page' href='san-pham/trang-19' > ></a></div>
                    </div> -->
                </section>
            </div>
        </div>
    </section>
    <div class="banner_left"></div>
    <div class="banner_right"></div>
@endsection