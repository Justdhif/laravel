@extends('profile.sidebar.sidebar')

@section('title', 'Your menu')

@section('content')

<div class="statistic">
    <div class="statistic_item">
        <h3>Total Menus Created:</h3>
        <span>{{ $totalMenus }}</span>
    </div>
    <div class="statistic_item">
        <h3>Total Reviews:</h3>
        <span>{{ $totalReviews }}</span>
    </div>
    <div class="statistic_item">
        <h3>Average Rating:</h3>
        <span>{{ number_format($averageRating, 2) }}</span>
    </div>
</div>

<div class="your_menu">
    <h3>Your Menus</h3>
    @if ($menus->isEmpty())
        <p>No menus created yet.</p>
    @else
        <div class="menu_container">
            @foreach ($menus as $menu)
                <div class="menu_content">
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="">
                    <h3 style="margin-top: 15px">{{ $menu->name }}</h3>
                    <p>{{ $menu->category->category_name }}</p>
                    <div class="bottom">
                        <a href="{{ route('menu.show', $menu->id) }}" class="button">More</a>
                        <a href="{{ route('admin.dashboard', $menu->id) }}" class="button">Kelola</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
