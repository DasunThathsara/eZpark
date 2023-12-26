<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'securities';
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
                    <div class="emptysecurity">You have no any registered securities</div>
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
                                                <p class="id-p">security ID: <span class="id"></span></p>
                                            </td>
                                            <td class="district" data-header></td>
                                            <td class="province" data-header></td>

                                            <td class="options">
                                                <form action="" method="POST" class="request-form" id="request-form">
                                                    <input type="text" name="landID" id="landID" hidden value="" />
                                                    <input type="text" name="securityID" id="securityID" hidden value="" />
                                                    <button type="submit" class="price" onclick="confirmSubmit()">
                                                        <img id="dynamicImage" src="" alt="">
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
        const requestForm = document.getElementById("request-form");

        if (requestForm) {
            const submitButton = requestForm.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to submit this.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, submit it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            requestForm.submit();
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
    var pendingSecurityData = <?php echo json_encode($other_data['pending_securities']); ?>;

    securities = backendData.map(security => {
        const card = userCardTemplate.content.cloneNode(true).children[0];
        card.querySelector(".name").textContent = security.name;
        card.querySelector(".district").textContent = security.preferredDistrictToWork;
        card.querySelector(".province").textContent = security.preferredProvinceToWork;
        card.querySelector(".id").textContent = security.id;

        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');

        // Set the parking view link
        if (tileLink) {
            tileLink.href = `<?php echo URLROOT?>/land/viewSecurity/${security.id}`;
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }

        // Set id and name to go to the price page
        const requestForm = card.querySelector('.request-form');
        if (requestForm) {
            const landID = requestForm.querySelector('#landID');
            const securityID = requestForm.querySelector('#securityID');

            if (landID && securityID) {
                securityID.value = security.id;
                landID.value = <?php print_r($other_data['id']) ?>;
            } else {
                console.error("Form inputs with id 'id' or 'name' not found in the cloned card:", card);
            }
        }


        if (pendingSecurityData.includes(security.id)){
            requestForm.setAttribute("action", '<?php echo URLROOT ?>/land/cancelRequest');
            document.getElementById("dynamicImage").src = '<?php echo URLROOT ?>/images/pending.svg';
        }
        else{
            requestForm.setAttribute("action", '<?php echo URLROOT ?>/land/sendRequest');
            document.getElementById("dynamicImage").src = '<?php echo URLROOT ?>/images/sec-add.svg';
        }

        return { id: security.id, name: security.name, district: security.preferredDistrictToWork, province: security.preferredProvinceToWork, element: card };
    });


    // ------------------------------- Filter -------------------------------
    const allSecurities = document.querySelector(".all-securities");
    const districtSecurities = document.querySelector(".district-securities");
    const provinceSecurities = document.querySelector(".province-securities");

    allSecurities.addEventListener("click", () => {
        allSecurities.classList.add("option-item-active");
        districtSecurities.classList.remove("option-item-active");
        provinceSecurities.classList.remove("option-item-active");
        securities.forEach(security => {
            security.element.classList.remove("hide");
        });
    });

    districtSecurities.addEventListener("click", () => {
        allSecurities.classList.remove("option-item-active");
        districtSecurities.classList.add("option-item-active");
        provinceSecurities.classList.remove("option-item-active");
        securities.forEach(security => {
            if (security.district === '<?php print_r($other_data['district'])?>') {
                security.element.classList.remove("hide");
            } else {
                security.element.classList.add("hide");
            }
        });
    });

    provinceSecurities.addEventListener("click", () => {
        allSecurities.classList.remove("option-item-active");
        districtSecurities.classList.remove("option-item-active");
        provinceSecurities.classList.add("option-item-active");
        securities.forEach(security => {
            if (security.province === '<?php print_r($other_data['province'])?>') {
                security.element.classList.remove("hide");
            } else {
                security.element.classList.add("hide");
            }
        });
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
