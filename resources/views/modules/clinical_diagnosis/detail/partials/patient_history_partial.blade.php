@php
$page = 'clinical_diagnosis';
@endphp
@isset($data)
@if (count($data) > 0)
@foreach ($data as $d)
<tr class="text-gray-800 border-gray-200 fw-semibold fs-6 border-bottom">
    <td>
        <!--begin::User-->
        <div class="d-flex align-items-center">
            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Info-->
            <div class="d-flex flex-column justify-content-center">
                <p class="mb-1 text-gray-800 text-hover-primary">@isset($d->patient_name)
                    {{$d->patient_name}}
                    @endisset </p>
            </div>
            <!--end::Info-->
        </div>
        <!--end::User-->
    </td>
    <td class="p-0">
        <!--begin::User-->
        <div class="d-flex align-items-center">
            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Info-->
            <div class="d-flex flex-column justify-content-center">
                <p class="mb-1 text-gray-800 text-hover-primary">@isset($d->doctor_name)
                    {{$d->doctor_name}}
                    @endisset </p>
            </div>
            <!--end::Info-->
        </div>
        <!--end::User-->
    </td>
    <td class="p-0"> {{($d->created_at)->format('d/m/Y H:i')}} </td>
    <td class="p-0"> {{$d->counter_name}} / {{$d->count}} </td>
    <td class="p-0"> {{$d->h_abbreviation}} </td>
    <td class="p-0">
        <!--begin::User-->
        <div class="d-flex align-items-center">
            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Info-->
            <div class="d-flex flex-column justify-content-center">
                <a href="" class="mb-1 text-gray-800 text-hover-primary">@isset($d->patient_mr_number)
                    {{$d->patient_mr_number}}
                    @endisset </a>
            </div>
            <!--end::Info-->
        </div>
        <!--end::User-->
    </td>
    {{-- <td class="mb-1 text-gray-800">
        @isset($d->status)
        {{ ucfirst($d->status) }}
        @endisset
    </td> --}}

    <td class="p-0">
        <div class="d-flex justify-content-center align-items-center">

            <a title="Preview" href="{{route($page.'.preview', ['id' => $d->id])}}" data-id="{{$d->id}}"
                class="btn btn-icon btn-active-light-success w-30px h-30px preview-{{$page}}"
                data-kt-permissions-table-filter="delete_row">
                <i class="ki-duotone ki-eye fs-3 text-success">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
            </a>

            @if($d->user == auth()->user()->id || strtolower(auth()->user()->role->name) == "super admin")

            <a title="Detail" href="{{route($page.'.detail_form',$d->id)}}">
                <button
                    class="btn btn-icon btn-active-light-primary w-30px h-30px" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_update_permission">
                    <i class="ki-duotone ki-document fs-3 text-info">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </a>

            @endif

        </div>
    </td>
</tr>

@endforeach
@else
<tr class="text-danger border-gray-200  border-bottom">
    <td class="fs-7 text-center pt-8" colspan="7">
        No patient history found
    </td>
</tr>
@endif
@endisset
