<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-PRIMARY90 fw-600 col-2">Description</th>
            <th class="text-PRIMARY90 fw-600 col-10" colspan="2">Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @for ($i = 0; $i < $item->total_rows; $i++)
                <tr>
                    @if ($i == 0)
                        <td rowspan='{{ $item->total_rows }}' class="center">{{ $item->description }}</td>
                    @endif
                    <td class="p-td-unset" width="25%">
                        <div class="col">
                            <input type="text" class="form-control" id="details[{{ $item->id }}][{{ $i }}][value]" 
                            name="details[{{ $item->id }}][value][]" value="">
                        </div>
                    </td>
                    <td class="p-td-unset">
                        <div class="col">
                            <input type="text" class="form-control" id="details[{{ $item->id }}][{{ $i }}][option]"
                            name="details[{{ $item->id }}][option][]" value="">
                        </div>
                    </td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>