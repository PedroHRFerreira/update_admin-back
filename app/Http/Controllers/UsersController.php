<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        return response()->json([
            'users' => User::all(),
            'message' => 'Usuarios carregados com sucesso',
            'status' => 'success',
            'code' => 200
        ]);
    }
}
