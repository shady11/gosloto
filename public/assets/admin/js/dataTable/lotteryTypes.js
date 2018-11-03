var DatatableRemoteAjaxDemo = {
    init: function() {
        var t;
        t = $(".m_datatable").mDatatable({
            data: {
                type: "remote",
                source: {
                    read: {
                        url: '/getLotteryTypes',
                        headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
                field: "name",
                title: "Название",
                attr: {
                    nowrap: "nowrap"
                }
            }, {
                field: "has_edition",
                title: "Тиражность",
                template: function(t) {
                    var e = {
                        0: {
                            title: "без тиража",
                            class: "metal"
                        },
                        1: {
                            title: "с тиражом",
                            class: "success"
                        }
                    };
                    return '<span class="m-badge m-badge--'+e[t.has_edition].class+' m-badge--dot"></span><span class="m--font-bold m--font-'+e[t.has_edition].class+'">'+e[t.has_edition].title+'</span>'
                }
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