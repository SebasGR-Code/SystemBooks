<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //Relacion uno a muchos (Sirve para ver las veces que se ha prestado el libro)
    public function loans() {
        return $this->hasMany(Loan::class);
    }
}
