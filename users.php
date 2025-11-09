<?php
session_start();

// Cek login — kalau belum login, langsung arahkan ke halaman login
if (!isset($_SESSION['admin'])) {
  header("Location: ../auth/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users | BM Garage</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f8faff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding-bottom: 90px;
    }

    header {
      background: linear-gradient(135deg, #0022a8, #0044ff);
      color: #fff;
      padding: 80px 20px 60px;
      border-bottom-left-radius: 30px;
      border-bottom-right-radius: 30px;
      position: relative;
      overflow: visible;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 200px;
    }

    .page-title {
      font-size: 2.5rem;
      font-weight: 700;
      text-align: center;
      letter-spacing: 1px;
    }

    /* Search Container */
    .search-container {
      padding: 0 20px;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .search-box {
      background: #fff;
      border-radius: 15px;
      width: 100%;
      box-shadow: 0 6px 25px rgba(0,0,0,0.15);
      display: flex;
      align-items: center;
      padding: 12px 16px;
      border: 1px solid #e8f0ff;
    }

    .search-box input {
      border: none;
      outline: none;
      flex: 1;
      padding: 10px;
      font-size: 0.95rem;
      color: #333;
      background: transparent;
    }

    .search-box i {
      color: #666;
      margin-right: 8px;
      font-size: 1rem;
    }

    .content {
      padding: 20px 20px 100px;
      flex: 1;
    }

    .section-title {
      font-size: 1.1rem;
      margin-bottom: 20px;
      color: #333;
      font-weight: 600;
    }

    .user-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .user-item {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      display: flex;
      align-items: center;
      gap: 15px;
      transition: all 0.3s ease;
      border: 1px solid #f0f4ff;
    }

    .user-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .user-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: linear-gradient(135deg, #667eea, #764ba2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.1rem;
      font-weight: 600;
      border: 3px solid #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .user-avatar.avatar-2 {
      background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .user-avatar.avatar-3 {
      background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .user-avatar.avatar-4 {
      background: linear-gradient(135deg, #43e97b, #38f9d7);
    }

    .user-avatar.avatar-5 {
      background: linear-gradient(135deg, #fa709a, #fee140);
    }

    .user-info-list {
      flex: 1;
    }

    .user-name {
      font-weight: 600;
      color: #333;
      margin-bottom: 5px;
      font-size: 1rem;
    }

    .user-role {
      font-size: 0.85rem;
      color: #666;
      background: #f8faff;
      padding: 4px 10px;
      border-radius: 8px;
      display: inline-block;
      border: 1px solid #e8f0ff;
    }

    .user-status {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 8px;
    }

    .status-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #00c853;
    }

    .status-text {
      font-size: 0.8rem;
      color: #666;
    }

    .user-action {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      background: #f8faff;
      border: none;
      border-radius: 8px;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #666;
      transition: all 0.3s ease;
      font-size: 0.9rem;
    }

    .action-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .more-btn:hover {
      background: #666;
      color: white;
    }

    /* Floating Add Button */
    .floating-add-btn {
      position: fixed;
      right: 25px;
      bottom: 100px;
      background: #2455ff;
      color: white;
      border: none;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(36, 85, 255, 0.4);
      z-index: 99;
      transition: all 0.3s ease;
    }

    .floating-add-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 8px 25px rgba(36, 85, 255, 0.6);
    }

    /* ===== MENU BAWAH ===== */
    .bottom-nav {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: #ffffff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 380px;
      padding: 8px;
      border-radius: 50px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      z-index: 100;
    }

    .bottom-nav a {
      flex: 1;
      text-align: center;
      color: #2455ff;
      text-decoration: none;
      font-weight: 600;
      border-radius: 40px;
      padding: 10px 0;
      font-size: 14px;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .bottom-nav a i {
      font-size: 20px;
      margin-bottom: 3px;
    }

    .bottom-nav a.active {
      background: #2455ff;
      color: #fff;
      box-shadow: 0 4px 15px rgba(36,85,255,0.4);
    }

    .bottom-nav a:hover {
      transform: scale(1.08);
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 450px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .modal-header h3 {
      color: #333;
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 8px;
    }

    .modal-header p {
      color: #666;
      font-size: 0.9rem;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .form-group input {
      width: 100%;
      padding: 15px;
      border: 2px solid #e8f0ff;
      border-radius: 12px;
      font-size: 1rem;
      background: #f8faff;
      transition: all 0.3s;
    }

    .form-group input:focus {
      outline: none;
      border-color: #2455ff;
      box-shadow: 0 0 0 3px rgba(36, 85, 255, 0.1);
      background: white;
    }

    .form-row {
      display: flex;
      gap: 15px;
    }

    .form-row .form-group {
      flex: 1;
    }

    .phone-input {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .phone-prefix {
      background: #f0f4ff;
      padding: 15px;
      border-radius: 12px;
      color: #2455ff;
      font-weight: 600;
      min-width: 70px;
      text-align: center;
      border: 2px solid #e8f0ff;
      font-size: 1rem;
    }

    .phone-input input {
      flex: 1;
    }

    .password-toggle {
      position: relative;
    }

    .password-toggle input {
      padding-right: 50px;
    }

    .toggle-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      cursor: pointer;
      background: none;
      border: none;
      font-size: 1rem;
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      gap: 15px;
    }

    .btn {
      padding: 16px 30px;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      flex: 1;
      font-size: 1rem;
      font-weight: 700;
    }

    .btn-cancel {
      background: #f0f0f0;
      color: #666;
    }

    .btn-cancel:hover {
      background: #e0e0e0;
      transform: translateY(-2px);
    }

    .btn-save {
      background: #2455ff;
      color: white;
    }

    .btn-save:hover {
      background: #1a45e0;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(36, 85, 255, 0.4);
    }

    /* Success notification */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #00c853;
      color: white;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      z-index: 1000;
      display: flex;
      align-items: center;
      gap: 10px;
      transform: translateX(150%);
      transition: transform 0.3s ease;
    }

    .notification.show {
      transform: translateX(0);
    }

    .notification i {
      font-size: 1.2rem;
    }

    /* No results state */
    .no-results {
      text-align: center;
      padding: 40px 20px;
      color: #666;
    }

    .no-results i {
      font-size: 3rem;
      color: #ddd;
      margin-bottom: 15px;
    }

    .no-results p {
      margin-bottom: 10px;
    }

    /* Placeholder styling */
    input::placeholder {
      color: #999;
      font-weight: 400;
    }

    /* Delete confirmation modal */
    .delete-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .delete-modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      text-align: center;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .delete-modal h3 {
      color: #333;
      margin-bottom: 15px;
      font-size: 1.3rem;
    }

    .delete-modal p {
      color: #666;
      margin-bottom: 25px;
    }

    .delete-actions {
      display: flex;
      gap: 15px;
      justify-content: center;
    }

    .btn-delete {
      background: #f44336;
      color: white;
    }

    .btn-delete:hover {
      background: #d32f2f;
    }
  </style>
</head>
<body>

  <header>
    <div class="page-title">Users</div>
  </header>

  <!-- Success Notification -->
  <div class="notification" id="successNotification">
    <i class="fas fa-check-circle"></i>
    <span id="notificationText">User berhasil ditambahkan!</span>
  </div>

  <!-- Search Container -->
  <div class="search-container">
    <div class="search-box">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Search" id="searchInput" />
    </div>
  </div>

  <div class="content">
    <h2 class="section-title">Users</h2>

    <div class="user-list" id="userList">
      <!-- User list will be populated here -->
    </div>
  </div>

  <!-- Floating Add Button -->
  <button class="floating-add-btn" id="addUserBtn">+</button>

  <!-- Add User Modal -->
  <div class="modal" id="addUserModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Add User</h3>
      </div>
      
      <form id="addUserForm">
        <!-- First Name -->
        <div class="form-group">
          <label for="firstName">First name</label>
          <input type="text" id="firstName" placeholder="first" required>
        </div>

        <!-- Last Name -->
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" placeholder="last" required>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label for="userEmail">Email Address</label>
          <input type="email" id="userEmail" placeholder="email@example.com" required>
        </div>

        <div class="form-row">
          <!-- Phone Number -->
          <div class="form-group">
            <label for="phoneNumber">Phone</label>
            <div class="phone-input">
              <div class="phone-prefix">+62</div>
              <input type="tel" id="phoneNumber" placeholder="2XXXXXXX" required>
            </div>
          </div>

          <!-- Date of Birth -->
          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" required>
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password">Password</label>
          <div class="password-toggle">
            <input type="password" id="password" placeholder="Password" required>
            <button type="button" class="toggle-icon" id="togglePassword">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
          <label for="confirmPassword">Re-Password</label>
          <div class="password-toggle">
            <input type="password" id="confirmPassword" placeholder="Password" required>
            <button type="button" class="toggle-icon" id="toggleConfirmPassword">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-cancel" id="cancelBtn">Cancel</button>
          <button type="submit" class="btn btn-save">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="delete-modal" id="deleteModal">
    <div class="delete-modal-content">
      <h3>Delete User</h3>
      <p>Are you sure you want to delete this user? This action cannot be undone.</p>
      <div class="delete-actions">
        <button class="btn btn-cancel" id="cancelDeleteBtn">Cancel</button>
        <button class="btn btn-delete" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>

  <!-- ===== MENU BAWAH ===== -->
  <div class="bottom-nav">
    <a href="dashboard.php">
      <i class="fas fa-home"></i>
      <span>Home</span>
    </a>
    <a href="tasks.php">
      <i class="fas fa-tasks"></i>
      <span>Tasks</span>
    </a>
    <a href="users.php" class="active">
      <i class="fas fa-users"></i>
      <span>Users</span>
    </a>
    <a href="profile.php">
      <i class="fas fa-user-circle"></i>
      <span>Profile</span>
    </a>
  </div>

  <script>
    // Data pengguna utama - menggunakan key universal yang tidak tergantung user login
    let users = [];
    const STORAGE_KEY = 'bmGarageUsers_global'; // Key universal untuk semua user

    // DOM Elements
    const userList = document.getElementById('userList');
    const searchInput = document.getElementById('searchInput');
    const addUserBtn = document.getElementById('addUserBtn');
    const addUserModal = document.getElementById('addUserModal');
    const addUserForm = document.getElementById('addUserForm');
    const cancelBtn = document.getElementById('cancelBtn');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const successNotification = document.getElementById('successNotification');
    const notificationText = document.getElementById('notificationText');
    const deleteModal = document.getElementById('deleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    let userToDelete = null;

    // Fungsi untuk menyimpan data ke localStorage dengan key universal
    function saveUsersToStorage() {
      try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(users));
        console.log('✅ Data users disimpan permanen di localStorage');
      } catch (error) {
        console.error('❌ Gagal menyimpan data users:', error);
      }
    }

    // Fungsi untuk memuat data dari localStorage dengan key universal
    function loadUsersFromStorage() {
      try {
        const storedUsers = localStorage.getItem(STORAGE_KEY);
        if (storedUsers) {
          users = JSON.parse(storedUsers);
          console.log('✅ Data users dimuat dari localStorage:', users.length + ' users');
        } else {
          // Data default jika tidak ada data di localStorage
          users = [
            { 
              id: 1, 
              name: "Aditya Pratama", 
              role: "Frontend Developer",
              initial: "A",
              status: "Online",
              avatarClass: "",
              email: "aditya@example.com",
              phone: "+628123456789",
              dob: "1990-01-15",
              createdAt: new Date().toISOString()
            },
            { 
              id: 2, 
              name: "Dimas Nugroho", 
              role: "Backend Developer",
              initial: "D",
              status: "Online",
              avatarClass: "avatar-2",
              email: "dimas@example.com",
              phone: "+628234567890",
              dob: "1992-05-20",
              createdAt: new Date().toISOString()
            },
            { 
              id: 3, 
              name: "Bima Putra", 
              role: "UI/UX Designer",
              initial: "B",
              status: "Offline",
              avatarClass: "avatar-3",
              email: "bima@example.com",
              phone: "+628345678901",
              dob: "1991-08-10",
              createdAt: new Date().toISOString()
            }
          ];
          saveUsersToStorage(); // Simpan data default ke localStorage
          console.log('✅ Data default users dibuat dan disimpan');
        }
      } catch (error) {
        console.error('❌ Gagal memuat data users:', error);
        users = [];
      }
    }

    // Fungsi untuk menampilkan notifikasi sukses
    function showSuccessNotification(message) {
      notificationText.textContent = message;
      successNotification.classList.add('show');
      setTimeout(() => {
        successNotification.classList.remove('show');
      }, 3000);
    }

    // Fungsi untuk menampilkan daftar pengguna utama
    function displayUsers(userArray) {
      userList.innerHTML = '';
      
      if (userArray.length === 0) {
        userList.innerHTML = `
          <div class="no-results">
            <i class="fas fa-search"></i>
            <p>No users found</p>
            <p>Try adjusting your search</p>
          </div>
        `;
        return;
      }
      
      userArray.forEach((user) => {
        const userItem = document.createElement('div');
        userItem.className = 'user-item';
        userItem.setAttribute('data-user-id', user.id);
        
        userItem.innerHTML = `
          <div class="user-avatar ${user.avatarClass}">${user.initial}</div>
          <div class="user-info-list">
            <div class="user-name">${user.name}</div>
            <div class="user-role">${user.role}</div>
            <div class="user-status">
              <div class="status-dot" style="background: ${user.status === 'Online' ? '#00c853' : '#999'}"></div>
              <div class="status-text">${user.status}</div>
            </div>
          </div>
          <div class="user-action">
            <button class="action-btn more-btn" onclick="showDeleteConfirmation(${user.id})">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        `;
        
        userList.appendChild(userItem);
      });
    }

    // Fungsi untuk mencari pengguna
    function searchUsers() {
      const searchTerm = searchInput.value.toLowerCase();
      const filteredUsers = users.filter(user => 
        user.name.toLowerCase().includes(searchTerm) || 
        user.role.toLowerCase().includes(searchTerm) ||
        user.email.toLowerCase().includes(searchTerm)
      );
      displayUsers(filteredUsers);
    }

    // Fungsi untuk menambahkan pengguna baru
    function addUser(userData) {
      const newUser = {
        id: users.length > 0 ? Math.max(...users.map(u => u.id)) + 1 : 1,
        name: `${userData.firstName} ${userData.lastName}`,
        role: "Team Member",
        initial: userData.firstName.charAt(0).toUpperCase(),
        status: "Online",
        avatarClass: `avatar-${(users.length % 5) + 1}`,
        email: userData.email,
        phone: userData.phone,
        dob: userData.dob,
        createdAt: new Date().toISOString()
      };
      
      users.push(newUser);
      saveUsersToStorage(); // Simpan ke localStorage
      displayUsers(users);
      closeModal();
      showSuccessNotification('User berhasil ditambahkan!');
    }

    // Fungsi untuk menghapus pengguna
    function deleteUser(userId) {
      users = users.filter(user => user.id !== userId);
      saveUsersToStorage(); // Simpan perubahan ke localStorage
      displayUsers(users);
      closeDeleteModal();
      showSuccessNotification('User berhasil dihapus!');
    }

    // Fungsi untuk membuka modal
    function openModal() {
      addUserModal.style.display = 'flex';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
      addUserModal.style.display = 'none';
      addUserForm.reset();
    }

    // Fungsi untuk konfirmasi hapus
    function showDeleteConfirmation(userId) {
      userToDelete = userId;
      deleteModal.style.display = 'flex';
    }

    // Fungsi untuk menutup modal hapus
    function closeDeleteModal() {
      deleteModal.style.display = 'none';
      userToDelete = null;
    }

    // Password toggle functionality
    togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      togglePassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    toggleConfirmPassword.addEventListener('click', () => {
      const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPasswordInput.setAttribute('type', type);
      toggleConfirmPassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Event Listeners
    searchInput.addEventListener('input', searchUsers);
    
    addUserBtn.addEventListener('click', openModal);
    
    cancelBtn.addEventListener('click', closeModal);
    
    addUserForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;
      const email = document.getElementById('userEmail').value;
      const phone = document.getElementById('phoneNumber').value;
      const dob = document.getElementById('dob').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      // Validasi email unik
      const emailExists = users.some(user => user.email.toLowerCase() === email.toLowerCase());
      if (emailExists) {
        alert('Email sudah terdaftar! Gunakan email lain.');
        return;
      }

      // Validasi password
      if (password !== confirmPassword) {
        alert('Password dan konfirmasi password tidak cocok!');
        return;
      }

      if (password.length < 6) {
        alert('Password harus minimal 6 karakter!');
        return;
      }

      const userData = {
        firstName,
        lastName,
        email,
        phone: '+62' + phone,
        dob,
        password
      };

      addUser(userData);
    });

    // Event listeners untuk modal hapus
    cancelDeleteBtn.addEventListener('click', closeDeleteModal);
    
    confirmDeleteBtn.addEventListener('click', () => {
      if (userToDelete) {
        deleteUser(userToDelete);
      }
    });

    // Menutup modal ketika mengklik di luar konten modal
    window.addEventListener('click', function(e) {
      if (e.target === addUserModal) {
        closeModal();
      }
      if (e.target === deleteModal) {
        closeDeleteModal();
      }
    });

    // Menampilkan semua pengguna saat halaman dimuat
    window.onload = function() {
      loadUsersFromStorage(); // Muat data dari localStorage
      displayUsers(users);
    };

    // Export fungsi ke global scope untuk event handler
    window.showDeleteConfirmation = showDeleteConfirmation;
  </script>
</body>
</html>