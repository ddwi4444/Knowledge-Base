@extends('layouts.main')

@section('jumbotron')
<!-- Halaman untuk menampilkan daftar post berdasarkan unit tertentu berdasarkan id -->
    <div class="bg-video animate__animated animate__bounceInDown">
        <video playsinline autoplay muted loop poster="cake.jpg">
            <source src="/img/bg_videoblue.mp4" type="video/webm">
            Your browser does not support the video tag.
        </video>
        </div>

        <div class="justify-content-center animate__animated animate__bounceInDown">
            <div class="justify-content-center">
            <br>
            <br>
            <form action="{{ route('unit.search', $user->id_unit) }}" method="GET" class="mt-5 w-100 d-flex justify-content-center">                  
                <div class="input-group rounded justify-content-center">
                    <div class="form-outline w-50" style="margin-right: 5px;">
                    <input id="search-focus" type="search" id="form1" name="search" class="form-control w-100" />
                    <label class="form-label" value="{{ old('search') }}" for="form1">Search</label>
                    </div>
                    <button class="bg-transparent">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
                <p class="mt-3 d-flex justify-content-center">Apa yang dapat kami bantu?</p>       
        </div>
    </div>

@section('container')    
    <div class="container mt-5" style="margin-bottom: 50px;">
        <div class="row g-0 justify-content-center ms-1 p-0 m-0 responsive">
            <!-- Memanggil data post -->
            @foreach($posts as $post)
            <!-- Menyaring untuk menampilkan post berdasarkan id yang sama dengan parameter id unitnya -->
            @if($post->id_unit == $user->id_unit)
            <div class="col-md-2 responsive justify-content-center mt-5 d-flex">
                <article class="card__unit card responsive">
                    <div class="card__info-hover">        
                    </div>
                    <div class="card__img"></div>
                    <a href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug] )}}" class="card_link">
                        <div class="card__img--hover"><img style="height: 450px;" class="img_card" src="{{ asset('storage/'.$post->image) }}" alt=""></div>
                    <div class="card__info">
                        <div class="fitin" id="fitin">
                            <h5 class="card__title text-dark" id="fitin">{{ ($post->judul_post) }}</h5>
                        </div>                        
                        <p class="card__by text-dark">{{ $post->created_at }}</p></a>
                    </div>
                </article>
            </div>
            @endif
            @endforeach            
        </div>
    </div>
@endsection

