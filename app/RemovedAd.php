<?php

namespace App;

/**
 * Class RemoveAd
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ad_id
 * @property-read User $user
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class RemovedAd extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'user_id',
        'ad_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
