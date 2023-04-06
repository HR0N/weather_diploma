<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Погода 🌧️</title>
        <meta name="robots" content="noindex">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        {{--    jQuery  --}}
        <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])

    </head>
    <body class="antialiased">
    <div id="welcome">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Home
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (Auth::user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('adminpanel') }}">APanel</a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="main">
            <div class="weather">
                <div class="weather__header">
                    <div class="weather__title"><span>Погода</span> у Києві</div>
                    <label>Вибрати місто:
                        <select type="text" class="form-control">
                            <option value="Dnipro">Дніпро</option>
                            <option value="Donetsk">Донецьк</option>
                            <option value="Zaporizhia">Запоріжжя</option>
                            <option value="Kyiv">Київ</option>
                            <option value="Kryvyi Rih">Кривий Ріг</option>
                            <option value="Lviv">Львів</option>
                            <option value="Mykolayiv">Миколаїв</option>
                            <option value="Odessa">Одеса</option>
                            <option value="Sevastopol">Севастополь</option>
                            <option value="Kharkiv">Харків</option>
                        </select>
                    </label>
                </div>
                <div class="days">
                    @foreach($data['days'] as $day)
                        <div class="day">
                            <div class="today"><?= $data['welcome']->get_weekday($day); ?></div>
                            <div class="date"><?= $data['welcome']->get_date($day)['day'] ?></div>
                            <div class="month"><?= $data['welcome']->get_month($day); ?></div>
                            <div class="icon"><img src="<?= "https://openweathermap.org/img/w/".$day[0]['weather'][0]['icon'].".png" ?>" alt="weather"></div>
                            <div class="temp">
                                <div class="min">
                                    <div class="temp__title">мін.</div>
                                    <div class="val"><?= $day['temp_min'] ?>°</div>
                                </div>
                                <div class="max">
                                    <div class="temp__title">макс.</div>
                                    <div class="val"><?= $day['temp_max'] ?>°</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="details_wrap">
                    @foreach($data['days'] as $key => $day)
                        <div class="detail <?= $key === 0 ? 'show-detail' : '' ?>">
                            <div class="capture">
                                <div class="time"></div>
                                <div class="tmp">Температура, °C</div>
                                <div class="feels_like">Відчувається як</div>
                                <div class="pressure">Тиск, мм</div>
                                <div class="humidity">Вологість, %</div>
                                <div class="wind">Вітер, м/сек</div>
                            </div>
                            <?php $intervals = array_splice($day, 0, -2); ?>
                            @foreach($intervals as $interval)
                                <div class="interval">
                                    <div class="time"><?= substr($interval['dt_txt'], 11, 5) ?></div>
                                    <div class="tmp"><?= $data['welcome']->with_sign($interval['main']['temp']) ?>°</div>
                                    <div class="feels_like"><?= $data['welcome']->with_sign($interval['main']['feels_like']) ?>°</div>
                                    <div class="pressure"><?= round($interval['main']['pressure'] / 1.333, 0) ?></div>
                                    <div class="humidity"><?= $interval['main']['humidity'] ?></div>
                                    <div class="wind"><?= $interval['wind']['speed'] ?></div>
                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    </body>
</html>
