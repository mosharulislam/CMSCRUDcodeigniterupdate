<!DOCTYPE html>
<html>
<head>
    <title>CRUD Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1, h2 {
            color: #333;
        }

        p {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px;
            border: 1px solid #badbcc;
            border-radius: 5px;
            max-width: 600px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        form {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="email"], input[type="number"] {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
            margin-bottom: 10px;
            display: block;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .random-operations button {
            background-color: #28a745;
        }

        .random-operations button:hover {
            background-color: #218838;
        }

        .actions button {
            background-color: #dc3545;
        }

        .actions button:hover {
            background-color: #b02a37;
        }
    </style>
</head>
<body>

    <h1>CRUD Operations</h1>

    <!-- Notification Section -->
    <?php if (session()->getFlashdata('message')): ?>
        <p>
            <?= session()->getFlashdata('message') ?>
        </p>
    <?php endif; ?>

    <!-- Manual Data Insertion -->
    <div class="form-section">
        <h2>Add a New Record</h2>
        <form action="/insertManual" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter name" required>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter phone number" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email address" required>
            <button type="submit">Add Record</button>
        </form>
    </div>

    <!-- Random Data Insertion -->
    <div class="form-section">
        <h2>Insert Random Data</h2>
        <form action="/insert" method="post">
            <label for="num_records">How many records to insert?</label>
            <input type="number" id="num_records" name="num_records" required min="1" placeholder="Enter number of records">
            <button type="submit">Insert</button>
        </form>
    </div>

    <!-- Edit Multiple Records -->
    <div class="form-section">
        <h2>Edit Specific Number of Records</h2>
        <form action="/editMultiple" method="post">
            <label for="num_records">How many records to edit?</label>
            <input type="number" id="num_records" name="num_records" required min="1" placeholder="Enter number of records">
            <button type="submit">Edit Records</button>
        </form>
    </div>

    <!-- Delete Multiple Records -->
    <div class="form-section">
        <h2>Delete Specific Number of Records</h2>
        <form action="/deleteMultiple" method="post">
            <label for="num_records">How many records to delete?</label>
            <input type="number" id="num_records" name="num_records" required min="1" placeholder="Enter number of records">
            <button type="submit">Delete Records</button>
        </form>
    </div>

    <!-- Random Operations -->
    <div class="form-section random-operations">
        <h2>Random Operations</h2>
        <form action="/editRandom" method="post" style="display: inline;">
            <button type="submit">Edit Random Record</button>
        </form>
        <form action="/deleteRandom" method="post" style="display: inline;">
            <button type="submit">Delete Random Record</button>
        </form>
    </div>

    <!-- Display All Data -->
    <h2>All Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $contact['id'] ?></td>
                    <td><?= $contact['name'] ?></td>
                    <td><?= $contact['phone'] ?></td>
                    <td><?= $contact['email'] ?></td>
                    <td><?= $contact['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Speed Test Operations</h2>

<<!-- Display Speed Results -->
<?php if (isset($speed_result)): ?>
    <p style="color: green; font-weight: bold; margin-top: 20px;">
        <?= $speed_result ?>
    </p>
<?php endif; ?>

<?php if (isset($query_speed_result)): ?>
    <p style="color: blue; font-weight: bold; margin-top: 20px;">
        <?= $query_speed_result ?>
    </p>
<?php endif; ?>
<h2>Speed Test Logs</h2>
<?php if (!empty($logs)): ?>
    <table border="1" cellpadding="10" cellspacing="0" style="margin-top: 20px; width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Operation</th>
                <th>Number of Records</th>
                <th>Execution Time (seconds)</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= $log['id'] ?></td>
                    <td><?= $log['operation'] ?></td>
                    <td><?= $log['num_records'] ?></td>
                    <td><?= number_format($log['execution_time'], 6) ?></td>
                    <td><?= $log['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No speed logs available.</p>
<?php endif; ?>

    <!-- JavaScript for Auto-Refresh -->
    <script>
        // Function to fetch updated data from the server
        function fetchUpdatedData() {
    fetch('/fetchUpdatedData')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('data-table-body');
            tableBody.innerHTML = ''; // Clear old data
            data.forEach(contact => {
                const row = `
                    <tr>
                        <td>${contact.id}</td>
                        <td>${contact.name}</td>
                        <td>${contact.phone}</td>
                        <td>${contact.email}</td>
                        <td>${contact.created_at}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            // Rebind event listeners if necessary
        })
        .catch(error => console.error("Error fetching updated data:", error));
}


        // Automatically refresh data after submitting any form
        document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission behavior
            
            const formData = new FormData(form);
            fetch(form.action, {
                method: form.method,
                body: formData,
            })
                .then(response => response.text())
                .then(result => {
                    console.log(result); // Optionally log the server response
                    fetchUpdatedData(); // Refresh data
                })
                .catch(error => console.error("Error:", error));
        });
    });
});

    </script>

</body>
</html>
