<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));

            $permissions =[
                // User
                ['name' => 'add-user'],
                ['name' => 'list-user'],
                ['name' => 'show-user'],
                ['name' => 'edit-user'],
                ['name' => 'delete-user'],

                // Course
                ['name' => 'add-course'],
                ['name' => 'list-course'],
                ['name' => 'show-course'],
                ['name' => 'edit-course'],
                ['name' => 'delete-course'],

                // Chapter
                ['name' => 'add-chapter'],
                ['name' => 'list-chapter'],
                ['name' => 'show-chapter'],
                ['name' => 'edit-chapter'],
                ['name' => 'delete-chapter'],

                // Video
                ['name' => 'add-video'],
                ['name' => 'list-video'],
                ['name' => 'show-video'],
                ['name' => 'edit-video'],
                ['name' => 'delete-video'],

                // order
                ['name' => 'add-order'],
                ['name' => 'list-order'],
                ['name' => 'show-order'],
                ['name' => 'edit-order'],
                ['name' => 'delete-order'],
    
            ];

            $tutor_permissions = [
                'add-course', 'list-course', 'show-course', 'edit-course', 'delete-course',
                'add-course', 'list-course', 'show-course', 'edit-course', 'delete-course',
                'add-video', 'list-video', 'show-video', 'edit-video', 'delete-video',
            ];

            $user_permissions = ['show-course'];

    
            $admin = User::find(1);
    
            foreach ($permissions as $permission){
                Permission::create(['name' => $permission['name'], "guard_name"=>'web']);
            }
            $roles =[
                ['name' => 'admin', 'permissions'=>$permissions],
                ['name' => 'tutor', 'permissions' => $tutor_permissions],
                ['name' => 'user', 'permissions' => $user_permissions],
            ];

    
            foreach ($roles as $role){
                $created_role = Role::create(['name' => $role['name'], "guard_name"=>'web']);
                $created_role->givePermissionTo($role['permissions']);
            }

            $admin->assignRole('admin', 'tutor', 'user');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
