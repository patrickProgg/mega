<style>
    #addFamModal {
        z-index: 1060 !important;
        /* Higher than default 1050 */
    }

    .dropdown-menu {
        font-size: 15px;
    }

    label {
    font-size: 12px; /* or whatever size you want */
}

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
                <h1>Members</h1>
                <ul class="breadcrumb">
                    <!-- <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li> -->
                    <div>
                        <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="font-size: 14px;">
                            <i class="fas fa-user-plus"></i> Add Member
                        </button> -->
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" onclick="openModal('addParent')" style="font-size: 14px;">
                                <i class="fas fa-user-plus"></i> Add Member
                            </button>

                            <!-- <button onclick="openModal('addParent')">Add Parent</button> -->

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonAddress" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Address
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAddress" id="address-filter" style="cursor:pointer;">
                                    <a class="dropdown-item">Address</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" data-status="Masayag">Masayag</a>
                                    <a class="dropdown-item" data-status="East">East</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonStatus" id="status-filter" style="cursor:pointer;">
                                    <a class="dropdown-item">Status</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" data-status="1">Active</a>
                                    <a class="dropdown-item" data-status="3">Inactive</a>
                                    <a class="dropdown-item" data-status="2">Deceased</a>
                                </div>
                            </div>
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

        <!-- Upload Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Import CSV File</h5>
                            </div>
                            <form id="csvUploadForm" action="<?php echo base_url('User_ctrl/upload_csv'); ?>" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div>
                                        <label for="csv_file" class="form-label">Select CSV File</label>
                                        <input class="form-control" type="file" name="csv_file" id="csv_file" accept=".csv" required>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <table id="parent_table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:300px;">FULL NAME</th>
                            <th>ADDRESS</th>
                            <th style="width:200px;">PHONE</th>
                            <th style="width:120px;">STATUS</th>
                            <th style="width:80px;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- add member modal -->
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 700px; overflow:hidden;">
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <!-- <h6 class="mb-2 text-primary">Personal Details</h6> -->
                                                <h6 class="mb-2 text-primary" id="modal-title">Personal Details</h6>

                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="First Name">First Name</label>
                                                    <input type="text" class="form-control" id="fname" placeholder="Enter First Name" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Second Name">Middle Name</label>
                                                    <input type="text" class="form-control" id="mname" placeholder="Enter Middle Name" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Middle Name">Last Name</label>
                                                    <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Birthday">Birthday</label>
                                                    <input type="date" class="form-control" id="birthday" placeholder="Enter Birthday">
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Age">Age</label>
                                                    <input type="text" class="form-control" id="age"disabled>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Phone 1">Phone 1</label>
                                                    <input type="text" class="form-control" id="phone1" placeholder="Enter phone number">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Phone 2">Phone 2</label>
                                                    <input type="text" class="form-control" id="phone2" placeholder="Enter phone number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <h6 class="mt-3 mb-2 text-primary">Address</h6>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Purok">Purok</label>
                                                    <input type="name" class="form-control" id="purok" placeholder="Enter Purok" value="Purok 7" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Barangay">Barangay</label>
                                                    <input type="name" class="form-control" id="barangay" placeholder="Enter Barangay" value="Guinacot" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="City">City</label>
                                                    <input type="text" class="form-control" id="city" placeholder="Enter City" value="Guindulman" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Province">Province</label>
                                                    <input type="text" class="form-control" id="province" placeholder="Enter Province" value="Bohol" oninput="capitalizeName(this)">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="Zip">Zip Code</label>
                                                    <input type="text" class="form-control" id="zip_code" placeholder="Zip Code" value="6310">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="birthday">Date Joined</label>
                                                    <input type="date" class="form-control" id="date_joined" placeholder="Select Date">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status">
                                                        <option value="0">Active</option>
                                                        <option value="1">Inactive</option>
                                                        <option value="2">Deceased</option>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="row gutters">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="d-flex justify-content-end">
                                                <!-- <button type="button" id="add" name="submit" class="btn btn-primary ">Add</button> -->
                                                <button type="button" id="submitBtn" class="btn btn-primary" onclick="handleFormSubmit(currentAction, currentId)">Add</button>
                                                <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- add member modal -->

        <!-- view member modal -->
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header" style="margin-top: 0;"> 
                                <label class="form-label" style="font-size: 14px;">Family Representative : <span id="fam_rep" style="font-weight: bold; font-size: 14px;"></span> </label>
                            </div>
                            <div class="modal-body" id="modal-content">
                                <div class="table-responsive">
                                    <table id="details_table" class="table table-hover" style="width:100%;">
                                        <div>
                                            <p class="modal-title mb-2" style="font-weight: bold;">Family Members</p>
                                            <button class="btn btn-primary me-2" onclick="openModal('addMember', currentId)">
                                                <i class="fas fa-user-plus"></i> Add Member
                                            </button>
                                            <input type="hidden" id="member_id">
                                            <button onclick="openShowLoanModal()" class="btn btn-primary">
                                                <i class="fas fa-file-alt"></i> Loan Records
                                            </button>
                                        </div>
                                        <thead>
                                            <tr>
                                                <th style="width:150px;">FULL NAME</th>
                                                <th>ADDRESS</th>
                                                <th style="width:100px;">PHONE</th>
                                                <th style="width:70px;">STATUS</th>
                                                <th style="width:80px;">ACTION</th>
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
        <!-- view member modal -->

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

        <!-- send to modal -->
        <div id="sendUserModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sendUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="table-data">
                    <div class="order">
                        <!-- <div class="modal-content"> -->
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sendUserModalLabel">Confirm Passing Date</h5>
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            </div>
                            <div class="modal-body">
                                <form id="sendUserForm">
                                    <input type="hidden" id="userId" name="user_id">
                                    <div class="mb-2">
                                        <label for="date_died" class="form-label">Passing Date</label>
                                        <input type="date" class="form-control" id="dateDied" name="date_died" required>

                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="submit" class="btn btn-primary">Confirm</button>
                                            <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- send to modal -->

    </main>
