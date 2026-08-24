<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventory Management System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeOut {
    from {
      opacity: 1;
      transform: translateY(0);
    }
    to {
      opacity: 0;
      transform: translateY(-10px);
    }
  }
  
  .page-transition-in {
    animation: fadeIn 0.4s ease-in-out forwards;
  }
  
  .page-transition-out {
    animation: fadeOut 0.4s ease-in-out forwards;
  }
  
  :root{
    --black: #0a0a0a;
    --panel: #17181a;
    --panel-border: #262729;
    --field: #1f2022;
    --field-border: #313234;
    --text-hi: #f4f4f3;
    --text-mid: #a8a8a8;
    --text-low: #6f7072;
    --red: #ff3b30;
    --red-dim: #7a1d18;
    --orange: #ff7a3d;
    --green: #34c759;
  }

  *{box-sizing:border-box; margin:0; padding:0;}

  html,body{
    height:100%;
    background:var(--black);
    font-family:'Inter', sans-serif;
    color:var(--text-hi);
    -webkit-font-smoothing:antialiased;
  }

  body{
    display:flex;
    flex-direction:column;
    min-height:100vh;
    opacity: 1;
  }

  .dashboard-container{
    display:flex;
    flex-direction:column;
    min-height:100vh;
    max-width:1400px;
    margin:0 auto;
    padding:32px;
    width:100%;
  }

  .header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:32px;
    padding-bottom:24px;
    border-bottom:1px solid var(--panel-border);
  }

  .header-left{
    display:flex;
    align-items:center;
    gap:16px;
  }

  .header-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:24px;
    font-weight:600;
    letter-spacing:-0.01em;
  }

  .header-right{
    display:flex;
    align-items:center;
    gap:12px;
  }

  .live-time{
    font-family:'Space Grotesk', sans-serif;
    font-size:14px;
    color:var(--text-mid);
    padding:8px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    animation:pulse 2s ease-in-out infinite;
  }

  @keyframes pulse{
    0%, 100%{ opacity:1; }
    50%{ opacity:0.7; }
  }

  .logout-btn{
    padding:8px 16px;
    background:var(--field);
    border:1px solid var(--field-border);
    color:var(--text-mid);
    text-decoration:none;
    font-size:13px;
    font-weight:500;
    border-radius:8px;
    transition:all 0.15s ease;
  }

  .logout-btn:hover{
    border-color:var(--red);
    color:var(--red);
  }

  .user-menu{
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    font-size:13px;
    color:var(--text-mid);
  }

  .user-avatar{
    width:32px;
    height:32px;
    border-radius:6px;
    background:linear-gradient(135deg, var(--red), var(--orange));
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:600;
    font-size:12px;
    color:var(--text-hi);
  }

  .stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
    gap:16px;
    margin-bottom:32px;
  }

  .stat-card{
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    padding:24px;
    transition:border-color .15s ease, transform .15s ease, box-shadow .15s ease;
    position:relative;
    overflow:hidden;
  }

  .stat-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:3px;
    background:linear-gradient(90deg, var(--red), var(--orange));
    opacity:0;
    transition:opacity .15s ease;
  }

  .stat-card:hover{
    border-color:var(--field-border);
    transform:translateY(-4px);
    box-shadow:0 8px 24px rgba(0,0,0,0.3);
  }

  .stat-card:hover::before{
    opacity:1;
  }

  .stat-label{
    font-size:12px;
    color:var(--text-low);
    letter-spacing:0.02em;
    text-transform:uppercase;
    margin-bottom:8px;
  }

  .stat-value{
    font-family:'Space Grotesk', sans-serif;
    font-size:32px;
    font-weight:600;
    color:var(--text-hi);
    margin-bottom:4px;
    transition:transform 0.3s ease;
  }

  .stat-value:hover{
    transform:scale(1.05);
  }

  .stat-change{
    font-size:13px;
    display:flex;
    align-items:center;
    gap:4px;
  }

  .stat-change.positive{
    color:var(--green);
  }

  .stat-change.negative{
    color:var(--red);
  }

  .stat-change.warning{
    color:var(--orange);
  }

  .card{
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    overflow:hidden;
  }

  .card-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:20px 24px;
    border-bottom:1px solid var(--panel-border);
  }

  .search-box{
    display:flex;
    align-items:center;
    gap:8px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    padding:8px 12px;
    transition:border-color .15s ease;
  }

  .search-box:focus-within{
    border-color:var(--red);
  }

  .search-box input{
    background:transparent;
    border:none;
    color:var(--text-hi);
    font-size:13px;
    font-family:inherit;
    outline:none;
    width:200px;
  }

  .search-box input::placeholder{
    color:var(--text-low);
  }

  .search-icon{
    color:var(--text-low);
    font-size:14px;
  }

  .card-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:16px;
    font-weight:600;
    color:var(--text-hi);
  }

  .card-actions{
    display:flex;
    gap:8px;
  }

  .action-btn{
    padding:6px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    color:var(--text-mid);
    font-size:12px;
    font-weight:500;
    border-radius:6px;
    cursor:pointer;
    transition:all 0.15s ease;
    font-family:inherit;
  }

  .action-btn:hover{
    border-color:var(--text-low);
    background:#232426;
    color:var(--text-hi);
  }

  .action-btn.primary{
    background:var(--text-hi);
    color:var(--black);
    border-color:var(--text-hi);
  }

  .action-btn.primary:hover{
    background:#fff;
  }

  .action-btn.danger{
    background:var(--red);
    color:var(--text-hi);
    border-color:var(--red);
  }

  .action-btn.danger:hover{
    background:var(--red-dim);
  }

  .table-container{
    overflow-x:auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .table-container::-webkit-scrollbar{
    display: none;
  }

  table{
    width:100%;
    border-collapse:collapse;
  }

  th{
    text-align:left;
    padding:12px 24px;
    font-size:12px;
    font-weight:500;
    color:var(--text-low);
    letter-spacing:0.02em;
    text-transform:uppercase;
    border-bottom:1px solid var(--panel-border);
  }

  td{
    padding:16px 24px;
    font-size:14px;
    color:var(--text-mid);
    border-bottom:1px solid var(--panel-border);
  }

  tr:last-child td{
    border-bottom:none;
  }

  tr:hover td{
    background:var(--field);
  }

  .status{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 10px;
    border-radius:12px;
    font-size:12px;
    font-weight:500;
  }

  .status.active{
    background:rgba(52,199,89,0.1);
    color:var(--green);
  }

  .status.inactive{
    background:var(--field);
    color:var(--text-low);
  }

  .status.low-stock{
    background:rgba(255,122,61,0.1);
    color:var(--orange);
  }

  .status-dot{
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
  }

  .product-image{
    width:48px;
    height:48px;
    border-radius:8px;
    object-fit:cover;
    background:var(--field);
    border:1px solid var(--field-border);
  }

  .product-image-placeholder{
    width:48px;
    height:48px;
    border-radius:8px;
    background:var(--field);
    border:1px solid var(--field-border);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    color:var(--text-low);
  }

  .full-width{
    grid-column: 1 / -1;
  }

  @media (max-width: 768px){
    .dashboard-container{
      padding:20px;
    }
    
    .header{
      flex-direction:column;
      align-items:flex-start;
      gap:16px;
    }
    
    .stats-grid{
      grid-template-columns:1fr;
    }
  }

  :focus-visible{
    outline:2px solid var(--red);
    outline-offset:2px;
  }

  @media (prefers-reduced-motion: reduce){
    .page-transition-in, .page-transition-out{
      animation:none;
    }
  }

  /* Modal Styles */
  .modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.8);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:1000;
    opacity:0;
    visibility:hidden;
    transition:opacity 0.3s ease, visibility 0.3s ease;
  }

  .modal-overlay.active{
    opacity:1;
    visibility:visible;
  }

  .modal{
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    padding:32px;
    max-width:600px;
    width:90%;
    max-height:90vh;
    overflow-y:auto;
    transform:scale(0.9);
    transition:transform 0.3s ease;
  }

  .modal-overlay.active .modal{
    transform:scale(1);
  }

  .modal-icon{
    font-size:48px;
    margin-bottom:16px;
  }

  .modal-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:20px;
    font-weight:600;
    color:var(--text-hi);
    margin-bottom:8px;
  }

  .modal-message{
    font-size:14px;
    color:var(--text-mid);
    line-height:1.5;
    margin-bottom:24px;
  }

  .form-group{
    margin-bottom:16px;
  }

  .form-label{
    display:block;
    font-size:12px;
    color:var(--text-low);
    letter-spacing:0.02em;
    text-transform:uppercase;
    margin-bottom:8px;
  }

  .form-input{
    width:100%;
    padding:10px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    color:var(--text-hi);
    font-size:14px;
    font-family:inherit;
    transition:border-color .15s ease;
  }

  .form-input:focus{
    outline:none;
    border-color:var(--red);
  }

  .form-input::placeholder{
    color:var(--text-low);
  }

  .form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
  }

  .form-select{
    width:100%;
    padding:10px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    color:var(--text-hi);
    font-size:14px;
    font-family:inherit;
    transition:border-color .15s ease;
  }

  .form-select:focus{
    outline:none;
    border-color:var(--red);
  }

  .form-textarea{
    width:100%;
    padding:10px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    color:var(--text-hi);
    font-size:14px;
    font-family:inherit;
    transition:border-color .15s ease;
    resize:vertical;
    min-height:80px;
  }

  .form-textarea:focus{
    outline:none;
    border-color:var(--red);
  }

  .image-preview{
    width:100%;
    height:150px;
    border:2px dashed var(--field-border);
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-top:8px;
    overflow:hidden;
    position:relative;
  }

  .image-preview img{
    width:100%;
    height:100%;
    object-fit:cover;
  }

  .image-preview-placeholder{
    color:var(--text-low);
    font-size:14px;
  }

  .modal-actions{
    display:flex;
    gap:12px;
    justify-content:flex-end;
    margin-top:24px;
  }

  .loading{
    opacity:0.5;
    pointer-events:none;
  }

  .error-message{
    color:var(--red);
    font-size:12px;
    margin-top:4px;
  }
