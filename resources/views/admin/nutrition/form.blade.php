
<div class="mb-3">
    <label>Nama Menu</label>
    <input type="text" name="name" value="{{ old('name', $menu->name ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Nutrisi</label>
    <textarea name="nutrition" class="form-control" required>{{ old('nutrition', $menu->nutrition ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Bahan-bahan</label>
    <textarea name="ingredients" class="form-control" required>{{ old('ingredients', $menu->ingredients ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Cara Membuat</label>
    <textarea name="instructions" class="form-control" required>{{ old('instructions', $menu->instructions ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label>Kategori</label>
    <select name="category" class="form-control" required>
        @foreach(['pagi', 'siang', 'malam', 'snack'] as $kategori)
            <option value="{{ $kategori }}" {{ (old('category', $menu->category ?? '') == $kategori) ? 'selected' : '' }}>{{ ucfirst($kategori) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Upload Gambar</label>
    <input type="file" name="image" class="form-control">
    @if (!empty($menu->image))
        <p>Gambar Saat Ini:</p>
        <img src="{{ asset('storage/' . $menu->image) }}" width="200">
    @endif
</div>
