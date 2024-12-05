<?php

namespace App\Controllers;

use App\Models\ContactModel;
use CodeIgniter\Controller;

class CRUDController extends Controller
{
    // Display all records and speed test logs
    public function index()
    {
        $model = new ContactModel();
        $db = \Config\Database::connect();

        // Fetch all contacts
        $contacts = $model->findAll();

        // Fetch speed logs
        $logs = $db->table('speed_test_logs')->orderBy('created_at', 'DESC')->get()->getResultArray();

        return view('crud_operations', [
            'contacts' => $contacts,
            'logs' => $logs,
            'speed_result' => null, // Default value
        ]);
    }

    // Insert random records
    public function insert()
    {
        $model = new ContactModel();
        $numRecords = (int)$this->request->getPost('num_records');

        if ($numRecords <= 0) {
            return redirect()->to('/')->with('message', "Please enter a valid number of records.");
        }

        // Start the timer for insertion
        $startTime = microtime(true);

        for ($i = 0; $i < $numRecords; $i++) {
            $data = [
                'name' => 'Name_' . rand(1000, 9999),
                'phone' => '123456' . rand(1000, 9999),
                'email' => 'user' . rand(1000, 9999) . '@example.com',
            ];
            $model->save($data);
        }

        // End the timer
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Log the operation
        $db = \Config\Database::connect();
        $db->query("SET @new_id = 0;");
        $db->query("UPDATE contacts SET id = (@new_id := @new_id + 1) ORDER BY id;");
        $db->table('speed_test_logs')->insert([
            'operation' => 'Insert',
            'num_records' => $numRecords,
            'execution_time' => $executionTime,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/')->with('message', "Inserted $numRecords records in " . number_format($executionTime, 6) . " seconds.");
    }

    // Insert a manual record
    public function insertManual()
    {
        $model = new ContactModel();
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');

        if (empty($name) || empty($phone) || empty($email)) {
            return redirect()->to('/')->with('message', "All fields are required.");
        }

        // Start the timer for insertion
        $startTime = microtime(true);

        $data = ['name' => $name, 'phone' => $phone, 'email' => $email];
        $model->save($data);

        // End the timer
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Log the operation
        $db = \Config\Database::connect();
        $db->query("SET @new_id = 0;");
        $db->query("UPDATE contacts SET id = (@new_id := @new_id + 1) ORDER BY id;");
        $db->table('speed_test_logs')->insert([
            'operation' => 'Manual Insert',
            'num_records' => 1,
            'execution_time' => $executionTime,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/')->with('message', "Manually inserted 1 record in " . number_format($executionTime, 6) . " seconds.");
    }

    // Edit multiple records
    public function editMultiple()
{
    $model = new ContactModel();
    $db = \Config\Database::connect();

    // Get the number of records to edit
    $numRecords = (int)$this->request->getPost('num_records');

    if ($numRecords <= 0) {
        return redirect()->to('/')->with('message', "Please enter a valid number of records.");
    }

    // Fetch the records to edit that haven't been edited yet
    $recordsToEdit = $model->where('is_edited', 0)
                           ->orderBy('id', 'ASC')
                           ->limit($numRecords)
                           ->findAll();

    if (empty($recordsToEdit)) {
        return redirect()->to('/')->with('message', "No unedited records available.");
    }

    // Start the timer for editing
    $startTime = microtime(true);

    foreach ($recordsToEdit as $record) {
        $data = [
            'name' => 'Edited_' . rand(1000, 9999),
            'phone' => '987654' . rand(1000, 9999),
            'email' => 'edited_user' . rand(1000, 9999) . '@example.com',
            'is_edited' => 1, // Mark as edited
        ];

        // Update the record
        $model->update($record['id'], $data);
    }

    // End the timer for editing
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    // Log the operation
    $db->table('speed_test_logs')->insert([
        'operation' => 'Edit Multiple',
        'num_records' => $numRecords,
        'execution_time' => $executionTime,
        'created_at' => date('Y-m-d H:i:s'),
    ]);

    // Redirect with a success message
    return redirect()->to('/')->with('message', "Edited $numRecords records in " . number_format($executionTime, 6) . " seconds.");
}


    // Delete multiple records
    public function deleteMultiple()
    {
        $model = new ContactModel();
        $numRecords = (int)$this->request->getPost('num_records');

        if ($numRecords <= 0) {
            return redirect()->to('/')->with('message', "Please enter a valid number of records.");
        }

        $recordsToDelete = $model->orderBy('id', 'ASC')->limit($numRecords)->findAll();

        if (empty($recordsToDelete)) {
            return redirect()->to('/')->with('message', "No records found to delete.");
        }

        // Start the timer for deletion
        $startTime = microtime(true);

        foreach ($recordsToDelete as $record) {
            $model->delete($record['id']);
        }

        // End the timer
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Log the operation
        $db = \Config\Database::connect();
        $db->query("SET @new_id = 0;");
        $db->query("UPDATE contacts SET id = (@new_id := @new_id + 1) ORDER BY id;");
        $db->table('speed_test_logs')->insert([
            'operation' => 'Delete Multiple',
            'num_records' => $numRecords,
            'execution_time' => $executionTime,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/')->with('message', "Deleted $numRecords records in " . number_format($executionTime, 6) . " seconds.");
    }

    // Edit a random record
    public function editRandom()
    {
        $model = new ContactModel();
        $db = \Config\Database::connect();
    
        // Fetch a random record
        $record = $model->select('*')->orderBy('RAND()', '', false)->first();
    
        if (!$record) {
            return redirect()->to('/')->with('message', "No record found to edit.");
        }
    
        // Start the timer for editing
        $startTime = microtime(true);
    
        // Prepare the new data
        $data = [
            'name' => 'Edited_' . rand(1000, 9999),
            'phone' => '987654' . rand(1000, 9999),
            'email' => 'edited_user' . rand(1000, 9999) . '@example.com',
        ];
    
        // Update the record
        $model->update($record['id'], $data);
    
        // End the timer
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
    
        // Log the operation
        $db->table('speed_test_logs')->insert([
            'operation' => 'Edit Random',
            'num_records' => 1,
            'execution_time' => $executionTime,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    
        return redirect()->to('/')->with('message', "Edited 1 random record in " . number_format($executionTime, 6) . " seconds.");
    }
    


    // Delete a random record
    public function deleteRandom()
    {
        $model = new ContactModel();
        $record = $model->select('*')->orderBy('RAND()', '', false)->first();

        if (!$record) {
            return redirect()->to('/')->with('message', "No record found to delete.");
        }

        // Start the timer
        $startTime = microtime(true);

        $model->delete($record['id']);

        // End the timer
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Log the operation
        $db = \Config\Database::connect();
        $db->query("SET @new_id = 0;");
        $db->query("UPDATE contacts SET id = (@new_id := @new_id + 1) ORDER BY id;");
        $db->table('speed_test_logs')->insert([
            'operation' => 'Delete Random',
            'num_records' => 1,
            'execution_time' => $executionTime,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/')->with('message', "Deleted 1 random record in " . number_format($executionTime, 6) . " seconds.");
    }
}
