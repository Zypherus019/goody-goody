<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/suppliers.css">
</head>

<body>
    <!-- Modal For Adding Supplier -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close" class="close" aria-label="Close modal">&times;</button>
            </div>
            <form id="insertForm" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>

                    <div class="form-group mb-3">
                        <label>Contact Num.</label>
                        <input type="number" class="form-control" name="contact" placeholder="Contact">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close2" class="close" aria-label="Close modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>


    <div id="blockListModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="closeBlockListModal" class="close" aria-label="Close modal">&times;</button>
                <h2 class="modal-title">Blocked Suppliers</h2>
            </div>
            <div class="modal-body">
                
                <table id="blockListTable" class="modal-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Un-Block</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeBlockListModalBtn" class="close" aria-label="Close modal">Close</button>
            </div>
        </div>
    </div>


    <!-- Modal For Veiwing Suppliers -->
    <table id="dataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Block List</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div class="btn-container">
        <h3 class="tool_header">Quick Access/Tools</h3>
        <button id="open" class="open"><i class='bx bx-list-plus'></i>Add Supplier</button>
        <button id="openBlockListModal" class="open"><i class='bx bx-list-minus'></i> Block List</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="modal.js"></script>
    <script src="suppliers.js"></script>
</body>

</html>