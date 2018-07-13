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
            class: "",
            scroll: !0,
            height: 'auto',
            footer: !1
        },
        sortable: !0,
        pagination: !0,
        columns: [
        {
            field: "orderNumber",
            title: "#",
            sortable: !1,
            width: 40,
            textAlign: "center",
            selector: {
                class: "m-checkbox--solid m-checkbox--brand"
            }
        }, {
            field: "id",
            title: "ID",
            width: 40,
            template: "{{id}}"
        }, {
            field: "name",
            title: "ФИО",
            width: 150,
            template: function(t) {
                return t.name + " " + t.lastname
            }
        }, {
            field: "email",
            title: "Email"
        }, {
            field: "login",
            title: "Логин",
            width: 100
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
        }, 
        // {
        //     field: "type",
        //     title: "Тип",
        //     template: function(t) {
        //         var e = {
        //             1: {
        //                 title: "Online",
        //                 state: "danger"
        //             },
        //             2: {
        //                 title: "Retail",
        //                 state: "primary"
        //             },
        //             3: {
        //                 title: "Direct",
        //                 state: "accent"
        //             }
        //         };
        //         return '<span class="m-badge m-badge--' + e[t.Type].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + e[t.Type].state + '">' + e[t.Type].title + "</span>"
        //     }
        // }, 
        // {
        //     field: null,
        //     width: 110,
        //     title: "Actions",
        //     sortable: !1,
        //     overflow: "visible",
        //     template: function(t, e, a) {
        //         return '\t\t\t\t\t\t<div class="dropdown ' + (a.getPageSize() - e <= 4 ? "dropup" : "") + '">\t\t\t\t\t\t\t<a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">                                <i class="la la-ellipsis-h"></i>                            </a>\t\t\t\t\t\t  \t<div class="dropdown-menu dropdown-menu-right">\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\t\t\t\t\t\t    \t<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\t\t\t\t\t\t  \t</div>\t\t\t\t\t\t</div>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t'
        //     }
        // }
        ]
    };
    return {
        init: function() {
            ! function() {
                t.extensions = {
                    checkbox: {}
                }, t.search = {
                    input: $("#generalSearch1")
                };
                var e = $("#server_record_selection").mDatatable(t);
                $("#m_form_status1").on("change", function() {
                    e.search($(this).val().toLowerCase(), "active")
                }), $("#m_form_type1").on("change", function() {
                    e.search($(this).val().toLowerCase(), "type")
                }), $("#m_form_status1,#m_form_type1").selectpicker(), e.on("m-datatable--on-click-checkbox m-datatable--on-layout-updated", function(t) {
                    var a = e.checkbox().getSelectedId().length;
                    $("#m_datatable_selected_number1").html(a), a > 0 ? $("#m_datatable_group_action_form1").collapse("show") : $("#m_datatable_group_action_form1").collapse("hide")
                }), $("#m_modal_fetch_id_server").on("show.bs.modal", function(t) {
                    for (var a = e.checkbox().getSelectedId(), n = document.createDocumentFragment(), l = 0; l < a.length; l++) {
                        var i = document.createElement("li");
                        i.setAttribute("data-id", a[l]), i.innerHTML = "Selected record ID: " + a[l], n.appendChild(i)
                    }
                    $(t.target).find(".m_datatable_selected_ids").append(n)
                }).on("hide.bs.modal", function(t) {
                    $(t.target).find(".m_datatable_selected_ids").empty()
                })
            }()
        }
    }
}();
jQuery(document).ready(function() {
    DatatableRecordSelectionDemo.init()
});