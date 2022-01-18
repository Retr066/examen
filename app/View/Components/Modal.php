<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $titulo;
    public $accion;
    /**
     * 
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $titulo = 'Guardar Empleados',string $accion = 'Guardar')
    {
        $this->titulo = $titulo;
        $this->accion = $accion;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
