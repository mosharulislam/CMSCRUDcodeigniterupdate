<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts'; // Table name
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['name', 'phone', 'email', 'created_at']; // Fields you can insert/update
}
