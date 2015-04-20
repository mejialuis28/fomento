<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'administradores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['usuario', 'activo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Retorna el usuario responsable del articulo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'usuario');
    }

    /**
     * Define si el modelo va a utilizar los timestamps de defecto: created_at, updated_at
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * Se especifica cual columna es la llave primaria debido a que laravel asume que es id.
     *
     * @var string
     */
    public $primaryKey  = 'usuario';

}
