<select name="drop_option" class="p-1 border-2 border-gray-400 rounded">
    <option selected="selected" value="">{{ $attr->name }}</option>
    @foreach ($opts as $opt) 
        @if ($opt->attribute_id == $attr->id)
        <option value="{{ $opt->option }}">{{ $opt->option }}</option>
        @endif
    @endforeach
</select>