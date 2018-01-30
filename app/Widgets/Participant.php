<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Participant extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = \App\Group::count();
        $string = str_plural('Participant', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-person',
            'title' => "{$count} {$string}",
            'text' => "You have " . $count . " " . str_plural('participant', $count) . " registered.",
            'button' => [
                'text' => "View all participants",
                'link' => route('voyager.groups.index'),
            ],
            'image' => '/images/splash-participant-widget.jpg',
        ]));
    }
}
