<?php
$user_details = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);
$store_id = $user_details['store_id'];
// echo $store_id;

?>

<?php if ($user_details["store_id"] == 6 && $user_details["user_type"] == "buyer") { // IF CDC Buyer 
?>
    <ul class="nav nav-tabs" style="margin-bottom: 30px;">
        <li id="cdc_link" class="active"><a href="#" onclick="setSelectLink('cdc_link')"><b>CDC Reorder</b></a></li>

        <li id="store_link"><a href="#" onclick="setSelectLink('store_link')"><b>STORE Reorder</b></a></li>
    </ul>

<?php } ?>

<div class="row">
    <div class="col-sm-10">
        <input type="radio" id="option3" name="cas_type" value="SI" style="width: 20px; height: 20px;" checked>
        <label for="option1">CAS</label>
        &nbsp;&nbsp;
        <input type="radio" id="option4" name="cas_type" value="DR" style="width: 20px; height: 20px;">
        <label for="option2">NON-CAS</label>
        &nbsp;&nbsp;
        <input type="radio" id="option5" name="cas_type" value="SI,DR" style="width: 20px; height: 20px;">
        <label for="option2">HYBRID</label>
        &nbsp;&nbsp;
        <input type="radio" id="option6" name="cas_type" value="" style="width: 20px; height: 20px;">
        <label for="option2">NO VENDOR TYPE</label>
    </div>
</div>

<div class="row">
    <div class="col-sm-10">
        <input type="radio" id="option1" name="options" value="pending" style="width: 20px; height: 20px;" checked>
        <label for="option1">Pending</label>
        &nbsp;&nbsp;
        <input type="radio" id="option2" name="options" value="approved" style="width: 20px; height: 20px;">
        <label for="option2">Approved</label>
    </div>

    <div class="text-right">

        <button id="refresh_btn" class="btn btn-success" onclick="refresh()" title="Sync" style="display: none;">
            <i class="fa fa-refresh"></i>
        </button>

        <a class="btn btn-danger" href="#" onclick="confirmExtract()">Extract</a>
    </div>


</div>

