<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inventario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['placa','descripcion','categoria','valor','marca','estado',
        'responsable','fechaIngreso','habilitadoPrestamo','activo','rutaImagen'];

    /**
     * The attributes treated as a carbon instance.
     *
     * @var array
     */
    protected $dates = ['fechaIngreso'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    /**
     * Establece el atributo fecha como una instancia Carbon a partir de un input con formato d/m/Y
     *
     * @param $date
     */
    public function setFechaIngresoAttribute($date)
    {
        $this->attributes['fechaIngreso'] = Carbon::createFromFormat('d/m/Y', $date);
    }

    /**
     * Retorna la fecha de ingreso con formato d/m/Y
     *
     * @param $date
     * @return string
     */
    public function getFechaIngresoAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
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
     * Retorna el estado asociado al artículo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cat()
    {
        return $this->belongsTo('App\Categoria', 'categoria');
    }


    /**
     * Retorna el estado asociado al artículo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function est()
    {
        return $this->belongsTo('App\EstadoArticulo', 'estado');
    }

    /**
     * Método personalizado para agregar un where sobre el campo placa.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopePlaca($query, $placa)
    {
        if ($placa) {
            return $query->where('placa', '=', $placa);
        }
        return $query;
    }

    /**
     * Método personalizado para agregar un where sobre el campo descripción.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeDescrip($query, $descrip)
    {
        if ($descrip) {
            return $query->where('descripcion', 'LIKE', "%$descrip%");
        }
        return $query;
    }

    /**
     * Método personalizado para agregar un where sobre el campo categoría.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeCat($query, $categoria)
    {
        if ($categoria) {
            return $query->where('categoria', '=', $categoria);
        }
        return $query;
    }

    /**
     * Método personalizado para agregar un where sobre el campo activo.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', '=', true);
    }

    /**
     * Método personalizado para agregar un where sobre el habilitado prestramo.
     *
     * @param $query
     * @return $query actualizado.
     */
    public function scopeHabilitadosPrestamo($query)
    {
        return $query->where('habilitadoPrestamo', '=', true);
    }


}