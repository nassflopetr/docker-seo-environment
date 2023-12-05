<h1 class="d-none">{{ isset($metadata) && \array_key_exists('h1', $metadata) ? $metadata['h1'] : '' }}</h1>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('/') }}">
                <span class="fs-5 text-uppercase">Театральний Портал</span><br>
                <span class="fs-6">Ваш вхід до світу неповторних вистав</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('/') }}">Про нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shows') }}">Афіша</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contacts') }}">Контакти</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
