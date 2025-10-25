<?php
// app/controllers/MenuController.php

class MenuController extends Controller {
    private $menuModel;
    
    public function __construct() {
        parent::__construct();
        $this->menuModel = new MenuModel();
    }
    
    public function index() {
        // Get all products grouped by category
        $products = $this->menuModel->getAllProducts();
        $categories = $this->menuModel->getCategories();
        
        // Group products by category for the view
        $groupedProducts = [];
        foreach ($products as $product) {
            $groupedProducts[$product['category']][] = $product;
        }
        
        $data = [
            'title' => 'Menu - Bille Southside',
            'groupedProducts' => $groupedProducts,
            'categories' => $categories,
            'activeNav' => 'menu',
            'current_route' => 'menu'
        ];
        
        $this->view('menu/index', $data);
    }
    
    public function category($category) {
        $validCategories = ['food', 'beverage', 'snack', 'merchandise'];
        
        if (!in_array($category, $validCategories)) {
            $this->redirect('menu');
            return;
        }
        
        $products = $this->menuModel->getProductsByCategory($category);
        $categoryName = $this->getCategoryDisplayName($category);
        
        $data = [
            'title' => $categoryName . ' - Bille Southside',
            'products' => $products,
            'categoryName' => $categoryName,
            'currentCategory' => $category,
            'activeNav' => 'menu',
            'current_route' => 'menu'
        ];
        
        $this->view('menu/category', $data);
    }
    
    public function merchandise() {
        $products = $this->menuModel->getMerchandise();
        
        $data = [
            'title' => 'Merchandise - Bille Southside',
            'products' => $products,
            'categoryName' => 'Bille Merchandise',
            'currentCategory' => 'merchandise',
            'activeNav' => 'menu',
            'current_route' => 'menu'
        ];
        
        $this->view('menu/merchandise', $data);
    }
    
    public function apiGetProducts() {
        $category = $_GET['category'] ?? '';
        
        if ($category) {
            $products = $this->menuModel->getProductsByCategory($category);
        } else {
            $products = $this->menuModel->getAllProducts();
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }
    
    public function apiGetProduct($productId) {
        $product = $this->menuModel->getProductById($productId);
        
        header('Content-Type: application/json');
        if ($product) {
            echo json_encode([
                'success' => true,
                'data' => $product
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
    }
    
    /**
     * Method untuk mendapatkan detail produk (halaman single product)
     */
    public function show($productId) {
        // Handle parameter (bisa string atau array)
        if (is_array($productId)) {
            $productId = $productId[0];
        }
        
        $product = $this->menuModel->getProductById($productId);
        
        if (!$product) {
            $_SESSION['menu_error'] = 'Product not found';
            $this->redirect('menu');
            return;
        }
        
        $data = [
            'title' => $product['name'] . ' - Bille Southside',
            'product' => $product,
            'activeNav' => 'menu',
            'current_route' => 'menu'
        ];
        
        $this->view('menu/show', $data);
    }
    
    /**
     * Method untuk pencarian produk
     */
    public function search() {
        $query = $_GET['q'] ?? '';
        
        if (empty($query)) {
            $this->redirect('menu');
            return;
        }
        
        $products = $this->menuModel->searchProducts($query);
        
        $data = [
            'title' => 'Search: ' . htmlspecialchars($query) . ' - Bille Southside',
            'products' => $products,
            'searchQuery' => $query,
            'activeNav' => 'menu',
            'current_route' => 'menu'
        ];
        
        $this->view('menu/search', $data);
    }
    
    private function getCategoryDisplayName($category) {
        $names = [
            'food' => '🍔 Food & Meals',
            'beverage' => '🥤 Beverages & Drinks', 
            'snack' => '🍿 Snacks & Sides',
            'merchandise' => '🛍️ Bille Merchandise'
        ];
        
        return $names[$category] ?? ucfirst($category);
    }
}
?>