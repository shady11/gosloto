var DatatableRemoteAjaxDemo = {
    init: function() {
        var t;
        t = $(".m_datatable").mDatatable({
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/getLotteryDraws',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        params: {
                            drawLottery: $('#drawLottery').val(),
                        }
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
            columns: [
                // {
                //     field: "id",
                //     title: "ID",
                //     width: 50
                // },
                {
                    field: "draw_number",
                    title: "Номер тиража"
                }, {
                    field: "tickets_count",
                    title: "Кол-во билетов"
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