<div class="row">
    <div class="col-12 table-responsive" style="padding-top: 20px;">
        <table id="reorder-table" class="table table-striped table-bordered table-responsive" style="background-color: rgb(5, 68, 104); width: 100%;">
            <thead style="text-align: center; color: white;" id="reorder-thead">
                <tr>
                    <th style="width:150px">DOCUMENT NO.</th>
                    <th style="width:100px">VENDOR CODE</th>
                    <th>VENDOR NAME</th>
                    <th style="width:200px">DATE GENERATED</th>
                    <!-- <th>GROUP CODE</th> -->
                    <th style="width:200px">STATUS</th>
                    <th style="width:80px">
                        ACTION&nbsp;&nbsp;
                        <input id="checkAll" type="checkbox" onchange="checkAll()" style="display: none;">
                    </th>
                </tr>
            </thead>
            <tbody id="po-data-body">

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade custom-width-modal" id="vendModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 1040px;">
        <div class="modal-content">
            <div class="modal-header">
                <table>
                    <tr>
                        <td style="font-family: Arial; font-size: 16px;" id="setup_code"></td>
                    </tr>
                </table>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-content">
                <div class="row">
                    <div class="col-6 table-responsive">
                        <table id="setup" class="table table-striped table-bordered"
                            style="background-color: rgb(5, 68, 104); width: 1120px;">
                            <thead style="text-align: center; color: white;" id="reorder-thead">
                                <tr>
                                    <th style="width:100px;">VENDOR CODE</th>
                                    <th style="width:100px;">VENDOR NAME</th>
                                    <th style="width:100px;">VENDOR TYPE</th>
                                </tr>
                            </thead>
                            <tbody id="po-data-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button id="save_edit" class="btn btn-success"><i class="fa fa-film"></i> Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-right:3px;">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block ">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    // function setSelectLink(link) {
    //     if (link == 'cdc_link') {
    //         $('#cdc_link').attr("class", "active");
    //         $('#store_link').attr("class", "");
    //         $('#reorder_modal_btn').show();
    //     } else { // store_link
    //         $('#cdc_link').attr("class", "");
    //         $('#store_link').attr("class", "active");
    //         $('#reorder_modal_btn').hide();
    //     }

    //     reload_table();
    // }

    // ******************************************************** 04/01/25
    // Function to set and save the selected link state
    // function setSelectLink(link) {
    //     localStorage.setItem("selectedLink", link); // Save selection

    //     if (link === 'cdc_link') {
    //         $('#cdc_link').attr("class", "active");
    //         $('#store_link').attr("class", "");
    //         $('#reorder_modal_btn').show();
    //     } else { // store_link
    //         $('#cdc_link').attr("class", "");
    //         $('#store_link').attr("class", "active");
    //         $('#reorder_modal_btn').hide();
    //     }

    //     reload_table();
    // }

    // // Function to apply saved state on page load
    // $(document).ready(function() {
    //     let savedLink = localStorage.getItem("selectedLink") || 'cdc_link'; // Default to 'cdc_link'
    //     setSelectLink(savedLink);
    // });
    // ******************************************************** 04/01/25

    // ******************************************************** 04/01/25
    function setSelectLink(link) {
        localStorage.setItem("selectedLink", link); // Save selection

        if (link === 'cdc_link') {
            $('#cdc_link').addClass("active").removeClass("");
            $('#store_link').removeClass("active");
            $('#reorder_modal_btn').show();
        } else { // store_link
            $('#cdc_link').removeClass("active");
            $('#store_link').addClass("active");
            $('#reorder_modal_btn').hide();
        }

        reload_table();
    }

    function saveRadioSelection(value) {
        localStorage.setItem("selectedRadio", value);
    }

    function restoreRadioSelection() {
        let savedRadio = localStorage.getItem("selectedRadio") || 'pending'; // Default to 'pending'
        $(`input[name="options"][value="${savedRadio}"]`).prop("checked", true);
    }

    $(document).ready(function() {
        let savedLink = localStorage.getItem("selectedLink") || 'cdc_link'; // Default to 'cdc_link'
        setSelectLink(savedLink);

        restoreRadioSelection();

        $('input[name="options"]').on('change', function() {
            saveRadioSelection($(this).val());
        });
    });
    // ********************************************************04/01/25


    function getSelectLink() {
        var link = 'store';

        if ($("#cdc_link").length) {
            if ($('#cdc_link').attr("class") == "active") {
                link = "cdc";
            }
        }
        return link;
        // console.log(link);
    }

    function reload_table() {
        reorder_table.ajax.reload();
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Retrieve the saved value from sessionStorage
        let selectedOption = sessionStorage.getItem("selectedCasType");

        if (selectedOption) {
            let radioButton = document.querySelector(`input[name="cas_type"][value="${selectedOption}"]`);
            if (radioButton) {
                radioButton.checked = true;

                // Trigger the change event manually to display the corresponding data
                radioButton.dispatchEvent(new Event("change"));
            }
        }

        // Add event listener to save the selected option on change
        let radioButtons = document.querySelectorAll('input[name="cas_type"]');
        radioButtons.forEach(radio => {
            radio.addEventListener("change", function() {
                sessionStorage.setItem("selectedCasType", this.value);
                updateDataDisplay(this.value); // Ensure data updates based on selection
            });
        });

        // Function to update the displayed data (Modify this according to your logic)
        function updateDataDisplay(selectedValue) {
            console.log("Displaying data for:", selectedValue); // Debugging
            // Add logic here to show the corresponding data based on selectedValue
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Select all radio buttons inside the 'cas_type' group
        var casTypeRadios = document.getElementsByName("cas_type");

        // Add event listeners to all radio buttons
        casTypeRadios.forEach(function(radio) {
            radio.addEventListener("change", toggleRefreshButton);
        });

        function toggleRefreshButton() {
            var noVendorType = document.getElementById("option6");
            var refreshBtn = document.getElementById("refresh_btn");

            if (noVendorType.checked) {
                refreshBtn.style.display = "inline-block"; // Show button
            } else {
                refreshBtn.style.display = "none"; // Hide button
            }
        }
    });

    const swalLoading = Swal.fire({
        title: 'Loading...',
        text: 'Please wait while the data is being loaded.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    window.addEventListener('load', () => {
        swalLoading.close();
    });

    var stat_style = '';

    if (status === "APPROVED BY-STORE BUYER" || status === "APPROVED BY-CATEGORY HEAD" || status === "APPROVED BY-CORPORATE BUYER" || status === "APPROVED BY-CORP CATEGORY HEAD")
        stat_style = 'style="color:green; cursor: pointer;"';
    else if (status === "DISAPPROVED BY-CATEGORY HEAD" || status === "CANCELLED")
        stat_style = 'style="color:red; cursor: pointer;"';
    else
        stat_style = 'style="color:orange; cursor: pointer;"';

    var reorder_table = $("#reorder-table").DataTable({
        stateSave: true, // Enables state saving    
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        lengthMenu: [10, 25, 50, 100],
        processing: true,
        serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            url: '<?php echo site_url('Manual_po_ctrl/index'); ?>',
            type: 'POST',
            data: function(d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw,
                    status: $('input[name="options"]:checked').val(),
                    cas_type: $('input[name="cas_type"]:checked').val(),
                    link: getSelectLink(),
                };
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [{
                data: 'mp_hd_id',
                render: function(data, type, row) {
                    const doc_number = String(row.mp_hd_id).padStart(7, '0');
                    return 'MMSMP-' + row.value_.toUpperCase() + '-' + doc_number;
                }
            },
            {
                data: 'vendor_code'
            },
            {
                data: 'vendor_name'
            },
            {
                data: 'date_generated',
                render: function(data, type, row) {
                    var date = new Date(data);
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                    }).replace(' at ', ' -- ');
                }
            },
            // {
            //     data: 'group_code',
            //     defaultContent: ''
            // },
            {
                data: 'status',
                render: function(data, type, row) {
                    let stat_style = '',
                        status = data.toUpperCase();

                    if (status === "APPROVED BY-STORE BUYER" || status === "APPROVED BY-CATEGORY HEAD" || status === "APPROVED BY-CORPORATE BUYER" || status === "APPROVED BY-CORP CATEGORY HEAD") {
                        stat_style = 'style="color:green; cursor: pointer;"';
                    } else if (status === "DISAPPROVED BY-CATEGORY HEAD" || status === "CANCELLED") {
                        stat_style = 'style="color:red; cursor: pointer;"';
                    } else {
                        stat_style = 'style="color:orange; cursor: pointer;"';
                    }

                    return '<span ' + stat_style + '>' + status + '</span>';
                }
            },
            {
                data: 'mp_hd_id',
                render: function(data, type, row) {
                    return '<a class="btn btn-primary" href="<?php echo base_url('Mms_ctrl/mms_ui/21?r_no='); ?>' + row.mp_hd_id + '">' + '<i class="fa fa-eye"></i></a>';
                }
            }
        ]
    });

    $('input[name="options"]').change(function() {
        reorder_table.ajax.reload();
    });

    $('input[name="cas_type"]').change(function() {
        reorder_table.ajax.reload();
    });


    function confirmExtract() {
        Swal.fire({
            title: 'Confirmation',
            text: "Do you want to extract all data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                const swalLoading = Swal.fire({
                    // title: 'Processing...',
                    // html: '<div style="display: flex; flex-direction: column; align-items: center;">' +
                    //         '<img src="<?php echo base_url(); ?>assets/img/no_records1.gif" width="100%">' +
                    //         '<br>' +
                    //         '<p>No records found.</p>' +
                    //         '</div>',
                    html: `
                    <img src="<?php echo base_url(); ?>assets/img/extract.gif" width="80%">
                    <progress id="progressBar" value="0" max="100" style="width: 100%;"></progress>
                    <br>
                    <span id="progressText">0%</span>
                    <p>Please wait while data is being extracted.</p>
                `,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    // didOpen: () => {
                    //     Swal.showLoading();
                    // }
                });

                $.ajax({
                    url: "<?php echo base_url('Manual_po_ctrl/extract'); ?>",
                    type: "POST",
                    success: function(response) {
                        console.log("Data Extraction Started...");
                    }
                });

                // Poll progress every 1 second
                let progressInterval = setInterval(() => {
                    $.ajax({
                        url: "<?php echo base_url('Manual_po_ctrl/check_progress'); ?>",
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            let progress = response.progress;
                            $("#progressBar").val(progress);
                            $("#progressText").text(Math.round(progress) + "%"); // Round off the progress

                            if (progress >= 100) {
                                clearInterval(progressInterval);
                                swalLoading.close();

                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Data migration completed successfully!',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            clearInterval(progressInterval);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to fetch progress!',
                                icon: 'error'
                            });
                        }
                    });
                }, 1000);
            }
        });
    }


    // function confirmExtract() {
    //     Swal.fire({
    //         title: 'Confirmation',
    //         text: "Do you want to extract all data?",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         // confirmButtonColor: '#3085d6',
    //         // cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes',
    //         cancelButtonText: 'No'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             const swalLoading = Swal.fire({
    //                 title: 'Processing...',
    //                 text: 'Please wait while data is being extracted.',
    //                 allowOutsideClick: false,
    //                 didOpen: () => {
    //                     Swal.showLoading();
    //                 }
    //             });

    //             setTimeout(() => {
    //                 $.ajax({
    //                     url: "<?php echo base_url('Manual_po_ctrl/extract'); ?>",
    //                     type: "POST",
    //                     success: function(response) {
    //                         swalLoading.close();

    //                         Swal.fire({
    //                             title: 'Success!',
    //                             text: 'Data migration completed successfully!',
    //                             icon: 'success',
    //                             showConfirmButton: false,
    //                             timer: 500
    //                         }).then(() => {
    //                             location.reload();
    //                         });
    //                     },
    //                     error: function(xhr, status, error) {
    //                         swalLoading.close();

    //                         Swal.fire({
    //                             title: 'Error!',
    //                             text: 'An error occurred: ' + error,
    //                             icon: 'error'
    //                         });
    //                     }
    //                 });
    //             }, 500);
    //         }
    //     });
    // }

    // function confirmExtract() {
    //     Swal.fire({
    //         title: 'Confirmation',
    //         text: "Do you want to extract all data?",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Yes',
    //         cancelButtonText: 'No'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             Swal.fire({
    //                 title: 'Processing...',
    //                 html: '<div id="progress-text">Initializing...</div><br><progress id="progress-bar" value="0" max="100" style="width:100%;"></progress>',
    //                 allowOutsideClick: false,
    //                 didOpen: () => {
    //                     Swal.showLoading();
    //                     startExtraction();
    //                 }
    //             });
    //         }
    //     });
    // }

    // function startExtraction() {
    //     $.ajax({
    //         url: "<?php echo base_url('Manual_po_ctrl/extract'); ?>",
    //         type: "POST",
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.status === 'success') {
    //                 updateProgress(true);
    //             } else {
    //                 Swal.fire('Error', 'Unexpected response from server.', 'error');
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire('Error!', 'An error occurred: ' + error, 'error');
    //         }
    //     });

    //     updateProgress();
    // }

    // function updateProgress(forceComplete = false) {
    //     let interval = setInterval(() => {
    //         $.ajax({
    //             url: "<?php echo base_url('Manual_po_ctrl/get_progress'); ?>",
    //             type: "GET",
    //             dataType: "json",
    //             success: function(response) {
    //                 $("#progress-bar").val(response.progress);
    //                 $("#progress-text").text(response.message);

    //                 if (response.progress >= 100 || forceComplete) {
    //                     clearInterval(interval);
    //                     Swal.close();
    //                     Swal.fire({
    //                         title: 'Success!',
    //                         text: 'Data migration completed successfully!',
    //                         icon: 'success',
    //                         showConfirmButton: false,
    //                         timer: 1500
    //                     }).then(() => {
    //                         location.reload();
    //                     });
    //                 }
    //             }
    //         });
    //     }, 1000);
    // }




    function showNoSetup() {
        $('#vendModel').modal('show'); // If using jQuery and Bootstrap
    }

    function showNoSetup() {
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while the data is being loaded.',
            allowOutsideClick: false,
            didOpen: (swal) => {
                Swal.showLoading();
            }
        });

        $('#vendModel').modal('show');

        $('#vendModel').one('shown.bs.modal', function() {
            Swal.close(); // Close loading modal

            if ($.fn.dataTable.isDataTable('#setup')) {
                $('#setup').DataTable().clear().destroy();
            }

            // Initialize DataTable
            var reorder_table = $("#setup").DataTable({
                columnDefs: [{
                    targets: '_all',
                    orderable: false
                }],
                lengthMenu: [10, 25, 50, 100],
                processing: true,
                serverSide: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: '<?php echo site_url('Manual_po_ctrl/index3'); ?>',
                    type: 'POST',
                    data: function(d) {
                        return {
                            start: d.start,
                            length: d.length,
                            order: d.order,
                            search: d.search.value,
                            draw: d.draw,
                        };
                    },
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed: " + error);
                    }
                },
                columns: [{
                        data: 'vendor_code'
                    },
                    {
                        data: 'vendor_name'
                    },
                    {
                        data: 'vend_type',
                    },
                ]
            });
        });
    }

    $(document).ready(function() {
        // Initialize DataTable only once
        if (!$.fn.DataTable.isDataTable("#reorder-table")) {
            var table = $('#reorder-table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true
            });
        } else {
            var table = $('#reorder-table').DataTable();
        }

        $('#refresh_btn').click(function() {
            let allVendorCodes = [];
            // Collect data from DataTable
            table.rows().every(function() {
                let rowData = this.data();
                if (rowData) {
                    if (rowData.vendor_code) allVendorCodes.push(rowData.vendor_code);
                }
            });

            if (allVendorCodes.length === 0) { // Fix condition here
                Swal.fire({
                    title: 'Error',
                    text: 'No vendor code found',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                });
                return;
            }

            Swal.fire({
                title: 'Confirm Sync',
                text: 'Are you sure you want to start syncing data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Sync',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Syncing...',
                        text: 'Please wait while data is syncing.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // AJAX request
                    $.ajax({
                        url: '<?php echo site_url("Manual_po_ctrl/fetchVendorData"); ?>',
                        type: 'POST',
                        data: {
                            vendor_code: allVendorCodes,
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.close();
                            let updatedRows = 0;

                            let filteredResponse = response.filter(item =>
                                item.vendor_code !== null
                                // &&
                                // item.vendor_name !== null &&
                                // item.vend_type !== null

                            );

                            if (filteredResponse.length > 0) {
                                let matchedDataHtml = `
                                <table id="matchedDataTable" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Vendor Code</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                                filteredResponse.forEach(item => {
                                    matchedDataHtml += `<tr>
                                    <td>${item.vendor_code}</td>
                                    <td>${item.vendor_name}</td>    
                                    <td>${item.vend_type}</td>
                                </tr>`;
                                    updatedRows++;
                                });

                                matchedDataHtml += `</tbody></table>`;

                                // Show matched data in SweetAlert
                                Swal.fire({
                                    title: 'Matched Data Found',
                                    html: `<p>${updatedRows} record(s) found.</p>${matchedDataHtml}`,
                                    // icon: 'info',
                                    confirmButtonText: 'Ok',
                                    width: '50%',
                                    didOpen: () => {
                                        // **Destroy old DataTable before reinitializing**
                                        if ($.fn.DataTable.isDataTable("#matchedDataTable")) {
                                            $("#matchedDataTable").DataTable().destroy();
                                        }
                                        // Reinitialize DataTable
                                        $("#matchedDataTable").DataTable({
                                            responsive: true,
                                            paging: true,
                                            searching: true,
                                            ordering: true
                                        });
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let syncUpdatedRows = 0;
                                        response.forEach(item => {
                                            if (item.vendor_code) {
                                                table.rows().every(function() {
                                                    let rowData = this.data();
                                                    if (rowData.vendor_code == item.vendor_code) {
                                                        rowData.vendor_name = item.vendor_name;
                                                        rowData.vend_type = item.vend_type;
                                                        this.data(rowData);
                                                        syncUpdatedRows++;
                                                    }
                                                });
                                            }
                                        });

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Sync Successful',
                                            text: `${updatedRows} records updated successfully.`,
                                            showConfirmButton: false,
                                            timer: 1000
                                        });

                                        table.draw(false);
                                    }
                                });

                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'No Matching Items',
                                    text: 'No data found.',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: 'An error occurred while updating the table. Please try again.',
                            });

                            table.draw(false);
                        }
                    });
                }
            });
        });
    });
</script>