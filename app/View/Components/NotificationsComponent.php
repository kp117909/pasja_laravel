<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Notifications;

class NotificationsComponent extends Component
{
    public $notifications;

    public function __construct()
    {
        $this->notifications = Notifications::all();
    }

    public function render()
    {
        return view('components.notifications-component');
    }
}
