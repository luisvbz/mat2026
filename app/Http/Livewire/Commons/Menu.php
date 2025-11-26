<?php

namespace App\Http\Livewire\Commons;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Menu extends Component
{
    public $route;
    public $isAdmin;
    public function mount() {
        $this->route = Route::currentRouteName();

        $this->isAdmin = auth()->user()->hasRole('Admin');
    }

    public function go($route){

        $this->redirect(route($route));
    }

    public function logout()
    {
        Auth::logout();
        redirect()->to(route('admin.login'));
    }

    public function render()
    {
        return view('livewire.commons.menu');
    }
}
