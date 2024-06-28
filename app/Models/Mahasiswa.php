<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $fillable = ['nama', 'nim', 'program_studi_id'];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}