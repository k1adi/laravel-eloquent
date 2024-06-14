<?php

namespace Tests\Feature;

use App\Models\Comment;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function testMakeComment()
    {
        $comment = new Comment();
        $comment->email = 'email@email.com';
        $comment->title = 'Comment Title';
        $comment->comment = 'Sample Comment';
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();

        $comment->save();
        $this->assertNotNull($comment->id);
    }

    public function testDefaultValues()
    {
        $comment = new Comment();
        $comment->email = 'email@email.com';
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();

        $comment->save();
        $this->assertNotNull($comment->id);
        $this->assertNotNull($comment->title);
        $this->assertNotNull($comment->comment);
    }
}
