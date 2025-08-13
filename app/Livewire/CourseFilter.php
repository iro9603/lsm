<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Course;
use App\Models\ExchangeRate;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseFilter extends Component
{
    /** @var LengthAwarePaginator $courses */

    use WithPagination;

    public $categories;
    public $levels;

    public $selectedCategories = [];


    public $selectedLevels = [];

    public $selectedPrices = [];

    public $search;

    public $usdRate;

    public $priceUsd;

    public $priceMxn;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->levels = Level::all();
    }
    public function render()
    {

        $courses = Course::where('status', 3)->when($this->selectedCategories, function ($query) {
            $query->whereIn('category_id', $this->selectedCategories);
        })->when($this->selectedLevels, function ($query) {
            $query->whereIn('level_id', $this->selectedLevels);
        })->when($this->selectedPrices, function ($query) {
            if (count($this->selectedPrices) == 1) {
                if ($this->selectedPrices[0] == 'free') {
                    $query->where('price_id', '1');
                } else {
                    $query->where('price_id', '!=', 1);
                }
            }
        })->when($this->search, function ($query) {
            $query->where('title', 'LIKE', '%' . $this->search . '%');
        })->paginate(5);


        return view('livewire.course-filter', compact('courses'));
    }
}
