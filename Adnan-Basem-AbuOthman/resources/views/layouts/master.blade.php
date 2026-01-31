<!DOCTYPE html>
<html lang="en">
@vite(['resources/js/app.js'])

<link rel="icon" type="image/x-icon" href="{{ asset('img/14025056.png')}}">

@include('layouts.head')




@livewireStyles




<body @yield('class')>


    @include('layouts.header')




    <main class="">

        @yield('content')

    </main>




    @include('layouts.footer')



    @yield('js')
    @livewireScripts

</body>

</html>
