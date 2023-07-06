@extends('frontend.main_master')
@section('content')

<div class="body-content">
    <div class="container">
        <div class="row">
            
            @include('frontend.common.user_sidebar')

            <div class="col-md-2">

            </div> <!-- // end col md 2 -->

            <div class="col-md-6">

                <div class="card">
                    <h3 class="text-center">
                        <span class="text-danger">Hi...</span>
                        <strong>{{ Auth::user()->name }}</strong>
                        Update Your Profile
                    </h3>
                    <div class="card-body">
                        <form action="{{ route('user.profile.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Name</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control unicase-form-control text-input">
                            </div>

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control unicase-form-control text-input">
                            </div>

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="form-control unicase-form-control text-input">
                            </div>

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">User Image</label>
                                <input type="file" id="profile_photo_path" name="profile_photo_path" value="{{ $user->profile_photo_path }}" class="form-control unicase-form-control text-input">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div> <!-- // end col md 2 -->
        </div> <!-- // end row -->
    </div>
</div>

@endsection