<?php
session_start();
// require 'db.php'; // Uncomment if you want to pull dynamic data from your database later

// Determine user state for navigation routing
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? ($_SESSION['user_name'] ?? 'User') : '';
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
$isFarmer = isset($_SESSION['is_farmer']) && $_SESSION['is_farmer'] == 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop | FarmDirect+</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
:root {
  --g900:#0f2d16; --g800:#1a4d23; --g700:#236030; --g600:#2e7d32;
  --g500:#388e3c; --g400:#43a047; --g200:#c8e6c9; --g100:#e8f5e9; --g50:#f1f8f2;
  --amber:#e65100; --amber-l:#fff3e0;
  --red:#c62828; --red-l:#ffebee;
  --cream:#fdfbf7; --paper:#f7f4ef;
  --ink:#1a2419; --ink2:#3d4f3e; --muted:#7a8c7b; --border:#dde8de;
  --white:#fff;
  --shadow-sm:0 1px 4px rgba(15,45,22,.06);
  --shadow-md:0 4px 20px rgba(15,45,22,.09);
  --shadow-lg:0 12px 40px rgba(15,45,22,.14);
  --shadow-xl:0 24px 60px rgba(15,45,22,.18);
  --r-sm:10px; --r-md:16px; --r-lg:24px; --r-xl:32px;
  --transition:0.28s cubic-bezier(.4,0,.2,1);
}
*{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{font-family:'Outfit',sans-serif;background:var(--cream);color:var(--ink);line-height:1.6;overflow-x:hidden;}

/* ── LOADER ── */
#loader{position:fixed;inset:0;background:var(--g900);z-index:9999;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:20px;transition:opacity .5s ease,visibility .5s ease;}
#loader.out{opacity:0;visibility:hidden;}
.ld-logo{font-family:'Playfair Display',serif;font-size:2rem;color:#fff;letter-spacing:-.5px;}
.ld-logo em{color:#86c98a;font-style:normal;}
.ld-track{width:180px;height:3px;background:rgba(255,255,255,.12);border-radius:99px;overflow:hidden;}
.ld-fill{height:100%;width:0;background:linear-gradient(90deg,#86c98a,#fff);border-radius:99px;animation:ldFill 1.3s .2s ease forwards;}
@keyframes ldFill{to{width:100%;}}

/* ── NAV ── */
header{background:rgba(253,251,247,.94);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-bottom:1px solid var(--border);position:sticky;top:0;z-index:200;}
.nav{max-width:1280px;margin:0 auto;padding:14px 28px;display:flex;align-items:center;gap:32px;}
.logo{font-family:'Playfair Display',serif;font-size:22px;font-weight:800;color:var(--g800);text-decoration:none;display:flex;align-items:center;gap:9px;flex-shrink:0;}
.logo i{color:var(--g500);}
.logo em{color:var(--amber);font-style:normal;}
.nav-links{display:flex;gap:6px;list-style:none;flex:1;}
.nav-links a{text-decoration:none;color:var(--ink2);font-weight:500;font-size:.88rem;padding:7px 13px;border-radius:8px;transition:background var(--transition),color var(--transition);}
.nav-links a:hover,.nav-links a.active{background:var(--g100);color:var(--g700);}
.nav-right{display:flex;align-items:center;gap:12px;margin-left:auto;}
.nav-btn{display:flex;align-items:center;gap:7px;padding:8px 16px;border-radius:10px;border:none;font-family:'Outfit',sans-serif;font-size:.88rem;font-weight:600;cursor:pointer;transition:all var(--transition);text-decoration:none;}
.nav-btn.ghost{background:transparent;color:var(--ink2);border:1.5px solid var(--border);}
.nav-btn.ghost:hover{background:var(--g50);border-color:var(--g400);}
.nav-btn.solid{background:var(--g700);color:#fff;}
.nav-btn.solid:hover{background:var(--g800);}
.cart-btn{position:relative;width:42px;height:42px;border-radius:11px;background:var(--g100);border:none;color:var(--g700);font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--transition);}
.cart-btn:hover{background:var(--g200);}
.cart-count{position:absolute;top:-5px;right:-5px;background:var(--amber);color:#fff;width:19px;height:19px;border-radius:50%;font-size:.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;border:2px solid var(--cream);transition:transform .3s cubic-bezier(.34,1.56,.64,1);}
.cart-count.bump{animation:bump .35s cubic-bezier(.34,1.56,.64,1);}
@keyframes bump{0%{transform:scale(1)}50%{transform:scale(1.5)}100%{transform:scale(1)}}

/* ── HERO ── */
.hero{position:relative;background:var(--g900);overflow:hidden;padding:80px 28px 90px;}
.hero-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=2200&q=75') center/cover;opacity:.18;animation:hZoom 16s ease-in-out infinite alternate;}
@keyframes hZoom{from{transform:scale(1.04)}to{transform:scale(1.12)}}
.hero-inner{position:relative;max-width:1280px;margin:0 auto;display:flex;align-items:center;gap:60px;}
.hero-text{flex:1;}
.hero-pill{display:inline-flex;align-items:center;gap:8px;background:rgba(134,201,138,.15);border:1px solid rgba(134,201,138,.3);color:#86c98a;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:6px 16px;border-radius:99px;margin-bottom:22px;animation:fadeUp .6s .1s both;}
.hero h1{font-family:'Playfair Display',serif;font-size:clamp(2.4rem,5vw,3.8rem);color:#fff;line-height:1.08;margin-bottom:18px;animation:fadeUp .6s .25s both;}
.hero h1 em{color:#a8dba9;font-style:normal;}
.hero-sub{color:rgba(255,255,255,.6);font-size:1rem;max-width:480px;margin-bottom:36px;animation:fadeUp .6s .4s both;}
.hero-ctas{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .6s .55s both;}
.btn-primary{padding:13px 30px;background:var(--g500);color:#fff;border:none;border-radius:12px;font-family:'Outfit',sans-serif;font-size:.95rem;font-weight:700;cursor:pointer;transition:all var(--transition);text-decoration:none;display:inline-flex;align-items:center;gap:9px;}
.btn-primary:hover{background:var(--g600);transform:translateY(-2px);box-shadow:0 8px 24px rgba(56,142,60,.4);}
.btn-outline{padding:13px 30px;background:transparent;color:#fff;border:1.5px solid rgba(255,255,255,.3);border-radius:12px;font-family:'Outfit',sans-serif;font-size:.95rem;font-weight:600;cursor:pointer;transition:all var(--transition);text-decoration:none;display:inline-flex;align-items:center;gap:9px;}
.btn-outline:hover{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.5);}
.hero-stats{display:flex;gap:36px;margin-top:48px;animation:fadeUp .6s .7s both;}
.stat{color:rgba(255,255,255,.55);}
.stat strong{display:block;font-family:'Playfair Display',serif;font-size:1.8rem;color:#fff;line-height:1;}
.hero-img-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;width:380px;flex-shrink:0;animation:fadeUp .7s .3s both;}
.hero-img-grid img{width:100%;border-radius:16px;object-fit:cover;aspect-ratio:1;}
.hero-img-grid img:first-child{grid-column:span 2;aspect-ratio:16/9;}
@keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}

/* ── CATEGORY TABS ── */
.cats-wrap{background:var(--paper);border-bottom:1px solid var(--border);position:sticky;top:65px;z-index:150;}
.cats-inner{max-width:1280px;margin:0 auto;padding:0 28px;display:flex;gap:4px;overflow-x:auto;scrollbar-width:none;}
.cats-inner::-webkit-scrollbar{display:none;}
.cat-tab{flex-shrink:0;display:flex;align-items:center;gap:8px;padding:14px 18px;border:none;background:transparent;font-family:'Outfit',sans-serif;font-size:.88rem;font-weight:600;color:var(--muted);cursor:pointer;border-bottom:2.5px solid transparent;transition:all var(--transition);white-space:nowrap;}
.cat-tab i{font-size:1rem;}
.cat-tab:hover{color:var(--g600);}
.cat-tab.active{color:var(--g700);border-bottom-color:var(--g600);}
.cat-tab .count{background:var(--g100);color:var(--g700);font-size:.7rem;font-weight:700;padding:2px 7px;border-radius:99px;}
.cat-tab.active .count{background:var(--g600);color:#fff;}

/* ── MAIN SHOP ── */
.shop-wrap{max-width:1280px;margin:0 auto;padding:40px 28px 80px;display:flex;gap:36px;align-items:flex-start;}

/* ── SIDEBAR ── */
.sidebar{width:250px;flex-shrink:0;position:sticky;top:130px;}
.sidebar-block{background:var(--white);border:1px solid var(--border);border-radius:var(--r-md);padding:22px;margin-bottom:18px;box-shadow:var(--shadow-sm);}
.sb-title{font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:var(--ink);margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
.sb-title i{color:var(--g500);}
.sb-check{display:flex;align-items:center;gap:10px;padding:7px 8px;border-radius:8px;cursor:pointer;font-size:.88rem;color:var(--ink2);font-weight:500;transition:background var(--transition);}
.sb-check:hover{background:var(--g50);}
.sb-check input{accent-color:var(--g600);width:16px;height:16px;cursor:pointer;}
.price-range{width:100%;accent-color:var(--g600);cursor:pointer;}
.price-vals{display:flex;justify-content:space-between;font-size:.82rem;font-weight:600;color:var(--muted);margin-top:10px;}
.clear-btn{width:100%;padding:9px;border-radius:8px;border:1.5px dashed var(--border);background:transparent;color:var(--muted);font-family:'Outfit',sans-serif;font-size:.83rem;font-weight:600;cursor:pointer;transition:all var(--transition);}
.clear-btn:hover{border-color:var(--g400);color:var(--g600);}

/* ── PRODUCTS AREA ── */
.products-main{flex:1;min-width:0;}
.products-toolbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;gap:16px;flex-wrap:wrap;}
.toolbar-left h2{font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--ink);}
.toolbar-left p{font-size:.85rem;color:var(--muted);margin-top:2px;}
.toolbar-right{display:flex;align-items:center;gap:10px;}
.sort-sel{padding:9px 14px;border:1.5px solid var(--border);border-radius:10px;font-family:'Outfit',sans-serif;font-size:.85rem;color:var(--ink);background:var(--white);cursor:pointer;outline:none;transition:border-color var(--transition);}
.sort-sel:focus{border-color:var(--g500);}
.view-toggle{display:flex;gap:4px;}
.view-btn{width:36px;height:36px;border-radius:8px;border:1.5px solid var(--border);background:var(--white);color:var(--muted);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.9rem;transition:all var(--transition);}
.view-btn.active,.view-btn:hover{background:var(--g100);border-color:var(--g400);color:var(--g700);}

/* ── PRODUCT GRID ── */
.product-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:22px;}
.product-grid.list-view{grid-template-columns:1fr;}

/* ── PRODUCT CARD ── */
.product-card{background:var(--white);border:1px solid var(--border);border-radius:var(--r-md);overflow:hidden;display:flex;flex-direction:column;transition:transform var(--transition),box-shadow var(--transition),border-color var(--transition);position:relative;}
.product-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-lg);border-color:#c0dbc1;}
.product-card.list-view{flex-direction:row;height:160px;}
.product-card.list-view .card-img-wrap{width:180px;flex-shrink:0;height:100%;}
.product-card.list-view .card-body{flex:1;padding:16px 20px;display:flex;flex-direction:column;justify-content:space-between;}
.card-img-wrap{position:relative;overflow:hidden;background:var(--g50);}
.card-img-wrap img{width:100%;height:200px;object-fit:cover;transition:transform .5s cubic-bezier(.25,.46,.45,.94);display:block;}
.product-card.list-view .card-img-wrap img{height:100%;}
.product-card:hover .card-img-wrap img{transform:scale(1.08);}
.card-badge{position:absolute;top:11px;left:11px;padding:4px 10px;border-radius:99px;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;z-index:5;}
.badge-org{background:rgba(46,125,50,.9);color:#fff;backdrop-filter:blur(6px);}
.badge-best{background:rgba(230,81,0,.9);color:#fff;backdrop-filter:blur(6px);}
.badge-sale{background:rgba(198,40,40,.9);color:#fff;backdrop-filter:blur(6px);}
.badge-new{background:rgba(25,118,210,.9);color:#fff;backdrop-filter:blur(6px);}
.card-wish{position:absolute;top:11px;right:11px;width:32px;height:32px;border-radius:50%;border:none;background:rgba(255,255,255,.9);color:#ccc;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:5;transition:all var(--transition);backdrop-filter:blur(6px);}
.card-wish:hover,.card-wish.on{color:#e53935;}
.card-wish.on{background:#fff;}
.card-body{padding:16px 16px 18px;display:flex;flex-direction:column;flex:1;}
.card-cat{font-size:.72rem;font-weight:700;color:var(--g500);text-transform:uppercase;letter-spacing:.09em;margin-bottom:5px;}
.card-name{font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--ink);line-height:1.3;margin-bottom:8px;}
.card-farm{font-size:.78rem;color:var(--muted);margin-bottom:9px;display:flex;align-items:center;gap:5px;}
.card-farm i{color:var(--g400);font-size:.75rem;}
.card-stars{color:#f59e0b;font-size:.78rem;margin-bottom:12px;display:flex;align-items:center;gap:4px;}
.card-stars span{color:var(--muted);font-size:.76rem;}
.card-footer{display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:12px;border-top:1px solid var(--border);}
.card-price{display:flex;flex-direction:column;}
.price-main{font-weight:800;color:var(--g800);font-size:1.15rem;line-height:1;}
.price-meta{font-size:.75rem;color:var(--muted);font-weight:400;}
.price-old{font-size:.74rem;color:#bbb;text-decoration:line-through;}
.add-btn{width:38px;height:38px;border-radius:10px;border:none;background:var(--g100);color:var(--g700);font-size:1rem;cursor:pointer;transition:all .25s cubic-bezier(.34,1.56,.64,1);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.add-btn:hover{background:var(--g600);color:#fff;transform:scale(1.1);}
.add-btn.in-cart{background:var(--g700);color:#fff;}
.qty-ctrl{display:flex;align-items:center;gap:4px;}
.qty-ctrl button{width:28px;height:28px;border-radius:7px;border:none;background:var(--g100);color:var(--g700);font-size:.85rem;font-weight:700;cursor:pointer;transition:background var(--transition);}
.qty-ctrl button:hover{background:var(--g200);}
.qty-ctrl span{min-width:22px;text-align:center;font-weight:700;font-size:.88rem;color:var(--ink);}

/* ── EMPTY STATE ── */
.empty-state{text-align:center;padding:80px 20px;color:var(--muted);}
.empty-state i{font-size:3.5rem;margin-bottom:20px;color:var(--g200);}
.empty-state h3{font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--ink2);margin-bottom:8px;}

/* ── CART DRAWER ── */
.cart-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:800;opacity:0;visibility:hidden;transition:all .3s;}
.cart-overlay.open{opacity:1;visibility:visible;}
.cart-drawer{position:fixed;top:0;right:0;bottom:0;width:420px;max-width:100vw;background:var(--cream);z-index:900;transform:translateX(100%);transition:transform .35s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;box-shadow:var(--shadow-xl);}
.cart-drawer.open{transform:translateX(0);}
.cart-head{padding:24px 24px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.cart-head h2{font-family:'Playfair Display',serif;font-size:1.3rem;}
.cart-close{width:36px;height:36px;border-radius:9px;border:none;background:var(--paper);color:var(--ink2);font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background var(--transition);}
.cart-close:hover{background:var(--border);}
.cart-items{flex:1;overflow-y:auto;padding:20px 24px;}
.cart-item{display:flex;gap:14px;padding:16px 0;border-bottom:1px solid var(--border);animation:slideIn .25s ease;}
@keyframes slideIn{from{opacity:0;transform:translateX(20px)}to{opacity:1;transform:translateX(0)}}
.ci-img{width:68px;height:68px;border-radius:10px;object-fit:cover;flex-shrink:0;}
.ci-info{flex:1;min-width:0;}
.ci-name{font-weight:700;font-size:.9rem;color:var(--ink);line-height:1.3;margin-bottom:3px;}
.ci-sub{font-size:.78rem;color:var(--muted);}
.ci-actions{display:flex;align-items:center;justify-content:space-between;margin-top:10px;}
.ci-qty{display:flex;align-items:center;gap:8px;}
.ci-qty button{width:26px;height:26px;border-radius:6px;border:1.5px solid var(--border);background:var(--white);color:var(--ink2);font-size:.85rem;cursor:pointer;transition:all var(--transition);}
.ci-qty button:hover{border-color:var(--g400);background:var(--g50);}
.ci-qty span{font-weight:700;font-size:.88rem;min-width:18px;text-align:center;}
.ci-price{font-weight:800;color:var(--g800);}
.ci-remove{background:none;border:none;color:#ccc;cursor:pointer;font-size:.85rem;transition:color var(--transition);}
.ci-remove:hover{color:var(--red);}
.cart-footer{padding:20px 24px;border-top:1px solid var(--border);background:var(--white);}
.cart-subtotal{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.cart-subtotal span{font-size:.9rem;color:var(--muted);}
.cart-subtotal strong{font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--ink);}
.cart-delivery{font-size:.8rem;color:var(--g500);margin-bottom:18px;display:flex;align-items:center;gap:6px;}
.checkout-btn{width:100%;padding:15px;background:var(--g700);color:#fff;border:none;border-radius:12px;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:700;cursor:pointer;transition:all var(--transition);display:flex;align-items:center;justify-content:center;gap:10px;}
.checkout-btn:hover{background:var(--g800);}
.cart-empty-msg{text-align:center;padding:60px 20px;color:var(--muted);}
.cart-empty-msg i{font-size:3rem;margin-bottom:14px;color:var(--g200);display:block;}

/* ── TOAST ── */
.toast{position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(80px);background:var(--g800);color:#fff;padding:12px 22px;border-radius:99px;font-size:.88rem;font-weight:600;display:flex;align-items:center;gap:9px;box-shadow:var(--shadow-lg);z-index:9999;opacity:0;transition:all .35s cubic-bezier(.34,1.56,.64,1);pointer-events:none;white-space:nowrap;}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0);}
.toast i{color:#86c98a;}

/* ── FOOTER ── */
footer{background:var(--g900);color:rgba(255,255,255,.6);padding:60px 28px 24px;}
.footer-grid{max-width:1280px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;}
.footer-brand .logo{color:#fff;margin-bottom:14px;display:inline-flex;}
.footer-brand p{font-size:.88rem;line-height:1.7;max-width:260px;}
.footer-col h4{font-family:'Playfair Display',serif;color:#fff;font-size:.95rem;margin-bottom:16px;}
.footer-col ul{list-style:none;}
.footer-col ul li{margin-bottom:9px;}
.footer-col ul li a{color:rgba(255,255,255,.5);text-decoration:none;font-size:.85rem;transition:color var(--transition);}
.footer-col ul li a:hover{color:#86c98a;}
.footer-bottom{max-width:1280px;margin:40px auto 0;padding-top:20px;border-top:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center;font-size:.82rem;flex-wrap:wrap;gap:10px;}

/* ── SCROLL ANIM ── */
.reveal{opacity:0;transform:translateY(24px);transition:opacity .55s cubic-bezier(.4,0,.2,1),transform .55s cubic-bezier(.4,0,.2,1);}
.reveal.on{opacity:1;transform:translateY(0);}
.reveal.d1{transition-delay:.06s;}.reveal.d2{transition-delay:.12s;}.reveal.d3{transition-delay:.18s;}.reveal.d4{transition-delay:.24s;}.reveal.d5{transition-delay:.30s;}.reveal.d6{transition-delay:.36s;}

/* ── RESPONSIVE ── */
@media(max-width:1024px){.hero-img-grid{display:none;}.footer-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:768px){.shop-wrap{flex-direction:column;}.sidebar{width:100%;position:static;}.hero h1{font-size:2rem;}.nav-links{display:none;}.sidebar-block{display:none;}}
@media(max-width:480px){.product-grid{grid-template-columns:repeat(2,1fr);gap:14px;}.hero{padding:50px 20px 60px;}}
</style>
</head>
<body>

<div id="loader">
  <div class="ld-logo"><i class="fas fa-seedling"></i> FarmDirect<em>+</em></div>
  <div class="ld-track"><div class="ld-fill"></div></div>
</div>

<div class="toast" id="toast"><i class="fas fa-check-circle"></i><span id="toastMsg">Added!</span></div>

<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>

<div class="cart-drawer" id="cartDrawer">
  <div class="cart-head">
    <h2><i class="fas fa-basket-shopping" style="color:var(--g500);margin-right:10px;"></i>Your Basket</h2>
    <button class="cart-close" onclick="closeCart()"><i class="fas fa-xmark"></i></button>
  </div>
  <div class="cart-items" id="cartItems"></div>
  <div class="cart-footer" id="cartFooter" style="display:none;">
    <div class="cart-subtotal"><span>Subtotal</span><strong id="cartTotal">$0.00</strong></div>
    <p class="cart-delivery"><i class="fas fa-truck"></i> Free delivery on orders over $35</p>
    <button class="checkout-btn" onclick="window.location.href='checkout.php';">
      <i class="fas fa-lock"></i> Secure Checkout
    </button>
  </div>
</div>

<header>
  <nav class="nav">
    <a href="index.php" class="logo"><i class="fas fa-leaf"></i> FarmDirect<em>+</em></a>
    
    <div class="nav-right">
      <?php if ($isLoggedIn): ?>
          <?php if ($isAdmin): ?>
              <a href="admin_dashboard.php" class="nav-btn ghost" title="Go to Admin Panel"><i class="fas fa-shield-alt"></i> Admin</a>
          <?php elseif ($isFarmer): ?>
              <a href="farmer_dashboard.php" class="nav-btn ghost" title="Go to Farmer Dashboard"><i class="fas fa-tractor"></i> Dashboard</a>
          <?php else: ?>
              <a href="account.php" class="nav-btn ghost" title="My Account"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($userName); ?></a>
          <?php endif; ?>
          <a href="logout.php" class="nav-btn ghost" style="color: var(--red); border-color: #ffcdd2;" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
      <?php else: ?>
          <a href="login.php" class="nav-btn ghost"><i class="fas fa-user"></i> Login</a>
      <?php endif; ?>

      <button class="cart-btn" onclick="openCart()" title="View Basket">
        <i class="fas fa-basket-shopping"></i>
        <span class="cart-count" id="cartCount">0</span>
      </button>
    </div>
  </nav>
</header>

<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-inner">
    <div class="hero-text">
      <div class="hero-pill"><i class="fas fa-seedling"></i> Harvested this week</div>
      <h1>Fresh Food,<br><em>Direct from</em><br>Local Farms</h1>
      <p class="hero-sub">Over 80 seasonal products from 24 verified local farms. No middlemen. Just honest food.</p>
      <div class="hero-ctas">
        <a href="#shop" class="btn-primary"><i class="fas fa-store"></i> Shop Now</a>
        <a href="#" class="btn-outline"><i class="fas fa-play-circle"></i> Our Story</a>
      </div>
      <div class="hero-stats">
        <div class="stat"><strong>80+</strong>Products</div>
        <div class="stat"><strong>24</strong>Local Farms</div>
        <div class="stat"><strong>4.9★</strong>Rating</div>
      </div>
    </div>
    <div class="hero-img-grid">
      <img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?w=800&q=80" alt="Fresh produce">
      <img src="https://images.unsplash.com/photo-1560806887-1e4cd0b6faa6?w=400&q=80" alt="Apples">
      <img src="https://images.unsplash.com/photo-1587049352847-81a56d773c1c?w=400&q=80" alt="Honey">
    </div>
  </div>
</section>

<div class="cats-wrap" id="shop">
  <div class="cats-inner" id="catTabs"></div>
</div>

<div class="shop-wrap">
  <aside class="sidebar">
    <div class="sidebar-block">
      <div class="sb-title"><i class="fas fa-tag"></i> Labels</div>
      <label class="sb-check"><input type="checkbox" id="fOrganic"> Organic only</label>
      <label class="sb-check"><input type="checkbox" id="fSale"> On sale</label>
      <label class="sb-check"><input type="checkbox" id="fBest"> Bestsellers</label>
      <label class="sb-check"><input type="checkbox" id="fNew"> New arrivals</label>
    </div>
    <div class="sidebar-block">
      <div class="sb-title"><i class="fas fa-dollar-sign"></i> Max Price</div>
      <input type="range" class="price-range" min="1" max="50" value="50" id="priceRange">
      <div class="price-vals"><span>$1</span><span id="priceVal">$50+</span></div>
    </div>
    <div class="sidebar-block">
      <div class="sb-title"><i class="fas fa-star"></i> Min Rating</div>
      <label class="sb-check"><input type="radio" name="ratingFilter" value="0" checked> All ratings</label>
      <label class="sb-check"><input type="radio" name="ratingFilter" value="4"> 4★ & above</label>
      <label class="sb-check"><input type="radio" name="ratingFilter" value="4.5"> 4.5★ & above</label>
    </div>
    <button class="clear-btn" onclick="clearFilters()"><i class="fas fa-rotate-left"></i> Clear All Filters</button>
  </aside>

  <div class="products-main">
    <div class="products-toolbar reveal">
      <div class="toolbar-left">
        <h2 id="sectionTitle">All Products</h2>
        <p id="productCount">Loading…</p>
      </div>
      <div class="toolbar-right">
        <select class="sort-sel" id="sortSel">
          <option value="featured">Sort: Featured</option>
          <option value="price-asc">Price: Low → High</option>
          <option value="price-desc">Price: High → Low</option>
          <option value="rating">Top Rated</option>
          <option value="name">Name A–Z</option>
        </select>
        <div class="view-toggle">
          <button class="view-btn active" id="gridViewBtn" onclick="setView('grid')" title="Grid view"><i class="fas fa-grid-2"></i></button>
          <button class="view-btn" id="listViewBtn" onclick="setView('list')" title="List view"><i class="fas fa-list"></i></button>
        </div>
      </div>
    </div>
    <div class="product-grid" id="productGrid"></div>
  </div>
</div>

<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <a href="#" class="logo"><i class="fas fa-leaf"></i> FarmDirect<em style="color:var(--amber)">+</em></a>
      <p>Connecting conscious consumers with local farmers since 2019. Eat fresh, live well, support your community.</p>
    </div>
    <div class="footer-col">
      <h4>Shop</h4>
      <ul>
        <li><a href="#">Vegetables</a></li>
        <li><a href="#">Fruits</a></li>
        <li><a href="#">Dairy & Eggs</a></li>
        <li><a href="#">Pantry</a></li>
        <li><a href="#">Meat & Fish</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Our Farmers</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Press</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Help</h4>
      <ul>
        <li><a href="#">Delivery Info</a></li>
        <li><a href="#">Returns</a></li>
        <li><a href="#">FAQ</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Privacy Policy</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© <?php echo date('Y'); ?> FarmDirect+. All rights reserved.</span>
    <span><i class="fas fa-leaf" style="color:var(--g400)"></i> Committed to sustainable farming</span>
  </div>
</footer>

<script>
// ─── DATA ───────────────────────────────────────────────────────────
const PRODUCTS = [
  // VEGETABLES (cat 1)
  {id:1,cat:"Vegetables",name:"Organic Vine Tomatoes",farm:"Green Valley Farm",price:4.99,unit:"lb",rating:4.5,reviews:124,badge:"organic",img:"https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=480&q=75"},
  {id:2,cat:"Vegetables",name:"Fresh Heirloom Carrots",farm:"Sunrise Acres",price:3.25,unit:"bunch",rating:4.1,reviews:48,badge:null,img:"https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=480&q=75"},
  {id:3,cat:"Vegetables",name:"Crisp Baby Spinach",farm:"Happy Roots Co.",price:3.50,unit:"bag",rating:4.3,reviews:91,badge:"organic",img:"https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=480&q=75"},
  {id:4,cat:"Vegetables",name:"Mixed Bell Peppers",farm:"Valley Fields",price:3.99,unit:"3-pack",rating:4.0,reviews:67,badge:null,img:"https://images.unsplash.com/photo-1563565375-f3fdfdbefa8a?w=480&q=75"},
  {id:5,cat:"Vegetables",name:"Organic Sweet Potatoes",farm:"Red Clay Farm",price:2.40,oldPrice:3.00,unit:"lb",rating:4.8,reviews:155,badge:"sale",img:"https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=480&q=75"},
  {id:6,cat:"Vegetables",name:"Fresh Basil Bunch",farm:"Herb Garden Farm",price:2.99,unit:"bunch",rating:4.4,reviews:72,badge:"organic",img:"https://images.unsplash.com/photo-1615486171448-4af40212f434?w=480&q=75"},
  {id:7,cat:"Vegetables",name:"Fresh Red Onions",farm:"Sunrise Acres",price:2.50,unit:"lb",rating:4.2,reviews:43,badge:null,img:"https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=480&q=75"},
  {id:8,cat:"Vegetables",name:"Organic Garlic Bulbs",farm:"Green Valley Farm",price:3.20,unit:"3-pack",rating:4.6,reviews:88,badge:"organic",img:"https://images.unsplash.com/photo-1540148426947-1fceb20dd676?w=480&q=75"},
  {id:9,cat:"Vegetables",name:"Baby Kale Mix",farm:"Happy Roots Co.",price:4.25,unit:"bag",rating:4.3,reviews:61,badge:"new",img:"https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=480&q=75"},
  {id:10,cat:"Vegetables",name:"Purple Cauliflower",farm:"Heritage Harvest",price:5.50,unit:"head",rating:4.7,reviews:39,badge:"new",img:"https://images.unsplash.com/photo-1459411621453-7b03977f4bfc?w=480&q=75"},
  {id:11,cat:"Vegetables",name:"Fresh Broccoli",farm:"Valley Fields",price:2.99,unit:"head",rating:4.2,reviews:55,badge:null,img:"https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=480&q=75"},
  {id:12,cat:"Vegetables",name:"English Cucumbers",farm:"Sunrise Acres",price:1.99,unit:"each",rating:4.0,reviews:37,badge:null,img:"https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=480&q=75"},
  {id:13,cat:"Vegetables",name:"Rainbow Chard",farm:"Herb Garden Farm",price:3.75,unit:"bunch",rating:4.5,reviews:29,badge:"organic",img:"https://images.unsplash.com/photo-1540420773420-3366772f4999?w=480&q=75"},
  {id:14,cat:"Vegetables",name:"Butternut Squash",farm:"Red Clay Farm",price:3.50,unit:"each",rating:4.1,reviews:44,badge:null,img:"https://images.unsplash.com/photo-1570586437263-ab629fccc818?w=480&q=75"},

  // FRUITS (cat 2)
  {id:20,cat:"Fruits",name:"Crisp Honeycrisp Apples",farm:"Orchard Hill",price:5.50,unit:"lb",rating:4.6,reviews:203,badge:"organic",img:"https://images.unsplash.com/photo-1560806887-1e4cd0b6faa6?w=480&q=75"},
  {id:21,cat:"Fruits",name:"Fresh Field Strawberries",farm:"Berry Patch Farm",price:6.99,unit:"box",rating:4.9,reviews:312,badge:"bestseller",img:"https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=480&q=75"},
  {id:22,cat:"Fruits",name:"Wild Blueberries",farm:"Northern Berry Co.",price:5.99,unit:"pint",rating:4.8,reviews:187,badge:"organic",img:"https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=480&q=75"},
  {id:23,cat:"Fruits",name:"Hass Avocados",farm:"SunGrove Farms",price:5.00,unit:"2-pack",rating:4.7,reviews:241,badge:"organic",img:"https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=480&q=75"},
  {id:24,cat:"Fruits",name:"Meyer Lemons",farm:"Citrus Grove",price:4.25,unit:"bag",rating:4.2,reviews:76,badge:"organic",img:"https://images.unsplash.com/photo-1590502593747-42a996133562?w=480&q=75"},
  {id:25,cat:"Fruits",name:"Juicy Watermelon",farm:"Summer Sun Farm",price:8.99,oldPrice:11.00,unit:"each",rating:4.6,reviews:129,badge:"sale",img:"https://images.unsplash.com/photo-1589984662646-e7b2e4962f18?w=480&q=75"},
  {id:26,cat:"Fruits",name:"Bosc Pears",farm:"Orchard Hill",price:4.50,unit:"lb",rating:4.1,reviews:54,badge:null,img:"https://images.unsplash.com/photo-1514756331096-242fdeb70d4a?w=480&q=75"},
  {id:27,cat:"Fruits",name:"Mandarin Oranges",farm:"Citrus Grove",price:5.25,unit:"bag",rating:4.5,reviews:98,badge:"bestseller",img:"https://images.unsplash.com/photo-1548095440-4cbe30dce3fd?w=480&q=75"},
  {id:28,cat:"Fruits",name:"Black Cherries",farm:"Cherry Top Farm",price:7.99,unit:"lb",rating:4.8,reviews:143,badge:"new",img:"https://images.unsplash.com/photo-1528821128474-27f963b062bf?w=480&q=75"},
  {id:29,cat:"Fruits",name:"Golden Kiwi",farm:"SunGrove Farms",price:3.99,unit:"4-pack",rating:4.3,reviews:67,badge:"new",img:"https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=480&q=75"},
  {id:30,cat:"Fruits",name:"Red Grapes",farm:"Vine Valley",price:5.75,unit:"lb",rating:4.4,reviews:88,badge:null,img:"https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=480&q=75"},
  {id:31,cat:"Fruits",name:"Fresh Figs",farm:"Mediterranean Grove",price:6.50,unit:"punnet",rating:4.7,reviews:51,badge:"organic",img:"https://images.unsplash.com/photo-1601379327928-bedfaf9da2d0?w=480&q=75"},
  {id:32,cat:"Fruits",name:"Mango Alphonso",farm:"Tropical Roots",price:4.99,unit:"2-pack",rating:4.9,reviews:174,badge:"bestseller",img:"https://images.unsplash.com/photo-1554187140-cf51fdcda3f5?w=480&q=75"},

  // DAIRY & EGGS (cat 3)
  {id:40,cat:"Dairy & Eggs",name:"Pasture-Raised Brown Eggs",farm:"Clover Creek Ranch",price:6.50,unit:"dozen",rating:4.9,reviews:412,badge:"bestseller",img:"https://images.unsplash.com/photo-1587486913049-53fc88980cb6?w=480&q=75"},
  {id:41,cat:"Dairy & Eggs",name:"Grass-Fed Whole Milk",farm:"Meadow Fresh Dairy",price:4.50,unit:"gallon",rating:4.6,reviews:189,badge:null,img:"https://images.unsplash.com/photo-1550583724-b2692b85b150?w=480&q=75"},
  {id:42,cat:"Dairy & Eggs",name:"Aged Farmhouse Cheddar",farm:"Artisan Creamery",price:8.50,unit:"block",rating:4.8,reviews:267,badge:"bestseller",img:"https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=480&q=75"},
  {id:43,cat:"Dairy & Eggs",name:"Plain Greek Yogurt",farm:"Meadow Fresh Dairy",price:5.25,unit:"tub",rating:4.5,reviews:134,badge:null,img:"https://images.unsplash.com/photo-1488477181946-6428a0291777?w=480&q=75"},
  {id:44,cat:"Dairy & Eggs",name:"Cultured Butter",farm:"Normandy-Style Farm",price:7.99,unit:"block",rating:4.7,reviews:96,badge:"new",img:"https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=480&q=75"},
  {id:45,cat:"Dairy & Eggs",name:"Fresh Mozzarella",farm:"Artisan Creamery",price:6.25,unit:"ball",rating:4.6,reviews:118,badge:"organic",img:"https://images.unsplash.com/photo-1563599175592-c58dc214deff?w=480&q=75"},
  {id:46,cat:"Dairy & Eggs",name:"Free-Range Duck Eggs",farm:"Clover Creek Ranch",price:9.50,unit:"half-dz",rating:4.5,reviews:44,badge:"new",img:"https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=480&q=75"},
  {id:47,cat:"Dairy & Eggs",name:"Goat Cheese Log",farm:"Caprine Creamery",price:7.50,unit:"log",rating:4.8,reviews:79,badge:"organic",img:"https://images.unsplash.com/photo-1452195100486-9cc805987862?w=480&q=75"},
  {id:48,cat:"Dairy & Eggs",name:"Crème Fraîche",farm:"Normandy-Style Farm",price:5.75,unit:"tub",rating:4.4,reviews:53,badge:null,img:"https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?w=480&q=75"},

  // PANTRY (cat 4)
  {id:60,cat:"Pantry",name:"Raw Wildflower Honey",farm:"Golden Hive Apiaries",price:12.99,oldPrice:15.50,unit:"jar",rating:4.9,reviews:389,badge:"sale",img:"https://images.unsplash.com/photo-1587049352847-81a56d773c1c?w=480&q=75"},
  {id:61,cat:"Pantry",name:"Artisan Sourdough Bread",farm:"Old World Bakehouse",price:7.00,unit:"loaf",rating:4.9,reviews:521,badge:"bestseller",img:"https://images.unsplash.com/photo-1589367920969-ab8e050bf0ef?w=480&q=75"},
  {id:62,cat:"Pantry",name:"Extra Virgin Olive Oil",farm:"Tuscan Grove Estate",price:14.99,unit:"bottle",rating:4.8,reviews:203,badge:null,img:"https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=480&q=75"},
  {id:63,cat:"Pantry",name:"Pure Maple Syrup",farm:"Vermont Sugar Shack",price:18.99,unit:"bottle",rating:4.9,reviews:445,badge:"bestseller",img:"https://images.unsplash.com/photo-1580915411954-282cb1b0d780?w=480&q=75"},
  {id:64,cat:"Pantry",name:"Stone-Ground Oats",farm:"Prairie Wind Mill",price:6.50,unit:"bag",rating:4.5,reviews:112,badge:"organic",img:"https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=480&q=75"},
  {id:65,cat:"Pantry",name:"Black Bean Pasta",farm:"Legume Craft",price:5.25,unit:"pack",rating:4.3,reviews:67,badge:"new",img:"https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=480&q=75"},
  {id:66,cat:"Pantry",name:"Cold-Pressed Walnut Oil",farm:"Nut Grove Estate",price:16.50,unit:"bottle",rating:4.6,reviews:48,badge:"new",img:"https://images.unsplash.com/photo-1612528443702-f6741f70a049?w=480&q=75"},
  {id:67,cat:"Pantry",name:"Organic Apple Cider Vinegar",farm:"Heritage Orchard",price:8.99,unit:"bottle",rating:4.7,reviews:138,badge:"organic",img:"https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=480&q=75"},
  {id:68,cat:"Pantry",name:"Sunflower Seed Butter",farm:"Prairie Sunfields",price:9.75,unit:"jar",rating:4.4,reviews:84,badge:null,img:"https://images.unsplash.com/photo-1559181567-c3190e788af7?w=480&q=75"},
  {id:69,cat:"Pantry",name:"Buckwheat Flour",farm:"Prairie Wind Mill",price:5.50,unit:"bag",rating:4.2,reviews:39,badge:"organic",img:"https://images.unsplash.com/photo-1587049633312-d628ae50a8ae?w=480&q=75"},
  {id:70,cat:"Pantry",name:"Spiced Granola",farm:"Old World Bakehouse",price:7.25,unit:"bag",rating:4.8,reviews:176,badge:"bestseller",img:"https://images.unsplash.com/photo-1517093157656-b9eccef91cb1?w=480&q=75"},

  // MEAT & FISH (cat 5)
  {id:80,cat:"Meat & Fish",name:"Grass-Fed Ground Beef",farm:"Rolling Hills Ranch",price:9.99,unit:"lb",rating:4.7,reviews:189,badge:"organic",img:"https://images.unsplash.com/photo-1603048297172-c92544798d5a?w=480&q=75"},
  {id:81,cat:"Meat & Fish",name:"Free-Range Chicken Breast",farm:"Meadowlark Poultry",price:8.50,unit:"lb",rating:4.6,reviews:214,badge:"bestseller",img:"https://images.unsplash.com/photo-1604503468506-a8da13d11d36?w=480&q=75"},
  {id:82,cat:"Meat & Fish",name:"Wild Salmon Fillet",farm:"Pacific Catch Co.",price:14.99,oldPrice:18.00,unit:"lb",rating:4.8,reviews:163,badge:"sale",img:"https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=480&q=75"},
  {id:83,cat:"Meat & Fish",name:"Pork Tenderloin",farm:"Heritage Pork Farm",price:11.50,unit:"lb",rating:4.5,reviews:87,badge:null,img:"https://images.unsplash.com/photo-1432139555190-58524dae6a55?w=480&q=75"},
  {id:84,cat:"Meat & Fish",name:"Smoked Turkey Breast",farm:"Meadowlark Poultry",price:12.99,unit:"lb",rating:4.6,reviews:72,badge:"new",img:"https://images.unsplash.com/photo-1574672280600-4accfa5b6f98?w=480&q=75"},
  {id:85,cat:"Meat & Fish",name:"Atlantic Cod Fillets",farm:"Pacific Catch Co.",price:13.50,unit:"lb",rating:4.4,reviews:58,badge:null,img:"https://images.unsplash.com/photo-1618897996318-5a901fa6ca71?w=480&q=75"},
  {id:86,cat:"Meat & Fish",name:"Lamb Shoulder Chops",farm:"Highland Pastures",price:15.99,unit:"lb",rating:4.7,reviews:44,badge:"organic",img:"https://images.unsplash.com/photo-1529543544282-ea669407fca3?w=480&q=75"},
  {id:87,cat:"Meat & Fish",name:"Dry-Aged Ribeye Steak",farm:"Rolling Hills Ranch",price:24.99,unit:"each",rating:4.9,reviews:132,badge:"bestseller",img:"https://images.unsplash.com/photo-1546964124-0cce460f38ef?w=480&q=75"},

  // HERBS & FLOWERS (cat 6)
  {id:100,cat:"Herbs & Flowers",name:"Fresh Rosemary Sprigs",farm:"Herb Garden Farm",price:2.49,unit:"bunch",rating:4.5,reviews:66,badge:"organic",img:"https://images.unsplash.com/photo-1515586000433-45406d8e6662?w=480&q=75"},
  {id:101,cat:"Herbs & Flowers",name:"Potted Mint Plant",farm:"Green Thumb Nursery",price:4.99,unit:"pot",rating:4.7,reviews:89,badge:"new",img:"https://images.unsplash.com/photo-1628624747186-a941c476b7ef?w=480&q=75"},
  {id:102,cat:"Herbs & Flowers",name:"Dried Lavender Bouquet",farm:"Provence Fields",price:6.99,unit:"bunch",rating:4.8,reviews:113,badge:"bestseller",img:"https://images.unsplash.com/photo-1499002238440-d264edd596ec?w=480&q=75"},
  {id:103,cat:"Herbs & Flowers",name:"Fresh Thyme Bundle",farm:"Herb Garden Farm",price:2.25,unit:"bunch",rating:4.3,reviews:48,badge:"organic",img:"https://images.unsplash.com/photo-1604328698692-f76ea9498e76?w=480&q=75"},
  {id:104,cat:"Herbs & Flowers",name:"Sunflower Bunch",farm:"Prairie Sunfields",price:7.50,unit:"bunch",rating:4.9,reviews:201,badge:"bestseller",img:"https://images.unsplash.com/photo-1597848212624-a19eb35e2651?w=480&q=75"},
  {id:105,cat:"Herbs & Flowers",name:"Fresh Chives",farm:"Green Thumb Nursery",price:1.99,unit:"bunch",rating:4.2,reviews:34,badge:"organic",img:"https://images.unsplash.com/photo-1616687989826-685aeae3df95?w=480&q=75"},
  {id:106,cat:"Herbs & Flowers",name:"Edible Flower Mix",farm:"Provence Fields",price:5.99,unit:"punnet",rating:4.7,reviews:78,badge:"new",img:"https://images.unsplash.com/photo-1490750967868-88df5691cc5e?w=480&q=75"},
];

const CATEGORIES = [
  {name:"All",icon:"fas fa-store"},
  {name:"Vegetables",icon:"fas fa-carrot"},
  {name:"Fruits",icon:"fas fa-apple-whole"},
  {name:"Dairy & Eggs",icon:"fas fa-egg"},
  {name:"Pantry",icon:"fas fa-jar"},
  {name:"Meat & Fish",icon:"fas fa-drumstick-bite"},
  {name:"Herbs & Flowers",icon:"fas fa-seedling"},
];

// ─── STATE ───────────────────────────────────────────────────────────
let activeCategory = "All";
let cart = {};
let currentView = "grid";

// ─── INIT ─────────────────────────────────────────────────────────────
window.addEventListener('load', () => {
  setTimeout(()=>{ document.getElementById('loader').classList.add('out'); },1400);
  buildCategoryTabs();
  renderProducts();
  setupFilters();
});

// ─── CATEGORY TABS ────────────────────────────────────────────────────
function buildCategoryTabs(){
  const el = document.getElementById('catTabs');
  CATEGORIES.forEach(c=>{
    const count = c.name==="All" ? PRODUCTS.length : PRODUCTS.filter(p=>p.cat===c.name).length;
    const btn = document.createElement('button');
    btn.className = 'cat-tab' + (c.name===activeCategory?' active':'');
    btn.innerHTML = `<i class="${c.icon}"></i> ${c.name} <span class="count">${count}</span>`;
    btn.onclick = ()=>{ activeCategory=c.name; document.querySelectorAll('.cat-tab').forEach(b=>b.classList.remove('active')); btn.classList.add('active'); document.getElementById('sectionTitle').textContent = c.name==="All"?"All Products":c.name; renderProducts(); };
    el.appendChild(btn);
  });
}

// ─── RENDER PRODUCTS ──────────────────────────────────────────────────
function renderProducts(){
  let list = activeCategory==="All" ? [...PRODUCTS] : PRODUCTS.filter(p=>p.cat===activeCategory);

  // filters
  if(document.getElementById('fOrganic')?.checked) list=list.filter(p=>p.badge==='organic');
  if(document.getElementById('fSale')?.checked) list=list.filter(p=>p.badge==='sale');
  if(document.getElementById('fBest')?.checked) list=list.filter(p=>p.badge==='bestseller');
  if(document.getElementById('fNew')?.checked) list=list.filter(p=>p.badge==='new');
  const maxP = parseInt(document.getElementById('priceRange')?.value||50);
  if(maxP<50) list=list.filter(p=>p.price<=maxP);
  const minR = parseFloat(document.querySelector('input[name="ratingFilter"]:checked')?.value||0);
  if(minR>0) list=list.filter(p=>p.rating>=minR);

  // sort
  const sort = document.getElementById('sortSel')?.value||'featured';
  if(sort==='price-asc') list.sort((a,b)=>a.price-b.price);
  else if(sort==='price-desc') list.sort((a,b)=>b.price-a.price);
  else if(sort==='rating') list.sort((a,b)=>b.rating-a.rating);
  else if(sort==='name') list.sort((a,b)=>a.name.localeCompare(b.name));

  const grid = document.getElementById('productGrid');
  document.getElementById('productCount').textContent = list.length + ' product' + (list.length!==1?'s':'') + ' found';

  if(list.length===0){
    grid.innerHTML=`<div class="empty-state" style="grid-column:1/-1"><i class="fas fa-magnifying-glass"></i><h3>No products found</h3><p>Try adjusting your filters or browsing another category.</p></div>`;
    return;
  }

  grid.innerHTML = '';
  const delays = ['d1','d2','d3','d4','d5','d6'];
  list.forEach((p,i)=>{
    const inCart = cart[p.id]||0;
    const stars = renderStars(p.rating);
    const badgeHtml = p.badge ? `<span class="card-badge badge-${p.badge==='organic'?'org':p.badge==='bestseller'?'best':p.badge==='sale'?'sale':'new'}">${p.badge==='organic'?'Organic':p.badge==='bestseller'?'Bestseller':p.badge==='sale'?'Sale':'New'}</span>` : '';
    const priceHtml = p.oldPrice ? `<span class="price-main">$${p.price.toFixed(2)}</span><span class="price-old">$${p.oldPrice.toFixed(2)}</span>` : `<span class="price-main">$${p.price.toFixed(2)}</span>`;
    const actionHtml = inCart>0
      ? `<div class="qty-ctrl"><button onclick="changeQty(${p.id},-1)"><i class="fas fa-minus"></i></button><span>${inCart}</span><button onclick="changeQty(${p.id},1)"><i class="fas fa-plus"></i></button></div>`
      : `<button class="add-btn" onclick="addToCart(${p.id})" title="Add to basket"><i class="fas fa-plus"></i></button>`;

    const card = document.createElement('div');
    card.className = `product-card reveal ${delays[i%6]}${currentView==='list'?' list-view':''}`;
    card.id = `card-${p.id}`;
    card.innerHTML = `
      <div class="card-img-wrap">
        <img src="${p.img}" alt="${p.name}" loading="lazy">
        ${badgeHtml}
        <button class="card-wish" onclick="toggleWish(this)" title="Wishlist"><i class="far fa-heart"></i></button>
      </div>
      <div class="card-body">
        <p class="card-cat">${p.cat}</p>
        <h3 class="card-name">${p.name}</h3>
        <p class="card-farm"><i class="fas fa-location-dot"></i>${p.farm}</p>
        <div class="card-stars">${stars}<span>(${p.reviews})</span></div>
        <div class="card-footer">
          <div class="card-price">${priceHtml}<span class="price-meta">/ ${p.unit}</span></div>
          ${actionHtml}
        </div>
      </div>`;
    grid.appendChild(card);
  });

  // trigger reveal
  requestAnimationFrame(()=>{
    const obs = new IntersectionObserver((entries,o)=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');o.unobserve(e.target);}});},{threshold:.08});
    document.querySelectorAll('.reveal:not(.on)').forEach(el=>obs.observe(el));
  });
}

function renderStars(r){
  let s='';
  for(let i=1;i<=5;i++){
    if(r>=i) s+='<i class="fas fa-star"></i>';
    else if(r>=i-.5) s+='<i class="fas fa-star-half-stroke"></i>';
    else s+='<i class="far fa-star"></i>';
  }
  return s;
}

// ─── FILTERS ──────────────────────────────────────────────────────────
function setupFilters(){
  ['fOrganic','fSale','fBest','fNew'].forEach(id=>{ document.getElementById(id).addEventListener('change',renderProducts); });
  document.querySelectorAll('input[name="ratingFilter"]').forEach(r=>r.addEventListener('change',renderProducts));
  document.getElementById('priceRange').addEventListener('input',function(){
    document.getElementById('priceVal').textContent = this.value>=50?'$50+':'$'+this.value;
    renderProducts();
  });
  document.getElementById('sortSel').addEventListener('change',renderProducts);
}
function clearFilters(){
  ['fOrganic','fSale','fBest','fNew'].forEach(id=>{document.getElementById(id).checked=false;});
  document.querySelector('input[name="ratingFilter"][value="0"]').checked=true;
  document.getElementById('priceRange').value=50;
  document.getElementById('priceVal').textContent='$50+';
  renderProducts();
}

// ─── VIEW TOGGLE ──────────────────────────────────────────────────────
function setView(v){
  currentView=v;
  document.getElementById('gridViewBtn').classList.toggle('active',v==='grid');
  document.getElementById('listViewBtn').classList.toggle('active',v==='list');
  const g=document.getElementById('productGrid');
  g.classList.toggle('list-view',v==='list');
  renderProducts();
}

// ─── CART ─────────────────────────────────────────────────────────────
function addToCart(id){
  cart[id] = (cart[id]||0)+1;
  updateCartUI();
  const p = PRODUCTS.find(x=>x.id===id);
  showToast(p.name+' added to basket','fas fa-check-circle');
  refreshCard(id);
}
function changeQty(id,delta){
  cart[id] = Math.max(0,(cart[id]||0)+delta);
  if(cart[id]===0) delete cart[id];
  updateCartUI();
  refreshCard(id);
}
function refreshCard(id){
  const inCart = cart[id]||0;
  const card = document.getElementById('card-'+id);
  if(!card) return;
  const footer = card.querySelector('.card-footer');
  if(!footer) return;
  const oldAction = footer.querySelector('.add-btn,.qty-ctrl');
  if(oldAction) oldAction.remove();
  const div = document.createElement('div');
  div.innerHTML = inCart>0
    ? `<div class="qty-ctrl"><button onclick="changeQty(${id},-1)"><i class="fas fa-minus"></i></button><span>${inCart}</span><button onclick="changeQty(${id},1)"><i class="fas fa-plus"></i></button></div>`
    : `<button class="add-btn" onclick="addToCart(${id})"><i class="fas fa-plus"></i></button>`;
  footer.appendChild(div.firstElementChild);
}
function updateCartUI(){
  const total = Object.values(cart).reduce((s,v)=>s+v,0);
  const countEl = document.getElementById('cartCount');
  countEl.textContent=total;
  countEl.classList.remove('bump');
  void countEl.offsetWidth;
  countEl.classList.add('bump');
  if(document.getElementById('cartDrawer').classList.contains('open')) renderCartDrawer();
}
function renderCartDrawer(){
  const el = document.getElementById('cartItems');
  const footer = document.getElementById('cartFooter');
  const keys = Object.keys(cart).filter(k=>cart[k]>0);
  if(!keys.length){
    el.innerHTML=`<div class="cart-empty-msg"><i class="fas fa-basket-shopping"></i><p style="font-size:.95rem;font-weight:600;color:var(--ink2)">Your basket is empty</p><p style="font-size:.85rem;margin-top:6px">Add some fresh products!</p></div>`;
    footer.style.display='none'; return;
  }
  footer.style.display='block';
  let html='', total=0;
  keys.forEach(k=>{
    const p=PRODUCTS.find(x=>x.id==k); if(!p) return;
    const sub=(p.price*cart[k]);
    total+=sub;
    html+=`<div class="cart-item">
      <img src="${p.img}" class="ci-img" alt="${p.name}">
      <div class="ci-info">
        <div class="ci-name">${p.name}</div>
        <div class="ci-sub">${p.farm} · $${p.price.toFixed(2)}/${p.unit}</div>
        <div class="ci-actions">
          <div class="ci-qty">
            <button onclick="changeQty(${p.id},-1);renderCartDrawer()">−</button>
            <span>${cart[p.id]}</span>
            <button onclick="changeQty(${p.id},1);renderCartDrawer()">+</button>
          </div>
          <span class="ci-price">$${sub.toFixed(2)}</span>
          <button class="ci-remove" onclick="changeQty(${p.id},-999);renderCartDrawer()" title="Remove"><i class="fas fa-trash-can"></i></button>
        </div>
      </div>
    </div>`;
  });
  el.innerHTML=html;
  document.getElementById('cartTotal').textContent='$'+total.toFixed(2);
}
function openCart(){ renderCartDrawer(); document.getElementById('cartDrawer').classList.add('open'); document.getElementById('cartOverlay').classList.add('open'); document.body.style.overflow='hidden'; }
function closeCart(){ document.getElementById('cartDrawer').classList.remove('open'); document.getElementById('cartOverlay').classList.remove('open'); document.body.style.overflow=''; }

// ─── WISHLIST ─────────────────────────────────────────────────────────
function toggleWish(btn){
  btn.classList.toggle('on');
  const icon=btn.querySelector('i');
  icon.className=btn.classList.contains('on')?'fas fa-heart':'far fa-heart';
  showToast(btn.classList.contains('on')?'Saved to wishlist':'Removed from wishlist','fas fa-heart');
}

// ─── TOAST ────────────────────────────────────────────────────────────
let toastTimer;
function showToast(msg,icon='fas fa-check-circle'){
  clearTimeout(toastTimer);
  const t=document.getElementById('toast');
  t.innerHTML=`<i class="${icon}"></i><span>${msg}</span>`;
  t.classList.add('show');
  toastTimer=setTimeout(()=>t.classList.remove('show'),2600);
}

// ─── SCROLL REVEAL (toolbar) ──────────────────────────────────────────
const revealObs = new IntersectionObserver(entries=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');revealObs.unobserve(e.target);}});},{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>revealObs.observe(el));
</script>
</body>
</html>