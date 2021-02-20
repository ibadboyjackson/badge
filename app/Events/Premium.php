<?php

namespace App\Events;

use App\User;

class Premium {
    /**
     * @var User
     */
    public $user;

    /**
     * Premim constructor.
     * @param User $user
     */
    public function __construct (User $user) {

        $this->user = $user;

    }

}
