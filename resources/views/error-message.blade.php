@foreach ($errors->all() as $error)
    <div class="my-2 p-2 shadow  sm:rounded-md bg-red-200 ">
        <span class="fas fa-exclamation-circle text-red-900">
            <span class="font-sans font-light text-md text-red-900">
                {{ $error }}
            </span>
        </span>
    </div>
@endforeach