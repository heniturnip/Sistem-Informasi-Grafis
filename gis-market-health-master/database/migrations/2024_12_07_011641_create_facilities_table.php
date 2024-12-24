<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama fasilitas
            $table->string('type'); // Jenis fasilitas (rumah sakit/pasar)
            $table->text('address'); // Alamat fasilitas
            $table->string('phone')->nullable(); // Nomor telepon (opsional)
            $table->string('jam_operasional')->nullable(); // Jam operasional (opsional)
            $table->string('jenis_pasar')->nullable(); // Jenis pasar (opsional)
            $table->text('fasilitas')->nullable(); // Fasilitas tambahan (opsional)
            $table->decimal('latitude', 10, 6); // Latitude
            $table->decimal('longitude', 10, 6); // Longitude
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
