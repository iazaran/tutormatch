@include('layouts.header')
<h2 class="text-center pb-5">Create new tutor</h2>
<form action="{{route('tutors.store')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
        @error('title')
            <div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
                {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @enderror
    </div>
    <div class="form-group mt-4">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" name="description" value="{{old('description')}}">
        @error('description')
        <div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@include('layouts.footer')