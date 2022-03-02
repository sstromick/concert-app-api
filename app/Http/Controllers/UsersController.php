<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserResetCredentials;

class UsersController extends Controller
{
  public function login(UserLoginRequest $request) {
    $credentials = $request->validated();

    if ( ! $token = auth()->attempt($credentials) ) {
        return response()->json(['error' => __('auth.login_failed'), 'code' => 401]);
    }

    return response()->json([
      'data' => [
        'message' => __('auth.login_success'),
        'token' => $token
      ]
    ], 200);
  }

  public function logout() {
    auth()->logout();
    return response()->json([
      'data' => [
        'message' => __('auth.logout_success')
      ]
    ], 200);
  }

  public function me() {
    $user = auth()->user();
    return response()->json([
      'data' => [
        'user' => $user->only('id', 'first_name', 'last_name', 'email', 'active')
      ]
    ]);
  }

    public function index() {
        $users = User::getFilteredUsers();
        return response()->json(['data' => $users], 200);
    }

    public function search() {
        $searchStr = "";

        if (request()->has('q'))
            $searchStr = '%' . request()->input('q') . '%';

        $users = User::where('first_name', 'like', $searchStr)
                ->orWhere('last_name', 'like', $searchStr)
                ->orWhere('email', 'like', $searchStr)
                ->paginate(20);

        return response()->json(['data' => $users], 200);
    }

    public function store(UserStoreRequest $request) {
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);
        $user = User::create($attributes);
        return response()->json(['data' => $user, 'message' => 'User created'], 201);
    }

    public function show(User $user) {
        $user->notes;
        return response()->json(['data' => $user], 200);
    }

    public function update(UserUpdateRequest $request, User $user) {
        $attributes = $request->validated();
        if (isset($attributes['password']))
            $attributes['password'] = bcrypt($attributes['password']);
        $user->update($attributes);
        $user->notes;
        return response()->json(['data' => $user, 'message' => 'User updated'], 200);
    }

    public function destroy(User $user) {
        $user->delete();
        return response()->json(['data' => $user, 'message' => 'User deleted'], 200);
    }

    public function export() {
        $users = User::getFilteredUsers(true);
        return $this->createExport($users, "users");
    }
}
