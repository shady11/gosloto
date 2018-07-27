var DatatableRecordSelectionDemo = function() {
    var t = {
        data: {
            type: "remote",
            source: {
                read: {
                    url: '/getUsers',
                    headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                },
            },
            pageSize: 10,
            serverPaging: !0,
            serverFiltering: !0,
            serverSorting: !0
        },
        layout: {
            theme: "default",
            class: "test",
            scroll: !0,
            height: 'auto',
            footer: !1
        },
        sortable: !0,
        pagination: !0,
        toolbar: {
            placement: ["bottom"],
            items: {
                pagination: {
                    pageSizeSelect: [2, 5, 10, 20, 30, 50]
                }
            }
        },
        columns: [
        {
            field: "id",
            title: "ID",
            width: 40,
        }, {
            field: "name",
            title: "ФИО",
            width: 100,
            attr: {
                nowrap: "nowrap"
            },
            template: function(t) {
                return '<a href="'+t.showLink+'" class="m-link">'+t.name+' '+t.lastname+'</a>'
            }
        }, {
            field: "email",
            title: "Email",
            width: 200,
            attr: {
                nowrap: "nowrap"
            }
        }, {
            field: "login",
            title: "Логин"
        }, 
        {
            field: "active",
            title: "Статус",
            template: function(t) {
                var e = {
                    0: {
                        title: "неактивный",
                        class: "m-badge--metal"
                    },
                    1: {
                        title: "активный",
                        class: " m-badge--success"
                    }
                };
                return '<span class="m-badge ' + e[t.active].class + ' m-badge--wide">' + e[t.active].title + "</span>"
            }
        }, {
            field: "type",
            title: "Тип"
        }, {
            field: "actions",
            width: 110,
            title: "Actions",
            sortable: !1,
            textAlign: "right"
        }]
    };
    return {
        init: function() {
            ! function() {
                t.extensions = {
                    checkbox: {}
                }, t.search = {
                    input: $("#generalSearch")
                };
                var e = $("#server_record_selection").mDatatable(t);
                $("#m_form_status").on("change", function() {
                    e.search($(this).val().toLowerCase(), "active")
                }), $("#m_form_type").on("change", function() {
                    e.search($(this).val().toLowerCase(), "type")
                }), $("#m_form_status,#m_form_type").selectpicker()
            }()
        }
    }
}();
jQuery(document).ready(function() {
    DatatableRecordSelectionDemo.init()
});