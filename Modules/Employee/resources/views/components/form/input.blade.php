@props([
    'placeholder' => '',
    'name',
    'label' => null,
    'value' => null,
    'type' => 'text',
    'required' => false,
    'hint' => null,
    'errors',
    'class' => '',
    'labelClass' => '',
    'checked' => false,
    'datalist' => null,
])
@if ($label)
    <label @class(['form-label', 'required' => $required, $labelClass])>{{ $label }}</label>
@endif
@includeWhen($hint, 'employee::components.forms.field-hint', ['hint' => $hint])
{{ $slot }}
<input type="{{ $type }}" list="{{ $name }}list" name="{{ $name }}"
    placeholder="{{ $placeholder }}" id="{{ $name }}" autocomplete="new-password" value="{{ old($name, $value) }}"
    @class([
        'form-control',
        'is-invalid' => $errors->first($name),
        $class,
    ]) @required($required) @checked($checked) />
{{ $datalist }}
@if ($errors->first($name))
    <div class="invalid-feedback">{{ $errors->first($name) }}</div>
@endif
