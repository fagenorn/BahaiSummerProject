<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Group extends AbstractWidget
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
        $string = str_plural('Group', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-group',
            'title' => "{$count} {$string}",
            'text' => "You have " . $count . " " . str_plural('group', $count) . " registered.",
            'button' => [
                'text' => "View all groups",
                'link' => route('voyager.groups.index'),
            ],
            'image' => '/images/splash-group-widget.jpg',
        ]));
    }
}
