    <script src="<?php echo URLROOT ?>/js/script.js"></script>
    <script>
        window.addEventListener("load", function() {
            const loader = document.querySelector(".loader-wrapper");
            loader.style.display = "none";
        });

        const rightCol = document.querySelector(".right-col");
        const leftCol = document.querySelector(".left-col");
        setTimeout(function() {
            rightCol.classList.add("reveal");
            leftCol.classList.add("reveal");
        }, 500);

        const reveal_anm = document.querySelector(".form-container");
        setTimeout(function() {
            reveal_anm.classList.add("reveal");
        }, 200);
    </script>
    </body>
</html>