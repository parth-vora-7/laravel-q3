<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * @return void
     */
    public function testPostList()
    {
        $response = $this->get('/admin/posts');

        $response->assertStatus(200);

        $response->assertViewIs('admin.posts.index');

        $response->assertViewHas('posts');
    }

    /**
     * @return void
     */
    public function testPostListWithSearch()
    {
        $response = $this->get('/admin/posts?search=post1');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testPostCreate()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/admin/posts', [
            'title'    => 'Test post title',
            'content'  => 'Test post content',
            'category' => 'Test post category',
        ]);

        $response->assertRedirect('admin/posts');

        $this->assertDatabaseHas('posts', [
            'title' => 'Test post title',
        ]);
    }
}
