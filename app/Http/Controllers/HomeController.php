<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\HomeSearchRequest;
use Exception;

class HomeController extends Controller
{
    use HomeTraitController;

    /**
     * 1. Return a list of top posts ordered by the number of comments. Consume the API endpoints provided
     * - comments endpoint – https://jsonplaceholder.typicode.com/comments
     * - View Single Post endpoint – https://jsonplaceholder.typicode.com/posts/{post_id}
     * - View All Posts endpoint – https://jsonplaceholder.typicode.com/posts
     * - The API response should have the following fields:
     *   - post_id
     *   - post_title
     *   - post_body
     *   - total_number_of_comments
     *
     * @return json
     */
    public function list() {
        $posts = $this->getContentsFromUrl('https://jsonplaceholder.typicode.com/posts');
        $comments = $this->getContentsFromUrl('https://jsonplaceholder.typicode.com/comments');

        $posts = $this->mergePostsComments($posts, $comments);
        $posts = $this->sortdTopPosts($posts);
        $posts = $this->mapFields($posts);

        return response()->json(['status' => 'success', 'data' => $posts], 200);
    }

    /**
     * 2. Search API Create an endpoint that allows a user to filter the comments based on all the available fields. Your solution needs to be scalable.
     * - comments endpoint – https://jsonplaceholder.typicode.com/comments
     *
     * @param Request $request
     *
     * @return json
     */
    public function search(HomeSearchRequest $request)
    {
        $comments = $this->getContentsFromUrl('https://jsonplaceholder.typicode.com/comments');

        $comments = $this->filterComments($comments, $request->field, $request->operator, $request->value);

        return response()->json(['status' => 'success', 'data' => $comments], 200);
    }
}
