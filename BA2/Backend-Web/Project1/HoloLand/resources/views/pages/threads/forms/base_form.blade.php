@php
/**
 * @var \App\Models\ThreadForm[] $fields
 */
@endphp
@foreach($fields as $field)
    @switch($field->type)
        @case("big-text")
            <label for="{{ $field->id }}">{{ $field->label }}</label><br>
            <span>{{ $field->description }}</span>
            <textarea id="{{ $field->id }}" name="{{ $field->id }}" cols="100" rows="15">{{ $field->placeholder }}</textarea><br>
        @break
        @case('text')
            <label for="{{ $field->id }}">{{ $field->label }}</label><br>
            <span>{{ $field->description }}</span>
            <input type="{{ $field->type }}" id="{{ $field->id }}" name="{{ $field->id }}" placeholder="{{ $field->placeholder }}"><br>
        @break
        @case('bool')
            <label for="{{ $field->id }}">{{ $field->label }}</label><br>
            <span>{{ $field->description }}</span>
            <input type="checkbox" id="{{ $field->id }}" name="{{ $field->id }}"><br>
        @break
    @endswitch
@endforeach
