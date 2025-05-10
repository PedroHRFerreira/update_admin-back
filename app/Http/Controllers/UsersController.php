<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
            'message' => 'Usuarios carregados com sucesso',
            'status' => 'success',
            'code' => 200
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => 'nullable|string',
        ]);

        $users = User::create($validated);

        if (!$users) {
            return response()->json([
                'user' => [],
                'message' => 'Erro ao criar usuario',
                'status' => 'error',
                'code' => 422
            ], 422);
        }

        return response()->json([
            'user' => $users,
            'message' => 'Usuario criado com sucesso',
            'status' => 'success',
            'code' => 200
        ]);
    }

    public function update(Request $request, $id)
    {
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'user' => [],
            'message' => 'Usuário não encontrado',
            'status' => 'error',
            'code' => 404
        ], 404);
    }

    $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|string|lowercase|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);

    return response()->json([
        'user' => $user,
        'message' => 'Usuário atualizado com sucesso',
        'status' => 'success',
        'code' => 200
    ]);
    }


    public function destroy($id)
    {
        $users = User::find($id);

        if (!$users) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Usuário não encontrada'
            ], 404);
        }

        $users->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Usuário removida com sucesso'
        ], 200);
    }
}
