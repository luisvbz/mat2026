<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Historial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $username;
    public $password;


    public function updated($field){

        $this->validateOnly($field,[
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Debe ingresar el correo electrónico',
            'password.required' => 'Debe ingresar la contraseña'
        ]);
    }

    public function submitForm ()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Debe ingresar el correo electrónico',
            'password.required' => 'Debe ingresar la contraseña'
        ]);


        $credentials = ['username' => $this->username, 'password' => $this->password];

        if (Auth::attempt($credentials)) {
            Historial::create(['user_id' => auth()->user()->id, 'accion' => 'Iniciar sesión']);
            return redirect()->route('dashboard.principal');
        }else {
            $this->addError('credentials', 'Error de usuario y o contraseña');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.login')
            ->extends('layouts.login-panel')
            ->section('content');
    }
}
