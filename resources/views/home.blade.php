@extends('layouts.app')

@section('titulo')
    pagina principal
@endsection

@section('contenido')
    <x-lista-post :posts="$posts"/>
@endsection
