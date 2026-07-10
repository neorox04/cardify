@props([
    'name'  => '',
    'photo' => null,   // raw storage path (e.g. business card / user avatar column)
    'style' => null,   // avatar style key; falls back to the default
    'size'  => 96,
])

@if($photo)
    <img src="{{ \Illuminate\Support\Facades\Storage::url($photo) }}"
         alt="{{ $name }}"
         width="{{ $size }}" height="{{ $size }}"
         style="width:{{ $size }}px;height:{{ $size }}px;border-radius:50%;object-fit:cover;display:block;">
@else
    {!! \App\Support\Avatar::svg($name, $style, (int) $size) !!}
@endif
