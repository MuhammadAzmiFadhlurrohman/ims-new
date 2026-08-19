<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->integer('port')->default(8728);
            $table->string('username')->default('admin');
            $table->text('password')->nullable();
            $table->boolean('use_ssl')->default(false);
            $table->string('pop_code', 50)->nullable();
            $table->string('model')->nullable();
            $table->string('ros_version')->nullable();
            $table->string('status')->default('unknown'); // online, offline, error, unknown
            $table->timestamp('last_connected_at')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('pop_code')->references('code')->on('pops')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
