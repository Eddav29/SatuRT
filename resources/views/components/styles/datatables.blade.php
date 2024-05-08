@push('styles')
    <style>
        @charset "UTF-8";

        :root {
            font-weight: 400;
        }

        table.dataTable td.dt-control {
            text-align: center;
            cursor: pointer;
        }

        table.dataTable td.dt-control:before {
            display: inline-block;
            box-sizing: border-box;
            content: "";
            border-top: 5px solid transparent;
            border-left: 10px solid rgba(0, 0, 0, 0.5);
            border-bottom: 5px solid transparent;
            border-right: 0px solid transparent;
        }

        table.dataTable tr.dt-hasChild td.dt-control:before {
            border-top: 10px solid rgba(0, 0, 0, 0.5);
            border-left: 5px solid transparent;
            border-bottom: 0px solid transparent;
            border-right: 5px solid transparent;
        }

        table.dataTable thead tr th span.dt-column-title {
            width: 100% !important;
            display: inline-block !important;
        }

        div.dt-scroll-body thead tr,
        div.dt-scroll-body tfoot tr {
            height: 0;
        }

        div.dt-scroll-body thead tr th,
        div.dt-scroll-body thead tr td,
        div.dt-scroll-body tfoot tr th,
        div.dt-scroll-body tfoot tr td {
            height: 0 !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            border-top-width: 0px !important;
            border-bottom-width: 0px !important;
        }

        div.dt-scroll-body thead tr th div.dt-scroll-sizing,
        div.dt-scroll-body thead tr td div.dt-scroll-sizing,
        div.dt-scroll-body tfoot tr th div.dt-scroll-sizing,
        div.dt-scroll-body tfoot tr td div.dt-scroll-sizing {
            height: 0 !important;
            overflow: hidden !important;
        }

        table.dataTable thead>tr>th:active,
        table.dataTable thead>tr>td:active {
            outline: none;
        }

        table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order:before,
        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before {
            position: absolute;
            display: block;
            bottom: 50%;
            content: "▲";
            content: "▲" /"";
        }

        table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order:after,
        table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {
            position: absolute;
            display: block;
            top: 50%;
            content: "▼";
            content: "▼" /"";
        }

        table.dataTable thead>tr>th.dt-orderable-asc,
        table.dataTable thead>tr>th.dt-orderable-desc,
        table.dataTable thead>tr>th.dt-ordering-asc,
        table.dataTable thead>tr>th.dt-ordering-desc,
        table.dataTable thead>tr>td.dt-orderable-asc,
        table.dataTable thead>tr>td.dt-orderable-desc,
        table.dataTable thead>tr>td.dt-ordering-asc,
        table.dataTable thead>tr>td.dt-ordering-desc {
            position: relative;
            padding-right: 30px;
        }

        table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order,
        table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order,
        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order,
        table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order,
        table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order,
        table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order,
        table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order,
        table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order {
            position: absolute;
            right: 12px;
            top: 0;
            bottom: 0;
            width: 12px;
        }

        table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order:before,
        table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order:after,
        table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order:before,
        table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order:after,
        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,
        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:after,
        table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:before,
        table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {
            left: 0;
            opacity: 0.125;
            line-height: 9px;
            font-size: 0.8em;
        }

        table.dataTable thead>tr>th.dt-orderable-asc,
        table.dataTable thead>tr>th.dt-orderable-desc,
        table.dataTable thead>tr>td.dt-orderable-asc,
        table.dataTable thead>tr>td.dt-orderable-desc {
            cursor: pointer;
        }

        table.dataTable thead>tr>th.dt-orderable-asc:hover,
        table.dataTable thead>tr>th.dt-orderable-desc:hover,
        table.dataTable thead>tr>td.dt-orderable-asc:hover,
        table.dataTable thead>tr>td.dt-orderable-desc:hover {
            outline: 2px solid #E8F1FF;
            outline-offset: -2px;
        }

        table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,
        table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,
        table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before,
        table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {
            opacity: 0.6;
        }

        table.dataTable thead>tr>th.sorting_desc_disabled span.dt-column-order:after,
        table.dataTable thead>tr>th.sorting_asc_disabled span.dt-column-order:before,
        table.dataTable thead>tr>td.sorting_desc_disabled span.dt-column-order:after,
        table.dataTable thead>tr>td.sorting_asc_disabled span.dt-column-order:before {
            display: none;
        }

        table.dataTable thead>tr>th:active,
        table.dataTable thead>tr>td:active {
            outline: none;
        }

        div.dt-scroll-body>table.dataTable>thead>tr>th,
        div.dt-scroll-body>table.dataTable>thead>tr>td {
            overflow: hidden;
        }

        div.dt-processing {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            margin-left: -100px;
            margin-top: -22px;
            text-align: center;
            padding: 2px;
            z-index: 10;
        }

        div.dt-processing>div:last-child {
            position: relative;
            width: 80px;
            height: 15px;
            margin: 1em auto;
        }

        div.dt-processing>div:last-child>div {
            position: absolute;
            top: 0;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: rgb(13, 110, 253);
            background: rgb(var(--dt-row-selected));
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        div.dt-processing>div:last-child>div:nth-child(1) {
            left: 8px;
            animation: datatables-loader-1 0.6s infinite;
        }

        div.dt-processing>div:last-child>div:nth-child(2) {
            left: 8px;
            animation: datatables-loader-2 0.6s infinite;
        }

        div.dt-processing>div:last-child>div:nth-child(3) {
            left: 32px;
            animation: datatables-loader-2 0.6s infinite;
        }

        div.dt-processing>div:last-child>div:nth-child(4) {
            left: 56px;
            animation: datatables-loader-3 0.6s infinite;
        }

        @keyframes datatables-loader-1 {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes datatables-loader-3 {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        @keyframes datatables-loader-2 {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(24px, 0);
            }
        }

        table.dataTable.nowrap th,
        table.dataTable.nowrap td {
            white-space: nowrap;
        }

        table.dataTable th,
        table.dataTable td {
            box-sizing: border-box;
        }

        table.dataTable td {
            box-sizing: border-box;
            border-bottom: 1px solid #0b121511;
        }

        /* table.dataTable th.dt-left,
                    table.dataTable td.dt-left {
                        text-align: left;
                    }

                    table.dataTable th.dt-center,
                    table.dataTable td.dt-center {
                        text-align: center;
                    }

                    table.dataTable th.dt-right,
                    table.dataTable td.dt-right {
                        text-align: right;
                    }

                    table.dataTable th.dt-justify,
                    table.dataTable td.dt-justify {
                        text-align: justify;
                    } */

        table.dataTable th.dt-nowrap,
        table.dataTable td.dt-nowrap {
            white-space: nowrap;
        }

        table.dataTable th.dt-empty,
        table.dataTable td.dt-empty {
            text-align: center;
            vertical-align: top;
        }

        table.dataTable th.dt-type-numeric,
        table.dataTable th.dt-type-date,
        table.dataTable td.dt-type-numeric,
        table.dataTable td.dt-type-date {
            text-align: left;
            padding: 1.75rem
        }

        table.dataTable thead th,
        table.dataTable thead td,
        table.dataTable tfoot th,
        table.dataTable tfoot td {
            text-align: left;
        }

        table.dataTable thead th.dt-head-left,
        table.dataTable thead td.dt-head-left,
        table.dataTable tfoot th.dt-head-left,
        table.dataTable tfoot td.dt-head-left {
            text-align: left;
        }

        table.dataTable thead th.dt-head-center,
        table.dataTable thead td.dt-head-center,
        table.dataTable tfoot th.dt-head-center,
        table.dataTable tfoot td.dt-head-center {
            text-align: center;
        }

        table.dataTable thead th.dt-head-right,
        table.dataTable thead td.dt-head-right,
        table.dataTable tfoot th.dt-head-right,
        table.dataTable tfoot td.dt-head-right {
            text-align: right;
        }

        table.dataTable thead th.dt-head-justify,
        table.dataTable thead td.dt-head-justify,
        table.dataTable tfoot th.dt-head-justify,
        table.dataTable tfoot td.dt-head-justify {
            text-align: justify;
        }

        table.dataTable thead th.dt-head-nowrap,
        table.dataTable thead td.dt-head-nowrap,
        table.dataTable tfoot th.dt-head-nowrap,
        table.dataTable tfoot td.dt-head-nowrap {
            white-space: nowrap;
        }

        table.dataTable tbody th.dt-body-left,
        table.dataTable tbody td.dt-body-left {
            text-align: left;
        }

        table.dataTable tbody th.dt-body-center,
        table.dataTable tbody td.dt-body-center {
            text-align: center;
        }

        table.dataTable tbody th.dt-body-right,
        table.dataTable tbody td.dt-body-right {
            text-align: right;
        }

        table.dataTable tbody th.dt-body-justify,
        table.dataTable tbody td.dt-body-justify {
            text-align: justify;
        }

        table.dataTable tbody th.dt-body-nowrap,
        table.dataTable tbody td.dt-body-nowrap {
            white-space: nowrap;
        }

        /* Table styles */
        table.dataTable {
            width: 100%;
            margin: 0 auto;
            border-spacing: 0;
        }

        /* Header and footer styles*/
        /* Body styles */

        table.dataTables.display thead tr th:first-child {
            border-top-left-radius: 0.75rem !important;
        }

        table.dataTables.display thead tr th:last-child {
            border-top-right-radius: 0.75rem !important;
        }

        table.dataTable thead th,
        table.dataTable tfoot th {
            font-weight: 600;
        }

        table.dataTable>thead>tr>th,
        table.dataTable>thead>tr>td {
            padding: 1.5rem;
        }

        table.dataTable>thead>tr>th:active,
        table.dataTable>thead>tr>td:active {
            outline: none;
        }

        table.dataTable>tfoot>tr>th,
        table.dataTable>tfoot>tr>td {
            padding: 10px 10px 6px 10px;
        }

        table.dataTable>tbody>tr {
            background-color: transparent;
        }

        table.dataTable>tbody>tr:first-child>* {
            border-top: none;
        }

        table.dataTable>tbody>tr:last-child>* {
            border-bottom: none;
        }

        table.dataTable>tbody>tr.selected>* {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.9);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.9);
            color: rgb(255, 255, 255);
            color: rgb(var(--dt-row-selected-text));
        }

        table.dataTable>tbody>tr.selected a {
            color: rgb(9, 10, 11);
            color: rgb(var(--dt-row-selected-link));
        }

        table.dataTable>tbody>tr>th,
        table.dataTable>tbody>tr>td {
            padding: 1.5rem
        }

        table.dataTable.row-border>tbody>tr>*,
        table.dataTable.display>tbody>tr>* {
            border-top: 1px solid rgba(0, 0, 0, 0.15);
        }

        table.dataTable.row-border>tbody>tr:first-child>*,
        table.dataTable.display>tbody>tr:first-child>* {
            border-top: none;
        }

        table.dataTable.row-border>tbody>tr.selected+tr.selected>td,
        table.dataTable.display>tbody>tr.selected+tr.selected>td {
            border-top-color: rgba(13, 110, 253, 0.65);
            border-top-color: rgba(var(--dt-row-selected), 0.65);
        }

        table.dataTable.cell-border>tbody>tr>* {
            border-top: 1px solid rgba(0, 0, 0, 0.15);
            border-right: 1px solid rgba(0, 0, 0, 0.15);
        }

        table.dataTable.cell-border>tbody>tr>*:first-child {
            border-left: 1px solid rgba(0, 0, 0, 0.15);
        }

        table.dataTable.cell-border>tbody>tr:first-child>* {
            border-top: 1px solid rgba(0, 0, 0, 0.3);
        }

        table.dataTable.stripe>tbody>tr:nth-child(odd)>*,
        table.dataTable.display>tbody>tr:nth-child(odd)>* {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.023);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-stripe), 0.023);
        }

        table.dataTable.stripe>tbody>tr:nth-child(odd).selected>*,
        table.dataTable.display>tbody>tr:nth-child(odd).selected>* {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.923);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.923);
        }

        table.dataTable.hover>tbody>tr:hover>*,
        table.dataTable.display>tbody>tr:hover>* {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.035);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.035);
        }

        table.dataTable.hover>tbody>tr.selected:hover>*,
        table.dataTable.display>tbody>tr.selected:hover>* {
            box-shadow: inset 0 0 0 9999px #0d6efd !important;
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 1) !important;
        }

        table.dataTable.order-column>tbody tr>.sorting_1,
        table.dataTable.order-column>tbody tr>.sorting_2,
        table.dataTable.order-column>tbody tr>.sorting_3,
        table.dataTable.display>tbody tr>.sorting_1,
        table.dataTable.display>tbody tr>.sorting_2,
        table.dataTable.display>tbody tr>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.019);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.019);
        }

        table.dataTable.order-column>tbody tr.selected>.sorting_1,
        table.dataTable.order-column>tbody tr.selected>.sorting_2,
        table.dataTable.order-column>tbody tr.selected>.sorting_3,
        table.dataTable.display>tbody tr.selected>.sorting_1,
        table.dataTable.display>tbody tr.selected>.sorting_2,
        table.dataTable.display>tbody tr.selected>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.919);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.919);
        }

        table.dataTable.display>tbody>tr:nth-child(odd)>.sorting_1,
        table.dataTable.order-column.stripe>tbody>tr:nth-child(odd)>.sorting_1 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.054);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.054);
        }

        table.dataTable.display>tbody>tr:nth-child(odd)>.sorting_2,
        table.dataTable.order-column.stripe>tbody>tr:nth-child(odd)>.sorting_2 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.047);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.047);
        }

        table.dataTable.display>tbody>tr:nth-child(odd)>.sorting_3,
        table.dataTable.order-column.stripe>tbody>tr:nth-child(odd)>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.039);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.039);
        }

        table.dataTable.display>tbody>tr:nth-child(odd).selected>.sorting_1,
        table.dataTable.order-column.stripe>tbody>tr:nth-child(odd).selected>.sorting_1 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.954);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.954);
        }

        table.dataTable.display>tbody>tr:nth-child(odd).selected>.sorting_2,
        table.dataTable.order-column.stripe>tbody>tr:nth-child(odd).selected>.sorting_2 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.947);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.947);
        }

        table.dataTable.display>tbody>tr:nth-child(odd).selected>.sorting_3,
        table.dataTable.order-column.stripe>tbody>tr:nth-child(odd).selected>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.939);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.939);
        }

        table.dataTable.display>tbody>tr.even>.sorting_1,
        table.dataTable.order-column.stripe>tbody>tr.even>.sorting_1 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.019);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.019);
        }

        table.dataTable.display>tbody>tr.even>.sorting_2,
        table.dataTable.order-column.stripe>tbody>tr.even>.sorting_2 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.011);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.011);
        }

        table.dataTable.display>tbody>tr.even>.sorting_3,
        table.dataTable.order-column.stripe>tbody>tr.even>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.003);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.003);
        }

        table.dataTable.display>tbody>tr.even.selected>.sorting_1,
        table.dataTable.order-column.stripe>tbody>tr.even.selected>.sorting_1 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.919);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.919);
        }

        table.dataTable.display>tbody>tr.even.selected>.sorting_2,
        table.dataTable.order-column.stripe>tbody>tr.even.selected>.sorting_2 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.911);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.911);
        }

        table.dataTable.display>tbody>tr.even.selected>.sorting_3,
        table.dataTable.order-column.stripe>tbody>tr.even.selected>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.903);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.903);
        }

        table.dataTable.display tbody tr:hover>.sorting_1,
        table.dataTable.order-column.hover tbody tr:hover>.sorting_1 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.082);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.082);
        }

        table.dataTable.display tbody tr:hover>.sorting_2,
        table.dataTable.order-column.hover tbody tr:hover>.sorting_2 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.074);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.074);
        }

        table.dataTable.display tbody tr:hover>.sorting_3,
        table.dataTable.order-column.hover tbody tr:hover>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.062);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.062);
        }

        table.dataTable.display tbody tr:hover.selected>.sorting_1,
        table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_1 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.982);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.982);
        }

        table.dataTable.display tbody tr:hover.selected>.sorting_2,
        table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_2 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.974);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.974);
        }

        table.dataTable.display tbody tr:hover.selected>.sorting_3,
        table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_3 {
            box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.962);
            box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.962);
        }

        table.dataTable.compact thead th,
        table.dataTable.compact thead td,
        table.dataTable.compact tfoot th,
        table.dataTable.compact tfoot td,
        table.dataTable.compact tbody th,
        table.dataTable.compact tbody td {
            padding: 4px;
        }

        /* Control feature layout */
        div.dt-container {
            position: relative;
            width: 100%;
        }

        div.dt-container div.dt-layout-row:first-child {
            display: grid;
            width: 100%;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            grid-gap: 1em;
            padding: 1rem 0;
        }

        div.dt-container div.dt-layout-row:last-child {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 1rem 0;
        }

        div.dt-container div.dt-layout-row:first-child div.dt-layout-cell.dt-start:first-child {
            grid-column: span 4 / span 4;
            align-self: center
        }

        div.dt-container div.dt-layout-row:last-child div.dt-layout-cell.dt-end {
            display: flex;
            justify-content: end;
            align-items: center;
        }

        /* div.dt-layout-cell.dt-start div.dt-info {
                        text-align: left;
                    } */

        /* div.dt-layout-cell table tbody tr td div {
                        text-align: left !important;
                    } */

        div.dt-container div.dt-layout-cell.dt-end {
            display: flex;
            justify-content: flex-start;
            width: 100%;
        }

        div.dt-container div.dt-layout-cell.dt-end {
            text-align: right;
        }

        div.dt-container div.dt-layout-cell:empty {
            display: none;
        }

        div.dt-container .dt-search input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            background-color: transparent;
            color: inherit;
            margin-left: 3px;
        }

        div.dt-container .dt-input {
            border: 1px solid #aaa;
            border-radius: 3px;
            padding: 5px;
            background-color: transparent;
            color: inherit;
        }

        div.dt-container select.dt-input {
            padding: 4px;
        }

        div.dt-container .dt-paging {
            /* background-color: #ffffff !important; */
            padding: 0.75rem;
            border-radius: 0.75rem
        }

        div.dt-container .dt-paging .dt-paging-button {
            box-sizing: border-box;
            display: inline-block;
            width: 2.5em;
            height: 2.5em;
            margin-left: 0.5em;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            color: inherit !important;
            border: 1px solid rgb(209 213 219);
            border-radius: 0.5em;
        }

        div.dt-container .dt-paging .dt-paging-button.current,
        div.dt-container .dt-paging .dt-paging-button.current:hover {
            color: #0B1215;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.5em;
            background-color: #E8F1FF;
            background: -webkit-gradient(linear,
                    left top,
                    left bottom,
                    color-stop(0%, rgba(230, 230, 230, 0.05)),
                    color-stop(100%, #E8F1FF));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Chrome10+,Safari5.1+ */
            background: -moz-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* FF3.6+ */
            background: -ms-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* IE10+ */
            background: -o-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Opera 11.10+ */
            background: linear-gradient(to bottom,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* W3C */
        }

        div.dt-container .dt-paging .dt-paging-button.disabled,
        div.dt-container .dt-paging .dt-paging-button.disabled:hover,
        div.dt-container .dt-paging .dt-paging-button.disabled:active {
            cursor: default;
            color: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid transparent;
            background: transparent;
            box-shadow: none;
        }

        div.dt-container .dt-paging .dt-paging-button:hover {
            color: #0B1215;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.5em;
            background-color: #E8F1FF;
            background: -webkit-gradient(linear,
                    left top,
                    left bottom,
                    color-stop(0%, rgba(230, 230, 230, 0.05)),
                    color-stop(100%, #E8F1FF));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Chrome10+,Safari5.1+ */
            background: -moz-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* FF3.6+ */
            background: -ms-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* IE10+ */
            background: -o-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Opera 11.10+ */
            background: linear-gradient(to bottom,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* W3C */
        }

        div.dt-container .dt-paging .dt-paging-button:active {
            color: #0B1215;
            border: 1px solid rgba(0, 0, 0, 0.3);
            background-color: #E8F1FF;
            background: -webkit-gradient(linear,
                    left top,
                    left bottom,
                    color-stop(0%, rgba(230, 230, 230, 0.05)),
                    color-stop(100%, #E8F1FF));
            /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Chrome10+,Safari5.1+ */
            background: -moz-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* FF3.6+ */
            background: -ms-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* IE10+ */
            background: -o-linear-gradient(top,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* Opera 11.10+ */
            background: linear-gradient(to bottom,
                    rgba(230, 230, 230, 0.05) 0%,
                    #E8F1FF 100%);
            /* W3C */
        }

        div.dt-container .dt-paging .ellipsis {
            padding: 0 1em;
            display: flex;
            justify-content: center;
            align-items: center
        }

        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing,
        div.dt-container .dt-paging {
            color: #0B1215;
        }

        div.dt-container .dt-info {
            padding: 1rem 0;
        }

        div.dt-container .dataTables_scroll {
            clear: both;
        }

        div.dt-container .dataTables_scroll div.dt-scroll-body {
            -webkit-overflow-scrolling: touch;
        }

        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>th,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>td,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>th,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>td {
            vertical-align: middle;
        }

        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>th>div.dataTables_sizing,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>td>div.dataTables_sizing,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>th>div.dataTables_sizing,
        div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>td>div.dataTables_sizing {
            height: 0;
            overflow: hidden;
            margin: 0 !important;
            padding: 0 !important;
        }

        div.dt-container.dt-empty-footer tbody>tr:last-child>* {
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        }

        div.dt-container.dt-empty-footer .dt-scroll-body {
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        }

        div.dt-container.dt-empty-footer .dt-scroll-body tbody>tr:last-child>* {
            border-bottom: none;
        }

        div.dt-container div.dt-layout-cell.dt-end {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        div.dt-container.dt-empty-footer {
            width: auto;
        }

        div.dt-layout-row.dt-layout-table {
            overflow: auto;
        }

        @media screen and (max-width: 1280px) {
            div.dt-container {
                width: fit-content;
            }

            div.dt-container div.dt-layout-row:first-child {
                display: grid;
                width: 100%;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                grid-gap: 1em;
                padding: 1rem 0;
            }

            div.dt-container div.dt-layout-row:last-child {
                display: flex;
                flex-direction: column;
            }

            div.dt-container div.dt-layout-row:first-child div.dt-layout-cell.dt-start:first-child {
                grid-column: span 2 / span 2;
                align-self: center
            }

            div.dt-container div.dt-layout-row:last-child div.dt-layout-cell.dt-end {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            div.dt-layout-cell.dt-start div.dt-info {
                text-align: center;
            }
        }


        @media screen and (max-width: 768px) {}

        @media screen and (max-width: 640px) {

            div.dt-container {
                width: 100%;
            }

            div.dt-container div.dt-layout-row:first-child {
                display: flex;
                flex-direction: column
            }

            div.dt-container div.dt-layout-row:last-child {
                display: flex;
                flex-direction: column;
                width: max-content
            }

            div.dt-container div.dt-layout-row div.dt-layout-cell {
                width: 100% !important;
            }

            div.dt-container div.dt-layout-row div.dt-layout-cell div.dt-start {
                width: 100% !important;
            }

            div.dt-container div.dt-layout-row div.dt-layout-cell.dt-end {
                width: 100% !important;
            }

            div.dt-layout-cell.dt-start div.dt-info {
                text-align: left;
            }

            .dt-container .dt-length,
            .dt-container .dt-search {
                float: none;
                text-align: center;
            }

            .dt-container .dt-search {
                margin-top: 0.5em;
            }
        }

        */ *[dir="rtl"] table.dataTable thead th,
        *[dir="rtl"] table.dataTable thead td,
        *[dir="rtl"] table.dataTable tfoot th,
        *[dir="rtl"] table.dataTable tfoot td {
            text-align: left;
        }

        *[dir="rtl"] table.dataTable th.dt-type-numeric,
        *[dir="rtl"] table.dataTable th.dt-type-date,
        *[dir="rtl"] table.dataTable td.dt-type-numeric,
        *[dir="rtl"] table.dataTable td.dt-type-date {
            text-align: left;
        }

        *[dir="rtl"] div.dt-container div.dt-layout-cell.dt-start {
            text-align: left;
        }

        *[dir="rtl"] div.dt-container div.dt-layout-cell.dt-end {
            text-align: left;
        }

        *[dir="rtl"] div.dt-container div.dt-search input {
            margin: 0 3px 0 0;
        }
    </style>
@endpush
