<?php

namespace Database\Seeders;

use App\Models\Privilege;
use App\Models\Role;
use Illuminate\Database\Seeder;

class SetupRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DASHBOARD_ROLES = Privilege::where(['name' => "DASHBOARD_ROLES"])->first();
        $ROLES_EDIT = Privilege::where(['name' => "ROLES_EDIT"])->first();

        $DASHBOARD_PRIVILEGES = Privilege::where(['name' => "DASHBOARD_PRIVILEGES"])->first();
        $PRIVILEGES_EDIT = Privilege::where(['name' => "PRIVILEGES_EDIT"])->first();

        $DASHBOARD_LOGS = Privilege::where(['name' => "DASHBOARD_LOGS"])->first();
        $LOGS_LOGIN = Privilege::where(['name' => "LOGS_LOGIN"])->first();
        $LOGS_MODERATION = Privilege::where(['name' => "LOGS_MODERATION"])->first();
        $LOGS_POSTS = Privilege::where(['name' => "LOGS_POSTS"])->first();
        $LOGS_ACTIVITY = Privilege::where(['name' => "LOGS_ACTIVITY"])->first();

        $DASHBOARD_FEATURED = Privilege::where(['name' => "DASHBOARD_FEATURED"])->first();
        $FEATURED_EDIT = Privilege::where(['name' => "FEATURED_EDIT"])->first();

        $DASHBOARD_MEMBERS = Privilege::where(['name' => "DASHBOARD_MEMBERS"])->first();
        $MEMBERS_EDIT_PROFILE = Privilege::where(['name' => "MEMBERS_EDIT_PROFILE"])->first();
        $MEMBERS_EDIT_ROLES = Privilege::where(['name' => "MEMBERS_EDIT_ROLES"])->first();

        $DASHBOARD_PUNISHMENTS = Privilege::where(['name' => "DASHBOARD_PUNISHMENTS"])->first();
        $PUNISHMENTS_ISSUE = Privilege::where(['name' => "PUNISHMENTS_ISSUE"])->first();

        $FORUM_CREATE = Privilege::where(['name' => "FORUM_CREATE"])->first();
        $FORUM_EDIT = Privilege::where(['name' => "FORUM_EDIT"])->first();
        $FORUM_LOCK = Privilege::where(['name' => "FORUM_LOCK"])->first();
        $FORUM_CLOAK = Privilege::where(['name' => "FORUM_CLOAK"])->first();
        $THREAD_EDIT = Privilege::where(['name' => "THREAD_EDIT"])->first();
        $THREAD_LOCK = Privilege::where(['name' => "THREAD_LOCK"])->first();
        $THREAD_CLOAK = Privilege::where(['name' => "THREAD_CLOAK"])->first();
        $POST_EDIT = Privilege::where(['name' => "POST_EDIT"])->first();

        $FORUM_CLOAK_STAFF = Privilege::where(['name' => "FORUM_CLOAK_STAFF"])->first();
        $FORUM_LOCK_STAFF = Privilege::where(['name' => "FORUM_LOCK_STAFF"])->first();
        $THREAD_CLOAK_STAFF = Privilege::where(['name' => "THREAD_CLOAK_STAFF"])->first();
        $THREAD_LOCK_STAFF = Privilege::where(['name' => "THREAD_LOCK_STAFF"])->first();

        $TITLE_EDIT = Privilege::where(['name' => "TITLE_EDIT"])->first();
        $NOT_GLOBAL_SITE = Privilege::where(['name' => "NOT_GLOBAL_SITE"])->first();

        Role::factory()->create([
            'name' => 'ADMIN',
            'description' => 'Access to everything',
            'title' => 'Administrator',
            'colour' => '#0079FF',
            'weight' => 1000,
            'privilege' =>
                $DASHBOARD_ROLES->value | $ROLES_EDIT->value |  $DASHBOARD_PRIVILEGES->value | $PRIVILEGES_EDIT->value |
                $DASHBOARD_LOGS->value | $LOGS_LOGIN->value | $LOGS_MODERATION->value | $LOGS_POSTS->value | $LOGS_ACTIVITY->value |
                $DASHBOARD_FEATURED->value | $FEATURED_EDIT->value |
                $DASHBOARD_MEMBERS->value | $MEMBERS_EDIT_PROFILE->value | $MEMBERS_EDIT_ROLES->value |
                $DASHBOARD_PUNISHMENTS->value | $PUNISHMENTS_ISSUE->value | $FORUM_CREATE->value | $FORUM_EDIT->value |
                $FORUM_LOCK->value | $FORUM_CLOAK->value | $THREAD_LOCK->value | $THREAD_CLOAK->value |
                $THREAD_EDIT->value | $POST_EDIT->value | $FORUM_CLOAK_STAFF->value | $FORUM_LOCK_STAFF->value
        ]);

        Role::factory()->create([
            'name' => 'MODERATOR',
            'description' => 'Access to moderation tools',
            'title' => 'Moderator',
            'colour' => '#00DFA2',
            'weight' => 900,
            'privilege' =>
                $DASHBOARD_LOGS->value | $LOGS_MODERATION->value | $LOGS_POSTS->value | $LOGS_ACTIVITY->value |
                $DASHBOARD_MEMBERS->value | $MEMBERS_EDIT_PROFILE->value |
                $DASHBOARD_PUNISHMENTS->value | $PUNISHMENTS_ISSUE->value | $THREAD_EDIT->value | $POST_EDIT->value

        ]);

        Role::factory()->create([
            'name' => 'STAFF',
            'description' => 'Part of the staff team',
            'title' => 'Staff',
            'colour' => null,
            'weight' => 500,
            'privilege' => $TITLE_EDIT->value | $THREAD_CLOAK_STAFF->value | $THREAD_LOCK_STAFF->value,
        ]);

        Role::factory()->create([
            'name' => 'MEMBER',
            'description' => 'A member',
            'title' => 'Member',
            'colour' => 'gray',
            'weight' => 100,
            'privilege' => 0,
        ]);

        Role::factory()->create([
            'name' => 'BANNED',
            'description' => 'Banned from the site',
            'title' => 'Member',
            'colour' => 'gray',
            'weight' => 0,
            'privilege' => $NOT_GLOBAL_SITE->value
        ]);


    }
}
