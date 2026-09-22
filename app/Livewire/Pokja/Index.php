<?php

namespace App\Livewire\Pokja;

use App\Models\Pokjars;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.template')]
class Index extends Component
{
use WithPagination;
    public $query = '';


    public function updatedQuery()
    {
        $this->resetPage();
    }

public function render()
{
    $author = Auth::id();

    $pokjars = Pokjars::query()
        ->where('author_id', $author)
        ->where(function ($query) {
            $query->where('isi', 'like', '%' . $this->query . '%');
        })
        ->paginate(10);

    return view('livewire.pokja.index', [
        'pokjars' => $pokjars,
    ]);
}

}
