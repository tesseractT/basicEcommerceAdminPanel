@extends('admin.admin_master')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Portfolio Edit Page</h4>

                        <form method="post" action="{{route('update.portfolio')}}" enctype="multipart/form-data"> @csrf

                            <input type="hidden" name="id" value="{{$portfolio->id}}">

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="portfolio_name" type="text" value="{{$portfolio->portfolio_name}}" id="example-text-input">
                                    @error('portfolio_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="portfolio_title" type="text" value="{{$portfolio->portfolio_title}}" id="example-text-input">
                                    @error('portfolio_title')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Portfolio Description</label>
                                <div class="col-sm-10">
                                    <textarea id="elm1" required="" name="portfolio_description" value="{{$portfolio->portfolio_description}}" class="form-control" rows="5" >

                                    </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Portfolio Image</label>
                                <div class="col-sm-10">
                                    <input class="form-control" name="portfolio_image" type="file"  id="portfolio_image">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img id="showImage" class="rounded avatar-lg" src="{{asset($portfolio->portfolio_image) }}" alt="Card image cap">

                                </div>
                            </div>
                            <input type="submit" value="Update Portfolio Page" class="btn btn-info waves-effect waves-light">
                        </form>
                        <!-- end row -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    });
</script>

@endsection
