var modal = document.getElementById("myModal");

var openBtn = document.getElementById("open");

var close2Btn = document.getElementById("close2");

var closeBtn = document.getElementsByClassName("close")[0];

openBtn.onclick = function () {
  modal.style.display = "block";
}

close2Btn.onclick = function () {
  modal.style.display = "none";
}

closeBtn.onclick = function () {
  modal.style.display = "none";
}
close2Btn.onclick = function () {
  modal.style.display = "none";
}

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


$(document).ready(function () {
  // Function to fetch data from block_list.php
  function fetchData() {
    $.ajax({
      url: 'block_list.php',
      type: 'GET',
      success: function (data) {
        $('#blockListTable tbody').html(data);
        // Initialize DataTable (assuming DataTables is included and configured)
        $('#blockListTable').DataTable({
          "paging": true, // Enable pagination
          "searching": true, // Enable search box
          "ordering": true, // Enable sorting
          "info": true // Show table information
          // Add more options as needed
        });
      },
      error: function (xhr, status, error) {
        console.error('Error fetching data:', error);
        // Handle error gracefully, e.g., show an alert to the user
        alert('Failed to fetch data. Please try again later.');
      }
    });
  }

  $(document).on('click', '.returnBtn', function () {
    var id = $(this).data('id');
    $.ajax({
      url: 'transfer_blocklist.php',
      type: 'POST',
      data: { id: id },
      success: function (response) {
        fetchData();
        alert(response);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });


  var blockListModal = document.getElementById('blockListModal');
  var openBlockListModalBtn = document.getElementById('openBlockListModal');
  var closeBlockListModalBtn = document.getElementById('closeBlockListModalBtn');


  openBlockListModalBtn.onclick = function () {
    blockListModal.style.display = 'block';
    fetchData();
  }

  closeBlockListModalBtn.onclick = function () {
    blockListModal.style.display = 'none';
  }
});