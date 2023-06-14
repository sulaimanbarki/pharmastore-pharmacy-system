@extends('layouts.frontend.app')

@section('content')

<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('main_home')}}">Home</a></li>
                    <li class="breadcrumb-item active">About Us</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<!-- Cart Page Start -->
<main class="contact_area inner-page-sec-padding-bottom">
    <div class="container">

        <div class="row mt--60 ">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="contact_adress">
                    <div class="ct_address">
                        <h3 class="ct_title">About us</h3>
                        
<p>Welcome to NetMed, your number one source for all things [product]. We're dedicated to giving you the very best of [product], with a focus on [store characteristic 1], [store characteristic 2], [store characteristic 3].</p>


<p>Founded in [year] by [founder name], NetMed has come a long way from its beginnings in [starting location]. When [founder name] first started out, [his/her/their] passion for [brand message - e.g. "eco-friendly cleaning products"] drove them to [action: quit day job, do tons of research, etc.] so that NetMed can offer you [competitive differentiator - e.g. "the world's most advanced toothbrush"]. We now serve customers all over [place - town, country, the world], and are thrilled that we're able to turn our passion into [my/our] own website.</p>


<p>[I/we] hope you enjoy [my/our] products as much as [I/we] enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact [me/us].</p>


Sincerely,

[founder name]


                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Cart Page End -->
@endsection