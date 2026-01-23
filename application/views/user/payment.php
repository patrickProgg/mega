<style>
    .modal.modal-stack {
    z-index: 1065 !important;
}

.modal-backdrop-stack {
    z-index: 1060 !important;
}

</style>
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
                            <div class="modal-header pb-0" style="margin-top: 0;">
                                <div> 
                                    <label class="form-label" style="font-size: 14px;">Passed Member : <span id="fam_rep" style="font-weight: bold; font-size: 14px;"></span> </label>
                                </div>
                                <div> 
                                    <label class="form-label" style="font-size: 14px;">Deadline <span id="fund_dead_line" style="font-weight: bold; font-size: 14px;"></span> </label>
                                </div>
                            </div>
                            <div class="modal-body" id="modal-content">
                                <div class="table-responsive">
                                    <table id="setup" class="table table-hover" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>FULL NAME</th>
                                                <th>AMOUNT</th>
                                                <th>STATUS</th>
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
            <div class="modal-dialog" style="margin-top: 100px;">
                <div class="table-data">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="payMoneyModalLabel">Payment Amount</h5>
                        </div>
                        <div class="modal-body">
                            <form id="payMoneyForm">
                                <input type="hidden" id="df_id" name="df_id">
                                <input type="hidden" id="dd_id" name="dd_id">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="amount" name="amount" required disabled>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary">Pay</button>
                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
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
                            <div class="modal-header pb-0" style="display: flex; width: 100%;">
                                <div>
                                    <div> 
                                        <label class="form-label" style="font-size: 14px;">Passed Member : <span id="fam_reps" style="font-weight: bold; font-size: 14px;"></span> </label>
                                    </div>
                                    <div> 
                                        <label class="form-label" style="font-size: 14px;">Total : ₱ <span id="total_bal" style="font-weight: bold; font-size: 14px;"></span> </label>
                                    </div>
                                </div>
                                <div>
                                    <div> 
                                        <label class="form-label" style="font-size: 14px;">Status : <span id="status" style="font-weight: bold; font-size: 14px;"></span> </label>
                                    </div>
                                    <div> 
                                        <label class="form-label" style="font-size: 14px;">Remaining Balance : ₱ <span id="remaining_bal" style="font-weight: bold; font-size: 14px;"></span> </label>
                                    </div>
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
                                        <button id="relBtn" type="submit" class="btn btn-primary">Release</button>
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
                d.start = d.start || 0;
                d.length = d.length || 10;
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
                data: 'date_died',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'phone1',
            },

            {
                data: 'total_amt',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            {
                data: 'amt_rcv',
                render: function(data, type, row) {
                    if (parseFloat(data) === 0) {
                        return '';
                    }

                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (data == 'pending') {
                        return '<span class="badge bg-danger">Pending</span>';
                    } else if (data == 'partial') {
                        return '<span class="badge bg-primary">Partial</span>';
                    } else {
                        return '<span class="badge bg-success">Settled</span>';
                    }
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <div style="display: flex; gap: 10px;">
                            <!-- View Icon -->
                            <i class="fas fa-eye view-icon text-primary" style="cursor: pointer; font-size: 14px;" 
                                onclick="openDetailsModal('${row.id}', '${row.full_name}', '${row.total_amt}', '${row.status}')"></i>

                            <!-- Edit Icon -->
                            <i class="fas fa-file-alt text-warning" style="cursor: pointer; font-size: 14px;" 
                                onclick="openViewModal('${row.id}', '${row.full_name}', '${row.dead_line}')"></i>
                        </div>  
                    `;
                }
            }
        ]
    });

    function openViewModal(id, fullname, dead_line) {

        let deadline = new Date(dead_line);
        let formattedDeadline = deadline.toLocaleDateString("en-US", {
            month: "long",
            day: "numeric",
            year: "numeric"
        });

        $('#fam_rep').text(fullname);
        $('#fund_dead_line').text(formattedDeadline);

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
                        d.start = d.start || 0;
                        d.length = d.length || 10
                        d.id = id;
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed:", xhr.responseText);
                        Swal.fire('Error', 'Failed to load data: ' + error, 'error');
                    }
                },
                columns: [
                    {
                        data: 'full_name'
                    },
                    {
                        data: 'amt'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            if (data === 'paid') {
                                return '<span class="badge bg-success">Paid</span>';
                            } else {
                                return '<span class="badge bg-danger">Pending</span>';
                            }
                        }
                    },
                    {
                        data: 'df_id',
                        render: function (data, type, row) {
                            return `
                                <div class="text-center">
                                    ${row.status != "paid" ? `
                                        <button class="btn btn-primary btn-sm" 
                                                style="padding: 4px 8px;font-size:10px;" 
                                                 onclick="payMoney('${row.df_id}', '${row.dd_id}')">
                                            <i class="fas fa-credit-card me-1"></i> Pay
                                        </button>
                                    ` : ''}
                                </div>
                            `;
                        }

                    }
                ],
            });

        });
    }

    function openDetailsModal(id, fullname) {

        $('#openDetailsModal').modal('show');

        if ($.fn.dataTable.isDataTable('#details-table')) {
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
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", xhr.responseText);
                    Swal.fire('Error', 'Failed to load data: ' + error, 'error');
                },
                dataSrc: function(json) {

                    console.log(json);
                    
                    let amtRel = 0;
                    let status = json.data[0].status;
                    let total_bal = json.data[0].total_amt;

                    let statusText = "";
                    let statusColorClass = "";

                    switch (status) {
                        case "pending":
                            statusText = "Pending";
                            statusColorClass = "text-danger"; 
                            break;
                        case "partial":
                            statusText = "Partial";
                            statusColorClass = "text-primary";
                            break;
                        case "settled":
                            statusText = "Settled";
                            statusColorClass = "text-success";
                            $('#relBtn').hide();
                            break;
                    }

                    $('#fam_reps').text(fullname);
                    $('#total_bal').text(total_bal);
                    $('#status').text(statusText).removeClass('text-danger text-primary text-success').addClass(statusColorClass);
                    $('#deceased_id').val(id);

                    if (Array.isArray(json.data) && json.data.length > 0) {
                        amtRel = json.data.reduce((sum, item) => sum + (parseFloat(item.amt_rel) || 0), 0);
                    }

                    let total = parseFloat(total_bal) || 0;

                    let bal = total - amtRel;

                    if (status === "settled") {
                        document.querySelector('.releaseInputs').style.display = 'none';
                    } else if (status === "partial") {
                        document.querySelector('.releaseInputs').style.display = 'block';
                        $('#type').val('full');
                        $('#amountRelease').val(bal);
                    } else if (status === "pending") {
                        document.querySelector('.releaseInputs').style.display = 'block';
                        $('#type').val('partial');
                        $('#amountRelease').val((bal) / 2);
                    }

                    $('#remaining_bal').text((total - amtRel).toFixed(2));

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
                    data: 'fullname'
                },
                {
                    data: 'amt_rel',
                    render: function(data) {
                        return data ? `₱ ${parseFloat(data).toFixed(2)}` : "";
                    }
                },
                {
                    data: 'date_rel',
                    render: function(data, type, row) {
                        return formatDate(data);
                    }
                },
            ],
        });
    }

    function payMoney(df_id, dd_id) {

        const modalEl = document.getElementById('payMoneyModal');

        if (document.querySelectorAll('.modal.show').length > 0) {
            modalEl.classList.add('modal-stack');

            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show modal-backdrop-stack';
            document.body.appendChild(backdrop);
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        $.ajax({
            url: '<?php echo base_url("Payment_ctrl/get_mort_amt"); ?>',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success' && res.data.length > 0) {
                    $('#amount').val(res.data[0].mort_amt);
                }
            },
            error: function (err) {
                console.log(err);
                alert('Server error. Check console.');
            }
        });

        $('#df_id').val(df_id);
        $('#dd_id').val(dd_id);

        modalEl.addEventListener('hidden.bs.modal', () => {
            modalEl.classList.remove('modal-stack');

            const stackedBackdrop = document.querySelector('.modal-backdrop-stack');
            if (stackedBackdrop) stackedBackdrop.remove();
        }, { once: true });
    }

    $('#openDetailsForm').submit(function(e) {
        e.preventDefault();

        let dd_id = $('#deceased_id').val();
        let date = $('#relDate').val();
        let fullname = $('#fullname').val();
        let type = $('#type').val();
        let amountRel = $('#amountRelease').val();
        let totalAmount = $('#total_bal').val();

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

    $('#payMoneyForm').submit(function(e) {
        e.preventDefault();

        $('#payMoneyModal').modal('hide');

        let df_id = $('#df_id').val();
        let dd_id = $('#dd_id').val();
        let amount = $('#amount').val();

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
                            $('#payMoneyModal').modal('hide');
                            $('#setup').DataTable().ajax.reload();
                            $('#table-data').DataTable().ajax.reload();
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