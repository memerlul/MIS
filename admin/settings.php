<?php 
include "components/header.php";
?>
<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Settings</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($account[0]['name']), 0, 1);
        ?>
    </div>
</div>


<?php 
include "components/footer.php";
?>
