<html>

<head>
    <title>CURD REST API in Codeigniter</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.0.0/backbone-min.js"></script>

</head>

<link rel="stylesheet" href="<?php echo base_url('assets/css/home.css'); ?>" />

<nav class="navbar navbar-light bg-white">
    <a class="navbar-brand" href="<?php echo site_url('UserManagementController/sendingToHomePage') ?>">SharedGroove</a>
</nav>

<body>
    <div class="container">
        <br />
        <h3 align="center">Create CRUD REST API in Codeigniter - 4</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">CRUD REST API in Codeigniter</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form>
        <div>
            <input type="submit" value="Create" id="create" />
        </div>
    </form>
</body>

</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Contact</h4>
                </div>
                <div class="modal-body">
                    <label>Enter First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" />
                    <span id="first_name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Surname Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" />
                    <span id="last_name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Email Address</label>
                    <input type="text" name="emai_address" id="emai_address" class="form-control" />
                    <span id="email_address_error" class="text-danger"></span>
                    <br />
                    <label>Enter Telephone Number</label>
                    <input type="text" name="telephone_no" id="telephone_no" class="form-control" />
                    <span id="telephone_no_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        // function fetch_data()
        // {
        //     $.ajax({
        //         url:"<?php echo base_url(); ?>test_api/action",
        //         method:"POST",
        //         data:{data_action:'fetch_all'},
        //         success:function(data)
        //         {
        //             $('tbody').html(data);
        //         }
        //     });
        // }

        // fetch_data();

        $('#add_button').click(function(){
            $('#user_form')[0].reset();
            $('.modal-title').text("Add Contact");
            $('#action').val('Add');
            $('#data_action').val("Insert");
            $('#userModal').modal('show');
        });

        // $(document).on('submit', '#user_form', function(event){
        //     event.preventDefault();
        //     $.ajax({
        //         url:"<?php echo base_url() . 'test_api/action' ?>",
        //         method:"POST",
        //         data:$(this).serialize(),
        //         dataType:"json",
        //         success:function(data)
        //         {
        //             if(data.success)
        //             {
        //                 $('#user_form')[0].reset();
        //                 $('#userModal').modal('hide');
        //                 fetch_data();
        //                 if($('#data_action').val() == "Insert")
        //                 {
        //                     $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
        //                 }
        //             }

        //             if(data.error)
        //             {
        //                 $('#first_name_error').html(data.first_name_error);
        //                 $('#last_name_error').html(data.last_name_error);
        //             }
        //         }
        //     })
        // });

        // $(document).on('click', '.edit', function(){
        //     var user_id = $(this).attr('id');
        //     $.ajax({
        //         url:"<?php echo base_url(); ?>test_api/action",
        //         method:"POST",
        //         data:{user_id:user_id, data_action:'fetch_single'},
        //         dataType:"json",
        //         success:function(data)
        //         {
        //             $('#userModal').modal('show');
        //             $('#first_name').val(data.first_name);
        //             $('#last_name').val(data.last_name);
        //             $('.modal-title').text('Edit User');
        //             $('#user_id').val(user_id);
        //             $('#action').val('Edit');
        //             $('#data_action').val('Edit');
        //         }
        //     })
        // });

        // $(document).on('click', '.delete', function(){
        //     var user_id = $(this).attr('id');
        //     if(confirm("Are you sure you want to delete this?"))
        //     {
        //         $.ajax({
        //             url:"<?php echo base_url(); ?>test_api/action",
        //             method:"POST",
        //             data:{user_id:user_id, data_action:'Delete'},
        //             dataType:"JSON",
        //             success:function(data)
        //             {
        //                 if(data.success)
        //                 {
        //                     $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
        //                     fetch_data();
        //                 }
        //             }
        //         })
        //     }
        // });


        $("#create").click(function() {
            event.preventDefault();
            $.ajax({
                method: "GET",
                url: "<?php base_url() ?> index.php/ContactListController/contacts",
                dataType: "JSON",
                cache: false,
                data: {
                    name: 'Raveen',
                },
                success: function(data) {
                    console.log(data);
                }
            });
            return false;
        });
    });
</script>