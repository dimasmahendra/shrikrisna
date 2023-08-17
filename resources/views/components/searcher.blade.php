<form action="" id="src-form" method="get">
    <div class="row">
        <div class="col-md-8">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <label for="inputPassword6" class="col-form-label">Search</label>
                </div>
                <div class="col-md-10">
                    <input type="search" autocomplete="off" autofocus id="sercher-inp" value="{{isset($_GET['src_key']) ? $_GET['src_key'] : ""}}" 
                    class="form-control" name="src_key" placeholder="Search">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group position-relative has-icon-left" id="filter-tanggal">
                <input type="search" autocomplete="off" autofocus id="tanggalclaim" class="form-control" 
                value="{{isset($_GET['tanggal']) ? $_GET['tanggal'] : ""}}"
                name="tanggal" placeholder="Select Date">
                <div class="form-control-icon">
                    <i class="bi bi-calendar"></i>
                </div>
            </div>
        </div>
    </div>
</form>
