<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ProgramStudiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc');

        $query = ProgramStudi::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($sort) {
            $query->orderBy($sort, $direction);
        }

        $programStudi = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return Inertia::render('ProgramStudi/Index', [
            'programStudi' => $programStudi->items(),
            'pagination' => [
                'current_page' => $programStudi->currentPage(),
                'last_page' => $programStudi->lastPage(),
                'per_page' => $programStudi->perPage(),
                'total' => $programStudi->total(),
                'next_page_url' => $programStudi->nextPageUrl(),
                'prev_page_url' => $programStudi->previousPageUrl(),
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
        return Inertia::render('ProgramStudi/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:program_studi,nama',
        ]);

        ProgramStudi::create($validated);

        return redirect()->route('program-studi.index')->with('message', 'Program Studi berhasil ditambahkan');
    }

    public function edit(ProgramStudi $programStudi)
    {
        return Inertia::render('ProgramStudi/Edit', ['programStudi' => $programStudi]);
    }

    public function update(Request $request, ProgramStudi $programStudi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:program_studi,nama,' . $programStudi->id,
        ]);

        $programStudi->update($validated);

        return redirect()->route('program-studi.index')->with('message', 'Program Studi berhasil diperbarui');
    }

    public function destroy(ProgramStudi $programStudi)
    {
        DB::transaction(function () use ($programStudi) {
            Mahasiswa::where('program_studi_id', $programStudi->id)->delete();
            $programStudi->delete();
        });
        return redirect()->route('program-studi.index')->with('message', 'Program Studi berhasil dihapus');
    }
    
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        DB::transaction(function () use ($ids) {
            Mahasiswa::whereIn('program_studi_id', $ids)->delete();
            ProgramStudi::whereIn('id', $ids)->delete();
        });
        return redirect()->route('program-studi.index')->with('message', 'Program Studi terpilih berhasil dihapus');
    }
}