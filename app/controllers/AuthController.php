<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->session = $this->call->library('session');
        $this->call->database();
        $this->call->model('UserModel');
    }

    public function login()
    {
        if ($this->io->method() === 'post') {
            $username = trim((string) $this->io->post('username'));
            $password = (string) $this->io->post('password');
            $user = $this->UserModel->find_by('username', $username);

            if ($user && password_verify($password, $user['password'])) {
                $this->session->regenerate_on_login();
                $this->session->set_userdata([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'logged_in' => true,
                ]);
                redirect('products');
                return;
            }

            $this->session->set_flashdata('error', 'Invalid username or password.');
        }

        $this->call->view('auth/login', [
            'error' => $this->session->flashdata('error'),
            'success' => $this->session->flashdata('success'),
        ]);
    }

    public function register()
    {
        if ($this->io->method() === 'post') {
            $username = trim((string) $this->io->post('username'));
            $email = trim((string) $this->io->post('email'));
            $password = (string) $this->io->post('password');

            if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
                $this->session->set_flashdata('error', 'Enter a valid email and a password with at least 6 characters.');
            } elseif ($this->UserModel->find_by('username', $username) || $this->UserModel->find_by('email', $email)) {
                $this->session->set_flashdata('error', 'Username or email is already registered.');
            } else {
                $this->UserModel->insert([
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'user',
                    'is_active' => 1,
                ]);
                $this->session->set_flashdata('success', 'Account created. You can now log in.');
                redirect('login');
                return;
            }
        }

        $this->call->view('auth/register', [
            'error' => $this->session->flashdata('error'),
        ]);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
