@extends('layouts.app')

@section('content')
    <keep-alive :exclude="['CardComponent', 'ChoiceCardsForDeckComponent', 'ChoiceHeroesComponent']">
        <router-view></router-view>
    </keep-alive>
@endsection