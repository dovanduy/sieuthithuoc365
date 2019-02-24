<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (!User::isManager($this->role) && !User::isCreater($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();
            if (User::isCreater($user->role)) {
                $users = User::orderBy('id', 'desc')
                    ->get();
            } else {
                $users = User::orderBy('id', 'desc')->get();
            }

            return View('admin.user.list', compact('users'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị thành viên: dữ liệu không hợp lệ.');
            Log::error('http->admin->UserController->index: Lỗi xảy ra trong quá trình hiển thị thành viên');

            return redirect('admin/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required | unique:users',
            ]);

            // if validation fail return error
            if ($validation->fails()) {
                return redirect('admin/users/create')
                    ->withErrors($validation)
                    ->withInput();
            }

            // insert to database
            $user = new User();
            $userId = $user->insertGetId([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->input('phone'),
                'image' => $request->input('image'),
                'name' => $request->input('name'),
            ]);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới thành viên: dữ liệu không hợp lệ.');
            Log::error('http->admin->UserController->store: Lỗi xảy ra trong quá trình thêm mới thành viên');
        } finally {
            return redirect('admin/users');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return View('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try  {
            $validation = Validator::make($request->all(), [
                'email' =>  Rule::unique('users')->ignore($user->id, 'id'),
            ]);

            // if validation fail return error
            if ($validation->fails()) {
                return redirect(route('users.edit', ['id' => $user->id]))
                    ->withErrors($validation)
                    ->withInput();
            }

            $isChangePassword = $request->input('is_change_password');
            if ($isChangePassword == 1) {
                $user->update([
                    'password' =>  bcrypt($request->input('password'))
                ]);
            }
            // insert to database
            $user->update([
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'image' => $request->input('image'),
                'name' => $request->input('name'),
            ]);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa thành viên: dữ liệu không hợp lệ.');
            Log::error('http->admin->UserController->update: Lỗi xảy ra trong quá trình chỉnh sửa thành viên');
        } finally {
            return redirect('admin/users');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $userLogin = Auth::user();
            if ($userLogin->role == 4 ) {
                User::where('id', $user->id)->delete();

                return redirect('admin/users');
            }

            User::where('id', $user->id)->delete();

            return redirect('admin/users');
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa thành viên: dữ liệu không hợp lệ.');
            Log::error('http->admin->UserController->destroy: Lỗi xảy ra trong quá trình xóa thành viên');
        }

    }
}
