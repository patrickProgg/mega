<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->


<style>
    .card {
        font-family: 'Poppins', sans-serif;
        border-radius: 10px;
        margin: 1px;
        /* padding: 10px; */
        width: 220px;
        height: auto;
        /* color: black; */
        /* background: url('<?php echo base_url("assets/image/bg-white.jpg"); ?>') center/cover no-repeat, rgb(176, 228, 241); */
        /* background: linear-gradient(270deg,rgb(233, 241, 220),rgb(195, 221, 243)); */
        background-color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: inline-block;
        margin-bottom: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.5);
    }

    .row-ItemList {
        background-color: blue;
    }

    .card-body p {
        margin-bottom: 5px;
        /* Adjust spacing between text */
        font-size: 14px;
        /* Adjust font size */
    }




    #ItemList {
        display: flex;
        /* Make items appear in one line */
        flex-wrap: nowrap;
        /* Prevent wrapping */
        overflow-x: auto;
        /* Enable horizontal scrolling */
    }

    #ItemListIssue {
        display: flex;
        /* Make items appear in one line */
        flex-wrap: nowrap;
        /* Prevent wrapping */
        overflow-x: auto;
        /* Enable horizontal scrolling */
    }

    .modal-dialog {
        max-width: 800px;
    }

    .modal-content {
        display: flex;
        flex-direction: column;
    }

    .modal-title {
        color: var(--bs-primary);
        /* For Bootstrap's primary color */
    }

    .table-data {
        flex-grow: 1;
        /* Ensures it does not stretch */
        overflow: hidden;
        /* Prevents unintended extra space */
    }

    #addRow {
        color: white;
        border: none;
        padding: 6px 6px;
        font-size: 8px;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
    }

    #removeRow {
        color: white;
        border: none;
        padding: 6px 6px;
        font-size: 8px;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
    }

    .scroll-container {
        display: flex;
        overflow-x: auto;
        gap: 1rem;
        padding-bottom: 1rem;
    }

    /* Wrapper to position the icon */
    .dropdown-wrapper {
        position: relative;
    }

    /* Positioning the triangle icon */
    .dropdown-wrapper i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2em;
        color: #007bff;
        pointer-events: none;
        /* Prevents interfering with select click */
    }

    /* Make space for the icon in the select box */
    .dropdown-wrapper select {
        padding-right: 30px;
        /* Add space for the icon */
        font-size: 1em;
    }
