<?php

namespace App;

/**
 * Class AdDesc
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ad_id
 * @property string $desc
 * @property-read User $user
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class AdDesc extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'user_id',
        'ad_id',
        'desc',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
