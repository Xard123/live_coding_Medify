<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriItemController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index(Request $request)
    {
        $query = KategoriItem::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        $kategoriItems = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('kategori_items.index', compact('kategoriItems'));
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('kategori_items.form', [
            'kategoriItem' => new KategoriItem(),
            'method' => 'new',
        ]);
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:255',
                'unique:kategori_items,code',
            ],
        ]);

        KategoriItem::create($validated);

        return redirect()
            ->route('kategori-items.index')
            ->with('success', 'Kategori item berhasil ditambahkan.');
    }

    /**
     * Detail kategori.
     */
    public function show(KategoriItem $kategoriItem)
    {
        $kategoriItem->load([
            'masterItems' => function ($query) {
                $query->orderBy('nama');
            }
        ]);

        return view('kategori_items.show', compact('kategoriItem'));
    }

    /**
     * Form edit kategori.
     */
    public function edit(KategoriItem $kategoriItem)
    {
        return view('kategori_items.form', [
            'kategoriItem' => $kategoriItem,
            'method' => 'edit',
        ]);
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, KategoriItem $kategoriItem)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_items', 'code')
                    ->ignore($kategoriItem->id),
            ],
        ]);

        $kategoriItem->update($validated);

        return redirect()
            ->route('kategori-items.index')
            ->with('success', 'Kategori item berhasil diperbarui.');
    }


    /**
     * Hapus kategori.
     */
    public function destroy(KategoriItem $kategoriItem)
    {
        $kategoriItem->masterItems()->detach();

        $kategoriItem->delete();

        return redirect()
            ->route('kategori-items.index')
            ->with('success', 'Kategori item berhasil dihapus.');
    }

    public function pdf(KategoriItem $kategoriItem)
    {
        $kategoriItem->load([
            'masterItems' => function ($query) {
                $query->orderBy('nama');
            }
        ]);

        $pdf = Pdf::loadView('kategori_items.pdf', [
            'kategoriItem' => $kategoriItem,
        ]);

        return $pdf->setPaper('a4', 'portrait')
            ->stream('kategori-' . $kategoriItem->code . '.pdf');
    }
}