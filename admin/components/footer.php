
<!-- Main Content goes here -->
 </main>
</div>



<!-- Floating Chat Button -->
<div id="chat-button" class="fixed bottom-5 right-5 bg-blue-500 text-white p-4 rounded-full shadow-lg cursor-pointer hover:bg-blue-600 transition">
    💬
</div>


<!-- Chat Modal -->
<div id="chat-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" style="display:none;">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg flex h-[80vh]">
        
        <!-- Sidebar (Contacts List) -->
        <div class="w-1/3 bg-gray-200 p-4 rounded-l-lg overflow-y-auto">
            <h2 class="text-lg font-semibold mb-3">Contacts list</h2>
            
            <!-- Search Bar -->
            <input type="text" id="search-input" placeholder="Search contacts..." 
                class="w-full p-2 mb-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

            <!-- Contacts List -->
            <label for="mis-list">MIS System</label>
            <ul id="mis-list" class="space-y-2">
                <li class="text-gray-500">Loading mis...</li>
            </ul>

            <label for="alumni-list">Alumni System</label>
            <ul id="alumni-list" class="space-y-2">
                <li class="text-gray-500">Loading alumni...</li>
            </ul>

            <label for="library-list">Library System</label>
            <ul id="library-list" class="space-y-2">
                <li class="text-gray-500">Loading library...</li>
            </ul>
        </div>

        <!-- Chat Area -->
        <div class="w-2/3 flex flex-col rounded-r-lg">
            
          
            <!-- Chat Header -->
            <div class="bg-blue-500 text-white text-center py-3 text-lg font-semibold rounded-tr-lg" id="chat-header">
                Select a contact
            </div>

            <!-- Chat Messages -->
            <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                <div class="chat-messages">
               
                </div>
                    
            </div>

            <!-- Input Box -->
            <form id="frmSend_chat" class="p-3 border-t flex items-center">
                <input type="file" id="file-input" name="file-input" class="hidden" onchange="handleFileUpload()">
                <label for="file-input" class="cursor-pointer bg-gray-200 px-3 py-2 rounded-lg mr-2 hover:bg-gray-300">
                    <span class="material-icons">attach_file</span>
                </label>
                <div id="file-preview" class="text-sm text-gray-600 hidden"></div>
                
                <input id="message-input" name="message-input" type="text" placeholder="Type a message..."
                    class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                
                <!-- Hidden Fields -->
                <input type="hidden" id="sender_id" name="sender_id" value="<?=$_SESSION['id']?>">
                <input type="hidden" id="reciever_id" name="reciever_id" value="">
                <input type="hidden" name="systemFrom" value="mis">
                <input type="hidden" id="system" name="systemTo" value="">

                <!-- Send Button -->
                <button type="submit" id="btnSend_chat" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Send</button>
            </form>
        </div>

    </div>
</div>








<script>





$(document).ready(function () {

  












    fetchAlumni();
    fetchMis();
    fetchLibrary();


    $("#frmSend_chat").submit(function (e) {
    e.preventDefault();

    var fileInput = $("#file-input")[0].files; // Get files array
    var message = $("#message-input").val().trim();   
    var reciever_id = $("#reciever_id").val();   

    if (!reciever_id) {
        alertify.error("Select Contact First");
        return;
    }

    if (fileInput.length === 0 && !message) { 
        alertify.error("Attach a file or write a message first");
        return;
    }

    var formData = new FormData(this);
    formData.append('requestType', 'send_chat');



    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response === "success") {
                $("#file-input").val("");  // Clear file input
                $("#message-input").val("");  // Clear message input
                $("#file-preview").html("").addClass("hidden");  // Clear and hide file preview
            }
        }
    });

});

});


function fetchMis() {
    $.ajax({
        url: 'backend/end-points/fetch_mis_user.php',
        type: 'GET',
        // dataType: 'json',
        success: function (data) {
            // console.log(data);
            let misList = $("#mis-list");

            // Clear existing lists
            misList.empty();

            if (data.length === 0) {
                misList.append(`<li class="text-gray-500">No users found</li>`);
                return;
            }

            data.forEach(user => {
                let userItem = `
                    <li class="target_chat_reciever p-2 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-100" data-system='mis' data-user_id=${user.id} data-user_name=${user.name}>
                        ${user.name}
                    </li>`;
                    // If user_type is not categorized, add them to a default list
                    misList.append(userItem);
               
            });
        },
    });
}


function fetchAlumni() {
    $.ajax({
        url: 'http://localhost/BCPAlumni-SMS3/alumni_system_api.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            let alumniList = $("#alumni-list");

            // Clear existing lists
            alumniList.empty();

            if (data.length === 0) {
                alumniList.append(`<li class="text-gray-500">No users found</li>`);
                return;
            }

            data.forEach(user => {
                let userItem = `
                    <li class="target_chat_reciever p-2 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-100" data-system='alumni' data-user_id=${user.id} data-user_name=${user.name}>
                        ${user.name}
                    </li>`;
                  
                    alumniList.append(userItem);
               
            });
        },
    });
}


