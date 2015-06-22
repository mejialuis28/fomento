<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model {

	/**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'reservas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['responsable','fechaInicio','fechaFin','comentarios','estado', 'motivoRechazo'];

    /**
     * The attributes treated as a carbon instance.
     *
     * @var array
     */
    protected $dates = ['fechaInicio', 'fechaFin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public function setFechaInicioAttribute($date)
    {
        $this->attributes['fechaInicio'] = Carbon::createFromFormat('d/m/Y h:i A', $date);
    }

    public function setFechaFinAttribute($date)
    {
        $this->attributes['fechaFin'] = Carbon::createFromFormat('d/m/Y h:i A', $date);
    }

    /**
     * Método personalizado para agregar un where sobre el campo Estaod.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeCreadas($query)
    {
        return $query->where('estado', '=', EstadoReserva::CREADA);
    }

    /**
     * Método personalizado para agregar un where sobre el campo Estado.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeSinEjecutar($query)
    {
        return $query->whereIn('estado', array(EstadoReserva::CREADA, EstadoReserva::CANCELADA, EstadoReserva::RECHAZADA, EstadoReserva::EXPIRADA));
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
     * Retorna el usuario responsable del articulo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function items()
    {
        return $this->hasMany('App\DetalleReserva','idReserva');
    }
}

abstract class EstadoReserva
{
    const CREADA = 'Creada';
    const EJECUTADA = 'Ejecutada';
    const RECHAZADA = 'Rechazada';
    const EXPIRADA = 'Expirada';
    const CANCELADA = 'Cancelada';
}
