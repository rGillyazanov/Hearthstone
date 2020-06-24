@extends('layouts.app')

@section('content')
    <keep-alive :exclude="['CardComponent', 'ChoiceCardsForDeckComponent', 'ChoiceHeroesComponent', 'DeckComponent']">
        <router-view></router-view>
    </keep-alive>
@endsection