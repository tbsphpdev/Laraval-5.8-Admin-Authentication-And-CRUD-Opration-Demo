@extends('layouts.header')
@section('content')
<section class="content">
    <div class="box-header with-border">
        <div class="box">
        <div class="box-header">
            <button class="btn custom-btn" data-toggle="tooltip" onclick="add_user()">Add User</button>
        </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Register Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var table;
    $(document).ready(function () {
        table = $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('user/list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                    },
            "columns": [
                { "data": "name" },
                { "data": "email" },
                { "data": "date" },
                { "data": "status" },
                { "data": "options" }
            ],
            "columnDefs": [{ "orderable": false, "targets": [4] }]	 

        });
    });
    function add_user() { 
        $('.form-group').removeClass('has-error');
        $('#form_user').trigger("reset");
        $('.help-block').empty();
        $('#modal_user').modal('show');
        $('.modal-title').text('Add User');
        $("input[name='id']").val('');
        //$("input[name='title']").attr('disabled',false);
    }
    function edit_record(id){ 
        
        $.ajax({
            url: "<?= $edit ?>/" + id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $('.form-group').removeClass('has-error');
                $('#form_user').trigger("reset");
                $('.help-block').empty();
                $('#modal_user').modal('show');
                $("#submit_button").html('Save');
                $('.modal-title').text('Edit User');
                $("input[name='id']").val(data.id);
                $("input[name='user_name']").val(data.name);
                $("input[name='user_email']").val(data.email);
                //$("input[name='title']").attr('disabled',true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.top-right').notify({
                    message: { text: 'Error'},
                    type:'danger'
                }).show();
            }
        });
    }
    function save() { 
        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);
        var formData = new FormData($('#form_user')[0]);
        
        $.ajax({ 
            url: "<?= $add ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data) {  
                                                                   
                if (data.status) {
                    
                    $('.top-right').notify({
                        message: { text: data.message },
                        type:'success'
                    }).show();
                    
                    $('#modal_user').modal('hide');
                    reload_table();
                } else {
                    if (data.inputerror.length) {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').closest('.form-group').addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').nextAll('.help-block').text(data.error_string[i]);
                        }
                    } else {
                        $('.top-right').notify({
                            message: { text: data.message },
                            type:'danger'
                        }).show();
                    }
                }
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.top-right').notify({
                    message: { text: data.message },
                    type:'danger'
                }).show();
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            }
        });
    }
    function delete_record(id){
        $.ajax({
            url: "<?= $delete ?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    $('.top-right').notify({
                        message: { text: data.message },
                        type:'success'
                    }).show();
                    reload_table();
                } else {
                    $('.top-right').notify({
                        message: { text: data.message },
                        type:'warning'
                    }).show();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.top-right').notify({
                    message: { text: data.message },
                    type:'danger'
                }).show();
            }
        });
    }
</script>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade bd-example-modal-lg" id="modal_user" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="modal-global">
                <form class="form-horizontal" id="form_user">
                    {{ @csrf_field() }}
                    <input name="id" type="hidden">
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="inputtitle">
                            Name
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" name="user_name" placeholder="enter name" required="" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="inputtitle">
                            Email
                        </label>
                        <div class="col-sm-10">
                        <input class="form-control" name="user_email" placeholder="enter email" required="" type="text">
                            <span class="help-block">
                            </span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-success" onclick="save()" type="button" id="btnSave">
                            save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="modal_view"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="modal-global">
               
            </div>
        </div>
    </div>
</div>
<script> 
    function view_record(id) { 
        $.ajax({
            url: "<?= $view ?>/" + id,
            type: "GET",
            dataType: "HTML",
            success: function (data) { 
                $('.modal-title').text('View User Details');
                $('#modal_view').modal('show');
                $("#modal_view").find('.modal-body').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) { 
               // notification('Error:', 'error', errorThrown);
            }
        });
    }
     function change_userstatus(id,status){
        $("div#divLoading").addClass('show');
        $.ajax({
            url: "<?= $userstatus ?>/"+id+'/'+status,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    $('.top-right').notify({
                        message: { text: data.message },
                        type:'success'
                    }).show();
                    $("div#divLoading").removeClass('show');
                    reload_table();
                } else {
                    $('.top-right').notify({
                        message: { text: data.message },
                        type:'warning'
                    }).show();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.top-right').notify({
                    message: { text: data.message },
                    type:'danger'
                }).show();
            }
        });
    }
</script>

@endsection

