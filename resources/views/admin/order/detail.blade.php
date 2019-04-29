@extends('admin.layout.admin')

@section('title', 'Cài đặt thanh toán')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CHI TIẾT ĐƠN HÀNG
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cài đặt thanh toán</li>
        </ol>

    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông Tin Đơn Hàng</h3>
                    </div>
                    <!-- /.box-header -->

                <div class="box-body">
                    <form action="{{ route('orderUpdatePrice') }}" method="post">
                          {!! csrf_field() !!}
                        <table id="example1" class="table table-bordered table-striped">
                            <tr>
                                <td colspan="2">
                                    <h4>Thông tin đơn hàng</h4>
                                    <p>Mã đơn hàng: #{{ $order->order_id }}</p>
                                    <p>IP khách hàng: {{ $order->ip_customer }}</p>
                                    <p>Ngày
                                        đặt: <?php $dateOrder = new \DateTime($order->created_at); echo $dateOrder->format('d/m/Y H:i'); ?></p>
                                    {{--<p>Hình thức vận chuyển: </p>--}}
                                    <p>Hình thức thanh toán: {{ $order->method_payment }}</p>
                                </td>
                                <td colspan="2">
                                    <h4>Thông tin người nhận hàng</h4>
                                    <p>{{ $order->shipping_name }}</p>
                                    @if($order->status != 4)
                                        Địa chỉ: <input type="text" class="form-control" name="shipping_address" value="{{ $order->shipping_address }}">
                                    @else
                                    <p>Địa chỉ: {{ $order->shipping_address }}</p>
                                    @endif
                                    <p>Số điện thoại: {{ $order->shipping_phone }}</p>
                                    <p>Email: {{ $order->shipping_email }}</p>
                                </td>
                                <td>
                                    <h4>Ghi chú</h4>
                                    <p>{{ $order->shipping_note }}</p>
                                </td>
                            </tr>
                        </table>
                        <table id="" class="table table-bordered table-striped">
                            <tr>
                                <td>Ảnh Sản phẩm</td>
                                <td>Tên SP</td>
                                <td>Mã SP</td>
                                <td>Số lượng</td>
                                <td>Giá gốc</td>
                                <td>Đơn giá khi mua</td>
                            </tr>
                            <?php $sumPrice = 0;?>
                            @foreach($orderItems as $idx => $orderItem)
                                <tr>

                                    <td><img src="{{ asset($orderItem->image) }}" alt="{{ $orderItem->title }}" width="70"/></td>
                                    <td><p>{{ $orderItem->title }}</p></td>
                                    <td><p>{{ $orderItem->code }}</p></td>
                                    <td>
                                        @if($order->status != 4)
                                        <input type="hidden" value="{{ $orderItem->item_id }}" name="item_id[]"/>
                                        <input type="number" class="form-control" name="quantity[]" value="{{ $orderItem->quantity }}" step="any">
                                        @else
                                        <p>{{ $orderItem->quantity }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status != 4)
                                        <input type="number" class="form-control formatPrice" name="origin_price[]" value="{{ $orderItem->origin_price }}" step="any">
                                        @else
                                        <p>{{ $orderItem->origin_price }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->status != 4)
                                        <input type="number" class="form-control formatPrice" name="cost[]" value="{{ $orderItem->cost }}" step="any">
                                        @else
                                        <div class="price">
                                            {{ number_format($orderItem->cost, 0, ',', '.') }}
                                        </div>
                                        @endif
                                        
                                    </td>

                                </tr>
                                <?php $sumPrice += $orderItem->cost*$orderItem->quantity ?>
                            @endforeach
                            <tr>
                                <td colspan="5">Phí vận chuyển</td>
                                <td>
                                    @if($order->status != 4)
                                        <input type="number" class="form-control formatPrice" name="customer_ship" value="{{ $order->customer_ship }}" step="any">
                                    @else
                                    {{ !empty($order->customer_ship) ? $order->customer_ship : 'Miễn Phí'  }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">Thành tiền</td>
                                <td><p>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p></td>
                            </tr>
                            {{--<tr>--}}
                            {{--<td colspan="5">Mã giảm giá</td>--}}
                            {{--<td>-{{ number_format($order->cost_sale, 0, ',', '.') }} VNĐ</td>                                    --}}
                            {{--</tr>--}}

                            {{--<tr>--}}
                                {{--<td colspan="5">Tổng cộng</td>--}}
                                {{--<td><p>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p></td>--}}
                            {{--</tr>--}}
                        </table>
                        <input type="hidden" value="{{ $order->order_id }}" name="order_id"/>
                        @if($order->status != 4)
                         <button type="submit" class="btn btn-primary">Cập nhật</button>
                        @endif
                        
                       </form>     
                    </div>


<!-- end -->

                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ghi Chú Đơn Hàng</h3>
                    </div>
                    <div class="box-body">
                         <form action="{{ route('orderUpdateStatus') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>Trạng thái đơn hàng  : </label>
                                <select name="status" class="
                                <?php switch ($order->status) {
                                case 1:
                                    echo 'btn-info';
                                    break;
                                case 2:
                                    echo 'btn-warning';
                                    break;
                                case 3:
                                    echo 'btn-danger';
                                    break;
                                case 4:
                                    echo 'btn-success';
                                    break;
                                case 5:
                                    echo 'btn-danger';
                                    break;    
                            }?>" >
                                <option value="0"
                                        class="btn-danger clearfix" {{ ($order->status==0) ? 'selected' : ''}}>
                                    Hủy đơn hàng
                                </option>
                                <option value="1"
                                        class="btn-info clearfix" {{ ($order->status==1) ? 'selected' : ''}}>
                                    Đã đặt đơn hàng
                                </option>
                                <option value="2"
                                        class="btn-warning clearfix" {{ ($order->status==2) ? 'selected' : ''}}>
                                    Đã nhận đơn hàng
                                </option>
                                <option value="3"
                                        class="btn-danger clearfix" {{ ($order->status==3) ? 'selected' : ''}}>
                                    Đang vận chuyển
                                </option>
                                <option value="4"
                                        class="btn-success clearfix" {{ ($order->status==4) ? 'selected' : ''}}>
                                    Đã giao hàng
                                </option>
                                <option value="5"
                                        class="btn-success clearfix" {{ ($order->status==5) ? 'selected' : ''}}>
                                    Đơn chuyển hoàn
                                </option>
                            </select>
                            </div>

                            <div class="form-group">
                                <label>Nguồn đơn hàng  : </label>
                                <select name="order_source" class="
                                <?php switch ($order->order_source) {
                                case 0:
                                    echo 'btn-info';
                                    break;
                                case 1:
                                    echo 'btn-success';
                                    break;
                                case 2:
                                    echo 'btn-warning';
                                    break;   
                            }?>" >
                                <option value="0"
                                        class="btn-info clearfix" {{ ($order->order_source==0) ? 'selected' : ''}}>
                                    Đơn Thuốc uy tín
                                </option>
                                <option value="1"
                                        class="btn-success clearfix" {{ ($order->order_source==1) ? 'selected' : ''}}>
                                    Đơn Shopee
                                </option>
                                <option value="2"
                                        class="btn-warning clearfix" {{ ($order->order_source==2) ? 'selected' : ''}}>
                                    Đơn Blumed
                                </option>
                            </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="noteAdmin">Thông báo cho khách hàng</label>
                                <input type="checkbox" name="is_mail_customer" value="1"
                                       {{ !empty($order->is_mail_customer) ? 'checked' : '' }} class="flat-red">
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Ghi chú Admin</label>
                                <textarea class="form-control" rows="3" name="noteAdmin" id="noteAdmin">{{ $order->note_admin }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Tiền shipping hàng</label>
                                <input type="number" class="form-control formatPrice" name="cost_ship" value="{{ $order->cost_ship }}" placeholder="Tiền shipping hàng" step="any">
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Mã vận đơn</label>
                                <input type="text" class="form-control" name="shipping_code" value="{{ $order->shipping_code }}" placeholder="Mã vận đơn">
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Đã hoàn gốc</label>
                                <input type="checkbox" name="is_redeem_origin"
                                       {{ !empty($order->is_redeem_origin) ? 'checked' : '' }} class="flat-red">
                            </div>
                            <div class="form-group">
                                <label for="noteAdmin">Đã chia lợi nhuận</label>
                                <input type="checkbox" name="is_shared_profit"
                                       {{ !empty($order->is_shared_profit) ? 'checked' : '' }} class="flat-red">
                            </div>
                            <input type="hidden" value="{{ $order->order_id }}" name="order_id"/>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.partials.popup_delete')
@endsection

