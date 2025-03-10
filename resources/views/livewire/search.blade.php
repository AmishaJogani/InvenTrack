<form class="search-form d-flex align-items-center" method="POST" wire:submit="search">
    <input
        type="text"
        wire:name="query"
        placeholder="Search"
        title="Enter search keyword"
    />
    <button type="submit" title="Search">
        <i class="bi bi-search"></i>
    </button>
</form>
