<!DOCTYPE html>
<html lang="en">

<?php include '../header.php' ?>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">


        <?php include '../nav.php' ?>

        <!-- Main -->
        <div id="main">


            <!-- Posts -->
            <section style="display:flex; align-items:center; justify-content: center; flex-direction:column;"
                class="posts">
                <form method="POST" action="/join/loginProcess.php">

                    <label for="exampleFormControlInput1">아이디</label>
                    <input name="id" type="id" id="exampleFormControlInput1" placeholder="id">
                    <label for="exampleFormControlInput1">비밀번호</label>
                    <input name="password" type="password" id="exampleFormControlInput1" placeholder="password">


                    <button type="submit">접속</button>

                </form>
            </section>


        </div>

        <?php include '../footer.php' ?>

        <!-- Scripts -->
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/jquery.scrollex.min.js"></script>
        <script src="/assets/js/jquery.scrolly.min.js"></script>
        <script src="/assets/js/browser.min.js"></script>
        <script src="/assets/js/breakpoints.min.js"></script>
        <script src="/assets/js/util.js"></script>
        <script src="/assets/js/main.js"></script>

</body>

</html>