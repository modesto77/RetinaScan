<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Patient extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'diabetes_type',   // <--- Important
        'diagnosis_year',  // <--- Important
        'medical_history'
    ];

    protected $casts = [
        'date_of_birth' => 'date', // Convertit le String en Date (Carbon)
        'diagnosis_year' => 'integer',
    ];

    // Relation : Un patient appartient à un médecin (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scans()
    {
        // hasMany = A plusieurs...
        // latest() = Trie du plus récent au plus ancien automatiquement
        return $this->hasMany(Scan::class)->latest();
    }
}