</style>
</head>
<body id="admin-page">

  <div class="dashboard-container">
    <div class="header">
      <div class="header-left">
        <h1 class="header-title">📦 Inventory Management System</h1>
      </div>
      <div class="header-right">
        <div class="live-time" id="live-time">--:--:--</div>
        <div class="user-menu">
          <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
          <span>{{ auth()->user()->name }}</span>
        </div>
        <button type="button" class="logout-btn" id="logout-btn">Logout</button>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value" id="total-products">0</div>
        <div class="stat-change positive">
          <span>📦</span>
          <span style="color:var(--text-low)">In inventory</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Active Products</div>
        <div class="stat-value" id="active-products">0</div>
        <div class="stat-change positive">
          <span>✓</span>
          <span style="color:var(--text-low)">Currently available</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Low Stock Items</div>
        <div class="stat-value" id="low-stock-products">0</div>
        <div class="stat-change warning">
          <span>⚠️</span>
          <span style="color:var(--text-low)">Need restocking</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Total Stock Value</div>
        <div class="stat-value" id="total-stock-value">$0</div>
        <div class="stat-change positive">
          <span>💰</span>
          <span style="color:var(--text-low)">Inventory value</span>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h2 class="card-title">Products</h2>
        <div class="card-actions">
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search products..." id="product-search">
          </div>
          <button class="action-btn" id="filter-status">Filter Status</button>
          <button class="action-btn primary" id="add-product-btn">+ Add Product</button>
        </div>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Image</th>
              <th>SKU</th>
              <th>Name</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Stock</th>
              <th>Price</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="products-table-body">
            <tr>
              <td colspan="9" style="text-align: center; padding: 32px;">Loading products...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add/Edit Product Modal -->
  <div class="modal-overlay" id="product-modal">
    <div class="modal">
      <h3 class="modal-title" id="modal-title">Add Product</h3>
      <form id="product-form">
        <input type="hidden" id="product-id">
        
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">SKU *</label>
            <input type="text" class="form-input" id="product-sku" required>
          </div>
          <div class="form-group">
            <label class="form-label">Product Name *</label>
            <input type="text" class="form-input" id="product-name" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Category *</label>
            <input type="text" class="form-input" id="product-category" required>
          </div>
          <div class="form-group">
            <label class="form-label">Brand</label>
            <input type="text" class="form-input" id="product-brand">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Unit *</label>
            <input type="text" class="form-input" id="product-unit" value="pcs" required>
          </div>
          <div class="form-group">
            <label class="form-label">Status *</label>
            <select class="form-select" id="product-status" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Purchase Price *</label>
            <input type="number" step="0.01" class="form-input" id="product-purchase-price" required>
          </div>
          <div class="form-group">
            <label class="form-label">Selling Price *</label>
            <input type="number" step="0.01" class="form-input" id="product-selling-price" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Current Stock *</label>
            <input type="number" class="form-input" id="product-current-stock" required>
          </div>
          <div class="form-group">
            <label class="form-label">Min Stock Level *</label>
            <input type="number" class="form-input" id="product-min-stock" required>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Product Image</label>
          <input type="file" class="form-input" id="product-image" accept="image/*">
          <div class="image-preview" id="image-preview">
            <span class="image-preview-placeholder">No image selected</span>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Description</label>
          <textarea class="form-textarea" id="product-description"></textarea>
        </div>

        <div class="modal-actions">
          <button type="button" class="action-btn" id="cancel-product">Cancel</button>
          <button type="submit" class="action-btn primary" id="save-product">Save Product</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Product Modal -->
  <div class="modal-overlay" id="view-product-modal">
    <div class="modal">
      <h3 class="modal-title">Product Details</h3>
      <div id="product-details"></div>
      <div class="modal-actions">
        <button type="button" class="action-btn" id="close-view">Close</button>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal-overlay" id="delete-modal">
    <div class="modal">
      <div class="modal-icon">🗑️</div>
      <h3 class="modal-title">Confirm Delete</h3>
      <p class="modal-message">Are you sure you want to delete this product? This action cannot be undone.</p>
      <div class="modal-actions">
        <button type="button" class="action-btn" id="cancel-delete">Cancel</button>
        <button type="button" class="action-btn danger" id="confirm-delete">Delete</button>
      </div>
    </div>
  </div>

  <!-- Logout Confirmation Modal -->
  <div class="modal-overlay" id="logout-modal">
    <div class="modal">
      <div class="modal-icon">🔒</div>
      <h3 class="modal-title">Confirm Logout</h3>
      <p class="modal-message">Are you sure you want to log out? You will need to sign in again to access your account.</p>
      <div style="display: flex; gap: 12px; justify-content: center;">
        <button class="action-btn" id="cancel-logout">Cancel</button>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="action-btn primary">Logout</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Elements
      const liveTime = document.getElementById('live-time');
      const logoutBtn = document.getElementById('logout-btn');
      const logoutModal = document.getElementById('logout-modal');
      const cancelLogout = document.getElementById('cancel-logout');
      const addProductBtn = document.getElementById('add-product-btn');
      const productModal = document.getElementById('product-modal');
      const cancelProduct = document.getElementById('cancel-product');
      const productForm = document.getElementById('product-form');
      const productsTableBody = document.getElementById('products-table-body');
      const productSearch = document.getElementById('product-search');
      const viewProductModal = document.getElementById('view-product-modal');
      const closeView = document.getElementById('close-view');
      const deleteModal = document.getElementById('delete-modal');
      const cancelDelete = document.getElementById('cancel-delete');
      const confirmDelete = document.getElementById('confirm-delete');
      const productImage = document.getElementById('product-image');
      const imagePreview = document.getElementById('image-preview');

      let currentDeleteId = null;
      let products = [];

      // Live time update
      function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
          hour12: false, 
          hour: '2-digit', 
          minute: '2-digit', 
          second: '2-digit' 
        });
        liveTime.textContent = timeString;
      }
      
      updateTime();
      setInterval(updateTime, 1000);

      // Load products
      async function loadProducts() {
        try {
          const response = await fetch('/products');
          const data = await response.json();
          if (data.success) {
            products = data.products;
            renderProducts(products);
            loadStats();
          }
        } catch (error) {
          console.error('Error loading products:', error);
        }
      }

      // Load stats
      async function loadStats() {
        try {
          const response = await fetch('/products/stats');
          const data = await response.json();
          if (data.success) {
            document.getElementById('total-products').textContent = data.stats.total_products;
            document.getElementById('active-products').textContent = data.stats.active_products;
            document.getElementById('low-stock-products').textContent = data.stats.low_stock_products;
            document.getElementById('total-stock-value').textContent = '$' + data.stats.total_stock_value.toFixed(2);
          }
        } catch (error) {
          console.error('Error loading stats:', error);
        }
      }

      // Render products table
      function renderProducts(productsToRender) {
        if (productsToRender.length === 0) {
          productsTableBody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 32px;">No products found</td></tr>';
          return;
        }

        productsTableBody.innerHTML = productsToRender.map(product => `
          <tr data-id="${product.id}">
            <td>
              ${product.image 
                ? `<img src="/storage/${product.image}" class="product-image" alt="${product.name}">`
                : `<div class="product-image-placeholder">📦</div>`
              }
            </td>
            <td>${product.sku}</td>
            <td>${product.name}</td>
            <td>${product.category}</td>
            <td>${product.brand || '-'}</td>
            <td>
              <span class="status ${product.current_stock <= product.minimum_stock_level ? 'low-stock' : 'active'}">
                ${product.current_stock} ${product.unit}
              </span>
            </td>
            <td>$${product.selling_price.toFixed(2)}</td>
            <td>
              <span class="status ${product.status}">
                <span class="status-dot"></span>${product.status}
              </span>
            </td>
            <td>
              <button class="action-btn" onclick="viewProduct(${product.id})">View</button>
              <button class="action-btn" onclick="editProduct(${product.id})">Edit</button>
              <button class="action-btn danger" onclick="deleteProduct(${product.id})">Delete</button>
            </td>
          </tr>
        `).join('');
      }

      // Image preview
      productImage.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
          };
          reader.readAsDataURL(file);
        } else {
          imagePreview.innerHTML = '<span class="image-preview-placeholder">No image selected</span>';
        }
      });

      // Add product modal
      addProductBtn.addEventListener('click', function() {
        document.getElementById('modal-title').textContent = 'Add Product';
        productForm.reset();
        document.getElementById('product-id').value = '';
        imagePreview.innerHTML = '<span class="image-preview-placeholder">No image selected</span>';
        productModal.classList.add('active');
      });

      cancelProduct.addEventListener('click', function() {
        productModal.classList.remove('active');
      });

      // Save product
      productForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        const productId = document.getElementById('product-id').value;
        
        formData.append('sku', document.getElementById('product-sku').value);
        formData.append('name', document.getElementById('product-name').value);
        formData.append('category', document.getElementById('product-category').value);
        formData.append('brand', document.getElementById('product-brand').value);
        formData.append('unit', document.getElementById('product-unit').value);
        formData.append('purchase_price', document.getElementById('product-purchase-price').value);
        formData.append('selling_price', document.getElementById('product-selling-price').value);
        formData.append('current_stock', document.getElementById('product-current-stock').value);
        formData.append('minimum_stock_level', document.getElementById('product-min-stock').value);
        formData.append('status', document.getElementById('product-status').value);
        formData.append('description', document.getElementById('product-description').value);
        
        if (productImage.files[0]) {
          formData.append('image', productImage.files[0]);
        }

        try {
          const url = productId ? `/products/${productId}` : '/products';
          
          if (productId) {
            formData.append('_method', 'PUT');
          }
          formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
          
          const response = await fetch(url, {
            method: 'POST',
            body: formData
          });
          
          const data = await response.json();
          
          if (data.success) {
            productModal.classList.remove('active');
            loadProducts();
          } else {
            alert('Error: ' + (data.message || 'Failed to save product'));
          }
        } catch (error) {
          console.error('Error saving product:', error);
          alert('Error: Failed to save product');
        }
      });

      // View product
      window.viewProduct = async function(id) {
        try {
          const response = await fetch(`/products/${id}`);
          const data = await response.json();
          
          if (data.success) {
            const product = data.product;
            document.getElementById('product-details').innerHTML = `
              <div style="margin-bottom: 16px;">
                ${product.image 
                  ? `<img src="/storage/${product.image}" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px;">`
                  : `<div style="width: 100%; height: 200px; background: var(--field); border: 1px solid var(--field-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 40px;">📦</div>`
                }
              </div>
              <div class="form-row">
                <div><strong>SKU:</strong> ${product.sku}</div>
                <div><strong>Name:</strong> ${product.name}</div>
              </div>
              <div class="form-row">
                <div><strong>Category:</strong> ${product.category}</div>
                <div><strong>Brand:</strong> ${product.brand || '-'}</div>
              </div>
              <div class="form-row">
                <div><strong>Unit:</strong> ${product.unit}</div>
                <div><strong>Status:</strong> ${product.status}</div>
              </div>
              <div class="form-row">
                <div><strong>Purchase Price:</strong> $${product.purchase_price.toFixed(2)}</div>
                <div><strong>Selling Price:</strong> $${product.selling_price.toFixed(2)}</div>
              </div>
              <div class="form-row">
                <div><strong>Current Stock:</strong> ${product.current_stock} ${product.unit}</div>
                <div><strong>Min Stock Level:</strong> ${product.minimum_stock_level} ${product.unit}</div>
              </div>
              ${product.description ? `<div style="margin-top: 16px;"><strong>Description:</strong><br>${product.description}</div>` : ''}
            `;
            viewProductModal.classList.add('active');
          }
        } catch (error) {
          console.error('Error viewing product:', error);
        }
      };

      // Edit product
      window.editProduct = async function(id) {
        try {
          const response = await fetch(`/products/${id}`);
          const data = await response.json();
          
          if (data.success) {
            const product = data.product;
            document.getElementById('modal-title').textContent = 'Edit Product';
            document.getElementById('product-id').value = product.id;
            document.getElementById('product-sku').value = product.sku;
            document.getElementById('product-name').value = product.name;
            document.getElementById('product-category').value = product.category;
            document.getElementById('product-brand').value = product.brand || '';
            document.getElementById('product-unit').value = product.unit;
            document.getElementById('product-purchase-price').value = product.purchase_price;
            document.getElementById('product-selling-price').value = product.selling_price;
            document.getElementById('product-current-stock').value = product.current_stock;
            document.getElementById('product-min-stock').value = product.minimum_stock_level;
            document.getElementById('product-status').value = product.status;
            document.getElementById('product-description').value = product.description || '';
            
            if (product.image) {
              imagePreview.innerHTML = `<img src="/storage/${product.image}" alt="Current image">`;
            } else {
              imagePreview.innerHTML = '<span class="image-preview-placeholder">No image selected</span>';
            }
            
            productModal.classList.add('active');
          }
        } catch (error) {
          console.error('Error loading product:', error);
        }
      };

      // Delete product
      window.deleteProduct = function(id) {
        currentDeleteId = id;
        deleteModal.classList.add('active');
      };

      cancelDelete.addEventListener('click', function() {
        deleteModal.classList.remove('active');
        currentDeleteId = null;
      });

      confirmDelete.addEventListener('click', async function() {
        if (currentDeleteId) {
          try {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            const response = await fetch(`/products/${currentDeleteId}`, {
              method: 'POST',
              body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
              deleteModal.classList.remove('active');
              currentDeleteId = null;
              loadProducts();
            } else {
              alert('Error: ' + (data.message || 'Failed to delete product'));
            }
          } catch (error) {
            console.error('Error deleting product:', error);
            alert('Error: Failed to delete product');
          }
        }
      });

      closeView.addEventListener('click', function() {
        viewProductModal.classList.remove('active');
      });

      // Search functionality
      productSearch.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredProducts = products.filter(product => 
          product.name.toLowerCase().includes(searchTerm) ||
          product.sku.toLowerCase().includes(searchTerm) ||
          product.category.toLowerCase().includes(searchTerm) ||
          (product.brand && product.brand.toLowerCase().includes(searchTerm))
        );
        renderProducts(filteredProducts);
      });

      // Logout confirmation
      logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        logoutModal.classList.add('active');
      });

      cancelLogout.addEventListener('click', function(e) {
        e.preventDefault();
        logoutModal.classList.remove('active');
      });

      logoutModal.addEventListener('click', function(e) {
        if (e.target === logoutModal) {
          logoutModal.classList.remove('active');
        }
      });

      // Close modals when clicking outside
      [productModal, viewProductModal, deleteModal].forEach(modal => {
        modal.addEventListener('click', function(e) {
          if (e.target === modal) {
            modal.classList.remove('active');
          }
        });
      });

      // Initial load
      loadProducts();

      // Page transition
      document.body.classList.add('page-transition-in');
    });
  </script>
</body>
</html>