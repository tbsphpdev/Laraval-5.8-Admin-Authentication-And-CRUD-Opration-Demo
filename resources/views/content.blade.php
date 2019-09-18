@extends('layouts.header')
@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
            <button class="btn custom-btn" data-toggle="tooltip" onclick="add_content()">Add Content</button>
        </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</section>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade bd-example-modal-lg" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="modal-global">
                <form class="form-horizontal" id="form">
                    {{ @csrf_field() }}
                    <input name="id" type="hidden">
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="inputtitle">
                            Title
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" name="title" placeholder="enter title" required="" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label" for="inputtitle">
                            Content
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="inputtitle" name="content" placeholder="enter content" required="" rows="5"></textarea>
                            <span class="help-block">
                            </span>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-success" onclick="save()" type="button" id="btnSave">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var table;
    $(document).ready(function () {
        table = $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('content/list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                    },
            "columns": [
                { "data": "title" },
                { "data": "content" },
                { "data": "options" }
            ],
            "columnDefs": [{ "orderable": false, "targets": [2] }]	 

        });
    });
    function add_content() { 
        $('.form-group').removeClass('has-error');
        $('#form').trigger("reset");
        $('.help-block').empty();
        $('#modal_view').modal('show');
        $('.modal-title').text('Add Content');
        $("input[name='id']").val('');
        //$("input[name='title']").attr('disabled',false);
    }
    function save() { 
        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);
        var formData = new FormData($('#form')[0]);

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
                    $('#modal_view').modal('hide');
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
      function edit_record(id){ 
        $.ajax({
            url: "<?= $edit ?>/" + id,
            type: "GET",
            dataType: "json",
            success: function (data) { 
                $('.form-group').removeClass('has-error');
                $('#form').trigger("reset");
                $('.help-block').empty();
                $('#modal_view').modal('show');
                $('.modal-title').text('Edit Content');
                $("input[name='id']").val(data.id);
                $("input[name='title']").val(data.title);
                $("textarea[name='content']").val(data.content);
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

@endsection
