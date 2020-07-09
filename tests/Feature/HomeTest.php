<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Test /api/list
     *
     * @return void
     */
    public function testApiList()
    {
        $response = $this->get('api/list');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'data' => [[
                    'post_id',
                    'post_title',
                    'post_body',
                    'total_number_of_comments',
                ]],
            ]);
    }

    /**
     * Test /api/search
     *
     * @return void
     */
    public function testApiSearch()
    {
        $response = $this->post('api/search', [
            'field' => 'id',
            'operator' => 'lte',
            'value' => '3',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure([
                'data' => [[
                    'postId',
                    'id',
                    'name',
                    'email',
                    'body',
                ]],
            ]);
    }
}
