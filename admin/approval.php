<?php 
include "components/header.php";


?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Message Approval</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($account[0]['name']), 0, 1);
        ?>
    </div>
</div>









<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <!-- Search Input -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="p-2 border rounded-md" placeholder="Search user...">
    </div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="display table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-2">Sent From User ID :</th>
                    <th class="p-2">Sent To User ID :</th>
                    <th class="p-2">System</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/message_approval_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include "components/footer.php";
?>

<!-- jQuery for Modal Functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
// UpdateUserModal


        $(".showUpdateModal").click(function (e) { 
            let id = $(this).data('id')
            let name = $(this).data('name')
            let username = $(this).data('username')
            let type = $(this).data('type')

            $("#UpdateUserModal").fadeIn();

            $("#update_userid").val(id);
            $("#update_fullname").val(name);
            $("#update_username").val(username);
            $("#update_userType").val(type);
            console.log(type);
        });


        $("#closeUpdateUserModal").click(function() {
            $("#UpdateUserModal").fadeOut();
        });
        $("#UpdateUserModal").click(function(event) {
            if ($(event.target).is("#UpdateUserModal")) {
                $("#UpdateUserModal").fadeOut();
            }
        });




        $("#openAddUserModalBtn").click(function() {
            $("#addUserModal").fadeIn();
        });

        $("#closeAddUserModal").click(function() {
            $("#addUserModal").fadeOut();
        });
        $("#addUserModal").click(function(event) {
            if ($(event.target).is("#addUserModal")) {
                $("#addUserModal").fadeOut();
            }
        });

       
    });
</script>
