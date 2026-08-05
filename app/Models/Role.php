<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nama',
    ];

    // Relasi: 1 Role digunakan oleh banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}