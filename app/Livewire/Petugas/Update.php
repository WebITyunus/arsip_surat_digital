<?php

namespace App\Livewire\Petugas;

use App\Models\Pokja;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.template')]
class Update extends Component
{
    public User $user;

    public $name = '';
    public $username = '';
    public $email = '';
    public $unit_id = '';
    public $password = '';
    public $password_confirmation = '';

    public $role = '';
    public $pokja_id = '';

    public $is_active = 1;

public function mount(User $user)
{
    $this->user = $user;

    $this->name = $user->name;
    $this->username = $user->username;
    $this->email = $user->email;
    $this->unit_id = $user->unit_id;
    $this->pokja_id = $user->pokja_id;
    $this->is_active = $user->is_active;

    // Ambil role Spatie user
    $this->role = $user->roles->first()?->name;
}
    public function UpdateUser()
    {
        $rules = [
            'name' => 'required|string|max:255',

            'username' => 'required|string|max:255|unique:users,username,' . $this->user->id,

            'email' => 'nullable|email|max:255',

            'unit_id' => 'nullable|exists:units,id',

            'role' => 'required|string|max:255',

            'pokja_id' => 'nullable|exists:pokjars,id',

            'is_active' => 'required|boolean',
        ];

        // Password hanya divalidasi kalau ingin mengganti
        if ($this->password !== '') {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

$data = [
    'name' => $this->name,
    'username' => $this->username,
    'email' => $this->email ?: null,
    'unit_id' => $this->unit_id ?: null,
    'pokja_id' => $this->pokja_id ?: null,
    'is_active' => $this->is_active,
];

if ($this->password !== '') {
    $data['password'] = Hash::make($this->password);
}

$this->user->update($data);

// Update role Spatie
$this->user->syncRoles([$this->role]);

        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Data user berhasil diperbarui.'
        );

        $this->reset([
            'password',
            'password_confirmation',
        ]);

        $this->user->refresh();
    }

   public function render()
{
    $units = Unit::select([
        'id',
        'kode_unit',
        'nama_unit'
    ])->get();

    $roles = Role::select([
        'id',
        'name'
    ])->get();

        $pokjars= Pokja::select(['id','nama','kode'])->get();


    return view('livewire.petugas.update', [
        'units' => $units,
        'roles' => $roles,
        'pokjars' => $pokjars
    ]);
}
}
