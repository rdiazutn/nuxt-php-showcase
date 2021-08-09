<?php

namespace Database\Seeders;

use App\Permission\AbstractPermission;
use Illuminate\Database\Seeder;
use ReflectionClass;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    const GUARD = 'sanctum';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::query()->upsert(
                AbstractPermission::permissions()
                    ->map(fn ($permission) => [
                        'name' => $permission,
                        'guard_name' => self::GUARD
                    ])
                    ->toArray(),
                'name'
            );

        $roles = collect([
            'customer' => AbstractPermission::permissions()
        ]);

        $roles->each(fn ($permissions, $name) => Role::findOrCreate($name, self::GUARD)->givePermissionTo($permissions));
    }
}
