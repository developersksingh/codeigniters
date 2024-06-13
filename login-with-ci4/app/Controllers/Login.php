<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
    protected $db;

    public function __construct()
    {
        // Load the database service through dependency injection
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $postData = $this->request->getPost(); // Get all POST data
    
        // Check if username and password keys exist in the POST data
        if (isset($postData['username'], $postData['password'])) {
            $username = $postData['username'];
            $password = $postData['password'];
    
            // Accessing the database service
            $user = $this->db->table('users')
                             ->where('username', $username)
                             ->get()
                             ->getRow();
           
            if ($user && password_verify($password, $user->password)) {
                // Redirect to login page with success message
                return redirect()->to('dashboard')->with('success', 'Login successful.');
            } else {
                // Redirect back to registration page with error message
                return redirect()->to('login')->withInput()->with('error', 'user email or Password incorrect. Please try again.');
            }
        } else {
            return redirect()->to('login')->withInput()->with('error', 'user & password has empty value');
        }
    }
    
}
