@props(['action'])
<div id="searchModal" class="modal-overlay hidden">
    <div class="modal-content">
        <h2>Cari</h2>
        <form method="GET" action="{{ $action }}">
            <input type="text" name="search" placeholder="Masukkan kata kunci..." value="{{ request('search') }}" class="p-2 w-full border rounded mb-4">
            <div class="flex justify-end gap-2">
                <x-button type="submit">Cari</x-button>
                <x-button color="red" onclick="toggleSearch()">Tutup</x-button>
            </div>
        </form>
    </div>
</div>
