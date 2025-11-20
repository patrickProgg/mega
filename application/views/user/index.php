<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<style>
    #addFamModal {
        z-index: 1060 !important;
        /* Higher than default 1050 */
    }

    .dropdown-menu {
        font-size: 15px;
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
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="font-size: 14px;">
                                <i class="fas fa-user-plus"></i> Add Member
                            </button>

                            <!-- <button class="btn" title="Filter" style="border:none;" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter"></i>
                            </button> -->

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonAddress" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Address
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAddress" id="address-filter" style="cursor:pointer;">
                                    <!-- <a class="dropdown-item" href="#">Default</a> -->
                                    <a class="dropdown-item">Address</a>
                                    <!-- <a class="dropdown-header" id="addressHeader">Address</a> -->
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" data-status="Masayag">Masayag</a>
                                    <a class="dropdown-item" data-status="East">East</a>
                                    <!-- <a class="dropdown-item" data-status="Guinacot">Guinacot</a> -->
                                    <!-- <a class="dropdown-item" data-status="Guindulman">Guindulman</a> -->
                                </div>
                            </div>

                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonStatus" id="status-filter" style="cursor:pointer;">
                                    <a class="dropdown-item">Status</a>
                                    <!-- <a class="dropdown-header" id="statusHeader">Status</a> -->
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
                <!-- <table id="table-data" class="table table-striped" style="width:100%"> -->
                <table id="table-data" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <!-- <th>User ID</th> -->
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
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <!-- <div class="modal-content" style="background-color: transparent; border:none;"> -->
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <div class="row gutters">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="account-settings">
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                                    </div>
                                                    <h5 class="user-name">Yuki Hayashi</h5>
                                                    <h6 class="user-email">yuki@Maxwell.com</h6>
                                                </div>
                                                <div class="about">
                                                    <h5>About</h5>
                                                    <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <h6 class="mb-2 text-primary">Personal Details</h6>
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
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Birthday">Birthday</label>
                                                        <input type="date" class="form-control" id="birthday" placeholder="Enter Birthday">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Age">Age</label>
                                                        <input type="text" class="form-control" id="age" placeholder="Enter Age">
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
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="eMail">Email</label>
                                                        <input type="email" class="form-control" id="email" placeholder="Enter email ID" oninput="capitalizeName(this)">
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
                                                        <input type="text" class="form-control" id="zip" placeholder="Zip Code" value="6310">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="d-flex justify-content-end mt-5">
                                                        <button type="button" id="add" name="submit" class="btn btn-primary ">Add</button>
                                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="add" name="submit" class="btn btn-primary ">Add</button>
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
        </div>
        <!-- add member modal -->

        <!-- add family member modal -->
        <div class="modal fade" id="addFamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <div class="row gutters">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="account-settings">
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                                    </div>
                                                    <h5 class="user-name">Yuki Hayashi</h5>
                                                    <h6 class="user-email">yuki@Maxwell.com</h6>
                                                </div>
                                                <div class="about">
                                                    <h5>About</h5>
                                                    <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <h6 class="mb-2 text-primary">Personal Details</h6>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="First Name">First Name</label>
                                                        <input type="text" class="form-control" id="af_fname" placeholder="Enter First Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Second Name">Middle Name</label>
                                                        <input type="text" class="form-control" id="af_mname" placeholder="Enter Middle Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Middle Name">Last Name</label>
                                                        <input type="text" class="form-control" id="af_lname" placeholder="Enter Last Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Birthday">Birthday</label>
                                                        <input type="date" class="form-control" id="af_birthday" placeholder="Enter Birthday">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Age">Age</label>
                                                        <input type="text" class="form-control" id="af_age" placeholder="Enter Age">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Phone 1">Phone 1</label>
                                                        <input type="text" class="form-control" id="af_phone1" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Phone 1">Phone 2</label>
                                                        <input type="text" class="form-control" id="af_phone2" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="eMail">Email</label>
                                                        <input type="email" class="form-control" id="af_email" placeholder="Enter email ID" oninput="capitalizeName(this)">
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
                                                        <input type="name" class="form-control" id="af_purok" placeholder="Enter Purok" value="Purok 7" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Barangay">Barangay</label>
                                                        <input type="name" class="form-control" id="af_barangay" placeholder="Enter Barangay" value="Guinacot" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="City">City</label>
                                                        <input type="text" class="form-control" id="af_city" placeholder="Enter City" value="Guindulman" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Province">Province</label>
                                                        <input type="text" class="form-control" id="af_province" placeholder="Enter Province" value="Bohol" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Zip">Zip Code</label>
                                                        <input type="text" class="form-control" id="af_zip" placeholder="Zip Code" value="6310">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="d-flex justify-content-end mt-5">
                                                        <button type="button" id="addFam" name="submit" class="btn btn-primary ">Add</button>
                                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="addFam" name="submit" class="btn btn-primary ">Add</button>
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
        </div>
        <!-- add family member modal -->

        <!-- view member modal -->
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header" style="margin-top: 0;">
                                <div style="font-family: Arial; font-size: 16px;" id="fam_rep"></div>
                            </div>
                            <div class="modal-body" id="modal-content">
                                <!-- <div class="table-data"> -->
                                <div class="table-responsive">
                                    <table id="setup" class="table table-hover" style="width:100%;">
                                        <div>
                                            <p class="modal-title" style="font-weight: bold;">Family Members</p>
                                            <h5></h5>
                                            <!-- <button class="btn btn-primary" onclick="AddFamModal()"><i class="fas fa-user-plus"></i> Add Member </button> -->
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFamModal">
                                                <i class="fas fa-user-plus"></i> Add Member
                                            </button>
                                        </div>
                                        <thead>
                                            <tr>
                                                <!-- <th>ID</th> -->
                                                <th style="width:150px;">FULL NAME</th>
                                                <th>ADDRESS</th>
                                                <th style="width:100px;">PHONE</th>
                                                <!-- <th>Email</th> -->
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

        <!-- edit member modal -->
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <div class="row gutters">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="account-settings">
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                                    </div>
                                                    <!-- <h5 class="user-name">Yuki Hayashi</h5> -->
                                                    <h5 id="es_fname"></h5>
                                                    <h6 class="user-email">yuki@Maxwell.com</h6>
                                                </div>
                                                <div class="about">
                                                    <h5>About</h5>
                                                    <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <h6 class="mb-2 text-primary">Personal Details</h6>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="First Name">First Name</label>
                                                        <input type="text" class="form-control" id="e_fname" placeholder="Enter First Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Second Name">Middle Name</label>
                                                        <input type="text" class="form-control" id="e_mname" placeholder="Enter Middle Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Middle Name">Last Name</label>
                                                        <input type="text" class="form-control" id="e_lname" placeholder="Enter Last Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Birthday">Birthday</label>
                                                        <input type="date" class="form-control" id="e_birthday" placeholder="Enter Birthday">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Age">Age</label>
                                                        <input type="text" class="form-control" id="e_age" placeholder="Enter Age">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Phone 1">Phone 1</label>
                                                        <input type="text" class="form-control" id="e_phone1" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Phone 2">Phone 2</label>
                                                        <input type="text" class="form-control" id="e_phone2" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="eMail">Email</label>
                                                        <input type="email" class="form-control" id="e_email" placeholder="Enter email ID" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" id="e_username" placeholder="Enter username">
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
                                                        <input type="name" class="form-control" id="e_purok" placeholder="Enter Purok" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Barangay">Barangay</label>
                                                        <input type="name" class="form-control" id="e_barangay" placeholder="Enter Barangay" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="City">City</label>
                                                        <input type="text" class="form-control" id="e_city" placeholder="Enter City" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Province">Province</label>
                                                        <input type="text" class="form-control" id="e_province" placeholder="Enter Province" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="zIp">Zip Code</label>
                                                        <input type="text" class="form-control" id="e_zip" placeholder="Zip Code">
                                                        <input type="hidden" id="hd_id">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="d-flex justify-content-end mt-5">
                                                        <button type="button" id="update" name="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="update" name="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Cancel</button>
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
        </div>
        <!-- edit member modal -->

        <!-- edit fam member modal -->
        <div class="modal fade" id="editFamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 1000px; overflow:hidden;">
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <div class="row gutters">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="account-settings">
                                                <div class="user-profile">
                                                    <div class="user-avatar">
                                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                                    </div>
                                                    <!-- <h5 class="user-name">Yuki Hayashi</h5> -->
                                                    <h5 id="efs_fname"></h5>
                                                    <h6 class="user-email">yuki@Maxwell.com</h6>
                                                </div>
                                                <div class="about">
                                                    <h5>About</h5>
                                                    <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <h6 class="mb-2 text-primary">Personal Details</h6>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="First Name">First Name</label>
                                                        <input type="text" class="form-control" id="ef_fname" placeholder="Enter First Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Second Name">Middle Name</label>
                                                        <input type="text" class="form-control" id="ef_mname" placeholder="Enter Second Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Middle Name">Last Name</label>
                                                        <input type="text" class="form-control" id="ef_lname" placeholder="Enter Middle Name" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Birthday">Birthday</label>
                                                        <input type="date" class="form-control" id="ef_birthday" placeholder="Enter Birthday">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Age">Age</label>
                                                        <input type="text" class="form-control" id="ef_age" placeholder="Enter Age">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Phone 1">Phone 1</label>
                                                        <input type="text" class="form-control" id="ef_phone1" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Phone 2">Phone 2</label>
                                                        <input type="text" class="form-control" id="ef_phone2" placeholder="Enter phone number">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="eMail">Email</label>
                                                        <input type="email" class="form-control" id="ef_email" placeholder="Enter email ID" oninput="capitalizeName(this)">
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
                                                        <input type="name" class="form-control" id="ef_purok" placeholder="Enter Purok" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Barangay">Barangay</label>
                                                        <input type="name" class="form-control" id="ef_barangay" placeholder="Enter Barangay" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="City">City</label>
                                                        <input type="text" class="form-control" id="ef_city" placeholder="Enter City" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="Province">Province</label>
                                                        <input type="text" class="form-control" id="ef_province" placeholder="Enter Province" oninput="capitalizeName(this)">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <div class="form-group">
                                                        <label for="zIp">Zip Code</label>
                                                        <input type="text" class="form-control" id="ef_zip" placeholder="Zip Code">
                                                        <input type="hidden" id="ln_id">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="row gutters">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="d-flex justify-content-end mt-5">
                                                        <button type="button" id="updateFam" name="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" id="updateFam" name="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Cancel</button>
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
        </div>
        <!-- edit fam member -->

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
    $(document).ready(function() {
        $('#addModal, #addFamModal').on('show.bs.modal', function() {
            let modal = $(this);

            // Clear all inputs EXCEPT those with predefined values
            modal.find('input').each(function() {
                let defaultValue = $(this).attr('value'); // Get the default value from the HTML
                if (defaultValue === undefined) {
                    $(this).val(''); // Only clear fields that don’t have default values
                } else {
                    $(this).val(defaultValue); // Restore the default value
                }
            });
        });
    });

    var table_data = $("#table-data").DataTable({
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
            url: '<?php echo site_url('User_ctrl/getData'); ?>',
            type: 'POST',
            data: function(d) {
                return {
                    start: d.start,
                    length: d.length,
                    order: d.order,
                    search: d.search.value,
                    draw: d.draw,
                    status: $('#status-filter .dropdown-item.active').data('status') || '',
                    address: $('#address-filter .dropdown-item.active').data('status') || ''
                    // status: $("#status-filter").val()
                };
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                console.error("AJAX request failed: " + error);
            }
        },
        columns: [
            // {
            //     data: 'hd_id',
            //     render: function(data, type, row) {
            //         const idNo = String(row.hd_id).padStart(4, '0');
            //         return idNo;
            //     }

            // },
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
                    if (data == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else if (data == 2) {
                        return '<span class="badge bg-secondary">Deceased</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactive</span>';
                    }
                }
            },
            // {
            //     data: 'status',
            //     render: function(data, type, row) {
            //         if (data == 1) {
            //             return '<span style="color: green;">Active</span>';
            //         } else if (data == 2) {
            //             return '<span style="color: gray;">Deceased</span>';
            //         } else {
            //             return '<span style="color: red;">Inactive</span>';
            //         }
            //     }
            // },
            {
                data: 'hd_id',
                render: function(data, type, row) {
                    return `
            <div style="display: flex; gap: 10px;">
                <!-- View Icon -->
                <i class="fas fa-eye view-icon text-primary" style="cursor: pointer; font-size: 14px;" 
                    onclick="openViewModal('${row.hd_id}')"></i>

                <!-- Edit Icon -->
                <i class="fas fa-edit edit-icon text-warning" style="cursor: pointer; font-size: 14px;" 
                    onclick="openEditModal('${row.hd_id}')"></i>

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


    $('#add').click(function() {
        var fname = $('#fname').val().trim();
        var lname = $('#lname').val().trim();

        var date = new Date().toISOString().split('T')[0]; // "2025-03-24"

        // Validation
        if (fname === '' || lname === '') {
            Swal.fire('Warning', 'First Name and Last Name are required', 'info');
            return; // Stop execution if validation fails
        }

        Swal.fire({
            title: "Confirmation",
            text: "Do you want to add this member?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add member!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    fname: $('#fname').val(),
                    mname: $('#mname').val(),
                    lname: $('#lname').val(),
                    birthday: $('#birthday').val(),
                    age: $('#age').val(),
                    phone1: $('#phone1').val(),
                    phone2: $('#phone2').val(),
                    email: $('#email').val(),
                    purok: $('#purok').val(),
                    barangay: $('#barangay').val(),
                    city: $('#city').val(),
                    province: $('#province').val(),
                    zip_code: $('#zip').val(),
                    date: date
                };

                $.ajax({
                    url: '<?php echo base_url("User_ctrl/addMember"); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', 'Member added successfully', 'success');

                            $('#addModal').modal('hide'); // Close the modal
                            // $('#addModal input').val('');
                            $('#table-data').DataTable().ajax.reload(); // Refresh DataTable
                        } else {
                            Swal.fire('Error', 'Failed to add member', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to add member', 'error');
                        console.error("Error:", xhr.responseText);
                    }
                });
            }
        });
    });

    $('#addFam').click(function() {
        let id = hdData[0].hd_id || null;
        // let id = hdData.hd_id || null; // Use hdData

        console.log(id);

        if (!id) {
            Swal.fire('Error', 'Invalid Family Representative Data', 'error');
            return;
        }

        let fname = $('#af_fname').val().trim();
        let lname = $('#af_lname').val().trim();

        // Validation
        if (fname === '' || lname === '') {
            Swal.fire('Warning', 'First Name and Last Name are required', 'info');
            return;
        }

        var formData = {
            id: id,
            fname: $('#af_fname').val(),
            mname: $('#af_mname').val(),
            lname: $('#af_lname').val(),
            birthday: $('#af_birthday').val(),
            age: $('#af_age').val(),
            phone1: $('#af_phone1').val(),
            phone2: $('#af_phone2').val(),
            email: $('#af_email').val(),
            purok: $('#af_purok').val(),
            barangay: $('#af_barangay').val(),
            city: $('#af_city').val(),
            province: $('#af_province').val(),
            zip_code: $('#af_zip').val()
        };

        $.ajax({
            url: '<?php echo base_url("User_ctrl/addFamMember"); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Member added successfully', 'success');
                    $('.form-group input').each(function() {
                        $(this).val(this.defaultValue);
                    });
                    $('#addFamModal').modal('hide');
                    $('#setup').DataTable().ajax.reload();
                } else {
                    Swal.fire('Error', 'Failed to add member', 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Failed to add member', 'error');
                console.error("Error:", xhr.responseText);
            }
        });
    });


    $('#update').click(function() {

        var formData = {
            id: $('#hd_id').val(), // Get hidden ID
            fname: $('#e_fname').val(),
            mname: $('#e_mname').val(),
            lname: $('#e_lname').val(),
            birthday: $('#e_birthday').val(),
            age: $('#e_age').val(),
            phone1: $('#e_phone1').val(),
            phone2: $('#e_phone2').val(),
            email: $('#e_email').val(),
            username: $('#e_username').val(),
            purok: $('#e_purok').val(),
            barangay: $('#e_barangay').val(),
            city: $('#e_city').val(),
            province: $('#e_province').val(),
            zip_code: $('#e_zip').val()
        };

        $.ajax({
            url: '<?php echo base_url("User_ctrl/updateMember"); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData, // Fixed: Send formData directly
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Member updated successfully', 'success');

                    $('#editModal').modal('hide'); // Close the modal
                    $('#table-data').DataTable().ajax.reload(); // Refresh DataTable
                } else {
                    Swal.fire('Error', 'Failed to update member', 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Failed to update member', 'error');
                console.error("Error:", xhr.responseText);
            }
        });
    });


    $('#updateFam').click(function() {

        var formData = {
            id: $('#ln_id').val(), // Get hidden ID
            fname: $('#ef_fname').val(),
            mname: $('#ef_mname').val(),
            lname: $('#ef_lname').val(),
            birthday: $('#ef_birthday').val(),
            age: $('#ef_age').val(),
            phone1: $('#ef_phone1').val(),
            phone2: $('#ef_phone2').val(),
            email: $('#ef_email').val(),
            username: $('#ef_username').val(),
            purok: $('#ef_purok').val(),
            barangay: $('#ef_barangay').val(),
            city: $('#ef_city').val(),
            province: $('#ef_province').val(),
            zip_code: $('#ef_zip').val()
        };

        $.ajax({
            url: '<?php echo base_url("User_ctrl/updateFamMember"); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData, // Fixed: Send formData directly
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Member updated successfully', 'success');

                    $('#editFamModal').modal('hide'); // Close the modal
                    var table = $('#setup').DataTable();
                    table.ajax.reload(null, false); // Reload without resetting pagination
                    // $('#setup').DataTable().ajax.reload(); // Refresh DataTable
                } else {
                    Swal.fire('Error', 'Failed to update member', 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Failed to update member', 'error');
                console.error("Error:", xhr.responseText);
            }
        });
    });


    // $(document).ready(function() {
    //     var setup = $('#setup').DataTable();

    //     $('#setup tbody').on('click', 'tr', function() {
    //         var data = setup.row(this).data();

    //         if (data) {
    //             var id = data.hd_id;
    //             openEditModal(id);
    //         }
    //     });
    // });




    function openEditModal(id) {

        console.log("Opening modal for ID:", id);

        $('#hd_id').val(id); // Store ID in hidden input
        $('#editModal').modal('show');

        $.ajax({
            url: '<?php echo base_url('User_ctrl/memberDetails'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                console.log("Full Response:", response);
                if (response.data && response.data.length > 0) {
                    var data = response.data[0];
                    $('#es_fname').text(data.full_name);
                    $('#e_fname').val(data.fname);
                    $('#e_mname').val(data.mname);
                    $('#e_lname').val(data.lname);
                    $('#e_birthday').val(data.birthday);
                    $('#e_age').val(data.age);
                    $('#e_phone1').val(data.phone1);
                    $('#e_phone2').val(data.phone2);
                    $('#e_email').val(data.email);
                    $('#e_purok').val(data.purok);
                    $('#e_barangay').val(data.barangay);
                    $('#e_city').val(data.city);
                    $('#e_province').val(data.province);
                    $('#e_zip').val(data.zip);
                } else {
                    Swal.fire('Error', 'No member details found', 'error');
                }
            },

            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr.responseText);
                Swal.fire('Error', 'Failed to load data: ' + error, 'error');
            }
        });
    }

    // $(document).ready(function() {
    //     var setup = $('#setup').DataTable();

    //     $('#setup tbody').on('click', 'tr', function() {
    //         var data = setup.row(this).data();
    //         if (data) {
    //             var id = data.ln_id;
    //             openEditFamModal(id);
    //         }
    //     });
    // });

    function openEditFamModal(id) {

        console.log("Opening modal for ID:", id);
        $('#ln_id').val(id); // Store ID in hidden input
        $('#editFamModal').modal('show');

        $.ajax({
            url: '<?php echo base_url('User_ctrl/memberFamDetails'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                console.log("Full Response:", response);
                if (response.data && response.data.length > 0) {
                    var data = response.data[0];
                    // ef_fname
                    $('#efs_fname').text(data.full_name);
                    $('#ef_fname').val(data.fname);
                    $('#ef_mname').val(data.mname);
                    $('#ef_lname').val(data.lname);
                    $('#ef_birthday').val(data.birthday);
                    $('#ef_age').val(data.age);
                    $('#ef_phone1').val(data.phone1);
                    $('#ef_phone2').val(data.phone2);
                    $('#ef_email').val(data.email);
                    $('#ef_purok').val(data.purok);
                    $('#ef_barangay').val(data.barangay);
                    $('#ef_city').val(data.city);
                    $('#ef_province').val(data.province);
                    $('#ef_zip').val(data.zip);
                } else {
                    Swal.fire('Error', 'No member details found', 'error');
                }
            },

            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr.responseText);
                Swal.fire('Error', 'Failed to load data: ' + error, 'error');
            }
        });
    }

    // $(document).ready(function() {
    //     var setup = $('#setup').DataTable();

    //     $('#setup tbody').on('click', 'tr', function() {
    //         var data = setup.row(this).data();
    //         if (data) {
    //             var id = data.hd_id;
    //             openViewModal(id);
    //         }
    //     });
    // });

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
                paging: false,
                searching: false,
                info: false,
                lengthChange: false,
                ordering: false,
                ajax: {
                    url: '<?php echo base_url('User_ctrl/details'); ?>',
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
                        console.log("HD Data:", json.hd_data); // Debugging
                        console.log("Data:", json.data); // Debugging

                        if (Array.isArray(json.hd_data) && json.hd_data.length > 0) {
                            $('#fam_rep').html("Family Representative - <strong>" + json.hd_data[0].fullname + "</strong>");

                            // Store hd_data in global variable
                            hdData = json.hd_data;
                        } else {
                            $('#fam_rep').text("Family Representative - No Data Available");
                        }
                        return json.data; // DataTables expects an array
                    }
                },
                columns: [
                    // {
                    //     data: 'id'
                    // },
                    {
                        data: 'ul_full_name'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'phone1'
                    },
                    // {
                    //     data: 'email'
                    // },
                    {
                        data: 'ul_status',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Active</span>';
                            } else if (data == 2) {
                                return '<span class="badge bg-secondary">Deceased</span>';
                            } else {
                                return '<span class="badge bg-danger">Inactive</span>';
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
                                        onclick="openViewModal('${row.ln_id}')"></i>

                                    <!-- Edit Icon -->
                                    <i class="fas fa-edit edit-icon text-warning" style="cursor: pointer; font-size: 14px;" 
                                        onclick="openEditFamModal('${row.ln_id}')"></i>

                                        <!-- Send To Icon -->
                                    <i class="fas fa-paper-plane text-info" style="cursor: pointer; font-size: 14px;" 
                                        onclick="sendTo('${row.ln_id}')"></i>
                                </div>
                                
                            `;
                        }
                    }
                ],
            });
        });
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



    // function AddFamModal() {
    //     var addFamModal = new bootstrap.Modal(document.getElementById('addFamModal'));
    //     addFamModal.show();
    // }


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

    // $('#statusHeader, #addressHeader').click(function() {
    //     // Clear active state
    //     $('#status-filter .dropdown-item').removeClass('active');
    //     $('#address-filter .dropdown-item').removeClass('active');

    //     // Reload without filter
    //     $('#table-data').DataTable().ajax.reload();
    // });


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