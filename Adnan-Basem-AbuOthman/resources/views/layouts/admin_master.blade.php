<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/x-icon" href="{{ asset('img/14025056.png')}}">


@include('layouts.head')
@livewireStyles


<body>

    @include('layouts.admin_sidebar')




    <main class="dashboard-main">


        @yield('content')


    </main>




    @yield('js')
        @livewireScripts


</body>

</html>
