<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organisation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'status',
        'manager_id',
        'organisation_logo',
        'city',
        'state',
        'zip_code',
        'country',
        'address',
        'zip_code',
        'website',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
