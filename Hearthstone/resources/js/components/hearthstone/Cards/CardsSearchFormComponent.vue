<template>
    <div>
        <div class="form-group">
            <label for="nameCard">Название</label>
            <input type="text" class="form-control" id="cardName" aria-describedby="nameCard" placeholder="Введите название карты">
        </div>
        <div>
            <div class="form-group">
                <label for="classHeroes">Класс</label>
                <select class="form-control" id="classHeroes" name="playerClass">
                    <option>Все</option>
                    <!--            @foreach ($heroes as $hero)-->
                    <!--            <option value="{{ $hero->id }}">{{ $hero->name }}</option>-->
                    <!--            @endforeach-->
                </select>
            </div>
            <div class="form-group">
                <label for="rarityCards">Качество</label>
                <select class="form-control" id="rarityCards" name="rarity">
                    <option>Все</option>
                    <!--            @foreach ($rarities as $rarity)-->
                    <!--            <option value="{{ $rarity->id }}">{{ $rarity->name }}</option>-->
                    <!--            @endforeach-->
                </select>
            </div>
            <div class="form-group">
                <label for="typeCards">Тип</label>
                <select class="form-control" id="typeCards" name="type">
                    <option>Все</option>
                    <!--            @foreach ($types as $type)-->
                    <!--            <option value="{{ $type->id }}">{{ $type->name }}</option>-->
                    <!--            @endforeach-->
                </select>
            </div>
            <div class="form-group">
                <label for="rarityCards">Раса</label>
                <select class="form-control" id="rarityCards" name="race">
                    <option>Все</option>
                    <!--            @foreach ($races as $race)-->
                    <!--            <option value="{{ $race->id }}">{{ $race->name }}</option>-->
                    <!--            @endforeach-->
                </select>
            </div>
            <div class="form-group">
                <label for="mechanicsCards">Механика</label>
                <select class="form-control" id="mechanicsCards" name="mechanics_id">
                    <option>Все</option>
                    <!--@foreach ($mechanics as $mechanic)
                    <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                    @endforeach-->
                </select>
            </div>
            <div class="form-group">
                <label for="packsetCards">Набор</label>
                <select class="form-control" id="packsetCards" name="packset">
                    <option>Все</option>
                    <!--@foreach ($packsets as $packset)
                    <option value="{{ $packset->id }}">{{ $packset->name }}</option>
                    @endforeach-->
                </select>
            </div>
            <div class="form-group border-mana-attack-health mt-3">
                <div class="input-group mt-3">
                    <input type="range" class="custom-range" min="0" max="10" id="rangeMana" name="cost" aria-describedby="manaHelp">
                    <small id="manaHelp" class="form-text text-muted">
                        Мана: <span id="manacost"></span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" name="manacheck" id="manacheck">
                            <label class="form-check-label" style="margin-top: 2px" for="manacheck">
                                Поиск по мане
                            </label>
                        </div>
                    </small>
                </div>
                <div class="input-group mt-2">
                    <input type="range" class="custom-range" min="0" max="10" id="rangeAttack" name="attack" aria-describedby="attackHelp">
                    <small id="attackHelp" class="form-text text-muted">
                        Атака: <span id="attack"></span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" name="attackcheck" id="attackcheck">
                            <label class="form-check-label" style="margin-top: 2px" for="attackheck">
                                Поиск по атаке
                            </label>
                        </div>
                    </small>
                </div>
                <div class="input-group mt-3">
                    <input type="range" class="custom-range" min="1" max="10" id="rangeHealth" name="health" aria-describedby="healthHelp">
                    <small id="healthHelp" class="form-text text-muted">
                        Здоровье: <span id="health"></span>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" name="healthcheck" id="healthcheck">
                            <label class="form-check-label" style="margin-top: 2px" for="healthcheck">
                                Поиск по здоровью
                            </label>
                        </div>
                    </small>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">Найти</button>
        </div>
    </div>
</template>

<script>
    export default {
    }
</script>

<style scoped>

</style>
