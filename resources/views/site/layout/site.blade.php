<!DOCTYPE html >
<html mlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://ogp.me/ns/fb#" class="no-js">
<head>
  <title>@yield('title')</title>
  <!-- meta -->
  <meta name="ROBOTS" content="index, follow" />
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="@yield('meta_description')" />
  <meta name="keywords" content="@yield('keywords')" />
  <!-- facebook gooogle -->
  <!-- <meta property="fb:app_id" content="" />
  <meta property="fb:admins" content=""> -->

  <link rel="icon" href="{{ !empty($information['icon']) ?  asset($information['icon']) : '' }}" type="image/x-icon" />

    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:locale" content="vi_VN"/>
    <meta property="og:type" content="@yield('type_meta')"/>
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('meta_description')" />
    <meta property="og:url" content="@yield('meta_url')" />
    <meta property="og:image" content="@yield('meta_image')" />
    <meta property="og:image:secure_url" content="@yield('meta_image')" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />

 <!--  <base href="{{ isset($domainUrl) ? $domainUrl : ''}}"> -->
  <base href="{{ isset($information['domain']) ? $information['domain'] : '' }}">
 
  <link href="//fonts.googleapis.com/css?family=Roboto:300italic,300,400italic,400,700italic,700" rel="stylesheet" type="text/css">    <link rel="canonical" href="" />
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css" />
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery.matchHeight-min.js"></script>


  <script src="assets/js/numeral.min.js"></script>


	{!! isset($information['google-alynic']) ? $information['google-alynic'] : '' !!}
</head>
<body>
  {{--<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>--}}
  <!-- Load Facebook SDK for JavaScript -->
  {!! isset($information['chat-facebook']) ? $information['chat-facebook'] : '' !!}
      
  @include('site.common.header')

    <!-- Phần nội dung -->
  @yield('content')

  @include('site.common.footer')    
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/home.js"></script>
  <script type="text/javascript" src="assets/js/default1.js"></script>
  <script type="text/javascript" src="assets/js/category.js"></script>
  <script type="text/javascript" src="assets/js/default2.js"></script>
  <script type="text/javascript" src="assets/js/owl.carousel.js"></script>
  <script type="text/javascript" src="assets/js/library.js"></script>
  <script type="text/javascript" src="assets/js/jquery.raty.js"></script>
  <script type="text/javascript" src="assets/js/script_main.js"></script>
  <script type="text/javascript" src="assets/js/function.js"></script>
  <script type="text/javascript" src="assets/js/menu_cat.js"></script>
  <script type="text/javascript" src="assets/js/jquery.autocomplete.js"></script>
  <script type="text/javascript" src="assets/js/search.js"></script>
  <script type="text/javascript" src="assets/js/default3.js"></script>


<!-- Bizweb javascript customer -->
<!-- Add to cart -->    
   
    
<!-- DANG KI EMAIL VA THEM GIO HANG -->
<script>
    function subcribeEmailSubmit(e) {
        var email = $(e).find('.emailSubmit').val();
        var token =  $(e).find('input[name=_token]').val();

        $.ajax({
            type: "POST",
            url: '{!! route('subcribe_email') !!}',
            data: {
                email: email,
                _token: token
            },
            success: function(data) {
                var obj = jQuery.parseJSON(data);

                alert(obj.message);
            }
        });
        return false;
    }

    function addToOrder(e) {
        var data = $(e).serialize();
       
        $.ajax({
            type: "POST",
            url: '{!! route('addToCart') !!}',
            data: data,
            success: function(result){
                var obj = jQuery.parseJSON( result);

                window.location.replace("/gio-hang");
            },
            error: function(error) {
                //alert('Lỗi gì đó đã xảy ra!')
            }

        });

        return false;
    }
  
	function contact(e) {
		var $btn = $(e).find('button').button('loading');
		var data = $(e).serialize();
		
		$.ajax({
            type: "POST",
            url: '{!! route('sub_contact') !!}',
            data: data,
            success: function(result){
                var obj = jQuery.parseJSON( result);
				// gửi thành công
                if (obj.status == 200) {
					alert(obj.message);
					$btn.button('reset');
					
					return;
				}
				
				// gửi thất bại
				if (obj.status == 500) {
					alert(obj.message);
					$btn.button('reset');
					
					return;
				}
            },
            error: function(error) {
                //alert('Lỗi gì đó đã xảy ra!')
            }

        });
		
		
		return false;
	}
</script>

</body>
</html>