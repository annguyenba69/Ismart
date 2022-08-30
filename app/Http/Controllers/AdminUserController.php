<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    function __construct()
    {
        $this->middleware('CheckRole:Admin,admin/user/list')->except('list');
    }
    
    function list(Request $request)
    {
        $keyword = "";
        $list_action = ["delete"=>"Xóa Tạm Thời"];
        if ($request->input("keyword")) {
            $keyword = $request->input("keyword");
        }
        $users = User::where("name", "LIKE", "%$keyword%")->paginate(6);
        if($request->input("status")=="trash"){
            $users = User::onlyTrashed()->where("name", "LIKE", "%$keyword%")->paginate(6);
            $list_action = ["restore"=>"Khôi Phục", "forcedelete"=>"Xóa Vĩnh Viễn"];
        }
        $count_active_user = User::all()->count();
        $count_trash_user = User::onlyTrashed()->count();
        $count = [$count_active_user, $count_trash_user];
        return view('admin.user.list', compact('users','count', 'list_action'));
    }

    function add()
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
                'role_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute phải là định dạng Email(@)',
                'unique' => ':attribute không được trùng',
                'confirmed' => ':attribute xác nhận không đúng',
                'regex' => ':attribute phải chứa chữ in hoa, in thường, số và kí tự đặc biệt',
            ],
            [
                'fullname' => 'Họ và tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
                'role_id' => 'Quyền'
            ],
        );
        User::create([
            'name' => $request->input('fullname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id')
        ]);
        return redirect('admin/user/add')->with('status', 'Bạn đã thêm người dùng thành công');
    }

    function edit($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $roles = Role::all();
            return view('admin.user.edit', compact('user', 'roles'));
        } else {
            return redirect('admin/user/list')->with('status', 'Người dùng không tồn tại')
                ->with('class', 'alert-danger');
        }
    }

    function update($id, Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'password' => 'nullable|min:8|confirmed',
                'role_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => ':attribute không được trùng',
                'confirmed' => ':attribute xác nhận không đúng',
            ],
            [
                'fullname' => 'Họ và tên',
                'password' => 'Mật khẩu',
                'password_confirmation' => 'Xác nhận mật khẩu',
                'role_id' => 'Quyền'
            ],
        );
        $user = User::find($id);
        if($user != null){
            $password = $user->password;
            if($request->input('password')){
                $password = Hash::make($request->input('password'));
            }
            $user->update([
                'name'=>$request->input('fullname'),
                'password'=> $password,
                'role_id'=>$request->input('role_id')
            ]);
            return redirect(url()->previous())->with('status', 'Cập nhật thông tin thành công')
            ->with('class', 'alert-success');
        }
    }

    function delete($id){
        if($id != Auth::id()){
            $user = User::find($id);
            if($user != null){
                $user->delete();
                return redirect('admin/user/list')->with('status', 'Xóa tạm thời thành công người dùng')
                ->with('class', 'alert-success');
            }else{
                return redirect('admin/user/list')->with('status', 'Không tìm thấy người dùng')
                ->with('class', 'alert-danger');
            }
        }else{
            return redirect('admin/user/list')->with('status', 'Bạn không thể xóa chính tài khoản của mình')
            ->with('class','alert-danger');
        }
    }

    function restore($id){
        $user = User::onlyTrashed()->find($id);
        if($user != null){
            $user->restore();
            return redirect('admin/user/list?status=trash')->with('status', 'Khôi phục thành công người dùng')
            ->with('class','alert-success');
        }else{
            return redirect('admin/user/list')->with('status', 'Không tìm thấy người dùng cần khôi phục')
            ->with('class','alert-danger');
        }
    }

    function force_delete($id){
        $user = User::onlyTrashed()->find($id);
        if($user != null){
            $user->forceDelete();
            return redirect('admin/user/list?status=trash')->with('status', 'Xóa vĩnh viễn thành công người dùng')
            ->with('class','alert-success');
        }else{
            return redirect('admin/user/list')->with('status', 'Không tìm thấy người dùng cần xóa vĩnh viễn')
            ->with('class','alert-danger');
        }
    }

    function action(Request $request){
        if($request->input('list_user')){
            $list_user = $request->input('list_user');
            foreach($list_user as $key=>$id){
                if($id == Auth::id()){
                    unset($list_user[$key]);
                }
            }
            if(!empty($list_user)){
                if($request->input('action') == 'delete'){
                    User::destroy($list_user);
                    return redirect('admin/user/list')->with('status', 'Xóa tạm thời thành công người dùng')
                    ->with('class', 'alert-success');
                }else if($request->input('action') == 'restore'){
                    User::onlyTrashed()->whereIn('id', $list_user)->restore();
                    return redirect('admin/user/list')->with('status', 'Khôi phục thành công người dùng')
                    ->with('class', 'alert-success');
                }else if($request->input('action') == 'forcedelete'){
                    User::onlyTrashed()->whereIn('id', $list_user)->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Xóa vĩnh viễn thành công người dùng')
                    ->with('class', 'alert-success');
                }else{
                    return redirect('admin/user/list')->with('status', 'Bạn phải chọn hành động để thao tác')
                    ->with('class', 'alert-danger');
                }
            }else{
                return redirect('admin/user/list')->with('status', 'Bạn không thể thao tác trên tài khoản của mình')
                ->with('class', 'alert-danger');
            }
        }else{
            return redirect('admin/user/list')->with('status', 'Bạn phải chọn người dùng để thao tác')
            ->with('class', 'alert-danger');
        }
    }
}
