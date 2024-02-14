<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'parkingRequest';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">Search Securities</h1>
            <p class="subtitle">View available securities in the system</p>

            <br><br>

            <div class="content-body">
                <?php if (sizeof($data) == 0) {?>
                    <div class="emptysecurity">You have no any request lands</div>
                <?php }  
                else {?>
                    <div class="title-options" style="width: 250px;">
                        <div class="all-securities option-item option-item-active">All</div>
                        <div class="district-securities option-item">In Your District</div>
                        <div class="province-securities option-item">In Your Province</div>
                    </div>
                    <hr class="option-break" />
                    <!-- Search area -->
                    <div class="search-area">
                        <!-- Search bar -->
                        <input type="search" class="data-search" placeholder="Search security...">
                        <div class="filter-area">
                            <img class="filter-btn" src="<?php echo URLROOT?>/images/filter-ico.png" alt="">
                        </div>
                    </div>

                    <div class="user-card-title">
                        <div class="sec-name">Name</div>
                        <div class="district">District</div>
                        <div class="province">Province</div>
                    </div>

                    <div class="card-set-container">
                        <!-- Card set -->
                        <div class="user-cards"></div>
                        <template class="data-user-template">
                            <div class="card">
                                <a href="" class="tile">
                                    <table width="100%">
                                        <tr>
                                            <td class="sec-name-td" style="width: 26%;" data-header>
                                                <p class="name"></p>
                                                <p class="id-p">Land ID: <span class="id"></span></p>
                                            </td>
                                            <td class="district" data-header></td>
                                            <td class="province" data-header></td>

                                            <td class="options">
                                                <form action="<?php echo URLROOT ?>/security/acceptLandRequest" method="POST" class="accept-form" id="accept-form">
                                                    <input type="text" name="id" class="id" id="landID" hidden value="" />
                                                    <button type="submit" class="price" onclick="confirmSubmit()">
                                                        <img id="dynamicImage" src="<?php echo URLROOT ?>/images/check.svg" alt="">
                                                    </button>
                                                </form>
                                                
                                                &nbsp;&nbsp;

                                                <form action="<?php echo URLROOT ?>/security/declineLandRequest" method="POST" class="decline-form" id="decline-form">
                                                    <input type="text" name="id" class="id" id="landID" hidden value="" />
                                                    <button type="submit" class="price" onclick="confirmSubmit()">
                                                        <img id="dynamicImage" src="<?php echo URLROOT ?>/images/xmark-solid.svg" alt="">
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
    document.addEventListener("DOMContentLoaded", function () {
        const declineForm = document.getElementById("decline-form");

        if (declineForm) {
            const submitButton = declineForm.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to decline this land.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, submit it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            declineForm.submit();
                        }
                    });
                });
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const acceptForm = document.getElementById("accept-form");

        if (acceptForm) {
            const submitButton = acceptForm.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to accept this land.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, submit it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            acceptForm.submit();
                        }
                    });
                });
            }
        }
    });


    // ------------------------------- Search Bar -------------------------------
    const userCardTemplate = document.querySelector(".data-user-template");
    const searchInput = document.querySelector(".data-search");

    searchInput.addEventListener("input", (data) => {
        const value = data.target.value.toLowerCase();
        securities.forEach(security => {
            const isVisible = security.name.toLowerCase().includes(value) || security.district.toLowerCase().includes(value) || security.province.toLowerCase().includes(value);
            if (security.element) {
                security.element.classList.toggle("hide", !isVisible);
            }
        });
    });

    let securities = [];
    var backendData = <?php echo json_encode($data); ?>;
    // console.log(backendData)
    securities = backendData.map(security => {
        const card = userCardTemplate.content.cloneNode(true).children[0];
        card.querySelector(".name").textContent = security.name;
        card.querySelector(".district").textContent = security.district;
        card.querySelector(".province").textContent = security.province;
        card.querySelector(".id").textContent = security.lid;

        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');

        // Set the parking view link
        if (tileLink) {
            tileLink.href = `<?php echo URLROOT?>/security/viewLand/${security.lid}`;
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }

        // Set id to delete land request
        const declineForm = card.querySelector('.decline-form');
        if (declineForm) {
            const landID = declineForm.querySelector('#landID');

            if (landID) {
                landID.value = security.lid;
                // console.log(landID.value);
            } else {
                console.error("Form inputs with id 'id' or 'name' not found in the cloned card:", card);
            }
        }

        // Set id to accept land request
        const acceptForm = card.querySelector('.accept-form');
        if (acceptForm) {
            const landID = acceptForm.querySelector('#landID');

            if (landID) {
                landID.value = security.lid;
                // console.log(landID.value);
            } else {
                console.error("Form inputs with id 'id' or 'name' not found in the cloned card:", card);
            }
        }

        return { id: security.id, name: security.name, district: security.preferredDistrictToWork, province: security.preferredProvinceToWork, element: card };
    });

</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
