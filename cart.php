<?php
    session_start();
    if(isset($_SESSION['userinfo'][0]['pfp']))
    {
        $data = $_SESSION['userinfo'][0]['pfp'];
    }
    include('connect.php');
    global $conn;

    if (isset($_POST['action']) && $_POST['action'] === 'addtocart')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $pid = $_POST['pid'];

        $existsql = "SELECT * FROM purchase_cart WHERE username = '$username' AND product_id = $pid";
        $existresult = $conn->query($existsql);
        $countexist = $existresult->num_rows;
        if($countexist == 1)
        {
            $updaterow = $existresult->fetch_assoc();
            $newqty = $updaterow['purchase_quantity'] + 1;
            $updatesql = "UPDATE purchase_cart SET purchase_quantity=$newqty WHERE product_id = $pid";
            $conn->query($updatesql);

        }
        else
        {
            $insertsql = "INSERT INTO purchase_cart (product_id, username, purchase_quantity) VALUES ($pid, '$username', 1)";
            $conn->query($insertsql);
        }

        $cartqty = 0;
        $qtysql = "SELECT purchase_quantity FROM purchase_cart WHERE username = '$username'";
        $result = $conn->query($qtysql);
        while($row = $result->fetch_assoc()) {
            $qty = (int)$row['purchase_quantity'];
            $cartqty += $qty;
        }
        exit;
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'deletefromcart')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $pid = $_POST['pid'];

        $qtyquery = "SELECT * FROM purchase_cart WHERE username = '$username' AND product_id = $pid";
        $qtyresult = $conn->query($qtyquery);
        $rowqty = $qtyresult->fetch_assoc();
        if ($rowqty['purchase_quantity'] > 1)
        {
            $newqty = $rowqty['purchase_quantity'] - 1;
            $updatesql = "UPDATE purchase_cart SET purchase_quantity=$newqty WHERE product_id = $pid";
            $conn->query($updatesql);
        }
        else{
            $deletesql = "DELETE FROM purchase_cart WHERE username = '$username' AND product_id = $pid";
            $conn->query($deletesql);
        }

        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'removefromcart')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $pid = $_POST['pid'];

        $deletesql = "DELETE FROM purchase_cart WHERE username = '$username' AND product_id = $pid";
        $check = $conn->query($deletesql);

        if($check) {
            echo "success";
        }
        else
        {
            echo "fail";
        }

        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'displayqty')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $cartqty = 0;
        $qtysql = "SELECT purchase_quantity FROM purchase_cart WHERE username = '$username'";
        $result = $conn->query($qtysql);
        while($row = $result->fetch_assoc()) {
            $qty = (int)$row['purchase_quantity'];
            $cartqty += $qty;
        }
        echo $cartqty;
        exit;
    }

    if(isset($_POST['action']) && $_POST['action'] === 'displaycartcontent')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $cartqty = 0;
        $qtysql = "SELECT purchase_quantity FROM purchase_cart WHERE username = '$username'";
        $result = $conn->query($qtysql);
        while($row = $result->fetch_assoc()) {
            $qty = (int)$row['purchase_quantity'];
            $cartqty += $qty;
        }
        if($cartqty != 0){
            $member = $_SESSION['userinfo'][0]['member'];
            $carttotal = 0;
            $dcartsql = "SELECT * FROM purchase_cart WHERE username = '$username'";
            $cartresult = $conn->query($dcartsql);
            while($row = $cartresult->fetch_assoc()) {
                $pid = $row['product_id'];
                $psql = "SELECT * FROM product WHERE product_id = $pid";
                $productresult = $conn->query($psql);
                $productrow = $productresult->fetch_assoc();
                $pqty = $row['purchase_quantity'];
                if($member == 1 && $productrow['member_discount'] == 1){
                    $producttotal = $row['purchase_quantity'] * ($productrow['product_price'] - ($productrow['product_price'] * 0.1));
                }
                else{
                    $producttotal = $row['purchase_quantity'] * ($productrow['product_price'] - ($productrow['product_price'] * $productrow['product_discount']));
                }
                $carttotal += $producttotal;

                echo '<div class="ct-contents">';
                echo '<div class="ct-image">';
                echo '<img src="' . $productrow['product_img'] .'"></div>';
                echo '<div class="ct-detail">';
                echo '<div class="ct-name">' . $productrow["product_name"] . '</div></div>';
                echo '<div class="ct-btns">';
                if($row['purchase_quantity'] > 1)
                {
                    echo '<button class="cdelbtn" value="' . $pid .'">-</button>';
                }
                else
                {
                    echo '<button class="cdelbtn" value="' . $pid .'"><img src="./Images/navbar/bin.png" class="binbtn"></button>';
                }
                
                echo '<div class="c-qty">' . $pqty . '</div>';
                echo '<button class="caddbtn" value="' . $row["product_id"] . '">+</button></div>';
                echo '<div class="ct-price">BHD ' . number_format($producttotal, 3) . '</div>';
                echo '<div class="removebtn"><button class="rbtn" value="' . $row["product_id"] .'">X</button></div></div>';
            }
        }
        else
        {
            echo '<div class="emptycart">';
            echo '<div class="emptytitle">Your Shopping Cart is Empty!</div>';
            echo '<div class="shopbtn">';
            echo '<a href="./product.php"><button>START SHOPPING</button></a>';
            echo '</div></div>';
        }
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] === 'cartamount')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $member = $_SESSION['userinfo'][0]['member'];
        $dcartsql = "SELECT * FROM purchase_cart WHERE username = '$username'";
        $cartresult = $conn->query($dcartsql);
        $mtotal = 0;
        $dtotal = 0;
        $ctotal = 0;
        $stotal = 0;
        while($row = $cartresult->fetch_assoc()) {
            $pid = $row['product_id'];
            $psql = "SELECT * FROM product WHERE product_id = $pid";
            $productresult = $conn->query($psql);
            $productrow = $productresult->fetch_assoc();
            $pqty = $row['purchase_quantity'];
            $discount = 0;
            $mdiscount = 0;
            $stotal += ($row['purchase_quantity'] * $productrow['product_price']);
            if($member == 1 && $productrow['member_discount'] == 1){
                $mdiscount = ($productrow['product_price'] * 0.1);
                $mdiscounted = ($productrow['product_price'] - $mdiscount);
                $producttotal = $row['purchase_quantity'] * $mdiscounted;
            }
            else{
                $discount = ($productrow['product_price'] * $productrow['product_discount']);
                $discounted = ($productrow['product_price'] - $discount);
                $producttotal = $row['purchase_quantity'] * $discounted;
            }
            $mtotal += ($mdiscount * $row['purchase_quantity']);
            $dtotal += ($discount * $row['purchase_quantity']);
            $ctotal += $producttotal;
        }
        echo '<div class="amount-title">Order Summary</div>';
        echo '<div class="amount-subtotals">';
        echo '<div class="subtotal"><div>Subtotal</div>';
        echo '<div>BHD ' . number_format($stotal, 3) . '</div></div>';
        echo '<div class="discounttotal"><div>Discounts</div>';
        echo '<div>- BHD ' . number_format($dtotal, 3) . '</div></div>';
        echo '<div class="membertotal"><div>Member Discounts</div>';
        echo '<div>- BHD ' . number_format($mtotal, 3) . '</div></div></div>';
        echo '<div class="amount-total">';
        echo '<div class="total">Total</div>';
        echo '<div class="total-amount">BHD ' . number_format($ctotal, 3) . '</div></div>';
        echo '<div class="checkoutbtn">';
        echo '<button>Continue to checkout</button></div>';
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./style.css">
        <title>
            LaLa Grocery Store
        </title>
    </head>
    <body>
        <header>
            <nav>
                <div class="navtop">
                    <div class="leftIcons">
                        <a href="./main.php">
                            <img src="./images/logo.png" class="logo" title="LaLa">
                        </a>
                    </div>                    
                    <div class="searchcontainer">
                        <form method="GET" action="product.php" class="searchbar">
                            <input type="text" name="search" placeholder="Search..">
                            <button type="submit"><img src="./Images/navbar/search.png"></button>
                        </form>
                    </div>
                    <div class="rightIcons">
                        <div class="pfp">
                            <img src="<?php echo $data; ?>" title="Profile" onclick="togglePMenu()">
                        </div>
                        <div class="cart">
                            <img src="./images/navbar/carticon.png" class="cart" title="Cart" onclick="toggleCartMenu()" id="cart">
                            <div class="cartqty" id="cartqty">
                                <?php  
                                    $username = $_SESSION['userinfo'][0]['username'];
                                    $cartqty = 0;
                                    $qtysql = "SELECT purchase_quantity FROM purchase_cart WHERE username = '$username'";
                                    $result = $conn->query($qtysql);
                                    while($row = $result->fetch_assoc()) {
                                        $qty = (int)$row['purchase_quantity'];
                                        $cartqty += $qty;
                                    }
                                    echo $cartqty;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="navbar">
                    <li>
                        <a onmouseenter="toggleCMenu()">
                            <img src="./Images/navbar/hamburger.png">
                            Categories
                        </a>
                        <a href="product.php">
                            Products
                        </a>
                        <a href="deals.php">
                            Deals
                        </a>
                        <a href="membership.php">
                            Membership
                        </a>
                    </li>
                </ul>
                <div class="cMenuContainer" id="cMenu" onmouseleave="toggleCMenu()">
                    <div class="cMenu">
                        <ul class="catbar">
                            <li>
                                <a href="product.php?filter=Produce">
                                    <img src="./Images/Categories/produce_icon.png">
                                    Produce
                                </a>
                                <a href="product.php?filter=Meats">
                                    <img src="./Images/Categories/meats_icon.png">
                                    Meats
                                </a>
                                <a href="product.php?filter=Seafood">
                                    <img src="./Images/Categories/seafood_icon.png">
                                    Seafood
                                </a>
                                <a href="product.php?filter=Bakery">
                                    <img src="./Images/Categories/bakery_icon.png">
                                    Bakery
                                </a>
                                <a href="product.php?filter=Dairy">
                                    <img src="./Images/Categories/dairy_icon.png">
                                    Dairy
                                </a>
                                <a href="product.php?filter=Snacks">
                                    <img src="./Images/Categories/snacks_icon.png">
                                    Snacks
                                </a>
                                <a href="product.php?filter=Beverages">
                                    <img src="./Images/Categories/beverages_icon.png">
                                    Beverages
                                </a>
                                <a href="product.php?filter=Household">
                                    <img src="./Images/Categories/household_icon.png">
                                    Household
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pMenuContainer" id="pMenu" onmouseleave="togglePMenu()">
                    <div class="pMenu">
                        <div class="uInfo">
                            <img src="<?php echo $data; ?>" class="ppfp">
                            <h2><?php echo $_SESSION['userinfo'][0]['username'] ?></h2>
                        </div>
                        <hr>
                        <a href="" class=pMContent>
                            <img src="./Images/navbar/user.png">
                            <p>
                                Edit Profile
                            </p>
                            <span>></span>
                        </a>
                        <a href="./logout.php" class=pMContent>
                            <img src="./Images/navbar/logout.png">
                            <p>
                                Logout
                            </p>
                            <span>></span>
                        </a>
                    </div>
                </div>
                <div class="cartMenuContainer" id="cartMenu" onmouseleave="toggleCartMenu()">
                </div>
            </nav>
        </header>
        <div class="cartpage-container">
            <?php
                $username = $_SESSION['userinfo'][0]['username'];
                $cartqty = 0;
                $qtysql = "SELECT purchase_quantity FROM purchase_cart WHERE username = '$username'";
                $result = $conn->query($qtysql);
                while($row = $result->fetch_assoc()) {
                    $qty = (int)$row['purchase_quantity'];
                    $cartqty += $qty;
                }
                if($cartqty != 0){ ?>
                    <div class="cartlist">
                        <div class="ctitle">
                            Cart
                        </div>
                        <div class="ct-content-container" id="ct-content">
                            <?php
                                $username = $_SESSION['userinfo'][0]['username'];
                                $member = $_SESSION['userinfo'][0]['member'];
                                $dcartsql = "SELECT * FROM purchase_cart WHERE username = '$username'";
                                $cartresult = $conn->query($dcartsql);
                                while($row = $cartresult->fetch_assoc()) {
                                    $pid = $row['product_id'];
                                    $psql = "SELECT * FROM product WHERE product_id = $pid";
                                    $productresult = $conn->query($psql);
                                    $productrow = $productresult->fetch_assoc();
                                    $pqty = $row['purchase_quantity'];
                                    if($member == 1 && $productrow['member_discount'] == 1){
                                        $producttotal = $row['purchase_quantity'] * ($productrow['product_price'] - ($productrow['product_price'] * 0.1));
                                    }
                                    else{
                                        $producttotal = $row['purchase_quantity'] * ($productrow['product_price'] - ($productrow['product_price'] * $productrow['product_discount']));
                                    }

                                    echo '<div class="ct-contents">';
                                    echo '<div class="ct-image">';
                                    echo '<img src="' . $productrow['product_img'] .'"></div>';
                                    echo '<div class="ct-detail">';
                                    echo '<div class="ct-name">' . $productrow["product_name"] . '</div></div>';
                                    echo '<div class="ct-btns">';
                                    if($row['purchase_quantity'] > 1)
                                    {
                                        echo '<button class="cdelbtn" value="' . $pid .'">-</button>';
                                    }
                                    else
                                    {
                                        echo '<button class="cdelbtn" value="' . $pid .'"><img src="./Images/navbar/bin.png" class="binbtn"></button>';
                                    }
                                    echo '<div class="c-qty">' . $pqty . '</div>';
                                    echo '<button class="caddbtn" value="' . $row["product_id"] . '">+</button></div>';
                                    echo '<div class="ct-price">BHD ' . number_format($producttotal, 3) . '</div>';
                                    echo '<div class="removebtn"><button class="rbtn" value=' . $pid . '>X</button></div></div>';
                                } 
                            ?>
                        </div>
                    </div>
                    <div class="cartamount">
                        <div class="cartamount-container" id="cartamount-container">
                            <?php 
                                $username = $_SESSION['userinfo'][0]['username'];
                                $member = $_SESSION['userinfo'][0]['member'];
                                $dcartsql = "SELECT * FROM purchase_cart WHERE username = '$username'";
                                $cartresult = $conn->query($dcartsql);
                                $mtotal = 0;
                                $dtotal = 0;
                                $ctotal = 0;
                                $stotal = 0;
                                while($row = $cartresult->fetch_assoc()) {
                                    $pid = $row['product_id'];
                                    $psql = "SELECT * FROM product WHERE product_id = $pid";
                                    $productresult = $conn->query($psql);
                                    $productrow = $productresult->fetch_assoc();
                                    $pqty = $row['purchase_quantity'];
                                    $discount = 0;
                                    $mdiscount = 0;
                                    $stotal += ($row['purchase_quantity'] * $productrow['product_price']);
                                    if($member == 1 && $productrow['member_discount'] == 1){
                                        $mdiscount = ($productrow['product_price'] * 0.1);
                                        $mdiscounted = ($productrow['product_price'] - $mdiscount);
                                        $producttotal = $row['purchase_quantity'] * $mdiscounted;
                                    }
                                    else{
                                        $discount = ($productrow['product_price'] * $productrow['product_discount']);
                                        $discounted = ($productrow['product_price'] - $discount);
                                        $producttotal = $row['purchase_quantity'] * $discounted;
                                    }
                                    $mtotal += ($mdiscount * $row['purchase_quantity']);
                                    $dtotal += ($discount * $row['purchase_quantity']);
                                    $ctotal += $producttotal;
                                }
                                echo '<div class="amount-title">Order Summary</div>';
                                echo '<div class="amount-subtotals">';
                                echo '<div class="subtotal"><div>Subtotal</div>';
                                echo '<div>BHD ' . number_format($stotal, 3) . '</div></div>';
                                echo '<div class="discounttotal"><div>Discounts</div>';
                                echo '<div>- BHD ' . number_format($dtotal, 3) . '</div></div>';
                                echo '<div class="membertotal"><div>Member Discounts</div>';
                                echo '<div>- BHD ' . number_format($mtotal, 3) . '</div></div></div>';
                                echo '<div class="amount-total">';
                                echo '<div class="total">Total</div>';
                                echo '<div class="total-amount">BHD ' . number_format($ctotal, 3) . '</div></div>';
                                echo '<div class="checkoutbtn">';
                                echo '<button>Continue to checkout</button></div>';
                            ?>
                        </div>
                    </div>
            <?php 
            } 
                else
                {
                    echo '<div class="emptycart">';
                    echo '<div class="emptytitle">Your Shopping Cart is Empty!</div>';
                    echo '<div class="shopbtn">';
                    echo '<a href="./product.php"><button>START SHOPPING</button></a>';
                    echo '</div></div>';
                }
            ?>
        </div>
        <footer>
            <div class="footer-container">
                <div class="lfooter">
                    <img src="./Images/logo.png">
                </div>
                <div class="mfooter">
                    <h2>
                        LaLa Grocery Store Website
                    </h2>
                </div>
                <div class="rfooter">
                    <h3>
                        Project for: CSCI824-CA
                        <br>
                        Made by: Lance BH23500118
                    </h3>
                </div>
            </div>
        </footer>
        <script>
            // Category Menu
            let cMenu = document.getElementById("cMenu");
            function toggleCMenu()
            {
                cMenu.classList.toggle("open-menu")
            }

            // User Menu
            let pMenu = document.getElementById("pMenu");
            function togglePMenu()
            {
                pMenu.classList.toggle("open-menu");
            }

            document.body.addEventListener("click", function(event) {
                const btn = event.target.closest(".cdelbtn");
                if (btn) {
                    const pid = btn.value;
                    
                    const cartdelete = new XMLHttpRequest();
                    cartdelete.open("POST", "cart.php", true);
                    cartdelete.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    cartdelete.onload = function () {
                        updateCartContents();
                    };

                    cartdelete.send("action=deletefromcart&pid=" + encodeURIComponent(pid));
                }
            });

            document.body.addEventListener("click", function(event) {
                const btn = event.target.closest(".rbtn");
                if (btn) {
                    const pid = btn.value;

                    const cartremove = new XMLHttpRequest();
                    cartremove.open("POST", "cart.php", true);
                    cartremove.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    cartremove.onreadystatechange = function () {
                        if (cartremove.readyState === 4 && cartremove.status === 200 && cartremove.responseText.trim() === "success")
                        {
                            updateCartContents();
                        }
                    }

                    cartremove.send("action=removefromcart&pid=" + encodeURIComponent(pid))
                }
            });

            function updateCartContents() {
                const cart = new XMLHttpRequest();
                cart.open("POST", "cart.php", true);
                cart.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                cart.onload = function() {
                    document.getElementById("ct-content").innerHTML = cart.responseText;
                };

                cart.send("action=displaycartcontent");

                const cqty = new XMLHttpRequest();
                cqty.open("POST", "cart.php", true);
                cqty.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                cqty.onload = function() {
                    document.getElementById("cartqty").innerHTML = cqty.responseText;
                };

                cqty.send("action=displayqty");

                const camount = new XMLHttpRequest();
                camount.open("POST", "cart.php", true);
                camount.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                camount.onload = function() {
                    document.getElementById("cartamount-container").innerHTML = camount.responseText;
                }

                camount.send("action=cartamount");
            }

            document.body.addEventListener("click", function(event) {
                if (event.target.classList.contains("caddbtn")) {
                    const pid = event.target.value;
                    const cartadd = new XMLHttpRequest();
                    cartadd.open("POST", "cart.php", true);
                    cartadd.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    cartadd.onload = function () {
                        updateCartContents();
                    };

                    cartadd.send("action=addtocart&pid=" + encodeURIComponent(pid));
                };
            });

        </script>
    </body>
</html>