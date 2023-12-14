<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
    $section = 'dashboard';
    require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <div class="search">
                <input type="text" class="parking-search" placeholder="Search Parking" style="border: 1px solid #ccc">
            </div>
<!--            <div class="map">-->
<!--                <img src="--><?php //echo URLROOT ?><!--/images/location.png" alt="">-->
<!--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4231.666368350934!2d79.86014226253688!3d6.902790088271364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259100761b8f3%3A0x78f0a33054ea929b!2sIndependence%20Square%20Parking%20Lot!5e0!3m2!1sen!2slk!4v1697709991816!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
<!--            </div>-->

            <!-- Search bar -->
<!--            <input type="search" class="data-search" placeholder="Search..">-->

            <!-- Card set -->
            <div class="user-cards"></div>
            <template class="data-user-template">
                <div class="card" style="padding: 10px;">
                    <a href="" class="tile">
                        <table>
                            <tr>
                                <td class="name" data-header></td>
                                <td class="city" data-des></td>
                            </tr>
                        </table>
                    </a>
                </div>
            </template>
        </div>
    </section>
</main>

<script>
    function confirmSubmit() {
        return confirm("Are you sure you want to delete this land?");
    }

    // ------------------------------- Search Bar -------------------------------
    const userCardTemplate = document.querySelector(".data-user-template");
    const searchInput = document.querySelector(".parking-search");

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
