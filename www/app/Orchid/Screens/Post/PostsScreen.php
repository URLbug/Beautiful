<?php

namespace App\Orchid\Screens\Post;

use App\Models\Post;
use App\Orchid\Layouts\Posts\PostEditLayout;
use App\Orchid\Layouts\Posts\PostListLayout;
use Orchid\Screen\Screen;

class PostsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'post' => Post::find(1),
            'posts' => Post::paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Posts';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            // PostListLayout::class,
            PostEditLayout::class,
        ];
    }
}
