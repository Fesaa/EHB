@extends('layouts.master')

<style>
    .item {
        text-align: center;
    }
</style>

@section('extra-content')
    <div class="item">
        <p>Item ID: {{ $id }}</p>
        <p>Item Name: {{ $info["name"] }}</p>
        <p>Item Description: {{ $info["description"] }}</p>
    </div>
@endsection
