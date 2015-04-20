<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipousuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Usuarios asociados al tipo de usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

}
