<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\ProductGallery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'type', 'description', 'price', 'quantity'
    ];
    protected $hidden = [];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id');
    }

    /**
     * Update Data Product
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return Product
     */
    public function updateById(array $data, String $id): Product
    {
        $item = $this->findOrFail($id);
        $item->update($data);
        return $item;
    }

    /**
     * Delete Product By Id
     *
     * @param  mixed $id
     * @return bool
     */
    public function deleteById(String $id): bool
    {
        $item = $this->findOrFail($id);
        $item->delete();
        return true;
    }
}
