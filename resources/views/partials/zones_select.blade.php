<select class="select2_demo_3 form-control select2-hidden-accessible" tabindex="-1" aria-hidden="true" multiple name="zones[]">
    <option>Selecciona una alternativa</option>
    @foreach($zones as $zone)
        <option value="{{ $zone->id }}" {{ (old('zone') == $zone->id)?'selected':'' }}>{{ $zone->name }}</option>
    @endforeach
</select>