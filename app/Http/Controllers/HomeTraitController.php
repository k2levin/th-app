<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HomeTraitController
{
    /**
     * Merge the posts and comments
     * @param array $posts
     * @param array $comments
     *
     * @return array
     */
    private function mergePostsComments(array $posts = [], array $comments = [])
    {
        foreach ($posts as &$post) {
            foreach ($comments as $comment) {
                if ($post['id'] == $comment['postId']) {
                    $post['comments'][] = $comment;
                }
            }
        }

        return $posts;
    }

    /**
     * Sort the top posts
     * @param array $posts
     *
     * @return array $posts
     */
    private function sortdTopPosts($posts)
    {
        $posts = collect($posts)->sortByDesc(function ($post) {
            return count($post['comments']);
        })->values()->all();

        return $posts;
    }

    /**
     * Map the fields
     * @param array $posts
     *
     * @return array
     */
    private function mapFields($posts)
    {
        $new_posts = [];

        foreach ($posts as $i => $post) {
            $new_posts[$i]['post_id'] = $post['id'];
            $new_posts[$i]['post_title'] = $post['title'];
            $new_posts[$i]['post_body'] = $post['body'];
            $new_posts[$i]['total_number_of_comments'] = count($post['comments']);
        }

        return $new_posts;
    }

    /**
     * Filter the comments
     *
     * @param array $comments
     * @param string $field
     * @param string $operator
     * @param string $value
     *
     * @return array
     */
    private function filterComments(array $comments = [], string $field, string $operator, string $value)
    {
        $comments = collect($comments)->filter(function ($comment) use ($field, $operator, $value) {
            if ($operator == 'eq') {
                return $comment[$field] == $value;
            } elseif ($operator == 'ne') {
                return $comment[$field] != $value;
            } elseif ($operator == 'gt') {
                return $comment[$field] > $value;
            } elseif ($operator == 'gte') {
                return $comment[$field] >= $value;
            } elseif ($operator == 'lt') {
                return $comment[$field] < $value;
            } elseif ($operator == 'lte') {
                return $comment[$field] <= $value;
            } elseif ($operator == 'like') {
                return stripos($comment[$field], $value) !== false;
            } else {
                return false;
            }
        })->values()->all();

        return $comments;
    }

    /**
     * Get the contents from url
     *
     * @param string $url
     *
     * @return array
     */
    private function getContentsFromUrl(string $url)
    {
        try {
            $json = file_get_contents($url);
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'status' => 'failure',
                'message' => 'Error from getting external API.',
            ], 401));
        }

        $datas = json_decode($json, true);

        return $datas;
    }
}
