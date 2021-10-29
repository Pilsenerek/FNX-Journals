<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="/all.css">
    </head>
    <body>

        <div class="jumbotron text-left">
            <a href="/">
                <h1>
                    <img width="150" src="/img/logo.png">
                    Journals 2
                </h1>
            </a>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?a=categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?a=authors">Authors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?a=tags">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/?a=chat">Chat</a>
                    </li>
                </ul>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <?php if (empty($_user)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/?a=login">
                                <span class="far fa-user mr-2"></span>Login
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/?a=logout">
                                <span class="fa fa-user mr-2"></span>Logout <?php echo $_user->getUsername() ?>
                                (<?php echo number_format($_user->getWallet(), 2, ',', ' ') ?> $)
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>

        <div class="container-fluid mt-5">

            <?php echo $_content ?>

        </div>   

        <footer class="footer">
            <div class="text-center py-3 mt-5 mb-5">
                © 2018 Copyright: <a href="http://fnx-group.com/">FNX Group</a>
            </div>
        </footer>

    </body>
</html>


