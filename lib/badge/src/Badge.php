<?php

namespace Badge;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    protected $guarded = [];
    public $timestamps = false;


    /**
     * @return HasMany
     */
    public function unlocks (): HasMany
    {

        return $this->hasMany(BadgeUnlock::class);

    }


    /**
     * @param User $user
     * @return bool
     */
    public function isUnlockFor (User $user): bool {

        return $this->unlocks()->where('user_id', $user->id)->exists();

    }

    /**
     * @param User $user
     * @param string $action
     * @param int $count
     * @return mixed
     */
    public function unlockActionFor (User $user, string $action, int $count = 0) {

        $badge  = $this->newQuery()->where('action', $action)->where('action_count', $count)->first();

        if ($badge && ! $badge->isUnlockFor($user)) {

            $user->badges()->attach($badge);

            return $badge;

        }

        return null;


    }

}
