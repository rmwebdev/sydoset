
<html>
    <head>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CETAK LIST ARSIP SPD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!--    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">-->
    <style>

    @page {
      
      margin: auto;
    }
             

        
    @font-face {
       font-family: 'Rubik', sans-serif;
       font-style: normal;
       font-weight: 200;
        src:url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;900&display=swap') format("truetype");
        
    }
        
     body {
         font-family: 'Rubik', sans-serif;
         /* font-size:12px; */
         color: #1d1e4b;
         
      font-style: normal;
     }
        
        
     #printDocArsip tbody td {
    padding: 5px 5px !important;
    /* line-height: 1.0; */
}
    #printDocArsip thead td {
        padding: 0px 0px !important;
        /* line-height: 1.0; */
    }
     .font_style {
      height: 11px;
      font-family: 'Rubik', sans-serif;
/*      font-size: 12px;*/
/*      font-weight: 500;*/
      font-stretch: normal;
      font-style: normal;
      line-height: 1; 
      letter-spacing: normal;
      text-align: center;
      color: #1d1e4b;
     }
        .font12px{
            
            font-size: 10px;
             width:auto;
            line-height:10px;
        }
        .font8px{
            
            font-size: 8.5px;
            width:auto;
            line-height:8.5px;
        }
         .font6px{
            
            font-size: 7.5px;
            width:auto;
            line-height:7.5px;
        }
        
        .judul {
            text-decoration: underline;
            font-size: 16px;
            font-family: 'Rubik', sans-serif;
            color:#1d1e4b;
            
        }
      
            #footer{
                        position:absolute;
                        margin:0;
                        padding:0;
                        left: 0;
                        right: 0;
                        bottom:0;
                        float: bottom;
                    }
            
            .page-break{
                page-break-before: always;
            }
