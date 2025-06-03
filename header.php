<?php
$header_styles = "
<style>
    body {
        padding-top: 80px;
        margin: 0;
       
    }

    .logo {
        height: 60px;
        display: block;
    }

    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 80px;
        padding: 0 12px;
        background: rgba(255, 249, 229, 0.8);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(52, 57, 75, 0.04);
        z-index: 1000;
        display: flex;
        align-items: center;
        padding-right: 30px;
        
        
    }

    header a {
        display: flex;
        align-items: center;
    }

    nav {
        margin-left: auto;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 60px;
        font-size: 22px;
        font-weight: 400;
        margin: 0;
        padding: 0;
        margin-right: 50px;
    }

    nav ul li a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
    }

    nav ul li a:hover {
        color: #007BFF;
    }

    .menu-icon {
        display: none;
        font-size: 28px;
        cursor: pointer;
        margin-left: auto;
        padding: 10px;
        line-height: 1;
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        right: -250px;
        width: 250px;
        height: 100%;
        background-color: white;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        padding-top: 80px;
        transition: right 0.3s ease-in-out;
        z-index: 9999;
    }

    .sidebar.open {
        right: 0;
    }

    .sidebar .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 26px;
        font-weight: bold;
        background: none;
        border: none;
        cursor: pointer;
        color: #333;
    }

    .sidebar ul {
        list-style: none;
        padding: 0 20px;
        margin-top: 30px;
    }

    .sidebar ul li {
        margin: 20px 0;
    }

    .sidebar ul li a {
        font-size: 18px;
        color: #333;
        text-decoration: none;
    }

    .sidebar ul li a:hover {
        color: #007BFF;
    }

    @media (max-width: 768px) {

    
    
        nav ul {
            display: none;
        }

        .menu-icon {
            display: block;
        }
    }
</style>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
  }

  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
  }
</script>
";

echo $header_styles;
?>

<header>
    <a href="/">
        <img src="images/logo.png" alt="Bhaktimay Logo" class="logo">
    </a>

    

    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="upcoming-pujas.php">Upcoming Pujas</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>
    <div class="menu-icon" onclick="toggleSidebar()">&#9776;</div>
    
</header>

<div class="sidebar" id="sidebar">
   
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="upcoming-pujas.php">Pujas</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
     <button class="close-btn" onclick="closeSidebar()">×</button>
</div>
