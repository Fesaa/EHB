<style>
    .search-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        width: 80%;
    }

    .search-container h1 {
        color: #9ca3af;
        font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
    }
</style>

@extends('layouts.master')

@section('extra-content')
    <div class="search-container">
        <h1>Searching for: </h1>
        <div class="search">
            <h2>Magical World Adventure Book Set</h2>
            <p>Embark on a thrilling journey with this enchanting book set filled with magical creatures, daring quests, and epic adventures. Perfect for young readers who love to escape into the world of fantasy and imagination.</p>
            <a >link</a>
            <hr>
        </div>
        <div class="search">
            <h2>Unicorn Dreams Pajama Set</h2>
            <p>Dive into the world of dreams with this adorable pajama set featuring a unicorn design. Soft and cozy, these pajamas are ideal for a comfortable night's sleep or lounging around on lazy weekends. Let your inner unicorn shine!</p>
            <a >link</a>
            <hr>
        </div>
        <div class="search">
            <h2>Mystical Forest Backpack</h2>
            <p>Carry your books and essentials in style with this mystical forest-themed backpack. Its whimsical design features magical creatures, towering trees, and twinkling stars. It's a must-have accessory for any young adventurer with a love for the mystical and fantastical.</p>
            <a >link</a>
            <hr>
        </div>
    </div>
@endsection
