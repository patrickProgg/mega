<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->


<section id="content">
    <main>
        <div class="head-title">
            <div class="left">
                <h1>History</h1>
                <ul class="breadcrumb">
                    <li><a href="#" class="tab-link active" data-tab="mutual">Mutual Aid</a></li>
                    <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="rental">Rental</a></li>
                    <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="issue">Issuance</a></li>
                    <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="history">Loan</a></li>
                    <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="history">Investment</a></li>
                </ul>
            </div>
        </div>

        <div id="mutual" class="tab-content active">
            <div class="table-data">
                <div class="order">
                    <table id="table-data" class="table table-hover" style="width:100%;">
                        <thead>
                            <tr>
                                <th>FULL NAME</th>
                                <!-- <th style="width:250px;">ADDRESS</th>
                                <th style="width:130px;">PASSING DATE</th>
                                <th style="width:150px;">PHONE</th>
                                <th style="width:100px;">TOTAL AMOUNT</th>
                                <th style="width:110px;">LEDGER</th>
                                <th style="width:80px;">STATUS</th>
                                <th style="width:50px;">ACTION</th> -->
                                <th>ADDRESS</th>
                                <th>PASSING DATE</th>
                                <th>PHONE</th>
                                <th>TOTAL AMOUNT</th>
                                <th>LEDGER</th>
                                <th>STATUS</th>
                                <th style="width:50px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="rental" class="tab-content">
            <div class="table-data">
                <div class="order">
                    <table id="rental-table" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>FULL NAME</th>
                                <th>RENTED</th>
                                <th>QTY</th>
                                <th>DATE RENTED</th>
                                <th>DUE DATE</th>
                                <th>DATE RETURNED</th>
                                <th>AMOUNT</th>
                                <th>PENALTY</th>
                                <th>TOTAL AMT</th>
                                <th style="width:50px;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="issue" class="tab-content">
            <div class="table-data">
                <div class="order">
                    <table id="issue-table" class="table  table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>FULL NAME</th>
                                <th>ISSUED</th>
                                <th>QTY</th>
                                <th>DATE ISSUED</th>
                                <th>DUE DATE</th>
                                <th>DATE RETURNED</th>
                                <!-- <th>PENALTY</th>
                                <th>TOTAL AMT</th> -->
                                <th style="width:80px;">STATUS</th>
                                <th style="width:50px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- view details modal -->
        <div class="modal fade" id="openDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 900px; overflow:hidden; margin-top:10px;">
                <div class="table-data">
                    <div class="order">
                        <!-- <div class="modal-content"> -->
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header" style="display: flex; width: 100%;">
                                <div>
                                    <div id="fam_reps" style="font-family: Arial; font-size: 16px; padding-bottom: 10px;"></div>
                                    <div id="total_bal" style="font-family: Arial; font-size: 16px; "></div>

                                </div>
                                <div>
                                    <div id="status" style="font-family: Arial; font-size: 16px; padding-bottom: 10px; padding-left: 200px; text-align: left;"></div>
                                    <div id="remaining_bal" style="font-family: Arial; font-size: 16px;  padding-left: 200px; text-align: left;"></div>
                                </div>
                            </div>
                            <div class="modal-body" id="modal-content">
                                <form id="openDetailsForm">
                                    <div class="table-responsive">
                                        <table id="details-table" class="table table-hover" style="width:100%; font-size:15px;">
                                            <p style="font-weight: bold;">Received By:</p>
                                            <thead>
                                                <tr>
                                                    <th>FULL NAME</th>
                                                    <th>AMOUNT</th>
                                                    <th>DATE RECEIVED</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="releaseInputs">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="fullname">Full Name</label>
                                                    <input type="text" class="form-control" id="fullname" placeholder="Enter Fullname" required>
                                                    <input type="hidden" id="deceased_id" name="id">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="relDate">Release Date</label>
                                                    <input type="date" class="form-control" id="relDate" placeholder="Select Release Date">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="type">Type</label>
                                                    <select class="form-control" id="type">
                                                        <option value="partial">Partial</option>
                                                        <option value="full">Full</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="amountRelease">Amount</label>
                                                    <input type="number" class="form-control" id="amountRelease" placeholder="Amount" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary" id="release">Release</button>
                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- view details modal -->
    </main>
</section>

