<style>
    #dropdown {
        position: absolute;
        background: white;
        border: 1px solid #ccc;
        width: 50%;
        max-height: 192px;
        overflow-y: hidden;
        z-index: 9999;
    }

    .dropdown-item {
        padding: 8px 12px;
        border-bottom: 1px solid #eee;
    }

    .dropdown-item:hover {
        background-color: #f0f0f0;
    }

    /* #user-table td {
        background-color: transparent !important;
    } */

    #user-table tbody tr:hover {
        background-color: rgb(96, 118, 241);
        /* Light grey background color on hover */
    }
    
</style>

<section id="content">
    <!-- MAIN -->
    <main>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tools </a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="font-size: 14px;">
                <i class="fas fa-user-plus"></i> Add User
            </button>
        </div>

        <!-- add member modal -->
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 600px; overflow:hidden;">
                <!-- <div class="modal-content" style="background-color: transparent; border:none;"> -->
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <form>
                                <div class="mb-3 row">
                                    <h4 class="mb-2" style="font-weight: bold;">ADD USER</h4>
                                </div>

                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="email" class="form-control" placeholder="Search Lastname, Firstname" id="fullName" aria-describedby="emailHelp" autocomplete="off">
                                    <input type="hidden" id="emp_id" name="emp_id">
                                    <div id="dropdown" class="dropdown-menu" style="display: none;"></div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="position" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" disabled>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="businessUnit" class="form-label">Business Unit</label>
                                        <input type="text" class="form-control" id="bu" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="col-md-6" style="width: 100px;">
                                        <label for="disabledSelect" class="form-label">User Type</label>
                                        <select id="userType" class="form-select">
                                            <option>MIS</option>
                                            <option>Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="add_user" name="submit" class="btn btn-primary ">Add</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>

                                <!-- </div> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- add member modal -->

        <!-- update member modal -->
        <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 600px; overflow:hidden;">
                <!-- <div class="modal-content" style="background-color: transparent; border:none;"> -->
                <div class="modal-content">
                    <div class="modal-body" id="modal-content">
                        <div class="container">
                            <form>
                                <div class="mb-3 row">
                                    <h4 class="mb-2" style="font-weight: bold;">UPDATE USER</h4>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="newUserName" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="newUserName">
                                        <input type="hidden" id="user_id">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="password">
                                    </div>
                                </div>

                            </form>

                            <div class="row">
                                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"> -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" id="update_user" name="submit" class="btn btn-primary ">Update</button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">Close</button>
                                </div>

                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- update member modal -->

        <div class="table-data mt-3">
            <div class="order">
                <table id="user-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>USERNAME</th>
                            <th>USER TYPE</th>
                            <th style="width: 80px;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </main>
</section>

<script>
    var user_table = $("#user-table").DataTable({
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
            url: '<?php echo site_url('User_cont/users'); ?>',
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
                data: 'name'
            },
            {
                data: 'username'
            },
            {
                data: 'user_type',
            },
            {
                data: 'user_id',
                render: function(data, type, row) {
                    return `
            <div style="display: flex; gap: 10px;">
                <!-- Edit Icon -->
                <i class="fas fa-edit edit-icon text-warning" style="cursor: pointer; font-size: 14px;" 
                    onclick="openEditModal('${row.user_id}')"></i>
            </div> `;
                }
            }
        ]
    });

    $(function() {
        $("#fullName").on("input", function() {
            var fullname = $("#fullName").val();

            $.ajax({
                url: '<?php echo site_url('User_cont/searchEmployee') ?>',
                type: 'POST',
                data: {
                    fullname: fullname
                },
                success: function(response) {
                    var jObj = JSON.parse(response);
                    console.log(jObj);

                    $("#dropdown").html("");

                    if (fullname.length > 0) {
                        for (var c = 0; c < jObj.length; c++) {
                            var name = jObj[c].name;
                            var id = jObj[c].emp_id;
                            var pos = jObj[c].position;
                            var bu = jObj[c].business_unit;
                            var dept = jObj[c].dept_name;

                            var option = $('<div>')
                                .addClass('dropdown-item')
                                .css('cursor', 'pointer')
                                .text(name)
                                .click((function(name, id, pos, dept, bu) {
                                    return function() {
                                        emp_id = id;
                                        $("#fullName").val(name);
                                        $("#position").val(pos);
                                        $("#department").val(dept);
                                        $("#bu").val(bu);
                                        $("#emp_id").val(id);

                                        $("#dropdown").hide();
                                        console.log(emp_id);
                                    };
                                })(name, id, pos, dept, bu));

                            $("#dropdown").append(option);
                        }

                        $("#dropdown").show();
                    } else {
                        $("#dropdown").hide();
                        emp_id = "";
                        $("#position").val("");
                        $("#department").val("");
                        $("#bu").val("");
                    }

                }
            });
        });
    });

    $(function() {
        $("#add_user").on('click', function(e) {

            e.preventDefault();

            var name = $("#fullName").val();
            var username = $("#username").val();
            var usertype = $("#userType").val();
            var emp_id = $("#emp_id").val();

            console.log(username);
            console.log(usertype);
            console.log(emp_id);

            if (name == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Fullname required'
                });
                return;
            }

            if (username == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Username required'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to add this user?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('User_cont/add_user'); ?>",
                        data: {
                            emp_id: emp_id,
                            username: username,
                            usertype: usertype,
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Success', response.message, 'success');
                                $('#addModal').modal('hide');
                                $('#addModal input').val('');
                                user_table.ajax.reload();
                            } else if (response.exist) {
                                Swal.fire('Error', response.message, 'error');
                            } else {
                                Swal.fire('Error', 'Something went wrong', 'error');
                            }
                        }
                    });
                }
            });
        });
    });


    function openEditModal(id) {

        console.log("Opening modal for ID:", id);

        $('#user_id').val(id);
        $('#updateModal').modal('show');

        $.ajax({
            url: '<?php echo base_url('User_cont/userDetails'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                console.log("Full Response:", response);

                if (response.data && response.data.length > 0) {
                    var data = response.data[0];
                    $('#newUserName').val(data.username);
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

    $('#update_user').click(function() {

        var user_id = $("#user_id").val();
        var username = $("#newUserName").val();
        var password = $("#password").val();

        console.log(user_id);
        console.log(username);
        console.log(password);

        $.ajax({
            url: '<?php echo base_url("User_cont/updateUser"); ?>',
            type: 'POST',
            data: {
                user_id: user_id,
                username: username,
                password: password,
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success');
                    $('#updateModal').modal('hide');
                    $('#updateModal input').val('');
                    user_table.ajax.reload();
                } else if (response.exist) {
                    Swal.fire('Error', response.message, 'error');
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Failed to update member', 'error');
                console.error("Error:", xhr.responseText);
            }
        });
    });
</script>