var DatatableDrawCreatedTickets = {
    init: function() {
        var t;
        t = $("#drawCreatedTickets").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/getDrawCreatedTickets',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        params: {
                            draw: $('#draw').val(),
                        }
                    }
                },
                pageSize: 10,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0,
                saveState: {
                    cookie: false,
                    webstorage: false
                }
            },
            layout: {
                scroll: !1,
                footer: !1
            },
            sortable: !0,
            pagination: !0,
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: [10, 20, 30, 50, 100]
                    }
                }
            },
            search: {
                input: $("#generalSearch")
            },
            columns: [{
                field: "ticket_number",
                title: "Номер билета"
            }, {
                field: "seller_id",
                selector: !1,
                title: "Реализатор"
            }, {
                field: "supervisor_id",
                selector: !1,
                title: "Супервайзер"
            }, {
                field: "status",
                title: "Статус",
                template: function(t) {
                    var e = {
                        0: {
                            title: "неактивный",
                            class: "m-badge--metal"
                        },
                        1: {
                            title: "выдан",
                            class: " m-badge--info"
                        },
                        2: {
                            title: "выдан",
                            class: " m-badge--info"
                        },
                        3: {
                            title: "продан",
                            class: " m-badge--success"
                        },
                        4: {
                            title: "возврат",
                            class: " m-badge--danger"
                        }
                    };
                    return '<span class="m-badge ' + e[t.status].class + ' m-badge--wide">' + e[t.status].title + "</span>"
                }
            }, {
                field: "actions",
                title: "Actions",
                sortable: !1,
                textAlign: "right",
                overflow: "visible"
            }]
        })
    }
};

var DatatableDrawReturnedTickets = {
    init: function() {
        var t;
        t = $("#drawReturnedTickets").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/getDrawReturnedTickets',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        params: {
                            draw: $('#draw').val(),
                            // generalSearch2: $('#generalSearch2').val(),
                        }
                    }
                },
                pageSize: 10,
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0,
                saveState: {
                    cookie: false,
                    webstorage: false
                }
            },
            layout: {
                scroll: !1,
                footer: !1
            },
            sortable: !0,
            pagination: !0,
            toolbar: {
                items: {
                    pagination: {
                        pageSizeSelect: [10, 20, 30, 50, 100]
                    }
                }
            },
            search: {
                input: $("#generalSearch2")
            },
            columns: [{
                field: "ticket_number",
                title: "Номер билета"
            }, {
                field: "seller_id",
                selector: !1,
                title: "Реализатор"
            }, {
                field: "supervisor_id",
                selector: !1,
                title: "Супервайзер"
            }, {
                field: "returned_at",
                selector: !1,
                title: "Дата возврата"
            }, {
                field: "actions",
                title: "Actions",
                sortable: !1,
                textAlign: "right",
                overflow: "visible"
            }]
        })
    }
};

jQuery(document).ready(function() {
    DatatableDrawCreatedTickets.init();
    DatatableDrawReturnedTickets.init();
});