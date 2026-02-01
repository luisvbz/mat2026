<?php

namespace App\Http\Controllers\Api;

use App\Models\ParentUser;
use App\Models\TeacherUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'document_number' => 'required|numeric',
            'password' => 'required',
            'role' => 'required|in:parent,teacher',
        ]);
        $user = null;
        $userData = null;
        if ($request->role === 'parent') {
            $user = ParentUser::where('document_number', $request->document_number)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'error' =>  ['message' => "Las credenciales son incorrectas."]
                ], 422);
            }
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'error' =>  ['message' => "Tu cuenta está desactivada."]
                ], 422);
            }

            $user->update(['last_login_at' => now()]);

            $padre = $user->padre;
            $userData = [
                'id' => $padre->id,
                'name' => $padre->nombres . ' ' . $padre->apellidos,
                'email' => $user->email,
                'role' => 'parent',
                'photo' => $padre->foto,
            ];
        } else {
            $user = TeacherUser::where('document_number', $request->document_number)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => ['message' => "El usuario no existe."]
                ], 422);
            }

            if (!$user || !Hash::check($request->password, $user->password)) {

                return response()->json([
                    'success' => false,
                    'error' =>  ['message' => "Las credenciales son incorrectas."]
                ], 422);
            }
            if (!$user->is_active) {
                return response()->json([
                    'success' => false,
                    'error' =>  ['message' => "Tu cuenta está desactivada."]
                ], 422);
            }
            $user->update(['last_login_at' => now()]);
            $teacher = $user->teacher;
            $userData = [
                'id' => $teacher->id,
                //'name' => $teacher->nombres . ' ' . $teacher->apellidos,
                'name' => $teacher->nombres,
                'email' => $user->email,
                'role' => 'teacher',
                'photo' => $teacher->foto,
            ];
        }
        // Crear token
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $userData,
                'token' => $token,
            ],
        ]);
    }
    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente',
        ]);
    }


    public function me(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Usuario no autenticado',
            ], 401);
        }

        if ($user instanceof ParentUser) {
            $padre = $user->padre;
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $padre->id,
                    'name' => $padre->nombres . ' ' . $padre->apellidos,
                    'email' => $user->email,
                    'role' => 'parent',
                    'photo' => $padre->foto,
                ],
            ]);
        } else {
            $teacher = $user->teacher;
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $teacher->id,
                    'name' => $teacher->nombres . ' ' . $teacher->apellidos,
                    'email' => $user->email,
                    'role' => 'teacher',
                    'photo' => $teacher->foto,
                ],
            ]);
        }
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'error' => ['message' => 'La contraseña actual es incorrecta.']
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada exitosamente.'
        ]);
    }
}
