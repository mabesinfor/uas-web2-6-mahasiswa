<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc');

        $query = Nilai::with(['mahasiswa', 'mataKuliah']);

        if ($search) {
            $query->where('mahasiswa_id', 'like', "%{$search}%");
        }

        if ($sort) {
            $query->orderBy($sort, $direction);
        }

        $nilai = $query->paginate(10, ['*'], 'page', $page)->withQueryString();
        return Inertia::render('Nilai/Index', [
            'nilai' => $nilai->items(),
            'pagination' => [
                'current_page' => $nilai->currentPage(),
                'last_page' => $nilai->lastPage(),
                'per_page' => $nilai->perPage(),
                'total' => $nilai->total(),
                'next_page_url' => $nilai->nextPageUrl(),
                'prev_page_url' => $nilai->previousPageUrl(),
            ],
            'search' => $search,
            'sort' => [
                'column' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        $mataKuliah = MataKuliah::all();
        return Inertia::render('Nilai/Create', [
            'mahasiswa' => $mahasiswa,
            'mataKuliah' => $mataKuliah
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        Nilai::create($validated);

        return redirect()->route('nilai.index')->with('message', 'Nilai berhasil ditambahkan');
    }

    public function edit(Nilai $nilai)
    {
        $mahasiswa = Mahasiswa::all();
        $mataKuliah = MataKuliah::all();
        return Inertia::render('Nilai/Edit', [
            'nilai' => $nilai,
            'mahasiswa' => $mahasiswa,
            'mataKuliah' => $mataKuliah
        ]);
    }

    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $nilai->update($validated);

        return redirect()->route('nilai.index')->with('message', 'Nilai berhasil diperbarui');
    }

    public function destroy(Nilai $nilai)
    {
        DB::transaction(function () use ($nilai) {
            $nilai->delete();
        });
        return redirect()->route('nilai.index')->with('message', 'Nilai berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        DB::transaction(function () use ($ids) {
            Nilai::whereIn('id', $ids)->delete();
        });
        return redirect()->route('nilai.index')->with('message', 'Nilai terpilih berhasil dihapus');
    }
}