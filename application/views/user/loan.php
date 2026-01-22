<section id="content">
    <main>
        <div class="head-title">
            <div class="left mb-2">
                <h1>Loan</h1>
                <ul class="breadcrumb">
                    <div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoaner" style="font-size: 14px;">
                                <i class="fas fa-user-plus"></i> Add New
                            </button>
                        </div>
                    </div>
                </ul>
            </div>

            <div class="buttons">
                <a href="#" class="btn-upload" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class='bx bxs-cloud-upload'></i>
                    <span class="text">Import CSV</span>
                </a>

                <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
            </div>
        </div>

        <div class="modal fade" id="addLoaner" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 500px; overflow:hidden;">
                <div class="table-data">
                    <div class="modal-content">
                        <div class="modal-body" id="modal-content">
                            <h5 class="modal-title mb-3" id="uploadModalLabel">Details</h5>

                            <div class="form-group mb-3 mt-3 position-relative">
                                <label for="Full Name">Full Name</label>
                                <input type="text" class="form-control" id="iName" placeholder="Select Member" autocomplete="off">
                                <input type="hidden" id="hdId"> 

                                <div id="nameDropdown" class="dropdown-menu w-100" style="max-height: 100px; overflow-y: auto; display: none; font-size:12px">
                                    <div id="dropdownList"></div>
                                </div>
                            </div>

                            <div id="issuedForms">
                                <div class="form-group mb-3 issued-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="loan_amount">Amount</label>
                                            <input type="text" class="form-control" id="loan_amount" placeholder="Amount">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="loan_date">Issue Date</label>
                                            <input type="date" class="form-control" id="loan_date" placeholder="Select Date">

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="saveLoaner" name="submit" class="btn btn-primary">Add</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-data mt-0">
            <div class="order">
                <table id="loaner-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>FULL NAME</th>
                            <th>ADDRESS</th>
                            <th>PHONE</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th style="width:100px;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="showLoanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">

                            <div class="modal-header d-flex justify-content-between w-100 col-12">
                                <div class="col-2">
                                    <div>
                                        <label class="form-label">Select Date :</label>
                                        <select id="header_date_arr" class="form-select form-select-sm">
                                        </select>
                                    </div>
                                </div>

                                <div class="ml-6">
                                    <div>
                                        <label class="form-label">Name : <span id="header_name" style="font-weight: bold;"></span> </label>
                                        <input type="hidden" id="header_id">
                                    </div>
                                    <div>
                                        <label class="form-label">Principal Amount : ₱ <span id="header_amount" style="font-weight: bold;"></span> </label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div>
                                        <label class="form-label">
                                            Loan Date : <span id="header_date" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="form-label">
                                            Returned Date : <span id="header_date_return" style="font-weight: bold;"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="text-align: center; padding:6px 8px;">MONTH</th>
                                                <th style="text-align: center; padding:6px 8px;">INTEREST RATE (%)</th>
                                                <th style="text-align: center; padding:6px 8px;">INTEREST AMOUNT (₱)</th>
                                                <th style="text-align: center; padding:6px 8px;">PAYMENT DATE</th>
                                                <th style="text-align: center; padding:6px 8px;">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button id="returnBtn" type="submit" class="btn btn-primary">Return Principal</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>

