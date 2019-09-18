<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-info">
            <div class="box-body box-profile">
                   <img class="profile-user-img img-responsive img-circle"
                        src="{{asset('assets/images/user.png')}}" alt="User profile picture">
                <h3 class="profile-username text-center">{{$user->name}}</h3>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs border-bottom-0">
                <li class="active w-100"><a href="#activity" data-toggle="tab"><strong>Personal Information</strong></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered"  style="margin-bottom: 2px;">
                                <tbody>
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Joining Date</strong></td>
                                    <td>{{date('Y-m-d',strtotime($user->created_at))}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.post -->
                </div>
                <!-- /.tab-pane -->
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
            <!-- /.col -->
</div>
        <!-- /.row -->
