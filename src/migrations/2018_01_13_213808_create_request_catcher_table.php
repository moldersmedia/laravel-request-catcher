<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateRequestCatcherTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('request_catches', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('status_code');
                $table->text('headers');
                $table->text('input');
                $table->string('locale', 2);
                $table->boolean('is_secure');
                $table->text('url');
                $table->string('method', 10);
                $table->integer('tries')->default(0);
                $table->integer('parent_id')->nullable();
                $table->integer('_id')->nullable();
                $table->timestamp('successful_at')->nullable();
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
            Schema::dropIfExists('request_catches');
        }
    }
