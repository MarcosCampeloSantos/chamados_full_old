<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;

    public function pesquisa($filter)
    {   
        $query_2 = Interacoe::where(function($q_2) use ($filter){
            
        })->paginate();

        $query = Chamado::where(function($q) use ($filter){
            $q->where('title','LIKE', "%".$filter."%");
            $q->orWhere('id','LIKE', "%".$filter."%");
        })->paginate();

        return $query;
    }

    public function pesquisaFim($filter)
    {   
        $query = Chamado::where(function($q) use ($filter){
            $q->where('title','LIKE', "%".$filter."%")->where('status_id', '2');
            $q->orWhere('id','LIKE', "%".$filter."%")->where('status_id', '2');
        })->paginate();

        return $query;
    }
}
