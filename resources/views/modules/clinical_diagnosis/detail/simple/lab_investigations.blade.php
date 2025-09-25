
                    <div class="table-responsive">
                        <table class="table mb-10 border table-rounded" style="width: 100%">
                            <thead>
                                <tr
                                    class="text-center text-gray-800 border-gray-200 fw-bold fs-6 border-bottom-2 bg-primary-subtle">
                                    <th class="py-5" colspan="3" scope="col">
                                        Investigations
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0" style="width: 35%">
                                        <table class="table mb-0 table-hover table-striped gs-5 gy-5"
                                            style="border-collapse: collapse;">
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-6">
                                                    <th scope="col">Pathology</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($CdInvestigationsPathology as $investigation)
                                                <tr>
                                                    <td>{{$investigation->investigation_name}} </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-danger"><small>N/A</small>&nbsp;</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="p-0" style="width: 33.33%">
                                        <table class="table mb-0 table-hover table-striped gs-5 gy-5"
                                            style="border-collapse: collapse;">
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-6">
                                                    <th class="px-5" scope="col">Radiology</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($CdInvestigationsRadiology as $investigation)
                                                <tr>
                                                    <td>{{$investigation->investigation_name}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-danger"><small>N/A</small>&nbsp;</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </td>

                                    <td class="p-0" style="width: 33.33%">
                                        <table class="table mb-0 table-hover table-striped gs-5 gy-5"
                                            style="border-collapse: collapse;">
                                            <thead>
                                                <tr class="text-gray-800 fw-bold fs-6">
                                                    <th scope="col">Rehabilitation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($CdInvestigationsRehablitation as $investigation)
                                                <tr>
                                                    <td>{{$investigation->investigation_name}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-danger"><small>N/A</small>&nbsp;</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