/*            #page_num:before { content: counter(page); }:before { content: counter(page); }*/                                 
            
            .pagenum:after {
/*                content: counter(page);*/
                content: "Halaman " counter(page) " - " ; 
                }
          
            
    </style>
        
 
    </head>
    <body>
        <?php 
            $indexKey = 0; 
            $font_sz = 'font12px';
            if(count($kolom_header)>=6) {
            $font_sz = 'font8px';
            }
            if(count($kolom_header)>8){
            $font_sz = 'font6px'; 
            }
            
            $varMod = 30;
            $br = (count($documents)/$varMod)-1;
            $total = ceil(count($documents)/$varMod);
            ?>
    
    <div class="content mb-4 mt-3 ml-3 mr-3">
        
    
        <header >
            @if(count($documents) > 30)
            
            <p style="padding-top:50px;font-style: italic;float:right; font-size:10px;">
            <small class="pagenum"></small><small><?= $total; ?></small>
            </p>
            @endif
            
        <center style="margin: auto; width:50%">
            <h4 class="judul">SERAH TERIMA DOKUMEN SPD</h4>
          
        </center>
        
                                            
        <table class="display mb-3" style="width:100%; font-size:10px;">
         <tr class="tbl">
            <th style="width:150px;">Kode Pengarsipan</th>
            <th style="width:10px;">:</th>
            <td>{{ $kode_arsip }}</td>
        </tr>
        <tr class="tbl">
            <th style="width:50px;">Tanggal Pengarsipan</th>
            <th>:</th>
            
            <td>{{ $tanggal_arsip }}</td>
         
        </tr>
        <tr class="tbl">
            <th style="width:50px;">Nama Messenger</th>
            <th>:</th>
            <td>{{ $messenger }}</td>
        </tr>  
        </table>
        </header>
        <table id="printDocArsip" class="table nowrap" style="width:100%; font-size:smaller; text-align:center; border-top: 2px solid #6666; border-bottom:2px solid #6666;color:#1d1e4b;">
          
            <thead style="border-bottom: solid 2px #6666; border-top: solid 2px #6666;">
                <tr>
                    <th class="<?=$font_sz;?>" style="width:10px;">NO</th>
                    
                    @foreach($kolom_header as $row)
                    
                        <th class="<?=$font_sz;?>">{{ $row }}</th>

                    @endforeach()
                       
    
               </tr>
            </thead>
            <tbody  style="padding: 5px 5px !important;line-height: 1.0;">
                
                <?php 
                    $a=1;
                   
                ?>

                @foreach($documents as $indexKey =>$row)
                
                    <tr>
                        <td class="<?=$font_sz;?>" style="width:10px;">{{ $indexKey+1 }}</td>
                        @foreach($kolom_table as $obj)
                            <td class="<?php echo $font_sz;?>">{{ $row->$obj }}</td>
                        @endforeach()
                        
                    </tr>
                    @if($a % $varMod == 0 )
                        @if($br > 0)
                            </tbody>
                            
                        </table>
            @if(count($documents) >= 30)
            <footer style="position: absolute; bottom: -1px; text-align: center; width:100%; margin-top:3px;">
                <small style="margin: auto; text-align: center; justify-content:center; margin-top:5px ">Date : <?php echo date("d-m-Y H:i"); ?> | User: {{ Session::get('nama_user')." ".Session::get('nama_user_last')}} | Jabatan: {{ Session::get('role')." ".Session::get('role_last')}}</small>
    
            </footer>
            @endif  
                    <center>
                  
                     
                 
                            <div class="page-break"></div>
                        
        
                            <header > 
                                <p style="padding-top:50px;font-style: italic;float:right; font-size:10px;">
                                <small class="pagenum"></small><small><?= $total;?></small>
                                </p>
                                    
                                <center style="margin-top:25px;">
                                    <h4 class="judul" style="margin:auto; width:50%">SERAH TERIMA DOKUMEN SPD</h4>
                                
                                </center>
                            
                                                                
                            <table class="display mb-3" style="width:100%; font-size:10px;">
                                <tr class="tbl">
                                    <th style="width:150px;">Kode Pengarsipan</th>
                                    <th style="width:10px;">:</th>
                                    <td>{{ $kode_arsip }}</td>
                                </tr>
                                <tr class="tbl">
                                    <th style="width:50px;">Tanggal Pengarsipan</th>
                                    <th>:</th>
                                    <td> {{ $tanggal_arsip }}</td>
                                    
                                </tr>
                                <tr class="tbl">
                                    <th style="width:50px;">Nama Messenger</th>
                                    <th>:</th>
                                    
                                    <td>{{ $messenger }}</td>
                                </tr>  
                            </table>
                        </header>
                        
                            <table id="printDocArsip" class="table nowrap" style="width:100%; font-size:smaller; text-align:center; border-top: 2px solid #6666; border-bottom:2px solid #6666;color:#1d1e4b;">
                                <thead style="border-bottom: solid 2px #6666; border-top: solid 2px #6666;">
                                    <tr>
                                        <th class="<?=$font_sz;?>" style="width:10px;">NO</th>
                    
                                        @foreach($kolom_header as $row)

                                        <th class="<?= $font_sz;?>">{{ $row }}</th>



                                        @endforeach()              
                                    </tr>
                                </thead>
                                <tbody  style="padding: 5px 5px !important;line-height: 1.0;">
                        @endif
                        <?php $br--;?>
                    @endif

                    <?php $a++;?>
                @endforeach
                
       
            </tbody>
        </table>    
               
        
                    <div id="footer" style="margin-bottom: 15px;">
                        <center>
                            <table width="100%" style="text-align:center;font-size:9pt">
                                <tr>
                                    {{-- <td></td> --}}
                                    
                                    <td>Dikirim Oleh,</td>
                                    <td>Diterima Oleh,</td>
                                    <td>Messenger,</td>
                                    
                                </tr>
                                <tr>
                                
                                    
                                    <td style="padding-top:40px;text-transform:uppercase;font-size:50%;">______________________________________</td>
                                    <td style="padding-top:40px;text-transform:uppercase;font-size:50%;">______________________________________</td>
                                    <td style="padding-top:40px;text-transform:uppercase;font-size:50%;">______________________________________</td>
                                    
                                </tr>
                            </table>
                        </center>
            </div>
            <footer style="position: absolute; bottom: -3px; text-align: center; width:100%; margin-top:3px;">
                <small style="margin: auto; text-align: center; justify-content:center; margin-top: 5px;">Date : <?php echo date("d-m-Y H:i:s"); ?> || User: {{ Session::get('nama_user')." ".Session::get('nama_user_last')}} || Jabatan: {{ Session::get('role')." ".Session::get('role_last')}}</small>

            </footer>
    </div>
    
    
       <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        
       <script type="text/javascript">
          $(document).ready(function() {
       $('#printDocArsip').DataTable( {
           
        // columnDefs: [ {
        //            // data:'id',
        //            className: 'dt-td-center',
        //            targets: [0,2,3,4]
        //            } ],
        columnDefs: [ 
            {className: 'dt-td-left',targets: [1]} ,
        ],
          columnDefs: [ 
            {className: 'dt-td-center',targets: [0], width:'8px'} ,
        ],
       } );
    } );
        
        
        </script>
    </body>
      
    </html>