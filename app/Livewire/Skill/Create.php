<?php

namespace App\Livewire\Skill;

use App\Models\Category;
use App\Models\Skill;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;
    public $category;
    public $categories;
    public $type;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function createSkill()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category' => 'required|exists:categories,id',
        ]);

        Skill::create([
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category,
            'type' => $this->type,
        ]);

        $this->reset(['name', 'description', 'category', 'type']);
        $this->redirect('/skill');
    }

    public function render()
    {
        return view('livewire.skill.create');
    }
}
