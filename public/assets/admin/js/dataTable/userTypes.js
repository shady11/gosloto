var DatatableRemoteAjaxDemo = {
    init: function() {
        var t;
        t = $(".m_datatable").mDatatable({
            data: {
                type: "remote",
                source: {
                    read: {
                        url: '/getUserTypes',
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
                field: "name",
                title: "Название",
                attr: {
                    nowrap: "nowrap"
                }
            }, {
                field: "actions",
                title: "Actions",
                sortable: !1,
                textAlign: "right",
                overflow: "visible"
            }],
            translate: {
                records: {
                    processing: 'Подождите...',
                    noRecords: 'Нет данных'
                },
                toolbar: {
                    pagination: {
                        items: {
                            default: {
                                first: 'Начало',
                                prev: 'Пред.',
                                next: 'След.',
                                last: 'Конец',
                                more: 'Больше страниц',
                                input: 'Номер страницы',
                                select: 'Выберите количество данных'
                            },
                            info: '{{start}} - {{end}} / {{total}}'
                        }
                    }
                }
            }
        })
    }
};
jQuery(document).ready(function() {
    DatatableRemoteAjaxDemo.init()
});