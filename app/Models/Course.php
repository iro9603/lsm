<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'status',
        'image_path',
        'video_path',
        'welcome_message',
        'goodbye_message',
        'observation',
        'user_id',
        'level_id',
        'category_id',
        'price_id',
        'published_at'
    ];

    protected $casts = [
        'status' => CourseStatus::class,
        'published_at' => 'datetime'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function image(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                return $this->image_path ? Storage::url($this->image_path) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg';
            }
        );
    }

    protected function dateOfAcquisition(): Attribute
    {
        return new Attribute(
            get: function () {

                return now()->parse(DB::table('course_user')->where('course_id', $this->id)->where('user_id', Auth::id())->first()->created_at);
            }
        );
    }

    protected function rating(): Attribute
    {
        return new Attribute(
            get: function () {

                return $this->reviews->count() ? round($this->reviews->avg('rating'), 2) : 5;
            }
        );
    }


    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    //Relacion uno a muchos
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
