document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.querySelector(".sidebar");
    const toggleBtn = document.querySelector("#btn");
    const homeContent = document.querySelector(".dynamic-content"); // Ensure the selector matches your content div

    if (toggleBtn && sidebar && homeContent) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");

            // Adjust the dynamic-content position and width dynamically
            if (sidebar.classList.contains("open")) {
                homeContent.style.marginLeft = "200px"; // Match expanded sidebar width
                homeContent.style.width = "calc(100% - 200px)";
            } else {
                homeContent.style.marginLeft = "78px"; // Match collapsed sidebar width
                homeContent.style.width = "calc(100% - 78px)";
            }
        });
    }
});

//delete button for users
$(document).on("click", ".delete-btn-msg", function (e) {
    e.preventDefault(); 

    const rowId = $(this).data("id"); 

    // Confirm deletion
    if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
            url: "", 
            type: "POST",
            data: {
                delete_id: rowId 
            },
            success: function (response) {
                if (response === "success") {
                // If deletion was successful, remove the row from the table
                $("#row-" + rowId).remove();
            } else {
                alert("Failed to delete the user.");
            }
        },
        error: function () {
            alert("An error occurred while deleting the user.");
        }
    });
}
});