</section>

<script>
    
    let currentId = 0;

    $(document).ready(function() {
        $('#addModal').on('hidden.bs.modal', function() {
            let modal = $(this);

            modal.find('input').each(function() {
                let defaultValue = $(this).attr('value');
                if (defaultValue === undefined) {
                    $(this).val(''); 
                } else {
                    $(this).val(defaultValue);
                }
            });
        });
    });

    var table_data = $("#parent_table").DataTable({
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
            url: '<?php echo site_url('User_ctrl/getHeadData'); ?>',
            type: 'POST',
            data: function(d) {
                d.start = d.start || 0;
                d.length = d.length || 10;
                d.status = $('#status-filter .dropdown-item.active').data('status') || '',
                d.address = $('#address-filter .dropdown-item.active').data('status') || ''
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            {
                data: 'full_name'
            },
            {
                data: 'address'
            },
            {
                data: 'phone1',
            },
            {
                data: 'status',
                render: function(data, type, row) {
                    if (data == 'inactive') {
                        return '<span class="badge bg-danger">Inactive</span>';
                    } else if (data == 'deceased') {
                        return '<span class="badge bg-secondary">Deceased</span>';
                    } else {
                        return '<span class="badge bg-success">Active</span>';
                    }
                }
            },
            {
                data: 'hd_id',
                render: function(data, type, row) {
                    return `
                        <div style="display: flex; gap: 10px;">
                            <!-- View Icon -->
                            <i class="fas fa-eye view-icon text-primary" style="cursor: pointer; font-size: 14px;" 
                                onclick="openViewModal('${row.hd_id}', '${row.full_name}')"></i>

                            <!-- Edit Icon -->
                            <i class="fas fa-edit text-warning" style="cursor:pointer; font-size:14px;"
                                onclick='openModal("editParent", ${JSON.stringify(row)})'></i>

                            <!-- Send To Icon (Hidden if status is 2) -->
                            ${row.status != 2 ? `
                                <i class="fas fa-paper-plane text-info" style="cursor: pointer; font-size: 14px;" 
                                    onclick="sendTo('${row.hd_id}')"></i>
                            ` : ''}
                        </div>
                    `;
                }
            }
        ]
    });

    function openViewModal(id, fullname) {

        currentId = id;

        $('#member_id').val(id);
        $('#fam_rep').text(fullname);

        $('#viewModal').modal('show');

        if ($.fn.dataTable.isDataTable('#details_table')) { 
            $('#details_table').DataTable().clear().destroy(); 
        }

        var details_table = $('#details_table').DataTable({
            autoWidth: false,
            processing: true,
            serverSide: true,
            paging: false,
            searching: false,
            info: false,
            lengthChange: false,
            ordering: false,
            ajax: {
                url: '<?php echo base_url('User_ctrl/getHeadDetails'); ?>',
                type: 'POST',
                dataType: 'json',
                data: function(d) {
                    d.id = id;
                    return d;
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
                    data: 'address'
                },
                {
                    data: 'phone1'
                },
                {
                    data: 'ul_status',
                    render: function(data, type, row) {
                        if (data == 'inactive') {
                            return '<span class="badge bg-danger">Inactive</span>';
                        } else if (data == 'deceased') {
                            return '<span class="badge bg-secondary">Deceased</span>';
                        } else {
                            return '<span class="badge bg-success">Active</span>';
                        }
                    }
                },
                {
                    data: 'ln_id',
                    render: function(data, type, row) {
                        return `
                            <div style="display: flex; gap: 10px;  align-items: center;">
                                <!-- View Icon -->
                                <i class="fas fa-eye view-icon text-primary" style="cursor: pointer; font-size: 14px;" 
                                    onclick="openViewModals('${row.ln_id}')"></i>

                                <!-- Edit Icon -->
                                <i class="fas fa-edit text-warning" style="cursor:pointer; font-size:14px;"
                                    onclick='openModal("editMember", ${JSON.stringify(row)})'></i>

                                    <!-- Send To Icon -->
                                <i class="fas fa-paper-plane text-info" style="cursor: pointer; font-size: 14px;" 
                                    onclick="sendTo('${row.ln_id}')"></i>
                            </div>
                            
                        `;
                    }
                }
            ],
        });
    }

    function openModal(action, row) {

        console.log(row);

        currentAction = action;

        if (row) {
            currentId = row.hd_id || row.ln_id;
        }
        console.log(currentId);

        const modalEl = document.getElementById('addModal');
        const submitBtn = document.getElementById('submitBtn');

        if (document.querySelectorAll('.modal.show').length > 0) {
            modalEl.classList.add('modal-stack');

            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show modal-backdrop-stack';
            document.body.appendChild(backdrop);
        }

        submitBtn.textContent = action.startsWith('add') ? 'Add' : 'Update';

        if (action === 'editParent' || action === 'editMember' && row) {
            $('#fname').val(row.fname);
            $('#mname').val(row.mname);
            $('#lname').val(row.lname);
            $('#birthday').val(row.birthday);
            $('#age').val(row.age);
            $('#phone1').val(row.phone1);
            $('#phone2').val(row.phone2);
            $('#purok').val(row.purok);
            $('#barangay').val(row.barangay);
            $('#city').val(row.city);
            $('#province').val(row.province);
            $('#zip_code').val(row.zip_code);
            $('#date_joined').val(row.date_joined);
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        modalEl.addEventListener('hidden.bs.modal', () => {
            modalEl.classList.remove('modal-stack');

            const stackedBackdrop = document.querySelector('.modal-backdrop-stack');
            if (stackedBackdrop) stackedBackdrop.remove();
        }, { once: true });
    }


    function handleFormSubmit(action, id = null) {

        if(id === null){
            id= $('#member_id').val();
            console.log(id);
        }
        
        const formData = {
            fname: $('#fname').val(),
            mname: $('#mname').val(),
            lname: $('#lname').val(),
            birthday: $('#birthday').val(),
            age: $('#age').val(),
            phone1: $('#phone1').val(),
            phone2: $('#phone2').val(),
            purok: $('#purok').val(),
            barangay: $('#barangay').val(),
            city: $('#city').val(),
            province: $('#province').val(),
            zip_code: $('#zip_code').val(),
            date_joined: $('#date_joined').val()
        };
        
       switch(action) {
            case 'addParent':
                url = '<?php echo base_url("User_ctrl/addParent"); ?>';
                method = 'POST';
                break;

            case 'addMember':
                url = '<?php echo base_url("User_ctrl/addMember/"); ?>' + id;
                method = 'POST';
                break;

            case 'editParent':
                url = '<?php echo base_url("User_ctrl/updateParent/"); ?>' + id;
                method = 'POST';
                break;

            case 'editMember':
                url = '<?php echo base_url("User_ctrl/updateMember/"); ?>' + id;
                method = 'POST';
                break;
        }

        $.ajax({
            url: url,
            type: method,
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res.success) { 
                    Swal.fire({ 
                        title: 'Success', 
                        text: 'Member added successfully', 
                        icon: 'success', 
                        timer: 1000, 
                        showConfirmButton: false 
                    }).then(() => { 
                        table_data.ajax.reload(); 
                        $('#details_table').DataTable().ajax.reload(); }); 
                    } else {
                        lert(res.message);
                }
            },
            error: function(err) {
                console.log(err);
                alert('Server error. Check console.');
            }
        });
        
        const addModalEl = document.getElementById('addModal');
        const modal = bootstrap.Modal.getInstance(addModalEl);
        modal.hide();
    }

    function sendTo(id) {
        $('#userId').val(id); // Set user ID in the modal hidden input
        // console.log(id);
        $('#sendUserModal').modal('show'); // Show the modal

    }

    // Handle form submission
    $('#sendUserForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var user_id = $('#userId').val();
        var date_died = $('#dateDied').val();

        if (date_died === '') {
            alert('Please enter date of death.');
            return;
        }

        $.ajax({
            url: "<?php echo base_url('User_ctrl/sendTo'); ?>",
            type: "POST",
            data: {
                user_id: user_id,
                date_died: date_died
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success',
                    text: 'Member added successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Refresh the page after user clicks "OK"
                    }
                });
            },
            error: function() {
                alert('Failed to send user.');
            }
        });
    });

    function openShowLoanModal() {

        const modalEl = document.getElementById('showLoanModal');

        if (document.querySelectorAll('.modal.show').length > 0) {
            modalEl.classList.add('modal-stack');

            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show modal-backdrop-stack';
            document.body.appendChild(backdrop);
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        var name = $('#fam_rep').text();
        var id = $('#member_id').val();

        console.log(name);
        console.log(id);

        $('#header_name').text(name);


        modalEl.addEventListener('hidden.bs.modal', () => {
            modalEl.classList.remove('modal-stack');

            const stackedBackdrop = document.querySelector('.modal-backdrop-stack');
            if (stackedBackdrop) stackedBackdrop.remove();
        }, { once: true });
    }

    $(document).ready(function() {
        $('#birthday').on('change', function() {
            let birthDate = new Date($(this).val());
            let today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();

            // Adjust if birthday hasn't occurred this year yet
            let monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            $('#age').val(age); // Set calculated age in input field
        });
    });

    $(document).ready(function() {
        $('#e_birthday').on('change', function() {
            let birthDate = new Date($(this).val());
            let today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();

            // Adjust if birthday hasn't occurred this year yet
            let monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            $('#e_age').val(age); // Set calculated age in input field
        });
    });

    $('#status-filter .dropdown-item').click(function() {
        var selectedStatus = $(this).data('status');
        var selectedText = $(this).text();

        // Add 'active' class to selected, remove from others
        $('#status-filter .dropdown-item').removeClass('active');
        $(this).addClass('active');

        $('#dropdownMenuButtonStatus').text(selectedText);

        // Reload the table with the selected filter
        table_data.ajax.reload();
    });

    $('#headerStatus, #headerAddress').click(function() {
        location.reload();
    });

    
    $('#address-filter .dropdown-item').click(function() {
        var selectedStatus = $(this).data('status');
        var selectedText = $(this).text();

        // Add 'active' class to selected, remove from others
        $('#address-filter .dropdown-item').removeClass('active');
        $(this).addClass('active');

        $('#dropdownMenuButtonAddress').text(selectedText);

        // Reload the table with the selected filter
        table_data.ajax.reload();
    });

</script>