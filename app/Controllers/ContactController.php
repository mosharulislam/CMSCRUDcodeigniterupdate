<?php

namespace App\Controllers;

use App\Models\ContactModel;

class ContactController extends BaseController
{
    public function index()
    {
        $model = new ContactModel();
        $data['contacts'] = $model->findAll();

        return view('contacts/index', $data);
    }

    public function create()
    {
        return view('contacts/create');
    }

    public function store()
    {
        $model = new ContactModel();

        $data = [
            'name'  => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
        ];

        $model->save($data);
        return redirect()->to('/');
    }

    public function delete($id)
    {
        $model = new ContactModel();
        $model->delete($id);

        return redirect()->to('/');
    }
}
