<?php

namespace Database\Seeders;

use App\Models\Privilege;
use Illuminate\Database\Seeder;

class SetupPrivileges extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Privilege::factory()->create([
            'name' => 'DASHBOARD_ROLES',
            'description' => 'Access to roles on the staff panel',
            'value' => 1 << 1
        ]);

        Privilege::factory()->create([
            'name' => 'ROLES_EDIT_MISC',
            'description' => 'Edit role descriptions, title, and colour',
            'value' => 1 << 2
        ]);

        Privilege::factory()->create([
            'name' => 'ROLES_EDIT_PRIVILEGES',
            'description' => 'Edit role privileges',
            'value' => 1 << 3
        ]);


        Privilege::factory()->create([
            'name' => 'DASHBOARD_PRIVILEGES',
            'description' => 'Access to privileges on the staff panel',
            'value' => 1 << 4
        ]);


        Privilege::factory()->create([
            'name' => 'PRIVILEGES_EDIT',
            'description' => 'Edit privileges descriptions',
            'value' => 1 << 5
        ]);


        Privilege::factory()->create([
            'name' => 'DASHBOARD_LOGS',
            'description' => 'Access to logs on the staff panel',
            'value' => 1 << 6
        ]);

        Privilege::factory()->create([
            'name' => 'LOGS_LOGIN',
            'description' => 'Access to login logs',
            'value' => 1 << 7
        ]);

        Privilege::factory()->create([
            'name' => 'LOGS_MODERATION',
            'description' => 'Access to moderation logs',
            'value' => 1 << 8
        ]);

        Privilege::factory()->create([
            'name' => 'LOGS_POSTS',
            'description' => 'Access to post & reply logs',
            'value' => 1 << 9
        ]);


        Privilege::factory()->create([
            'name' => 'LOGS_ACTIVITY',
            'description' => 'Access to activity logs',
            'value' => 1 << 10
        ]);


        Privilege::factory()->create([
            'name' => 'DASHBOARD_FEATURED',
            'description' => 'Access to featured content on the staff panel',
            'value' => 1 << 11
        ]);

        Privilege::factory()->create([
            'name' => 'FEATURED_EDIT',
            'description' => 'Remove and add posts to the featured list',
            'value' => 1 << 12
        ]);


        Privilege::factory()->create([
            'name' => 'DASHBOARD_MEMBERS',
            'description' => 'Access to members on the staff panel',
            'value' => 1 << 13
        ]);

        Privilege::factory()->create([
            'name' => 'MEMBERS_EDIT_PROFILE',
            'description' => 'Edit members profile',
            'value' => 1 << 14
        ]);

        Privilege::factory()->create([
            'name' => 'MEMBERS_EDIT_ROLES',
            'description' => 'Edit members roles',
            'value' => 1 << 15
        ]);

        Privilege::factory()->create([
            'name' => 'DASHBOARD_PUNISHMENTS',
            'description' => 'Access to punishments on the staff panel',
            'value' => 1 << 16
        ]);

        Privilege::factory()->create([
            'name' => 'PUNISHMENTS_ISSUE',
            'description' => 'Issue and remove punishments',
            'value' => 1 << 17
        ]);

        Privilege::factory()->create([
            'name' => 'FORUM_CREATE',
            'description' => 'Create new forums',
            'value' => 1 << 18
        ]);

        Privilege::factory()->create([
            'name' => 'FORUM_EDIT',
            'description' => 'Edit forums info',
            'value' => 1 << 19
        ]);

        Privilege::factory()->create([
            'name' => 'THREAD_EDIT',
            'description' => 'Edit thread contents from other users',
            'value' => 1 << 20
        ]);

        Privilege::factory()->create([
            'name' => 'POST_EDIT',
            'description' => 'Edit post contents from other users',
            'value' => 1 << 21
        ]);

        Privilege::factory()->create([
            'name' => 'TITLE_EDIT',
            'description' => 'Edit own title',
            'value' => 1 << 25
        ]);

        Privilege::factory()->create([
            'name' => 'NOT_GLOBAL_SITE',
            'description' => 'Used to ban members',
            'value' => 1 << 26
        ]);
    }
}
