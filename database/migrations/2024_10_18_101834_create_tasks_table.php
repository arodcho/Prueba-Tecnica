<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); 
            $table->dateTime('start'); 
            $table->dateTime('end'); 
            $table->unsignedBigInteger('user_id'); 
            $table->string('task_description'); 
            $table->unsignedBigInteger('project_id'); 

         
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade'); 

            $table->timestamps(); 
        });
    }

       /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tasks'); 
    }
}
