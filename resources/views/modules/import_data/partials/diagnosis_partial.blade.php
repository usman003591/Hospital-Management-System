<div class="mb-5 card card-xl-stretch mb-xl-12" style="width: 73.5rem">
    <form class="form" action="{{route('opd_diagnosis.import')}}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card-body" style="height:20vh">
            <h3 class="mb-6 font-size-lg text-dark font-weight-bold">1. Import Diagnosis</h3>
            <div class="mb-15">
                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">File Browser:</label>
                    <div class="col-lg-6">
                        <input type="file" name="file" class="form-control custom-file-input" value="" id="file">
                        <br>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        @error('file')
                        {{ $message }}
                        @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="text-right col-lg-3 col-form-label">Import Template:</label>
                    <div class="col-lg-6">
                        @php
                        $name = 'diagnosis';
                        $url = getExcelSheetTemplateUrl($name);
                        @endphp
                        <a class="btn btn-sm btn-info" href="{{$url}}" download> Download </a>
                        <br>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-9"></div>
                <div class="col-lg-3 text-end">
                    <button type="submit" class="mr-2 btn btn-sm btn-primary">Submit</button>
                    <a href="{{route('import_opd_data')}}" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
