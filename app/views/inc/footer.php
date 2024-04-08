    <div class="overlay-container"></div>
    <script>
        window.addEventListener("load", function() {
            const loader = document.querySelector(".loader-wrapper");
            loader.style.display = "none";
        });

        // const rightCol = document.querySelector(".right-col");
        // const leftCol = document.querySelector(".left-col");
        // setTimeout(function() {
        //     rightCol.classList.add("reveal");
        //     leftCol.classList.add("reveal");
        // }, 500);

        const reveal_anm = document.querySelector(".form-container");
        setTimeout(function() {
            reveal_anm.classList.add("reveal");
        }, 200);

        const side_cards = document.querySelector(".side-cards");
        setTimeout(function() {
            side_cards.classList.add("reveal");
        }, 100);

        // const charts = document.querySelector(".charts");
        // setTimeout(function() {
        //     charts.classList.add("reveal");
        // }, 100);
    </script>
    </body>
</html>