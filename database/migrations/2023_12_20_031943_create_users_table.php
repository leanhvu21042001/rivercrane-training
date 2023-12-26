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
        Schema::create('mst_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->string('group_role', 50);
            $table->rememberToken();
            $table->string('verify_email', 100)->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('0: Không hoạt động , 1 : Hoạt động');
            $table->tinyInteger('is_delete')->default(0)->comment('0: Bình thường , 1 : Đã xóa');
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 40)->nullable();
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
        Schema::dropIfExists('mst_users');
    }
};
