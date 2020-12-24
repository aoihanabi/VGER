<label>{{ $attr->name }}</label>
<select id="{{ strtolower($attr->name) }}_selected" name="drop_option" class="buy_dropdown p-1 col-span-3 border-2 border-gray-400 rounded" >
    <option>Seleccione una opción</option>
    @php
        $duplicates = [];        
    @endphp
    @foreach ($options_db as $detail) 
        <!-- <p>{{ $detail->options_ids }}</p> -->
        
        @foreach((array)json_decode($detail->options_ids) as $key => $opt)
            @if($opt != null && $key == strtolower($attr->name))
                
                @if (!in_array($opt->id, $duplicates))
                    <option value="{{ $opt->id }}" >{{ $opt->option }}</option>
                    @php 
                        $duplicates[] = $opt->id;
                    @endphp
                @endif
                

            @endif
        @endforeach
    @endforeach
</select>
