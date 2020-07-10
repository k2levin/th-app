<?php

namespace Tests\Unit;

use App\Http\Controllers\HomeTraitController;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    use HomeTraitController;

    /**
     * Test mergePostsComments
     *
     * @return void
     */
    public function testMergePostsComments()
    {
        $posts_json = '[{"userId":1,"id":1,"title":"p1","body":""}]';
        $posts = json_decode($posts_json, true);

        $comments_json = '[{"postId":1,"id":1,"name":"1-1","email":"","body":""}]';
        $comments = json_decode($comments_json, true);

        $posts = $this->mergePostsComments($posts, $comments);

        $this->assertArrayHasKey('userId', $posts[0]);
        $this->assertArrayHasKey('id', $posts[0]);
        $this->assertArrayHasKey('title', $posts[0]);
        $this->assertArrayHasKey('body', $posts[0]);
        $this->assertArrayHasKey('comments', $posts[0]);

        $this->assertArrayHasKey('postId', $posts[0]['comments'][0]);
        $this->assertArrayHasKey('id', $posts[0]['comments'][0]);
        $this->assertArrayHasKey('name', $posts[0]['comments'][0]);
        $this->assertArrayHasKey('email', $posts[0]['comments'][0]);
        $this->assertArrayHasKey('body', $posts[0]['comments'][0]);
    }

    /**
     * Test sortdTopPosts
     *
     * @return void
     */
    public function testSortdTopPosts()
    {
        $posts_json = '[{"userId":1,"id":1,"title":"p1","body":"","comments":[{"postId":1,"id":1,"name":"1-1","email":"","body":""},{"postId":1,"id":2,"name":"1-2","email":"","body":""},{"postId":1,"id":3,"name":"1-3","email":"","body":""}]},{"userId":1,"id":2,"title":"p2","body":"","comments":[{"postId":2,"id":4,"name":"2-1","email":"","body":""}]},{"userId":1,"id":3,"title":"p3","body":"","comments":[{"postId":3,"id":5,"name":"3-1","email":"","body":""},{"postId":3,"id":6,"name":"3-2","email":"","body":""},{"postId":3,"id":7,"name":"3-3","email":"","body":""},{"postId":3,"id":8,"name":"3-4","email":"","body":""},{"postId":3,"id":9,"name":"3-5","email":"","body":""}]},{"userId":1,"id":4,"title":"p4","body":"","comments":[{"postId":4,"id":10,"name":"4-1","email":"","body":""},{"postId":4,"id":11,"name":"4-2","email":"","body":""}]}]';
        $posts = json_decode($posts_json, true);

        $posts = $this->sortdTopPosts($posts);

        $this->assertEquals('p3', $posts[0]['title']);
        $this->assertEquals('p1', $posts[1]['title']);
        $this->assertEquals('p4', $posts[2]['title']);
        $this->assertEquals('p2', $posts[3]['title']);
    }

    /**
     * Test mapFields
     *
     * @return void
     */
    public function testMapFields()
    {
        $posts_json = '[{"userId":1,"id":1,"title":"p1","body":"","comments":[{"postId":1,"id":1,"name":"1-1","email":"","body":""}]}]';
        $posts = json_decode($posts_json, true);

        $posts = $this->mapFields($posts);

        $this->assertArrayHasKey('post_id', $posts[0]);
        $this->assertArrayHasKey('post_title', $posts[0]);
        $this->assertArrayHasKey('post_body', $posts[0]);
        $this->assertArrayHasKey('total_number_of_comments', $posts[0]);
    }

    /**
     * Test filterComments
     *
     * @return void
     */
    public function testFilterComments()
    {
        $comments_json = '[{"postId":1,"id":1,"name":"id labore ex et quam laborum","email":"Eliseo@gardner.biz","body":"laudantium enim quasi est quidem magnam voluptate ipsam eos\ntempora quo necessitatibus\ndolor quam autem quasi\nreiciendis et nam sapiente accusantium"},{"postId":1,"id":2,"name":"quo vero reiciendis velit similique earum","email":"Jayne_Kuhic@sydney.com","body":"est natus enim nihil est dolore omnis voluptatem numquam\net omnis occaecati quod ullam at\nvoluptatem error expedita pariatur\nnihil sint nostrum voluptatem reiciendis et"},{"postId":1,"id":3,"name":"odio adipisci rerum aut animi","email":"Nikita@garfield.biz","body":"quia molestiae reprehenderit quasi aspernatur\naut expedita occaecati aliquam eveniet laudantium\nomnis quibusdam delectus saepe quia accusamus maiores nam est\ncum et ducimus et vero voluptates excepturi deleniti ratione"},{"postId":1,"id":4,"name":"alias odio sit","email":"Lew@alysha.tv","body":"non et atque\noccaecati deserunt quas accusantium unde odit nobis qui voluptatem\nquia voluptas consequuntur itaque dolor\net qui rerum deleniti ut occaecati"},{"postId":1,"id":5,"name":"vero eaque aliquid doloribus et culpa","email":"Hayden@althea.biz","body":"harum non quasi et ratione\ntempore iure ex voluptates in ratione\nharum architecto fugit inventore cupiditate\nvoluptates magni quo et"}]';
        $comments = json_decode($comments_json, true);

        $comments1 = $this->filterComments($comments, 'id', 'lte', '3');
        $this->assertEquals('1', $comments1[0]['id']);
        $this->assertEquals('2', $comments1[1]['id']);
        $this->assertEquals('3', $comments1[2]['id']);

        $comments2 = $this->filterComments($comments, 'email', 'like', 'sydney');
        $this->assertEquals('Jayne_Kuhic@sydney.com', $comments2[0]['email']);
    }

    /**
     * Test getContentsFromUrl
     *
     * @return void
     */
    public function testGetContentsFromUrl()
    {
        $url = 'https://jsonplaceholder.typicode.com/comments';
        $datas = $this->getContentsFromUrl($url);

        if (is_array($datas)) {
            $this->assertTrue(true);
        }

        $this->assertArrayHasKey('postId', $datas[0]);
        $this->assertArrayHasKey('id', $datas[0]);
        $this->assertArrayHasKey('name', $datas[0]);
        $this->assertArrayHasKey('email', $datas[0]);
        $this->assertArrayHasKey('body', $datas[0]);
    }
}
