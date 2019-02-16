<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Inquilino
 *
 * @property int    $id
 * @property string $name
 * @property array  $nicknames
 * @property int    $number
 */
class Tenant extends Model implements HasMedia
{
    use HasMediaTrait;


    /**
     * @var string
     */
    const DEFAULT_AVATAR_URL = '/svg/default-avatar.svg';

    protected $casts = [
        'nicknames' => 'array',
    ];

    protected $appends = [
        'avatar_url',
    ];

    protected $guarded = [
    ];

    protected $with = [
        'title'
    ];

    /**
     * $avatar_url getter
     *
     * @return string
     */
    public function getAvatarUrlAttribute() : string
    {
        $url = $this->getFirstMediaUrl();

        return $url ?: static::DEFAULT_AVATAR_URL;
    }


    public function title()
    {
        return $this->belongsTo(Title::class);
    }
}
