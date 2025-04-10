<form action="{{ route('admin.artikel.store') }}" method="POST">
    @csrf
    <label>Judul:</label>
    <input type="text" name="title" required>

    <label>Isi:</label>
    <textarea name="content" required></textarea>

    <label>Slug:</label>
    <input type="text" name="slug" required>

    <button type="submit">Simpan</button>
</form>
