<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class ManageReviews extends Component
{
    public $course;

    public $reviews;

    public $reviewEdit = [
        'open' => false,
        'id' => null,
        'rating' => 5,
        'comment' => ''
    ];

    public function mount()
    {
        $this->reviews = Review::where('course_id', $this->course->id)->with('user')->get();

    }

    public function edit(Review $review)
    {
        $this->reviewEdit = [
            'open' => true,
            'id' => $review->id,
            'rating' => $review->rating,
            'comment' => $review->comment
        ];
    }

    public function update()
    {
        $this->validate([
            'reviewEdit.rating' => 'required|integer|min:1',
            'reviewEdit.comment' => 'required|string'
        ]);

        $review = Review::find($this->reviewEdit['id']);

        $review->update([
            'rating' => $this->reviewEdit['rating'],

            'comment' => $this->reviewEdit['comment']
        ]);

        $this->reviews = Review::where('course_id', $this->course->id)->with('user')->get();

        $this->reset('reviewEdit');
    }

    public function delete(Review $review)
    {
        $review->delete();
        $this->reviews = Review::where('course_id', $this->course->id)->with('user')->get();
    }

    public function render()
    {


        return view('livewire.manage-reviews');
    }
}
