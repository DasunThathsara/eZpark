<?php require APPROOT.'/views/inc/header.php'; ?>
<!--  TOP NAVIGATION  -->
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<!--  SIDE NAVIGATION  -->
<?php
$section = 'notifications';
require APPROOT.'/views/inc/components/sidenavbar.php';
?>

<main class="page-container">
    <section class="section" id="main">
        <div class="container">
            <h1 class="title">All notifications</h1>
            <p class="subtitle">View and Edit information related to notifications</p>

            <br><br>

            <div class="content-body">
                <?php if (sizeof($other_data) == 0) {?>
                    <div class="emptynotification">You have no any registered notifications</div>
                <?php }
                else {?>
                    <div class="title-options" style="width: 150px;">
                        <div class="all-notifications option-item option-item-active">All</div>
                        <div class="available-notifications option-item">Unread</div>
                        <div class="unavailable-notifications option-item">Read</div>
                    </div>
                    <hr class="option-break" />
                    <!-- Search area -->
                    <div class="search-area">
                        <!-- Search bar -->
                        <input type="search" class="data-search" placeholder="Search notification...">
                        <div class="filter-area">
                            <img class="filter-btn" src="<?php echo URLROOT?>/images/filter-ico.png" alt="">
                        </div>
                    </div>

                    <div class="user-card-title">
                        <div class="name">Name</div>
                    </div>

                    <div class="card-set-container">
                        <!-- Card set -->
                        <div class="user-cards"></div>
                        <template class="data-user-template">
                            <div class="card">
                                <a href="" class="tile">
                                    <table>
                                        <tr>
                                            <td class="name-td" data-header style="width: 100%">
                                                <p class="name" style="color: black; font-size: 14px"></p>
                                                <p class="id-p"><span class="id"></span></p>
                                            </td>
                                            <td class="options">
                                                <form action="<?php echo URLROOT ?>/users/removeNotification" method="post" class="delete-form" id="delete-form">
                                                    <input type="text" name="id" id="id" hidden value="" />
                                                    <button type="submit" class="delete" onclick="confirmSubmit()">
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
    document.addEventListener("DOMContentLoaded", function () {
        const requestForm = document.getElementById("delete-form");

        if (requestForm) {
            const submitButton = requestForm.querySelector("button[type='submit']");

            if (submitButton) {
                submitButton.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the form from submitting

                    // Use SweetAlert for confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete this.',
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
        notifications.forEach(notification => {
            const isVisible = notification.name.toLowerCase().includes(value) || notification.city.toLowerCase().includes(value) || notification.street.toLowerCase().includes(value);
            if (notification.element) {
                notification.element.classList.toggle("hide", !isVisible);
            }
        });
    });

    let notifications = [];
    var backendData = <?php echo json_encode($other_data['list']); ?>;

    notifications = backendData.map(notification => {
        const card = userCardTemplate.content.cloneNode(true).children[0];
        console.log(card);
        card.querySelector(".name").textContent = notification.notification;
        card.querySelector(".id").textContent = notification.notificationTime;

        document.querySelector(".user-cards").appendChild(card);
        const tileLink = card.querySelector('.tile');

        // Set the parking view link
        if (tileLink) {
            if (notification.notificationType == 'securityRequest') {
                tileLink.href = `<?php print_r(URLROOT)?>/security/viewnotificationRequest/${notification.senderID}/${notification.receiverID}`;
            }
            else if (notification.notificationType == 'landRegistration') {
                tileLink.href = `<?php print_r(URLROOT)?>/admin/viewRegistrationRequestedLand/${notification.senderID}`;
            }
        } else {
            console.error("Anchor element with class 'tile' not found in the cloned card:", card);
        }

        // Set values to go to the update page
        const deleteForm = card.querySelector('.delete-form');
        if (deleteForm) {
            const idInput = deleteForm.querySelector('#id');

            if (idInput) {
                idInput.value = notification.id;
            } else {
                console.error("One or more form inputs not found in the cloned card:", card);
            }
        }

        return { id: notification.id, notification: notification.notification, status: notification.status, notificationTime: notification.notificationTime, element: card };
    });

    // ------------------------------- Filter -------------------------------
    const allnotifications = document.querySelector(".all-notifications");
    const availablenotifications = document.querySelector(".available-notifications");
    const unavailablenotifications = document.querySelector(".unavailable-notifications");

    allnotifications.addEventListener("click", () => {
        allnotifications.classList.add("option-item-active");
        availablenotifications.classList.remove("option-item-active");
        unavailablenotifications.classList.remove("option-item-active");
        notifications.forEach(notification => {
            notification.element.classList.remove("hide");
        });
    });

    availablenotifications.addEventListener("click", () => {
        allnotifications.classList.remove("option-item-active");
        availablenotifications.classList.add("option-item-active");
        unavailablenotifications.classList.remove("option-item-active");
        notifications.forEach(notification => {
            if (notification.status === '0') {
                notification.element.classList.remove("hide");
            } else {
                notification.element.classList.add("hide");
            }
        });
    });

    unavailablenotifications.addEventListener("click", () => {
        allnotifications.classList.remove("option-item-active");
        availablenotifications.classList.remove("option-item-active");
        unavailablenotifications.classList.add("option-item-active");
        notifications.forEach(notification => {
            if (notification.status === '1') {
                notification.element.classList.remove("hide");
            } else {
                notification.element.classList.add("hide");
            }
        });
    });
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>

