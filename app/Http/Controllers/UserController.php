<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        //consulta todos los usuarios de la base de datos
        $users = User::latest()->get();
        //envia el resultado a la vista users
        return view('users.index', [
            'users' => $users
        ] );
    }

    public function store(Request $request)
    {
        //valida los datos
        $request->validate([
            'name' =>       ['required'],
            'email' =>      ['required', 'email', 'unique:users'],
            'password' =>   ['required', 'min:8']
        ]);

        //crea un usuario con los siguientes datos
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //retorna a la vista anterior
        return back();
    }

    public function destroy(User $user)
    {
        //Recibe como parametro la informacion del usuario 
        //si lo encuentra lo elimina
        $user->delete();
        //retorna a la vista anterior
        return back();
    }
}
