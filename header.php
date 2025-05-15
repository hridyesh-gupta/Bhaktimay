<?php
// Essential header styles
$header_styles = "
<style>
    body {
        padding-top: 64px;
    }
    .logo { 
        height: 40px; 
        display: block;
    }
    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 16px;
        background: rgba(255, 249, 229, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(52, 57, 75, 0.04);
        z-index: 1000;
    }
</style>
";

// Output the header HTML
echo $header_styles;
?>
<header>
    <a href="/">
        <img src="images/logo.png" alt="Bhaktimay Logo" class="logo">
    </a>
</header> 