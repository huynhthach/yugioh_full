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
        Schema::table('Recieptdetails', function (Blueprint $table) {
            // Loại bỏ ràng buộc khóa ngoại
            $table->dropForeign(['RecieptID']);
        });

        Schema::table('Receipt', function (Blueprint $table) {
            // Thay đổi cấu trúc của cột RecieptID
            $table->id('RecieptID')->change(); // Đặt RecieptID là khóa chính và tự tăng
        });

        Schema::table('Recieptdetails', function (Blueprint $table) {
            // Thiết lập lại ràng buộc khóa ngoại
            $table->foreign('RecieptID')->references('RecieptID')->on('Receipt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Trong phần rollback, chúng ta sẽ không hoàn tác các thay đổi cấu trúc cơ sở dữ liệu
        // vì một số thay đổi như thay đổi cột RecieptID thành id có thể gây ra mất mát dữ liệu.
        // Tuy nhiên, bạn có thể chỉ định các hành động rollback phù hợp với nhu cầu của bạn ở đây.
    }
};
