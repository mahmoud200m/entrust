<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('{{ $roles_table }}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('{{ $roleUserPivotTable['name'] }}', function (Blueprint $table) {
            @foreach ($roleUserPivotTable['fkeys'] as $fkey)
            $table->integer('{{$fkey['fkey']}}')->unsigned();
            $table->foreign('{{$fkey['fkey']}}')->references('{{ $fkey['pkey'] }}')->on('{{ $fkey['name'] }}')
            ->onUpdate('cascade')->onDelete('cascade');
            @endforeach
            $table->primary(['{{$roleUserPivotTable['fkeys'][0]['fkey']}}', '{{$roleUserPivotTable['fkeys'][1]['fkey']}}']);
        });

        // Create table for storing permissions
        Schema::create('{{ $permissions_table }}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('{{ $permission_role_table }}', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('{{ $permissions_table }}')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('{{ $roles_table }}')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $permission_role_table }}');
        Schema::drop('{{ $permissions_table }}');
        Schema::drop('{{ $roleUserPivotTable['name'] }}');
        Schema::drop('{{ $roles_table }}');
    }
}
