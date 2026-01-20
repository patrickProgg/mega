<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<section id="content">
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Mutual Aid</h1>
            </div>

            <a href="#" class="btn-download">
                <i class='bx bxs-cloud-download'></i>
                <span class="text">Download PDF</span>
            </a>
        </div>

        <div class="table-data">
            <div class="order">
                <table id="table-data" class="table table-hover" style="width:100%;">
                    <thead>
                        <tr>
                            <!-- <th style= "width:50px;">User ID</th> -->
                            <th>FULL NAME</th>
                            <th style="width:350px;">ADDRESS</th>
                            <th style="width:130px;">PASSING DATE</th>
                            <th style="width:150px;">PHONE</th>
                            <th style="width:100px;">AMOUNT</th>
                            <th style="width:110px;">LEDGER</th>
                            <!-- <th style="width:90px;">BALANCE</th> -->
                            <th style="width:80px;">STATUS</th>
                            <th style="width:80px;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- view member -->
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 900px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header" style="margin-top: 0;">
                                <div style="font-family: Arial; font-size: 16px;" id="fam_rep"></div>
                                <div style="font-family: Arial; font-size: 16px;" id="fund_dead_line"></div>
                            </div>
                            <div class="modal-body" id="modal-content">
                                <div class="table-responsive">
                                    <table id="setup" class="table table-hover" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <!-- <th>ID</th> -->
                                                <th>FULL NAME</th>
                                                <th>AMOUNT</th>
                                                <!-- <th style="width:100px;">Phone</th> -->
                                                <!-- <th>Email</th> -->
                                                <th>STATUS</th>
                                                <!-- <th>Action</th> -->
                                                <!-- <th style="width:100px;">Status</th> -->
                                                <th style="width: 100px; text-align: center;">ACTION</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- view member -->

        <!-- pay modal -->
        <div class="modal fade" id="payMoneyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <!-- <div class="modal-dialog"> -->
            <div class="modal-dialog" style="margin-top: 100px;">
                <!-- <div class="modal-content"> -->
                <div class="table-data">
                    <div class="modal-content" style="box-shadow: 0px 0px 200px rgba(0, 0, 0, 0.8);">
                        <div class="modal-header">
                            <h5 class="modal-title" id="payMoneyModalLabel">Pay</h5>
                        </div>
                        <div class="modal-body">
                            <form id="payMoneyForm">
                                <input type="hidden" id="df_id" name="df_id">
                                <input type="hidden" id="dd_id" name="dd_id">
                                <div class="form-group">
                                    <label for="amount">Enter Amount:</label>
                                    <input type="number" class="form-control" id="amount" name="amount" value="100" required>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary">Pay</button>
                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>

                                <!-- <button type="submit" class="btn btn-primary" style="margin-top:10px;">Pay</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="margin-top:10px;">Close</button> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pay modal -->

        <!-- view details modal -->
        <div class="modal fade" id="openDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 900px; overflow:hidden;">
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
                                        <table id="details-table" class="table table-hover" style="width:100%;">
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
                                                    <input type="text" class="form-control" id="fullname" placeholder="Enter Fullname" required oninput="capitalizeName(this)">
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
                                        <button type="submit" class="btn btn-primary">Release</button>
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
            "infoFiltered": " ",
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
            url: '<?php echo site_url('Payment_ctrl/getData'); ?>',
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
                data: 'dd_date_died',
                render: function(data, type, row) {
                    return formatDate(data);
                }
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
                    if (parseFloat(data) === 0) {
                        return ''; // or return 'None'; if you want to display "None"
                    }

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
            <div style="display: flex; gap: 10px;">
                <!-- View Icon -->
                <i class="fas fa-eye view-icon text-primary" style="cursor: pointer; font-size: 14px;" 
                    onclick="openDetailsModal('${row.dd_id}')"></i>

                <!-- Edit Icon -->
                <i class="fas fa-file-alt text-warning" style="cursor: pointer; font-size: 14px;" 
                    onclick="openViewModal('${row.dd_id}')"></i>

                     <!-- View Icon -->
                <i class="fas fa-paper-plane text-info" style="cursor: pointer; font-size: 14px;" 
                    onclick="openViewModal('${row.dd_id}')"></i>
            </div>  
        `;
                }
            }
        ]
    });

    $(document).ready(function() {
        var setup = $('#setup').DataTable();

        $('#setup tbody').on('click', 'tr', function() {
            var data = setup.row(this).data();
            if (data) {
                var id = data.dd_id;
                openViewModal(id);
            }
        });
    });

    let hdData = {}; // Global variab

    function openViewModal(id) {
        // let hd_id = id
        console.log("Opening modal for ID:", id);
        console.log("ID:", id);

        // Show modal
        $('#viewModal').modal('show');

        // Ensure DataTable is properly re-initialized
        $('#viewModal').one('shown.bs.modal', function() {
            if ($.fn.dataTable.isDataTable('#setup')) {
                $('#setup').DataTable().clear().destroy();
            }
            $('#setup').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 10,
                lengthChange: true,
                ordering: false,
                ajax: {
                    url: '<?php echo base_url('Payment_ctrl/details'); ?>',
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
                        // console.log("Data:", json.hd_id); 
                        // console.log("Data:", json.data);

                        let date = json.hd_id.dd_dead_line;
                        let deadline = new Date(date);
                        let formattedDeadline = deadline.toLocaleDateString("en-US", {
                            month: "long",
                            day: "numeric",
                            year: "numeric"
                        });

                        // if (Array.isArray(json.hd_id) && json.hd_id.length > 0) {
                        $('#fam_rep').html("Passed Member - <strong>" + json.hd_id.hd_full_name + "</strong>");
                        $('#fund_dead_line').html("Fund Deadline - <strong>" + formattedDeadline + "</strong>");

                        // } else {
                        //     $('#fam_rep').text("Family Representative - No Data Available");
                        // }

                        return json.data; // DataTables expects an array
                    }

                },
                columns: [
                    // {
                    //     data: 'id'
                    // },
                    {
                        data: 'hd_full_name'
                    },
                    {
                        data: 'amt'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Paid</span>';
                            } else {
                                return '<span class="badge bg-danger">Not Paid</span>';
                            }
                        }
                    },
                    {
                        data: 'df_id',
                        render: function(data, type, row) {
                            return `   
                                <div style="display: flex; justify-content: center; align-items: center; margin-right:4px;">
                                ${row.status != 1 ? `
                                    <i class="fas fa-credit-card text-primary" style="cursor: pointer; font-size: 14px;" 
                                        onclick="payMoney('${row.df_id}', '${row.dd_id}')"></i>
                                        ` : ''}
                                </div>
                            `;
                        }
                    }
                ],
            });

        });
    }

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

        // Ensure DataTable is properly re-initialized
        $('#openDetailsModal').one('shown.bs.modal', function() {
            if ($.fn.dataTable.isDataTable('#setup')) {
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
                        console.log("HD Data:", json.data);
                        console.log("Data:", json.hd_id);

                        // if (json.hd_id) {

                        let amtRel = 0;

                        if (Array.isArray(json.data) && json.data.length > 0) {
                            amtRel = json.data.reduce((sum, item) => sum + (parseFloat(item.rf_amt_rel) || 0), 0);
                        }

                        console.log("Total Amount Released:", amtRel);

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
                        } else if (status === "1") {
                            document.querySelector('.releaseInputs').style.display = 'block';
                            $('#type').val('full');
                            $('#amountRelease').val(bal);
                        } else if (status === "0") {
                            document.querySelector('.releaseInputs').style.display = 'block';
                            $('#type').val('partial');
                            $('#amountRelease').val((bal) / 2);
                        }

                        $('#fam_reps').html("Passed Member: <strong>" + json.hd_id.hd_full_name + "</strong>");
                        $('#deceased_id').val(id);
                        $('#status').html(`Status: <strong class="${statusColorClass}">${statusText}</strong>`);
                        $('#total_bal').html("Total: <strong>₱ " + total.toFixed(2) + "</strong>");
                        $('#remaining_bal').html("Remaining Balance: <strong>₱ " + (total - amtRel).toFixed(2) + "</strong>");

                        // $('#type').val('partial');

                        // if (status === "1") {
                        //     $('#type').val('full');
                        // }

                        // $('#amountRelease').val((bal) / 2);

                        $('#type').off('change').on('change', function() {
                            let selectedType = $(this).val();
                            let amountField = $('#amountRelease');

                            let total = parseFloat($('#total_bal').text().replace(/[^\d.]/g, '')) || 0;
                            let bal = parseFloat($('#remaining_bal').text().replace(/[^\d.]/g, '')) || 0;

                            if (selectedType === "partial") {
                                amountField.val(((bal) / 2).toFixed(2));
                            } else if (selectedType === "full") {
                                amountField.val((bal).toFixed(2));
                            }
                        });

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

    function payMoney(df_id, dd_id) {
        $('#df_id').val(df_id); // Set df_id in modal
        $('#dd_id').val(dd_id); // Set dd_id
        $('#payMoneyModal').modal('show'); // Show modal
    }


    $('#openDetailsForm').submit(function(e) {
        e.preventDefault();

        let dd_id = $('#deceased_id').val();
        let date = $('#relDate').val();
        let fullname = $('#fullname').val();
        let type = $('#type').val();
        let amountRel = $('#amountRelease').val();
        let totalAmount = $('#total_bal').val();

        console.log(dd_id);
        console.log(date);
        console.log(fullname);
        console.log(type);
        console.log(amountRel);
        console.log(totalAmount);

        if (date.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Release Date',
                text: 'Please add release date before proceeding.',
            });
            return;
        }

        Swal.fire({
            title: "Confirmation",
            text: "Do you wish to release this amount?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo base_url('Payment_ctrl/updateReleaseFund'); ?>",
                    type: "POST",
                    data: {
                        id: dd_id,
                        date: date,
                        name: fullname,
                        type: type,
                        amountRel: amountRel,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', 'Amount Released!', 'success');
                            $("#fullname").val("");
                            $("#relDate").val("");
                            $('#details-table').DataTable().ajax.reload();
                            $('#table-data').DataTable().ajax.reload(); // Refresh table
                        } else {
                            Swal.fire('Error', 'Failed to update amount.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // Handle form submission
    $('#payMoneyForm').submit(function(e) {
        e.preventDefault();

        let df_id = $('#df_id').val();
        let dd_id = $('#dd_id').val();
        let amount = $('#amount').val();
        console.log(df_id);

        Swal.fire({
            title: "Confirmation",
            text: "Do you wish to complete the payment?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo base_url('Payment_ctrl/updateDeathFund'); ?>",
                    type: "POST",
                    data: {
                        df_id: df_id,
                        dd_id: dd_id,
                        amount: amount
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', 'Amount updated successfully!', 'success');
                            $('#payMoneyModal').modal('hide'); // Close modal
                            $('#setup').DataTable().ajax.reload(); // Refresh table
                            $('#table-data').DataTable().ajax.reload(); // Refresh table
                        } else {
                            Swal.fire('Error', 'Failed to update amount.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // document.getElementById("quantity").addEventListener("change", function() {
    //     let amountField = document.getElementById("amount");

    //     if (this.value === "partial") {
    //         amountField.value = 50; // Set amount for Partial (change as needed)
    //     } else if (this.value === "full") {
    //         amountField.value = 100; // Set amount for Full (change as needed)
    //     }
    // });
</script>