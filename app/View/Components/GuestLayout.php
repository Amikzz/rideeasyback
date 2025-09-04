<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/**
 * Represents the guest layout component.
 *
 * This component is used as the base layout for pages that are
 * accessible to unauthenticated users, such as the login and
 * registration pages. It renders the `layouts.guest` view.
 */
class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
