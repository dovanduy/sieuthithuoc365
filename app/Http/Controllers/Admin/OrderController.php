<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 3:05 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Input;
use App\Entity\MailConfig;
use App\Entity\Order;
use App\Entity\OrderBank;
use App\Entity\OrderCodeSale;
use App\Entity\OrderItem;
use App\Entity\OrderShip;
use App\Entity\Post;
use App\Entity\SettingGetfly;
use App\Entity\SettingOrder;
use App\Entity\User;
use App\Mail\Mail;
use App\Ultility\Error;
use App\Ultility\InforFacebook;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });

    }

    public function setting(Request $request) {
        try {
            if ($request->has('accesstoken')) {
                User::where('id', Auth::user()->id)->update([
                    'accesstoken' => $request->input('accesstoken')
                ]);
            }
            $orderShips = OrderShip::get();
            $orderBanks = OrderBank::get();
            $orderCodeSales = OrderCodeSale::get();
            $settingOrder = SettingOrder::first();
            $userId = Auth::user()->id;
            $settingEmail = MailConfig::where('user_id', $userId)->first();
            if (empty($settingEmail)) {
                $mailConfigModel =  new MailConfig();
                $mailConfigModel->insert([
                    'user_id' => $userId,
                    'created_at' => new \Datetime(),
                    'updated_at' => new \DateTime()
                ]);
                $settingEmail = MailConfig::where('user_id', $userId)->first();
            }

            $loginUrl = $this->getLoginFacebook();

            return view('admin.order.setting', compact('orderShips', 'orderBanks', 'orderCodeSales', 'settingOrder', 'settingEmail', 'loginUrl'));
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị cài đặt thanh toán: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->setting: Lỗi xảy ra trong quá trình hiển thị cài đặt thanh toán');

            return redirect('admin/home');
        }
    }

    private function getLoginFacebook() {
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $urlLogin = 'http://facebook.vn3c.net/flogin?service_code=1c9b7597b1e8b09e61b419235f1d207a&currentUrl='.$actual_link;

        return $urlLogin;
    }

    public function updateSetting(Request $request) {
        try {
            $settingOrder = new SettingOrder();

            $settingOrder->delete();
            $settingOrder->insert([
                'point_to_currency' => $request->input('point_to_currency'),
                'currency_give_point' => $request->input('currency_give_point'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật cài đặt thanh toán: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->setting: Lỗi xảy ra trong quá trình cập nhật cài đặt thanh toán');
        } finally {
            return redirect(route('method_payment'));
        }
    }
    public function updateBank(Request $request) {
        try {
            $orderBank = new OrderBank();
            $orderBank->insert([
                'name_bank' => $request->input('name_bank'),
                'number_bank' => $request->input('number_bank'),
                'manager_account' => $request->input('manager_account'),
                'branch' => $request->input('branch'),
            ]);


        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật ngân hàng cài đặt thanh toán: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateBank: Lỗi xảy ra trong quá trình cập nhật ngân hàng cài đặt thanh toán');
        } finally {
            return redirect(route('method_payment'));
        }
    }
    public function deleteBank(OrderBank $orderBanks){
        try {
            OrderBank::where('order_bank_id' , $orderBanks->order_bank_id)
              ->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa ngân hàng cài đặt thanh toán: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->deleteBank: Lỗi xảy ra trong quá trình xóa ngân hàng cài đặt thanh toán');
        } finally {
            return redirect(route('method_payment'));
        }
    }
    public function updateCodeSale(Request $request) {
        try {
            $orderCodeSale = new OrderCodeSale();

            $discountStartEnd = $request->input('code_sale_start_end');
            $discountTime = explode('-', $discountStartEnd);
            $discountStart = new \DateTime($discountTime[0]);
            $discountEnd = new \DateTime($discountTime[1]);

            $orderCodeSale->insert([
                'code' => $request->input('code'),
                'method_sale' => $request->input('method_sale'),
                'sale' => $request->input('sale'),
                'start' =>  $discountStart,
                'end' => $discountEnd ,
                'many_use' => $request->input('many_use'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật mã giảm giá: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateCodeSale: Lỗi xảy ra trong quá trình cập nhật mã giảm giá ');
        } finally {
            return redirect(route('method_payment'));
        }
    }
    public function deleteCodeSale(OrderCodeSale $orderCodeSales){
        try {
            OrderCodeSale::where('order_code_sale_id' , $orderCodeSales->order_code_sale_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa mã giảm giá: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->deleteCodeSale: Lỗi xảy ra trong quá trình xóa mã giảm giá ');
        } finally {
            return redirect(route('method_payment'));
        }
    }
    public function updateShip(Request $request) {
        try {
            $orderShip =  new OrderShip();
            $orderShip->insert([
                'method_ship' => $request->input('method_ship'),
                'cost' => $request->input('cost'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật vận chuyển: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateShip: Lỗi xảy ra trong quá trình cập nhật vận chuyển');
        } finally {
            return redirect(route('method_payment'));
        }
    }

    public function updateSettingGetFly(Request $request) {
        try {
            $user = Auth::user();
            $settingGetfly = SettingGetfly::where('user_id', $user->id)->first();
            // Nếu không tồn tại thì thêm mới
            if (empty($settingGetfly)) {
                SettingGetfly::insert([
                    'user_id' => $user->id,
                    'api_key' => $request->input('api_key'),
                    'base_url' => $request->input('base_url'),
                    'created_at' => new \Datetime(),
                    'updated_at' => new \DateTime()
                ]);

                return redirect(route('method_payment'));
            }

            $settingGetfly->update([
                'api_key' => $request->input('api_key'),
                'base_url' => $request->input('base_url'),
                'created_at' => new \Datetime(),
                'updated_at' => new \DateTime()
            ]);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật dữ liệu getfly: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateSettingGetFly: Lỗi xảy ra trong quá trình cập nhật cài đặt getfly');
        } finally {
            return redirect(route('method_payment'));
        }
    }

    public function updateSettingEmail(Request $request) {
        try {
            $user = Auth::user();
            $mailConfigModel = new MailConfig();
            $mailConfig = $mailConfigModel->where('user_id', $user->id)->first();
            // Nếu không tồn tại thì thêm mới
            if (empty($mailConfig)) {
                $mailConfigModel->insert([
                    'user_id' => $user->id,
                    'email_send' => $request->input('email_send'),
                    'name_send' => $request->input('name_send'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'address_server' => $request->input('address_server'),
                    'port' => $request->input('port'),
                    'sign' => $request->input('sign'),
                    'supplier' => $request->input('supplier'),
                    'method' => $request->input('method'),
                    'api_key' => $request->input('api_key'),
                    'driver' => $request->input('driver'),
                    'host' => $request->input('host'),
                    'email_receive' => $request->input('email_receive'),
                    'encryption' => $request->input('encryption'),
                    'created_at' => new \Datetime(),
                    'updated_at' => new \DateTime()
                ]);

                return redirect(route('method_payment').'#email');
            }

            $mailConfig->update([
                'user_id' => $user->id,
                'email_send' => $request->input('email_send'),
                'name_send' => $request->input('name_send'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'address_server' => $request->input('address_server'),
                'port' => $request->input('port'),
                'sign' => $request->input('sign'),
                'supplier' => $request->input('supplier'),
                'method' => $request->input('method'),
                'api_key' => $request->input('api_key'),
                'driver' => $request->input('driver'),
                'host' => $request->input('host'),
                'email_receive' => $request->input('email_receive'),
                'encryption' => $request->input('encryption'),
                'created_at' => new \Datetime(),
                'updated_at' => new \DateTime()
            ]);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật cấu hình email: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateSettingEmail: Lỗi xảy ra trong quá trình cập nhật cấu hình email');
        } finally {
            return redirect(route('method_payment'));
        }
    }

    public function deleteShip(OrderShip $orderShips)
    {
        try {
            OrderShip::where('order_ship_id', $orderShips->order_ship_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa ship hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->deleteShip: Lỗi xảy ra trong quá trình xóa ship hàng ');
        } finally {
            return redirect(route('method_payment'));
        }
    }
    public function listOrder(Request $request) {
        try {
            $orders = Order::orderBy('created_at', 'desc')
                ->where('status', '>=', 0);

            if (!empty($request->input('order_id'))) {
                $orders = $orders->where('order_id', 'like', '%'.$request->input('order_id').'%');
            }
            if (!empty($request->input('phone'))) {
                $orders = $orders->where('shipping_phone', 'like', '%'.$request->input('phone').'%');
            }
            if (!empty($request->input('email'))) {
                $orders = $orders->where('shipping_email', 'like', '%'.$request->input('email').'%');
            }
            if (!empty($request->input('name'))) {
                $orders = $orders->where('shipping_name', 'like', '%'.$request->input('name').'%');
            }
            if (!empty($request->input('user_id'))) {
                $orders = $orders->where('user_id', '=', $request->input('user_id'));
            }
            if (!empty($request->input('status')) && $request->input('status') >= 0) {
                $status = $request->input('status') - 1;
                $orders = $orders->where('status', '=', $status);
                   
            }
            if (!empty($request->input('order_source')) && $request->input('order_source') >= 0) {
                $orderSource = $request->input('order_source') - 1;
                $orders = $orders->where('order_source', '=', $orderSource);
            }
            if (!empty($request->input('is_shared_profit'))) {
                $orders = $orders->where('is_shared_profit', '=', 1);
            }
            if (!empty($request->input('is_redeem_origin'))) {
                $orders = $orders->where('is_redeem_origin', '=', 1);
            }
            if (!empty($request->input('is_not_shared_profit'))) {
                $orders = $orders->where('is_shared_profit', '=', 0);
            }
            if (!empty($request->input('is_not_redeem_origin'))) {
                $orders = $orders->where('is_redeem_origin', '=', 0);
            }
            if (!empty($request->input('user_id'))) {
                $orders = $orders->where('user_id', '=', $request->input('user_id'));
            }
            if ($request->input('is_search_time') == 1) {
                $startEnd = $request->input('search_start_end');
                $time = explode('-', $startEnd);
                $start = $time[0];
                $end = $time[1];

                $orders = $orders->where('updated_at', '>=', new \DateTime($start))
                    ->where('updated_at', '<=', new \DateTime($end));
            }

            $orderShips = OrderShip::get();

            $orders = $orders->paginate(50);
            $orders->appends(['status' => $request->input('status')]);
            $orders->appends(['order_source' => $request->input('order_source')]);
            $orders->appends(['is_redeem_origin' => $request->input('is_redeem_origin')]);
            $orders->appends(['is_not_redeem_origin' => $request->input('is_not_redeem_origin')]);
            $orders->appends(['is_shared_profit' => $request->input('is_shared_profit')]);
            $orders->appends(['is_not_shared_profit' => $request->input('is_not_shared_profit')]);
            $orders->appends(['is_search_time' => $request->input('is_search_time')]);
            $orders->appends(['search_start_end' => $request->input('search_start_end')]);
            $orders->appends(['phone' => $request->input('phone')]);
            $orders->appends(['email' => $request->input('email')]);
            $orders->appends(['user_id' => $request->input('user_id')]);

            foreach($orders as $id => $order) {
                $orders[$id]->orderItems = OrderItem::join('products','products.product_id','=', 'order_items.product_id')
                    ->join('posts', 'products.post_id','=','posts.post_id')
                    ->select(
                        'posts.*',
                        'products.price',
                        'products.discount',
                        'products.origin_price',
                        'products.code',
                        'order_items.*'
                    )
                    ->where('order_id', $order->order_id)->get();
            }
            return view('admin.order.list', compact('orders', 'orderShips'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị danh sách đơn hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->listOrder: Lỗi xảy ra trong quá trình hhiển thị danh sách đơn hàng');

            return redirect('admin/home');
        }
    }


    public function updatePriceOrder(Request $request) {
        try {
            $orderId = $request->input('order_id');
            $order = Order::where('order_id', $orderId)->first();
            $customer_ship = $request->input('customer_ship');
            $orderItems = OrderItem::where('order_id', $orderId)->get();
            $leng = count($orderItems);
            for($i = 0; $i < $leng; $i++){
                $originPrice = $request->input('origin_price')[$i];  
                $cost = $request->input('cost')[$i];  
                $quantity = $request->input('quantity')[$i];  
                $itemId = $request->input('item_id')[$i]; 
                $orderItem = OrderItem::where('item_id', $itemId)->first();

                $orderItem->update([
                    'origin_price' => $originPrice,
                    'cost' => $cost,
                    'quantity' => $quantity,
                ]);
            }

            $orderItems = OrderItem::where('order_id', $orderId)->get();
            $totalPrice = 0;
            foreach ($orderItems as $orderItem) {
                $totalPrice += $orderItem->cost*$orderItem->quantity;
            }

            $totalPrice = $totalPrice + $customer_ship;
            $order->update([
                'customer_ship' => $request->input('customer_ship'),
                'total_price' => $totalPrice,
                'shipping_address' => $request->input('shipping_address')
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật thành tiền đơn hàng : dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updatePriceOrder: Lỗi xảy ra trong quá trình cập nhật thành tiền đơn hàng');
        } finally {
            return redirect(route('orderAdmin'));
        }

    }

    public function updateStatusOrder(Request $request) {
        try {
            $orderId = $request->input('order_id');
            $status = $request->input('status');
            $noteAdmin = $request->input('noteAdmin');
            $orderSource = $request->input('order_source');
            $shippingCode = $request->input('shipping_code');
            $order = Order::where('order_id', $orderId)->first();

            $order->update([
                'status' => $status,
                'note_admin' => $noteAdmin,
                'order_source' => $orderSource,
                'cost_ship' => $request->input('cost_ship'),
                'shipping_code' => $shippingCode,
                'is_mail_customer' => $request->has('is_mail_customer') ? 1 : 0,
                'is_redeem_origin' => $request->has('is_redeem_origin') ? 1 : 0,
                'is_shared_profit' => $request->has('is_shared_profit') ? 1 : 0,
            ]);


            if ($request->has('is_mail_customer')) {
                $now = date_create("2013-03-15");
                $now =  date_format($now,"d/m/Y H:i:s");
                $orderItems = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                    ->join('order_items', 'order_items.product_id', '=', 'products.product_id')
                    ->select(
                        'products.product_id',
                        'posts.*',
                        'products.price',
                        'products.discount'
                    )
                    ->where('order_items.order_id', $orderId)
                    ->get();
					
			//	$this->sendMailCustomer($status, $noteAdmin, $order);
            }

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật trạng thái đơn hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->updateStatusOrder: Lỗi xảy ra trong quá trình cập nhật trạng thái đơn hàng');
        } finally {
            return redirect(route('orderAdmin'));
        }

    }

	private function sendMailCustomer($status, $noteAdmin, $order) {
		try {
			$statusString = '';
			switch ($status) {
				case 1:
					$statusString = 'Đơn hàng đã được đặt thành công';
					break;
				case 2:
					$statusString = 'Đơn hàng đã được tiếp nhận';
					break;
				case 3:
					$statusString = 'Đơn hàng đang được vận chuyển';
					break;
				case 4:
					$statusString = 'Đơn hàng đã giao hàng thành công';
					break;
			}
		    $subject =  'Trạng thái đơn hàng của bạn vừa được cập nhật';
		    $content =  'Trạng thái đơn hàng của bạn đã được cập nhật thành '.$statusString;
			if (!empty($noteAdmin)) {
				$content .= '. Ghi chú của chúng tôi: '.$noteAdmin;
			}

		//   MailConfig::sendMail($order->shipping_email, $subject, $content);
		} catch (\Exception $e) {

	    }
	}
    public function deleteOrder(Order $order) {
        try {
            // delete order item
            OrderItem::where('order_id', $order->order_id)->delete();

            $order->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa đơn hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->deleteOrder: Lỗi xảy ra trong quá trình xóa đơn hàng');
        } finally {
            return redirect(route('orderAdmin'));
        }
    }

    public function showOrder(Order $order) {
        try {
            $orderShips = OrderShip::get();
            // delete order item
            $orderItems = OrderItem::join('products','products.product_id','=', 'order_items.product_id')
                ->join('posts', 'products.post_id','=','posts.post_id')
                ->select(
                    'posts.*',
                    'products.price',
                    'products.discount',
                    'products.code',
                    'order_items.*'
                )
                ->where('order_id', $order->order_id)->get();

            return view('admin.order.detail', compact('order', 'orderItems', 'orderShips'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa đơn hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->deleteOrder: Lỗi xảy ra trong quá trình xóa đơn hàng');
        }

    }

    public function exportToExcel() {
        try {
            $orders = Order::orderBy('created_at', 'desc')
                ->where('status', '>', 0)->get();
            $data = array();
            $data[] = array(
                'họ tên',
                'email',
                'số điện thoại',
                'địa chỉ',
                'sản phẩm',
                'ghi chú',
                'tổng tiền'
            );
            foreach ($orders as $order) {
                $orderItems = OrderItem::join('products','products.product_id','=', 'order_items.product_id')
                    ->join('posts', 'products.post_id','=','posts.post_id')
                    ->select(
                        'posts.*',
                        'products.price',
                        'products.discount',
                        'products.code',
                        'order_items.*'
                    )
                    ->where('order_id', $order->order_id)->get();
                $products = '';
                foreach ($orderItems as $orderItem) {
                    $products .= $orderItem->quantity.' sản phẩm '.$orderItem->title.'('.route('product', ['post_slug' => $orderItem->slug]).'), ';
                }

                $data[] = array(
                    $order->shipping_name,
                    $order->shipping_email,
                    $order->shipping_phone,
                    $order->shipping_address,
                    $products,
                    $order->shipping_note,
                    $order->total_price
                );
            };

            $date = new \DateTime();
            $fileName = "don-hang-".$date->format("d/m/y");
            Excel::create($fileName, function($excel) use($data) {

                $excel->sheet('Sheetname', function($sheet) use($data) {

                    $sheet->fromArray($data);
                    $sheet->getStyle('E')->getAlignment()->setWrapText(true);

                });

            })->download('xls');
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xuất đơn hàng: dữ liệu không hợp lệ.');
            Log::error('http->admin->OrderController->exportToExcel: Lỗi xảy ra trong quá trình xuất đơn hàng');

            return null;
        }

    }
}