</style>
<section id="content">
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Utility Assets</h1>
                <ul class="breadcrumb mb-1">
                    <li><a href="#" class="tab-link active" data-tab="assets">Assets</a></li>
                    <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="renter">Rental Transactions</a></li>
                    <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="issue">Issuance Transactions</a></li>
                    <!-- <li>|</li>
                    <li><a href="#" class="tab-link" data-tab="history">Rental History</a></li> -->
                </ul>
            </div>
        </div>

        <!-- Tab Content Sections -->
        <div id="assets" class="tab-content active">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAssetsModal">
                    <i class="fas fa-box"></i> Add Asset
                </button>
            </div>
            <div class="table-data">
                <div class="order">
                    <table id="assets-table" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ASSETS</th>
                                <th>QTY</th>
                                <th>VACANT<br>QTY</th>
                                <th>DAMAGED</th>
                                <th>REGULAR / MEMBER<br>RATE</th>
                                <th>PENALTY<br>RATE</th>
                                <th>DATE PURCHASED</th>
                                <th>STATUS</th>
                                <th style="width:60px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="renter" class="tab-content">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRenterModal">
                    <i class="fas fa-user-tag"></i> Add Renter
                </button>
            </div>
            <div class="table-data">
                <div class="order">
                    <table id="renter-table" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>FULL NAME</th>
                                <th>RENTED</th>
                                <th>QTY</th>
                                <th>AMOUNT</th>
                                <th>DATE RENTED</th>
                                <th>DUE DATE</th>
                                <th>DATE RETURNED</th>
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

        <div id="issue" class="tab-content">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIssueModal">
                    <i class="fas fa-user-tag"></i> Add Issuance
                </button>
            </div>
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

        <!-- add assets modal -->
        <div class="modal fade" id="addAssetsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 800px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-body" id="modal-content">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                        <h5 class="mb-2 text-primary">Asset Details</h5>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="Asset Name">Asset Name</label>
                                            <input type="text" class="form-control" id="assName" placeholder="Enter Asset Name" oninput="capitalizeName(this)">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <label for="Quantity">Quantity</label>
                                            <input type="number" class="form-control" id="qty" placeholder="Enter Quantity" oninput="capitalizeName(this)">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <!-- <div class="form-group">
                                            <label for="Rental Period">Rental Period (day/s)</label>
                                            <input type="text" class="form-control" id="rentPerd" placeholder="Enter Rental Period" oninput="capitalizeName(this)">
                                        </div> -->
                                        <div class="form-group" style="position: relative;">
                                            <label for="Rental Period">Rental Period</label>
                                            <input type="text" class="form-control" id="rentPerd" placeholder="0" style="padding-right: 50px;">
                                            <span style="position: absolute; right: 15px; top: 28px; color: dark; pointer-events: none;">days</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="Non Member Amount">Standard Rate</label>
                                            <input type="number" class="form-control" id="nmemAmt" placeholder="Enter Standard Rate">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="Member Amount">Member Rate</label>
                                            <input type="number" class="form-control" id="memAmt" placeholder="Enter Member Rate">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="Penalty Amount">Penalty Amount</label>
                                            <input type="number" class="form-control" id="penAmt" placeholder="Enter Penalty Amount">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="Damage Amount">Damage Amount</label>
                                            <input type="number" class="form-control" id="damAmt" placeholder="Enter Damage Amount">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="Date Purchased">Date Purchased</label>
                                            <input type="date" class="form-control" id="datePurch" placeholder="Enter Date Purchased" oninput="capitalizeName(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="d-flex justify-content-end mt-3">
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
        <!-- add assets modal -->

        <!-- edit asset modal -->
        <div class="modal fade" id="editAssetsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 800px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-body" id="modal-content">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                        <h5 class="mb-2 text-primary">Update Asset Details</h5>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="Asset Name">Asset Name</label>
                                            <input type="text" class="form-control" id="eassName" placeholder="Enter Asset Name" oninput="capitalizeName(this)">
                                            <input type="hidden" id="ra_id">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <label for="Quantity">Quantity</label>
                                            <input type="number" class="form-control" id="eqty" placeholder="Enter Quantity" oninput="capitalizeName(this)">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <!-- <div class="form-group">
                                            <label for="Rental Period">Rental Period</label>
                                            <input type="text" class="form-control" id="erentPerd" placeholder="Enter Rental Period" oninput="capitalizeName(this)">
                                        </div> -->
                                        <div class="form-group" style="position: relative;">
                                            <label for="Rental Period">Rental Period</label>
                                            <input type="text" class="form-control" id="erentPerd" placeholder="0" style="padding-right: 50px;">
                                            <span style="position: absolute; right: 15px; top: 28px; color: dark; pointer-events: none;">days</span>
                                        </div>

                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="Non Member Amount">Standard Rate</label>
                                            <input type="number" class="form-control" id="enmemAmt" placeholder="Enter Standard Rate">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="Member Amount">Member Rate</label>
                                            <input type="number" class="form-control" id="ememAmt" placeholder="Enter Member Rate">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="Penalty Amount">Penalty Amount</label>
                                            <input type="number" class="form-control" id="epenAmt" placeholder="Enter Penalty Amount">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="Damage Amount">Damage Amount</label>
                                            <input type="number" class="form-control" id="edamAmt" placeholder="Enter Damage Amount">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="Date Purchased">Date Purchased</label>
                                            <input type="date" class="form-control" id="edatePurch" placeholder="Enter Date Purchased" oninput="capitalizeName(this)">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <!-- <div class="form-group">
                                        <label for="estatus">Status</label>
                                        <select class="form-control" id="estatus" name="estatus">
                                            <option value="1">Serviceable</option>
                                            <option value="0">Unserviceable</option>
                                        </select>
                                    </div> -->
                                        <div class="form-group">
                                            <label for="estatus">Status</label>
                                            <div class="dropdown-wrapper">
                                                <i class="fa fa-caret-down"></i>
                                                <select class="form-control" id="estatus" name="estatus">
                                                    <option value="1">Serviceable</option>
                                                    <option value="0">Unserviceable</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" id="update" name="submit" class="btn btn-primary ">Update</button>
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
        <!-- edit asset modal -->

        <!-- rent modal -->
        <div class="modal fade" id="addRenterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog"> -->
            <div class="modal-dialog" style="max-width: 800px; overflow:hidden;">
                <div class="table-data">
                    <div class="modal-content">
                        <div class="modal-body" id="modal-content">
                            <h5 class="modal-title mb-3" id="uploadModalLabel">Choose Item</h5>
                            <div class="row" id="ItemList"></div>
                            <div class="form-group mb-3 mt-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="memberCheck">
                                    <label class="form-check-label" for="memberCheck" style="color: var(--bs-primary);">Membership Discount (Check if Member)</label>
                                </div>

                                <label for="Full Name">Full Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Full Name" autocomplete="off" oninput="capitalizeName(this)" required>
                                <input type="hidden" id="hdId"> <!-- Store selected user ID -->

                                <div id="rentDropdown" class="dropdown-menu" style="height: 200px; width:94%; overflow-y: auto; display: none;">
                                    <div id="dropdownRent"></div>
                                </div>
                            </div>

                            <div id="rentalForms">
                                <div class="form-group mb-3 rental-form">
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-primary add-rental" id="addRow"><i class="fas fa-plus"></i></button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="rentedItem">Rented Item</label>
                                            <input type="text" class="form-control rentedItem" placeholder="Rented Item" readonly>
                                            <input type="hidden" class="rentedItemId">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control quantity" placeholder="Quantity">
                                        </div>

                                        <div class="col-md-3">
                                            <label for="amount">Amount</label>
                                            <input type="number" class="form-control amount" placeholder="Amount" readonly>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="totalAmount">Total Amount</label>
                                            <input type="number" class="form-control totalAmount" placeholder="Total Amount" readonly>
                                            <input type="hidden" class="rentPeriod">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <!-- Rented Item (Readonly) -->
                                    <div class="col-md-4">
                                        <label for="rentDate">Rental Date</label>
                                        <input type="date" class="form-control" id="rentDate" placeholder="Select Rental Date">
                                        <!-- <input type="hidden" class="rentDateId"> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="saveRental" name="submit" class="btn btn-primary">Add</button>
                                    <button type="button" id="closeRental" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- rent modal -->

        <!-- issuance modal -->
        <div class="modal fade" id="addIssueModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <!-- <div class="modal-dialog"> -->
            <div class="modal-dialog" style="max-width: 800px; overflow:hidden;">
                <div class="table-data">
                    <div class="modal-content">
                        <div class="modal-body" id="modal-content">
                            <!-- <div class="modal-header"> -->
                            <h5 class="modal-title mb-3" id="uploadModalLabel">Choose Item</h5>
                            <!-- </div> -->
                            <div class="row" id="ItemListIssue"></div>

                            <div class="form-group mb-3 mt-3 position-relative">
                                <label for="Full Name">Full Name</label>
                                <input type="text" class="form-control" id="iName" placeholder="Select Member" autocomplete="off">
                                <input type="hidden" id="hdId"> <!-- Hidden input for hd_id -->

                                <!-- Dropdown Menu -->
                                <div id="nameDropdown" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto; display: none;">
                                    <div id="dropdownList"></div>
                                </div>
                            </div>

                            <div id="issuedForms">
                                <div class="form-group mb-3 issued-form">
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-primary add-issued" id="addRow"><i class="fas fa-plus"></i></button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="issuedItem">Issued Item</label>
                                            <input type="text" class="form-control issuedItem" placeholder="Rented Item" readonly>
                                            <input type="hidden" class="issuedItemId">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="issuedQuantity">Quantity</label>
                                            <input type="number" class="form-control issuedQuantity" placeholder="Quantity">
                                            <input type="hidden" class="issuedPeriod">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <!-- Rented Item (Readonly) -->
                                    <div class="col-md-4">
                                        <label for="issuedDate">Issue Date</label>
                                        <input type="date" class="form-control" id="issuedDate" placeholder="Select Issue Date">

                                        <!-- <input type="hidden" class="rentDateId"> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="saveIssued" name="submit" class="btn btn-primary">Add</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- issuance modal -->

        <!-- pay modal -->
        <div class="modal fade" id="payMoneyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 800px; overflow:hidden;">
                <div class="table-data">
                    <div class="order">
                        <!-- <div class="modal-content"> -->
                        <div class="modal-content" style="border:none; background: var(--light);">
                            <div class="modal-header" style="display: flex; width: 100%;">
                                <div>
                                    <div id="header_name" style="font-family: Arial; font-size: 16px; padding-bottom: 10px;"></div>
                                    <div id="item" style="font-family: Arial; font-size: 16px; padding-bottom: 10px;"></div>
                                    <div id="amountToPay" style="font-family: Arial; font-size: 16px;"></div>
                                </div>
                                <div>
                                    <div id="rentPeriod" style="font-family: Arial; font-size: 16px; padding-bottom: 10px; text-align: left;"></div>
                                    <div id="penaltyAmount" style="font-family: Arial; font-size: 16px; text-align: left; padding-bottom: 10px;"></div>
                                    <!-- <div id="computation" style="font-family: Arial; font-size: 16px;  text-align: left;"></div> -->
                                </div>
                            </div>
                            <div class="modal-body">
                                <form id="payMoneyForm">
                                    <input type="hidden" id="r_id" name="r_id">
                                    <input type="hidden" id="ra_id" name="ra_id">
                                    <div class="form-group mb-3">
                                        <div class="row">
                                            <!-- <p class="modal-title mb-3" id="item" style="font-size:18px;"></p> -->
                                            <div class="col-md-6">
                                                <label for="dueDate">Due Date</label>
                                                <input type="text" class="form-control" id="dueDate" name="dueDate" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="dateRet">Date Returned</label>
                                                <input type="date" class="form-control" id="dateRet" name="dateRet">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="amount">Amount</label>
                                                <input type="number" class="form-control" id="amount" placeholder="Amount" readonly>
                                                <!-- <input type="hidden" id="rentQty" name="rentQty"> -->
                                            </div>

                                            <div class="col-md-3" style="display: none;">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" placeholder="Quantity" readonly>
                                            </div>


                                            <div class="col-md-3">
                                                <label for="penalty">Penalty</label>
                                                <input type="number" class="form-control" id="penalty" placeholder="Penalty" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="totalAmount">Total Amount</label>
                                                <input type="number" class="form-control" id="totalAmount" placeholder="Total Amount" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <!-- <div class="col-md-3" style="display: flex; flex-direction: column; height: 100%;"> -->

                                            <div class="form-check" style="margin-left: 10px;">
                                                <input type="checkbox" class="form-check-input" id="confirmCheckbox">
                                                <label class="form-check-label" for="confirmCheckbox" style="color: var(--bs-primary);">Damaged Item (Click Here!)</label>
                                            </div>

                                            <!-- <label for="confirmCheckbox">Damaged</label>
                                                <div style="margin-top: 8px;">
                                                    <input type="checkbox" id="confirmCheckbox"
                                                        style="width: 25px; height: 25px; border: 1px solid #333; border-radius: 10px; cursor: pointer;">
                                                </div> -->
                                            <!-- </div> -->

                                            <div class="col-md-3" id="quantityContainer" style="display: none;">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" class="form-control" id="damageQuantity" placeholder="Quantity">
                                            </div>

                                            <div class="col-md-3" id="amountContainer" style="display: none;">
                                                <label for="amount">Amount</label>
                                                <input type="number" class="form-control" id="damageAmount" placeholder="Amount">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary">Pay</button>
                                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- pay modal -->

    </main>
