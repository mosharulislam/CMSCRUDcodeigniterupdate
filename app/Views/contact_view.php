<!DOCTYPE html>
<html>
<head>
    <title>Contact CRUD</title>
</head>
<body>
    <h1>Contact List</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>mobile</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $contact->id; ?></td>
                    <td><?= $contact->name; ?></td>
                    <td><?= $contact->phone; ?></td>
                    <td><?= $contact->email; ?></td>
                    <td><?= $contact->created_at; ?></td>
                    <td>
                        <a href="<?= site_url('ContactController/update/'.$contact->id); ?>">Update</a>
                        <a href="<?= site_url('ContactController/delete/'.$contact->id); ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <form action="<?= site_url('ContactController/insert'); ?>" method="post">
        <button type="submit">Add Random Contact</button>
    </form>
</body>
</html>
