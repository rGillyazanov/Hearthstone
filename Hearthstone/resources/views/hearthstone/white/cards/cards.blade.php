@extends('layouts.app')

@section('content')
    <transition name="slide-fade" mode="out-in">
        <keep-alive :exclude="['CardComponent', 'ChoiceCardsForDeckComponent', 'ChoiceHeroesComponent', 'DeckComponent']">
                <router-view></router-view>
        </keep-alive>
    </transition>
@endsection