<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public function createCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $this->name,
        ]);

        return $this->redirect('/skill');
    }

    public function render()
    {
        return view('livewire.category.create');
    }
}
