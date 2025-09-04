<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Represents the main application layout component.
 *
 * This component is used as the base layout for authenticated pages
 * in the application. It renders the `layouts.app` view.
 */
class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
