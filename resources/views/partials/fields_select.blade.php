<select class="select2_demo_3 form-control select2-hidden-accessible" tabindex="-1" aria-hidden="true" multiple name="fields[]">
    <option>Selecciona una alternativa</option>
    @foreach($fields as $field)
        <option value="{{ $field->id }}" {{ (old('zone') == $field->id)?'selected':'' }}>{{ $field->name }}</option>
    @endforeach
</select>