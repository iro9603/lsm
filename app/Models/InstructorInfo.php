<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class InstructorInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'video_path',
        'video_original_name',
        'image_path',
        'description',
        'about_me',
        'subject',
        'duration',
        'is_published',
        'is_preview',
        'is_processed',

    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_preview' => 'boolean',
        'is_processed' => 'boolean',
    ];

    public function image(): Attribute
    {
        return new Attribute(get: function () {
            if ($this->platform == 1) {
                return Storage::url($this->image_path);
            }

            return $this->image_path;
        });
    }

    // Relación inversa con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
