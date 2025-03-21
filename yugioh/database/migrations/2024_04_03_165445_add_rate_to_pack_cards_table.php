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
        Schema::table('pack_cards', function (Blueprint $table) {
            $table->decimal('rate', 5, 2)->default(0); // Thêm trường rate với giá trị mặc định là 0
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pack_cards', function (Blueprint $table) {
            //
        });
    }
};
