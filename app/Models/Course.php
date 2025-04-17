<?php

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
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

    protected function image():Attribute{
        return new Attribute(
            get: function($value){
                return $this->image_path ? Storage::url($this->image_path) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg'; 
            }
        );
    }

    public function teacher(){
        return $this->belongsTo(User::class);
    }
    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function price(){
        return $this->belongsTo(Price::class);
    }

    //Relacion uno a muchos
    public function goals(){
        return $this->hasMany(Goal::class);
    }
}
