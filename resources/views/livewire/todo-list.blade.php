<div>
    @include('livewire.create')

    @include('livewire.search')
    
    <div id="todos-list">
        @foreach ($todos as $todo)
            @include('livewire.show')
        @endforeach
        <div class="my-2">
            {{ $todos->links() }}
        </div>
    </div>
</div>
