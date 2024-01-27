@extends('includes.default')

@section('main')
    <div class="row">
        <div class="col-md-6 mb-4">
            <section class="border border-1 rounded-2 p-3 h-100" id="show">
                <h3>{{ $show->title }}</h3>
                <p><strong>Час:</strong> {{ $show->start_at->format('d.m.Y H:i') }}
                    - {{ $show->end_at->format('d.m.Y H:i') }}</p>
                <p><strong>Опис:</strong> {{ $show->description }}</p>
                <p><strong>Ціна квитка:</strong> {{ $show->price }}₴</p>
            </section>
        </div>
        <div class="col-md-6 mb-4">
            <section class="border border-1 rounded-2 p-3 h-100" id="hall">
                <h3>{{ $hall->title }}</h3>
                <p><strong>Кількість місць:</strong> {{ $hall->seats }}</p>
                <p><strong>Вільно:</strong> {{ $hall->seats - \count($occupied_seats) }}</p>
                <div class="d-flex align-items-center">
                    <div class="border border-1 rounded-1 m-1 text-center seat"></div>
                    <span> - Вільно</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="border border-1 rounded-1 m-1 text-center bg-secondary seat"></div>
                    <span> - Зайнято</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="border border-1 rounded-1 m-1 text-center bg-success seat"></div>
                    <span> - Обрано</span>
                </div>
            </section>
        </div>
        <div class="col-12 mb-4">
            <section class="border border-1 rounded-2 p-3" id="seats">
                <div class="d-flex justify-content-center mb-4">
                    <div id="map" class="d-flex flex-wrap justify-content-center">

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div id="scene" class="d-flex align-items-center justify-content-center w-100 border border-1">
                        <p class="text-center m-0 p-5">Сцена</p>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-12 text-center mb-4">
            <section class="border border-1 rounded-2 p-3">
                <button id="make-order" class="btn btn-success">Оформити замовлення</button>
            </section>
        </div>
        @if ($gallery->isNotEmpty())
            <div class="col-12">
                <section class="border border-1 rounded-2 p-3" id="carousel">
                    <div id="carousel-indicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($gallery as $item)
                                <button type="button" data-bs-target="#carousel-indicators"
                                        data-bs-slide-to="{{ $loop->index }}" @if ($loop->first) class="active"
                                        aria-current="true" @endif aria-label="{{ $item->alt }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($gallery as $item)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <img src="{{ asset($item->src) }}" class="d-block w-100" alt="{{ $item->alt }}">
                                </div>
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
                </section>
            </div>
        @endif
    </div>

    <div class="modal" id="modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Оформлення замовлення</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('shows', ['id' => $show->id]) }}">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                                    <div class="border border-1 rounded-2 m-1 p-2 h-100">
                                        <h4 class="mb-3">Персональні дані</h4>
                                        <div class="mb-2">
                                            <label for="full-name" class="form-label">Прізвище, Ім'я, По
                                                батькові:</label>
                                            <input type="text" class="form-control" id="full-name" placeholder=""
                                                   name="full_name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="phone" class="form-label">Номер телефону:</label>
                                            <input type="text" class="form-control" id="phone"
                                                   placeholder="+380000000000" name="phone">
                                        </div>
                                        <div class="mb-2">
                                            <label for="email" class="form-label">Адреса електронної пошти:</label>
                                            <input type="text" class="form-control" id="email"
                                                   placeholder="example@example.com" name="email">
                                        </div>
                                        <div>
                                            <label for="comment" class="form-label">Коментар:</label>
                                            <textarea style="resize: none;" class="form-control" id="comment" rows="3"
                                                      name="comment"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="border border-1 rounded-2 m-1 p-2 h-100">
                                        <h4 class="mb-3">Дані оплати</h4>
                                        <div class="mb-2">
                                            <label for="amount" class="form-label">Сума замовлення:</label>
                                            <input type="text" class="form-control" id="amount" name="amount"
                                                   disabled="disabled">
                                        </div>
                                        <div class="mb-2">
                                            <label for="card-number" class="form-label">Номер картки:</label>
                                            <input type="text" class="form-control" id="card-number"
                                                   placeholder="0000 0000 0000 0000" name="card_number">
                                        </div>
                                        <div class="mb-2">
                                            <label for="expiry-date" class="form-label">Термін дії:</label>
                                            <input type="text" class="form-control" id="expiry-date" placeholder="MM/YY"
                                                   name="expiry_date">
                                        </div>
                                        <div>
                                            <label for="cvv" class="form-label">CVV:</label>
                                            <input type="text" class="form-control" id="cvv" placeholder="000"
                                                   name="cvv">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="d-none"></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                    <button id="pay" type="button" class="btn btn-primary">Оплатити</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/show.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            show({{ \Illuminate\Support\Js::from([
                'seats' => $hall->seats,
                'occupied_seats' => $occupied_seats,
                'price' => $show->price,
                'alerts' => \array_merge($alerts ?? [], session()->get('alerts') ?? [])
            ]) }});
        });
    </script>
@endpush
