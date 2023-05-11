<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\UnidadeAdministrativa;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.usuario_index', ['usuarios' => User::all()->sortBy('id')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check() && Auth::user()->perfil_id == 1)
        {
            $perfils = Perfil::all()->where('id', '!=', 1)->sortBy('id');
        } else{
            $perfils = Perfil::all()->where('id', '!=', 1)->where('id', '!=', 3)->sortBy('id');
        }


        $unidade_administrativas = UnidadeAdministrativa::all()->sortBy('id');

        return view('usuario.usuario_create', ['perfils' => $perfils, 'unidade_administrativas' => $unidade_administrativas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = new User();

        $usuario->name = $request->name;
        $usuario->cpf = $request->cpf;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->perfil_id = $request->perfil_id;
        $usuario->unidade_administrativa_id = $request->unidade_administrativa_id;

        $usuario->save();

        return redirect(Route('usuario.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        $perfil = Perfil::findOrFail($usuario->perfil_id);
        $unidade_administrativa = UnidadeAdministrativa::findOrFail($usuario->unidade_administrativa_id);

        $perfils = Perfil::all()->sortBy('id');
        $unidade_administrativas = UnidadeAdministrativa::all()->sortBy('id');

        return view('usuario.usuario_edit', ['usuario' => $usuario, 'perfils' => $perfils, 'perf' => $perfil,
            'unidade_administrativas' => $unidade_administrativas, 'un_administrativa' => $unidade_administrativa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUsuarioRequest  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $usuario = User::findOrFail($request->id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->perfil_id = $request->perfil_id;
        $usuario->unidade_administrativa_id = $request->unidade_administrativa_id;

        $usuario->update();

        return redirect(Route('usuario.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function delete($usuario_id)
    {
        $usuario = User::findOrFail($usuario_id);
        $usuario->delete();

        return redirect(Route('usuario.index'));
    }

    public function home_administrador()
    {
        return view('administrador.administrador_index');
    }
    public function home_gestor()
    {
        return view('gestor_institucional.gestor_index');
    }
}
