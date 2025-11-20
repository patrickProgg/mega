
<?php 
    $user_details = $this->Acct_mod->retrieveUserDetails();
?>

<style>
    
</style>


<!-- modal3 -->
<div class="modal fade text-left" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="modal"
                                    aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">STATUS HISTORY (<span id="span_status_hist"></span>)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i data-feather="x"></i>
        </button>
      </div>
      
      <div class="modal-body">
            <table class="table">
                <thead>
                    <th>STATUS</th>
                    <th>DATE SET</th>
                    <th>APPROVED/DISAPPROVED BY</th>
                </thead>
                <tbody id="status_hist_tbody"></tbody>
            </table>                          
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <i class="bx bx-x d-block d-sm-none"></i>
          <span class="d-none d-sm-block ">Close</span>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- end of modal3 -->

<?php if($user_details["store_id"]==6 && $user_details["user_type"]=="buyer"){ // IF CDC Buyer ?>

<ul class="nav nav-tabs" style="margin-bottom: 30px;">
    <li id="cdc_link" class="active"><a href="#" onclick="setSelectLink('cdc_link')"><b>CDC Reorder</b></a></li>
    
    <li id="store_link"><a href="#" onclick="setSelectLink('store_link')"><b>STORE Reorder</b></a></li>
</ul>

<?php } ?>

 <div class="row">
     <div class="col-sm-10">
        <input type="radio" id="option1" name="options" value="pending" style="width: 20px; height: 20px;" checked> 
        <label for="option1">Pending</label>
        &nbsp;&nbsp;
        <input type="radio" id="option2" name="options" value="approved" style="width: 20px; height: 20px;"> 
        <label for="option2">Approved</label>
     </div>
     <div class="col-sm-2">

<?php if($user_details["user_type"] == 'buyer'){ ?>

        <!-- <a class="btn btn-danger" id="view_old_btn" onclick="show_old_files_uploader()" href="#">Upload Old Sales</a>   -->
        <a class="btn btn-danger" href="<?php echo base_url('Mms_ctrl/mms_ui/11'); ?>">Upload Previous Sales</a> 

<?php } ?>

     </div>
 </div>

 <div class="row">
       <div class="col-12 table-responsive" style="padding-top: 20px;">
        <table id="reorder-table" class="table table-striped table-bordered table-responsive" style="background-color: rgb(5, 68, 104); width: 100%;">
            <thead style="text-align: center;color:white;" id="reorder-thead">
               <th>DOCUMENT NO.</th>
               <th>VENDOR CODE</th>
               <th>VENDOR NAME</th>
               <th>DATE GENERATED</th>
               <th>GROUP CODE</th>
               <th>STATUS</th>
               <th>
                ACTION&nbsp;&nbsp; 
                <input id="checkAll" type="checkbox" onchange="checkAll()" style="display: none;">
               </th>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>     
  </div>

