<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->session = $this->call->library('session');
        $this->call->database();
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $this->call->view('products/index', [
            'products' => $this->ProductModel->all_products(),
            'message' => $this->session->flashdata('message'),
        ]);
    }

    public function create()
    {
        if ($this->io->method() === 'post') {
            $data = $this->_product_data();
            if ($this->_valid($data)) {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->ProductModel->insert($data);
                $this->session->set_flashdata('message', 'Product added successfully.');
                redirect('products');
                return;
            }
            $error = 'Product name, price, and a non-negative quantity are required.';
        }

        $this->call->view('products/form', [
            'product' => null,
            'error' => $error ?? null,
            'heading' => 'Add product',
            'action' => site_url('products/create'),
        ]);
    }

    public function edit($id)
    {
        $product = $this->ProductModel->find((int) $id);
        if (!$product) {
            show_404();
            return;
        }

        if ($this->io->method() === 'post') {
            $data = $this->_product_data();
            if ($this->_valid($data)) {
                $this->ProductModel->update((int) $id, $data);
                $this->session->set_flashdata('message', 'Product updated successfully.');
                redirect('products');
                return;
            }
            $error = 'Product name, price, and a non-negative quantity are required.';
            $product = array_merge($product, $data);
        }

        $this->call->view('products/form', [
            'product' => $product,
            'error' => $error ?? null,
            'heading' => 'Edit product',
            'action' => site_url('products/edit/' . (int) $id),
        ]);
    }

    public function delete($id)
    {
        $this->ProductModel->delete((int) $id);
        $this->session->set_flashdata('message', 'Product deleted successfully.');
        redirect('products');
    }

    private function _product_data()
    {
        return [
            'product_name' => trim((string) $this->io->post('product_name')),
            'description' => trim((string) $this->io->post('description')),
            'price' => (float) $this->io->post('price'),
            'quantity' => (int) $this->io->post('quantity'),
        ];
    }

    private function _valid($data)
    {
        return $data['product_name'] !== '' && $data['price'] >= 0 && $data['quantity'] >= 0;
    }
}
