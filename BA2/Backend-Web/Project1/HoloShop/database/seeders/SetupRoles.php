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
        $ROLES_EDIT_DESC = Privilege::where(['name' => "ROLES_EDIT_DESC"])->first();
        $ROLES_EDIT_PRIVILEGES = Privilege::where(['name' => "ROLES_EDIT_PRIVILEGES"])->first();

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
        $MEMBERS_EDIT_DATA = Privilege::where(['name' => "MEMBERS_EDIT_DATA"])->first();

        $DASHBOARD_PUNISHMENTS = Privilege::where(['name' => "DASHBOARD_PUNISHMENTS"])->first();
        $PUNISHMENTS_ISSUE = Privilege::where(['name' => "PUNISHMENTS_ISSUE"])->first();

        $TITLE_EDIT = Privilege::where(['name' => "TITLE_EDIT"])->first();
        $NOT_GLOBAL_SITE = Privilege::where(['name' => "NOT_GLOBAL_SITE"])->first();

        Role::factory()->create([
            'name' => 'ADMIN',
            'description' => 'Access to everything',
            'title' => 'Administrator',
            'colour' => hexdec('ff5733'),
            'weight' => 1000,
            'privilege' =>
                $DASHBOARD_ROLES->value | $ROLES_EDIT_DESC->value | $ROLES_EDIT_PRIVILEGES->value |
                $DASHBOARD_PRIVILEGES->value | $PRIVILEGES_EDIT->value |
                $DASHBOARD_LOGS->value | $LOGS_LOGIN->value | $LOGS_MODERATION->value | $LOGS_POSTS->value | $LOGS_ACTIVITY->value |
                $DASHBOARD_FEATURED->value | $FEATURED_EDIT->value |
                $DASHBOARD_MEMBERS->value | $MEMBERS_EDIT_PROFILE->value | $MEMBERS_EDIT_DATA->value |
                $DASHBOARD_PUNISHMENTS->value | $PUNISHMENTS_ISSUE->value
        ]);

        Role::factory()->create([
            'name' => 'MODERATOR',
            'description' => 'Access to moderation tools',
            'title' => 'Moderator',
            'colour' => hexdec('ff5733'),
            'weight' => 900,
            'privilege' =>
                $DASHBOARD_LOGS->value | $LOGS_MODERATION->value | $LOGS_POSTS->value | $LOGS_ACTIVITY->value |
                $DASHBOARD_MEMBERS->value | $MEMBERS_EDIT_PROFILE->value |
                $DASHBOARD_PUNISHMENTS->value | $PUNISHMENTS_ISSUE->value
        ]);

        Role::factory()->create([
            'name' => 'STAFF',
            'description' => 'Part of the staff team',
            'title' => 'Staff',
            'colour' => hexdec('ff5733'),
            'weight' => 500,
            'privilege' => $TITLE_EDIT->value,
        ]);

        Role::factory()->create([
            'name' => 'BANNED',
            'description' => 'Banned from the site',
            'title' => 'Member',
            'colour' => hexdec('ff5733'),
            'weight' => 0,
            'privilege' => $NOT_GLOBAL_SITE->value
        ]);


    }
}
