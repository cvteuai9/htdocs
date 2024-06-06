<style>
    /* ---------------新增樣式-------------- */
    /* 按鈕 */
    .btn-custom {
        background-color: #198754;
        color: white;
    }

    .btn-custom:hover {
        background-color: #198754;
    }

    .btn-custom-d {
        background-color: red;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 14px;
    }

    /* 狀態 */
    .status-custom {
        color: whitesmoke;
        border: none;
        padding: 10px 10px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin: 4px 2px;
        border-radius: 14px;
        font-weight: bold;
    }

    #status-available {
        background-color: #4CAF50;
    }

    #status-not-open {
        background-color: #bbb;
    }

    #status-disabled {
        background-color: #800000;
    }

    /* sort排序 */
    .sort-icon {
        color: #198754;
        margin-left: 5px;
    }

    /* 查看詳細資訊 */
    .eye-icon {
        color: #198754;
    }

    /* 頁籤 */
    .pagination .active .page-link {
        background-color: #198754;
        color: white;
        border-color: #198754;
    }

    /* .pagination {
        --bs-pagination-font-size:20px
    } */


    .pagination .page-link {
        color: #198754;
        font-size: 20px;
        /* --bs-pagination-font-size:30px */

    }

    /* 表格顏色 */

    .table-striped>tbody>tr:nth-child(2n)>td,
    .table-striped>tbody>tr:nth-child(2n)>th {
        background-color: #f5f8ff;
    }


    .table-striped>tbody>tr:nth-of-type(odd)>* {
        --bs-table-bg-type: white;
    }

    .table-header>tr>th {
        background-color: #f5f8ff;
        padding: 15px;
    }

    .table-coupon>tbody>tr:nth-child(2n+1)>td,
    .table-coupon>tbody>tr:nth-child(2n+1)>th {
        background-color: #f5f8ff;
    }
    /* .table-coupon>tbody>tr>th {
        background-color: #f5f8ff;
    } */

    .table>:not(caption)>*>* {
        padding: 15px;
    }

    .table-coupon {
        td {

            border-width: 1.5px;
        }

        tr {

            border-color: white;
            border-style: solid;
            border-width: 1px;
        }
    }

    /* 建立優惠券錯誤訊息 */
    #error-message {
        color: red;
    }

    /* 編輯優惠券類別 */
    /* 更改选中状态的单选按钮颜色 */
    .form-check-input:checked {
        background-color: #876d5a;
        border-color: #876d5a;
    }

    /* 更改选中状态的单选按钮旁边的标签颜色 */
    .form-check-input:checked+.form-check-label {
        color: #876d5a;
    }
</style>