<script>

    var table_data = $("#loaner-table").DataTable({
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
            url: '<?php echo site_url('Loan_ctrl/get_loaner'); ?>',
            type: 'POST',
            data: function(d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
            }
        },
        columns: [{
                data: 'full_name',
            },
            {
                data: 'province'
            },
            {
                data: 'phone1'
            },
            {
                data: 'loan_date',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (data === 'completed') {
                        return '<span class="badge bg-success">Completed</span>';
                    } else {
                       return '<span class="badge bg-warning">Ongoing</span>';
                    }
                }
            },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <div style="text-center">
                            ${row.r_status != 1 ? `
                                <button class="btn btn-primary btn-sm" 
                                        style="padding: 2px 6px; font-size: 12px;" 
                                        onclick="viewLoanDetails('${row.loan_ids}', '${row.full_name}','${row.statuses}' ,'${row.loan_dates}', '${row.loan_amts}', '${row.return_dates}')">
                                    <i class="fas fa-eye" style="font-size: 12px;"></i> View
                                </button>
                            ` : ''}
                        </div>
                    `;
                }               
            }
        ]
    });
  
    $(document).on('click', '#saveLoaner', function() {
        let Name = $('#iName').val().trim();
        let Id = $('#hdId').val().trim();
        let Date = $('#loan_date').val().trim();
        let Amount = $('#loan_amount').val().trim();

        console.log(Name);
        console.log(Id);
        console.log(Date);
        console.log(Amount);

        if (Name.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Renter',
                text: 'Please select user before proceeding.',
            });
            return;
        }

        if (Amount.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Loan Amount',
                text: 'Please add loan amount before proceeding.',
            });
            return;
        }

        if (Date.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Issuance Date',
                text: 'Please add issuance date before proceeding.',
            });
            return;
        }

        $.ajax({
            url: '<?php echo site_url('Loan_ctrl/save_loaner'); ?>',
            type: 'POST',
            data: {
                id: Id,
                name: Name,
                date: Date,
                amount: Amount
            },
            dataType: 'json',

            success: function(response) {   
                if (response.staus="success") {
                    Swal.fire('Success', response.message, 'success');

                    $('#addLoaner').modal('hide'); 
                    $('#loaner-table').DataTable().ajax.reload(); 
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                alert("Error while saving rentals.");
            }
        });
    });

    function viewLoanDetails(id, fullname, status, loan_date, loan_amt, return_date) {

        const amount = Number(loan_amt).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        const dates = loan_date.split(', ');
        const ids = id.split(',');
        const amts = loan_amt.split(',');
        const statuses = status.split(',');
        const return_dates = return_date.split(',');

        $('#header_date_arr').empty();

        dates.forEach((date, index) => {
            const isLast = index === dates.length - 1;

            $('#header_date_arr').append(`
                <option value="${date}" data-id="${ids[index]}" data-amt="${amts[index]}" data-status="${statuses[index]}" data-return_date="${return_dates[index]}" ${isLast ? 'selected' : ''}>
                    ${formatDate(date)}
                </option>
            `);
        });

        const selected = $('#header_date_arr option:selected');
        const selectedId = selected.data('id');
        const selectedAmt = selected.data('amt');
        const selectedStatus = selected.data('status').trim();
        const selectedReturn = selected.data('return_date');

        const selectedDate = selected.val();

        const isValidDate = (dateStr) => {
            const date = new Date(dateStr);
            return date instanceof Date && !isNaN(date) && dateStr !== "0000-00-00";
        };

        $('#header_name').text(fullname);

        $('#header_amount').text(Number(selectedAmt).toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

        $('#header_date').text(formatDate(selectedDate));
        $('#header_status').text(selectedStatus);
        $('#header_date_return').text(
            isValidDate(selectedReturn) ? formatDate(selectedReturn) : ''
        );

        $('#header_id').val(selectedId);

        populateLoanTable(selectedId, selectedDate, selectedAmt, selectedStatus, selectedReturn);

        $('#header_date_arr').off('change').on('change', function () {
            const selected = $(this).find(':selected');
            const selectedId = selected.data('id');
            const selectedAmt = selected.data('amt');
            const selectedStatus = selected.data('status').trim();
            const selectedReturn = selected.data('return_date');
            const selectedDate = selected.val();

            const isValidDate = (dateStr) => {
                const date = new Date(dateStr);
                return date instanceof Date && !isNaN(date) && dateStr !== "0000-00-00";
            };

            $('#header_amount').text(Number(selectedAmt).toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            $('#header_date').text(formatDate(selectedDate));
            $('#header_status').text(selectedStatus);
            $('#header_date_return').text(
                isValidDate(selectedReturn) ? formatDate(selectedReturn) : ''
            );
            $('#header_id').val(selectedId);

            populateLoanTable(selectedId, selectedDate, selectedAmt, selectedStatus, selectedReturn);
        });

        $('#showLoanModal').modal('show');
    }

    function populateLoanTable(id, selectedDate, selectedAmt, selectedStatus, selectedReturn) {

        $.ajax({
            url: "<?php echo base_url('Loan_ctrl/get_loan_details'); ?>",
            type: "POST",
            dataType: "json",
            data: { id: id },
            success: function (response) {

                const loanDetails = Array.isArray(response) ? response : [];
                const tableBody = $('#showLoanModal table tbody');
                tableBody.empty();

                let status = selectedStatus;
                let amount = selectedAmt;
                let return_date = selectedReturn;

                let startMonth = new Date(selectedDate);
                startMonth.setMonth(startMonth.getMonth() + 1);
                startMonth = startMonth.getMonth();

                const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                let totalInterest = 0;

                let endMonth = 11;
                if (status === "completed" && return_date && return_date !== "0000-00-00") {
                    const tempMonth = new Date(return_date).getMonth();
                    if (!isNaN(tempMonth)) endMonth = tempMonth;
                } else if (return_date && return_date !== "0000-00-00") {
                    const tempMonth = new Date(return_date).getMonth();
                    if (!isNaN(tempMonth)) endMonth = tempMonth;
                }

                for (let m = startMonth; m <= endMonth; m++) {

                    const loan = loanDetails.find(l => parseInt(l.month) === (m + 1));

                    const interestRate = loan?.interest_rate ?? '-';
                    const interestAmtValue = loan ? parseFloat(loan.interest_amt) : 0;
                    const interestAmt = loan
                        ? interestAmtValue.toLocaleString('en-PH', { minimumFractionDigits: 2 })
                        : '-';

                    const paymentDate = loan?.payment_date ?? '';

                    let action;

                    if (loan) {
                        action = `
                            <span class="text-success fw-bold" style="font-size:12px;">
                                <i class="fa fa-check-circle"></i> Paid
                            </span>`;
                    } else {
                        action = `
                            <button class="btn btn-primary btn-sm pay-btn"
                                data-month="${m + 1}"
                                data-id="${id}"
                                data-amount="${amount}"
                                style="padding:4px 8px;font-size:10px;">
                                <i class="fa fa-credit-card me-1"></i> Pay
                            </button>`;
                    }

                    totalInterest += interestAmtValue;

                    tableBody.append(`
                    <tr>
                        <td style="padding: 5px 6px;">${monthNames[m]}</td>
                        <td style="padding: 5px 6px;">${interestRate}</td>
                        <td style="padding: 5px 6px;">${interestAmt}</td>
                        <td style="padding: 5px 6px;">${formatDate(paymentDate) || '-'}</td>
                        <td style="padding: 5px 6px;">${action}</td>
                    </tr>
                    `);
                }

                tableBody.append(`
                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td colspan="2" class="text-end">Total Interest:</td>
                        <td class="text-center">
                            ₱${totalInterest.toLocaleString('en-PH', { minimumFractionDigits: 2 })}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                `);

                const returnBtn = $('#returnBtn');

                if (loanDetails.length <= 0 || status ==="completed") {
                    returnBtn.hide();
                } else {
                    returnBtn.show();
                }
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        });
    }

    $(document).on('click', '.pay-btn', function() {
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const month = $(this).data('month'); 
        const id = $(this).data('id');
        const amount = $(this).data('amount');

        const defaultDate = new Date(new Date().getFullYear(), 0);
        defaultDate.setMonth(month);
        defaultDate.setDate(1);

        Swal.fire({
            title: 'Confirm Payment',
            html: `
                <p>Month: <b>${monthNames[month-1]}</b></p>
                <label for="paymentDate">Select Payment Date:</label>
                <input type="date" id="paymentDate" class="swal2-input" value="${defaultDate.toISOString().split('T')[0]}">
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Pay'
        }).then((result) => {
            if (result.isConfirmed) {
                const selectedDate = document.getElementById('paymentDate').value;
                if (!selectedDate) {
                    Swal.fire('Error', 'Please select a payment date.', 'error');
                    return;
                }

                const selectedMonth = new Date(selectedDate).getMonth() + 1;
                const interestRate = selectedMonth > month ? 0.10 : 0.05;
                const interestAmount = amount * interestRate;

                $.ajax({
                    url: "<?php echo base_url('Loan_ctrl/pay_loan'); ?>",
                    type: "POST",
                    data: {
                        id: id,
                        month: month,
                        interest_rate: interestRate,
                        interest_amount: interestAmount,
                        payment_date: selectedDate
                    },
                    success: function(response) {

                        Swal.fire('Paid!', `
                            Payment recorded.<br>
                            Interest: ₱${interestAmount.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2})}<br>
                            Payment Date: ${selectedDate}
                        `, 'success');

                        const row = $(`.pay-btn[data-id="${id}"][data-month="${month}"]`).closest('tr');

                        row.find('td:last').html('<span class="text-success fw-bold" style="font-size:12px;"><i class="fa fa-check-circle me-1"></i>Paid</span>');
                        row.find('td:nth-child(4)').text(selectedDate);
                        row.find('td:nth-child(2)').text((interestRate*100) + '%');
                        row.find('td:nth-child(3)').text(interestAmount.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2}));

                        $('#returnBtn').show();

                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '#returnBtn', function() {
        const id = $('#header_id').val();
        const amount = $('#header_amount').text();

        console.log(id);

        Swal.fire({
            title: 'Confirm Return',
            text: 'Are you sure you want to return the ₱' + amount + ' principal amount?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Return'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo base_url('Loan_ctrl/return_principal'); ?>",
                    type: "POST",
                    data: {
                        id: id,
                        amount: amount
                    },
                    success: function(response) {
                        Swal.fire('Returned!', response.message, 'success');
                        $('#showLoanModal').modal('hide');
                        $('#loaner-table').DataTable().ajax.reload(); 
                    },
                    error: function() {
                        Swal.fire('Error', response.message, 'error');
                    }
                });
            }
        });

    });

    $(document).ready(function() {
        let allUsers = []; 

        $("#iName").on("focus", function() {
            fetchNames();
        }).on("input", function() {
            let searchText = $(this).val().toLowerCase();
            filterNames(searchText);
        });

        function fetchNames() {
            $.ajax({
                url: "<?php echo site_url('Rental_ctrl/get_all_users'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    allUsers = response; 
                    displayNames(allUsers);
                },
                error: function() {
                    console.error("Failed to fetch names.");
                }
            });
        }

        function displayNames(users) {
            let dropdownList = $("#dropdownList");
            dropdownList.empty(); 

            if (users.length > 0) {
                users.forEach(user => {
                    let item = `<a href="#" class="dropdown-item name-option" data-id="${user.hd_id}">${user.full_name}</a>`;
                    dropdownList.append(item);
                });

                $("#nameDropdown").show(); 
            } else {
                $("#nameDropdown").hide(); 
            }
        }

        function filterNames(searchText) {
            let filteredUsers = allUsers.filter(user => user.full_name.toLowerCase().includes(searchText));
            displayNames(filteredUsers);
        }

        $(document).on("click", ".name-option", function(e) {
            e.preventDefault();
            $("#iName").val($(this).text()); 
            $("#hdId").val($(this).data("id")); 
            $("#nameDropdown").hide(); 
        });

        $(document).click(function(e) {
            if (!$(e.target).closest("#iName, #nameDropdown").length) {
                $("#nameDropdown").hide();
            }
        });
    });

    document.getElementById('loan_amount').addEventListener('input', function(e) {
        let value = e.target.value;
        value = value.replace(/[^0-9]/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        e.target.value = value;
    });

    function formatDate(dateString) {
        if (!dateString) return ''; // Handle empty/null values
        let date = new Date(dateString);
        let options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        return date.toLocaleDateString('en-US', options);
    }
</script>