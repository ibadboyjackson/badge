<?php

namespace Badge;

trait Bageable {


    public function badges (): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {

        return $this->belongsToMany (Badge::class);

    }


}
