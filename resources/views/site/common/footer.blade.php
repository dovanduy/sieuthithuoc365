

 <footer>
         <div class="info ">
            <div class="container">
            <div class="wrapper row ">
               <div class="col-md-9 col-sm-12 services">
                     <div class="col col-xs-12 col-sm-6 col-md-4 contactInfo">
                        <p class="tit_2">Thông tin liên hệ</p>
                        <span class="addres_">{{ isset($information['dia-chi']) ? $information['dia-chi'] : '' }}</span>
                        <span class="tele_">{{ isset($information['dien-thoai']) ? $information['dien-thoai'] : '' }}</span>
                        <span class="email_">{{ isset($information['email']) ? $information['email'] : '' }}</span>
                     </div>
                     <div class="col col-xs-12  col-sm-6 col-md-4 aboutUs">
                        <p class="tit_2">Về chúng tôi</p>
                        <ul>
                           @foreach(\App\Entity\Post::categoryShow('ve-chung-toi',5) as $post)
                           <li class="menu-31  selected"><a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}" title="{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : ''}}">{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : ''}}</a></li>
                           @endforeach
                        </ul>
                     </div>
                     <div class="col col-xs-12 col-sm-6 col-md-4 support">
                        <p class="tit_2">Dịch vụ & hỗ trợ</p>
                        <ul>
                           
                           @foreach(\App\Entity\Post::categoryShow('dich-vu-ho-tro',5) as $post)
                           <li class="menu-31  selected"><a href="{{ route('post', ['cate_slug' => 'tin-tuc', 'post_slug' => $post->slug]) }}" title="{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : ''}}">{{ isset($post['title']) ? \App\Ultility\Ultility::textLimit($post['title'], 10) : ''}}</a></li>
                           @endforeach
                           
                        </ul>
                     </div>
               </div>
               <div class="col-md-3 fanpages">
                  <div class="row">
                     <div class="footer_r clearfix ">
                  <p class="tit_2 col-xs-12">Liên kết Facebook</p>
                  <div class="block-fanpage ">
                     {!! isset($information['nhung-facebook']) ? $information['nhung-facebook'] : '' !!}
                  </div>
               </div>
                  </div>
               </div>
               
            </div>
             </div>
         </div>
         <div class="register_new_footer">
            <div class="container">
            <div class="get_news row">
               <div class="col-md-6">
                  <form  id="frmGetNews" method="post" accept-charset="utf-8" class="" onsubmit="return subcribeEmailSubmit(this)">
                     {{ csrf_field() }}
                     <p class="tit_f">Đăng ký nhận bản tin</p>
                     <p>Chúng tôi sẽ gửi tất cả các thông tin khuyến mại và chương trình sale off của chúng tôi với bạn</p>
                     <div>
                        <input type="email" id="EmailGetNews" value="" placeholder="Email của bạn..." class="emailSubmit">
                        <button class="button" style="border: none">Đăng ký</button>
                     </div>
                  </form>
                  <div class="ban_quyen_hidden col-xs-12">
                   <p>{{ isset($information['copy-right']) ? $information['copy-right'] : '' }}</p>
                  </div>
               </div>
               <div class="col-md-6 paymentSupport">
                  <p class="tit_f">Thanh toán</p>
                  <p class="tit_m">Chúng tôi cung cấp các giải pháp thanh toán tiện lợi cho bạn</p>
                  <img src="{!! isset($information['thuong-hieu']) ? $information['thuong-hieu'] : '' !!}">
                  <!-- <img style="width: 115px; padding-top: 15px; display: block;" src="nhathuoc365/templates/version3/images/register-stamp.png"> -->
               </div>
               <div class=""></div>
               <div class="ban_quyen col-xs-12">
                   <p>{{ isset($information['copy-right']) ? $information['copy-right'] : '' }}</p>
                  </div>
            </div>
         </div>
         </div>

      </footer>
      <a href="tel:{{ isset($information['hotline']) ? $information['hotline'] : '' }}" class="call_me">
      <img src="nhathuoc365/templates/version3/scss/images/phone_1.png" style="max-width: 100%">
     {{ isset($information['hotline']) ? $information['hotline'] : '' }}    </a>
      <a href="#top" class="cd-top">Top</a>

     
     <!--  <script type='text/javascript'>window._sbzq||function(e){e._sbzq=[];var t=e._sbzq;t.push(["_setAccount",11491]);var n=e.location.protocol=="https:"?"https:":"http:";var r=document.createElement("script");r.type="text/javascript";r.async=true;r.src=n+"//static.subiz.com/public/js/loader.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}(window);</script> -->
      <script type="text/javascript">
         $(document).ready(function(){
             $("#myModal_popup").modal('show');
         });
      </script>


