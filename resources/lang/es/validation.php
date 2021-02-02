<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute solo puede contener letras.',
    'alpha_dash' => 'El :attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute solo puede contener letras y números.',
    'array' => 'El :attribute debe ser un arreglo.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute debe estar entre :min y :max.',
        'file' => ':attribute debe estar entre :min y :max kilobytes.',
        'string' => ':attribute debe estar entre :min y :max caractéres.',
        'array' => ':attribute debe tener entre :min y :max elementos.',
    ],
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => ':attribute no es una fecha válida.',
    'date_equals' => ':attribute debe ser una fecha igual a :date.',
    'date_format' => ':attribute no coincide con el formato :format.',
    'different' => ':attribute ay :other deben ser diferentes.',
    'digits' => ':attribute debe ser de :digits dígitos.',
    'digits_between' => ':attribute debe estar entre :min y :max dígitos.',
    'dimensions' => ':attribute tiene dimensiones de imágen inválidas.',
    'distinct' => 'El campo :attribute tiene un valor duplicado.',
    'email' => ':attribute debe ser una dirección de correo válida.',
    'ends_with' => ':attribute debe terminar con uno de los siguientes valores: :values.',
    'exists' => 'El :attribute seleccionado es inválido.',
    'file' => ':attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe tener un valor.',
    'gt' => [
        'numeric' => ':attribute debe ser mayor que :value.',
        'file' => ':attribute debe ser mayor a :value kilobytes.',
        'string' => ':attribute debe ser mayor a :value caractéres.',
        'array' => ':attribute debe tener más de :value elementos.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'El campo :attribute es requerido.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',
    'product_not_found' => 'Producto no encontrado.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        //Producto
        'code' => [
            'required' => 'El código es requerido.',
            'numeric' => 'El código debe ser numérico.',
            'digits' =>  'El código debe tener :digits dígitos.',
        ],
        'name' => [
            'required' => 'El nombre es requerido.',
            'max' => 'El nombre no puede tener más :max caractéres.',
        ],
        'description' => [
            'max' => 'La descripción no puede tener más :max caractéres.',
        ],
        'quantity' => [
            'required' => 'La cantidad es requerida.',
            'numeric' => 'La cantidad debe ser un valor numérico.',
        ],
        'price' => [
            'required' => 'El precio es requerido.',
            'numeric' => 'El precio debe ser un valor numérico.',
        ],
        'attribute_checks' => [
            'required' => 'Debe seleccionar al menos un atributo.'
        ],
        'color' => [
            'required_without_all' => 'Debe agregar al menos una opcion.'
        ],
        'talla' => [
            'required_without_all' => 'Debe agregar al menos una opcion.'
        ],
        'estilo' => [
            'required_without_all' => 'Debe agregar al menos una opcion.'
        ],
        'categ_checks' => [
            'required' => 'Debe seleccionar al menos una categoría.'
        ],
        'main_image' => [
            'required' => 'La imagen principal es requerida.'
        ],
        //Categoría
        'name' => [
            'required' => 'El nombre es requerido.',
            'max' => 'El nombre no puede tener más :max caractéres.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
