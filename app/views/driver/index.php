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
            <div id="map" style="margin-top: 50px; height: 80vh; border-radius: 10px;"></div>
<!--            <div class="search">-->
<!--                <input type="text" class="parking-search" placeholder="Search Parking" style="border: 1px solid #ccc">-->
<!--            </div>-->
<!--            <div class="map">-->
<!--                <img src="--><?php //echo URLROOT ?><!--/images/location.png" alt="">-->
<!--                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4231.666368350934!2d79.86014226253688!3d6.902790088271364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259100761b8f3%3A0x78f0a33054ea929b!2sIndependence%20Square%20Parking%20Lot!5e0!3m2!1sen!2slk!4v1697709991816!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>-->
<!--            </div>-->

            <!-- Search bar -->
<!--            <input type="search" class="data-search" placeholder="Search..">-->

            <!-- Card set -->
<!--            <div class="user-cards"></div>-->
<!--            <template class="data-user-template">-->
<!--                <div class="card" style="padding: 10px;">-->
<!--                    <a href="" class="tile">-->
<!--                        <table>-->
<!--                            <tr>-->
<!--                                <td class="name" data-header></td>-->
<!--                                <td class="city" data-des></td>-->
<!--                                <td>-->
<!--                                    <form action="--><?php //echo URLROOT?><!--/driver/enterExitParking" method="post" class="enter_exit_to_parking" id="enter_exit_to_parking">-->
<!--                                        <input type="hidden" id="id" name="id" value="">-->
<!--                                        <input type="submit" value="Enter" class="btn btn-primary" style="background-color: #fcd426; border-radius: 10px; padding: 10px 20px 10px 20px">-->
<!--                                    </form>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </template>-->
        </div>
    </section>
</main>

<!--<script>-->
<!--    function confirmSubmit() {-->
<!--        return confirm("Are you sure you want to delete this land?");-->
<!--    }-->

<!--    // ------------------------------- Search Bar --------------------------------->
<!--    //const userCardTemplate = document.querySelector(".data-user-template");-->
<!--    //const searchInput = document.querySelector(".parking-search");-->
<!--    //-->
<!--    //searchInput.addEventListener("input", (data) => {-->
<!--    //    const value = data.target.value.toLowerCase();-->
<!--    //    lands.forEach(land => {-->
<!--    //        const isVisible = land.name.toLowerCase().includes(value) || land.city.toLowerCase().includes(value) || land.street.toLowerCase().includes(value);-->
<!--    //        if (land.element) {-->
<!--    //            land.element.classList.toggle("hide", !isVisible);-->
<!--    //        }-->
<!--    //    });-->
<!--    //});-->
<!--    //-->
<!--    //let lands = [];-->
<!--    //var backendData = --><?php ////echo json_encode($data); ?><!--//;-->
<!--    //-->
<!--    //lands = backendData.map(land => {-->
<!--    //    const card = userCardTemplate.content.cloneNode(true).children[0];-->
<!--    //    console.log(card);-->
<!--    //    card.querySelector(".name").textContent = land.name;-->
<!--    //    card.querySelector(".city").textContent = land.city;-->
<!--    //    document.querySelector(".user-cards").appendChild(card);-->
<!--    //    const tileLink = card.querySelector('.tile');-->
<!---->
<!--        // Set the parking view link-->
<!--        // if (tileLink) {-->
<!--        //     tileLink.href = `gotoLand/${land.id}`;-->
<!--        // } else {-->
<!--        //     console.error("Anchor element with class 'tile' not found in the cloned card:", card);-->
<!--        // }-->
<!---->
<!--        // Set id and name to go to the price page-->
<!--        // const enter_exit_to_parking = card.querySelector('.enter_exit_to_parking');-->
<!--        // if (enter_exit_to_parking) {-->
<!--        //     const idInput = enter_exit_to_parking.querySelector('#id');-->
<!--        //-->
<!--        //     if (idInput) {-->
<!--        //         idInput.value = land.id;-->
<!--        //     } else {-->
<!--        //         console.error("Form inputs with id 'id' or 'name' not found in the cloned card:", card);-->
<!--        //     }-->
<!--        // }-->
<!---->
<!---->
<!--        // Set id and name to delete the land-->
<!--//        const deleteForm = card.querySelector('.delete-form');-->
<!--//        if (deleteForm) {-->
<!--//            const nameInput = deleteForm.querySelector('#name');-->
<!--//-->
<!--//            if (nameInput) {-->
<!--//                nameInput.value = land.name; // Set the value dynamically-->
<!--//            } else {-->
<!--//                console.error("Form input with id 'name' not found in the cloned card:", card);-->
<!--//            }-->
<!--//        }-->
<!--//-->
<!--//        return { id: land.id, name: land.name, city: land.city, street: land.street, element: card };-->
<!--//    });-->
<!--</script>-->

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAP?>"></script>
<script>
    function initMap() {
        // Initialize the map centered on the user's current location
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                center: userLocation,
                zoom: 14 // Adjust the zoom level as needed
            });

            var iconSize = new google.maps.Size(40, 40);

            // Add a marker for the user's current location
            var userMarker = new google.maps.Marker({
                position: userLocation,
                map: map,
                title: 'Your Current Location',
                icon: {
                    url: '<?php echo URLROOT ?>/public/images/pin1.png',
                    scaledSize: iconSize
                }
            });

            // Define multiple locations to be displayed on the map
            var locations = [
                <?php foreach ($data as $land){
                echo "{ lat: $land->latitude, lng: $land->longitude, name: '$land->name', type: '$land->availability' },\n";
            }?>
                // Add more locations as needed
            ];

            // Add markers for each location
            locations.forEach(function(location) {
                var markerIcon;
                if (location.type === '1') {
                    markerIcon = '<?php echo URLROOT ?>/public/images/pin-g.png';
                } else if (location.type === '0') {
                    markerIcon = '<?php echo URLROOT ?>/public/images/pin-r.png';
                } else {
                    markerIcon = '<?php echo URLROOT ?>/public/images/pin-y.png';
                }

                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: location.name,
                    icon: {
                        url: markerIcon,
                        scaledSize: iconSize
                    }
                });

                // Add click event listener to the marker
                marker.addListener('click', function() {
                    // Navigate to another page
                    window.location.href = '<?php echo URLROOT?>/driver/gotoLand/';
                });
            });
        });
    }

    initMap();
</script>
<?php require APPROOT.'/views/inc/footer.php'; ?>
