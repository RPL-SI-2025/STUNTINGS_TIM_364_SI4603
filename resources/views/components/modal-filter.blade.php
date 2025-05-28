@props(['kategoris', 'kategoriIds', 'action'])
<div id="filterModal" class="modal-overlay">
    <div class="modal-content">
        <h2>Pilih Kategori</h2>
        <form method="GET" action="{{ $action }}">
            <div class="flex flex-wrap gap-3">
                @foreach ($kategoris as $kategori)
                    <label>
                        <input type="checkbox" name="kategori[]" value="{{ $kategori->id }}" {{ in_array($kategori->id, $kategoriIds ?? []) ? 'checked' : '' }}>
                        {{ $kategori->name }}
                    </label>
                @endforeach
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <x-button type="submit">Apply</x-button>
                <x-button :href="$action" color="gray">Reset</x-button>
                <x-button color="red" onclick="toggleFilter()">Tutup</x-button>
            </div>
        </form>
    </div>
</div>