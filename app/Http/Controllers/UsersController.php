<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    
    //中间件行为
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store','index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //所有用户
    public function index()
    {
        $users = User::paginate(5);

        return view('users.index', compact('users'));
    }

    //注册页面
    public function create()
    {
        return view('users.create');
    }
    //注册行为
    public function store(REquest $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show',[$user]);
    }
    //用户展示
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
    //修改资料页面
    public function edit(User $user)
    {
        //授权策略定义完成之后，我们便可以通过在用户控制器中使用 authorize 方法来验证用户授权策略
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }
    //修改资料行为
    public function update(User $user, Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6'
            ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return redirect()->back();
    }
}
