<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/16/2017
 * Time: 9:24 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\Notification;
use App\Entity\Order;
use App\Entity\Post;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $isSale;

    public function __construct($countNotifi = 12){
        try {
            $countNotification = new Notification();
            $countReport = $countNotification->countReport();
            $typeSubPostsAdmin = TypeSubPost::orderBy('type_sub_post_id')
                ->get();
            $notifications = Notification::orderBy('notify_id', 'desc')
                ->offset(0)->limit($countNotifi)->get();

        } catch (\Exception $e) {
            $countReport = 0;
            $notifications = array();
            $typeSubPostsAdmin = array();

            Log::error('Lấy dạng bài viết và thông báo: '.$e->getMessage());

        } finally {

            view()->share([
                'countRp'=>$countReport,
                'notifications'=>$notifications,
                'typeSubPostsAdmin' => $typeSubPostsAdmin,
            ]);
        }

        
    }


    protected function createSlug($request) {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
        } catch (\Exception $e) {
            $slug = rand(10,10000000);

        } finally {
            return $slug;
        }
    }

    public function home() {
        if (User::isMember(Auth::user()->role)) {
            Auth::logout();
        }

		session_start();
        $user = Auth::user();
        if (User::isManager($user->role) || User::isEditor($user->role)) {
            $_SESSION['loginSuccessAdmin'] = $user->email;
            $_SESSION['emailFolder'] = 'library';
        }


        $countPost = Post::where('post_type', 'post')->count();
        $countProduct = Post::where('post_type', 'product')->count();
        $countUser = User::count();
        $countOrder = Order::count();
        $orders = Order::
            select(
                DB::raw('SUM(total_price) as total_sum'),
                DB::raw('YEAR (created_at) as year'),
                DB::raw('QUARTER(created_at) as quarter')
            )
            ->groupBy (
                DB::raw('YEAR (created_at)'),
                DB::raw('QUARTER(created_at)')
                )
            ->get();

        return View('admin.home.index', compact(
            'countPost',
            'countProduct',
            'countUser',
            'orders',
            'countOrder'
        ));
    }

    public function dateline() {
        return View('admin.home.dateline');
    }
}
