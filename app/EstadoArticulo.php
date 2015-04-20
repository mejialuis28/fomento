<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoArticulo extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'estadoarticulo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'activo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Define si el modelo va a utilizar los timestamps de defecto: created_at, updated_at
     *
     * @var bool
     */
    public $timestamps = false;

}
