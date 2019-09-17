<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user){
        $data = $request->all();

        if($request->avatar){
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if($result){
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        return redirect()->route('users.show', compact('user'))->with('success', '个人资料更新成功！');
    }
}
