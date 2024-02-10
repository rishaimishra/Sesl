<?php

use Eav\Entity;
use Eav\Attribute;
use Eav\AttributeSet;
use Eav\AttributeGroup;
use Eav\EntityAttribute;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('auto_text', function (Blueprint $table) {
            $table->increments('value_id')->comment('Value ID');
            $table->smallInteger('entity_type_id')->unsigned()->default(0)->comment('Entity Type ID');
            $table->integer('attribute_id')->unsigned()->default(0)->comment('Attribute ID');
            $table->bigInteger('entity_id')->unsigned()->default(0)->comment('Entity ID');

            $table->text('value')->default(NULL)->nullable()->comment('Value');

            $table->foreign('entity_id')
            	  ->references('id')->on('autos')
				  ->onDelete('cascade');

            $table->unique(['entity_id','attribute_id']);
			$table->index('attribute_id');
			$table->index('entity_id');
        });

		Schema::create('auto_string', function (Blueprint $table) {
            $table->increments('value_id')->comment('Value ID');
            $table->smallInteger('entity_type_id')->unsigned()->default(0)->comment('Entity Type ID');
            $table->integer('attribute_id')->unsigned()->default(0)->comment('Attribute ID');
            $table->bigInteger('entity_id')->unsigned()->default(0)->comment('Entity ID');

            $table->string('value')->default(NULL)->nullable()->comment('Value');

            $table->foreign('entity_id')
            	  ->references('id')->on('autos')
				  ->onDelete('cascade');

            $table->unique(['entity_id','attribute_id']);
			$table->index('attribute_id');
			$table->index('entity_id');
        });

		Schema::create('auto_json', function (Blueprint $table) {
            $table->increments('value_id')->comment('Value ID');
            $table->smallInteger('entity_type_id')->unsigned()->default(0)->comment('Entity Type ID');
            $table->integer('attribute_id')->unsigned()->default(0)->comment('Attribute ID');
            $table->bigInteger('entity_id')->unsigned()->default(0)->comment('Entity ID');

            $table->json('value')->default(NULL)->nullable()->comment('Value');

            $table->foreign('entity_id')
            	  ->references('id')->on('autos')
				  ->onDelete('cascade');

            $table->unique(['entity_id','attribute_id']);
			$table->index('attribute_id');
			$table->index('entity_id');
        });


        $entity = Entity::create([
        	'entity_code' => 'auto',
        	'entity_class' => '\App\ModelsAuto',
        	'entity_table' => 'autos',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

		Schema::drop('auto_text');

		Schema::drop('auto_string');

		Schema::drop('auto_json');

        $entity = Entity::where('entity_code', '=', 'auto');
        $entity->delete();

    }
}
