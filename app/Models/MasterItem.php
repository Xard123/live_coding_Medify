<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode', 'nama', 'harga_beli', 'laba', 'supplier', 'jenis', 'foto'
    ];

    public function categories()
    {
        return $this->belongsToMany(
            KategoriItem::class,
            'kategori_item_master_item',
            'master_item_id',
            'kategori_item_id'
        );
    }

    public function getHargaJualAttribute()
    {
        return round($this->harga_beli + ($this->harga_beli * $this->laba / 100));
    }
}