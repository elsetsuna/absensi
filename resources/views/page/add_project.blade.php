@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">PROJECTS</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tambah Project baru</h4>
            </div><!-- end card header -->
            <form action="{{ route('project.store') }}" method="POST">
                @csrf
            <div class="card-body">
                <div class="live-preview">
                    <div class="row gy-4">
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="placeholderInput" class="form-label">Project Type</label>
                                <select class="form-select mb-3" name="type" aria-label="Default select example">
                                    <option value="google">Google</option>
                                    <option value="yandex" disabled>Yandex</option>
                                    <option value="duckduckgo" disabled>Duck Duck Go</option>
                                    <option value="bing" disabled>Bing</option>
                                </select>                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label">Search Engine Region</label>
                                <select class="form-select mb-3" name="region" aria-label="Default select example">
                                    <option selected="" disabled>Choose Region</option>
                                    <option value="id">Indonesia</option>
                                    <option value="th">Thailand</option>
                                    <option value="vn">Vietnam</option>
                                    <option value="mn">Myanmar</option>
                                    <option value="sg">Singapore</option>
                                    <option value="my">Malaysia</option>
                                </select>
                            </div>
                        </div> 
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="placeholderInput" class="form-label">Search Device</label>
                                <select class="form-select mb-3" name="device" aria-label="Default select example">
                                    <option selected="mobile">Mobile</option>
                                    <option value="desktop">Desktop</option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label">Search Location</label>
                                <select class="form-select mb-3" name="location" aria-label="Default select example">
                                    <option selected="" disabled>Choose your Location</option>
                                    <option value="id">Indonesia</option>
                                    <option value="th">Thailand</option>
                                    <option value="vn">Vietnam</option>
                                    <option value="mn">Myanmar</option>
                                    <option value="sg">Singapore</option>
                                    <option value="my">Malaysia</option>
                                </select>
                            </div>
                        </div> 
                        <!--end col-->
                        <div class="col-xxl-6 col-md-6">
                            <div>
                                <label for="labelInput" class="form-label">Input Domain atau Subdomain </label>
                                <input type="text" class="form-control" name="domain" id="placeholderInput" placeholder="Please use domain or subdomain only">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-6 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label">Keywords [ Pisahkan dengan tanda koma ]</label>
                                <textarea class="form-control" id="exampleFormControlTextarea5" rows="3"  name="keyword"></textarea>
                            </div>
                        </div> 
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
            <div class="card-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button> 
                </div>
            </div>
        </div>
        </form>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection