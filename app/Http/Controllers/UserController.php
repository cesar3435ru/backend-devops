<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getAgremiados()
    {
        $users = User::where('rol_id', 2)->get();
        return response()->json($users, 200);
    }
    public function getAdmins()
    {
        $users = User::where('rol_id', 1)->get();
        return response()->json($users, 200);
    }

    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }



    public function addAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nue' => 'required|regex:/^[A-Z0-9]{10}$/|unique:users,nue',
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password), 'rol_id' => 1]
        ));

        return response()->json([
            'message' => '¡Admin created successfully!',
            'user' => $user
        ], 201);
    }

    public function addAgre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nue' => 'required|regex:/^[A-Z0-9]{10}$/|unique:users,nue',
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password), 'rol_id' => 2]
        ));

        return response()->json([
            'message' => '¡Agremiado created successfully!',
            'user' => $user
        ], 201);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $user->delete();
        return response()->json(['message' => '¡Usuario eliminado con éxito!'], 200);
    }

    public function editUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nue' => 'required|regex:/^[A-Z0-9]{10}$/',
            'password' => [
                'nullable',
                'string',
                'min:10',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->nue = $request->get('nue');
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return response()->json([
            'message' => '¡Admin updated successfully!',
            'user' => $user
        ], 200);
    }
}
