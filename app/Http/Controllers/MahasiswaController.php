<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc');

        $query = Mahasiswa::with('programStudi');

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($sort) {
            $query->orderBy($sort, $direction);
        }

        $mahasiswa = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return Inertia::render('Mahasiswa/Index', [
            'mahasiswa' => $mahasiswa->items(),
            'pagination' => [
                'current_page' => $mahasiswa->currentPage(),
                'last_page' => $mahasiswa->lastPage(),
                'per_page' => $mahasiswa->perPage(),
                'total' => $mahasiswa->total(),
                'next_page_url' => $mahasiswa->nextPageUrl(),
                'prev_page_url' => $mahasiswa->previousPageUrl(),
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
        $programStudi = ProgramStudi::all();
        return Inertia::render('Mahasiswa/Create', ['programStudi' => $programStudi]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswa,nim',
            'program_studi_id' => 'required|exists:program_studi,id',
        ]);

        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')->with('message', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $programStudi = ProgramStudi::all();
        return Inertia::render('Mahasiswa/Edit', [
            'mahasiswa' => $mahasiswa,
            'programStudi' => $programStudi
        ]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswa,nim,'.$mahasiswa->id,
            'program_studi_id' => 'required|exists:program_studi,id',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')->with('message', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        DB::transaction(function () use ($mahasiswa) {
            Nilai::where('mahasiswa_id', $mahasiswa->id)->delete();
            $mahasiswa->delete();
        });
        return redirect()->route('mahasiswa.index')->with('message', 'Mahasiswa berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        DB::transaction(function () use ($ids) {
            Nilai::whereIn('mahasiswa_id', $ids)->delete();
            Mahasiswa::whereIn('id', $ids)->delete();
        });
        return redirect()->route('mahasiswa.index')->with('message', 'Mahasiswa terpilih berhasil dihapus');
    }
}