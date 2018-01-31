<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    /**
     * Define the relationship with the user table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    /**
     * @return Model|null|static
     */
    public function getUserAttribute()
    {
        return $this->users()->first();
    }
}