<script>
    
    /*var reorder_table = $("#reorder-table").DataTable({ 
                            
                            columnDefs: [{  targets: -1, // The last column index (zero-based)
                                            orderable: false // Make the last column not sortable
                                        }] 
                        
                        });*/

    var reorder_table = $("#reorder-table").DataTable({ 
                            
                            columnDefs: [{  targets: '_all', 
                                            orderable: false 
                                        }], 
                            
                            lengthMenu: [10, 25, 50, 100],
                
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ordering: true,

                            ajax : {
                                    url : "<?php echo base_url(); ?>Mms_ctrl/list_reorders",
                                    type: "POST",
                                    data: function (d) {
                                        d.start        = d.start || 0; // Start index of the records
                                        d.length       = d.length || 10; // Number of records per page
                                        d.opt          = getSelectRadio();
                                        d.link         = getSelectLink();
                                    }
                                },

                            columns: [
                                        { data: 'doc_no' },
                                        { data: 'vendor_code' },
                                        { data: 'vendor_name' },
                                        { data: 'date_generated' },
                                        { data: 'group_code' },
                                        
                                        {
                                            data: 'status',
                                            render: function(data, type, row) {
                                                let stat_style = '', status = data;
                                                                        
                                                if((status.includes("APPROVED") || status.includes("FORWARDED")) && !status.includes("DISAPPROVED"))
                                                    stat_style = 'style="color:green; cursor: pointer;"';
                                                else if(status.includes("DISAPPROVED") || status.includes("CANCELLED"))
                                                    stat_style = 'style="color:red; cursor: pointer;"';
                                                else
                                                    stat_style = 'style="color:orange; cursor: pointer;"';

                                                return '<span '+stat_style+'">'+status+'</span>';
                                            }
                                        },

                                        { 
                                            data: 'batch_id',
                                            render: function(data, type, row) {
                                                return '<a class="btn btn-primary" href="<?php echo base_url('Mms_ctrl/mms_ui/4?r_no=');?>'+data+'">'+'<i class="fa fa-eye"></i></a>';
                                            }
                                        }
                                    ]
                        
                        });

    // $('#reorder-table_filter').append(' <span id="generate_btn_span"></span>');

    //loadTable();

    $(function(){
        $("input[name='options']").on('click', function(){
            // loadTable();
            // uncheckMain();
            reload_table();
        });

    });

    function reload_table(){
         reorder_table.ajax.reload();
    }

    function loadTable(){
        var selectedRadio = '';
        var selectedLink = getSelectLink(); // CDC or Store

        if($("input[name='options']").length) 
            selectedRadio = $("input[name='options']:checked").val();
        
        loader();
        $("#checkAll").hide();

        $.ajax({
            url: '<?php echo site_url('Mms_ctrl/list_reorders')?>', 
            type: 'POST',
            data: {opt:selectedRadio, link:selectedLink},
            success: function(response) {
                Swal.close();
                var jObj = JSON.parse(response);
                console.log(jObj);
                populateTable(jObj);
            }

          });
    }

    function populateTable(list){
        reorder_table.clear().draw();
        var selectedLink = getSelectLink();
        var selectedRadio = '';
        if($("input[name='options']").length) 
            selectedRadio = $("input[name='options']:checked").val();

        <?php if($user_details["store_id"]==6 && $user_details["user_type"]=="buyer"){ // IF CDC Buyer ?>

            /*if(selectedRadio=="approved" && list.length>0){
                var gen_btn = '<button id="generate_txt_btn" class="btn btn-dark btn-sm" onclick="generate_txt()">'+    
                            '<i class="fa fa-download"></i></button>';
                $("#generate_btn_span").html(gen_btn);
                $("#checkAll").show();
            }else{
                $("#generate_btn_span").html('');
            }*/

        <?php } ?>

        for(var c=0; c<list.length; c++){
            var batch_id = list[c].batch_id;
            var doc_no = '<span id="doc_span_'+batch_id+'">'+list[c].doc_no+'</span>';
            var vendor_code = list[c].vendor_code;
            var vendor_name = list[c].vendor_name;
            var date_generated = list[c].date_generated;
            var group_code = list[c].group_code;
            var status = list[c].status;

            <?php if($user_details["store_id"]==6 && $user_details["user_type"]=="buyer"){ // IF CDC Buyer ?>

                /*if(selectedRadio=="approved"){

                    list[c].nav_si_doc = (list[c].nav_si_doc===null) ? "" : list[c].nav_si_doc;
                    list[c].nav_dr_doc = (list[c].nav_dr_doc===null) ? "" : list[c].nav_dr_doc;

                    doc_no += '<div style="text-align: right;">';

                    if(list[c].vend_type=="SI,DR"){
                        var read_si = (list[c].nav_si_doc==="") ? "" : " readonly";
                        var read_dr = (list[c].nav_dr_doc==="") ? "" : " readonly";
                        doc_no += '<b>SI</b> <input type="text" size="15" id="nav_si_'+batch_id+'" value="'+list[c].nav_si_doc+'"'+read_si+'>';
                        doc_no += '<br><b>DR</b> <input type="text" size="15" id="nav_dr_'+batch_id+'" value="'+list[c].nav_dr_doc+'"'+read_dr+'>';
                    }else{
                        var read_si = (list[c].nav_si_doc==="") ? "" : " readonly";
                        doc_no += '<b>'+list[c].vend_type+'</b> <input type="text" size="15" id="nav_'+list[c].vend_type.toLowerCase()+'_'+batch_id+'" value="'+list[c].nav_si_doc+'"'+read_si+'>';
                    }

                    if(list[c].sub_vendors!==""){
                        let sv_split = list[c].sub_vendors.split(":");
                        for(let i=0; i<sv_split.length; i++){
                            let sv_details = sv_split[i].split("|");
                            let vendor_code_ = sv_details[0];
                            let vend_type = sv_details[1];
                            let nav_doc_no = sv_details[2];
                            let nav_doc_no_dr = sv_details[3];

                            if(vend_type=="SI,DR"){
                                let read_si = (nav_doc_no==="") ? "" : " readonly";
                                let read_dr = (nav_doc_no_dr==="") ? "" : " readonly";
                                doc_no += '<br><b>SI</b> <input type="text" size="15" id="nav_si_'+batch_id+'" placeholder="'+vendor_code_+'" value="'+nav_doc_no+'"'+read_si+'>';
                                doc_no += '<br><b>DR</b> <input type="text" size="15" id="nav_dr_'+batch_id+'" placeholder="'+vendor_code_+'" value="'+nav_doc_no_dr+'"'+read_dr+'>';
                            }else{
                                let read_si = (nav_doc_no==="") ? "" : " readonly";
                                doc_no += '<br><b>'+vend_type+'</b> <input type="text" size="15" id="nav_'+vend_type.toLowerCase()+'_'+batch_id+'" placeholder="'+vendor_code_+'" value="'+nav_doc_no+'"'+read_si+'>';
                            }
                        }
                    }

                    doc_no += '</div>';
                }*/

            <?php } ?>

            var stat_style = '';
            
            if((status.includes("APPROVED") || status.includes("FORWARDED")) && !status.includes("DISAPPROVED"))
                stat_style = 'style="color:green; cursor: pointer;"';
            else if(status.includes("DISAPPROVED") || status.includes("CANCELLED"))
                stat_style = 'style="color:red; cursor: pointer;"';
            else
                stat_style = 'style="color:orange; cursor: pointer;"';

            // var status_hist = '<a '+stat_style+' onclick="viewStatusHist('+batch_id+')">'+status+'</a>';
            var status_hist = '<span '+stat_style+'">'+status+'</span>';
            var view_link = '<a class="btn btn-primary" href="<?php echo base_url('Mms_ctrl/mms_ui/4?r_no=');?>'+batch_id+'">'+
                            '<i class="fa fa-eye"></i></a>';

            <?php if($user_details["user_type"]=="incorporator"){ // IF Incorporator ?>

                view_link = '<a class="btn btn-primary" href="<?php echo base_url('Sales_ctrl/page/16?id=');?>'+batch_id+'">'+
                            '<i class="fa fa-eye"></i></a>';

            <?php }else if($user_details["store_id"]==6 && $user_details["user_type"]=="buyer"){ // IF CDC Buyer ?>
                
                /*if(selectedRadio=="approved"){
                    view_link += '&nbsp;&nbsp;<input class="status_box" type="checkbox" onchange="checkSingle(this)" value="'+batch_id+'">';
                }*/
                 
            <?php }else if($user_details["store_id"]!=6 && $user_details["user_type"]=="buyer"){ // IF Store Buyer ?>


            <?php } ?>  

            var rowNode = reorder_table.row.add([doc_no,vendor_code,vendor_name,date_generated,group_code,status_hist,view_link]).draw().node();  
        }
          
    }

    function loader(){
              
        Swal.fire({
                    imageUrl: '<?php echo base_url(); ?>assets/mms/images/Cube-1s-200px.svg',
                    imageHeight: 203,
                    imageAlt: 'loading',
                    text: 'loading, please wait',
                    allowOutsideClick:false,
                    showCancelButton: false,
                    showConfirmButton: false
                });              
    }

    function setSelectLink(link){
        if(link=='cdc_link'){
            $('#cdc_link').attr("class","active");
            $('#store_link').attr("class","");
            $('#reorder_modal_btn').show();
        }else{ // store_link
            $('#cdc_link').attr("class","");
            $('#store_link').attr("class","active");
            $('#reorder_modal_btn').hide();
        }

        // loadTable();
        // uncheckMain();
        reload_table();
    }

    function getSelectLink(){
        var link = 'store';

        if($("#cdc_link").length){
            if($('#cdc_link').attr("class")=="active"){
                link = "cdc";
            }
        }
        
        return link;
    }

    function getSelectRadio(){
        let selectedRadio = '';
        
        if($("input[name='options']").length) 
            selectedRadio = $("input[name='options']:checked").val();

        return selectedRadio;
    } 
 
    function show_old_files_uploader(){
        io.open("POST", "<?php echo base_url();?>Mms_ctrl/mms_ui/3", 
                         {                               
                               "vendor_code":'UPLOAD OLD SALES',
                               "vendor_name":'',
                               "date_tag":'',
                               "group_code":''
                        },"_self");  
    }

    function checkAll(){
        var checked = $('#checkAll').prop('checked');
        var numberOfColumns = reorder_table.columns().header().length;
        reorder_table.column(numberOfColumns-1).nodes().to$().find('.status_box').prop('checked', checked);
    }

    function checkSingle(elem){
        uncheckMain();
    }

    function uncheckMain(){
        $('#checkAll').prop('checked',false);
    }

    window.io = {

        open: function(verb, url, data, target){

            var form = document.createElement("form");
            form.action = url;
            form.method = verb;
            form.target = target || "_self";
            if (data) {
                for (var key in data) {
                    var input = document.createElement("textarea");
                    input.name = key;
                    input.value = typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
                    form.appendChild(input);
                }

            }

            form.style.display = 'none';
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    };

    // function viewStatusHist(batch_id){
    //     var doc_no = $('#doc_span_'+batch_id).html();
    //     var html = '';

    //     $("#span_status_hist").html(doc_no)
    //     $("#status_modal").modal({backdrop: 'static',keyboard: false});

    //     $.ajax({
    //       url: '<?php echo site_url('Po_ctrl/getSeasonReorderStatusHistory')?>', 
    //       type: 'POST',
    //       data: {batch_id:batch_id},
    //       success: function(response) {
    //         var jObj = JSON.parse(response);
    //         console.log(jObj);
            
    //         for(var c=0; c<jObj.length; c++){
    //             html += '<tr><td>'+jObj[c].status+'</td><td>'+jObj[c].date_set+'</td><td>'+jObj[c].user+'</td></tr>';
    //         }
            
    //         $("#status_hist_tbody").html(html);
    //       }
    //     });
    // }

    function generate_txt(){
        var checkedValues = []; // Stores arrays
        var stores = [];
        var navValues = []; // Stores arrays
        var numberOfColumns = reorder_table.columns().header().length;

        // Determine how many stores
        reorder_table.column(numberOfColumns-1).nodes().to$().find('.status_box:checked').each(function() {
            var batch_id = $(this).val();
            var doc_number = reorder_table.column(0).nodes().to$().find('#doc_span_'+batch_id).text();
            var store = doc_number.split("-")[1]; // ex. MMSR-ASC-0000007
            
            var nav_si = reorder_table.column(0).nodes().to$().find('#nav_si_'+batch_id);
            var nav_dr = reorder_table.column(0).nodes().to$().find('#nav_dr_'+batch_id);

            if(!stores.includes(store+"-SI") && nav_si.length>0){
                stores.push(store+"-SI");
                checkedValues.push([]);
            }

            if(!stores.includes(store+"-DR") && nav_dr.length>0){
                stores.push(store+"-DR");
                checkedValues.push([]);
            }

        });

        console.log(stores);

        reorder_table.column(numberOfColumns-1).nodes().to$().find('.status_box:checked').each(function() {
            var batch_id = $(this).val();
            var doc_number = reorder_table.column(0).nodes().to$().find('#doc_span_'+batch_id).text();
            var store = doc_number.split("-")[1]; // ex. MMSS-ASC-0000007

            var nav_val = [];
            var nav_si = reorder_table.column(0).nodes().to$().find('#nav_si_'+batch_id);
            var nav_dr = reorder_table.column(0).nodes().to$().find('#nav_dr_'+batch_id);
            
            var nav_si_doc = '';
            if(nav_si.length>0){
                nav_si_doc = nav_si.val();
                nav_val.push(nav_si_doc);
            }

            var nav_dr_doc = '';
            if(nav_dr.length>0){
                nav_dr_doc = nav_dr.val();
                nav_val.push(nav_dr_doc);
            }

            navValues.push(nav_val);

            for(var c=0; c<stores.length; c++){
                if(stores[c]==store+"-SI"){
                    if(nav_si_doc!==""){
                        checkedValues[c].push([batch_id,"SI",nav_si_doc]);
                        break;
                    }
                }
            }

            for(var c=0; c<stores.length; c++){
                if(stores[c]==store+"-DR"){                
                    if(nav_dr_doc!==""){
                        checkedValues[c].push([batch_id,"DR",nav_dr_doc]);
                        break;
                    }
                }
            }

        });

        console.log(checkedValues);

        if(checkedValues.length<1){
            Swal.fire({title: 'Message!', text: "No Reorder Report Selected!", icon: "error"});
        }else if(!checkEmptyInArray(navValues)){
            Swal.fire({title: 'Message!', text: "An SI/DR textfield is not inputted for a document!", icon: "error"});
        }else{
/*
            for(var c=0; c<checkedValues.length; c++){
                (function (currentIndex) {
                    var doc_numbers = '';
                    for(var x=0; x<checkedValues[currentIndex].length; x++){
                        doc_numbers += reorder_table.column(0).nodes().to$().find('#doc_span_'+checkedValues[currentIndex][x]).text()+"_";
                    }
                    var filename = doc_numbers.slice(0, -1);

                    $.ajax({
                      url: '<?php echo site_url('Mms_ctrl/generate_txt')?>', 
                      type: 'POST',
                      data: {batches:checkedValues[c]},
                      success: function(response) {
                        var blob      = new Blob([response], { type: 'text/plain' }); // 'application/vnd.ms-excel','text/plain'
                        var url       = URL.createObjectURL(blob);                                  
                        var link      = document.createElement('a');                                                       
                        link.href     = url;                                                        
                        link.download = filename+'.txt'; // xls,txt                                                     
                        document.body.appendChild(link);                                            
                        link.click();                          
                        document.body.removeChild(link);
                      }
                    });
                })(c);
            }*/
        }
            
    }

    function checkEmptyInArray(new_arr){
        if(new_arr.length<1)
            return false;

        for(var c=0; c<new_arr.length; c++){
            var in_arr = new_arr[c];
            for(var x=0; x<in_arr.length; x++){
                if(in_arr[x].trim()==="")
                    return false;
            }
        }

        return true;
    }

</script>    