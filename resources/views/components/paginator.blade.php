@if ($paginator->hasPages())

    <div class="d-flex justify-content-end">
        <div class="paginater-total">
            Total {{ $paginator->total() }} Items
        </div>
        <div id="pagination"></div>
    </div>

    <script>
        let pages = {{ $paginator->lastPage() }};
        let currentPage = {{ $paginator->currentPage() }};
    </script>
@endif