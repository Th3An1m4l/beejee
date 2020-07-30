<div class="modal fade" id="task-container" tabindex="-1" role="dialog" aria-labelledby="task-container-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="task-container-label"><?php if(!$adminStatus) { ?>New task<? } else { ?> Edit task<? } ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="task-form" novalidate>
                    <?php if(!$adminStatus) { ?>
                    <div class="form-group">
                        <label for="user-name" class="col-form-label">User name:</label>
                        <input type="text" pattern="[a-zA-Z0-9._]{4,10}" class="form-control" name="username" id="user-name" required>
                        <div class="invalid-feedback">
                            Please provide user name.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="e-mail" class="col-form-label">E-mail:</label>
                        <input type="email" class="form-control" name="email" id="e-mail" required>
                        <div class="invalid-feedback">
                            Please provide valid e-mail.
                        </div>
                    </div>
                    <? } ?>
                    <div class="form-group">
                        <label for="task-description" class="col-form-label">Task description:</label>
                        <textarea class="form-control" name="description" id="task-description" required></textarea>
                        <div class="invalid-feedback">
                            Task description can't be empty.
                        </div>
                    </div>
                    <?php if($adminStatus) { ?>
                        <div class="form-check">
                            <input type="checkbox" name="status" value="true" class="form-check-input" id="task-status">
                            <label class="form-check-label" for="task-status">Completed</label>
                        </div>
                        <input type="hidden" name="taskId" id="task-id" value="">
                    <? } ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-task-form">Save</button>
            </div>
        </div>
    </div>
</div>