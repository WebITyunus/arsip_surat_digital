<?php

namespace App\Livewire\Petugas;

use App\Models\Pokja;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.template')]
class Create extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:255|unique:users,username')]
    public $username = '';

    public $email = '';

    #[Validate('required|min:5|confirmed')]
    public $password = '';
public $password_confirmation = '';
    #[Validate('required|string|max:255')]
    public $role;

#[Validate('exists:units,id')]
public $unit_id = '';

#[Validate('exists:pokjars,id')]
public $pokja_id = '';

    #[Validate('required|boolean')]
    public $is_active = 1;

    public function SimpanUser()
    {
        $this->validate();

$user = User::create([
    'name' => $this->name,
    'username' => $this->username,
    'email' => $this->email ?: null,
    'password' => Hash::make($this->password),
    'unit_id' => $this->unit_id ?: null,
    'pokja_id' => $this->pokja_id ?: null,
    'is_active' => $this->is_active,
]);

$user->assignRole($this->role);
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'User berhasil ditambahkan.'
        );

        $this->reset();

        // Default setelah form di-reset
        $this->role = 'operator';
        $this->is_active = 1;
    }

public function render()
{
    $units = Unit::select([
        'id',
        'kode_unit',
        'nama_unit'
    ])
    ->where('is_active', 1)
    ->orderBy('nama_unit')
    ->get();
      $roles = Role::where('guard_name', 'web')
        ->orderBy('name')
        ->get();
        $pokjars= Pokja::select(['id','nama','kode'])->get();

    return view('livewire.petugas.create', [
        'units' => $units,'roles' => $roles,'pokjars' => $pokjars
    ]);
}
}
