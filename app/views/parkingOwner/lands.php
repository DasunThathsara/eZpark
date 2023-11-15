<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'lands';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1>Lands</h1>

            <br><br>
            <a class="add-btn" href="<?php echo URLROOT ?>/land/landRegister" style="font-weight: 1000; font-size: 20px">+</a>

            <?php if (sizeof($data) == 0) {?>
                <div class="emptyLand">You have no any registered lands</div>
            <?php }
            else {?>
                <!-- <div class="table-container">
                    <table class="table">
                        <tr>
                            <th>Parking Name</th>
                            <th width="60px"></th>
                        </tr>
                        <?php for ($i = 0; $i < sizeof($data); $i++) {?>
                            <tr>
                                <td width="70%">
                                    <a class="tile" href="<?php echo URLROOT ?>/parkingOwner/gotoLand/<?php echo $data[$i]->id ?>/<?php echo $data[$i]->name ?>">
                                        <div class="content">
                                            <div class="left">
                                                <?php echo $data[$i]->name ?>
                                            </div>
                                            <div class="right">
                                                <form action="<?php echo URLROOT ?>/land/prices" method="get">
                                                    <input type="text" name="id" id="id" hidden value="<?php echo $data[$i]->id ?>" />
                                                    <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                                    <button type="submit" class="price">
                                                        <img src="<?php echo URLROOT ?>/images/price.svg" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/land/landUpdateForm" method="post">
                                                <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                                    <input type="text" name="city" id="city" hidden value="<?php echo $data[$i]->city ?>" />
                                                    <input type="text" name="street" id="street" hidden value="<?php echo $data[$i]->street ?>" />
                                                    <input type="text" name="deed" id="deed" hidden value="<?php echo $data[$i]->deed ?>" />
                                                    <input type="number" name="car" id="car" hidden value="<?php echo $data[$i]->car ?>" />
                                                    <input type="number" name="bike" id="bike" hidden value="<?php echo $data[$i]->bike ?>" />
                                                    <input type="number" name="threeWheel" id="threeWheel" hidden value="<?php echo $data[$i]->threeWheel ?>" />
                                                    <input type="number" name="contactNo" id="contactNo" hidden value="<?php echo $data[$i]->contactNo ?>" />
                                                    <button type="submit" class="edit">
                                                        <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/land/landRemove" method="post">
                                                    <input type="text" name="name" id="name" hidden value="<?php echo $data[$i]->name ?>" />
                                                    <button type="submit" class="delete" onclick="return confirmSubmit();">
                                                        <img src="<?php echo URLROOT ?>/images/trash-solid.svg" alt="">
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div> -->

                <input type="search" class="data-search">
                <div class="user-cards"></div>
                <template class="data-user-template">
                    <div class="card">
                        <a href="" class="tile">
                            <table>
                                <tr>
                                    <td class="header" data-header></td>
                                    <td class="options">
                                        <form action="<?php echo URLROOT ?>/land/prices" method="get">
                                            <input type="text" name="id" id="id" hidden value="" />
                                            <input type="text" name="name" id="name" hidden value="" />
                                            <button type="submit" class="price">
                                                <img src="<?php echo URLROOT ?>/images/price.svg" alt="">
                                            </button>
                                        </form>
                                        &nbsp;
                                        <form action="<?php echo URLROOT ?>/land/landUpdateForm" method="post">
                                        <input type="text" name="name" id="name" hidden value="" />
                                            <input type="text" name="city" id="city" hidden value="" />
                                            <input type="text" name="street" id="street" hidden value="" />
                                            <input type="text" name="deed" id="deed" hidden value="" />
                                            <input type="number" name="car" id="car" hidden value="" />
                                            <input type="number" name="bike" id="bike" hidden value="" />
                                            <input type="number" name="threeWheel" id="threeWheel" hidden value="" />
                                            <input type="number" name="contactNo" id="contactNo" hidden value=""/>
                                            <button type="submit" class="edit">
                                                <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                            </button>
                                        </form>
                                        &nbsp;
                                        <form action="<?php echo URLROOT ?>/land/landRemove" method="post">
                                            <input type="text" name="name" id="name" hidden value="" />
                                            <button type="submit" class="delete" onclick="return confirmSubmit();">
                                                <img src="<?php echo URLROOT ?>/images/trash-solid.svg" alt="">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </a>
                    </div>
                </template>
            <?php } ?>
        </div>
    </section>
</main>
<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to delete this land?");
    }

    // ------------------------------- Search Bar -------------------------------
    const userCardTemplate = document.querySelector(".data-user-template");
    const searchInput = document.querySelector(".data-search");

    searchInput.addEventListener("input", (data) => {
        const value = data.target.value.toLowerCase();
        lands.forEach(land => {
            const isVisible = land.name.toLowerCase().includes(value) || land.city.toLowerCase().includes(value) || land.street.toLowerCase().includes(value);
            if (land.element) {
                land.element.classList.toggle("hide", !isVisible);
            }
        });
    });

    let lands = [];
    var backendData = <?php echo json_encode($data); ?>;

    lands = backendData.map(land => {
        const card = userCardTemplate.content.cloneNode(true).children[0];
        console.log(card);
        card.querySelector(".header").textContent = land.name;
        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');
    
        if (tileLink) {
            tileLink.href = `gotoLand/${land.id}/${land.name}`;
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }
        return { id: land.id, name: land.name, city: land.city, street: land.street, element: card };
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
