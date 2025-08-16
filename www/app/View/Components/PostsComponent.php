<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostsComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $posts;

    public function __construct(mixed $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.posts-component');
    }
}
