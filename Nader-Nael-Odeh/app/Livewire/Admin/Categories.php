<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public $showEditModal = false;
    public $editCategoryId;
    public $editCategoryName;
    public $editCategoryStatus;

    public $showAddModal = false;
    public $addCategoryName;
    public $addCategoryStatus = 'active';

    public function render()
    {
        $categories = Category::withCount(['questions', 'articles', 'lawyers'])
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.admin.categories', [
            'categories' => $categories
        ]);
    }

    public function openAddModal()
    {
        $this->reset(['addCategoryName', 'addCategoryStatus']);
        $this->addCategoryStatus = 'active';
        $this->showAddModal = true;
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->resetValidation();
    }

    public function addCategory()
    {
        $this->validate([
            'addCategoryName' => 'required|string|max:255|unique:categories,name',
            'addCategoryStatus' => 'required|in:active,inactive',
        ]);

        Category::create([
            'name' => $this->addCategoryName,
            'status' => $this->addCategoryStatus,
            'slug' => \Illuminate\Support\Str::slug($this->addCategoryName),
        ]);

        $this->closeAddModal();
        session()->flash('success', 'Category added successfully.');
        $this->dispatch('action-completed');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->editCategoryId = $category->id;
        $this->editCategoryName = $category->name;
        $this->editCategoryStatus = $category->status;
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetValidation();
    }

    public function updateCategory()
    {
        $this->validate([
            'editCategoryName' => 'required|string|max:255|unique:categories,name,' . $this->editCategoryId,
            'editCategoryStatus' => 'required|in:active,inactive',
        ]);

        $category = Category::findOrFail($this->editCategoryId);
        $category->update([
            'name' => $this->editCategoryName,
            'status' => $this->editCategoryStatus,
            'slug' => \Illuminate\Support\Str::slug($this->editCategoryName),
        ]);

        $this->closeEditModal();
        session()->flash('success', 'Category updated successfully.');
        $this->dispatch('action-completed');
    }

    public function toggleCategory($id, $action)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => $action]);
        
        $actionText = $action === 'active' ? 'activated' : 'deactivated';
        session()->flash('success', "Category {$actionText} successfully.");
        $this->dispatch('action-completed');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->questions()->exists() || $category->articles()->exists() || $category->lawyers()->exists()) {
            session()->flash('error', 'Cannot delete category that is in use. Deactivate it instead.');
            return;
        }

        $category->delete();
        session()->flash('success', 'Category deleted successfully.');
        $this->dispatch('action-completed');
    }
}
