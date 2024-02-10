<?php

use Eav\Entity;
use Eav\Attribute;
use Eav\AttributeSet;
use Eav\AttributeGroup;
use Eav\EntityAttribute;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealEstateEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		Schema::create('real_estate_text', function (Blueprint $table) {
            $table->increments('value_id')->comment('Value ID');
            $table->smallInteger('entity_type_id')->unsigned()->default(0)->comment('Entity Type ID');
            $table->integer('attribute_id')->unsigned()->default(0)->comment('Attribute ID');
            $table->bigInteger('entity_id')->unsigned()->default(0)->comment('Entity ID');

            $table->text('value')->default(NULL)->nullable()->comment('Value');

            $table->foreign('entity_id')
            	  ->references('id')->on('real_estates')
				  ->onDelete('cascade');

            $table->unique(['entity_id','attribute_id']);
			$table->index('attribute_id');
			$table->index('entity_id');
        });

		Schema::create('real_estate_string', function (Blueprint $table) {
            $table->increments('value_id')->comment('Value ID');
            $table->smallInteger('entity_type_id')->unsigned()->default(0)->comment('Entity Type ID');
            $table->integer('attribute_id')->unsigned()->default(0)->comment('Attribute ID');
            $table->bigInteger('entity_id')->unsigned()->default(0)->comment('Entity ID');

            $table->string('value')->default(NULL)->nullable()->comment('Value');

            $table->foreign('entity_id')
            	  ->references('id')->on('real_estates')
				  ->onDelete('cascade');

            $table->unique(['entity_id','attribute_id']);
			$table->index('attribute_id');
			$table->index('entity_id');
        });

		Schema::create('real_estate_json', function (Blueprint $table) {
            $table->increments('value_id')->comment('Value ID');
            $table->smallInteger('entity_type_id')->unsigned()->default(0)->comment('Entity Type ID');
            $table->integer('attribute_id')->unsigned()->default(0)->comment('Attribute ID');
            $table->bigInteger('entity_id')->unsigned()->default(0)->comment('Entity ID');

            $table->json('value')->default(NULL)->nullable()->comment('Value');

            $table->foreign('entity_id')
            	  ->references('id')->on('real_estates')
				  ->onDelete('cascade');

            $table->unique(['entity_id','attribute_id']);
			$table->index('attribute_id');
			$table->index('entity_id');
        });


        $entity = Entity::create([
        	'entity_code' => 'real_estate',
        	'entity_class' => 'App\Models\RealEstate',
        	'entity_table' => 'real_estates',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('real_estate_text');

		Schema::drop('real_estate_string');

		Schema::drop('real_estate_json');

        $entity = Entity::where('entity_code', '=', 'real_estate');
        $entity->delete();
    }
}
