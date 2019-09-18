@extends('layouts.header')

@section('content')
<section class="content">
    <div class="row justify-content-center">
        <div class="card">
            <section class="content">
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <a href="{{'user/user'}}">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>{{$users}}</h3>
                                    <p>Total Users</p>
                                </div>
                                <div class="icon"><i class="fa fa-user"></i></div>
                                <span class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
