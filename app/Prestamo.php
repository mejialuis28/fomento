<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model {

	/**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'prestamos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idReserva','responsable','fechaInicio','fechaFin','fechaEntrega','fechaDevolucion','estado', 'observacionesEntrega','entregadoPor','recibidoPor', 'observacionesDevolucion','notificadoRetraso'];

    /**
     * The attributes treated as a carbon instance.
     *
     * @var array
     */
    protected $dates = ['fechaInicio', 'fechaFin', 'fechaEntrega', 'fechaDevolucion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public function setFechaInicioAttribute($date)
    {
        $this->attributes['fechaInicio'] = Carbon::createFromFormat('d/m/Y H:i', $date);
    }

    public function setFechaFinAttribute($date)
    {
        $this->attributes['fechaFin'] = Carbon::createFromFormat('d/m/Y H:i', $date);
    }

    /**
     * Método personalizado para agregar un where sobre el campo Estado.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopePrestados($query)
    {
        return $query->where('estado', '=', EstadoPrestamo::PRESTADO);
    }

    /**
     * Método personalizado para agregar un where sobre el campo Estado.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeDevueltos($query)
    {
        return $query->where('estado', '=', EstadoPrestamo::DEVUELTO);
    }

    /**
     * Retorna el usuario responsable del articulo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'responsable');
    }

    /**
     * Retorna el usuario responsable de entregar el préstamo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entrego()
    {
        return $this->belongsTo('App\User', 'entregadoPor');
    }

    /**
     * Retorna el usuario responsable de recibir el prestamo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recibio()
    {
        return $this->belongsTo('App\User', 'recibidoPor');
    }

    /**
     * Retorna el usuario responsable del articulo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function items()
    {
        return $this->hasMany('App\DetallePrestamo','idPrestamo');
    }
}

abstract class EstadoPrestamo
{
    const PRESTADO = 'Prestado';
    const DEVUELTO = 'Devuelto';
}
