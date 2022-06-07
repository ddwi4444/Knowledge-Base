@extends('layouts.main')

@section('jumbotron')
<!-- Halaman untuk menampilkan halaman home -->
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
            <form action="/search" method="GET" class="mt-5 w-100 d-flex justify-content-center">                  
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
    <div class="section_home animate__animated animate__fadeIn">

        <section class="article-list">
            <div class="container me-5">
                    
                <div class="intro animate__animated animate__fadeIn">
                    <h2 class="text-center">Knowledge Base</h2>
                </div>

                <div class="row articles mt-5 animate__animated animate__fadeIn">
                    <!-- Untuk memanggil setiap unit dari database -->
                    @foreach($users as $user)
                        <div class="col-sm-6 col-md-4 item mt-3">
                            <a href="{{ route('unit.posts', $user->id_unit) }}"><p class="text-primary fw-light" style="font-size:20px;">{{ $user->nama_unit }}</p></a>
                            <!-- Untuk memanggil post -->
                            @foreach ($posts as $post)
                                @if ($post->id_unit == $user->id_unit)
                                    <p style="line-height:0.5em;"><a class="text-dark text-underline-hover" href="{{ route('show', ['id_unit'=>$post->id_unit, 'slug'=>$post->slug] )}}">{{ Str::limit($post->judul_post, 40) }}</a></p>
                                @endif
                            @endforeach                        
                        </div>
                    @endforeach                 
                </div>
                

            </div>
        </section>

    </div>

    <br>
    <br>
    <br>
@endsection