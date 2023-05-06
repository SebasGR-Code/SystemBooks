<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    //Relacion uno a muchos (Sirve para ver los libros que ha pedido prestado el cliente)
    public function loans() {
        return $this->hasMany(Loan::class);
    }
}
