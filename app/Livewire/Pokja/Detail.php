<?php

namespace App\Livewire\Pokja;

use App\Models\Pokjars;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]
class Detail extends Component
{
    public Pokjars $pokja;
    public function mount(Pokjars $pokja){
    $this->pokja = $pokja;
    }
    public function render()
    {
        return view('livewire.pokja.detail');
    }
}
