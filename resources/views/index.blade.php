@include('layouts.header')
<h2 class="text-center pb-3">Tutors List</h2>
<div class="mb-5 d-flex justify-content-center">
    <a href="{{route('tutors.create')}}" role="button" class="btn btn-lg btn-secondary mr-2">Create new tutor</a>
</div>
<div class="list-group">
    @foreach($data as $key => $val)
        <div class="list-group-item list-group-item-action bg-light">
            <h4 class="mb-1">{{json_decode($key)->title}}</h4>
            <p class="mb-1">{{json_decode($key)->description}}</p>
            <div class="mt-2 d-flex justify-content-end">
                <a href="{{route('tutors.edit', ['tutor' => $val])}}" role="button" class="btn btn-secondary mr-2">Update</a>
                <form action="{{route('tutors.destroy', ['tutor' => $val])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@include('layouts.footer')