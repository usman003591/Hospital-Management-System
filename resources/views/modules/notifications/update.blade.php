@php
    $page = 'notifications';
    $sc = 'Notifications';
@endphp

@extends('layouts.master', [
    'activeMenu' => 'notification_management',
    'activeSubMenu' => $page,
    'activeThirdMenu' => $page
])

@section('breadcrumbs')
<div id="kt_app_toolbar" class="py-3 app-toolbar py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="flex-wrap page-title d-flex flex-column justify-content-center me-3">
            <h1 class="my-0 text-gray-900 page-heading d-flex fw-bold fs-3 flex-column justify-content-center">
                Update {{ $sc }}
            </h1>
            <ul class="pt-1 my-0 breadcrumb breadcrumb-separatorless fw-semibold fs-7">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted text-hover-primary">
                    <a href="{{ route('notifications.index') }}">{{ titlefilter($page) }}</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bg-gray-500 bullet w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted text-hover-primary">Update</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-xl-12">
    <div class="mb-5 card card-xl-stretch mb-xl-8">
        <form class="form" action="{{ route('notifications.update', $obj->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card-body">
                <h3 class="mb-6 font-size-lg text-dark font-weight-bold">{{ $sc }} Info</h3>
                        <div class="form-group row">
                            <label class="text-right col-lg-3 col-form-label">Hospital <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-6">

                                <label
                                    class="text-right col-form-label">{{ getActiveHospitalName($preferences['preference']['hospital_id']) }}</label>
                                <input type="hidden" name="hospital_id"
                                    value="{{ $preferences['preference']['hospital_id'] }}">

                                <div>
                                </div>
                            </div>
                        </div>
                        <br>
                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Name <span class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <input type="text" id="title" name="name" class="form-control" value="{{ old('name', $obj->name) }}" placeholder="Enter name" maxlength="100" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Slug <span class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <input type="text" id="slug" name="notification_slug" class="form-control" value="{{ old('notification_slug', $obj->notification_slug) }}" placeholder="Enter slug" readonly>
                        @error('notification_slug') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Description</label>
                    <div class="col-lg-6">
                        <textarea name="description" id="en_description" class="form-control" rows="3" placeholder="Enter description" maxlength="500">{{ old('description', $obj->description) }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Category <span class="text-danger">*</span></label>
                    <div class="col-lg-6">
                        <select name="notification_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('notification_category_id', $obj->notification_category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('notification_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <br>
                <div class="form-group row">
         <label class="text-right col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
       <div class="col-lg-6">
        <select name="status" class="form-control" required>
            <option value="1" {{ old('status', $obj->status) == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('status', $obj->status) == 0 ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        </div>



            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3 text-end">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const a = 'àáäâãåăæçèéëêǵḧìíïîḿńǹñòóöôœøṕŕßśșțùúüûǘẃẍÿź·/_,:;';
    const b = 'aaaaaaaaceeeeghiiiimnnnooooooprssstuuuuuwxyz------';
    const p = new RegExp(a.split('').join('|'), 'g');

    document.getElementById('title').addEventListener('keyup', function() {
        document.getElementById('slug').value = this.value
            .toLowerCase()
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
            .replace(/&/g, '-and-') // Replace & with 'and'
            .replace(/[^\w\-]+/g, '') // Remove non-word characters
            .replace(/\-\-+/g, '-') // Replace multiple hyphens with single
            .replace(/^-+/, '') // Trim hyphens from start
            .replace(/-+$/, ''); // Trim hyphens from end
    });
</script>
<script>
function initMCEexact(e){
var direction = 'ltr';
if (e === 'ar_description') {
direction = 'rtl';
}
var skin_color = 'oxide';
var editor_content_css = 'default';
tinymce.init({
selector : "textarea#"  +  e,
height : "480",
directionality: direction,
content_css : editor_content_css,
skin: skin_color,
//content_css: editor_content_css
setup: function (editor) {
    editor.on('change', function () {
        tinymce.triggerSave();
    });
    editor.on('keydown', function (e) {
        let content = editor.getContent({ format: 'text' }); // plain text only
        if (content.length >= 500 && e.keyCode !== 8 && e.keyCode !== 46) {
            e.preventDefault();
        }
    });

    editor.on('keyup', function () {
        let content = editor.getContent({ format: 'text' });
        if (content.length > 500) {
            editor.setContent(content.substring(0, 500));
        }
    });
},
menubar: 'insert view code restoredraft insertdatetime toc',
toolbar: 'undo redo | code | styleselect | fontselect |  alignleft aligncenter alignright alignjustify | bold italic underline |  image | media |  link | preview | code | fullscreen | numlist | bullist ',
plugins: 'code table fullscreen lists advlist autosave image insertdatetime link preview toc visualblocks wordcount textpattern quickbars charmap directionality anchor autoresize media',
});
}

initMCEexact("en_description");

</script>
@endsection
