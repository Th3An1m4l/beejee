<?=$addTaskModal?>

<?=$adminLoginModal?>

<div class="container mt-2">
    <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <?php if (!$adminStatus) { ?><button type="button" data-toggle="modal" data-target="#task-container" class="btn btn-success">Add task</button><? } ?>
        <button type="button" id="admin-toggle" data-toggle="modal" data-target="#login-container" data-status="<?=(!$adminStatus) ? 0 : $adminStatus?>" class="btn btn-info ml-auto "><?php
            if($adminStatus == 'loggedin') echo "Admin Logout"; else echo "Admin Login";
            ?></button>
    </nav>
    <div class="card mb-2">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#
                        <span id="id-sort" class="sortable" data-name="id" data-sort="" style="margin-left: 5px; font-size: 1em; color: lightcyan;">
                            <i class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th scope="col">User name
                        <span id="username-sort" class="sortable" data-name="username" data-sort="" style="margin-left: 5px; font-size: 1em; color: lightcyan;">
                            <i class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th scope="col">E-mail
                        <span id="email-sort" class="sortable" data-name="email" data-sort="" style="margin-left: 5px; font-size: 1em; color: lightcyan;">
                            <i class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th scope="col">Task</th>
                    <th scope="col">Status
                        <span id="status-sort" class="sortable" data-name="status" data-sort="" style="margin-left: 5px; font-size: 1em; color: lightcyan;">
                            <i class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th scope="col">Created</th>
                    <th scope="col">Edited</th>
                </tr>
                </thead>
                <tbody id="taskListBody">
                    <?=$taskListBody?>
                </tbody>
            </table>
            <?=$pagination?>
        </div>
    </div>
    <?=$successAlert?>
    <?=$errorAlert?>
</div>