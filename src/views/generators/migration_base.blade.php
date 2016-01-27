<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class {{$name}} extends Migration
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

        // Create table for associating scopes to permissions (Many-to-Many)
        Schema::create('{{ $permission_scope_table }}', function (Blueprint $table) {
            $table->integer('scope_id')->unsigned();
            $table->foreign('scope_id')
                  ->references('id')
                  ->on('scopes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permissions')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->primary(['scope_id', 'permission_id']);
        });

        Schema::create('{{ $scopes_table }}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating scopes to users (Many-to-Many)
        Schema::create('{{ $scope_user_table }}', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('scope_id')->unsigned();
            $table->foreign('scope_id')
                  ->references('id')
                  ->on('scopes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->primary(['user_id', 'scope_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ $permission_role_table }}');
        Schema::dropIfExists('{{ $permissions_table }}');
        Schema::dropIfExists('{{ $roles_table }}');
        Schema::dropIfExists('{{ $scopes_table }}');
        Schema::dropIfExists('{{ $scope_user_table }}');
    }
}
