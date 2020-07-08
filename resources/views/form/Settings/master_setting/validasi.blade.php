@extends('layout.master')

@section('title','Setting Management')

@section('css')

<style type="text/css">

.custom-tab .nav-tabs > a.active:after {
    background-color: #1d1e4b;
}
.nav-tabs {
    border-bottom-color: #1d1e4b;
}


.item_menu{
    font-size: 10px;
    font-weight: bold;
    color:  #1d1e4b;
}
.label_check{
    
    margin-left: 3%;
    text-align:center;
}
.menu-item{
    margin-bottom: -75px;
   
}
.border-{
    border:2px solid #1d1e4b;
}
</style>



@endsection


@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="margin-bottom:0px !important">
                <div class="row">
                    <div class="col-lg-12" style="margin-top:-20px;">
                        <div class="card-body" style="min-height:90vh">
                            <div class="card-body" style="margin-top:-20px;">
                                <div class="custom-tab">
                                    <nav class="mt-2 mb-2" style="border-bottom: 1px solid #1d1e4b;">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active show" id="custom-nav-home-tab" data-toggle="tab" href="#custom-nav-home" role="tab" aria-controls="custom-nav-home" aria-selected="false">SPK</a>
                                        <a class="nav-item nav-link " id="custom-nav-profile-tab" data-toggle="tab" href="#custom-nav-profile" role="tab" aria-controls="custom-nav-profile" aria-selected="true">SPK Trailer</a>
                                        <a class="nav-item nav-link" id="custom-nav-contact-tab" data-toggle="tab" href="#custom-nav-contact" role="tab" aria-controls="custom-nav-contact" aria-selected="false">SPD</a>
                                        </div>
                                    </nav>

                                    <div class="tab-content pl-3 pt-2 mt-2" id="nav-tabContent" style="border:hidden;">
                                        <div style="width:100%; margin-left:-16px;" class="tab-pane fade active show" id="custom-nav-home" role="tabpanel" aria-labelledby="custom-nav-home-tab">
                                        <h5 style="text-decoration:underline; color: #1d1e4b;">Pilih syarat settle Operation</h5>
                                        <ul class="nav navbar-nav mt-3" style="margin-left:-16px;">
                                            <li class="menu-item">
                                                <div class="col-md-2 float-left">
                                                    <p class="item_menu">Barcode Status</p>
                                                </div>
                                                <div class="col-md-4 float-left">
                                                    <div class="card border-">
                                                    <div class="card-body" style="min-height:120px;">
                                                        <div>
                                                        <label class="containerCheck" style="width:18px !important; ">
                                                            <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                        </label>
                                                        <label class="label_check">Barcode Sudah Pairing</label>
                                                        </div>
                                                        <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Barcode Belum Pairing</label>
                                                        </div>
                                                            
                                                    </div>
                                                    
                                                    </div>
                                                </div>

                                            </li>

                                            <li class="menu-item">
                                                <div class="col-md-2 float-left">
                                                    <p class="item_menu">Paid Status</p>
                                                </div>
                                                <div class="col-md-4 float-left">
                                                    <div class="card border-">
                                                    <div class="card-body" style="min-height:120px;">
                                                        <div>
                                                        <label class="containerCheck" style="width:18px !important; ">
                                                            <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                        </label>
                                                        <label class="label_check">Voucer Paid</label>
                                                        </div>
                                                        <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Voucer no paid</label>
                                                        </div>

                                                        <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Voucer Cancel</label>
                                                        </div>
                                                            
                                                    </div>
                                                    
                                                    </div>
                                                </div>

                                            </li>
                                            <li class="menu-item" style="margin-top:-62px;"> 
                                                <div class="col-md-2 float-left">
                                                    <p class="item_menu">Kelengkapan Dokumen</p>
                                                </div>
                                                <div class="col-md-4 float-left">
                                                    <div class="card border-">
                                                    <div class="card-body" style="min-height:120px;">
                                                        <div>
                                                        <label class="containerCheck" style="width:18px !important; ">
                                                            <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                        </label>
                                                        <label class="label_check">Lengkap</label>
                                                        </div>
                                                        <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Tidak Lengkap</label>
                                                        </div>
                                                            
                                                    </div>
                                                    
                                                    </div>
                                                </div>

                                            </li>
                                        </ul>
                                              <div style="width:100%;">
                                    <div class="button-items mt-5 float-right">
                                       <button type="button" class="btn btn-info waves-effect " onclick="openMdl()"  style="width:150px;margin-right: 23px;">Simpan</button> 

                                    </div>
                                </div>
                                    
                                        </div>
                                        <div style="width:100%; margin-left:-16px;" class="tab-pane fade " id="custom-nav-profile" role="tabpanel" aria-labelledby="custom-nav-profile-tab">
                                            <h5 style="text-decoration:underline; color: #1d1e4b;">Pilih syarat settle Operation</h5>
                                            <ul class="nav navbar-nav mt-3" style="margin-left:-16px;">
                                                <li class="menu-item">
                                                    <div class="col-md-2 float-left">
                                                        <p class="item_menu">Barcode Status</p>
                                                    </div>
                                                    <div class="col-md-4 float-left">
                                                        <div class="card border-">
                                                        <div class="card-body" style="min-height:120px;">
                                                            <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Barcode Sudah Pairing</label>
                                                            </div>
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Barcode Belum Pairing</label>
                                                            </div>
                                                                
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
    
                                                </li>
    
                                                <li class="menu-item">
                                                    <div class="col-md-2 float-left">
                                                        <p class="item_menu">Paid Status</p>
                                                    </div>
                                                    <div class="col-md-4 float-left">
                                                        <div class="card border-">
                                                        <div class="card-body" style="min-height:120px;">
                                                            <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Voucer Paid</label>
                                                            </div>
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Voucer no paid</label>
                                                            </div>
    
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Voucer Cancel</label>
                                                            </div>
                                                                
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
    
                                                </li>
                                                <li class="menu-item" style="margin-top:-62px;"> 
                                                    <div class="col-md-2 float-left">
                                                        <p class="item_menu">Kelengkapan Dokumen</p>
                                                    </div>
                                                    <div class="col-md-4 float-left">
                                                        <div class="card border-">
                                                        <div class="card-body" style="min-height:120px;">
                                                            <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Lengkap</label>
                                                            </div>
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Tidak Lengkap</label>
                                                            </div>
                                                                
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
    
                                                </li>
                                            </ul>
                                <div style="width:100%;">
                                    <div class="button-items mt-5 float-right">
                                       <button type="button" class="btn btn-info waves-effect " onclick="openMdl()"  style="width:150px;margin-right: 23px;">Simpan</button> 

                                    </div>
                                </div>
                            </div>
                                        <div style="width:100%; margin-left:-16px;" class="tab-pane fade" id="custom-nav-contact" role="tabpanel" aria-labelledby="custom-nav-contact-tab">
                                            <h5 style="text-decoration:underline; color: #1d1e4b;">Pilih syarat settle Operation</h5>
                                            <ul class="nav navbar-nav mt-3" style="margin-left:-16px;">
                                                <li class="menu-item">
                                                    <div class="col-md-2 float-left">
                                                        <p class="item_menu">Barcode Status</p>
                                                    </div>
                                                    <div class="col-md-4 float-left">
                                                        <div class="card border-">
                                                        <div class="card-body" style="min-height:120px;">
                                                            <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Barcode Sudah Pairing</label>
                                                            </div>
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Barcode Belum Pairing</label>
                                                            </div>
                                                                
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
    
                                                </li>
    
                                                <li class="menu-item">
                                                    <div class="col-md-2 float-left">
                                                        <p class="item_menu">Paid Status</p>
                                                    </div>
                                                    <div class="col-md-4 float-left">
                                                        <div class="card border-">
                                                        <div class="card-body" style="min-height:120px;">
                                                            <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Voucer Paid</label>
                                                            </div>
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Voucer no paid</label>
                                                            </div>
    
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Voucer Cancel</label>
                                                            </div>
                                                                
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
    
                                                </li>
                                                <li class="menu-item" style="margin-top:-62px;"> 
                                                    <div class="col-md-2 float-left">
                                                        <p class="item_menu">Kelengkapan Dokumen</p>
                                                    </div>
                                                    <div class="col-md-4 float-left">
                                                        <div class="card border-">
                                                        <div class="card-body" style="min-height:120px;">
                                                            <div>
                                                            <label class="containerCheck" style="width:18px !important; ">
                                                                <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                            </label>
                                                            <label class="label_check">Lengkap</label>
                                                            </div>
                                                            <div>
                                                                <label class="containerCheck" style="width:18px !important; ">
                                                                    <input type="checkbox" value="" class="check"><span class="checkmark"></span>
                                                                </label>
                                                                <label class="label_check">Tidak Lengkap</label>
                                                            </div>
                                                                
                                                        </div>
                                                        
                                                        </div>
                                                    </div>
    
                                                </li>
                                            </ul>
                                              <div style="width:100%;">
                                    <div class="button-items mt-5 float-right">
                                       <button type="button" class="btn btn-info waves-effect " onclick="openMdl()"  style="width:150px;margin-right: 23px;">Simpan</button> 

                                    </div>
                                </div>
                                        
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                         
                </div> <!-- /.row -->
            </div>
        </div><!-- /# column -->
    </div>




@endsection

@section('js')

@endsection