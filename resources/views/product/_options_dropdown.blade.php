<select id="{{ strtolower($attr->name) }}_selected" name="drop_option" class="p-1 border-2 border-gray-400 rounded">
    <option selected="selected" value="">{{ $attr->name }}</option>
    @foreach ($opts as $opt) 
        @if ($opt->attribute_id == $attr->id)
        <option value="{{ $opt->id }}">{{ $opt->option }}</option>
        @endif
    @endforeach
</select>