<?php

namespace Tests\Feature;

use App\Post;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * @return void
     */
    public function testPostCreateView()
    {
        $response = $this->get('/admin/posts/create');

        $response->assertStatus(200);

        $response->assertViewIs('admin.posts.create');
    }

    /**
     * @return void
     */
    public function testPostCreate()
    {
        //$this->withoutExceptionHandling();
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

    /**
     * @return void
     */
    public function testPostListView()
    {
        $response = $this->get('/admin/posts');

        $response->assertStatus(200);

        $response->assertViewIs('admin.posts.index');

        $response->assertViewHas('posts');
    }

    /**
     * @return void
     */
    public function testPostListWithTitleSearch()
    {
        $response = $this->get('/admin/posts?search=Test post title');

        $response->assertStatus(200);

        $response->assertSee('Test post title');
    }

    /**
     * @return void
     */
    public function testPostListWithContentSearch()
    {
        $response = $this->get('/admin/posts?search=Test post content');

        $response->assertStatus(200);

        $response->assertSee('Test post content');
    }

    /**
     * @return void
     */
    public function testPostListWithCategorySearch()
    {
        $response = $this->get('/admin/posts?search=Test post category');

        $response->assertStatus(200);

        $response->assertSee('Test post category');
    }

    /**
     * @return void
     */
    public function testPostShowView()
    {
        $post = Post::create([
            'title'    => 'Test post title',
            'content'  => 'Test post content',
            'category' => 'Test post category',
        ]);
        $response = $this->get('/admin/posts/' . $post->id);

        $response->assertStatus(200);

        $response->assertViewIs('admin.posts.show');

        $response->assertViewHas('post');
    }

    /**
     * @return void
     */
    public function testPostEditView()
    {
        $post = Post::create([
            'title'    => 'Test post title',
            'content'  => 'Test post content',
            'category' => 'Test post category',
        ]);

        $response = $this->get('/admin/posts/' . $post->id . '/edit');

        $response->assertStatus(200);

        $response->assertViewIs('admin.posts.edit');

        $response->assertViewHas('post');
    }

    /**
     * @return void
     */
    public function testPostUpdate()
    {
        $post = Post::create([
            'title'    => 'Test post title to be update',
            'content'  => 'Test post content to be update',
            'category' => 'Test post category to be update',
        ]);

        $response = $this->patch('/admin/posts/' . $post->id, [
            'title'    => 'Test post updated title',
            'content'  => 'Test post updated content',
            'category' => 'Test post updated category',
        ]);

        $response->assertRedirect('admin/posts');

        $this->assertDatabaseHas('posts', [
            'title' => 'Test post updated title',
        ]);
    }

    /**
     * @return void
     */
    public function testPostDelete()
    {
        $post = Post::create([
            'title'    => 'Test post title to delete',
            'content'  => 'Test post content to delete',
            'category' => 'Test post category to delete',
        ]);

        $response = $this->delete('/admin/posts/' . $post->id);

        $response->assertRedirect('admin/posts');

        $this->assertDatabaseMissing('posts', [
            'title' => 'Test post to delete',
        ]);
    }
}
