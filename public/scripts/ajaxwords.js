$(document).ready(function () {
    var url = '/engwo/ajaxanswer/';
    var filters;
    var order = 'asc';
    var name = 'id';
    var id = 1;
    var max = 0;

    $(document).on('click', '.employees-navbar .item-order', function () {
        var $this = $(this);
        $this.data('order', ($this.data('order') === 'desc') ? 'asc' : 'desc');
        order = $this.data('order');
        name = $this.data('name');
        reloadList();

        $this.removeClass((order === 'desc') ? 'asc' : 'desc');
        $this.addClass(order);
        $('.employees-navbar .item-order').removeClass('active');
        $this.addClass('active');
    });

    $('#button_search').on('click', function (e) {
        e.preventDefault();
        filters = {
            'word': $("input[name^='word']").val(),
            'translation': $("input[name^='translation']").val(),
            'lesson': $("input[name^='lesson']").val()
        }
        id = 1;
        $('#page').text(id + ' page');
        reloadList();
    });

    $('.lazy-employee-expand').on('click', function (e) {
        e.preventDefault();
        max += 10;
        getAjax(true, false);
    });

    $('.lazy-employee-back').on('click', function (e) {
        e.preventDefault();
        max -= 10;
        if (max < 0) {
            max = 0;
        }
        getAjax(true, true);
    });

    $('.lazy-employee-next').on('click', function (e) {
        e.preventDefault();
        id = id + 1;
        $('.lazy-employee-expand').data('id', id);
        getAjax(false, false);
    });

    $('.lazy-employee-return').on('click', function (e) {
        e.preventDefault();
        id = id - 1;
        if (id <= 0) {
            id = 1;
        }
        getAjax(false, true);
    });

    function getAjax(row, back) {
        var params = getActualParams();

        $.ajax(params).done(function (data) {
            if (row) {
                if (!back) {
                    if (max > data.length) {
                        max = max - 10;
                    }
                }
                if (data.length > 0) {
                    showList(data);
                    $('#pages').text(10 + max);
                }
            } else {
                if (data.length > 0) {
                    showList(data);
                    $('#page').text(id + ' page');
                }
                if (!back) {
                    if (data.length == 0) {
                        id = id - 1;
                    }
                } else {
                    if (data.length == 0) {
                        id = id + 1;
                    }
                }
            }

        }).fail(failMessage);
    }

    function getActualParams() {
        return {
            url: url,
            dataType: 'json',
            data: {
                orderBy: name,
                order: order,
                filters: filters,
                id: id, max: max
            },
            method: 'GET'
        };
    }

    function reloadList() {
        $('.employees-list-block').empty();
        var params = getActualParams();

        $.ajax(params).done(function (data) {
            if (data.length > 0) {
                if (max > data.length) {
                    max = (Math.floor(data.length / 10) + 1) * 10 - 10;
                    $('#pages').text((10 + max) + ' строк на странице');
                }
                showList(data);
            }
        }).fail(failMessage);
    }

    function showList(data) {
        var str = '<div class="row"><div class="col-md-12 col-xs-12 employees-list"><ul class="list-group">';
        $('.employees-list-block').empty().append(str);

        $.each(data, function (key, myrow) {

            str = '<li class="list-group-item list-group-item-action employees-list-item" data-employee-id="' + myrow['id'] + '"><div class="employee-item-id d-inline-block">' + myrow['id'] + '</div><div class="employee-item-word d-inline-block">' + myrow['word'] + '</div><div class="employee-item-translation d-inline-block">' + myrow['translation'] + '' + '</div><div class="employee-item-lesson d-inline-block">' + myrow['lesson'] + '</div><div class="employee-item-edit d-inline-block">' + '<a href="/engwo/edit/' + myrow['id'] + '"class="btn btn-primary">Редактировать</a></div><div class="employee-item-employment-delete d-inline-block"><a href="/engwo/delete/' + myrow['id'] + '" class="btn btn-danger">Удалить</a></div></li>';
            $('.employees-list-block').append(str);

        });

        str = '</ul></div></div>';
        $('.employees-list-block').append(str);
    }

    function failMessage() {
        alert('Network error');
    }

});