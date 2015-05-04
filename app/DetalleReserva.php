<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleReserva extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detallereservas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idReserva','idInventario'];

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

}
