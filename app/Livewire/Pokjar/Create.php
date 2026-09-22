<?php

namespace App\Livewire\Pokjar;

use App\Models\Pokja;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
#[Layout('layouts.template')]
class Create extends Component
{
                use WithFileUploads;

    #[Validate('required|string')]
    public $name = '';

    #[Validate('required|string|max:255')]
    public $kode = '';

    public function pokjar(){
    $this->validate();

        Pokja::create([
'name' => $this->name,
'kode' => $this->kode,
        ]);
    }


    public function render()
    {
        return view('livewire.pokjar.create');
    }
}
