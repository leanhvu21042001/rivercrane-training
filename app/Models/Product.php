<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mst_products';

    protected $fillable = ['name', 'description', 'price', 'is_sales', 'image', 'is_delete'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_sale_text'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $lastProductId = DB::table('mst_products')
                ->orderByRaw("CAST(SUBSTRING(id, 2) AS UNSIGNED) DESC")
                ->first();

            $intId = 0;

            if (!empty($lastProductId)) {
                $intId = (int)substr($lastProductId->id, 1, 9);
            }

            $firstLetter = strtoupper(substr($product->name, 0, 1));
            $product->id = $firstLetter . str_pad($intId + 1, 9, '0', STR_PAD_LEFT);
        });
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNotDelete(Builder $query): Builder
    {
        return $query->where('is_delete', 0);
    }

    /**
     * @param Builder $query
     * @param mixed $name
     *
     * @return Builder
     */
    public function scopeByName(Builder $query, $name): Builder
    {
        if (!empty($name)) {
            return $query->where('name', 'LIKE', "%$name%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param mixed $status
     *
     * @return Builder
     */
    public function scopeByStatus(Builder $query, $status): Builder
    {
        if (is_numeric($status)) {
            return $query->where('is_sales', '=', $status);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param mixed $minPrice
     *
     * @return Builder
     */
    public function scopeByMinPrice(Builder $query, $minPrice): Builder
    {
        if (is_numeric($minPrice) && $minPrice > 0) {
            $query->where('price', '>=', $minPrice);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param mixed $maxPrice
     *
     * @return Builder
     */
    public function scopeByMaxPrice(Builder $query, $maxPrice): Builder
    {
        if (is_numeric($maxPrice) && $maxPrice > 0) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * @return string
     */
    public function getStatusSaleTextAttribute(): string
    {
        return [
            "Ngừng bán",
            "Đang bán",
            "Hết hàng",
        ][$this->is_sales];
    }
}
