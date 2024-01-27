@extends('includes.default')

@section('main')
    <section id="shows">
        @foreach ($shows as $show)
            <div class="border border-1 rounded-2 p-3 mb-4">
                <h3>{{ $show->title }}</h3>
                <p><strong>Час:</strong> {{ $show->start_at->format('d.m.Y H:i') }}
                    - {{ $show->end_at->format('d.m.Y H:i') }}</p>
                <p><strong>Опис:</strong> {{ $show->description }}</p>
                <p><strong>Ціна квитка:</strong> {{ $show->price }}₴</p>
                <a href="{{ route('shows', ['id' => $show->id]) }}" class="btn btn-success">Детальніше / Купити квитки</a>
            </div>
        @endforeach
    </section>
@endsection
