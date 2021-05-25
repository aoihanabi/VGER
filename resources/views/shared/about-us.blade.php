@extends('layouts.application')

@section('content') 
  
    <div id="about-us-content" class="h-3/5 relative">
        <div class="absolute inset-0 z-10 bg-gray-200 bg-opacity-50">
            <div class="h-full mx-5 lg:mx-64 md:mx-20 sm:mx-15 flex flex-col items-center justify-center">
                <h1 class="my-2 font-display text-center text-3xl text-gray-800">Ventas Gerizim</h1>
                <p class="my-1 font-title text-center text-gray-800">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nec laoreet leo. Donec ex risus, tempus euismod pretium ac, 
                    dapibus in turpis. Integer faucibus metus rhoncus velit mattis, elementum consequat erat interdum. Donec ex risus, tempus euismod pretium ac, 
                    dapibus in turpis. Integer faucibus metus rhoncus velit mattis, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nec laoreet leo. Donec ex risus, tempus euismod pretium ac, 
                    dapibus in turpis. Integer faucibus metus rhoncus velit mattis, elementum consequat erat interdum.
                </p>
                <button class="my-2 px-4 py-2 rounded bg-gray-700 text-white hover:bg-gray-800">
                    <a href="https://wa.me/50688051481">Chat</a>
                </button>
            </div>
        </div>
    </div>
    <div id="contact-us-content" class="h-4/5 relative py-20 bg-cool-gray-200">
    <!-- flex flex-col items-center justify-center -->
        <div class="h-full mx-5 lg:mx-64 md:mx-20 sm:mx-15 grid grid-flow-row auto-rows-fr justify-center items-center text-center bg-white rounded-lg shadow-lg ">
            <h2 class="my-10 font-display text-center text-3xl text-gray-800"> Contáctanos </h2>
            <div class="grid grid-cols-2 gap-2">
                <div class="">
                    <div>
                        <label>Correo electrónico</label>
                        <p>olgercamposval@gmail.com</p>
                    </div>
                    <div>
                        <label>WhatsApp</label>
                        <a href="https://wa.me/50688051481">Escríbenos a WhatsApp</a>
                    </div>
                </div>
                <div class="justify-self-center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15770.818733661787!2d-82.91853922314253!3d8.813789548724568!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa434d5ac8dd9c5%3A0x204360dbd999e2f2!2sSabalito%2C%20Provincia%20de%20Puntarenas!5e0!3m2!1ses-419!2scr!4v1621964261017!5m2!1ses-419!2scr" 
                    width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection