<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_products', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->tinyInteger('is_sales')->comment('0: Ngừng bán, 1: Đang bán, 2: Hết hàng');
            $table->string('image')->nullable();
            $table->tinyInteger('is_delete')->default(0)->comment('0: Bình thường , 1 : Đã xóa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_products');
    }
};
