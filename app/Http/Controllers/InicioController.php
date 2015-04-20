<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class InicioController extends Controller {


    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

	/**
 * Display a listing of the resource.
 *
 * @return Response
 */
    public function index()
    {
        return view('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function login()
    {
        if($this->auth->check())
        {
            return redirect('/');
        }
        return view('login');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function autenticar(Request $request)
    {
        $credentials = $request->only('documento', 'password');

        if ($this->auth->attempt($credentials))
        {
            return redirect()->intended('/');
        }

        return redirect('login')
            ->withInput($request->only('documento'))
            ->withErrors([
                'documento' => 'Las información ingresada no es correcta, Intente nuevamente.'
            ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function logout()
    {
        $this->auth->logout();

        return redirect('/');
    }


}
