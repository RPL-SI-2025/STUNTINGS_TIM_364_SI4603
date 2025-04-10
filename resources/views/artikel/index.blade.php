@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 40px auto; font-family: sans-serif;">
    <h1 style="text-align: center; font-size: 32px;">📚 Daftar Artikel</h1>

    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('admin.artikel.create') }}" 
           style="background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
           + Tambah Artikel
        </a>
    </div>

    @if (session('success'))
        <div style="color: green; background-color: #e7f7ea; padding: 10px; border-left: 5px solid green; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 12px; border: 1px solid #ddd;">Judul</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Isi</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($artikels as $artikel)
                <tr>
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ $artikel->title }}</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">{{ Str::limit($artikel->content, 50) }}</td>
                    <td style="padding: 12px; border: 1px solid #ddd;">
                        <a href="{{ route('admin.artikel.edit', $artikel->id) }}" 
                           style="margin-right: 10px; color: #2196F3;">Edit</a>

                        <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="color: red; background: none; border: none; cursor: pointer;"
                                    onclick="return confirm('Yakin hapus?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 20px;">Belum ada artikel.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
