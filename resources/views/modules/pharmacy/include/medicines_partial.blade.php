@isset($treatment_data)
<div class="table-responsive">
<table class="table">
    <thead>
        <tr class="text-gray-800 fw-bold fs-6">
            <th>Medicine</th>
            <th>Dosage</th>
            <th>Interval</th>
            <th>Duration</th>
            <th>Instructions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($treatment_data as $td)
        <tr>
            <td>{{$td->medicine_name}} &nbsp;</td>
            <td class="column-left">{{$td->treatment_dosage_name}} &nbsp;</td>
            <td class="column-left">{{$td->treatment_dose_interval}} &nbsp;</td>
            <td class="column-left">{{$td->treatment_duration}} &nbsp;</td>
            <td class="column-left">{{$td->remarks}} &nbsp;</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@else
<div class="table-responsive">
<table class="table">
    <thead>
        <tr class="text-gray-800 fw-bold fs-6">
            <th>Medicine</th>
            <th>Dosage</th>
            <th>Interval</th>
            <th>Duration</th>
            <th>Instructions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          No Data Found
        </tr>
    </tbody>
</table>
</div>
@endisset
