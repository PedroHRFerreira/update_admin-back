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
}
