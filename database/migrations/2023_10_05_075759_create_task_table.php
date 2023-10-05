<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->default(0);
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('task')->insert([
            'project_id' => 1,
            'name' => 'task 1',
            'sort_order' => 1,
            'created_at' => '2023-10-05 09:50:12',
        ]);
        DB::table('task')->insert([
            'project_id' => 2,
            'name' => 'task 2',
            'sort_order' => 2,
            'created_at' => '2023-10-05 09:50:12',
        ]);
        DB::table('task')->insert([
            'project_id' => 2,
            'name' => 'task 3',
            'sort_order' => 3,
            'created_at' => '2023-10-05 09:50:12',
        ]);
         DB::table('task')->insert([
            'project_id' => 2,
            'name' => 'task 4',
            'sort_order' => 4,
            'created_at' => '2023-10-05 09:50:12',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
