@extends('includes.default')

@section('main')
    @if ($shows->isNotEmpty())
        <section id="shows" class="border border-1 rounded-2 p-3 mb-4">
            <div class="row">
                <div class="col-12">
                    <div id="carousel-indicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($shows as $show)
                                @if (!is_null($show->gallery->first()))
                                    <button type="button" data-bs-target="#carousel-indicators"
                                            data-bs-slide-to="{{ $loop->index }}" @if ($loop->first) class="active"
                                            aria-current="true"
                                            @endif aria-label="{{ $show->gallery->first()->alt }}"></button>
                                @endif
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($shows as $show)
                                @if (!is_null($show->gallery->first()))
                                    <div class="carousel-item position-relative @if ($loop->first) active @endif">
                                        <img src="{{ asset($show->gallery->first()->src) }}" class="d-block w-100"
                                             alt="{{ $show->gallery->first()->alt }}">
                                        <div class="carousel-caption">
                                            <h3><strong>{{ $show->title }}</strong></h3>
                                            <p>
                                                <strong>{{ Illuminate\Support\Str::limit($show->description, 120) }}</strong>
                                            </p>
                                        </div>
                                        <a href="{{ route('shows', ['id' => $show->id]) }}" class="stretched-link"></a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-indicators"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Попередня</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-indicators"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Наступна</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section id="about" class="border border-1 rounded-2 p-3 mb-4">
        <h2>Про Театральний Портал</h2>
        <p>Ласкаво просимо до нашого Театральний Порталу!</p>
        <p>
            Театральний Портал - це ваш пропуск у захоплюючий світ театрального мистецтва. Ми пропонуємо широкий вибір
            вистав для всіх смаків та вікових категорій. На нашому порталі ви можете дізнатися про найновіші театральні
            події, отримати <a href="{{ route('shows') }}">афішу</a> вистав та придбати квитки онлайн.
        </p>
    </section>

    <section id="services" class="border border-1 rounded-2 p-3 mb-4">
        <h2>Наші послуги</h2>
        <ul>
            <li>Детальна <a href="{{ route('shows') }}">афіша</a> театральних подій</li>
            <li>Купівля квитків онлайн</li>
            <li>Емоції та захоплення від неповторного театрального досвіду</li>
        </ul>
    </section>

    <section id="contact" class="border border-1 rounded-2 p-3">
        <h2>Зв'яжіться з нами</h2>
        <p>Ми завжди раді вам! З питань покупки квитків чи отримання додаткової інформації, будь ласка, звертайтеся за
            <a href="{{ route('contacts') }}">контактними даними</a>, вказаними на нашому порталі.</p>
    </section>
@endsection
