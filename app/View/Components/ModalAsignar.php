<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalAsignar extends Component
{

    public $titulo;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $titulo = 'Asignar Horario a Empleados')
    {
        $this->titulo = $titulo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal-asignar');
    }
}
