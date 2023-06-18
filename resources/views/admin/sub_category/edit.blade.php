@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sub-categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" name="subCategoryForm" id="subCategoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select a category</option>
                                    @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category )
                                    <option {{($subCategory->category_id==$category->id)?'selected':''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$subCategory->name}}">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$subCategory->slug}}">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{($subCategory->status==1)?'selected':''}} value="1">Active</option>
                                    <option {{($subCategory->status==0)?'selected':''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('sub-categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $("#subCategoryForm").submit(function(event) {
        event.preventDefault();
        var element = $("#subCategoryForm");

        $.ajax({
            url: '{{route("sub-categories.update", $subCategory->id)}}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response) {


                if (response["status"] == true) {
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    $("#category_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    window.location.href = "{{route('sub-categories.index')}} "
                } else {
                    var errors = response['errors'];
                    if (errors['name']) {
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if (errors['slug']) {
                        $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
                    } else {
                        $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }
                    if (errors['category_id']) {
                        $("#category_id").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['category_id']);
                    } else {
                        $("#category_id").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                    }

                }
            },
            error: function(jqXHR, exception) {
                console.log("Something went wrong");
            }
        })
    });


    $('#name').change(function() {
        element = $(this);
        $.ajax({
            url: '{{route("getSlug")}}',
            type: 'get',
            data: {
                title: element.val()
            },
            dataType: 'json',
            success: function(response) {
                if (response["status"] == true) {
                    $("#slug").val(response["slug"]);
                }
            }
        });
    });
</script>
@endsection