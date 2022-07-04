@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Blog Category Page</h4> <br>
                            <form method="post" id="myForm" action="{{route('store.blog.category')}}">
                                @csrf
                                {{--<input type="hidden" name="id"  value="{{$about_page->id}}">--}}

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category</label>
                                    <div class="col-sm-10 form-group">
                                        <input name="blog_category" class="form-control" type="text"  id="example-text-input">
                                        @error('blog_category')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->
                                <input type="submit" class="btn btn-info  waves-effect waves-light" value="Insert Blog Category">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#myForm').validate({
                rules:{
                    blog_category:{
                        required:true,
                        minlength:3,
                        maxlength:50
                    }
                },
                messages:{
                    blog_category:{
                        required:"Please enter blog category",
                        minlength:"Blog category must be at least 3 characters",
                        maxlength:"Blog category must be at most 50 characters"
                    },
                },
                errorElement : 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
