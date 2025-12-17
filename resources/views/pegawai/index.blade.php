@extends('base')
@section('title','Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')
@section('content')

{{-- bagian alert --}}
@if (session('berhasil'))
    <div class="mb-4 flex justify-between rounded-lg bg-green-50 p-4 text-sm text-green-800" role="alert">
        <div>
            {{ session('berhasil') }}
        </div>
        <button type="button" class="ml-auto text-green-800 hover:text-green-900 font-bold" onclick="this.parentElement.style.display='none'">
            &times; </button>
    </div>
@endif

@if (session('delete'))
    <div class="mb-4 flex justify-between rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">
        <div>
            {{ session('delete') }}
        </div>
        <button type="button" class="ml-auto text-red-800 hover:text-red-900 font-bold" onclick="this.parentElement.style.display='none'">
            &times; </button>
    </div>
@endif

@if (session('gagal'))
    <div class="mb-4 flex justify-between rounded-lg bg-red-50 p-4 text-sm text-red-800" role="alert">
        <div>
            {{ session('gagal') }}
        </div>
        <button type="button" class="ml-auto text-red-800 hover:text-red-900 font-bold" onclick="this.parentElement.style.display='none'">
            &times; </button>
    </div>
@endif
{{-- akhir bagian alert --}}


    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">pegawai</h1>
        <div class="mx-auto max-w-screen-xl">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('pegawai.add') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                    Tambah Data
                </a>
                <form class="flex w-full max-w-sm gap-2" autocomplete="off">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Masukkan kata kunci..." class="w-full rounded-md border px-3 py-2 text-sm">
                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700 cursor-pointer">
                        Cari
                    </button>
                </form>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-x divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700" width="1">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama pekerjaan</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">gender</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700" width="1"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($data as $k => $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $data->firstitem() + $k }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->email }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->pekerjaan->nama ?? 'pekerjaan kosong' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->gender }}</td>
                            <td class="px-4 py-3 text-center text-gray-600">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="{{ route('pegawai.edit', ['id' => $d->id]) }}" class="cursor-pointer rounded-l-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('pegawai.destroy', ['id' => $d->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer rounded-r-md border border-l-0 border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        kosong
                        @endforelse
                    </tbody>

                </table>
            </div>
            <div class="mt-4">
                {{ $data->links() }}
            </div>

        </div>
    </section>
@endsection
