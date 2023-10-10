@extends('layouts.master')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<style>

    .about {
        margin-bottom: 2rem;
        text-align: center;
    }

    .about h2 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .about p {
        font-size: 1rem;
        margin-bottom: 1rem;
        font-family: "Source Code Pro", "SFMono-Regular", Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }
</style>

@section("about")

    <div class="about">
        <h2>About Me</h2>
        <p>
            Heya! I'm Amelia, a passionate developer with a love for lisp, go, java, and hating on non/weakly typed languages. I believe in the power of affection and dedication and hope to not be bored soo much ^-^
        </p>
        <p>
            With too little years of experience in web development, I've had the opportunity to make this crappy website. My journey in web development has been a painful experience, and I now hate css, js, and html with all my heart.
        </p>
        <p>
            When I'm not crying because of css or js, you can find me falling in love with lisp or reading fantasy books. I enjoy reading fantasy and love books and believe that they help me stay creative and balanced in my professional life.
        </p>

    </div>
@endsection