</section>

<script>
    $(document).ready(function() {
        $('#addRenterModal, #addIssueModal, #addAssetsModal').on('show.bs.modal', function() {
            let modal = $(this);
            modal.find('input').val('');
            modal.find('.rental-form:not(:first)').remove();
        });

        $('#payMoneyModal, #addRenterModal').on('hidden.bs.modal', function() {
            $('#confirmCheckbox').prop('checked', false);
            $('#memberCheck').prop('checked', false);
            $('#quantityContainer, #amountContainer').hide();
            $('#damageQuantity, #damageAmount').val('');
        });

        // Show/hide quantity and amount fields based on checkbox state
        $('#confirmCheckbox').change(function() {
            if ($(this).is(':checked')) {
                $('#quantityContainer, #amountContainer').show();
            } else {
                $('#quantityContainer, #amountContainer').hide();
                // $('#damageQuantity, #damageAmount').val('');
            }
        });
    });


    var table_data = $("#assets-table").DataTable({
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
            url: '<?php echo site_url('Rental_ctrl/getAssets'); ?>',
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
        columns: [
            // {
            //     data: 'id',
            //     render: function(data, type, row) {
            //         const idNo = String(row.id).padStart(4, '0');
            //         return idNo;
            //     }
            // },
            {
                data: 'ra_desc'
            },
            {
                data: 'ra_qty'
            },
            {
                data: 'ra_vacant_qty'
            },
            {
                data: 'ra_damage_qty'
            },
            {
                data: 'ra_amount',
                render: function(data, type, row) {
                    let amount = parseFloat(data).toFixed(2); // Format ra_amount
                    let memberAmount = row.ra_amount_member ? parseFloat(row.ra_amount_member).toFixed(2) : "0.00"; // Format ra_amount_member

                    return `₱ ${amount} / ₱ ${memberAmount}`;
                }
            },
            {
                data: 'ra_penalty_amount',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
            {
                data: 'ra_date_purch',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            {
                data: 'ra_status',
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge bg-success">Serviceable</span>';
                    } else {
                        return '<span class="badge bg-danger">Unserviceable</span>';
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
                                        onclick="editAsset('${data}')">
                                    <i class="fas fa-edit edit-icon" style="font-size: 12px;"></i> Edit
                                </button>
                            ` : ''}
                        </div>
                    `;
                }
                
            }
        ]
    });

    var table_data = $("#renter-table").DataTable({
        "language": {
            "infoFiltered": " ", // To remove the Filtered From
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
            url: '<?php echo site_url('Rental_ctrl/getRenter'); ?>',
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
                data: 'r_amount',
                render: function(data, type, row) {
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
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

            // {
            //     data: 'r_rent_penalty',
            //     render: function(data, type, row) {
            //         if (parseFloat(data) === 0) {
            //             return ''; // or return 'None'; if you want to display "None"
            //         }
            //         return `₱ ${parseFloat(data).toFixed(2)}`;
            //     }
            // },
            // {
            //     data: 'r_total_amount',
            //     render: function(data, type, row) {
            //         if (parseFloat(data) === 0) {
            //             return ''; // or return 'None'; if you want to display "None"
            //         }
            //         return `₱ ${parseFloat(data).toFixed(2)}`;
            //     }
            // },
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
            {
                data: 'r_id',
                render: function(data, type, row) {
                    return `<div style="display: flex; justify-content: center; align-items: center; margin-right:4px;">
                                ${row.r_status != 1 ? `
                                    <i class="fas fa-eye text-primary" style="cursor: pointer; font-size: 14px;" 
                                        onclick="payMoney('${row.r_id}', '${row.ra_id}')"></i>
                                ` : ''}
                            </div>`;
                }
            }
        ]
    });

    var table_data = $("#issue-table").DataTable({
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
            url: '<?php echo site_url('Rental_ctrl/getIssuance'); ?>',
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

    var table_data = $("#history-table").DataTable({
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
                    return `₱ ${parseFloat(data).toFixed(2)}`;
                }
            },
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
            // {
            //     data: 'r_id',
            //     render: function(data, type, row) {
            //         return `<div style="display: flex; justify-content: center; align-items: center; margin-right:4px;">
            //                     ${row.r_status != 1 ? `
            //                         <i class="fas fa-eye text-primary" style="cursor: pointer; font-size: 14px;" 
            //                             onclick="payMoney('${row.r_id}', '${row.ra_id}')"></i>
            //                     ` : ''}
            //                 </div>`;
            //     }
            // }
        ]
    });

    $('#add').click(function() {
        var assName = $('#assName').val().trim();

        var date = new Date().toISOString().split('T')[0]; // "2025-03-24"

        // Validation
        if (assName === '') {
            Swal.fire('Warning', 'Asset Name is required', 'info');
            return; // Stop execution if validation fails
        }

        Swal.fire({
            title: "Confirmation",
            text: "Do you want to add this asset?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add asset!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    asset: $('#assName').val(),
                    qty: $('#qty').val(),
                    rentPeriod: $('#rentPerd').val(),
                    nonMemAmt: $('#nmemAmt').val(),
                    memAmt: $('#memAmt').val(),
                    penAmt: $('#penAmt').val(),
                    damAmt: $('#damAmt').val(),
                    datePurch: $('#datePurch').val(),
                };

                $.ajax({
                    url: '<?php echo base_url("Rental_ctrl/addAsset"); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', 'Asset added successfully', 'success');

                            $('#addAssetsModal').modal('hide'); // Close the modal
                            // $('#addModal input').val('');
                            $('#assets-table').DataTable().ajax.reload(); // Refresh DataTable
                        } else {
                            Swal.fire('Error', 'Failed to add asset', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to add asset', 'error');
                        console.error("Error:", xhr.responseText);
                    }
                });
            }
        });
    });


    function editAsset(id) {

        console.log("Opening modal for ID:", id);

        // $('#hd_id').val(id); // Store ID in hidden input
        $('#editAssetsModal').modal('show');

        $.ajax({
            url: '<?php echo base_url('Rental_ctrl/assetDetails'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                // console.log("Full Response:", response);
                var data = response.data[0];

                $('#ra_id').val(data.id);
                $('#eassName').val(data.ra_desc);
                $('#eqty').val(data.ra_qty);
                $('#erentPerd').val(data.ra_rent_period);
                $('#enmemAmt').val(data.ra_amount);
                $('#ememAmt').val(data.ra_amount_member);
                $('#edamAmt').val(data.ra_damage_amount);
                $('#epenAmt').val(data.ra_penalty_amount);
                $('#edatePurch').val(data.ra_date_purch);
                $('#estatus').val(data.ra_status);
            },

            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr.responseText);
                Swal.fire('Error', 'Failed to load data: ' + error, 'error');
            }
        });
    }


    $('#update').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update this asset?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = {
                    id: $('#ra_id').val(),
                    eassName: $('#eassName').val(),
                    eqty: $('#eqty').val(),
                    erentPerd: $('#erentPerd').val(),
                    enmemAmt: $('#enmemAmt').val(),
                    ememAmt: $('#ememAmt').val(),
                    edamAmt: $('#edamAmt').val(),
                    epenAmt: $('#epenAmt').val(),
                    edatePurch: $('#edatePurch').val(),
                    estatus: $('#estatus').val(),
                };

                $.ajax({
                    url: '<?php echo base_url("Rental_ctrl/updateAsset"); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Updated!', 'Asset updated successfully.', 'success');
                            $('#editAssetsModal').modal('hide');
                            $('#assets-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error', 'Failed to update asset.', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to update asset.', 'error');
                        console.error("Error:", xhr.responseText);
                    }
                });
            }
        });
    });


    $(document).on('click', '.select-item', function() {
        let itemDesc = $(this).data('desc');
        let itemId = $(this).data('id');
        let amount = parseFloat($(this).data('amount')) || 0;
        let memAmount = parseFloat($(this).data('member')) || 0;
        let rentPeriod = $(this).data('rent');

        let lastRow = $('.rental-form').last(); // Always update the last row

        lastRow.find('.rentedItem').val(itemDesc);
        lastRow.find('.rentedItemId').val(itemId);
        lastRow.find('.rentPeriod').val(rentPeriod);

        let isMemberChecked = $("#memberCheck").is(":checked");
        lastRow.find('.amount').val(isMemberChecked ? memAmount : amount);
        updateTotalAmount(lastRow);

        // Mark the selected item as active for reference in the change event
        $(".select-item").removeClass("active");
        $(this).addClass("active");
    });

    $("#memberCheck").change(function() {
        let isChecked = $(this).is(":checked");
        let lastRow = $('.rental-form').last();

        // Find the currently selected item
        let selectedItem = $(".select-item.active");
        if (selectedItem.length === 0) return; // Exit if no item is selected

        // Get amount based on member check status
        let newAmount = isChecked ? parseFloat(selectedItem.data('member')) || 0 :
            parseFloat(selectedItem.data('amount')) || 0;

        // Apply the new amount
        lastRow.find('.amount').val(newAmount);
        updateTotalAmount(lastRow);

        // Toggle class for visual indication (optional)
        selectedItem.toggleClass('member-active', isChecked);
    });

    // Add new rental row when clicking plus button
    $(document).on('click', '.add-rental', function() {
        let rentalForm = `
        <div class="form-group mb-3 rental-form">
        <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-rental" id="removeRow"><i class="fas fa-minus"></i></button>
                </div>
            <div class="row">
                
                
                <div class="col-md-4">
                    <label for="rentedItem">Rented Item</label>
                    <input type="text" class="form-control rentedItem" placeholder="Rented item" readonly>
                    <input type="hidden" class="rentedItemId">
                </div>

                <div class="col-md-2">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control quantity" placeholder="Quantity">
                </div>

                <div class="col-md-3">
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control amount" placeholder="Amount" readonly>
                </div>

                <div class="col-md-3">
                    <label for="totalAmount">Total Amount</label>
                    <input type="number" class="form-control totalAmount" placeholder="Total Amount" readonly>
                     <input type="hidden" class="rentPeriod">
                </div>
            </div>
        </div>
    `;
        $('#rentalForms').append(rentalForm);
    });

    // Remove rental row
    $(document).on('click', '.remove-rental', function() {
        $(this).closest('.rental-form').remove();
    });

    // Auto-update total amount when quantity changes
    $(document).on('input', '.quantity', function() {
        let row = $(this).closest('.rental-form');
        updateTotalAmount(row);
    });

    function updateTotalAmount(row) {
        let quantity = parseInt(row.find('.quantity').val()) || 0;
        let amount = parseFloat(row.find('.amount').val()) || 0;
        let totalAmount = quantity * amount;

        row.find('.totalAmount').val(totalAmount);
    }

    // Ensure the first row is always selectable
    $(document).ready(function() {
        if ($('.rental-form').length === 0) {
            $('#rentalForms').append(rentalForm); // Add one default row
        }
    });

    $(document).on('click', '#saveRental', function() {
        let renterName = $('#name').val().trim();
        let rentDate = $('#rentDate').val().trim();
        let rentals = [];

        $('.rental-form').each(function() {
            let rentedItemId = $(this).find('.rentedItemId').val();
            let rentedItem = $(this).find('.rentedItem').val();
            let quantity = $(this).find('.quantity').val();
            let amount = $(this).find('.amount').val();
            let totalAmount = $(this).find('.totalAmount').val();
            let rentPeriod = $(this).find('.rentPeriod').val();

            if (rentedItemId && quantity > 0) {
                rentals.push({
                    rentedItemId: rentedItemId,
                    rentedItem: rentedItem,
                    quantity: quantity,
                    amount: amount,
                    totalAmount: totalAmount,
                    rentPeriod: rentPeriod
                });
            }
        });

        if (renterName.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Renter',
                text: 'Please add renter before proceeding.',
            });
            return;
        }

        if (rentals.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Details',
                text: 'Please complete rent details before proceeding.',
            });
            return;
        }

        if (rentDate.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Rental Date',
                text: 'Please add rental date before proceeding.',
            });
            return;
        }

        console.log(rentals);
        $.ajax({
            url: '<?php echo site_url('Rental_ctrl/save_rental'); ?>',
            type: 'POST',
            data: {
                name: renterName,
                date: rentDate,
                rentals: rentals
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Rent added successfully', 'success');

                    $('#addRenterModal').modal('hide'); // Close the modal
                    $('#renter-table').DataTable().ajax.reload(); // Refresh DataTable
                    $('#assets-table').DataTable().ajax.reload(); // Refresh DataTable
                    $('#history-table').DataTable().ajax.reload(); // Refresh DataTable

                    // Reset form fields after submission
                    $("#name").val("");
                    $("#rentDate").val("");
                    $(".rentedItem").val("");
                    $(".rentedItemId").val("");
                    $(".quantity").val("");
                    $(".amount").val("");
                    $(".totalAmount").val("");
                    $(".rentPeriod").val("");

                    // Remove dynamically added rental rows (except the first one)
                    $("#rentalForms .rental-form:not(:first)").remove();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                alert("Error while saving rentals.");
            }
        });
    });

    $(document).on('click', '.select-item', function() {
        let itemDesc = $(this).data('desc'); // Get item description
        let itemId = $(this).data('id'); // Get item ID
        // let amount = parseFloat($(this).data('amount')); // Get item amount
        let issuedPeriod = $(this).data('rent'); // Get rental period
        // console.log(rentPeriod);

        let lastRow = $('.issued-form').last(); // Always update the last row

        lastRow.find('.issuedItem').val(itemDesc);
        lastRow.find('.issuedItemId').val(itemId);
        // lastRow.find('.amount').val(amount);
        // lastRow.find('.totalAmount').val();
        lastRow.find('.issuedPeriod').val(issuedPeriod);
        // updateTotalAmount(lastRow);
    });

    // Add new rental row when clicking plus button
    $(document).on('click', '.add-issued', function() {
        let issuedForm = `
        <div class="form-group mb-3 issued-form">
        <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-issued" id="removeRow"><i class="fas fa-minus"></i></button>
                </div>
            <div class="row">
                               
                <div class="col-md-6">
                    <label for="rentedItem">Rented Item</label>
                    <input type="text" class="form-control issuedItem" placeholder="Rented item" readonly>
                    <input type="hidden" class="issuedItemId">
                </div>

                <div class="col-md-6">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control issuedQuantity" placeholder="Quantity">
                      <input type="hidden" class="issuedPeriod">
                </div>

            </div>
        </div>
    `;
        $('#issuedForms').append(issuedForm);
    });

    // Remove rental row
    $(document).on('click', '.remove-issued', function() {
        $(this).closest('.issued-form').remove();
    });

    // Ensure the first row is always selectable
    $(document).ready(function() {
        if ($('.issued-form').length === 0) {
            $('#issuedForms').append(issuedForm); // Add one default row
        }
    });

    $(document).on('click', '#saveIssued', function() {
        let Name = $('#iName').val().trim();
        let Id = $('#hdId').val().trim();
        let Date = $('#issuedDate').val().trim();
        let issuance = [];

        $('.issued-form').each(function() {
            let issuanceItemId = $(this).find('.issuedItemId').val();
            let issuanceItem = $(this).find('.issuedItem').val();
            let issuanceQuantity = $(this).find('.issuedQuantity').val();
            let issuancePeriod = $(this).find('.issuedPeriod').val();

            if (issuanceItemId && issuanceQuantity > 0) {
                issuance.push({
                    ItemId: issuanceItemId,
                    Item: issuanceItem,
                    Quantity: issuanceQuantity,
                    Period: issuancePeriod
                });
            }
        });


        console.log(Name);
        console.log(Id);
        console.log(Date);
        console.log(issuance);

        if (Name.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Renter',
                text: 'Please select user before proceeding.',
            });
            return;
        }

        if (issuance.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Details',
                text: 'Please complete issue details before proceeding.',
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
            url: '<?php echo site_url('Rental_ctrl/save_issuance'); ?>',
            type: 'POST',
            data: {
                id: Id,
                name: Name,
                date: Date,
                issuance: issuance
            },
            dataType: 'json',

            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', 'Rent added successfully', 'success');

                    $('#addIssueModal').modal('hide'); // Close the modal
                    $('#issue-table').DataTable().ajax.reload(); // Refresh DataTable
                    $('#assets-table').DataTable().ajax.reload(); // Refresh DataTable
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                alert("Error while saving rentals.");
            }
        });
    });

    $(document).ready(function() {
        function fetchItems(targetElement) {
            $.ajax({
                url: '<?php echo site_url('Rental_ctrl/get_rental_items'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let itemList = $(targetElement);
                    itemList.empty(); // Clear previous content

                    if (response.length > 0) {
                        response.forEach(item => {
                            let card = `
                        <div class="col-md-4 mb-3">
                            <div class="card select-item" 
                                data-id="${item.id}" 
                                data-desc="${item.ra_desc}"
                                data-rent="${item.ra_rent_period}"
                                data-amount="${item.ra_amount}"
                                data-member="${item.ra_amount_member}">
                        
                                <div class="card-body">
                                    <h5 class="card-title">${item.ra_desc}</h5>
                                    <p class="card-text">Rent Period: ${item.ra_rent_period} ${item.ra_rent_period == 1 ? 'day' : 'days'}</p>
                                    <p class="card-text">Penalty (pcs): ₱ ${parseFloat(item.ra_penalty_amount).toFixed(2)}</p>
                                    <p class="card-text">Available: ${item.ra_vacant_qty}</p>
                                    <p class="card-text">Amount: ₱ ${parseFloat(item.ra_amount).toFixed(2)}</p>
                                    <p class="card-text">Member Amt: ₱ ${parseFloat(item.ra_amount_member).toFixed(2)}</p>
                                </div>
                            </div>
                        </div>
                        `;
                            itemList.append(card);
                        });
                    } else {
                        itemList.append('<p class="text-center">No items available.</p>');
                    }
                },
                error: function() {
                    $(targetElement).html('<p class="text-danger text-center">Failed to load items.</p>');
                }
            });
        }

        $('#addRenterModal').on('show.bs.modal', function() {
            fetchItems('#ItemList');
        });

        $('#addIssueModal').on('show.bs.modal', function() {
            fetchItems('#ItemListIssue');
        });
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

    function payMoney(r_id, ra_id) {
        $('#r_id').val(r_id);
        $('#ra_id').val(ra_id);

        $.ajax({
            url: "<?php echo base_url('Rental_ctrl/getTotalAmount'); ?>",
            type: "POST",
            data: {
                id: r_id,
                ra_id: ra_id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {

                    let name = response.name;
                    let item = response.item;
                    let rentPeriod = response.rent_period;
                    let penaltyAmt = response.penalty_amount;
                    let amountToPay = parseFloat(response.total_amount / response.rent_qty);

                    let dueDate = new Date(response.due_date);
                    let rentQty = parseFloat(response.rent_qty);
                    let currentAmount = parseFloat(response.total_amount);
                    let penaltyPerDay = parseFloat(response.penalty_amount);
                    let damageAmt = parseFloat(response.damageAmt);
                    let totalPenalty = 0; // Initialize totalPenalty
                    let formattedDueDate = dueDate.toLocaleDateString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric'
                    });

                    // Set default values
                    $('#header_name').html("Rented By - <strong>" + name + "</strong>");
                    // $('#item').html("Rented Item - <strong>" + item + "</strong>");
                    $('#item').html("Rented Item - <strong>" + item + "</strong> (" + rentQty + " " + (rentQty === 1 ? "pc" : "pcs") + ")");
                    $('#itemAmount').html("Rented Item - <strong>" + item + "</strong>");
                    $('#rentPeriod').html("Rent Period - <strong>" + rentPeriod + "</strong> " + (rentPeriod == 1 ? "day" : "days"));
                    $('#penaltyAmount').html("Penalty - <strong>₱ " + parseFloat(penaltyAmt).toFixed(2) + "</strong>");
                    $('#amountToPay').html("Amount - <strong>₱ " + parseFloat(amountToPay).toFixed(2) + "</strong>");
                    $('#computation').html("Computation - <strong>(Penalty * Rent Period)" + "</strong>");
                    $('#dueDate').val(formattedDueDate);
                    $('#amount').val(currentAmount.toFixed(2));
                    $('#quantity').val(rentQty);
                    $('#penalty').val(0);
                    $('#totalAmount').val(currentAmount.toFixed(2));
                    $('#damageAmount').val(damageAmt.toFixed(2));
                    $('#damageQuantity').val(0).prop('disabled', true); // Disable damage quantity by default

                    $('#payMoneyModal').modal('show'); // Show modal

                    // When date is changed, check for penalty
                    $('#dateRet').on('change', function() {
                        let returnDate = new Date($(this).val());

                        if (returnDate > dueDate) {
                            let daysOverdue = Math.floor((returnDate - dueDate) / (1000 * 60 * 60 * 24)); // Calculate overdue days
                            totalPenalty = penaltyPerDay * daysOverdue * rentQty; // Update totalPenalty

                            $('#penalty').val(totalPenalty.toFixed(2));
                        } else {
                            totalPenalty = 0;
                            $('#penalty').val(0);
                        }

                        updateTotalAmount(); // Update total amount
                    });

                    $('#damageQuantity').on('change', function() {
                        // let damQty = parseFloat($(this).val()) || 0;

                        // if (damQty > rentQty) {
                        //     Swal.fire({
                        //         icon: 'warning',
                        //         title: 'Invalid Quantity',
                        //         text: 'Damage quantity cannot exceed rented quantity!',
                        //         confirmButtonColor: '#d33'
                        //     });
                        //     $(this).val(rentQty); // Reset to max allowable quantity
                        // }

                        updateTotalAmount();
                    });

                    $('#damageAmount').on('change', function() {
                        // let damAmt = parseFloat($(this).val()) || 0;

                        // if (damAmt > damageAmt) {
                        //     Swal.fire({
                        //         icon: 'warning',
                        //         title: 'Invalid Amount',
                        //         text: 'Amount cannot exceed damage amount!',
                        //         confirmButtonColor: '#d33'
                        //     });
                        //     $(this).val(damageAmt); // Reset to max allowable quantity
                        // }

                        updateTotalAmount();
                    });

                    $('#confirmCheckbox').on('change', function() {
                        if ($(this).is(':checked')) {
                            $('#damageQuantity').prop('disabled', false); // Enable input
                        } else {
                            $('#damageQuantity').prop('disabled', true).val(0); // Disable and reset input
                        }
                        updateTotalAmount();
                    });

                    function updateTotalAmount() {
                        let damQty = parseFloat($('#damageQuantity').val()) || 0;
                        let damageAmt = parseFloat($('#damageAmount').val()) || 0;
                        let totalDamageAmt = ($('#confirmCheckbox').is(':checked')) ? damQty * damageAmt : 0;

                        let finalAmount = currentAmount + totalPenalty + totalDamageAmt;

                        $('#totalAmount').val(finalAmount.toFixed(2));
                    }
                } else {
                    Swal.fire('Error', 'Failed to fetch amount.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        });
    }

    $('#payMoneyForm').submit(function(e) {
        e.preventDefault();

        let ra_id = $('#ra_id').val();
        let r_id = $('#r_id').val();
        let date = $('#dateRet').val();
        let quantity = $('#quantity').val();
        let penalty = $('#penalty').val();
        let damageQty = $('#damageQuantity').val();
        let damageAmt = $('#damageAmount').val();
        let totalAmount = $('#totalAmount').val();
        let amount = $('#amount').val();
        // let amount = $('#amount').val();

        console.log(quantity);
        console.log(damageQty);
        // console.log(damageQty);

        if (date.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Date Returned',
                text: 'Please add returned date before proceeding.',
            });
            return;
        }

        // console.log(r_id);
        // console.log(date);

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
                    url: "<?php echo base_url('Rental_ctrl/updateRenterStatus'); ?>",
                    type: "POST",
                    data: {
                        id: r_id,
                        ra_id: ra_id,
                        date: date,
                        penalty: penalty,
                        total_amount: totalAmount,
                        amount: amount,
                        quantity: quantity,
                        damageAmt: damageAmt,
                        damageQty: damageQty
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', 'Payment successful!', 'success');

                            // Uncheck checkbox immediately
                            $('#confirmCheckbox').prop('checked', false);

                            // Hide conditional fields
                            $('#quantityContainer, #amountContainer').hide();

                            // Reset damage input fields
                            $('#damageQuantity, #damageAmount').val('');

                            // Reset all input fields when modal is closed
                            $('#payMoneyModal').on('hidden.bs.modal', function() {
                                $(this).find('form')[0].reset();
                            });

                            $('#payMoneyModal').modal('hide');

                            // Reload tables
                            $('#renter-table').DataTable().ajax.reload();
                            $('#assets-table').DataTable().ajax.reload();
                            $('#history-table').DataTable().ajax.reload();
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

    $(document).ready(function() {
        let allUsers = []; // Store fetched names for searching

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
                    allUsers = response; // Store data for searching
                    displayNames(allUsers);
                },
                error: function() {
                    console.error("Failed to fetch names.");
                }
            });
        }

        function displayNames(users) {
            let dropdownList = $("#dropdownList");
            dropdownList.empty(); // Clear previous entries

            if (users.length > 0) {
                users.forEach(user => {
                    let item = `<a href="#" class="dropdown-item name-option" data-id="${user.hd_id}">${user.full_name}</a>`;
                    dropdownList.append(item);
                });

                $("#nameDropdown").show(); // Show dropdown
            } else {
                $("#nameDropdown").hide(); // Hide if no results
            }
        }

        function filterNames(searchText) {
            let filteredUsers = allUsers.filter(user => user.full_name.toLowerCase().includes(searchText));
            displayNames(filteredUsers);
        }

        // Handle name selection and store hd_id
        $(document).on("click", ".name-option", function(e) {
            e.preventDefault();
            $("#iName").val($(this).text()); // Set full name in input
            $("#hdId").val($(this).data("id")); // Store hd_id in hidden input
            $("#nameDropdown").hide(); // Hide dropdown
        });

        // Hide dropdown if clicked outside
        $(document).click(function(e) {
            if (!$(e.target).closest("#iName, #nameDropdown").length) {
                $("#nameDropdown").hide();
            }
        });
    });



    $(document).ready(function() {
        let allUsers = []; // Store fetched names

        // Toggle dropdown functionality based on checkbox state
        $("#memberCheck").change(function() {
            $("#name").val(""); // Clear input when toggling
            $("#hdId").val(""); // Clear stored user ID
            if ($(this).is(":checked")) {
                // $("#name").attr("readonly", true); // Disable manual entry
            } else {
                $("#name").attr("readonly", false); // Enable manual entry
                $("#rentDropdown").hide(); // Hide dropdown
            }
        });

        $("#name").on("focus", function() {
            if ($("#memberCheck").is(":checked")) {
                fetchNames();
            }
        }).on("input", function() {
            if ($("#memberCheck").is(":checked")) {
                let searchText = $(this).val().toLowerCase();
                filterNames(searchText);
            }
        });

        function fetchNames() {
            $.ajax({
                url: "<?php echo site_url('Rental_ctrl/get_all_users'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    allUsers = response; // Store names
                    displayNames(allUsers);
                },
                error: function() {
                    console.error("Failed to fetch names.");
                }
            });
        }

        function displayNames(users) {
            let dropdownList = $("#dropdownRent");
            dropdownList.empty();

            if (users.length > 0) {
                users.forEach(user => {
                    let item = `<a href="#" class="dropdown-item name-option" data-id="${user.hd_id}">${user.full_name}</a>`;
                    dropdownList.append(item);
                });

                $("#rentDropdown").show();
            } else {
                $("#rentDropdown").hide();
            }
        }

        function filterNames(searchText) {
            let filteredUsers = allUsers.filter(user => user.full_name.toLowerCase().includes(searchText));
            displayNames(filteredUsers);
        }

        $(document).on("click", ".name-option", function(e) {
            e.preventDefault();
            $("#name").val($(this).text()); // Set name
            $("#hdId").val($(this).data("id")); // Store hd_id
            $("#rentDropdown").hide();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest("#name, #rentDropdown").length) {
                $("#rentDropdown").hide();
            }
        });
    });

    // Store references to multiple containers
    const containers = [document.getElementById('ItemList'), document.getElementById('ItemListIssue')];

    // Function to enable smooth scroll on each container
    function enableSmoothScroll(container) {
        let scrollTarget = container.scrollLeft;
        let isScrolling = false;
        let isUserDragging = false;

        // Detect mouse down for dragging
        container.addEventListener('mousedown', () => isUserDragging = true);
        document.addEventListener('mouseup', () => isUserDragging = false);

        // Wheel event for smooth scroll
        container.addEventListener('wheel', (e) => {
            if (isUserDragging) return; // Don't interfere with dragging
            e.preventDefault();

            const maxScroll = container.scrollWidth - container.clientWidth;
            scrollTarget += e.deltaY;

            // Clamp the scroll target within bounds
            scrollTarget = Math.max(0, Math.min(scrollTarget, maxScroll));

            if (!isScrolling) {
                isScrolling = true;
                smoothScroll();
            }
        }, {
            passive: false
        });

        // Smooth scrolling animation
        function smoothScroll() {
            const step = () => {
                if (isUserDragging) {
                    isScrolling = false;
                    return;
                }

                const current = container.scrollLeft;
                const distance = scrollTarget - current;
                const move = distance * 0.15; // Adjust smoothness by modifying 0.15

                if (Math.abs(move) > 0.5) {
                    container.scrollLeft += move;
                    requestAnimationFrame(step);
                } else {
                    container.scrollLeft = scrollTarget;
                    isScrolling = false;
                }
            };

            step();
        }
    }

    // Apply smooth scroll to all containers
    containers.forEach(container => {
        if (container) enableSmoothScroll(container);
    });

    const select = document.getElementById('estatus');
    const icon = document.querySelector('.dropdown-wrapper i');
    let isOpen = false;


    // On mousedown (before select opens), toggle the icon
    select.addEventListener('mousedown', () => {
        isOpen = !isOpen;
        updateIcon();
    });

    // On blur (select closed without change), reset icon
    select.addEventListener('blur', () => {
        isOpen = false;
        updateIcon();
    });

    // On change (value selected), reset icon
    select.addEventListener('change', () => {
        isOpen = false;
        updateIcon();
    });

    function updateIcon() {
        if (isOpen) {
            icon.classList.remove('fa-caret-down');
            icon.classList.add('fa-caret-up');
        } else {
            icon.classList.remove('fa-caret-up');
            icon.classList.add('fa-caret-down');
        }
    }

    function removeDays(input) {
        input.value = input.value.replace(/ *days$/, '');
    }

    function appendDays(input) {
        let val = input.value.replace(/ *days$/, ''); // remove existing "days"
        if (val && !isNaN(val)) {
            input.value = val + " days";
        } else if (val === '') {
            input.value = '';
        }
    }
</script>