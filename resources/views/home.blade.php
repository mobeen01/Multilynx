@extends('layout.app')

@section('content')
    <section id="hero" class="d-flex align-items-center">
        <div class="container position-relative text-center text-lg-left" data-aos="zoom-in" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8">
                    <h1>Welcome to <span>Multilynx</span></h1>

                    <div class="btns text-center">
                        <a href="{{ url('addProduct') }}" class="btn-menu animated fadeInUp scrollto">Select Menu</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
