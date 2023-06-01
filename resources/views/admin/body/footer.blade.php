<footer class="main-footer">
    <div class="pull-right d-none d-sm-inline-block">
        <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">FAQ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Purchase Now</a>
            </li>
        </ul>
    </div>
    &copy; <span id="year"></span> <a href="#">Ecommerce</a>. All Rights Reserved.
</footer>
<script>
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();

    const span = document.querySelector('#year');
    span.innerHTML = currentYear;
</script>