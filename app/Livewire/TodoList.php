<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule(['required', 'min:3', 'max:125'])]
    public $name;

    #[Url(as : 'q', history: true)]
    public $search;

    public $editId;

    #[Rule(['required', 'min:3', 'max:125'])]

    public $editName;

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(6)
        ]);
    }

    public function create()
    {
        $this->validateOnly('name');

        Todo::create(['name' => $this->name]);

        $this->reset('name');

        session()->flash('saved', 'Saved.');

        $this->resetPage();

    }

    public function edit(Todo $todo)
    {
        $this->editId = $todo->id;
        $this->editName = $todo->name;

    }

    public function update()
    {
        $this->validateOnly('editName');

        Todo::find($this->editId)->update([
            'name' => $this->editName
        ]);

        $this->cancel();

    }

    public function cancel()
    {
        $this->reset('editId', 'editName');
    }

    public function completion(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
    }
}
