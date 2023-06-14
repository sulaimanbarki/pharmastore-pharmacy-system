@extends('layouts.frontend.app')

@section('content')
        <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('main_home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Register</li>
                    </ol>
                </nav>
            </div>
        </div>
        </section>
        <!--=============================================
        =            Login Register page content         =
        =============================================-->
        <main class="page-section inner-page-sec-padding-bottom">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12  ">
                    <form action="{{ route('customer.signin.submit')}}" method="post">
                        @csrf
                        <div class="login-form">
                            <h4 class="login-title">Customer Login</h4>
                            {{-- <p><span class="font-weight-bold">I am a returning customer</span></p> --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('message'))
                                <div class="alert alert-{{session('type')}}" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="row">
                               
                                <div class="col-md-12 col-12 mb--15">
                                    <label for="email">Email*</label>
                                    <input class="mb-0 form-control" type="text" name="email" id="email" placeholder="email" value="{{ old('email')}}">
                                    @if($errors->has('email'))
                                    <span class="color-ff00">{{$errors->first('email')}}</span>
                                    @endif
                                </div>

                                <div class="col-12 mb--20">
                                    <label for="password">Password*</label>
                                    <input class="mb-0 form-control" name="password" type="password" id="password" placeholder="Password">
                                    @if($errors->has('password'))
                                    <span class="color-ff00">{{$errors->first('password')}}</span>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    
                                    <button type="submit" class="btn btn-outlined">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </main>
@endsection