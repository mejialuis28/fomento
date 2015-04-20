<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categorias';

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

    /**
     * Items de inventario relacionados con la categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventario()
    {
        return $this->hasMany('App\Inventario');
    }

}
