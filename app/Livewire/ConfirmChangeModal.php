<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmChangeModal extends Component
{
    public $showModal = false;
    public $oldValue;
    public $newValue;

    public function openModal($oldValue, $newValue)
    {
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
        $this->showModal = true;
    }

    public function confirmChange()
    {
        // Aqui você pode adicionar a lógica para atualizar o nome no banco de dados.
        $this->showModal = false; // Fecha o modal após a confirmação.
    }

    public function render()
    {
        return view('livewire.confirm-change-modal');
    }
}


