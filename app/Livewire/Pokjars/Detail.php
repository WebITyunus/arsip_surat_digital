<?php

namespace App\Livewire\Pokjars;

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
        return view('livewire.pokjars.detail');
    }
}
