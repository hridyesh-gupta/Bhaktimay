<?php
  require_once 'config.php';

  $longname = "Long Pooja Name";
  $shortname = "Short Pooja Name";
  // Define packages
  $packages = [
      'individual' => [
          'name' => 'Individual',
          'price' => 1000,
          'description' => 'Perfect for single person',
          'image' => 'addon1.jpg',
          'features' => ['1 Person', 'Basic Pooja Items', 'Standard Prasad']
      ],
      'couple' => [
          'name' => 'Couple',
          'price' => 2000,
          'description' => 'Ideal for couples',
          'image' => 'addon2.jpg',
          'features' => ['2 Persons', 'Premium Pooja Items', 'Special Prasad']
      ],
      'family' => [
          'name' => 'Family',
          'price' => 3500,
          'description' => 'Best for small families',
          'image' => 'addon3.jpg',
          'features' => ['4 Persons', 'Deluxe Pooja Items', 'Family Prasad']
      ],
      'joint_family' => [
          'name' => 'Joint Family',
          'price' => 5000,
          'description' => 'Perfect for large families',
          'image' => 'addon4.jpg',
          'features' => ['8 Persons', 'Premium Pooja Items', 'Large Prasad']
      ]
  ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $shortname; ?> - Bhaktimay</title>
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    html, body {
      width: 100%;
      max-width: 100%;
      overflow-x: hidden;
      scroll-behavior: smooth;
      scroll-padding-top: 80px; 
    }
    body {
      background: #FFF9DB;
      font-family: 'Poppins', Arial, sans-serif;
      color: #34394b;
      padding-top: 64px;
    }
    a { color: inherit; text-decoration: none; }
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
    .logo { 
      height: 40px; 
      display: block;
    }
    .main-nav { display: flex; gap: 28px; align-items: center; }
    .main-nav a { font-weight: 600; font-size: 15px; transition: color 0.2s; }
    .main-nav a:hover { color: #FF6F00; }
    .container { 
      width: 100%;
      max-width: 100%; 
      margin: 0 auto; 
      padding: 16px 8px; 
    }
    .hero {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 24px 0 rgba(52,57,75,0.08);
      display: flex;
      gap: 20px;
      align-items: flex-start;
      padding: 24px 16px;
      margin-bottom: 24px;
      width: 100%;
    }
    .hero-img {
      width: 100%;
      max-width: 340px;
      min-width: 260px;
      border-radius: 10px;
      object-fit: cover;
      border: 2px solid #e4a895;
    }
    .hero-content { flex: 1; }
    .hero-title {
      font-size: 24px;
      font-weight: 800;
      color: #FF6F00;
      margin-bottom: 12px;
    }
    .hero-date, .hero-meta, .countdown-text {
      color: #e09139;
      font-size: 15px;
      font-weight: 700;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    .hero-badges { 
      display: flex; 
      margin-bottom: 10px;
      position: relative;
      height: 28px;
    }
    .hero-badges .image {
      position: relative;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: 2px solid #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-left: -10px;
      z-index: 1;
    }
    .hero-badges .image:first-child {
      margin-left: 0;
      z-index: 3;
    }
    .hero-badges .image:nth-child(2) {
      z-index: 2;
    }
    .hero-badges .image:last-child {
      z-index: 1;
    }
    .hero-stat { color: #9a9ba5; font-size: 13px; }
    .countdown-timer {
      display: flex;
      gap: 10px;
      margin: 15px 0;
    }
    .timer-block {
      background: #34394b;
      color: white;
      border-radius: 4px;
      padding: 6px 8px;
      text-align: center;
      min-width: 42px;
    }
    .timer-number {
      font-size: 18px;
      font-weight: bold;
    }
    .timer-label {
      font-size: 10px;
      opacity: 0.8;
    }
    .hero-cta {
      margin-top: 12px;
      background: linear-gradient(90deg,#FF6F00 0%,#E65A00 150%);
      color: #fff;
      font-size: 17px;
      font-weight: 700;
      padding: 12px 24px;
      border: none;
      border-radius: 7px;
      cursor: pointer;
      box-shadow: 0 1px 6px 0 rgba(255,111,0,0.12);
      transition: background 0.2s;
    }
    .section-title {
      text-align: center;
      font-size: 26px;
      font-weight: 700;
      color: #FF6F00;
      margin: 24px 0 12px 0;
      letter-spacing: 0.5px;
      position: relative;
    }
    .pattern-heading { width: 26px; margin: 0 6px; vertical-align: middle; }
    .how-it-works {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 16px 0 rgba(52,57,75,0.04);
      padding: 0px 0 20px 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 44px;
      width: 100%;
    }
    .hiw-steps { 
      display: flex; 
      gap: 38px; 
      justify-content: space-between;
      flex-wrap: wrap;
      width: 80%;
    }
    .hiw-step {
      width: 130px;
      min-width: 90px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      color: #34394b;
    }
    .hiw-step img { height: 42px; margin-bottom: 8px; }
    .hiw-step-title { font-weight: 700; margin-bottom: 4px; font-size: 16px; }
    .hiw-step-desc { font-size: 14px; color: #9a9ba5; }
    /* Packages Cards */
    .cards-container {
      display: flex;
      gap: 30px;
      justify-content: center;
      flex-wrap: wrap;
      margin-bottom: 34px;
      width: 100%;
    }
    .package-card {
      background: #fff;
      border-radius: 13px;
      min-width: 240px;
      max-width: 270px;
      border: 2px solid #FF6F00;
      box-shadow: 0 2px 16px 0 rgba(52,57,75,0.07);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 26px 18px 18px 18px;
    }
    .package-card .pkg-title {
      font-size: 17px;
      font-weight: 700;
      color: #FF6F00;
      margin-bottom: 1px;
      text-align: center;
    }
    .package-card .pkg-price {
      color: #FF6F00;
      font-size: 16px;
      margin-bottom: 6px;
      font-weight: 700;
    }
    .package-card img.pkg-img {
      height: 64px;
      margin-bottom: 11px;
      border-radius: 7px;
    }
    .package-card ul {
      list-style: none;
      padding: 0;
      margin: 0 0 12px 0;
      font-size: 14px;
    }
    .package-card ul li {
      display: flex;
      align-items: flex-start;
      gap: 5px;
      margin-bottom: 8px;
      text-align: left;
      line-height: 1.4;
    }
    .package-card ul li img { width: 18px; height: 18px; margin-top: 1px; }
    .package-card .pkg-cta {
      margin-top: auto;
      background: #FF6F00;
      color: #fff;
      padding: 8px 24px;
      border-radius: 5px;
      font-weight: 600;
      font-size: 15px;
      border: none;
      cursor: pointer;
      transition: background 0.2s;
    }
    .package-card .pkg-cta:hover {
      background: #E65A00;
      transition: transform 0.3s ease;
    }
    .package-card .pkg-cta:hover {
      transform: scale(1.05);
    }
    .section-description { text-align: center; color: #34394b; font-size: 15px; margin-bottom: 16px; }
    .about-section, .about-temple-section, .benefits-section, .devotee-section, .faq-section, .whatsapp-section {
      margin: 0px auto;
      padding: 0px 22px;
      width: 100%;
      max-width: 100%;
      border-radius: 11px;
    }
    .about-section p { font-size: 15px; color: #34394b; max-width: 70%; text-align: center; align-items: center; margin: 0 auto;}
    .about-temple-section p { font-size: 15px; color: #34394b; max-width: 70%; text-align: center; align-items: center; margin: 0 auto;}

    /* About Temple, Benefits, Devotee Section Styles */
    .about-section, .about-temple-section, .benefits-section {
      background: #fff;
      border-radius: 11px;
      box-shadow: 0 2px 10px 0 rgba(52,57,75,0.07);
      max-width: 100%;
      margin: 30px auto;
      padding: 5px 22px;
      width: 100%;
    }
    .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 24px;
      width: 100%;
    }
    .benefit-card {
      border: 1px solid #f4c99a;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }
    .benefit-card h4 {
      color: #FF6F00;
      margin-top: 0;
      font-size: 17px;
    }
    .benefit-card:hover {
      transform: scale(1.05);
    }
    .card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      cursor: pointer;
      gap: 10px;
    }

    .card-header h4 {
      margin: 0;
      font-size: 17px;
      color: #FF6F00;
      flex: 1;
    }

    .card-header .icon {
      display: none;
      font-size: 18px;
      transition: transform 0.3s ease;
    }

    .card-content {
      margin-top: 10px;
      display: block;
    }
    
    /* Devotee Corner */
    .devotee-section {
      background: #fff;
      border-radius: 11px;
      box-shadow: 0 2px 10px 0 rgba(52,57,75,0.07);
      max-width: 100%;
      margin: 30px auto;
      padding: 5px 22px;
      width: 100%;
    }
    .testimonials {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 24px;
      width: 100%;
    }
    .testimonial-card {
      border: 1px solid #f4c99a;
      border-radius: 8px;
      padding: 18px;
    }
    .testimonial-dots {
      display: none;
      justify-content: center;
      gap: 8px;
      margin: 20px 0;
      width: 100%;
    }
    .testimonial-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #e4a895;
      opacity: 0.5;
      cursor: pointer;
      transition: opacity 0.3s ease;
    }
    .testimonial-dot.active {
      opacity: 1;
      background: #FF0000;
    }
    .rating {
      display: flex;
      margin: 10px 0;
    }
    .rating img {
      width: 16px;
      height: 16px;
      margin-right: 2px;
    }
    .reviewer-meta {
      display: flex;
      align-items: center;
      margin-top: 15px;
      font-size: 14px;
      color: #9a9ba5;
    }
    
    /* FAQ Section */
    .faq-section {
      background: #fff;
      border-radius: 11px;
      box-shadow: 0 2px 10px 0 rgba(52,57,75,0.07);
      max-width: 100%;
      margin: 30px auto;
      padding: 5px 22px;
      width: 100%;
    }
    .faq-item {
      border-bottom: 1px solid #f4c99a;
      padding: 15px 0;
      max-width: 80%;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
    }
    .faq-question {
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      font-weight: 600;
    }
    .faq-question::after {
      content: "+";
      font-size: 20px;
      color: #FF6F00;
    }
    .faq-answer {
      padding: 10px 0;
      display: none;
      color: #666;
      font-size: 14px;
    }
    
    /* WhatsApp */
    .whatsapp-section {
      background: #fff6f0;
      border-radius: 11px;
      max-width: 100%;
      margin: 30px auto;
      padding: 28px 22px;
      text-align: center;
      width: 100%;
    }
    .whatsapp-btn{
      background: #FF6F00;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 6px;
      font-weight: 600;
      margin: 10px 5px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    
    /* Footer */
    footer {
      background: linear-gradient(90deg,#FF6F00 0%,#E65A00 150%);
      color: #fff;
      padding: 4px 0 4px 0;
      width: 100%;
    }
    .footer-container {
      max-width: 100%;
      margin: auto;
      display: flex;
      gap: 60px;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 0 15px;
      width: 100%;
    }
    .footer-about { flex: 1; min-width: 200px; }
    .footer-links, .footer-legal, .footer-social, .footer-contact {
      min-width: 140px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .footer-item-title { font-size: 16px; color: #fff; font-weight: 700; margin-top: 16px; }
    .footer-legal a, .footer-links a, .footer-social a { color: #fff; opacity: 0.93; }
    .footer-legal a:hover, .footer-links a:hover, .footer-social a:hover { color: #34394b; opacity:1; }
    .copyright { text-align: center; color: #fff; opacity: 0.95; font-size: 13px; padding: 10px 0 0 0; }
    
    /* Responsive */
    .mobile-packages {
      display: none;
    }

    .carousel-container {
      position: relative;
      width: 100%;
      overflow: hidden;
      margin-top: 30px;
    }

    .carousel-viewport {
      overflow: hidden;
      width: 100%;
    }

    .carousel-track {
      display: flex;
      transition: transform 0.5s ease;
    }

    .carousel-img {
      flex: 0 0 100%;
      max-width: 100%;
      padding: 5px;
      box-sizing: border-box;
    }

    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: white;
      border: 1px solid #ccc;
      padding: 5px 10px;
      font-size: 24px;
      cursor: pointer;
      z-index: 1;
    }

    .carousel-btn.left {
      left: 10px;
    }

    .carousel-btn.right {
      right: 10px;
    }

    .card-header {
      display: flex;
      align-items: center;
      gap: 10px; /* spacing between image and heading */
    }

    .card-header h4 {
      margin: 0;
    }

    .whatsapp-float {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 999;
      display: inline-block;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(0,0,0,0);
    }

    @media (max-width: 900px) {
      .container { 
        padding: 12px 8px; 
        width: 100%; 
        max-width: 100%;
      }
      .hero { 
        flex-direction: column; 
        align-items: stretch;
        padding: 16px 12px;
        margin: 0 0 24px 0;
      }
      .hero-img { 
        width: 100%; 
        max-width: 100%; 
        margin: 0 auto 20px auto; 
        display: block; 
      }
      .benefits-grid, .testimonials {
        grid-template-columns: 1fr;
      }
      .about-section, .about-temple-section, .benefits-section, .devotee-section, .faq-section, .whatsapp-section {
        margin: 20px 0;
        padding: 20px 15px;
      }
    }
    
    /* Show 4 images per screen on desktop */
    @media (min-width: 768px) {
      .carousel-img {
        flex: 0 0 25%;
        max-width: 25%;
      }
    }

    @media (max-width: 768px) {
      .card-header .icon {
        display: block;
      }

      .card-content {
        display: none;
      }

      .benefit-card.expanded .card-content {
        display: block;
      }

      .benefit-card.expanded .icon {
        transform: rotate(180deg);
      }

      .testimonials {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
      .testimonials::-webkit-scrollbar {
        display: none;
      }
      .testimonial-card {
        flex: 0 0 100%;
        scroll-snap-align: start;
        margin-right: 16px;
        box-sizing: border-box;
      }
      .testimonial-dots {
        display: flex;
      }
      .hero-badges {
        height: 28px;
        margin-left: 0;
      }
      .hero-badges .image {
        width: 28px;
        height: 28px;
        margin-left: -10px;
      }
      .hero-badges .image:first-child {
        margin-left: 0;
      }
    }

    @media (max-width: 650px) {
      header {
        padding: 0 10px;
        flex-wrap: wrap;
        height: auto;
        min-height: 64px;
        align-items: center;
        justify-content: center;
      }
      .cards-container { display: none !important; }
      .mobile-packages { 
        width: 100%; 
        display: block;
      }
      .package-tabs {
        display: flex;
        justify-content: space-between;
        background: #fff;
        border-radius: 10px;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px 0 rgba(52,57,75,0.04);
        padding: 6px 0;
        gap: 4px;
      }
      .package-tab {
        flex: 1;
        text-align: center;
        padding: 8px 0 4px 0;
        cursor: pointer;
        border-radius: 8px 8px 0 0;
        border: 2px solid transparent;
        transition: border 0.2s, background 0.2s;
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
      }
      .package-tab.selected {
        border: 2px solid #FF6F00;
        background: #FFF9DB;
      }
      .package-tab img {
        height: 36px;
        margin-bottom: 2px;
      }
      .tab-name {
        font-size: 15px;
        font-weight: 500;
        color: #FF6F00;
      }
      .package-details {
        width: 100%;
      }
      .mobile-card {
        display: block;
        background: #fff;
        border-radius: 13px;
        border: 2px solid #FF6F00;
        box-shadow: 0 2px 16px 0 rgba(52,57,75,0.07);
        padding: 18px 10px 14px 10px;
        margin-bottom: 10px;
        max-width: 100%;
      }
      .mobile-card .pkg-title {
        font-size: 17px;
        font-weight: 700;
        color: #FF6F00;
        margin-bottom: 6px;
        text-align: left;
      }
      .mobile-card .pkg-price {
        color: #FF6F00;
        font-size: 16px;
        margin-bottom: 6px;
        font-weight: 700;
        text-align: left;
      }
      .mobile-card ul {
        margin-bottom: 12px;
        font-size: 14px;
      }
      .mobile-card .pkg-cta {
        width: 100%;
        margin-top: 10px;
        background: #FF6F00;
        color: #fff;
        padding: 10px 0;
        border-radius: 5px;
        font-weight: 700;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
      }
      .main-nav {
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
        margin-bottom: 8px;
      }
      .main-nav a {
        font-size: 14px;
      }
      .logo {
        margin: 8px 0;
        height: 32px;
      }
      .hero { 
        flex-direction: column; 
        padding: 16px 12px;
        border-radius: 8px;
        margin: 0 0 20px 0;
      }
      .about-section, .about-temple-section, .benefits-section, .devotee-section, .faq-section { 
        padding: 16px 10px;
        border-radius: 8px;
        margin: 15px 0;
      }
      .whatsapp-section {
        padding: 16px 10px;
        border-radius: 8px;
        margin: 15px 0;
      }
      .footer-container { 
        flex-direction: column; 
        gap: 14px; 
        padding: 10px 12px; 
      }
      .hiw-steps { 
        flex-wrap: wrap;
        gap: 12px;
        justify-content: space-around;
      }
      .hiw-step {
        width: 45%;
        min-width: 120px;
        margin-bottom: 10px;
      }
      .countdown-timer {
        gap: 5px;
      }
      .timer-block {
        min-width: 38px;
        padding: 4px 6px;
      }
      .timer-number {
        font-size: 16px;
      }
      .package-card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        padding: 16px 12px;
      }
      .store-buttons {
        flex-direction: column;
        align-items: center;
      }
      .section-title {
        font-size: 22px;
      }
      .benefit-card, .testimonial-card {
        padding: 12px;
      }
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 8px;
      }
      .hiw-steps {
        flex-direction: column;
        align-items: center;
      }
      .hiw-step {
        width: 100%;
        max-width: 280px;
        margin-bottom: 12px;
      }
      .cards-container {
        gap: 15px;
      }
      .hero-title {
        font-size: 20px;
      }
      .hero-cta {
        width: 100%;
        padding: 12px 8px;
        font-size: 16px;
      }
      .faq-question {
        font-size: 14px;
      }
      .about-section, .about-temple-section, .benefits-section, .devotee-section, .faq-section, .whatsapp-section {
        padding: 12px 8px;
        margin: 10px 0;
      }
      .benefit-card, .testimonial-card {
        padding: 10px;
      }
      .footer-container {
        padding: 8px;
      }
    }
  </style>
</head>
<body class='bg-lightyellow min-h-screen'>
<?php include 'header.php'; ?>

  <div class="container">
    <section class="hero">
      <img class="hero-img" src="images/addon1.jpg"/>
      <div class="hero-content">
        <div class="hero-title"><?php echo $longname; ?></div>
        <div class="hero-meta"><img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="Location" style="height: 20px; vertical-align:middle;margin-right:5px;">Lorem ipsum dolor sit amet</div>
        <div class="hero-date"><img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Calendar" style="height: 20px; vertical-align:middle;margin-right:5px;">Thursday, 15 May 2025</div>
        
        <div class="countdown-wrapper">
          <div class="countdown-text">
          <img src="https://cdn-icons-png.flaticon.com/512/1827/1827392.png" alt="Bell" style="height: 20px; vertical-align:middle;margin-right:5px;"> Bookings Closes in</div>

          <div class="countdown-timer">
            <div class="timer-block">
              <div id="days" class="timer-number">00</div>
              <div class="timer-label">Days</div>
            </div>
            <div class="timer-block">
              <div id="hours" class="timer-number">00</div>
              <div class="timer-label">Hrs</div>
            </div>
            <div class="timer-block">
              <div id="minutes" class="timer-number">00</div>
              <div class="timer-label">Min</div>
            </div>
            <div class="timer-block">
              <div id="seconds" class="timer-number">00</div>
              <div class="timer-label">Sec</div>
            </div>
          </div>
        </div>

        
        <div class="hero-badges">
          <img src="https://ext.same-assets.com/1765579610/3526585712.jpeg" alt="User" class="image">
          <img src="https://ext.same-assets.com/1765579610/529674041.jpeg" alt="User" class="image">
          <img src="https://ext.same-assets.com/1765579610/1634109515.jpeg" alt="User" class="image">
        </div>
        <div class="hero-stat">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
        <button class="hero-cta" onclick="document.getElementById('participation').scrollIntoView({ behavior: 'smooth' })">Participate in Puja</button>
      </div>
    </section>
    <div class="how-it-works">
      <div class="section-title">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
        How it Works
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
      </div>
      <br>
      <br>
      <div class="hiw-steps">
        <div class="hiw-step">
          <img src="https://ext.same-assets.com/1765579610/1297980122.svg" alt="Select Puja">
          <div class="hiw-step-title">Select Puja</div>
          <div class="hiw-step-desc">Lorem ipsum dolor</div>
        </div>
        <div class="hiw-step">
          <img src="https://ext.same-assets.com/1765579610/382254717.svg" alt="Name and Gotra">
          <div class="hiw-step-title">Name and Gotra</div>
          <div class="hiw-step-desc">Lorem ipsum dolor</div>
        </div>
        <div class="hiw-step">
          <img src="https://ext.same-assets.com/1765579610/2053465482.svg" alt="Watch Puja Video">
          <div class="hiw-step-title">Watch Puja Video</div>
          <div class="hiw-step-desc">Lorem ipsum dolor</div>
        </div>
        <div class="hiw-step">
          <img src="https://ext.same-assets.com/1765579610/2687762564.svg" alt="Prashad Shipped">
          <div class="hiw-step-title">Prashad Shipped</div>
          <div class="hiw-step-desc">Lorem ipsum dolor</div>
        </div>
      </div>
    </div>
    <div id="participation" class="section-title">
      <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
      4 Ways to Participate
      <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
    </div>
    <br>
    <div class="cards-container">
      <?php foreach ($packages as $key => $package): ?>
      <div class="package-card">
        <div class="pkg-title"><?php echo $package['name']; ?> <?php echo $shortname; ?></div>
        <div class="pkg-price">₹<?php echo number_format($package['price']); ?></div>
        <img src="images/<?php echo $package['image']; ?>" class="pkg-img" alt="<?php echo $package['name']; ?>"/>
        <ul>
          <?php foreach ($package['features'] as $feature): ?>
          <li>
            <img src="https://ext.same-assets.com/1765579610/3490768621.svg">
            <?php echo $feature; ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <a href="cart.php?package=<?php echo $key; ?>" class="pkg-cta">Participate</a>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="mobile-packages">
      <div class="package-tabs">
        <?php foreach ($packages as $key => $package): ?>
        <div class="package-tab" data-package="<?php echo $key; ?>">
          <img src="images/<?php echo $package['image']; ?>" />
          <div class="tab-name"><?php echo $package['name']; ?></div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="package-details">
        <?php foreach ($packages as $key => $package): ?>
        <div class="package-card mobile-card" data-package="<?php echo $key; ?>" <?php echo $key === 'individual' ? '' : 'style="display:none;"'; ?>>
          <div class="pkg-title"><?php echo $package['name'];?> <?php echo $shortname; ?></div>
          <div class="pkg-price">₹<?php echo number_format($package['price']); ?></div>
          <img src="images/<?php echo $package['image']; ?>" class="pkg-img" alt="<?php echo $package['name']; ?>"/>
          <ul>
            <?php foreach ($package['features'] as $feature): ?>
            <li>
              <img src="https://ext.same-assets.com/1765579610/3490768621.svg">
              <?php echo $feature; ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <button class="pkg-cta" onclick="window.location.href='cart.php?package=<?php echo $key; ?>'">Participate</button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    
    
    <!-- About Puja Section -->
    <div class="about-section">
      <div class="section-title">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
        About Puja
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
      </div>
      <br>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <div class="carousel-container">
        <button class="carousel-btn left" onclick="scrollCarousel(-1)">&#10094;</button>
        <div class="carousel-viewport" id="carouselViewport">
          <div class="carousel-track" id="carouselTrack">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 1">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 2">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 3">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 4">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 5">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 6">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 7">
            <img src="images/addon1.jpg" class="carousel-img" alt="Image 8">
          </div>
        </div>
        <button class="carousel-btn right" onclick="scrollCarousel(1)">&#10095;</button>
      </div>
    </div>

    <!-- About Temple Section -->
    <div class="about-temple-section">
      <div class="section-title">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
        About Temple
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
      </div>
      <br>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    <br>
    </div>
    
    <!-- Benefits Section -->
    <div class="benefits-section">
      <div class="section-title">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
        Benefits of Puja
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
      </div>
      <div class="benefits-grid">
      <div class="benefit-card">
        <div class="card-header" onclick="toggleCard(this)">
          <img src="images/swastik.png" class="logo" style="height: 50px;">
          <h4>Lorem ipsum dolor sit</h4>
          <span class="icon">⌵</span>
        </div>
        <div class="card-content">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
        </div>
      </div>
      <div class="benefit-card">
        <div class="card-header" onclick="toggleCard(this)">
          <img src="images/swastik.png" class="logo" style="height: 50px;">
          <h4>Lorem ipsum dolor sit</h4>
          <span class="icon">⌵</span>
        </div>
        <div class="card-content">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
        </div>
      </div><div class="benefit-card">
        <div class="card-header" onclick="toggleCard(this)">
          <img src="images/swastik.png" class="logo" style="height: 50px;">
          <h4>Lorem ipsum dolor sit</h4>
          <span class="icon">⌵</span>
        </div>
        <div class="card-content">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
        </div>
      </div><div class="benefit-card">
        <div class="card-header" onclick="toggleCard(this)">
          <img src="images/swastik.png" class="logo" style="height: 50px;">
          <h4>Lorem ipsum dolor sit</h4>
          <span class="icon">⌵</span>
        </div>
        <div class="card-content">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
        </div>
      </div>
    </div>
  </div>
    <!-- Devotee Corner Section -->
    <div class="devotee-section">
      <div class="section-title">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
        Devotee Corner
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
      </div>
      <div class="testimonials">
        <div class="testimonial-card">
          <img src="https://ext.same-assets.com/1765579610/3526585712.jpeg" alt="User" style="width:100px; border-radius:50%;">
          <h4>Lorem ipsum dolor</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <div class="rating">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
          </div>
          <div class="reviewer-meta">Name Surname • Via WhatsApp</div>
        </div>
        <div class="testimonial-card">
          <img src="https://ext.same-assets.com/1765579610/529674041.jpeg" alt="User" style="width:100px; border-radius:50%;">
          <h4>Lorem ipsum dolor</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <div class="rating">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
          </div>
          <div class="reviewer-meta">Name Surname • Via Google Play Store</div>
        </div>
        <div class="testimonial-card">
          <img src="https://ext.same-assets.com/1765579610/1634109515.jpeg" alt="User" style="width:100px; border-radius:50%;">
          <h4>Lorem ipsum dolor</h4>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <div class="rating">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
            <img src="https://ext.same-assets.com/1765579610/3879282018.svg" alt="star">
          </div>
          <div class="reviewer-meta">Name Surname • Via Facebook</div>
        </div>
      </div>
      <div class="testimonial-dots">
        <div class="testimonial-dot active"></div>
        <div class="testimonial-dot"></div>
        <div class="testimonial-dot"></div>
      </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="faq-section">
      <div class="section-title">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading">
        FAQs
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg);">
      </div>
      <div class="faq-item">
        <div class="faq-question">Lorem ipsum dolor sit amet, consectetur adipiscing elit?</div>
        <div class="faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question">Lorem ipsum dolor sit amet, consectetur?</div>
        <div class="faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question">Lorem ipsum dolor sit amet?</div>
        <div class="faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</div>
      </div>
      <div class="faq-item">
        <div class="faq-question">Lorem ipsum dolor sit?</div>
        <div class="faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</div>
      </div>
      <br>
    </div>
    
    <!-- WhatsApp Subscribe Section -->
    <div class="whatsapp-section">
      <img src="images/clogo.png" alt="Bhaktimay Logo" style="height:100px; margin: 8px 0px 8px;">
      <div class="section-title" style="margin: 12px 0px 12px;">
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="position: relative; left: 0%;">
        Subscribe
        <img src="https://ext.same-assets.com/1765579610/2806274772.svg" class="pattern-heading" style="transform: rotate(180deg); position: relative; right: 0%;">
        <br>to Bhaktimay WhatsApp
      </div>
      <br>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <br>
      <a href="https://wa.me/919580199989" target="_blank" class="whatsapp-btn">Subscribe on WhatsApp</a>
    </div>

    <a href="https://wa.me/919580199989?text=Namaste,%20I%20have%20a%20query%20regarding%20the%20<?php echo urlencode($shortname); ?>" target="_blank" class="whatsapp-float" aria-label="Chat on WhatsApp">
      <img
      src="https://img.icons8.com/color/48/000000/whatsapp--v1.png"
      alt="WhatsApp"
      style="width: 56px; height: 56px;"/>
    </a>

  
  <footer>
    <div class="footer-container">
      <div class="footer-about">
        <img src="images/clogo.png" alt="Bhaktimay Logo" style="height:70px; margin-bottom:8px;">
        <p style="font-size:14px;color:#fff;line-height:1.7;">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.<br>Made with <span style="color:#e4a895">❤️</span> in Hindustan
        </p>
      </div>
      <div class="footer-social">
        <div class="footer-item-title">Follow us on</div>
        <a href="#">Facebook</a>
        <a href="#">Twitter</a>
        <a href="#">Instagram</a>
        <a href="#">LinkedIn</a>
      </div>
      <div class="footer-contact">
        <div class="footer-item-title">Contact</div>
        <span>Lorem ipsum dolor sit</span>
        <span style="margin-top:5px;">+91 90000 00000</span>
        <span style="margin-top:4px;">support@example.com</span>
      </div>
    </div>
    <div class="copyright">&copy; 2025 Lorem ipsum dolor sit</div>
  </footer>
  
  <script>
    // Set your countdown deadline here (yyyy-mm-dd hh:mm:ss format)
    // Don't let this timer count for past dates as it will make all the JS logics fail and nothing will work 
    const deadline = new Date("2025-05-29T19:21:44").getTime();

    function updateCountdown() {
      const now = new Date().getTime();
      const timeLeft = deadline - now;

      if (timeLeft < 0) {
        document.getElementById("days").innerHTML = "00";
        document.getElementById("hours").innerHTML = "00";
        document.getElementById("minutes").innerHTML = "00";
        document.getElementById("seconds").innerHTML = "00";
        clearInterval(timerInterval);
        return;
      }

      const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

      document.getElementById("days").innerHTML = String(days).padStart(2, '0');
      document.getElementById("hours").innerHTML = String(hours).padStart(2, '0');
      document.getElementById("minutes").innerHTML = String(minutes).padStart(2, '0');
      document.getElementById("seconds").innerHTML = String(seconds).padStart(2, '0');
    }

    // Start the countdown
    updateCountdown(); // run once immediately
    const timerInterval = setInterval(updateCountdown, 1000); // update every second

    // Simple script to toggle FAQ answers
    document.querySelectorAll('.faq-question').forEach(question => {
      question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
        question.style.color = answer.style.display === 'block' ? '#e45a32' : '#34394b';
      });
    });

    // Mobile package tab switching
    document.querySelectorAll('.package-tab').forEach(tab => {
      tab.addEventListener('click', function() {
        // Remove selected from all tabs
        document.querySelectorAll('.package-tab').forEach(t => t.classList.remove('selected'));
        // Hide all cards
        document.querySelectorAll('.mobile-card').forEach(card => card.style.display = 'none');
        // Show selected card
        const pkg = this.getAttribute('data-package');
        document.querySelector('.mobile-card[data-package="' + pkg + '"]').style.display = 'block';
        // Highlight tab
        this.classList.add('selected');
      });
    });
    // Set first tab as selected by default
    document.querySelector('.package-tab[data-package="individual"]').classList.add('selected');

    function scrollCarousel(direction) {
      const viewport = document.getElementById('carouselViewport');
      const isDesktop = window.innerWidth >= 768;
      const img = document.querySelector('.carousel-img');
      const scrollAmount = img.offsetWidth * (isDesktop ? 4 : 1);

      viewport.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }

    function toggleCard(header) {
      const card = header.closest('.benefit-card');
      card.classList.toggle('expanded');
    }

    const carousel = document.querySelector('.testimonials');
    const dots = document.querySelectorAll('.testimonial-dot');
    let scrollAmount = 0;
    let slideWidth = carousel.offsetWidth;
    let currentSlide = 0;

    function updateDots() {
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
      });
    }

    function goToSlide(index) {
      currentSlide = index;
      scrollAmount = slideWidth * index;
      carousel.scrollTo({
        left: scrollAmount,
        behavior: 'smooth'
      });
      updateDots();
    }

    // Add click event listeners to dots
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        goToSlide(index);
      });
    });

    function autoScroll() {
      if (window.innerWidth <= 768) {
        currentSlide = (currentSlide + 1) % dots.length;
        goToSlide(currentSlide);
      }
    }

    let interval = setInterval(autoScroll, 3000);

    // Optional: Pause on hover
    carousel.addEventListener('mouseenter', () => clearInterval(interval));
    carousel.addEventListener('mouseleave', () => {
      interval = setInterval(autoScroll, 3000);
    });

    // Update slide width on window resize
    window.addEventListener('resize', () => {
      slideWidth = carousel.offsetWidth;
    });
  </script>
</body>
</html>