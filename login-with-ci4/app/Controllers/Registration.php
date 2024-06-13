<?php

namespace App\Controllers;

use App\Models\AuthenticateModel;
use CodeIgniter\Controller;

class Registration extends Controller
{
    protected $authenticateModel;

    public function __construct()
    {
        // Load the AuthenticateModel in the constructor
        $this->authenticateModel = new AuthenticateModel();
    }

    public function index()
    {
        return view('registration');
    }

    public function create()
    {
        // Validate input data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'password' => 'required|min_length[8]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed, redirect back to registration page with errors
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Create user
        $password = $this->request->getPost('password') ? $this->request->getPost('password') : "";
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            // Add more fields as needed
        ];
        
        // Call the createUser method of the AuthenticateModel
        $created = $this->authenticateModel->createUser($data);

        if ($created) {
            // Redirect to login page with success message
            return redirect()->to('registration')->with('success', 'Registration successful. Please login.');
        } else {
            // Redirect back to registration page with error message
            return redirect()->to('registration')->withInput()->with('error', 'Failed to register user. Please try again.');
        }
    }
}
