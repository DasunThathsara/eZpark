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
            <h1 class="title">All Lands</h1>
            <p class="subtitle">View and Edit information related to Lands</p>

            <br><br>
            <a class="add-btn" href="<?php echo URLROOT ?>/land/landRegister">Add new <span>+</span></a>

            <div class="content-body">
                <?php if (sizeof($data) == 0) {?>
                    <div class="emptyLand">You have no any registered lands</div>
                <?php }
                else {?>
                    <div class="title-options">
                        <div class="all-lands option-item option-item-active">All Lands</div>
                        <div class="available-lands option-item">Available</div>
                        <div class="unavailable-lands option-item">Unavailable</div>
                    </div>
                    <hr class="option-break" />
                    <!-- Search area -->
                    <div class="search-area">
                        <!-- Search bar -->
                        <input type="search" class="data-search" placeholder="Search land...">
                        <div class="filter-area">
                            <img class="filter-btn" src="<?php echo URLROOT?>/images/filter-ico.png" alt="">
                        </div>
                    </div>

                    <div class="user-card-title">
                        <div class="name">Name</div>
                        <div class="location">Location</div>
                        <div class="capacity">Capacity</div>
                        <div class="status">Status</div>
                    </div>

                    <div class="card-set-container">
                        <!-- Card set -->
                        <div class="user-cards"></div>
                        <template class="data-user-template">
                            <div class="card">
                                <a href="" class="tile">
                                    <table>
                                        <tr>
                                            <td class="name-td" data-header>
                                                <p class="name"></p>
                                                <p class="id-p">Land ID: <span class="id"></span></p>
                                            </td>
                                            <td class="location" data-header></td>
                                            <td class="capacity" data-header></td>
                                            <td class="status-td" data-header><span class="status"></span></td>

                                            <td class="options">
                                                <!--<form action="<?php echo URLROOT ?>/land/prices" method="get" class="price-form">
                                                    <input type="text" name="id" id="id" hidden value="" />
                                                    <input type="text" name="name" id="name" hidden value="" />
                                                    <button type="submit" class="price">
                                                        <img src="<?php echo URLROOT ?>/images/price.svg" alt="">
                                                    </button>
                                                </form>-->
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/land/landUpdateForm" method="get" class="update-form">
                                                    <!-- <input type="text" name="name" id="name" hidden value="" /> -->
                                                    <input type="text" name="id" id="id" hidden value="" />
                                                    <button type="submit" class="edit">
                                                        <img src="<?php echo URLROOT ?>/images/edit-solid.svg" alt="">
                                                    </button>
                                                </form>
                                                &nbsp;
                                                <form action="<?php echo URLROOT ?>/land/landRemove" method="post" class="delete-form">
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
                    </div>
                <?php } ?>
            </div>
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
        card.querySelector(".name").textContent = land.name;
        card.querySelector(".location").textContent = land.city;
        card.querySelector(".capacity").textContent = land.car + land.bike + land.threeWheel;
        card.querySelector(".id").textContent = land.id;
        if (land.availability === 0){
            card.querySelector(".status").textContent = 'Unavailable';
            card.querySelector(".status").classList.add("status-unavailable");
        }else{

            card.querySelector(".status").textContent = 'Available';
            card.querySelector(".status").classList.add("status-available");
        }

        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');
    
        // Set the parking view link
        if (tileLink) {
            tileLink.href = `gotoLand/${land.id}`;
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }
        
        // Set id and name to go to the price page
        const priceForm = card.querySelector('.price-form');
        if (priceForm) {
            const idInput = priceForm.querySelector('#id');
            const nameInput = priceForm.querySelector('#name');
        
            if (idInput && nameInput) {
                idInput.value = land.id;
                nameInput.value = land.name;
            } else {
                console.error("Form inputs with id 'id' or 'name' not found in the cloned card:", card);
            }
        }


        // Set id and name to delete the land
        const deleteForm = card.querySelector('.delete-form');
        if (deleteForm) {
            const nameInput = deleteForm.querySelector('#name');
            
            if (nameInput) {
                nameInput.value = land.name; // Set the value dynamically
            } else {
                console.error("Form input with id 'name' not found in the cloned card:", card);
            }
        }


        // Set values to go to the update page
        const updateForm = card.querySelector('.update-form');
        if (updateForm) {
            const idInput = updateForm.querySelector('#id');
            
            if (idInput) {
                idInput.value = land.id;
            } else {
                console.error("One or more form inputs not found in the cloned card:", card);
            }
        }

        return { id: land.id, name: land.name, city: land.city, street: land.street, availability: land.availability, element: card };
    });
    
    // ------------------------------- Filter -------------------------------
    const allLands = document.querySelector(".all-lands");
    const availableLands = document.querySelector(".available-lands");
    const unavailableLands = document.querySelector(".unavailable-lands");
    
    allLands.addEventListener("click", () => {
        allLands.classList.add("option-item-active");
        availableLands.classList.remove("option-item-active");
        unavailableLands.classList.remove("option-item-active");
        lands.forEach(land => {
            land.element.classList.remove("hide");
        });
    });

    availableLands.addEventListener("click", () => {
        allLands.classList.remove("option-item-active");
        availableLands.classList.add("option-item-active");
        unavailableLands.classList.remove("option-item-active");
        lands.forEach(land => {
            if (land.availability === 1) {
                land.element.classList.remove("hide");
            } else {
                land.element.classList.add("hide");
            }
        });
    });
    
    unavailableLands.addEventListener("click", () => {
        allLands.classList.remove("option-item-active");
        availableLands.classList.remove("option-item-active");
        unavailableLands.classList.add("option-item-active");
        lands.forEach(land => {
            if (land.availability === 0) {
                land.element.classList.remove("hide");
            } else {
                land.element.classList.add("hide");
            }
        });
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
