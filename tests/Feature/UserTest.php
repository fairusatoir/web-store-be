<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * Test the unverified method.
     *
     * @return void
     */
    public function testUnverifiedUser()
    {
        $user = User::factory()->unverified()->create();
        $this->assertNull($user->email_verified_at);
    }
}