<script>
    var table_data = $("#table-data").DataTable({
        "language": {
            "infoFiltered": " ", // Replace with a single space to hide the text
            // "search": "Search:", // Optional: Customize search label
            // "info": "Showing _START_ to _END_ of _TOTAL_ entries" // Custom info text without "filtered"
        },
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
            url: '<?php echo site_url('Payment_ctrl/getHistory'); ?>',
            type: 'POST',
            data: function(d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw
                };
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [{
                data: 'full_name'
            },
            {
                data: 'address'
            },
            {
                data: 'dd_date_died'
            },
            {
                data: 'phone1',
            },

            {
                data: 'dd_total_amt',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            {
                data: 'dd_amt_rcv',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            // {
            //     data: 'dd_bal',
            //     render: function(data, type, row) {
            //         return `₱ ${parseFloat(data).toFixed(2)}`;
            //     }
            // },
            {
                data: 'dd_status',
                render: function(data, type, row) {
                    if (data == 0) {
                        return '<span class="badge bg-danger">Pending</span>';
                    } else if (data == 1) {
                        return '<span class="badge bg-primary">Partial</span>';
                    } else {
                        return '<span class="badge bg-success">Settled</span>';
                    }
                }
            },
            {
                data: 'dd_id',
                render: function(data, type, row) {
                    return `
            <div style="display: flex; justify-content: center; align-items: center;">
                <!-- View Icon -->
                <i class="fas fa-eye view-icon text-primary" style="cursor: pointer; font-size: 14px;" 
                    onclick="openDetailsModal('${row.dd_id}')"></i>
            </div>  
        `;
                }
            }

        ]
    });

    var table_data = $("#rental-table").DataTable({
        "language": {
            "infoFiltered": " ",
        },
        // stateSave: true, // Enables state saving    
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
            url: '<?php echo site_url('Rental_ctrl/getHistory'); ?>',
            type: 'POST',
            data: function(d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw
                };
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [{
                data: 'r_name',
            },
            {
                data: 'ra_desc'
            },
            {
                data: 'r_rent_qty'
            },
            {
                data: 'r_rent_date',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'r_due_date',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'r_date_returned',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'r_amount',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
                
            },
            {
                data: 'r_rent_penalty',
                render: function(data, type, row) {
                    if (parseFloat(data) === 0) {
                        return ''; // or return 'None'; if you want to display "None"
                    }
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            // {
            //     data: 'r_rent_penalty',
            //     render: function(data, type, row) {
            //         return `₱ ${parseFloat(data).toFixed(2)}`;
            //     }
            // },
            {
                data: 'r_total_amount',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            {
                data: 'r_status',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge bg-success">Paid</span>';
                    } else {
                        return '<span class="badge bg-danger">Pending</span>';
                    }
                }
            },
        ]
    });


    $(document).ready(function() {
        var setup = $('#setup').DataTable();

        $('#setup tbody').on('click', 'tr', function() {
            var data = setup.row(this).data();
            if (data) {
                var id = data.dd_id;
                openDetailsModal(id);
            }
        });
    });

    // let hdData = {}; // Global variab

    function openDetailsModal(id) {

        $('#openDetailsModal').modal('show');

        $('#openDetailsModal').one('shown.bs.modal', function() {
            // Check if DataTable exists and destroy it before re-initializing
            if ($.fn.DataTable.isDataTable('#details-table')) {
                $('#details-table').DataTable().clear().destroy();
            }
            $('#details-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 10,
                lengthChange: true,
                ordering: false,
                paging: false,
                searching: false,
                info: false,
                lengthChange: false,
                ajax: {
                    url: '<?php echo base_url('Payment_ctrl/payment_details'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: function(d) {
                        d.id = id;
                        return d;
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed:", xhr.responseText);
                        Swal.fire('Error', 'Failed to load data: ' + error, 'error');
                    },
                    dataSrc: function(json) {
                        // console.log("HD Data:", json.data);
                        // console.log("Data:", json.hd_id);

                        let amtRel = 0;

                        if (Array.isArray(json.data) && json.data.length > 0) {
                            amtRel = json.data.reduce((sum, item) => sum + (parseFloat(item.rf_amt_rel) || 0), 0);
                        }

                        // console.log("Total Amount Released:", amtRel);

                        let total = parseFloat(json.hd_id.dd_total_amt) || 0;
                        let id = json.hd_id.dd_id;

                        let bal = total - amtRel;

                        console.log("amtRel:", amtRel);
                        console.log("total:", total);

                        let status = json.hd_id.dd_status;

                        let statusText = "";
                        let statusColorClass = "";

                        switch (status) {
                            case "0":
                                statusText = "Pending";
                                statusColorClass = "text-danger"; // Red for pending
                                break;
                            case "1":
                                statusText = "Partial";
                                statusColorClass = "text-primary"; // Blue for partial
                                break;
                            case "2":
                                statusText = "Settled";
                                statusColorClass = "text-success"; // Green for settled
                                break;
                            default:
                                statusText = "Unknown";
                                statusColorClass = "text-secondary"; // Gray for unknown
                        }

                        if (status === "2") {
                            document.querySelector('.releaseInputs').style.display = 'none';
                            document.getElementById('release').style.display = 'none';

                        }

                        $('#fam_reps').html("Passed Member: <strong>" + json.hd_id.hd_full_name + "</strong>");
                        $('#deceased_id').val(id);
                        $('#status').html(`Status: <strong class="${statusColorClass}">${statusText}</strong>`);
                        $('#total_bal').html("Amount Released: <strong>₱" + total.toFixed(2) + "</strong>");
                        $('#remaining_bal').html("Remaining Balance: <strong>₱" + (total - amtRel).toFixed(2) + "</strong>");

                        return json.data;
                    }
                },
                columns: [{
                        data: 'rf_fullname'
                    },
                    {
                        data: 'rf_amt_rel',
                        render: function(data, type, row) {
                            return `₱ ${parseFloat(data).toFixed(2)}`;
                        }
                    },
                    {
                        data: 'rf_date_rel',
                        render: function(data, type, row) {
                            return formatDate(data);
                        }
                    },
                ],
            });

        });
    }

    var table_data = $("#issue-table").DataTable({
        "language": {
            "infoFiltered": " ",
        },  
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
            url: '<?php echo site_url('Rental_ctrl/getIssuanceHistory'); ?>',
            type: 'POST',
            data: function(d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw
                };
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [{
                data: 'full_name',
            },
            {
                data: 'ra_desc'
            },
            {
                data: 'sr_rent_qty'
            },
            {
                data: 'sr_rent_date',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'sr_due_date',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'sr_date_returned',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            // {
            //     data: 'sr_rent_penalty',
            //     render: function(data, type, row) {
            //         return `₱ ${parseFloat(data).toFixed(2)}`;
            //     }
            // },
            // {
            //     data: 'sr_total_amount',
            //     render: function(data, type, row) {
            //         return `₱ ${parseFloat(data).toFixed(2)}`;
            //     }
            // },
            {
                data: 'sr_status_1',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge bg-success">Returned</span>';
                    } else {
                        return '<span class="badge bg-primary">Issued</span>';
                    }
                }
            },
            // {
            //     data: 'status', // Using concatenated status field
            //     render: function(data, type, row) {
            //         let statuses = data.split(" "); // Split concatenated values
            //         let stat1 = statuses[0]; // First status
            //         let stat2 = statuses[1]; // Second status
            //         let badgeHtml = '';

            //         if (stat1) {
            //             if (stat1 == 1) {
            //                 badgeHtml += '<span class="badge bg-success me-1">Returned</span> ';
            //             } else {
            //                 badgeHtml += '<span class="badge bg-primary me-1">Issued</span> ';
            //             }
            //         }

            //         if (stat2) {
            //             if (stat2 == 1) {
            //                 badgeHtml += '<span class="badge bg-success me-1">Paid</span> ';
            //             } else {
            //                 badgeHtml += '<span class="badge bg-danger me-1">Pending</span> ';
            //             }
            //         }

            //         return badgeHtml.trim(); // Return formatted badges
            //     }
            // },
            {
                data: 'sr_id',
                render: function(data, type, row) {
                    return `<div style="display: flex; justify-content: center; align-items: center; margin-right:4px;">
                                ${row.r_status != 1 ? `
                                    <i class="fas fa-eye text-primary" style="cursor: pointer; font-size: 14px;" 
                                        onclick="openIssuance('${row.sr_id}', '${row.hd_id}')"></i>
                                ` : ''}
                            </div>`;
                }
            }
        ]
    });
</script>