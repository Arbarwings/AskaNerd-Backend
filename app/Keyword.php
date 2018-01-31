<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $guarded = [];

    /**
     * Define the relationship with the user table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nerds()
    {
        return $this->hasMany(User::class, 'id', 'nerd_id');
    }

    /**
     * @return Model|null|static
     */
    public function getNerdAttribute()
    {
        return $this->nerds()->first();
    }
}
