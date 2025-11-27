<?php

namespace App\Livewire\Tests;

use Livewire\Component;

class Instructions extends Component
{
    public function startSpeedTask()
    {
        return redirect()->route('test.speed');
    }

    public function backToDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.tests.instructions');
    }
}
