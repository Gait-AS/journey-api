<?php

use App\Models\Team;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('assigned_to')->constrained('users');
            $table->enum('status', ['todo', 'doing', 'review', 'done'])->default('todo');
            $table->foreignIdFor(Team::class);
            $table->string('completed_at')->nullable();

            // created_at updated_at
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
        //
    }
};
