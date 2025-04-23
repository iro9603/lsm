<?php

namespace App\Models;

use App\Observers\LessonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([LessonObserver::class])]
class Lesson extends Model
{
    //


    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'platform',
        'video_path',
        'video_original_name',
        'image_path',
        'description',
        'duration',
        'position',
        'is_published',
        'is_preview',
        'is_processed',
        'section_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_preview' => 'boolean',
        'is_processed' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
