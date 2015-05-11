<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePrestamo extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalleprestamos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idPrestamo','idInventario','estadoEntrega','estadoDevolucion'];

    /**
     * The attributes treated as a carbon instance.
     *
     * @var array
     */
    protected $dates = [];

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
     * Retorna el item asociado al detalle.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('App\Inventario', 'idInventario');
    }

    public function estadoIni()
    {
        return $this->belongsTo('App\EstadoArticulo', 'estadoEntrega');
    }

    public function estadoFin()
    {
        return $this->belongsTo('App\EstadoArticulo', 'estadoDevolucion');
    }
}