function fetchLibrary() {
    $.ajax({
        url: 'http://localhost/BCP_SMS3_Library/library_system_api.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            let libraryList = $("#library-list");

            libraryList.empty();

            if (data.length === 0) {
                libraryList.append(`<li class="text-gray-500">No users found</li>`);
                return;
            }

            data.forEach(user => {
                let userItem = `
                    <li class="target_chat_reciever p-2 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-100" data-system='library' data-user_id=${user.user_id} data-user_name=${user.name}>
                        ${user.name}
                    </li>`;
                    // If user_type is not categorized, add them to a default list
                    libraryList.append(userItem);
               
            });
        },
    });
}


$(document).on('click', '.target_chat_reciever', function () {
    var user_id = $(this).data('user_id');
    var user_name = $(this).data('user_name');
    var system = $(this).data('system');
   $('#chat-header').text(user_name);
   $('#reciever_id').val(user_id);
   $('#system').val(system);
  
   fetchChatMessages(user_id);
   console.log('click');
});



function fetchChatMessages(receiver_id) {
    if (!receiver_id) return;

    var UserID = $("#UserID").val(); // Ensure this exists in HTML
    let chatBox = $(".chat-messages");

    $.ajax({
        url: 'backend/end-points/fetch_user_chat.php',
        type: "POST",
        data: { receiver_id: receiver_id },
        dataType: "json",
        success: function (response) {
            console.log(response.messages);

            chatBox.html("");

            if (response.status === "success" && response.messages.length > 0) {
                $.each(response.messages, function (index, message) {
                    let isSender = (message.sender_id == UserID);
                    let alignmentClass = isSender ? "justify-end" : "justify-start";
                    let bgColor = isSender ? "bg-blue-500 text-white" : "bg-gray-200 text-gray-800";

                    let mediaHTML = "";

                    if (message.message_media) {
                        let filePath = `upload_files/${message.message_media}`;
                        let fileName = message.message_media.split("/").pop();

                        if (message.message_status == 2) {
                            // File is waiting for approval
                            mediaHTML = `
                                <div class="flex items-center gap-2 mt-2 text-white-500">
                                    <span class="material-icons">insert_drive_file</span>
                                    <span class="italic">This file is waiting for approval</span>
                                </div>

                            `;
                        } else {
                            // File is approved and downloadable
                            mediaHTML = `
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="material-icons text-gray-500">attach_file</span>
                                    <a href="../assets/${filePath}" target="_blank" download="${fileName}" class="text-white-500 underline">${fileName}</a>
                                </div>
                            `;
                        }
                    }

                    let messageHTML = `
                        <div class="flex ${alignmentClass} mb-2">
                            <div class="${bgColor} p-3 rounded-lg shadow max-w-xs">
                                <p class="text-sm">${message.message_text}</p>
                                ${mediaHTML}
                            </div>
                        </div>
                    `;
                    chatBox.append(messageHTML);
                });

                // Smooth scroll to the latest message
                chatBox.animate({ scrollTop: chatBox[0].scrollHeight }, 300);
            } else {
                chatBox.html(`<div class="text-center text-gray-500">No messages found. Start the conversation!</div>`);
            }

        },
        error: function () {
            chatBox.html(`<div class="text-center text-red-500">Error fetching messages.</div>`);
            console.log("Error fetching messages.");
        }
    });
}


setInterval(function () {
        let receiver_id = $("#reciever_id").val();
        if (receiver_id) {
            fetchChatMessages(receiver_id);
        }
    }, 2000);




$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#mis-list li').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
        $('#alumni-list li').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
        $('#library-list li').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});

function handleFileUpload() {
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    
    if (fileInput.files.length > 0) {
        filePreview.textContent = `Attached: ${fileInput.files[0].name}`;
        filePreview.classList.remove('hidden');
    } else {
        filePreview.classList.add('hidden');
    }
}


  $("#chat-button").click(function() {
        $("#chat-modal").fadeIn();
    });

    // Close Modal
    $("#Hide_create_report_modal").click(function() {
        $("#chat-modal").fadeOut();
    });

    // Close Modal when clicking outside the modal content
    $("#chat-modal").click(function(event) {
        if ($(event.target).is("#chat-modal")) {
            $("#chat-modal").fadeOut();
        }
    });
</script>







<!-- Optional: Material Icons CDN for icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>






<script>
  
  
  const overlay = document.getElementById('overlay');


  menuButton.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  });



  overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });
</script>

<script src="js/app.js"></script>
</body>
</html>