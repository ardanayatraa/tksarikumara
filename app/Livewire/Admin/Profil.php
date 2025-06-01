<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class Profil extends Component
{
    public $id_admin;
    public $username;
    public $email;
    public $notlp;
    public $password;

    public function mount()
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) abort(403);

        $this->id_admin = $admin->id_admin;
        $this->username = $admin->username;
        $this->email    = $admin->email;
        $this->notlp    = $admin->notlp;
        $this->password = '';
    }

    protected function rules()
    {
        return [
            'username' => 'required|string',
            'email'    => 'required|email',
            'notlp'    => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ];
    }

    public function updateProfil()
    {
        $this->validate();

        $data = [
            'username' => $this->username,
            'email'    => $this->email,
            'notlp'    => $this->notlp,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        Admin::where('id_admin', $this->id_admin)->update($data);

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.profil');
    }
}
