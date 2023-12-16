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
                <!-- Search bar -->
                <input type="search" class="data-search" placeholder="Search..">

                <!-- Card set -->
                <div class="user-cards"></div>
                <template class="data-user-template">
                    <div class="card">
                        <a href="" class="tile">
                            <table>
                                <tr>
                                    <td class="header" data-header></td>
                                    <td class="options">
                                        <form action="<?php echo URLROOT ?>/land/prices" method="get" class="price-form">
                                            <input type="text" name="id" id="id" hidden value="" />
                                            <input type="text" name="name" id="name" hidden value="" />
                                            <button type="submit" class="price">
                                                <img src="<?php echo URLROOT ?>/images/price.svg" alt="">
                                            </button>
                                        </form>
                                        &nbsp;
                                        <form action="<?php echo URLROOT ?>/land/landUpdateForm" method="get" class="update-form">
                                            <input type="text" name="name" id="name" hidden value="" />
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

        // Set the parking view link
        if (tileLink) {
            tileLink.href = `gotoLand/${land.id}/${land.name}`;
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
            const nameInput = updateForm.querySelector('#name');

            if (nameInput && idInput) {
                nameInput.value = land.name;
                idInput.value = land.id;
            } else {
                console.error("One or more form inputs not found in the cloned card:", card);
            }
        }

        return { id: land.id, name: land.name, city: land.city, street: land.street, element: card };
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
