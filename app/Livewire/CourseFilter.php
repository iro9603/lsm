<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Course;
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
        $rate = ExchangeRate::where('from_currency', 'USD')
            ->where('to_currency', 'MXN')
            ->value('rate') ?? 0;



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

        // Paso 3: Transformar la colección para agregar precio en MXN
        $courses->getCollection()->transform(function ($course) use ($rate) {
            $usd = $course->price->value ?? 0;
            $course->price_mxn = round($usd * $rate, 2);
            return $course;
        });

        // 👇 Aquí transformamos y reasignamos la colección modificada
        $transformed = $courses->getCollection()->transform(function ($course) use ($rate) {
            $usd = $course->price->value ?? 0;
            $course->price_mxn = round($usd * $rate, 2);
            return $course;
        });

        $courses->setCollection($transformed); // 🔁 Aquí se reasigna

        return view('livewire.course-filter', compact('courses'));
    }
}
