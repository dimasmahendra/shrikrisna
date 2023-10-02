<div class="modal fade" id="modalprint" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content p-3 b-r-10">
            <div class="modal-header p-t-5">
                <h5 class="modal-title text-NEUTRAL100 fw-600 fs-15" id="exampleModalLongTitle">Last Measurement</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-item" action="{{ route('category.measurement.print', [$data->id]) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body p-t-5">
                    @foreach ($measurement as $item)
                        <div class="pb-2">
                            <div class="form-check border1 m-t-15">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="form-check-input form-check-primary view_checkbox" name="ids_measurement[{{ $item->id }}]" id="customColorCheck_{{ $item->id }}">
                                    <label class="form-check-label d-flex section-btn fs-12" for="customColorCheck_{{ $item->id }}">
                                        <p class="text-PRIMARY60 m-b-0">{{ ($item->category != null) ? ucwords($item->category->name) : "-" }}</p>
                                        <p class="text-SECONDARY60 m-b-0">{{ date("d F Y", strtotime($item->measurement_date)) }}</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-NEUTRAL100 h-45 fs-14 fw-600 w-100persen" id="button-submit">
                        <i class="icon-printer fs-20"></i>
                        Download
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>