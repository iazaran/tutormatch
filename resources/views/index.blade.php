@include('layouts.header')
<h2 class="text-center pb-5">Tutors List</h2>
<div class="list-group">
    <div class="list-group-item list-group-item-action bg-light">
        <h4 class="mb-1">Title</h4>
        <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
        <div class="mt-2 d-flex justify-content-end">
            <a href="{{route('tutors.edit', ['tutor' => 1])}}" role="button" class="btn btn-secondary mr-2">Update</a>
            <form action="{{route('tutors.destroy', ['tutor' => 1])}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@include('layouts.footer')