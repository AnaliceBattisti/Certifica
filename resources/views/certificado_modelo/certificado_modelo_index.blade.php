@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/acoes/list.css">
@endsection

@section('content')
    <section class="view-list-acoes">

        <div class="container">

            <h1 class="text-center mb-4">Modelos de certificados</h1>

            @if(Auth::user()->perfil_id == 1)
                <div class="row d-flex align-items-center justify-content-end">
                    <a class="criar-acao-button" href={{route('certificado_modelo.create')}}>
                        <img class="iconAdd" src="/images/acoes/listView/criar.svg" alt=""> Criar atividade
                    </a>
                </div>
            @elseif(Auth::user()->perfil_id == 3)
                <div class="row d-flex align-items-center justify-content-end">
                    <a class="criar-acao-button" href={{route('tipo_certificado_modelo.create')}}>
                        <img class="iconAdd" src="/images/acoes/listView/criar.svg" alt=""> Criar atividade
                    </a>
                </div>
            @endif


            <div class="row head-table d-flex align-items-center justify-content-center">
                <div class="col-4"><span class="spacing-col">Descrição</span></div>
                <div class="col-4"><span>Únidade Administrativa</span></div>
                <div class="col-4"><span>Detalhes</span></div>
            </div>
        </div>


        <div class="list container overflow-scroll">
            @foreach($certificado_modelos as $modelo)
                <div class="row linha-table d-flex align-items-center justify-content-center">
                    <div class="col-4"><span class="spacing-col">{{$modelo->descricao}}</span></div>
                    <div class="col-4"><span>@if($modelo->unidadeAdministrativa) {{$modelo->unidadeAdministrativa->descricao}} @endif</span></div>
                    <div class="col-4 d-flex align-items-center justify-content-around">



                        <span class="col-2 d-flex align-items-center justify-content-around">
                            <a href="{{route('certificado_modelo.show', ['id'=>$modelo->id])}}">
                                <img src="/images/acoes/listView/eye.svg" alt="Visualizar dados">
                            </a>
                            <a href="{{route('certificado_modelo.delete', ['id' => $modelo->id])}}">
                                <img src="/images/acoes/listView/lixoIcon.svg" alt="Excluir">
                            </a>
                        </span>

                        <span class="col-10 "></span>

                    </div>
                </div>
            @endforeach
        </div>


    </section>
@endsection
