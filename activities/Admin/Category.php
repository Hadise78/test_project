<?php


namespace Admin;

use database\Admin;
use database\DataBase;

class Category extends Admin
{
    private DataBase $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = new DataBase();
    }

    public function index()
    {
        $categories = $this->db->select("SELECT * FROM categories ORDER BY `id` DESC");

        require_once(BASE_PATH . '/template/admin/categories/index.php');
    }

    public function create()
    {
        require_once(BASE_PATH . '/template/admin/categories/create.php');
    }

    public function store($request)
    {
        $this->db->insert('categories', array_keys($request), $request);

        $this->redirect('admin/category');

        dd('residam inja');

    }

    public function edit($id)
    {
        $category = $this->db->select("SELECT * FROM `categories` WHERE id=?;", [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/categories/edit.php');
    }

    public function update($request, $id)
    {
        $this->db->update('categories', $id, array_keys($request), $request);
        $this->redirect('admin/category');
    }

    public function delete($id)
    {
        $this->db->delete('categories', $id);
        $this->redirect('admin/category');
    }
}
