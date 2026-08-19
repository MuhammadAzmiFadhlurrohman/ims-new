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
        Schema::create('installation_pipelines', function (Blueprint $table) {
            $table->string('code', 50)->primary();
            $table->string('internet_number', 50);
            
            // Verifikasi
            $table->date('verified_at')->nullable();
            $table->text('verified_note')->nullable();

            // Survei
            $table->date('survey_scheduled_at')->nullable();
            $table->string('survey_team')->nullable();
            $table->text('survey_note')->nullable();
            $table->date('survey_finished_at')->nullable();
            $table->text('survey_doc_path')->nullable();

            // Instalasi Lapangan
            $table->date('installation_scheduled_at')->nullable();
            $table->string('installation_team')->nullable();
            $table->text('installation_note')->nullable();
            $table->date('installation_finished_at')->nullable();
            $table->text('installation_doc_path')->nullable();

            // Aktivasi
            $table->date('activation_scheduled_at')->nullable();
            $table->string('activation_team')->nullable();
            $table->text('activation_note')->nullable();
            $table->date('activation_finished_at')->nullable();
            $table->text('activation_doc_path')->nullable();

            // Foto Bukti Lapangan
            $table->text('house_photo')->nullable();
            $table->text('id_card_photo')->nullable();
            $table->text('map_photo')->nullable();

            $table->timestamps();

            $table->foreign('internet_number')->references('internet_number')->on('customer_subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installation_pipelines');
    }
};
