<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc');

        $query = MataKuliah::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($sort) {
            $query->orderBy($sort, $direction);
        }

        $mataKuliah = $query->paginate(10)->withQueryString();

        return Inertia::render('MataKuliah/Index', [
            'mataKuliah' => $mataKuliah->items(),
            'pagination' => [
                'current_page' => $mataKuliah->currentPage(),
                'last_page' => $mataKuliah->lastPage(),
                'per_page' => $mataKuliah->perPage(),
                'total' => $mataKuliah->total(),
                'next_page_url' => $mataKuliah->nextPageUrl(),
                'prev_page_url' => $mataKuliah->previousPageUrl(),
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
        return Inertia::render('MataKuliah/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|unique:mata_kuliah,kode',
            'nama' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('mata-kuliah.index')->with('message', 'Mata Kuliah berhasil ditambahkan');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return Inertia::render('MataKuliah/Edit', ['mataKuliah' => $mataKuliah]);
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode' => 'required|string|unique:mata_kuliah,kode,'.$mataKuliah->id,
            'nama' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('mata-kuliah.index')->with('message', 'Mata Kuliah berhasil diperbarui');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        DB::transaction(function () use ($mataKuliah) {
            Nilai::where('mata_kuliah_id', $mataKuliah->id)->delete();
            $mataKuliah->delete();
        });
        return redirect()->route('mata-kuliah.index')->with('message', 'Mata Kuliah berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        DB::transaction(function () use ($ids) {
            Nilai::whereIn('mata_kuliah_id', $ids)->delete();
            MataKuliah::whereIn('id', $ids)->delete();
        });
        return redirect()->route('mata-kuliah.index')->with('message', 'Mata Kuliah terpilih berhasil dihapus');
    }
}