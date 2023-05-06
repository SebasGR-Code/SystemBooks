<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    //Sirve para ver el cliente del prestamo
    public function client() {
        return $this->belongsTo(Client::class);
    }

    //Sirve para ver el libro del prestamo
    public function book() {
        return $this->belongsTo(Book::class);
    }
}
