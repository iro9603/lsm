<?php

namespace App\Models;

use App\Observers\LessonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function image(): Attribute
    {
        return new Attribute(get: function () {
            if ($this->platform == 1) {
                return Storage::url($this->image_path);
            }

            return $this->image_path;
        });
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // Relacion muchos a muchos 
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_lesson_user')->withPivot([
            'course_id',
            'current',
            'completed'
        ])->withTimestamps();
    }
}
