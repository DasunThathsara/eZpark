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
            <h1>Admins</h1>

            <br><br>
            <a class="add-btn" href="<?php echo URLROOT ?>/superAdmin/addAdmin" style="font-weight: 1000; font-size: 20px; margin-left: 0px;">+</a>
            <br><br>

            <?php if (sizeof($data) == 0) {?>
                <div class="emptyLand">There are no any admins</div>
            <?php }
            else {?>
                <!-- Search bar -->
                <input type="search" class="data-search" placeholder="Search.." style="top: 135px;">

                <!-- Card set -->
                <div class="user-cards" style="margin-top: 0;"></div>
                <template class="data-user-template">
                    <div class="card">
                        <div class="identifier">
                            <a href="" class="tile">
                                <table>
                                    <tr>
                                        <td>
                                            <div style="display: flex; width: 50%">
                                                <div>
                                                    <p class="name" style="width: 90px;" data-header></p>
                                                </div>
                                                <div>
                                                    <p class="email" data-header></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="options">
                                            <form action="<?php echo URLROOT ?>/superAdmin/updateAdmin" method="get" class="edit-form">
                                                <input type="text" name="id" id="id" hidden value="" />
                                                <button type="submit" class="delete">
                                                    <img src="<?php echo URLROOT ?>/images/edit-solid.svg" style="width: 15px; margin-top: 4px" alt="" class="delete-ico">
                                                </button>
                                            </form>
                                            &nbsp;
                                            <form action="<?php echo URLROOT ?>/superAdmin/removeAdmin" method="post" class="delete-form">
                                                <input type="text" name="id" id="id" hidden value="" />
                                                <button type="submit" class="delete" onclick="return confirmDelete();">
                                                    <img src="<?php echo URLROOT ?>/images/trash-solid.svg" style="width: 15px; margin-top: 4px" alt="" class="delete-ico">
                                                </button>
                                            </form>
                                            &nbsp;
                                            <form action="<?php echo URLROOT ?>/superAdmin/banAdmin" method="post" class="ban-form">
                                                <input type="text" name="id" id="id" hidden value="" />
                                                <button type="submit" class="delete" onclick="return confirmBan();">
                                                    <img src="<?php echo URLROOT ?>/images/ban.svg" style="width: 18px; margin-top: 4px" alt="" class="ban-ico">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </a>
                        </div>
                    </div>
                </template>
            <?php } ?>
        </div>
    </section>
</main>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to remove this admin?");
    }

    function confirmBan() {
        return confirm("Are you sure you want to ban this admin?");
    }

    // ------------------------------- Search Bar -------------------------------
    const userCardTemplate = document.querySelector(".data-user-template");
    const searchInput = document.querySelector(".data-search");

    searchInput.addEventListener("input", (data) => {
        const value = data.target.value.toLowerCase();
        admins.forEach(admin => {
            const isVisible = admin.name.toLowerCase().includes(value) || admin.city.toLowerCase().includes(value) || admin.street.toLowerCase().includes(value);
            if (admin.element) {
                admin.element.classList.toggle("hide", !isVisible);
            }
        });
    });

    let admins = [];
    var backendData = <?php echo json_encode($data); ?>;

    admins = backendData.map(admin => {
        const card = userCardTemplate.content.cloneNode(true).children[0];
        console.log(card);
        card.querySelector(".name").textContent = admin.name;
        card.querySelector(".email").textContent = admin.email;
        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');

        var cardElement = card.querySelector('.identifier');

        if (admin.banCount === 0) {
            cardElement.style.border = '2px solid white';
            cardElement.style.borderRadius = '10px';
            cardElement.style.padding = '5px 10px 5px 10px';
        }
        else if (admin.banCount === 1) {
            cardElement.style.border = '2px solid green';
            cardElement.style.borderRadius = '10px';
            cardElement.style.padding = '5px 10px 5px 10px';
        }
        else if (admin.banCount === 2) {
            cardElement.style.border = '2px solid orange';
            cardElement.style.borderRadius = '10px';
            cardElement.style.padding = '5px 10px 5px 10px';
        }
        else if (admin.banCount >= 3) {
            cardElement.style.border = '2px solid red';
            cardElement.style.borderRadius = '10px';
            cardElement.style.padding = '5px 10px 5px 10px';
        }

        // Set the admin view link
        if (tileLink) {
            tileLink.href = `viewAdmin/${admin.id}`;
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }


        // Set id and name to delete the admin
        const deleteForm = card.querySelector('.delete-form');
        if (deleteForm) {
            const idInput = deleteForm.querySelector('#id');

            if (idInput) {
                idInput.value = admin.id; // Set the value dynamically
            } else {
                console.error("Form input with id 'name' not found in the cloned card:", card);
            }
        }

        // Set id and name to ban the admin
        const banForm = card.querySelector('.ban-form');
        if (deleteForm) {
            const idInput = banForm.querySelector('#id');

            if (idInput) {
                idInput.value = admin.id; // Set the value dynamically
            } else {
                console.error("Form input with id 'name' not found in the cloned card:", card);
            }
        }

        // Set id and name to ban the admin
        const editForm = card.querySelector('.edit-form');
        if (deleteForm) {
            const idInput = editForm.querySelector('#id');

            if (idInput) {
                idInput.value = admin.id; // Set the value dynamically
            } else {
                console.error("Form input with id 'name' not found in the cloned card:", card);
            }
        }

        return { id: admin.id, name: admin.name, city: admin.email, street: admin.username, element: card };
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
