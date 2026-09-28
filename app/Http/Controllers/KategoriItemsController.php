<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use App\Models\MasterItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriItemsController extends Controller
{
    public function index()
    {
        return view('kategori_items.index.index');
    }

    public function search(Request $request)
    {
        $query = KategoriItem::withCount('masterItems')
            ->when($request->name, fn ($q, $value) => $q->where('name', 'like', '%' . $value . '%'))
            ->when($request->code, fn ($q, $value) => $q->where('code', 'like', '%' . $value . '%'))
            ->orderBy('name');

        return response()->json([
            'status' => 200,
            'data' => $query->get(),
        ]);
    }

    public function formView($method, $id = 0)
    {
        $item = $method === 'new'
            ? new KategoriItem()
            : KategoriItem::with('masterItems')->findOrFail($id);

        return view('kategori_items.form.index', [
            'item' => $item,
            'method' => $method,
            'masterItems' => MasterItem::orderBy('nama')->get(['id', 'kode', 'nama']),
        ]);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_items', 'code')->ignore($id ?: null),
            ],
            'master_item_ids' => ['nullable', 'array'],
            'master_item_ids.*' => ['integer', 'exists:master_items,id'],
        ]);

        $category = $method === 'new'
            ? new KategoriItem()
            : KategoriItem::findOrFail($id);

        $category->name = $validated['name'];
        $category->code = $validated['code'];
        $category->save();
        $category->masterItems()->sync($validated['master_item_ids'] ?? []);

        return redirect('kategori-items');
    }

    public function singleView($id)
    {
        $data = KategoriItem::with('masterItems')->findOrFail($id);

        return view('kategori_items.single.index', compact('data'));
    }

    public function delete($id)
    {
        $category = KategoriItem::findOrFail($id);
        $category->masterItems()->detach();
        $category->delete();

        return redirect('kategori-items');
    }

    public function pdf($id)
    {
        $data = KategoriItem::with('masterItems')->findOrFail($id);

        $pdf = Pdf::loadView('kategori_items.pdf', [
            'data' => $data,
            'printedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('kategori-' . $data->code . '.pdf');
    }
}
