<?php

namespace Tests\Unit;

use App\Comment;
use App\Events\Premium;
use App\User;
use Badge\Badge;
use Badge\Notifications\BadgeUnlocked;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BadgeTest extends TestCase {


    use DatabaseTransactions, DatabaseMigrations;


    public function test_unlock_badge_automatically () {

        Badge::create([

            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2

        ]);

        $user = factory(User::class)->create();

        factory(Comment::class, 3)->create(['user_id' => $user->id]);


        $this->assertEquals(1, $user->badges()->count());

    }

    public function test_dont_unlock_badge_for_enough_action () {

        Badge::create([

            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2

        ]);

        $user = factory(User::class)->create();

        factory(Comment::class)->create(['user_id' => $user->id]);

        $this->assertEquals(0, $user->badges()->count());

    }

    public function test_unlock_double_badge () {

        Badge::create([

            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2

        ]);

        $user = factory(User::class)->create();

        factory(Comment::class, 2)->create(['user_id' => $user->id]);

        $this->assertEquals(1, $user->badges()->count());

        Comment::first()->delete();

        factory(Comment::class, 2)->create(['user_id' => $user->id]);

        $this->assertEquals(1, $user->badges()->count());

    }


    public function test_notification_sent () {

        Notification::fake();

        Badge::create([

            'name' => 'Pipelette',
            'action' => 'comments',
            'action_count' => 2

        ]);

        $user = factory(User::class)->create();

        factory(Comment::class, 3)->create(['user_id' => $user->id]);


        Notification::assertSentTo([$user], BadgeUnlocked::class);

    }

    public function test_unlock_premium_badge () {

        Badge::create([

            'name' => 'Premium',
            'action' => 'premium',
            'action_count' => 0

        ]);

        $user = factory(User::class)->create();
        event(new Premium($user));
        $this->assertEquals(1, $user->badges()->count());



    }


}
