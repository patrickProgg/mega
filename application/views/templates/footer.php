<!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert2@11.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script> -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('sidebar');
        const menuBar = document.querySelector('#content nav .bx.bx-menu');

        if (!sidebar || !menuBar) return; // Stop if elements are missing

        if (localStorage.getItem("sidebarState") === "hidden") {
            sidebar.classList.add("hide");
        }

        sidebar.style.visibility = "visible";

        menuBar.addEventListener('click', function() {
            sidebar.classList.toggle('hide');
            localStorage.setItem("sidebarState", sidebar.classList.contains('hide') ? "hidden" : "visible");
        });
    });

    // const searchButton = document.querySelector('#content nav form .form-input button');
    // const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    // const searchForm = document.querySelector('#content nav form');

    // searchButton.addEventListener('click', function(e) {
    //     if (window.innerWidth < 576) {
    //         e.preventDefault();
    //         searchForm.classList.toggle('show');
    //         if (searchForm.classList.contains('show')) {0
    //             searchButtonIcon.classList.replace('bx-search', 'bx-x');
    //         } else {
    //             searchButtonIcon.classList.replace('bx-x', 'bx-search');
    //         }
    //     }
    // })

    // if (window.innerWidth < 768) {
    //     sidebar.classList.add('hide');
    // } else if (window.innerWidth > 576) {
    //     searchButtonIcon.classList.replace('bx-x', 'bx-search');
    //     searchForm.classList.remove('show');
    // }

    // window.addEventListener('resize', function() {
    //     if (this.innerWidth > 576) {
    //         searchButtonIcon.classList.replace('bx-x', 'bx-search');
    //         searchForm.classList.remove('show');
    //     }
    // })   

    
    const switchMode = document.getElementById('switch-mode');
 
    switchMode.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
    })

    $(document).ready(function() {
        $(".tab-content").hide(); // Hide all tab content initially
        $(".tab-content.active").show(); // Show only the active tab

        $(".tab-link").click(function(e) {
            e.preventDefault(); // Prevent default link behavior

            let tabID = $(this).data("tab"); // Get tab ID from data attribute

            // Remove active class from all tabs and hide all content
            $(".tab-link").removeClass("active");
            $(".tab-content").removeClass("active").hide();

            // Add active class to the clicked tab and show its content
            $(this).addClass("active");
            $("#" + tabID).addClass("active").fadeIn(300);
        });
    });

    document.querySelectorAll('.tab-link').forEach(tab => {
        tab.addEventListener('click', function() {
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 100);
        });
    });

    function capitalizeName(input) {
        input.value = input.value.replace(/\b\w/g, char => char.toUpperCase());
    }

    function formatDate(dateString) {
        if (!dateString) return ''; // Handle empty/null values
        let date = new Date(dateString);
        let options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        return date.toLocaleDateString('en-US', options);
    }

</script>