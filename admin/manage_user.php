<?php 
include "components/header.php";


?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Manage User</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($account[0]['name']), 0, 1);
        ?>
    </div>
</div>

<!-- Add User Button -->
<div class="flex justify-between items-center mb-4">
    <button id="openAddUserModalBtn"
        class="px-4 py-2 bg-green-500 text-white font-semibold rounded-md shadow-md hover:bg-green-600 transition">
        + Add User
    </button>
</div>










<!-- Modal Background -->
<div id="UpdateUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4 sm:p-6" style="display:none;">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl">
        <h2 class="text-lg font-semibold mb-4">Update User</h2>
        
        <!-- Form for Adding User -->
        <form id="updateUserForm">

            <div hidden class="mb-3">
                <label class="block text-sm font-medium text-gray-700">User ID</label>
                <input type="text" id="update_userid" name="userid" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" id="update_fullname" name="fullname" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">username</label>
                <input type="text" id="update_username" name="username" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="update_password" name="password" class="w-full p-2 border rounded-md" >
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">User Type</label>
                <select id="update_userType" name="userType" class="w-full p-2 border rounded-md" required>
                    <option value="admin">Admin</option>
                    <option value="super admin">Super admin</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                <button type="button" id="closeUpdateUserModal" class="px-4 py-2 bg-gray-400 text-white rounded-md">Cancel</button>
                
            </div>
        </form>
    </div>
</div>






<!-- Modal Background -->
<div id="addUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-4 sm:p-6" style="display:none;">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl">
        <h2 class="text-lg font-semibold mb-4">Add New User</h2>
        
        <!-- Form for Adding User -->
        <form id="addUserForm">
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" id="fullname" name="fullname" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">username</label>
                <input type="username" id="username" name="username" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">User Type</label>
                <select id="userType" name="userType" class="w-full p-2 border rounded-md" required>
                    <option value="admin">Admin</option>
                    <option value="super admin">Super admin</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                <button type="button" id="closeModalBtn" class="px-4 py-2 bg-gray-400 text-white rounded-md">Cancel</button>
                
            </div>
        </form>
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
                    <th class="p-2">Fullname</th>
                    <th class="p-2">username</th>
                    <th class="p-2">User Type</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/user_list.php"; ?>
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
