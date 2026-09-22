<?php

namespace App\Livewire\Petugas;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Layout('layouts.template')]
class Index extends Component
{
            use WithPagination,WithoutUrlPagination;
    public $query='';

    public function updatedQuery()
    {
        $this->resetPage();
    }

            public function delete($id)
{
    $user = User::findOrFail($id);
    // Hapus user
    $user->delete();
     // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Petugas berhasil di hapus.'
        );

}
    public function render()
    {
        $datauser = User::query()->where('name','like','%' . $this->query . '%')->paginate(10);
        return view('livewire.petugas.index',['datauser' => $datauser]);
    }
}
