<?php

namespace Badge;

use Badge\Notifications\BadgeUnlocked;
use Illuminate\Events\Dispatcher;

class BadgeSubscriber {
    /**
     * @var Badge
     */
    private $badge;


    /**
     * BadgeSubscriber constructor.
     * @param Badge $badge
     */
    public function __construct (Badge $badge) {

        $this->badge = $badge;

    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen('eloquent.saved: App\Comment', [$this, 'onNewComment']);

        $events->listen('App\Events\Premium', [$this, 'onPremium']);

    }

    public function onNewComment ($comment) {

        $user = $comment->user;

        $comments_count = $user->comments()->count();

        $badge = $this->badge->unlockActionFor($user, 'comments', $comments_count);

        $this->notifyBadgeUnlock($user, $badge);

    }

    private function notifyBadgeUnlock ($user, $badge) {

        if ($badge) {

            $user->notify(new BadgeUnlocked($badge));

        }

    }

    public function onPremium ($event) {

        $badge = $this->badge->unlockActionFor($event->user, 'premium');

        $this->notifyBadgeUnlock($event->user, $badge);


    }


}
