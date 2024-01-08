<?php

namespace App\Models;

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

    // TODO: Hỏi anh mentor hướng tốt hơn
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
}
