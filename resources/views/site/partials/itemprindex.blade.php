<div class="noPadding itemProduct itemProductheight">
   <div class="itemPro" style="">
      <div class="img">
         <div class="CropImg">
            <div class="thumbs">
               <a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ $product->title }}">
               <img src="{{ isset($product->image) ?asset($product->image) :'' }}" alt="{{ $product->title }}">
               </a>
            </div>
         </div>
      </div>
      <div class="contentPro">
         <a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ $product->title }}">{{ $product->title }}</a>
         <p class="model">Model : {{ $product->code }}</p>
        <div class="price">
            @if (time() <= strtotime($product->deal_end))
                <span class="discuont">
			<del>{{ number_format($product->price) .''}} ₫</del>
			</span>
                <br>
                <span class="price">
			<del>{{ number_format($product->price_deal) .''}} ₫</del>
			</span>
			@elseif($product->discount > 0)
			<span class="discuont">
			<del>{{ number_format($product->price) .''}} ₫</del>
			</span>
			<br>
			<span class="price">
			<del>{{ number_format($product->discount) .''}} ₫</del>
			</span>
			@else
				<br>
			<span class="price">
			{{ number_format($product->price) .''}}₫
			</span>
			@endif
		</div>
      </div>
   </div>
</div>
 <script>
            //Đồng bộ chiều cao các div
            $(function() {
              $('.itemPro').matchHeight();
            });
            </script>







{{--<div class="col-lg-3 col-md-3 col-sm-6 col-6 noPadding itemProduct">--}}
{{--<div class="itemPro">--}}
{{--<div class="img">--}}
{{--<div class="CropImg">--}}
{{--<div class="thumbs">--}}
{{--<a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ $product->title }}">--}}
{{--<img src="{{ isset($product->image) ?asset($product->image) :'' }}" alt="{{ $product->title }}">--}}
{{--</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="contentPro">--}}
{{--<a href="{{ route('product',['cate_slug' => $product->slug]) }}" title="{{ $product->title }}">{{ $product->title }}</a>--}}
{{--<div class="price">--}}
{{--@if($product->discount > 0)--}}
{{--<span class="discuont">--}}
{{--<del>{{ number_format($product->price) .''}} ₫</del>--}}
{{--</span>--}}
{{--<span class="price">--}}
{{--{{ number_format($product->discount) .''}} ₫--}}
{{--</span>--}}
{{--@else--}}
{{--<span class="price">--}}
{{--{{ number_format($product->price) .''}}₫--}}
{{--</span>--}}
{{--@endif--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}