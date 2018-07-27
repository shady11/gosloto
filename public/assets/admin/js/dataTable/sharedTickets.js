var DatatableRemoteAjaxDemo = {
    init: function() {
        var t;
        t = $(".m_datatable").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/getSharedTickets',
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
                field: "id",
                title: "ID",
                width: 50
            }, {
                field: "count",
                title: "Количество"
            }, {
                field: "user",
                title: "Реализатор"
            }, {
                field: "shared_at",
                title: "Дата оформления"
            }, {
                field: "shared_user",
                title: "Оформил"
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