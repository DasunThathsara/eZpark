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
            <h1>Requests</h1>

            <br><br>
            <?php if (sizeof($data) == 0) {?>
                <div class="emptyLand">There are no any requests</div>
            <?php }
            else {?>
                <!-- Search bar -->
                <input type="search" class="data-search" placeholder="Search.." style="top: 50px;">

                <!-- Card set -->
                <div class="user-cards" style="margin-top: 0;"></div>
                <template class="data-user-template">
                    <div class="card">
                        <a href="" class="tile">
                            <table>
                                <tr>
                                    <td>
                                        <div style="display: flex; width: 50%">
                                            <div>
                                                <p class="name" style="width: 150px;" data-header></p>
                                            </div>
                                            <div>
                                                <p class="city" data-header></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="options">                                        &nbsp;
                                        <form action="<?php echo URLROOT ?>/admin/verifyLand" method="post" class="update-form">
                                            <input type="text" name="id" id="id" hidden value="" />
                                            <button type="submit" class="edit" onclick="return confirmSubmit();">
                                                <img src="<?php echo URLROOT ?>/images/tick.svg" style="width: 18px" alt="">
                                            </button>
                                        </form>
                                        &nbsp;
                                        <form action="<?php echo URLROOT ?>/admin/unverifyLand" method="post" class="delete-form">
                                            <input type="text" name="id" id="id" hidden value="" />
                                            <button type="submit" class="delete" onclick="return confirmSubmit();">
                                                <img src="<?php echo URLROOT ?>/images/circle-xmark-regular.svg" style="width: 18px;" alt="">
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
        card.querySelector(".name").textContent = land.name;
        card.querySelector(".city").textContent = land.city;
        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');

        // Set the parking view link
        if (tileLink) {
            tileLink.href = `viewRegistrationRequestedLand/${land.id}`;
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }


        // Set id and name to delete the land
        const deleteForm = card.querySelector('.delete-form');
        if (deleteForm) {
            const idInput = deleteForm.querySelector('#id');

            if (idInput) {
                idInput.value = land.id; // Set the value dynamically
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

        return { id: land.id, name: land.name, city: land.city, street: land.street, element: card };
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
