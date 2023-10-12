<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'value'
    ];


    // Change to cache later
    public static function getPrivilegeValue(string $name): int {
        $privilege = Privilege::where(['name' => $name])->first();
        if ($privilege == null) {
            // Return value that will never match
            return -1;
        }
        return $privilege->value;
    }

    public function name(): string {
        $name = str_replace('_', ' ', $this->name);
        $name = strtolower($name);
        return ucwords($name);

    }
}
