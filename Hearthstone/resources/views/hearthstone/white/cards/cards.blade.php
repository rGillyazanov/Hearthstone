@extends('layouts.app')

@section('content')
    <keep-alive exclude="CardComponent">
        <router-view></router-view>
    </keep-alive>
@endsection