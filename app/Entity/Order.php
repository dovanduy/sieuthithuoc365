<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/3/2017
 * Time: 2:50 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Order extends Model
{

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'user_id',
        'code_sale_id',
        'total_price',
        'shipping_address',
        'shipping_city',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'status',
        'is_redeem_origin',
        'is_shared_profit',
        'method_payment',
        'cost_ship',
        'cost_point',
        'customer_ship',
        'shipping_code',
        'cost_sale',
        'ip_customer',
        'note_admin',
        'order_source',
        'is_mail_customer',
        'visiable',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public static function countOrder() {
        try {
            $orderItems = session('orderItems');

            return count($orderItems);
        } catch (\Exception $e) {
            Log::error('Entity->Order->countOrder: Lỗi lấy tổng số order');

            return 0;
        }
    }

    public static function  getOrderItems() {
        try {
            $orderItems = session('orderItems');
            if(!isset($orderItems)){
                return $orderItems = null;
            }
            $productIds = array();
            $QuantityWithProduct = array();
            $propertiesWithProduct = array();
            foreach ($orderItems as $orderItem) {
                $productIds[] = $orderItem['product_id'];
                $QuantityWithProduct[$orderItem['product_id']] = $orderItem['quantity'];
                $propertiesWithProduct[$orderItem['product_id']] = $orderItem['properties'];
            }
            $orderItemDetail = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'posts.*',
                    'products.price',
                    'products.discount',
                    'products.price_deal',
                    'products.origin_price',
                    'products.deal_end',
                    'products.discount_start',
                    'products.discount_end',
                    'products.code'
                )
                ->whereIn('products.product_id', $productIds)
                ->get();
            foreach ($orderItemDetail as $id => $orderItem ) {
                $orderItemDetail[$id]->quantity = $QuantityWithProduct[$orderItem->product_id];
                $orderItemDetail[$id]->properties = $propertiesWithProduct[$orderItem->product_id];
            }

            return $orderItemDetail;
        } catch (\Exception $e) {
            Log::error('Entity->Order->getOrderItems: Lỗi lấy ra tất cả thành phần của đơn hàng');

            return array();
        }
    }

    public static function getUserOrderProduct($productId ) {
        try {
            $orderModel = new Order();

            $userIds = $orderModel->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                ->join('products', 'products.product_id', '=', 'order_items.product_id')
                ->select('user_id', 'orders.created_at')
                ->where('user_id', '>', 0)
                ->where('products.post_id', $productId)
                ->get()->toArray();

            return $userIds;
        } catch(\Exception $e) {
            Log::error('Entity->Order->getUserOrderProduct: Lỗi lấy user id của đơn hàng');

            return null;
        }
    }

    public static function getTotalOrder ($userId) {
        $totalOrder = static::where('user_id', $userId)->count();

        return $totalOrder;
    }

}
