<h2>Please sign in!</h2>

<div class="col-3">

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Bad username and/or password!</strong> Please try again and don't give up.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>

    <form action="/?a=login" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-user"></span>
                    </div>
                </div>
                <input name="username" type="username" class="form-control" id="email" placeholder="Enter username">
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                </div>
                <input name="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <small class="form-text text-muted">In case of problem don't hesitate to call *112</small>
        </div>
        <button type="submit" class="btn btn-primary">Log in</button>
    </form>
</div>