<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //get profile
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'message' => 'successfully fetched profile',
            'data' => $user
        ]);
    }

    //update profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'sap_number' => 'required|string|max:255',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->role = $request->role;
        $user->sap_number = $request->sap_number;
        $user->save();
        return response()->json([
            'message' => 'successfully updated profile',
            'data' => $user
        ]);
    }

    //change photo profile
    public function changePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image',
        ]);

        $user = $request->user();
        $path = public_path('images/users');

        //delete old photo if exists
        if ($user->photo) {
            File::delete($path . '/' . $user->photo);
        }

        $photoName = time() . '.' . $request->photo->getClientOriginalExtension();
        $request->photo->move($path, $photoName);

        $user->update(['photo' => $photoName]);

        return response()->json([
            'message' => 'successfully updated photo',
            'data' => $user
        ]);
    }

    //change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'message' => 'successfully changed password',
            'data' => $user
        ]);
    }

    //add user
    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'sap_number' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->sap_number = $request->sap_number;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'message' => 'successfully added user',
            'data' => $user
        ]);
    }

    //get all users
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
            'message' => 'successfully fetched users',
            'data' => $users
        ]);
    }

    //update user by id
    public function updateUserById(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'sap_number' => 'required|string|max:255',
            'password' => 'string|min:8',
        ]);
        $user = User::find($id);
        if ($user == null) {
            return response()->json([
                'message' => 'user not found'
            ], 404);
        }
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->sap_number = $request->sap_number;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json([
            'message' => 'successfully updated user',
            'data' => $user
        ]);
    }

    //change photo profile by id
    public function changePhotoById(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);
        $path = public_path('images/users');

        //delete old photo if exists
        if ($user->photo) {
            File::delete($path . '/' . $user->photo);
        }

        $photoName = time() . '.' . $request->photo->getClientOriginalExtension();
        $request->photo->move($path, $photoName);

        $user->update(['photo' => $photoName]);

        return response()->json([
            'message' => 'successfully updated photo',
            'data' => $user
        ]);
    }

    //delete user by id
    public function deleteUserById(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'successfully deleted user',
            'data' => $user
        ]);
    }


    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'successfully logged in',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'successfully logged out'
        ]);
    }
}
