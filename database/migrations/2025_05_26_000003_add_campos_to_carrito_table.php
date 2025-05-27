<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('carrito', function (Blueprint $table) {
            $table->integer('cantidad')->default(1)->after('user_id');
            $table->decimal('precio_unitario', 10, 2)->nullable()->after('cantidad');
            $table->decimal('iva', 10, 2)->default(21)->after('precio_unitario');
        });
    }

    public function down()
    {
        Schema::table('carrito', function (Blueprint $table) {
            $table->dropColumn(['cantidad', 'precio_unitario', 'iva']);
        });
    }
};
