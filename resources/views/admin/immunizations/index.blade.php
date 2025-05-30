@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4 text-primary">Data Vaksin Imunisasi</h4>

    {{-- Form Search --}}
    <form action="{{ route('admin.immunizations.index') }}" method="GET" class="mb-4">
        <div class="flex flex-wrap items-center gap-4 mb-4">
            <div class="flex-grow min-w-[250px]">
                <x-input-with-label
                    label=""
                    name="name"
                    type="text"
                    placeholder="Cari berdasarkan nama imunisasi..."
                    :value="request('name')"
                    class="h-10"
                />
            </div>

            <div class="flex gap-2 items-center">
                <x-button type="submit" class="bg-[#005f77] hover:bg-[#014f66] text-white h-10 flex items-center gap-2">
                    <i class="fas fa-search"></i> Cari
                </x-button>

                <x-button href="{{ route('admin.immunizations.index') }}" type="button" class="bg-gray-300 hover:bg-gray-400 text-black h-10 flex items-center gap-2">
                    <i class="fas fa-times-circle"></i> Reset
                </x-button>
            </div>

            <div class="ml-auto">
                <x-button href="{{ route('admin.immunizations.create') }}" type="button" class="bg-green-600 hover:bg-green-700 text-white h-10 flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i> Tambah Imunisasi
                </x-button>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto rounded shadow-sm">
        <table class="w-full border-collapse border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-center">
                <tr>
                    <th class="border border-gray-300 px-3 py-2 w-12">No</th>
                    <th class="border border-gray-300 px-3 py-2 w-1/4">Nama Imunisasi</th>
                    <th class="border border-gray-300 px-3 py-2 w-24">Usia</th>
                    <th class="border border-gray-300 px-3 py-2 w-2/5">Deskripsi</th>
                    <th class="border border-gray-300 px-3 py-2 w-1/5">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($immunizations as $immunization)
                    <tr class="text-center odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-left">{{ $immunization->name }}</td>
                        <td class="border border-gray-300 px-3 py-2">{{ $immunization->age }}</td>
                        <td class="border border-gray-300 px-3 py-2 text-left">{{ $immunization->description }}</td>
                        <td class="border border-gray-300 px-3 py-2">
                            <div class="flex justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.immunizations.edit', $immunization->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded"
                                   title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.immunizations.destroy', $immunization->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded"
                                            title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada data imunisasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
