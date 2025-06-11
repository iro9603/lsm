<?php

namespace App\Livewire;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class CourseEnrolled extends Component
{

    public $course;

    public function addCart()
    {
        Cart::instance('shopping');

        Cart::add([
            'id' => $this->course->id,
            'name' => $this->course->title,
            'qty' => 1,
            'price' => $this->course->price->value,
            'options' => [
                'slug' => $this->course->price->value,
                'image' => $this->course->image,
                'teacher' => $this->course->teacher->name
            ]
        ]);

        if (Auth::check()) {

            Cart::store(Auth::id());
        }

        $this->dispatch('cart-updated', Cart::count());
    }

    public function removeCart()
    {
        Cart::instance('shopping');

        $itemCart = Cart::content()->where('id', $this->course->id)->first();

        if ($itemCart) {
            Cart::remove($itemCart->rowId);
        }

        $this->dispatch('cart-updated', Cart::count());

        if (Auth::check()) {

            Cart::store(Auth::id());
        }


    }

    public function buyNow()
    {
        $this->removeCart();
        $this->addCart();

        // Redireccionar a la pagina de checkout

        return redirect()->route('cart.index');
    }


    public function enrolled()
    {
        if (Auth::check()) {
            $this->course->students()->attach(Auth::id());
        }

        return redirect()->route('courses.status', $this->course);
    }

    public function render()
    {
        return view('livewire.course-enrolled');
    }
}
