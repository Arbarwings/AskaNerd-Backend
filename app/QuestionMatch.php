<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionMatch extends Model
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
     * Define the relationship with the user table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(User::class, 'id', 'question_id');
    }


    /**
     * @return Model|null|static
     */
    public function getNerdAttribute()
    {
        return $this->nerds()->first();
    }

    /**
     * @return Model|null|static
     */
    public function getQuestionAttribute()
    {
        return $this->questions()->first();
    }
}
