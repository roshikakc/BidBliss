
// dropdown
const toggleBtn = document.querySelector('.toggle-button'); 
const toggleBtnIcon = document.querySelector('.toggle-button i'); 
const dropDownMenu = document.querySelector('.dropdown_menu'); 

// Add click event listener to the toggle button
toggleBtn.addEventListener('click', function () {
    dropDownMenu.classList.toggle('open'); 
    const isOpen = dropDownMenu.classList.contains('open')

    toggleBtnIcon.classList = isOpen
    ? 'fa-solid fa-xmark'
    : 'fa-solid fa-bars'
});

window.onload = function() {
    const background = document.getElementById("background");
    const images = [
       "url('./../assets/Image/oil lamp Sukunda.jpg')",
        "url('./../assets/Image/Nepali oil Lamp.jpg')",
        "url('./../assets/Image/Nepali Handmade Statue of Garuda,Gold plated antique finishing.jpg')"
    ];
     let currentIndex = 0;

    // Preload images to prevent any delay during transitions
    images.forEach(imageUrl => {
        const img = new Image();
        img.src = imageUrl.replace('url(', '').replace(')', '').replace(/\"/gi, "");
    });

    function changeBackgroundImage() {
         // Set current background image
         background.style.backgroundImage = images[currentIndex];

        // After fade-out, set the new background and fade back in
        setTimeout(() => {
           background.style.backgroundImage = images[currentIndex];

            // Update index to the next image
            currentIndex = (currentIndex + 1) % images.length;
        }, 1000); // Matches the fade-out duration in CSS
    }

   // Initial background setup
    background.style.backgroundImage = images[currentIndex];
    currentIndex = (currentIndex + 1) % images.length;

   // Change the background image every 3 seconds
    setInterval(changeBackgroundImage, 3000);
 };


// user products
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    // Function to switch active tab and content
    function switchTab(event) {
        const targetId = event.target.getAttribute('data-target');

        // Remove active class from all tabs and content
        tabs.forEach(tab => tab.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));

        // Add active class to the clicked tab and corresponding content
        event.target.classList.add('active');
        document.getElementById(targetId).classList.add('active');
    }

    // Add click event listener to each tab
    tabs.forEach(tab => {
        tab.addEventListener('click', switchTab);
    });
});


// auction date
document.addEventListener('DOMContentLoaded', function() {
    // Get the elements by their IDs
    const auctionTypeSelect = document.getElementById('auctionType');
    const upcomingDateContainer = document.getElementById('upcomingDateContainer');
    
    // Function to handle the dropdown change
    auctionTypeSelect.addEventListener('change', function() {
        // If 'upcoming' is selected, show the date input
        if (auctionTypeSelect.value === 'upcoming') {
            upcomingDateContainer.style.display = 'block';
        } else {
            upcomingDateContainer.style.display = 'none';
        }
    });

    // Initial check on page load to hide/show the date input
    if (auctionTypeSelect.value === 'upcoming') {
        upcomingDateContainer.style.display = 'block';
    } else {
        upcomingDateContainer.style.display = 'none';
    }
});

// edit product 
function showEditForm(productId) {
    // Hide all edit forms first
    document.querySelectorAll('.edit-form').forEach(form => {
        form.style.display = 'none';
    });

    // Show the specific edit form
    const editForm = document.getElementById(`edit-form-${productId}`);
    if (editForm) {
        editForm.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Get the elements by their IDs for the edit form
    const auctionTypeSelect = document.getElementById('auctionType1'); // Use auctionType1 for the second form
    const upcomingDateContainer = document.getElementById('upcomingDateContainer');

    // Function to handle the dropdown change
    if (auctionTypeSelect) {
        auctionTypeSelect.addEventListener('change', function () {
            // If 'upcoming' is selected, show the date input
            if (auctionTypeSelect.value === 'upcoming') {
                upcomingDateContainer.style.display = 'block';
            } else {
                upcomingDateContainer.style.display = 'none';
            }
        });

        // Initial check on page load to hide/show the date input
        if (auctionTypeSelect.value === 'upcoming') {
            upcomingDateContainer.style.display = 'block';
        } else {
            upcomingDateContainer.style.display = 'none';
        }
    }
});






//ajax for add to cart
{/* <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> */}
// $(document).ready(function() {
//     // When the Add to Cart form is submitted
//     $('#addToCartForm').submit(function(event) {
//         event.preventDefault();  // Prevent default form submission

//         var formData = $(this).serialize();  // Get form data

//         // Send AJAX POST request to cart.php
//         $.ajax({
//             url: 'cart.php',  // The same page
//             method: 'POST',
//             data: formData,  // Send the form data
//             success: function(response) {
//                 // Show the response message or success alert (from PHP)
//                 alert(response);  // Display the success message from PHP
//             },
//             error: function() {
//                 alert('Error adding to cart!');
//             }
//         });
//     });
// });





