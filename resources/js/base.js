$(function() {
    $('#drop-db').click(function () {
        data = {};

        $.ajax({
            url: 'dropDb',
            data: data,
            processData: false,
            type: 'POST',
            success: function ( data ) {
                updateTaskList(0);
            }
        });
    })

    $('#task-container').on('show.bs.modal', function (event) {
        var modal = $(this);

        modal.find('.modal-body input').val('');
        modal.find('.modal-body textarea').val('');
    })

    $('#submit-task-form').on('click', function (event) {
        trimTaskDescriptionBeforeCheck();

        var form = document.getElementsByClassName('needs-validation')[0];

        form.classList.add('was-validated');

        if (form.checkValidity() !== false) {
            saveTaskForm();
        }
    })

    $('#login-container').on('show.bs.modal', function (event) {
        var modal = $(this);

        if($("#admin-toggle").data('status') != 0) {
            event.preventDefault();
            logoutAttempt();
        }
        
        modal.find('.modal-body input').val('');
        modal.find('.modal-body textarea').val('');

        $('#login-container').modal('hide');
    })

    $('#submit-login-form').on('click', function (event) {
        var form = document.getElementsByClassName('needs-validation-login')[0];

        form.classList.add('was-validated');

        if (form.checkValidity() !== false) {
            loginAttempt();
        }
    })

    $("#id-sort, #username-sort,#email-sort,#status-sort").on('click', function () {
        var state = $(this).data('sort');

        switch (state) {
            case '':
                $(this).data('sort', 'asc');
                $(this).find("i").toggleClass('fa-sort', false);
                $(this).find("i").toggleClass('fa-sort-down');
                break;
            case 'asc':
                $(this).data('sort', 'desc');
                $(this).find("i").toggleClass('fa-sort-down', false);
                $(this).find("i").toggleClass('fa-sort-up');
                break;
            case 'desc':
                $(this).data('sort', '');
                $(this).find("i").toggleClass('fa-sort-up', false);
                $(this).find("i").toggleClass('fa-sort');
                break;
        }

        var activePage = $('a.page-link.active').data('page');

        updateTaskList(activePage);

    });

    bindEditProcessor();
    bindPaginateProcessor();
});

function updateTaskList(activePage) {
    var formData = new FormData();

    $(".sortable").each(function () {
        var name = $(this).data('name')
        var value= $(this).data('sort');

        formData.append(name, value);
    });

    formData.append('active', activePage);

    $.ajax({
        url: 'updateTaskList',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function ( data ) {
            data = $.parseJSON(data);
            $('#taskListBody').html(data.taskListBody);
            $('#pagination').replaceWith(data.pagination);

            bindEditProcessor();
            bindPaginateProcessor();
        }
    });
}


function trimTaskDescriptionBeforeCheck() {
    $("#task-description").val($("#task-description").val().trim());
}

function saveTaskForm() {
    var data = $("#task-form").serialize();

    $.ajax({
        url: 'saveTaskForm',
        data: data,
        processData: false,
        type: 'POST',
        success: function ( data ) {
            data = $.parseJSON(data);

            if(!data.activePage) window.location.reload();

            $('#task-container').modal('hide');

            $('.needs-validation').toggleClass('was-validated', false);

            if($("#admin-toggle").data('status') != 0) {
                var activePage = $('a.page-link.active').data('page');
            } else {
                var activePage = data.activePage
            }

            updateTaskList(activePage);

            $('.alert.alert-info').fadeIn(1500);

            $('.close').click(function (e) {
                e.preventDefault();
                $('.alert.alert-info').fadeOut(1500);
            })
        }
    });
}

function bindPaginateProcessor() {
    $('a.page-link').on('click', (function (e) {
        e.preventDefault();
        var activePage = $('a.page-link.active').data('page');

        switch ($(this).data('page')) {
            case 'next':
                activePage++;
                break
            case 'prev':
                activePage--;
                break
            default:
                activePage = $(this).data('page');
                break
        }

        updateTaskList(activePage);
    }));
}

function bindEditProcessor() {
    if($("#admin-toggle").data('status') != 0) {
        $(".editableRow").on('click', function () {
            $('#task-container').modal('show');

            $("#task-description").val($(this).data('description'));
            $("#task-id").val($(this).data('id'));
            let status = $(this).data('status');

            switch (status) {
                case 'new':
                    // hmm... doo nothing
                    break;
                case 'completed':
                    $("#task-status").prop('checked', 'checked');
                    break;
            }
        });
    }
}

function loginAttempt() {
    var data = $("#login-form").serialize();

    $.ajax({
        url: 'loginAttempt',
        data: data,
        processData: false,
        type: 'POST',
        success: function ( data ) {
            data = $.parseJSON(data);

            $('#login-container').modal('hide');
            $('.needs-validation-login').toggleClass('was-validated', false);

            if (!data.status) {
                $('.alert.alert-danger').fadeIn(1500);

                $('.close').click(function (e) {
                    e.preventDefault();
                    $('.alert.alert-danger').fadeOut(1500);
                })
            } else {
                window.location.reload();
            }
        }
    });
}

function logoutAttempt() {
    $.post( "logoutAttempt", function( data ) {
        window.location.reload();
    });
}