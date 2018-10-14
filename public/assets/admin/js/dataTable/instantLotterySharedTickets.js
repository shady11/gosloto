var DatatableRemoteAjaxDemo = {
    init: function() {
        var t;
        t = $(".m_datatable").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/getInstantLotterySharedTickets',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        params: { lottery: $('#lottery').val() }
                    }
                },
                pageSize: 10,
                serverPaging: !0,
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
                field: "supervisor_id",
                title: "Супервайзер"
            }, {
                field: "seller_id",
                title: "Реализатор"
            }, {
                field: "tickets_count",
                title: "Количество"
            }, {
                field: "shared_at",
                title: "Дата выдачи"
            }, {
                field: "owner_id",
                title: "Выдал"
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
    DatatableRemoteAjaxDemo.init()
});