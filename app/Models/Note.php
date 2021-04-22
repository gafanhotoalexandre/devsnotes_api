<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    public function rules()
    {
        return [
            'title' => 'required',
            'body' => 'required',
        ];
    }
    public function feedback()
    {
        return [
            'title.required' => 'O campo de Título deve ser preenchido',
            'body.required' => 'O campo da Mensagem deve ser preenchido'
        ];
    }
}
