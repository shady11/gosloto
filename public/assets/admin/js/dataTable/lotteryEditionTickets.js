var DatatableRemoteAjaxDemo = {
    init: function() {
        var t;
        t = $("#data_tickets").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/getLotteryEditionTickets',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        params: {
                            lotteryEdition: $('#lotteryEdition').val(),
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
                field: "user",
                selector: !1,
                title: "Реализатор"
            }, {
                field: "supervisor",
                selector: !1,
                title: "Супервайзер"
            }, {
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
                field: "sold_date",
                selector: !1,
                title: "Дата продажи"
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

var DatatableTicketsBack = {
    init: function() {
        var t;
        t = $("#data_tickets_back").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/getLotteryEditionTicketsBack',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        params: {
                            lotteryEdition: $('#lotteryEdition').val(),
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
                field: "id",
                title: "ID",
                width: 50
            }, {
                field: "ticket_number",
                title: "Номер билета"
            }, {
                field: "lottery_edition",
                title: "Тираж лотереи"
            }, {
                field: "user",
                selector: !1,
                title: "Реализатор"
            }, {
                field: "supervisor",
                selector: !1,
                title: "Супервайзер"
            }, {
                field: "return_date",
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
    DatatableRemoteAjaxDemo.init();
    DatatableTicketsBack.init();
});