<?php
    session_start();
    if(isset($_SESSION['userinfo'][0]['pfp']))
    {
        $data = $_SESSION['userinfo'][0]['pfp'];
    }
    include('connect.php');
    global $conn;

    if (isset($_POST['details'])) {
        $id = intval($_POST['details']);
        $sql = "SELECT * FROM product WHERE product_id = $id";
        $result = $conn->query($sql);
        if($row = $result->fetch_assoc()) {
            echo '<div class="product-details">';
            echo '<div class="productimg"><img src="' . htmlspecialchars($row['product_img']) . '"></div>';
            echo '<div class="productinfodetails">';
            echo '<h2>' . htmlspecialchars($row['product_name']) . '</h2>';
            echo '<div class="priceinfo">BHD ' . number_format($row['product_price'], 3) . '</div>';
            echo '<div class="cartbtn"><button class="addcartbtn" value="' . $id . '">Add to Cart</button></div>';
            echo '<div class="descinfo"><h3>Description</h3><div>' . htmlspecialchars($row['product_description']) . '</div></div>';
            echo '<div class="closedetails"><button>X</button></div>';
            echo '</div>';
        }
        exit;
    }

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
    
    if (isset($_POST['action']) && $_POST['action'] === 'displaycart') {
        $username = $_SESSION['userinfo'][0]['username'];
        $member = $_SESSION['userinfo'][0]['member'];

        $countdcartsql = "SELECT purchase_quantity FROM purchase_cart WHERE username = '$username'";
        $countresult = $conn->query($countdcartsql);
        $totalqty = 0;
        while($countrow = $countresult->fetch_assoc()){
            $totalqty += $countrow['purchase_quantity'];
        }

        echo '<div class="carttitle">';
        echo 'Your Cart: ' . $totalqty . ' items';
        echo '</div>';
        echo '<div class="cartproduct-container">';

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
            echo '<div class="cartproduct">';
            echo '<div class="cartpimg">';
            echo '<img src="' . $productrow['product_img'] . '">';
            echo '</div>';
            echo '<div class="cartpdetails">';
            echo '<div class="cartpname">';
            echo '' . $productrow["product_name"] . '';
            echo '</div>';
            echo '<div class="cartpnumbers">';
            echo '<div class="cartpprice">';
            echo 'BHD ' . number_format($producttotal, 3) . '';
            echo '</div>';
            echo '<div class="cartpqty">';
            echo '' . $pqty . ' qty';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="cartpdelete">';
            echo '<img src="./Images/navbar/bin.png" data-pid="' . $pid .'" class="deletecartbtn">';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="carttotal"> BHD ';
        echo  number_format($carttotal, 3);
        echo '<a href="./cart.php"><button class="cartgo">Go to cart</button></a>';
        echo '</div>';
        exit;
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'deletefromcart')
    {
        $username = $_SESSION['userinfo'][0]['username'];
        $pid = $_POST['pid'];

        $deletesql = "DELETE FROM purchase_cart WHERE username = '$username' AND product_id = $pid";
        $conn->query($deletesql);

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
        <div class="deal-container">
            <h2 style="padding: 20px;text-align: center;font-size: 50px;">AMAZING DEALS</h2>
            <div class="productsd" id="products">
                <?php
                    $sql = "SELECT * FROM product WHERE product_discount != 0";
                    global $conn;
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="product-infod">';
                        echo '<img src="' . htmlspecialchars($row["product_img"]) . '" onclick=togglePDMenu(' . $row["product_id"] . ')>';
                        echo '<div class="pname" onclick="togglePDMenu(' . $row["product_id"] . ')">' . htmlspecialchars($row["product_name"]) . '</div>';
                        $discountprice = ($row["product_price"] - ($row["product_price"] * $row["product_discount"]));
                        echo '<div class="pprice"><span class="onsale">BHD ' . number_format($row["product_price"], 3) . '</span><br><span class="saleprice">BHD ' . number_format($discountprice, 3) . '</span></div>';
                        echo '<div class="pbutton"><button class="addcartbtn" value="' . $row["product_id"] . '">+</button></div>';
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="product-details-container" id="detailsPanel">
            </div>
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

            // Cart Menu
            let cartMenu = document.getElementById("cartMenu");
            function toggleCartMenu()
            {
                cartMenu.classList.toggle("open-menu");
            }

            function togglePDMenu(productId)
            {   
                const container = document.getElementById("detailsPanel");

                const formData = new FormData();
                formData.append('ajax', '1');
                formData.append('details', productId);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    container.classList.add("open-menu");

                    const closebtn = container.querySelector(".closedetails button");
                    if (closebtn){
                        closebtn.addEventListener("click", () => {
                            container.innerHTML = "";
                            container.classList.remove("open-menu");
                        })
                    }
                });
            }

            document.body.addEventListener("click", function(event) {
                if (event.target.classList.contains("deletecartbtn")) {
                    const pid = event.target.dataset.pid;
                    
                    const cartdelete = new XMLHttpRequest();
                    cartdelete.open("POST", "deals.php", true);
                    cartdelete.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    cartdelete.onload = function () {
                        const cart = new XMLHttpRequest();
                        cart.open("POST", "deals.php", true);
                        cart.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        cart.onload = function() {
                            document.getElementById("cartMenu").innerHTML = cart.responseText;
                        };

                        cart.send("action=displaycart");

                        const cqty = new XMLHttpRequest();
                        cqty.open("POST", "deals.php", true);
                        cqty.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        cqty.onload = function() {
                            document.getElementById("cartqty").innerHTML = cqty.responseText;
                        };

                        cqty.send("action=displayqty");
                    };

                    cartdelete.send("action=deletefromcart&pid=" + encodeURIComponent(pid));
                }
            });

            document.body.addEventListener("click", function(event) {
                if (event.target.classList.contains("addcartbtn")) {
                    const pid = event.target.value;
                    const cartadd = new XMLHttpRequest();
                    cartadd.open("POST", "deals.php", true);
                    cartadd.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    cartadd.onload = function () {
                        const cqty = new XMLHttpRequest();
                        cqty.open("POST", "deals.php", true);
                        cqty.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        cqty.onload = function() {
                            document.getElementById("cartqty").innerHTML = cqty.responseText;
                        };

                        cqty.send("action=displayqty");
                    };

                    cartadd.send("action=addtocart&pid=" + encodeURIComponent(pid));
                };
            });

            document.getElementById("cart").addEventListener("click", function() {
                const cart = new XMLHttpRequest();
                cart.open("POST", "deals.php", true);
                cart.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                cart.onload = function() {
                    document.getElementById("cartMenu").innerHTML = cart.responseText;
                };

                cart.send("action=displaycart")
            });
        </script>
    </body>
</html>