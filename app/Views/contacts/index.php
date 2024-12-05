<!DOCTYPE html>
<html>
<head>
    <title>Contact List</title>
</head>
<body>
    <h1>Contact List</h1>
    <a href="/create">Add New Contact</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $contact['id']; ?></td>
                    <td><?= $contact['name']; ?></td>
                    <td><?= $contact['phone']; ?></td>
                    <td><?= $contact['email']; ?></td>
                    <td>
                        <form action="/delete/<?= $contact['id']; ?>" method="post">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
