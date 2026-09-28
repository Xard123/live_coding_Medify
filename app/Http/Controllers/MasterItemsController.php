<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $query = MasterItem::with('categories:id,name,code')
            ->when($request->kode, fn ($q, $value) => $q->where('kode', $value))
            ->when($request->nama, fn ($q, $value) => $q->where('nama', 'like', '%' . $value . '%'))
            ->when($request->filled('hargamin'), fn ($q) => $q->where('harga_beli', '>=', $request->hargamin))
            ->when($request->filled('hargamax'), fn ($q) => $q->where('harga_beli', '<=', $request->hargamax))
            ->orderBy('id');

        return response()->json([
            'status' => 200,
            'data' => $query->get(),
        ]);
    }

    public function formView($method, $id = 0)
    {
        $item = $method === 'new'
            ? new MasterItem()
            : MasterItem::with('categories')->findOrFail($id);

        return view('master_items.form.index', [
            'item' => $item,
            'method' => $method,
            'categories' => KategoriItem::orderBy('name')->get(['id', 'name', 'code']),
        ]);
    }

    public function singleView($kode)
    {
        $data = MasterItem::with('categories')->where('kode', $kode)->firstOrFail();

        return view('master_items.single.index', compact('data'));
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'laba' => ['required', 'numeric', 'min:0'],
            'supplier' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:kategori_items,id'],
        ]);

        if ($method === 'new') {
            $data_item = new MasterItem();
            $data_item->kode = str_pad((int) MasterItem::max('id') + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $data_item = MasterItem::findOrFail($id);
        }

        $data_item->nama = $validated['nama'];
        $data_item->harga_beli = $validated['harga_beli'];
        $data_item->laba = $validated['laba'];
        $data_item->supplier = $validated['supplier'];
        $data_item->jenis = $validated['jenis'];

        if ($request->hasFile('foto')) {
            if ($data_item->foto) {
                Storage::disk('public')->delete($data_item->foto);
            }
            $data_item->foto = $request->file('foto')->store('master-items', 'public');
        }

        $data_item->save();
        $data_item->categories()->sync($validated['category_ids'] ?? []);

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::findOrFail($id);

        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->categories()->detach();
        $item->delete();

        return redirect('master-items');
    }

    public function excel(): StreamedResponse
    {
        $items = MasterItem::with('categories:id,name')
            ->orderBy('id')
            ->get();

        return response()->streamDownload(function () use ($items) {
            echo '<?xml version="1.0"?>';
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
                xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
            echo '<Worksheet ss:Name="Master Items"><Table>';

            $headers = ['No', 'Nama kategori', 'Nama items', 'Nama supplier', 'Harga', 'Laba', 'Harga jual'];
            echo '<Row>';
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($header, ENT_XML1) . '</Data></Cell>';
            }
            echo '</Row>';

            foreach ($items as $index => $item) {
                $categoryName = $item->categories->pluck('name')->implode(', ');
                $values = [
                    $index + 1,
                    $categoryName,
                    $item->nama,
                    $item->supplier,
                    $item->harga_beli,
                    $item->laba,
                    $item->harga_jual,
                ];

                echo '<Row>';
                foreach ($values as $value) {
                    $type = is_numeric($value) ? 'Number' : 'String';
                    echo '<Cell><Data ss:Type="' . $type . '">' . htmlspecialchars((string) $value, ENT_XML1) . '</Data></Cell>';
                }
                echo '</Row>';
            }

            echo '</Table></Worksheet></Workbook>';
        }, 'master-items.xls', [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();

        foreach ($data as $item) {
            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = str_pad($item->id, 5, '0', STR_PAD_LEFT);
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        return ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'][rand(0, 4)];
    }

    private function getRandomJenis()
    {
        return ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'][rand(0, 4)];
    }
}
