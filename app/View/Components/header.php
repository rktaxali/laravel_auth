<?php

namespace App\View\Components;

use Illuminate\View\Component;

class header extends Component
{
	
	public $name;
	public $fruit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name=null,$fruit=null)
    {
        $this->name = $name;
		$this->fruit = $fruit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.header');
    }
}
