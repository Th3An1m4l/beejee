<div class="modal fade" id="login-container" tabindex="-1" role="dialog" aria-labelledby="login-container-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="login-container-label">Admin login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation-login" id="login-form" novalidate>
                    <div class="form-group">
                        <label for="user-name" class="col-form-label">User name:</label>
                        <input type="text" pattern="[a-zA-Z0-9._]{5,10}" class="form-control" name="username" id="user-name" required>
                        <div class="invalid-feedback">
                            Please provide user name.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e-mail" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                        <div class="invalid-feedback">
                            Please provide valid e-mail.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-login-form">login</button>
            </div>`
        </div>
    </div>
</div>